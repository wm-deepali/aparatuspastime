@extends('layouts.app')

@section('title', 'My Orders | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('user.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Orders</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('user._sidebar', ['active' => 'orders'])

        <!-- MAIN ORDERS LIST -->
        <div class="lg:col-span-9 space-y-6">

          <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-brand-border gap-4">
            <div>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">MY ORDERS</h1>
              <p class="text-xs text-brand-muted font-body mt-1">Review past orders, download invoices, and track live shipments.</p>
            </div>

            <!-- Filter status pills -->
            <div class="flex items-center gap-1.5 overflow-x-auto text-xs font-bold font-heading">
              <a href="{{ route('user.orders') }}"
                 class="px-3.5 py-1.5 rounded-full transition whitespace-nowrap {{ $status === 'all' ? 'bg-brand-navy text-white' : 'bg-white border border-brand-border text-brand-navy hover:bg-soft-yellow' }}">All</a>
              @foreach ($filters as $key => $label)
                <a href="{{ route('user.orders', ['status' => $key]) }}"
                   class="px-3.5 py-1.5 rounded-full transition whitespace-nowrap {{ $status === $key ? 'bg-brand-navy text-white' : 'bg-white border border-brand-border text-brand-navy hover:bg-soft-blue' }}">{{ $label }}</a>
              @endforeach
            </div>
          </div>

          <div class="space-y-4">
            @forelse ($orders as $o)
              @php
                [$statusLabel, $statusClass] = \App\Http\Controllers\User\UserOrderController::statusMeta($o->status);
              @endphp

              <div class="bg-white rounded-3xl border border-brand-border p-5 sm:p-6 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-brand-border gap-2 text-xs font-body">
                  <div>
                    <span class="text-brand-muted">Order ID:</span>
                    <span class="font-bold text-brand-navy font-heading text-sm ml-1">{{ $o->order_number }}</span>
                    <span class="text-brand-muted ml-3">• Placed on {{ $o->created_at->format('d M Y') }}</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase font-heading border {{ $statusClass }}">{{ $statusLabel }}</span>
                  </div>
                </div>

                <!-- Item rows -->
                <div class="space-y-3">
                  @foreach ($o->items as $item)
                    @php
                      $thumb = ($item->imageVariant && $item->imageVariant->image)
                          ? asset('storage/' . $item->imageVariant->image)
                          : optional($item->product)->display_image;
                      $lineTotal = ($item->price * $item->quantity) + $item->addons->sum('price');
                    @endphp
                    <div class="flex items-center gap-4 text-xs font-body">
                      @if ($thumb)
                        <img src="{{ $thumb }}" alt="{{ $item->product_name }}"
                             class="w-14 h-14 object-contain rounded-2xl bg-soft-blue/40 p-1.5 border border-brand-border shrink-0">
                      @else
                        <div class="w-14 h-14 rounded-2xl bg-soft-blue/40 border border-brand-border shrink-0 flex items-center justify-center text-brand-border">
                          <i class="fa-solid fa-image"></i>
                        </div>
                      @endif

                      <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-brand-navy truncate hover:text-brand-orange transition font-heading">
                          @if ($item->product)
                            <a href="{{ route('product', ['slug' => $item->product->slug]) }}">{{ $item->product_name }}</a>
                          @else
                            {{ $item->product_name }}
                          @endif
                        </h4>
                        <div class="text-[11px] text-brand-muted mt-0.5 font-medium">
                          Quantity: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}
                        </div>
                        @foreach ($item->addons as $addon)
                          <div class="text-[11px] text-brand-muted">+ {{ $addon->detail }} (₹{{ number_format($addon->price, 2) }})</div>
                        @endforeach
                      </div>

                      <div class="text-right">
                        <span class="font-bold text-brand-navy font-heading text-sm">₹{{ number_format($lineTotal, 2) }}</span>
                      </div>
                    </div>
                  @endforeach
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-3 border-t border-brand-border gap-3 text-xs">
                  <div>
                    <span class="text-brand-muted">Total:</span>
                    <span class="font-bold text-brand-navy text-base font-heading ml-1">₹{{ number_format($o->grand_total, 2) }}</span>
                    <span class="text-[11px] text-brand-muted ml-1 font-medium">({{ strtoupper($o->payment_method) }} · {{ ucfirst($o->payment_status) }})</span>
                  </div>

                  <div class="flex items-center gap-2">
                    <a href="{{ route('user.order-detail', ['orderId' => $o->order_number]) }}"
                       class="px-4 py-2 bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-blue font-bold font-heading rounded-xl transition">
                      View Details
                    </a>
                    <a href="{{ route('user.track-order', ['orderId' => $o->order_number]) }}"
                       class="px-4 py-2 bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading rounded-xl shadow-xs transition flex items-center gap-1.5">
                      <i class="fa-solid fa-truck-fast text-xs"></i>
                      <span>Track Shipment</span>
                    </a>
                  </div>
                </div>
              </div>
            @empty
              <div class="bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-soft-orange text-brand-orange flex items-center justify-center text-2xl mx-auto">
                  <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="font-heading font-extrabold text-lg text-brand-navy">No adventures found</h3>
                <p class="text-xs text-brand-muted max-w-sm mx-auto font-body">
                  {{ $status === 'all' ? "You haven't placed any orders yet." : 'You have no orders under this status yet.' }} Let's find something fun to play with!
                </p>
                <a href="{{ route('shop') }}" class="inline-block bg-brand-orange hover:bg-brand-bright-orange text-white text-xs font-bold font-heading px-6 py-3 rounded-2xl shadow transition">
                  EXPLORE TOYS & GAMES →
                </a>
              </div>
            @endforelse
          </div>

          @if ($orders->hasPages())
            <div class="pt-2">{{ $orders->links() }}</div>
          @endif

        </div>

      </div>

    </div>
  </div>
@endsection