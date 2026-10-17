<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class CancelledInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['order.customer', 'order.refundTransactions'])
            ->whereHas('order', fn($q) => $q->where('status', 'cancelled'))
            ->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('order', fn($o) => $o
                        ->where('order_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_email', 'like', "%{$search}%"));
            });
        }

        if ($from = $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $invoices = $query->paginate(20)->withQueryString();

        $cancelledWithInvoice = fn() => Order::where('status', 'cancelled')->whereHas('invoice');

        $stats = [
            'total'          => $cancelledWithInvoice()->count(),
            'total_value'    => $cancelledWithInvoice()->sum('grand_total'),
            'refund_pending' => $cancelledWithInvoice()
                ->where('payment_status', 'paid')
                ->whereDoesntHave('refundTransactions', fn($q) => $q->where('status', 'completed'))
                ->count(),
        ];

        return view('admin.cancelled-invoices.index', compact('invoices', 'stats'));
    }
}