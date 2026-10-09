@extends('layouts.app')

@section('title', 'Track Order | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-4xl mx-auto px-4 space-y-8">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('user.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">Track Order</span>
      </nav>

      <!-- LOOKUP CARD -->
      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-28 h-28 bg-soft-blue rounded-full -z-0 opacity-70 pointer-events-none"></div>

        <div class="text-center space-y-2 max-w-lg mx-auto relative z-10">
          <div class="w-16 h-16 rounded-full bg-soft-blue text-brand-blue flex items-center justify-center text-2xl mx-auto border border-sky-blue/40 shadow-xs">
            <i class="fa-solid fa-truck-fast"></i>
          </div>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Track Your Play Package</h1>
          <p class="text-xs sm:text-sm text-brand-muted font-body leading-relaxed">
            Enter your Order ID (from your confirmation email/SMS) to view delivery milestones.
          </p>
        </div>

        <form method="GET" action="{{ route('user.track-order') }}"
          class="grid grid-cols-1 sm:grid-cols-12 gap-3 max-w-2xl mx-auto text-xs font-body relative z-10">
          <div class="sm:col-span-9">
            <label class="block font-bold text-brand-navy mb-1.5 font-heading">Order Number *</label>
            <input type="text" name="orderId" required value="{{ $number }}" placeholder="E.g. AP-2026-89421"
              class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-bold text-brand-navy">
          </div>
          <div class="sm:col-span-3 flex items-end">
            <button type="submit"
              class="w-full bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-xs py-3.5 px-4 rounded-xl shadow transition cursor-pointer">
              TRACK ORDER
            </button>
          </div>
        </form>

        @if ($recentOrders->isNotEmpty())
          <div class="max-w-2xl mx-auto relative z-10 flex flex-wrap items-center gap-2 text-[11px] font-body">
            <span class="text-brand-muted font-medium">Recent:</span>
            @foreach ($recentOrders as $r)
              <a href="{{ route('user.track-order', ['orderId' => $r->order_number]) }}"
                class="px-3 py-1 rounded-full border border-brand-border bg-white hover:border-brand-orange hover:text-brand-orange font-bold text-brand-navy transition">
                {{ $r->order_number }}
              </a>
            @endforeach
          </div>
        @endif
      </div>

      <!-- NOT FOUND -->
      @if ($notFound)
        <div class="bg-soft-coral border border-red-300 text-red-800 rounded-3xl p-6 text-xs font-body flex items-start gap-3">
          <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
          <div>
            <p class="font-bold font-heading text-sm">We couldn't find that order</p>
            <p class="mt-1">Check the order number (<strong>{{ $number }}</strong>) and make sure you're logged in to the account that placed it.</p>
          </div>
        </div>
      @endif

      <!-- RESULTS -->
      @if ($order)
        <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6">

          <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-brand-border gap-2">
            <div>
              <span class="text-xs text-brand-muted font-body">Tracking result for package:</span>
              <h2 class="text-xl font-extrabold font-heading text-brand-navy">{{ $order->order_number }}</h2>
              <p class="text-[11px] text-brand-muted mt-0.5">Placed on {{ $order->created_at->format('F d, Y') }}</p>
            </div>
            <span class="px-3.5 py-1 rounded-full text-xs font-bold font-heading uppercase border {{ $statusClass }}">
              {{ $statusLabel }}
            </span>
          </div>

          <!-- Milestones -->
          <div class="space-y-3">
            <h3 class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
              <i class="fa-solid fa-route text-brand-orange"></i>
              DELIVERY MILESTONES
            </h3>
            <div class="space-y-0 pt-2">
              @foreach ($timeline as $step)
                @php
                  $circle = $step['alert']
                      ? 'bg-brand-orange text-white'
                      : ($step['done'] ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400');
                  $line = $step['alert'] ? 'bg-brand-orange' : ($step['done'] ? 'bg-emerald-500' : 'bg-gray-200');
                  $icon = $step['alert'] ? 'fa-exclamation' : ($step['done'] ? 'fa-check' : 'fa-circle');
                @endphp
                <div class="flex items-start gap-4">
                  <div class="flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full {{ $circle }} flex items-center justify-center text-xs font-bold shrink-0">
                      <i class="fa-solid {{ $icon }}"></i>
                    </div>
                    @unless ($loop->last)
                      <div class="w-0.5 h-10 {{ $line }}"></div>
                    @endunless
                  </div>
                  <div class="pt-1 text-xs font-body pb-4">
                    <div class="font-bold font-heading text-sm text-brand-navy">{{ $step['label'] }}</div>
                    <div class="text-brand-muted text-[11px] mt-0.5">
                      {{ $step['date'] ?? ($step['done'] ? '' : 'Pending') }}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Activity log (latest first) -->
          @if ($order->statusHistory->isNotEmpty())
            <div class="space-y-3 pt-4 border-t border-brand-border">
              <h3 class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-brand-blue"></i>
                ACTIVITY
              </h3>
              <ul class="divide-y divide-brand-border text-xs font-body">
                @foreach ($order->statusHistory as $h)
                  <li class="py-2.5 flex items-center justify-between gap-3">
                    <span class="font-bold text-brand-navy font-heading">
                      {{ \App\Http\Controllers\User\UserOrderController::statusMeta($h->status)[0] }}
                    </span>
                    <span class="text-brand-muted text-[11px]">{{ $h->created_at->format('d M Y, h:i A') }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Courier -->
          @if ($order->courier || $order->tracking_number)
            <div class="p-4 bg-soft-blue rounded-2xl border border-sky-blue/40 text-xs font-body flex flex-col sm:flex-row sm:items-center justify-between gap-3">
              <div class="space-y-0.5">
                <span class="text-brand-muted block text-[11px] font-medium">Courier Partner:</span>
                <span class="font-bold text-brand-navy font-heading">
                  {{ $order->courier->name ?? 'Courier' }}
                  @if ($order->tracking_number)
                    (AWB #{{ $order->tracking_number }})
                  @endif
                </span>
                @if ($order->courier?->website_url)
                  <a href="{{ $order->courier->website_url }}" target="_blank" rel="noopener"
                    class="block text-brand-blue hover:text-brand-orange font-bold text-[11px] mt-1">
                    Track on courier website ↗
                  </a>
                @endif
              </div>
              <a href="{{ route('contact') }}" class="text-brand-blue hover:text-brand-orange font-bold font-heading self-start sm:self-auto">
                Need Help With Delivery? →
              </a>
            </div>
          @else
            <div class="p-4 bg-soft-yellow/40 rounded-2xl border border-play-yellow/40 text-xs font-body text-brand-muted">
              Courier details will appear here once your order is shipped.
            </div>
          @endif

          <div class="text-right print:hidden">
            <a href="{{ route('user.order-detail', ['orderId' => $order->order_number]) }}"
              class="text-xs font-bold font-heading text-brand-blue hover:text-brand-orange">View full order details →</a>
          </div>
        </div>
      @endif

    </div>
  </div>
@endsection