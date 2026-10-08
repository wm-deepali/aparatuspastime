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
        <a href="{{ route('account.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Orders</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('front-pages._sidebar', ['active' => 'orders'])

        <!-- MAIN ORDERS LIST -->
        <div class="lg:col-span-9 space-y-6">

          <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-brand-border gap-4">
            <div>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">MY ORDERS</h1>
              <p class="text-xs text-brand-muted font-body mt-1">Review past orders, download invoices, and track live shipments.</p>
            </div>

            <!-- Filter status pills -->
            <div class="flex items-center gap-1.5 overflow-x-auto text-xs font-bold font-heading">
              <button class="order-filter-pill active px-3.5 py-1.5 rounded-full bg-brand-navy text-white transition cursor-pointer" data-status="all">All</button>
              <button class="order-filter-pill px-3.5 py-1.5 rounded-full bg-white border border-brand-border text-brand-navy hover:bg-soft-yellow transition cursor-pointer" data-status="Processing">Processing</button>
              <button class="order-filter-pill px-3.5 py-1.5 rounded-full bg-white border border-brand-border text-brand-navy hover:bg-soft-blue transition cursor-pointer" data-status="Shipped">Shipped</button>
              <button class="order-filter-pill px-3.5 py-1.5 rounded-full bg-white border border-brand-border text-brand-navy hover:bg-soft-mint transition cursor-pointer" data-status="Delivered">Delivered</button>
            </div>
          </div>

          <div id="orders-list-container" class="space-y-4">
            <!-- Injected via JavaScript -->
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

      const container = document.getElementById('orders-list-container');
      const allOrders = State.getOrders();

      const renderOrders = (filterStatus = 'all') => {
        let list = filterStatus === 'all' ? allOrders : allOrders.filter(o => o.status === filterStatus);

        if (list.length === 0) {
          container.innerHTML = `
            <div class="bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 shadow-sm">
              <div class="w-16 h-16 rounded-full bg-soft-orange text-brand-orange flex items-center justify-center text-2xl mx-auto">
                <i class="fa-solid fa-box-open"></i>
              </div>
              <h3 class="font-heading font-extrabold text-lg text-brand-navy">No adventures found</h3>
              <p class="text-xs text-brand-muted max-w-sm mx-auto font-body">You have no orders under this status category yet. Let's find something fun to play with!</p>
              <a href="${base}shop" class="inline-block bg-brand-orange hover:bg-brand-bright-orange text-white text-xs font-bold font-heading px-6 py-3 rounded-2xl shadow transition">
                EXPLORE TOYS & GAMES →
              </a>
            </div>
          `;
          return;
        }

        container.innerHTML = list.map(o => {
          const statusClass = o.status === 'Delivered'
            ? 'bg-soft-mint text-emerald-800 border-mint'
            : o.status === 'Shipped'
            ? 'bg-soft-blue text-brand-blue border-sky-blue'
            : o.status === 'Cancelled'
            ? 'bg-soft-coral text-red-800 border-red-300'
            : 'bg-soft-yellow text-amber-800 border-amber-300';

          return `
            <div class="bg-white rounded-3xl border border-brand-border p-5 sm:p-6 shadow-sm space-y-4 hover:shadow-md transition">
              <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-brand-border gap-2 text-xs font-body">
                <div>
                  <span class="text-brand-muted">Order ID:</span>
                  <span class="font-bold text-brand-navy font-heading text-sm ml-1">${o.id}</span>
                  <span class="text-brand-muted ml-3">• Placed on ${o.date}</span>
                </div>
                <div class="flex items-center gap-2">
                  <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase font-heading border ${statusClass}">${o.status}</span>
                </div>
              </div>

              <!-- Item rows -->
              <div class="space-y-3">
                ${o.items.map(item => `
                  <div class="flex items-center gap-4 text-xs font-body">
                    <img src="${item.image}" alt="${item.name}" class="w-14 h-14 object-contain rounded-2xl bg-soft-blue/40 p-1.5 border border-brand-border shrink-0">
                    <div class="flex-1 min-w-0">
                      <h4 class="font-bold text-brand-navy truncate hover:text-brand-orange transition font-heading">
                        <a href="${base}product?slug=${item.slug}">${item.name}</a>
                      </h4>
                      <div class="text-[11px] text-brand-muted mt-0.5 font-medium">Quantity: ${item.quantity} × ₹${item.price.toLocaleString()}</div>
                    </div>
                    <div class="text-right">
                      <span class="font-bold text-brand-navy font-heading text-sm">₹${(item.price * item.quantity).toLocaleString()}</span>
                    </div>
                  </div>
                `).join('')}
              </div>

              <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-3 border-t border-brand-border gap-3 text-xs">
                <div>
                  <span class="text-brand-muted">Total:</span>
                  <span class="font-bold text-brand-navy text-base font-heading ml-1">₹${o.total.toLocaleString()}</span>
                  <span class="text-[11px] text-brand-muted ml-1 font-medium">(${o.paymentMethod})</span>
                </div>

                <div class="flex items-center gap-2">
                  <a href="${base}account/order-detail?orderId=${o.id}" class="px-4 py-2 bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-blue font-bold font-heading rounded-xl transition">
                    View Details
                  </a>
                  <a href="${base}account/track-order?orderId=${o.id}" class="px-4 py-2 bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading rounded-xl shadow-xs transition flex items-center gap-1.5">
                    <i class="fa-solid fa-truck-fast text-xs"></i>
                    <span>Track Shipment</span>
                  </a>
                </div>
              </div>
            </div>
          `;
        }).join('');
      };

      document.querySelectorAll('.order-filter-pill').forEach(btn => {
        btn.onclick = () => {
          document.querySelectorAll('.order-filter-pill').forEach(b => {
            b.className = 'order-filter-pill px-3.5 py-1.5 rounded-full bg-white border border-brand-border text-brand-navy hover:bg-soft-yellow transition cursor-pointer';
          });
          btn.className = 'order-filter-pill active px-3.5 py-1.5 rounded-full bg-brand-navy text-white transition cursor-pointer';
          renderOrders(btn.getAttribute('data-status'));
        };
      });

      renderOrders('all');
    });
  </script>
@endpush