@extends('layouts.app')

@section('title', 'Order Confirmed | Aparatus Pastime - Kids Toys & Sports')
@section('active_nav', 'account')

@section('content')
  <div class="py-12 md:py-16">
    <div class="max-w-3xl mx-auto px-4 text-center">

      <!-- SUCCESS CELEBRATION CARD -->
      <div class="bg-white rounded-3xl border border-brand-border p-8 sm:p-12 shadow-xs space-y-6">

        <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-3xl flex items-center justify-center text-4xl mx-auto shadow-inner">
          <i class="fa-solid fa-circle-check"></i>
        </div>

        <div class="space-y-2">
          <span class="text-xs font-bold uppercase tracking-widest text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
            ORDER CONFIRMED
          </span>
          <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy">
            YAY! YOUR ORDER IS ON ITS WAY.
          </h1>
          <p class="text-xs sm:text-sm text-body-text max-w-md mx-auto font-sans leading-relaxed">
            Thanks for choosing Aparatus Pastime. We hope they love it!
            @if($order->customer_email)
              A confirmation invoice has been sent to <strong>{{ $order->customer_email }}</strong>.
            @endif
          </p>
        </div>

        <!-- ORDER HIGHLIGHTS -->
        <div class="bg-soft-blue/60 rounded-2xl border border-blue-100 p-6 text-left grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs font-sans">
          <div>
            <span class="text-brand-muted block font-semibold">Order Number:</span>
            <span class="font-bold text-dark-navy text-sm font-heading">{{ $order->order_number }}</span>
          </div>
          <div>
            <span class="text-brand-muted block font-semibold">Order Date:</span>
            <span class="font-bold text-dark-navy">{{ $order->created_at->format('d M Y') }}</span>
          </div>
          <div>
            <span class="text-brand-muted block font-semibold">Order Total:</span>
            <span class="font-bold text-brand-orange text-sm font-heading">₹{{ number_format($order->grand_total, 2) }}</span>
          </div>
          @if(!empty($order->estimated_delivery))
            <div>
              <span class="text-brand-muted block font-semibold">Delivery Estimate:</span>
              <span class="font-bold text-emerald-700">
                {{ \Illuminate\Support\Carbon::parse($order->estimated_delivery)->format('d M Y') }}
              </span>
            </div>
          @else
            <div>
              <span class="text-brand-muted block font-semibold">Payment:</span>
              <span class="font-bold text-emerald-700">
                {{ strtoupper($order->payment_method) }} · {{ ucfirst($order->payment_status) }}
              </span>
            </div>
          @endif
        </div>

        <!-- ORDERED ITEMS PREVIEW -->
        @if($order->items->isNotEmpty())
          <div class="text-left pt-2">
            <h3 class="font-heading font-bold text-xs uppercase tracking-wider text-dark-navy mb-3">PACKAGE ITEMS</h3>
            <div class="space-y-2 max-h-48 overflow-y-auto divide-y divide-brand-border font-sans">
              @foreach($order->items as $item)
                @php
                  $thumb = ($item->imageVariant && $item->imageVariant->image)
                      ? asset('storage/' . $item->imageVariant->image)
                      : optional($item->product)->display_image;
                  $lineTotal = ($item->price * $item->quantity) + $item->addons->sum('price');
                @endphp
                <div class="flex items-center gap-3 pt-2 text-xs font-sans">
                  @if($thumb)
                    <img src="{{ $thumb }}" alt="{{ $item->product_name }}"
                         class="w-10 h-10 object-contain rounded-xl bg-soft-blue p-1 border border-brand-border">
                  @endif
                  <div class="flex-1 truncate">
                    <span class="font-bold text-dark-navy font-heading">{{ $item->product_name }}</span>
                    <span class="text-brand-muted block text-[11px]">
                      Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}
                    </span>
                  </div>
                  <span class="font-bold font-heading text-brand-navy">₹{{ number_format($lineTotal, 2) }}</span>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <!-- ACTION BUTTONS -->
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
          <a href="{{ route('track-order', ['orderId' => $order->order_number]) }}"
             class="w-full sm:w-auto btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-md transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-truck text-xs"></i>
            <span>TRACK ORDER</span>
          </a>
          <a href="{{ route('shop') }}"
             class="w-full sm:w-auto bg-white hover:bg-soft-blue text-dark-navy font-bold font-heading text-xs sm:text-sm px-8 py-3.5 rounded-xl border border-brand-border transition">
            CONTINUE SHOPPING
          </a>
        </div>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  {{-- Pixel/GA purchase event from PixelTracker::purchaseScript($order) --}}
  {!! $purchaseScript !!}
@endpush