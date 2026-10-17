<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Notification;
use App\Models\Order;
use App\Models\RefundTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CancelledRefundController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'pending');

        $query = Order::where('status', 'cancelled')
            ->with(['customer', 'refundTransactions'])
            ->latest('updated_at');

        if ($tab === 'refunded') {
            $query->whereHas('refundTransactions', fn($q) => $q->where('status', 'completed'));
        } else {
            $query->where('payment_status', 'paid')
                ->whereDoesntHave('refundTransactions', fn($q) => $q->where('status', 'completed'));
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        $pendingBase = fn() => Order::where('status', 'cancelled')
            ->where('payment_status', 'paid')
            ->whereDoesntHave('refundTransactions', fn($q) => $q->where('status', 'completed'));

        $stats = [
            'pending_count'  => $pendingBase()->count(),
            'pending_amount' => $pendingBase()->sum('grand_total'),
            'refunded_count' => Order::where('status', 'cancelled')
                ->whereHas('refundTransactions', fn($q) => $q->where('status', 'completed'))
                ->count(),
        ];

        return view('admin.cancelled-refunds.index', compact('orders', 'stats', 'tab'));
    }

    public function refund(Request $request, Order $order)
    {
        abort_if($order->status !== 'cancelled', 422, 'Only cancelled orders can be refunded here.');
        abort_if($order->payment_status !== 'paid', 422, 'This order has no paid amount to refund.');

        $request->validate([
            'amount'         => 'required|numeric|min:1|max:' . $order->grand_total,
            'refund_method'  => 'required|in:neft_rtgs_imps,upi',
            'utr_id'         => 'required|string|max:100',
            'remarks'        => 'nullable|string|max:500',
            'payment_proof'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'bank_name'      => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:100',
            'account_name'   => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:100',
            'account_number' => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:30',
            'ifsc_code'      => 'required_if:refund_method,neft_rtgs_imps|nullable|string|max:20',
            'bank_branch'    => 'nullable|string|max:100',
            'account_type'   => 'nullable|in:savings,current,salary',
            'upi_id'         => 'required_if:refund_method,upi|nullable|string|max:100',
        ]);

        $proofPath = $request->hasFile('payment_proof')
            ? $request->file('payment_proof')->store('refunds/cancelled-proofs', 'public')
            : null;

        DB::transaction(function () use ($request, $order, $proofPath) {
            // Lock the row so a double-click can't create two refunds
            $order = Order::lockForUpdate()->findOrFail($order->id);

            abort_if(
                $order->refundTransactions()->where('status', 'completed')->exists(),
                422,
                'This order has already been refunded.'
            );

            $isUpi = $request->refund_method === 'upi';

            $refund = RefundTransaction::create([
                'order_id'        => $order->id,
                'customer_id'     => $order->customer_id,
                'order_return_id' => null,
                'ndr_id'          => null,
                'status'          => 'completed',
                'refund_method'   => $request->refund_method,
                'utr_id'          => $request->utr_id,
                'amount'          => $request->amount,
                'remarks'         => $request->remarks,
                'payment_proof'   => $proofPath,

                'upi_id'          => $isUpi ? $request->upi_id : null,
                'bank_name'       => $isUpi ? null : $request->bank_name,
                'account_name'    => $isUpi ? null : $request->account_name,
                'account_number'  => $isUpi ? null : $request->account_number,
                'ifsc_code'       => $isUpi ? null : $request->ifsc_code,
                'bank_branch'     => $isUpi ? null : $request->bank_branch,
                'account_type'    => $isUpi ? null : $request->account_type,
            ]);

            $order->update(['payment_status' => 'refunded']);

            $order->statusHistory()->create([
                'status'          => 'cancelled',
                'previous_status' => 'cancelled',
                'remarks'         => 'Refund of ₹' . number_format($refund->amount, 2) . ' processed. UTR: ' . $refund->utr_id,
                'triggered_by'    => 'Admin (' . auth()->user()->name . ')',
            ]);

            if ($order->customer_id) {
                Notification::create([
                    'customer_id' => $order->customer_id,
                    'title'       => 'Refund Completed',
                    'message'     => 'Your refund of ₹' . number_format($refund->amount, 2)
                        . ' for cancelled order ' . $order->order_number . ' has been processed. UTR: ' . $refund->utr_id,
                    'icon'        => 'fa-solid fa-money-bill-transfer',
                    'color'       => 'success',
                    'url'         => route('user.order-detail', $order->id),
                ]);
            }

            AdminNotification::notify([
                'type'      => 'order',
                'title'     => 'Refund processed',
                'message'   => 'Refund of ₹' . number_format($refund->amount, 2) . ' recorded for cancelled order #' . $order->order_number . '.',
                'reference' => '#' . $order->order_number,
                'icon'      => 'fa-undo',
                'url'       => route('admin.orders.show', $order->id),
                'link_text' => 'View Order',
            ]);
        });

        return redirect()
            ->route('admin.cancelled-refunds.index')
            ->with('success', 'Refund recorded for order #' . $order->order_number . ' (UTR: ' . $request->utr_id . ').');
    }
}