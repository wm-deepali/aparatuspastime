@extends('layouts.app')

@section('title', 'My Playroom Dashboard | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Playroom</span>
      </nav>

      <!-- DASHBOARD LAYOUT (SIDEBAR + CONTENT) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR (3 COLS) -->
        @include('user._sidebar', ['active' => 'dashboard', 'withUser' => true, 'customer' => $customer])

        <!-- MAIN DASHBOARD CONTENT (9 COLS) -->
        <div class="lg:col-span-9 space-y-6">

          <!-- WELCOME BANNER -->
          <div class="bg-gradient-to-r from-soft-yellow via-soft-orange to-soft-mint rounded-3xl border border-brand-border p-6 sm:p-8 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 text-7xl text-brand-orange/10 pointer-events-none">
              <i class="fa-solid fa-rocket"></i>
            </div>
            <div class="relative z-10">
              <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-orange font-heading bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full border border-brand-orange/20 mb-2">
                MY PLAYROOM
              </span>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">
                Welcome Back, {{ \Illuminate\Support\Str::before($customer->name ?? 'Playroom Member', ' ') }}! 👋
              </h1>
              <p class="text-xs sm:text-sm text-brand-muted font-body mt-1">
                Manage your orders and track your active deliveries.
              </p>
            </div>
            <a href="{{ route('shop') }}" class="bg-brand-orange hover:bg-brand-bright-orange text-white text-xs font-bold font-heading px-6 py-3 rounded-2xl shadow-md transition duration-200 shrink-0 relative z-10">
              EXPLORE TOYS & GAMES →
            </a>
          </div>

          <!-- STATS CARDS -->
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-soft-blue p-5 rounded-2xl border border-sky-blue/30 shadow-xs space-y-1">
              <div class="text-brand-blue text-xl mb-1"><i class="fa-solid fa-box-open"></i></div>
              <div class="text-2xl font-extrabold font-heading text-brand-navy">{{ $totalOrders }}</div>
              <div class="text-[11px] text-brand-muted font-heading font-bold uppercase tracking-wider">Total Orders</div>
            </div>

            <div class="bg-soft-orange p-5 rounded-2xl border border-brand-orange/30 shadow-xs space-y-1">
              <div class="text-brand-orange text-xl mb-1"><i class="fa-solid fa-truck-fast"></i></div>
              <div class="text-2xl font-extrabold font-heading text-brand-navy">{{ $activeCount }}</div>
              <div class="text-[11px] text-brand-muted font-heading font-bold uppercase tracking-wider">Active Deliveries</div>
            </div>

            <div class="bg-soft-mint p-5 rounded-2xl border border-mint shadow-xs space-y-1">
              <div class="text-emerald-600 text-xl mb-1"><i class="fa-solid fa-circle-check"></i></div>
              <div class="text-2xl font-extrabold font-heading text-brand-navy">{{ $deliveredCount }}</div>
              <div class="text-[11px] text-brand-muted font-heading font-bold uppercase tracking-wider">Delivered</div>
            </div>

            <div class="bg-soft-yellow p-5 rounded-2xl border border-play-yellow/40 shadow-xs space-y-1">
              <div class="text-amber-500 text-xl mb-1"><i class="fa-solid fa-rotate-left"></i></div>
              <div class="text-2xl font-extrabold font-heading text-brand-navy">{{ $closedCount }}</div>
              <div class="text-[11px] text-brand-muted font-heading font-bold uppercase tracking-wider">Cancelled / Returned</div>
            </div>
          </div>

          <!-- RECENT ORDERS TABLE -->
          <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-brand-border">
              <h2 class="font-heading font-extrabold text-sm uppercase tracking-wider text-brand-navy flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-brand-orange"></i>
                RECENT ORDERS
              </h2>
              <a href="{{ route('user.orders') }}" class="text-xs font-bold font-heading text-brand-blue hover:text-brand-orange transition">View All Orders →</a>
            </div>

            @if ($recentOrders->isEmpty())
              <div class="py-10 text-center text-xs font-body text-brand-muted space-y-3">
                <p>You haven't placed any orders yet.</p>
                <a href="{{ route('shop') }}" class="inline-block bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading px-5 py-2.5 rounded-xl transition">
                  Start Shopping
                </a>
              </div>
            @else
              <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs font-body">
                  <thead>
                    <tr class="bg-soft-blue/50 text-brand-navy font-bold font-heading rounded-xl">
                      <th class="py-3 px-3.5 rounded-l-xl">Order ID</th>
                      <th class="py-3 px-3.5">Date</th>
                      <th class="py-3 px-3.5">Items</th>
                      <th class="py-3 px-3.5">Total</th>
                      <th class="py-3 px-3.5">Status</th>
                      <th class="py-3 px-3.5 text-right rounded-r-xl">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-brand-border">
                    @foreach ($recentOrders as $o)
                      @php [$label, $class] = \App\Http\Controllers\User\UserOrderController::statusMeta($o->status); @endphp
                      <tr class="hover:bg-soft-blue/20 transition">
                        <td class="py-3 px-3.5 font-bold font-heading text-brand-navy">{{ $o->order_number }}</td>
                        <td class="py-3 px-3.5 text-brand-muted whitespace-nowrap">{{ $o->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-3.5 font-medium">{{ $o->items_count }} Item(s)</td>
                        <td class="py-3 px-3.5 font-bold text-brand-navy font-heading">₹{{ number_format($o->grand_total, 2) }}</td>
                        <td class="py-3 px-3.5">
                          <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase border whitespace-nowrap {{ $class }}">{{ $label }}</span>
                        </td>
                        <td class="py-3 px-3.5 text-right space-x-2 whitespace-nowrap">
                          <a href="{{ route('user.order-detail', ['orderId' => $o->order_number]) }}" class="text-brand-blue hover:text-brand-orange font-bold font-heading">View</a>
                          <a href="{{ route('user.track-order', ['orderId' => $o->order_number]) }}" class="text-brand-orange hover:underline font-bold font-heading">Track</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

          <!-- QUICK PLAYROOM SHORTCUTS -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('user.track-order') }}" class="p-5 bg-white hover:bg-soft-blue rounded-3xl border border-brand-border hover:border-sky-blue transition flex items-center gap-3.5 shadow-xs group">
              <div class="w-12 h-12 rounded-2xl bg-soft-blue text-brand-blue flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition">
                <i class="fa-solid fa-truck-fast"></i>
              </div>
              <div>
                <h4 class="font-heading font-bold text-xs text-brand-navy">Track Active Order</h4>
                <p class="text-[11px] text-brand-muted">Check live milestone progress</p>
              </div>
            </a>

            <a href="{{ route('user.wishlist') }}" class="p-5 bg-white hover:bg-soft-yellow rounded-3xl border border-brand-border hover:border-play-yellow transition flex items-center gap-3.5 shadow-xs group">
              <div class="w-12 h-12 rounded-2xl bg-soft-yellow text-amber-600 flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition">
                <i class="fa-solid fa-heart"></i>
              </div>
              <div>
                <h4 class="font-heading font-bold text-xs text-brand-navy">Saved Wishlist</h4>
                <p class="text-[11px] text-brand-muted">Things they'd love</p>
              </div>
            </a>

            <a href="{{ route('user.addresses') }}" class="p-5 bg-white hover:bg-soft-mint rounded-3xl border border-brand-border hover:border-mint transition flex items-center gap-3.5 shadow-xs group">
              <div class="w-12 h-12 rounded-2xl bg-soft-mint text-emerald-600 flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <div>
                <h4 class="font-heading font-bold text-xs text-brand-navy">Manage Addresses</h4>
                <p class="text-[11px] text-brand-muted">Home & office destinations</p>
              </div>
            </a>
          </div>

        </div>

      </div>

    </div>
  </div>
@endsection