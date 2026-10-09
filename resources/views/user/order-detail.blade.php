@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-5xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('user.orders') }}" class="hover:text-brand-orange transition font-semibold">My Orders</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">{{ $order->order_number }}</span>
      </nav>

      <!-- ORDER DETAILS CONTAINER -->
      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-8">

        <!-- TOP ROW -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-brand-border gap-4">
          <div>
            <div class="flex flex-wrap items-center gap-3">
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">
                Order <span>{{ $order->order_number }}</span>
              </h1>
              <span class="px-3.5 py-1 rounded-full text-xs font-bold font-heading uppercase border {{ $statusClass }}">
                {{ $statusLabel }}
              </span>
            </div>
            <p class="text-xs text-brand-muted mt-1 font-body">
              Placed on <span class="font-bold text-dark-navy">{{ $order->created_at->format('F d, Y') }}</span>
              @if ($order->tracking_number)
                • Tracking No: <span class="font-bold text-dark-navy">{{ $order->tracking_number }}</span>
                @if ($order->courier)
                  ({{ $order->courier->name }})
                @endif
              @endif
            </p>
          </div>

          <div class="flex items-center gap-3 print:hidden">
            <button type="button" onclick="window.print()"
              class="px-4 py-2.5 bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-blue font-bold font-heading text-xs rounded-xl transition flex items-center gap-2 cursor-pointer">
              <i class="fa-solid fa-print text-xs"></i>
              <span>Print</span>
            </button>
            <a href="{{ route('user.track-order', ['orderId' => $order->order_number]) }}"
              class="px-4 py-2.5 bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-xs rounded-xl shadow-xs transition flex items-center gap-2">
              <i class="fa-solid fa-truck-fast text-xs"></i>
              <span>Track Order</span>
            </a>
          </div>
        </div>

        <!-- TIMELINE -->
        <div class="space-y-4">
          <h2
            class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
            <i class="fa-solid fa-route text-brand-orange"></i>
            DELIVERY MILESTONES
          </h2>
          <div class="grid grid-cols-1 {{ $timeline->count() > 4 ? 'sm:grid-cols-5' : 'sm:grid-cols-4' }} gap-3">
            @foreach ($timeline as $step)
              @php
                $box = $step['alert']
                  ? 'bg-soft-orange border-orange-200'
                  : ($step['done'] ? 'bg-soft-mint border-mint' : 'bg-soft-blue/30 border-brand-border opacity-70');
                $head = $step['alert']
                  ? 'text-brand-orange'
                  : ($step['done'] ? 'text-emerald-800' : 'text-brand-muted');
                $icon = $step['alert']
                  ? 'fa-circle-exclamation text-brand-orange'
                  : ($step['done'] ? 'fa-circle-check text-emerald-600' : 'fa-circle-notch text-gray-400');
              @endphp
              <div class="p-3.5 rounded-2xl border {{ $box }} text-xs font-body space-y-1">
                <div class="flex items-center gap-1.5 font-bold font-heading {{ $head }}">
                  <i class="fa-solid {{ $icon }}"></i>
                  <span>Step {{ $loop->iteration }}</span>
                </div>
                <div class="font-bold text-brand-navy font-heading">{{ $step['label'] }}</div>
                @if ($step['date'])
                  <div class="text-[10px] text-brand-muted font-medium">{{ $step['date'] }}</div>
                @endif
              </div>
            @endforeach
          </div>
        </div>

        <!-- ORDERED PRODUCTS -->
        <div class="space-y-4 pt-4 border-t border-brand-border">
          <h2
            class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
            <i class="fa-solid fa-box text-brand-blue"></i>
            ITEMS IN THIS SHIPMENT
          </h2>
          <div class="divide-y divide-brand-border">
            @foreach ($order->items as $item)
              @php
                $thumb = ($item->imageVariant && $item->imageVariant->image)
                  ? asset('storage/' . $item->imageVariant->image)
                  : optional($item->product)->display_image;

                $variantLabel = null;
                if (!empty($item->selected_attributes)) {
                  $variantLabel = collect($item->selected_attributes)->map(function ($value, $key) {
                    if (is_array($value)) {
                      return ($value['attribute'] ?? $value['name'] ?? $key) . ': ' . ($value['value'] ?? $value['label'] ?? reset($value));
                    }
                    return $key . ': ' . $value;
                  })->join(' · ');
                }

                $lineTotal = ($item->price * $item->quantity) + $item->addons->sum('price');
              @endphp
              <div class="py-4 flex items-center justify-between gap-4 text-xs font-body">
                <div class="flex items-center gap-4 min-w-0">
                  @if ($thumb)
                    <img src="{{ $thumb }}" alt="{{ $item->product_name }}"
                      class="w-14 h-14 object-contain rounded-2xl bg-soft-blue/30 p-1.5 border border-brand-border shrink-0">
                  @else
                    <div
                      class="w-14 h-14 rounded-2xl bg-soft-blue/30 border border-brand-border shrink-0 flex items-center justify-center text-brand-border">
                      <i class="fa-solid fa-image"></i>
                    </div>
                  @endif
                  <div class="min-w-0">
                    <h4 class="font-bold text-brand-navy hover:text-brand-orange transition font-heading text-sm">
                      @if ($item->product)
                        <a href="{{ route('product', ['slug' => $item->product->slug]) }}">{{ $item->product_name }}</a>
                      @else
                        {{ $item->product_name }}
                      @endif
                    </h4>
                    @if ($variantLabel)
                      <p class="text-[11px] text-brand-muted font-medium">{{ $variantLabel }}</p>
                    @endif
                    <p class="text-[11px] text-brand-muted mt-0.5 font-medium">
                      Unit Price: ₹{{ number_format($item->price, 2) }} × {{ $item->quantity }} Qty
                    </p>
                    @foreach ($item->addons as $addon)
                      <p class="text-[11px] text-brand-muted">+ {{ $addon->detail }} (₹{{ number_format($addon->price, 2) }})
                      </p>
                    @endforeach
                  </div>
                </div>
                <div class="text-right shrink-0">
                  <span
                    class="font-extrabold font-heading text-base text-brand-navy">₹{{ number_format($lineTotal, 2) }}</span>
                  @if ($order->status === 'delivered')
                    @if (in_array($item->id, $reviewedItemIds))
                      <a href="{{ route('user.reviews') }}" class="block text-[11px] font-bold text-emerald-700 mt-1">✓
                        Reviewed</a>
                    @else
                      <a href="{{ route('user.reviews.create', ['item' => $item->id]) }}"
                        class="block text-[11px] font-bold text-brand-orange hover:underline mt-1 print:hidden">Write a
                        Review</a>
                    @endif
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- ADDRESS, PAYMENT, BREAKDOWN -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-brand-border text-xs font-body">

          <div class="space-y-2 p-5 bg-soft-blue/40 rounded-2xl border border-sky-blue/30">
            <h3 class="font-heading font-bold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
              <i class="fa-solid fa-location-dot text-brand-blue"></i>
              SHIPPING ADDRESS
            </h3>
            <p class="text-body-text leading-relaxed font-medium">
              <strong>{{ $order->customer_name }}</strong><br>
              {{ $order->address_line_1 }}@if ($order->address_line_2), {{ $order->address_line_2 }}@endif<br>
              {{ collect([$order->city?->name, $order->state?->name])->filter()->implode(', ') }} -
              {{ $order->pincode }}<br>
              Phone: {{ $order->customer_phone }}
            </p>
          </div>

          <div class="space-y-2 p-5 bg-soft-yellow/40 rounded-2xl border border-play-yellow/40">
            <h3 class="font-heading font-bold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
              <i class="fa-solid fa-credit-card text-amber-600"></i>
              PAYMENT METHOD
            </h3>
            <p class="text-brand-navy font-bold">
              {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment (Razorpay)' }}
            </p>
            @if ($order->payment_status === 'paid')
              <p class="text-[11px] text-emerald-700 font-bold flex items-center gap-1">
                <i class="fa-solid fa-circle-check"></i> Payment Received
              </p>
              @if ($order->transaction_id)
                <p class="text-[11px] text-brand-muted font-medium break-all">Txn ID: {{ $order->transaction_id }}</p>
              @endif
            @else
              <p class="text-[11px] text-amber-700 font-bold flex items-center gap-1">
                <i class="fa-solid fa-clock"></i> Payment {{ ucfirst($order->payment_status) }}
              </p>
            @endif
          </div>

          <div class="space-y-2 p-5 bg-soft-mint/40 rounded-2xl border border-mint">
            <h3 class="font-heading font-bold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
              <i class="fa-solid fa-receipt text-emerald-700"></i>
              PAYMENT BREAKDOWN
            </h3>
            <div class="space-y-1.5 text-body-text">
              <div class="flex justify-between">
                <span>Subtotal:</span>
                <span class="font-bold text-brand-navy">₹{{ number_format($order->subtotal, 2) }}</span>
              </div>

              @if ($order->discount > 0)
                <div class="flex justify-between">
                  <span>Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}:</span>
                  <span class="text-emerald-700 font-bold">-₹{{ number_format($order->discount, 2) }}</span>
                </div>
              @endif

              @if ($order->tax_amount > 0)
                @if ($order->gst_type === 'igst' && $order->igst_amount > 0)
                  <div class="flex justify-between">
                    <span>IGST ({{ $order->igst_rate }}%):</span>
                    <span class="font-bold text-brand-navy">₹{{ number_format($order->igst_amount, 2) }}</span>
                  </div>
                @else
                  @if ($order->cgst_amount > 0)
                    <div class="flex justify-between">
                      <span>CGST ({{ $order->cgst_rate }}%):</span>
                      <span class="font-bold text-brand-navy">₹{{ number_format($order->cgst_amount, 2) }}</span>
                    </div>
                  @endif
                  @if ($order->sgst_amount > 0)
                    <div class="flex justify-between">
                      <span>SGST ({{ $order->sgst_rate }}%):</span>
                      <span class="font-bold text-brand-navy">₹{{ number_format($order->sgst_amount, 2) }}</span>
                    </div>
                  @endif
                @endif
              @endif

              <div
                class="flex justify-between text-base font-extrabold font-heading text-brand-navy pt-2 border-t border-brand-border">
                <span>Total Amount:</span>
                <span>₹{{ number_format($order->grand_total, 2) }}</span>
              </div>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>
@endsection