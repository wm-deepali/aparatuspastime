@extends('layouts.app')

@section('title', 'Order Details | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-5xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('account.orders') }}" class="hover:text-brand-orange transition font-semibold">My Orders</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span id="breadcrumb-order-id" class="text-brand-navy font-bold">Order Details</span>
      </nav>

      <!-- ORDER DETAILS CONTAINER -->
      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-8">

        <!-- TOP ROW: TITLE, STATUS & INVOICE PRINT -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-brand-border gap-4">
          <div>
            <div class="flex items-center gap-3">
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">
                Order <span id="detail-order-id">AP-2026-89421</span>
              </h1>
              <span id="detail-status-pill" class="px-3.5 py-1 rounded-full text-xs font-bold font-heading uppercase bg-soft-mint text-emerald-800 border border-mint">
                Delivered
              </span>
            </div>
            <p class="text-xs text-brand-muted mt-1 font-body">
              Placed on <span id="detail-order-date" class="font-bold text-dark-navy">March 24, 2026</span> • Estimated Delivery: <span id="detail-est-date" class="font-bold text-dark-navy">March 28, 2026</span>
            </p>
          </div>

          <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-4 py-2.5 bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-blue font-bold font-heading text-xs rounded-xl transition flex items-center gap-2 cursor-pointer">
              <i class="fa-solid fa-print text-xs"></i>
              <span>Print Invoice</span>
            </button>
            <a id="detail-track-btn" href="{{ route('account.track-order') }}" class="px-4 py-2.5 bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-xs rounded-xl shadow-xs transition flex items-center gap-2">
              <i class="fa-solid fa-truck-fast text-xs"></i>
              <span>Track Order</span>
            </a>
          </div>
        </div>

        <!-- TIMELINE MILESTONE TRACKER -->
        <div class="space-y-4">
          <h2 class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
            <i class="fa-solid fa-route text-brand-orange"></i>
            DELIVERY MILESTONES
          </h2>
          <div id="detail-timeline-container" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
            <!-- Injected via JavaScript -->
          </div>
        </div>

        <!-- ORDERED PRODUCTS LIST -->
        <div class="space-y-4 pt-4 border-t border-brand-border">
          <h2 class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
            <i class="fa-solid fa-box text-brand-blue"></i>
            ITEMS IN THIS SHIPMENT
          </h2>
          <div id="detail-products-list" class="divide-y divide-brand-border">
            <!-- Injected via JavaScript -->
          </div>
        </div>

        <!-- ADDRESSES & PAYMENT BREAKDOWN (3 COLS) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-brand-border text-xs font-body">

          <div class="space-y-2 p-5 bg-soft-blue/40 rounded-2xl border border-sky-blue/30">
            <h3 class="font-heading font-bold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
              <i class="fa-solid fa-location-dot text-brand-blue"></i>
              SHIPPING ADDRESS
            </h3>
            <p id="detail-shipping-addr" class="text-body-text leading-relaxed font-medium"></p>
          </div>

          <div class="space-y-2 p-5 bg-soft-yellow/40 rounded-2xl border border-play-yellow/40">
            <h3 class="font-heading font-bold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
              <i class="fa-solid fa-credit-card text-amber-600"></i>
              PAYMENT METHOD
            </h3>
            <p id="detail-payment-method" class="text-brand-navy font-bold"></p>
            <p class="text-[11px] text-emerald-700 font-bold flex items-center gap-1">
              <i class="fa-solid fa-circle-check"></i> Payment Authorized & Verified
            </p>
          </div>

          <div class="space-y-2 p-5 bg-soft-mint/40 rounded-2xl border border-mint">
            <h3 class="font-heading font-bold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
              <i class="fa-solid fa-receipt text-emerald-700"></i>
              PAYMENT BREAKDOWN
            </h3>
            <div class="space-y-1.5 text-body-text">
              <div class="flex justify-between">
                <span>Subtotal:</span>
                <span id="detail-subtotal" class="font-bold text-brand-navy">₹0</span>
              </div>
              <div class="flex justify-between">
                <span>Discount:</span>
                <span id="detail-discount" class="text-emerald-700 font-bold">-₹0</span>
              </div>
              <div class="flex justify-between">
                <span>Shipping:</span>
                <span id="detail-shipping" class="text-emerald-700 font-bold">FREE</span>
              </div>
              <div class="flex justify-between text-base font-extrabold font-heading text-brand-navy pt-2 border-t border-brand-border">
                <span>Total Amount:</span>
                <span id="detail-total">₹0</span>
              </div>
            </div>
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

      const urlParams = new URLSearchParams(window.location.search);
      const orderId = urlParams.get('orderId');

      const orders = State.getOrders();
      const order = orderId ? orders.find(o => o.id === orderId) : orders[0];

      if (order) {
        document.getElementById('breadcrumb-order-id').textContent = order.id;
        document.getElementById('detail-order-id').textContent = order.id;
        document.getElementById('detail-order-date').textContent = order.date;
        document.getElementById('detail-est-date').textContent = order.estimatedDelivery;
        document.getElementById('detail-track-btn').href = `${base}account/track-order?orderId=${order.id}`;

        const statusPill = document.getElementById('detail-status-pill');
        statusPill.textContent = order.status;
        statusPill.className = order.status === 'Delivered'
          ? 'px-3.5 py-1 rounded-full text-xs font-bold font-heading uppercase bg-soft-mint text-emerald-800 border border-mint'
          : 'px-3.5 py-1 rounded-full text-xs font-bold font-heading uppercase bg-soft-blue text-brand-blue border border-sky-blue';

        // Timeline milestones
        const timelineContainer = document.getElementById('detail-timeline-container');
        if (timelineContainer && order.timeline) {
          timelineContainer.innerHTML = order.timeline.map((step, idx) => `
            <div class="p-3.5 rounded-2xl border ${step.done ? 'bg-soft-mint border-mint' : 'bg-soft-blue/30 border-brand-border opacity-70'} text-xs font-body space-y-1">
              <div class="flex items-center gap-1.5 font-bold font-heading ${step.done ? 'text-emerald-800' : 'text-brand-muted'}">
                <i class="fa-solid ${step.done ? 'fa-circle-check text-emerald-600' : 'fa-circle-notch text-gray-400'}"></i>
                <span>Step ${idx + 1}</span>
              </div>
              <div class="font-bold text-brand-navy font-heading">${step.status}</div>
              <div class="text-[10px] text-brand-muted font-medium">${step.date}</div>
            </div>
          `).join('');
        }

        // Products list
        const prodList = document.getElementById('detail-products-list');
        if (prodList && order.items) {
          prodList.innerHTML = order.items.map(item => `
            <div class="py-4 flex items-center justify-between gap-4 text-xs font-body">
              <div class="flex items-center gap-4">
                <img src="${item.image}" alt="${item.name}" class="w-14 h-14 object-contain rounded-2xl bg-soft-blue/30 p-1.5 border border-brand-border shrink-0">
                <div>
                  <h4 class="font-bold text-brand-navy hover:text-brand-orange transition font-heading text-sm">
                    <a href="${base}product?slug=${item.slug}">${item.name}</a>
                  </h4>
                  <p class="text-[11px] text-brand-muted mt-0.5 font-medium">Unit Price: ₹${item.price.toLocaleString()} × ${item.quantity} Qty</p>
                </div>
              </div>
              <div class="text-right">
                <span class="font-extrabold font-heading text-base text-brand-navy">₹${(item.price * item.quantity).toLocaleString()}</span>
              </div>
            </div>
          `).join('');
        }

        // Address & Payment
        document.getElementById('detail-shipping-addr').innerHTML = `
          <strong>${order.shippingAddress?.name || 'Aarav Sharma'}</strong><br>
          ${order.shippingAddress?.address || 'Flat 402, Lotus Greens, Sector 45, Noida, UP - 201303'}<br>
          Phone: ${order.shippingAddress?.phone || '+91 98765 43210'}
        `;
        document.getElementById('detail-payment-method').textContent = order.paymentMethod;

        // Breakdown
        document.getElementById('detail-subtotal').textContent = `₹${order.subtotal.toLocaleString()}`;
        document.getElementById('detail-discount').textContent = `-₹${(order.discount || 0).toLocaleString()}`;
        document.getElementById('detail-shipping').textContent = order.shipping === 0 ? 'FREE' : `₹${order.shipping}`;
        document.getElementById('detail-total').textContent = `₹${order.total.toLocaleString()}`;
      }
    });
  </script>
@endpush