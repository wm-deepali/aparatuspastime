<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Collection;

class OrderTracker
{
    public static function timeline(Order $order): Collection
    {
        $history = $order->statusHistory->sortBy('created_at');
        $at = fn(string $s) => optional($history->first(fn($h) => $h->status === $s))->created_at;

        $rankOf = fn(string $s) => match ($s) {
            'new', 'pending' => 0,
            'processing' => 1,
            'shipped', 'ndr', 'rto' => 2,
            'delivered' => 3,
            default => null,
        };

        $currentRank = $rankOf($order->status);
        if ($currentRank === null) { // cancelled: furthest step reached before
            $currentRank = $history->map(fn($h) => $rankOf($h->status))
                ->filter(fn($r) => $r !== null)->max() ?? 0;
        }

        $steps = [
            ['label' => 'Order Placed', 'rank' => 0, 'date' => $order->created_at],
            ['label' => 'Processing',   'rank' => 1, 'date' => $at('processing')],
            ['label' => 'Shipped',      'rank' => 2, 'date' => $at('shipped')],
            ['label' => 'Delivered',    'rank' => 3, 'date' => $at('delivered')],
        ];

        $timeline = collect($steps)->map(fn($s) => [
            'label' => $s['label'],
            'done'  => $s['rank'] <= $currentRank,
            'date'  => $s['date']?->format('d M Y, h:i A'),
            'alert' => false,
        ]);

        $extra = [
            'cancelled' => 'Cancelled',
            'ndr'       => 'Delivery Attempt Failed',
            'rto'       => 'Returned to Seller',
        ];
        if (isset($extra[$order->status])) {
            $timeline->push([
                'label' => $extra[$order->status],
                'done'  => true,
                'date'  => $at($order->status)?->format('d M Y, h:i A'),
                'alert' => true,
            ]);
        }

        return $timeline;
    }
}