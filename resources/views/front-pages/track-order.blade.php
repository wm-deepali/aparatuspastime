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
        <a href="{{ route('account.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">Track Order</span>
      </nav>

      <!-- TRACKING LOOKUP CARD -->
      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-28 h-28 bg-soft-blue rounded-full -z-0 opacity-70 pointer-events-none"></div>

        <div class="text-center space-y-2 max-w-lg mx-auto relative z-10">
          <div class="w-16 h-16 rounded-full bg-soft-blue text-brand-blue flex items-center justify-center text-2xl mx-auto border border-sky-blue/40 shadow-xs">
            <i class="fa-solid fa-truck-fast"></i>
          </div>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Track Your Play Package</h1>
          <p class="text-xs sm:text-sm text-brand-muted font-body leading-relaxed">
            Enter your Order ID (from your confirmation email/SMS) and phone number to view real-time delivery milestones.
          </p>
        </div>

        <form id="track-order-form" class="grid grid-cols-1 sm:grid-cols-12 gap-3 max-w-2xl mx-auto text-xs font-body relative z-10">
          <div class="sm:col-span-5">
            <label class="block font-bold text-brand-navy mb-1.5 font-heading">Order Number *</label>
            <input type="text" id="track-input-id" required value="AP-2026-89421" placeholder="E.g. AP-2026-89421" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-bold text-brand-navy">
          </div>
          <div class="sm:col-span-4">
            <label class="block font-bold text-brand-navy mb-1.5 font-heading">Phone or Email *</label>
            <input type="text" id="track-input-contact" required value="+91 98765 43210" placeholder="Phone or Email" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
          </div>
          <div class="sm:col-span-3 flex items-end">
            <button type="submit" class="w-full bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-xs py-3.5 px-4 rounded-xl shadow transition cursor-pointer">
              TRACK ORDER
            </button>
          </div>
        </form>
      </div>

      <!-- RESULTS TIMELINE CONTAINER -->
      <div id="tracking-results-card" class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-brand-border gap-2">
          <div>
            <span class="text-xs text-brand-muted font-body">Tracking result for package:</span>
            <h2 class="text-xl font-extrabold font-heading text-brand-navy" id="tr-order-id">AP-2026-89421</h2>
          </div>
          <div class="flex items-center gap-2">
            <span id="tr-status-tag" class="px-3.5 py-1 rounded-full text-xs font-bold font-heading uppercase bg-soft-mint text-emerald-800 border border-mint">
              Delivered
            </span>
          </div>
        </div>

        <!-- Visual Milestone Progress -->
        <div class="space-y-3">
          <h3 class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
            <i class="fa-solid fa-route text-brand-orange"></i>
            LIVE TRANSIT STATUS
          </h3>
          <div id="tr-milestones" class="space-y-4 pt-2">
            <!-- Injected via JavaScript -->
          </div>
        </div>

        <!-- Courier details -->
        <div class="p-4 bg-soft-blue rounded-2xl border border-sky-blue/40 text-xs font-body flex flex-col sm:flex-row sm:items-center justify-between gap-3">
          <div class="space-y-0.5">
            <span class="text-brand-muted block text-[11px] font-medium">Courier Partner:</span>
            <span class="font-bold text-brand-navy font-heading">BlueDart Express (AWB #889210459)</span>
          </div>
          <a href="{{ route('contact') }}" class="text-brand-blue hover:text-brand-orange font-bold font-heading self-start sm:self-auto">
            Need Help With Delivery? →
          </a>
        </div>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { State } from '{{ asset("assets/js/state.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const urlParams = new URLSearchParams(window.location.search);
      const paramId = urlParams.get('orderId');
      if (paramId) {
        document.getElementById('track-input-id').value = paramId;
      }

      const resultsCard = document.getElementById('tracking-results-card');
      const orderIdEl = document.getElementById('tr-order-id');
      const statusTag = document.getElementById('tr-status-tag');
      const milestonesEl = document.getElementById('tr-milestones');

      const track = (id) => {
        const order = State.getOrderById(id) || State.getOrders()[0];
        if (order) {
          resultsCard.classList.remove('hidden');
          orderIdEl.textContent = order.id;
          statusTag.textContent = order.status;
          statusTag.className = order.status === 'Delivered'
            ? 'px-3.5 py-1 rounded-full text-xs font-bold font-heading uppercase bg-soft-mint text-emerald-800 border border-mint'
            : 'px-3.5 py-1 rounded-full text-xs font-bold font-heading uppercase bg-soft-blue text-brand-blue border border-sky-blue';

          milestonesEl.innerHTML = order.timeline.map((step, idx) => `
            <div class="flex items-start gap-4">
              <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full ${step.done ? 'bg-emerald-600 text-white shadow-xs' : 'bg-gray-200 text-gray-400'} flex items-center justify-center text-xs font-bold shrink-0">
                  <i class="fa-solid ${step.done ? 'fa-check' : 'fa-circle'}"></i>
                </div>
                ${idx < order.timeline.length - 1 ? `<div class="w-0.5 h-10 ${step.done ? 'bg-emerald-500' : 'bg-gray-200'}"></div>` : ''}
              </div>
              <div class="pt-1 text-xs font-body">
                <div class="font-bold font-heading text-sm text-brand-navy">${step.status}</div>
                <div class="text-brand-muted text-[11px] mt-0.5">${step.date}</div>
              </div>
            </div>
          `).join('');
        }
      };

      document.getElementById('track-order-form')?.addEventListener('submit', (e) => {
        e.preventDefault();
        const id = document.getElementById('track-input-id').value.trim();
        track(id);
      });

      track(paramId || 'AP-2026-89421');
    });
  </script>
@endpush