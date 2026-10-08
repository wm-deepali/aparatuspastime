@extends('layouts.app')

@section('title', 'My Playroom Dashboard | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ url('/') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Playroom</span>
      </nav>

      <!-- DASHBOARD LAYOUT (SIDEBAR + CONTENT) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR (3 COLS) -->
        @include('front-pages._sidebar', ['active' => 'dashboard', 'withUser' => true])

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
                Welcome Back, <span id="welcome-user-fname">Aarav</span>! 👋
              </h1>
              <p class="text-xs sm:text-sm text-brand-muted font-body mt-1">
                Manage your orders, active deliveries, saved toys and playtime rewards.
              </p>
            </div>
            <a href="{{ route('shop') }}" class="bg-brand-orange hover:bg-brand-bright-orange text-white text-xs font-bold font-heading px-6 py-3 rounded-2xl shadow-md transition duration-200 shrink-0 relative z-10">
              EXPLORE TOYS & GAMES →
            </a>
          </div>

          <!-- 4 PASTEL STATS CARDS -->
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-soft-blue p-5 rounded-2xl border border-sky-blue/30 shadow-xs space-y-1">
              <div class="text-brand-blue text-xl mb-1"><i class="fa-solid fa-box-open"></i></div>
              <div id="stat-total-orders" class="text-2xl font-extrabold font-heading text-brand-navy">2</div>
              <div class="text-[11px] text-brand-muted font-heading font-bold uppercase tracking-wider">Total Orders</div>
            </div>

            <div class="bg-soft-yellow p-5 rounded-2xl border border-play-yellow/40 shadow-xs space-y-1">
              <div class="text-amber-500 text-xl mb-1"><i class="fa-solid fa-heart"></i></div>
              <div id="stat-wishlist-count" class="text-2xl font-extrabold font-heading text-brand-navy">3</div>
              <div class="text-[11px] text-brand-muted font-heading font-bold uppercase tracking-wider">Wishlist Items</div>
            </div>

            <div class="bg-soft-orange p-5 rounded-2xl border border-brand-orange/30 shadow-xs space-y-1">
              <div class="text-brand-orange text-xl mb-1"><i class="fa-solid fa-truck-fast"></i></div>
              <div id="stat-pending-orders" class="text-2xl font-extrabold font-heading text-brand-navy">1</div>
              <div class="text-[11px] text-brand-muted font-heading font-bold uppercase tracking-wider">Active Deliveries</div>
            </div>

            <div class="bg-soft-mint p-5 rounded-2xl border border-mint shadow-xs space-y-1">
              <div class="text-emerald-600 text-xl mb-1"><i class="fa-solid fa-award"></i></div>
              <div id="stat-reward-points" class="text-2xl font-extrabold font-heading text-brand-navy">250</div>
              <div class="text-[11px] text-brand-muted font-heading font-bold uppercase tracking-wider">Reward Points</div>
            </div>
          </div>

          <!-- RECENT ORDERS TABLE -->
          <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-brand-border">
              <h2 class="font-heading font-extrabold text-sm uppercase tracking-wider text-brand-navy flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-brand-orange"></i>
                RECENT ORDERS
              </h2>
              <a href="{{ route('account.orders') }}" class="text-xs font-bold font-heading text-brand-blue hover:text-brand-orange transition">View All Orders →</a>
            </div>

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
                <tbody id="dash-orders-tbody" class="divide-y divide-brand-border">
                  <!-- Injected via JavaScript -->
                </tbody>
              </table>
            </div>
          </div>

          <!-- QUICK PLAYROOM SHORTCUTS -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('account.track-order') }}" class="p-5 bg-white hover:bg-soft-blue rounded-3xl border border-brand-border hover:border-sky-blue transition flex items-center gap-3.5 shadow-xs group">
              <div class="w-12 h-12 rounded-2xl bg-soft-blue text-brand-blue flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition">
                <i class="fa-solid fa-truck-fast"></i>
              </div>
              <div>
                <h4 class="font-heading font-bold text-xs text-brand-navy">Track Active Order</h4>
                <p class="text-[11px] text-brand-muted">Check live milestone progress</p>
              </div>
            </a>

            <a href="{{ route('account.wishlist') }}" class="p-5 bg-white hover:bg-soft-yellow rounded-3xl border border-brand-border hover:border-play-yellow transition flex items-center gap-3.5 shadow-xs group">
              <div class="w-12 h-12 rounded-2xl bg-soft-yellow text-amber-600 flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition">
                <i class="fa-solid fa-heart"></i>
              </div>
              <div>
                <h4 class="font-heading font-bold text-xs text-brand-navy">Saved Wishlist</h4>
                <p class="text-[11px] text-brand-muted">Things they'd love</p>
              </div>
            </a>

            <a href="{{ route('account.addresses') }}" class="p-5 bg-white hover:bg-soft-mint rounded-3xl border border-brand-border hover:border-mint transition flex items-center gap-3.5 shadow-xs group">
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

@push('scripts')
  <script type="module">
    import { State } from '{{ asset("assets/js/state.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const base = @json(url('/') . '/');

      const user = State.getUser();
      const orders = State.getOrders();
      const wishlistCount = State.getWishlistCount();

      document.getElementById('welcome-user-fname').textContent = user.firstName || 'Playroom Member';
      document.getElementById('user-name-label').textContent = `${user.firstName} ${user.lastName}`;
      document.getElementById('user-email-label').textContent = user.email;

      // Stats
      document.getElementById('stat-total-orders').textContent = orders.length;
      document.getElementById('stat-wishlist-count').textContent = wishlistCount;
      document.getElementById('stat-pending-orders').textContent = orders.filter(o => o.status === 'Shipped' || o.status === 'Processing').length;
      document.getElementById('stat-reward-points').textContent = '250';

      // Orders table
      const tbody = document.getElementById('dash-orders-tbody');
      if (tbody) {
        tbody.innerHTML = orders.map(o => {
          const statusClass = o.status === 'Delivered'
            ? 'bg-soft-mint text-emerald-800 border-mint'
            : o.status === 'Shipped'
            ? 'bg-soft-blue text-brand-blue border-sky-blue'
            : 'bg-soft-yellow text-amber-800 border-amber-300';

          return `
            <tr class="hover:bg-soft-blue/20 transition">
              <td class="py-3 px-3.5 font-bold font-heading text-brand-navy">${o.id}</td>
              <td class="py-3 px-3.5 text-brand-muted">${o.date}</td>
              <td class="py-3 px-3.5 font-medium">${o.items.length} Item(s)</td>
              <td class="py-3 px-3.5 font-bold text-brand-navy font-heading">₹${o.total.toLocaleString()}</td>
              <td class="py-3 px-3.5">
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase border ${statusClass}">${o.status}</span>
              </td>
              <td class="py-3 px-3.5 text-right space-x-2">
                <a href="${base}account/order-detail?orderId=${o.id}" class="text-brand-blue hover:text-brand-orange font-bold font-heading">View</a>
                <a href="${base}account/track-order?orderId=${o.id}" class="text-brand-orange hover:underline font-bold font-heading">Track</a>
              </td>
            </tr>
          `;
        }).join('');
      }

      document.getElementById('dash-signout-btn')?.addEventListener('click', () => {
        State.logout();
      });
    });
  </script>
@endpush