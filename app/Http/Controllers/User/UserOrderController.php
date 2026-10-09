<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderTracker;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    // Filter pill => [label, DB statuses it covers]
    public const GROUPS = [
        'processing' => ['Processing', ['new', 'pending', 'processing']],
        'shipped' => ['Shipped', ['shipped', 'ndr']],
        'delivered' => ['Delivered', ['delivered']],
        'cancelled' => ['Cancelled', ['cancelled']],
        'returned' => ['Returned', ['rto']],
    ];

    // DB status => [customer-facing label, badge classes]
    public static function statusMeta(string $status): array
    {
        return match (strtolower($status)) {
            'delivered' => ['Delivered', 'bg-soft-mint text-emerald-800 border-mint'],
            'shipped' => ['Shipped', 'bg-soft-blue text-brand-blue border-sky-blue'],
            'ndr' => ['Delivery Attempt Failed', 'bg-soft-orange text-brand-orange border-orange-200'],
            'rto' => ['Returned to Seller', 'bg-soft-purple text-purple-700 border-purple-200'],
            'cancelled' => ['Cancelled', 'bg-soft-coral text-red-800 border-red-300'],
            'processing' => ['Processing', 'bg-soft-yellow text-amber-800 border-amber-300'],
            default => ['Order Placed', 'bg-soft-yellow text-amber-800 border-amber-300'], // new / pending
        };
    }

    public function index(Request $request)
    {
        $customer = auth('customer')->user();

        $status = strtolower((string) $request->query('status', 'all'));
        if (!array_key_exists($status, self::GROUPS)) {
            $status = 'all';
        }

        $orders = Order::where('customer_id', $customer->id)
            ->when($status !== 'all', fn($q) => $q->whereIn('status', self::GROUPS[$status][1]))
            ->with(['items.product.images', 'items.imageVariant', 'items.addons'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.orders', [
            'customer' => $customer,
            'orders' => $orders,
            'status' => $status,
            'filters' => collect(self::GROUPS)->map(fn($g) => $g[0])->all(),
        ]);
    }

    public function show(Request $request)
    {
        $customer = auth('customer')->user();
        $number = (string) $request->query('orderId');

        if ($number === '') {
            return redirect()->route('user.orders');
        }

        // Scoped to the logged-in customer, so nobody can open another person's order
        $order = Order::where('customer_id', $customer->id)
            ->where('order_number', $number)
            ->with([
                'items.product',
                'items.imageVariant',
                'items.addons',
                'state',
                'city',
                'courier',
                'statusHistory',
            ])
            ->firstOrFail();

        $timeline = OrderTracker::timeline($order);

        [$statusLabel, $statusClass] = self::statusMeta($order->status);

        $reviewedItemIds = \App\Models\ProductReview::where('customer_id', $customer->id)
            ->where('order_id', $order->id)
            ->pluck('order_item_id')
            ->all();

        return view('user.order-detail', [
            'customer' => $customer,
            'order' => $order,
            'timeline' => $timeline,
            'statusLabel' => $statusLabel,
            'statusClass' => $statusClass,
            'reviewedItemIds' => $reviewedItemIds,
        ]);
    }

    public function track(Request $request)
    {
        $customer = auth('customer')->user();
        $number = trim((string) $request->query('orderId'));

        $order = null;
        $notFound = false;

        if ($number !== '') {
            // Scoped to the logged-in customer
            $order = Order::where('customer_id', $customer->id)
                ->where('order_number', $number)
                ->with(['courier', 'statusHistory'])
                ->first();

            $notFound = $order === null;
        }

        $timeline = $order ? OrderTracker::timeline($order) : collect();

        [$statusLabel, $statusClass] = $order
            ? self::statusMeta($order->status)
            : [null, null];

        $recentOrders = Order::where('customer_id', $customer->id)
            ->latest()
            ->take(5)
            ->get(['id', 'order_number', 'status', 'created_at']);

        return view('user.track-order', compact(
            'customer',
            'order',
            'number',
            'notFound',
            'timeline',
            'statusLabel',
            'statusClass',
            'recentOrders'
        ));
    }


    public function dashboard()
    {
        $customer = auth('customer')->user();

        $mine = fn() => Order::where('customer_id', $customer->id);

        $totalOrders = $mine()->count();
        $activeCount = $mine()->whereIn('status', ['new', 'pending', 'processing', 'shipped', 'ndr'])->count();
        $deliveredCount = $mine()->where('status', 'delivered')->count();
        $closedCount = $mine()->whereIn('status', ['cancelled', 'rto'])->count();

        $recentOrders = $mine()
            ->withCount('items')
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'customer',
            'totalOrders',
            'activeCount',
            'deliveredCount',
            'closedCount',
            'recentOrders'
        ));
    }
}