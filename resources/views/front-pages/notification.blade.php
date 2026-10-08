@extends('layouts.app')

@section('title', 'Notifications | Aparatus Pastime')
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
        <span class="text-brand-navy font-bold">Notifications</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('front-pages._sidebar', ['active' => 'notifications'])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="pb-4 border-b border-brand-border">
            <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Notifications & Alerts</h1>
            <p class="text-xs text-brand-muted font-body mt-1">Delivery updates, milestone alerts, and promotional playtime drops.</p>
          </div>

          <div id="notifications-list" class="space-y-3">
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
      const notifs = State.getNotifications();
      const container = document.getElementById('notifications-list');

      container.innerHTML = notifs.map(n => `
        <div class="bg-white rounded-3xl border ${!n.read ? 'border-brand-orange/40 bg-soft-orange/30 shadow-sm' : 'border-brand-border shadow-xs'} p-5 flex items-start justify-between gap-4">
          <div class="flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-2xl ${n.type === 'order' ? 'bg-soft-blue text-brand-blue' : 'bg-soft-orange text-brand-orange'} flex items-center justify-center shrink-0 text-sm">
              <i class="fa-solid ${n.type === 'order' ? 'fa-truck-fast' : 'fa-bullhorn'}"></i>
            </div>
            <div>
              <h4 class="font-heading font-bold text-sm text-brand-navy">${n.title}</h4>
              <p class="text-xs text-body-text mt-0.5 font-body leading-relaxed">${n.message}</p>
              <span class="text-[10px] text-brand-muted mt-1 block font-medium">${n.time}</span>
            </div>
          </div>
          ${!n.read ? '<span class="w-2.5 h-2.5 rounded-full bg-brand-orange shrink-0 mt-2 animate-pulse"></span>' : ''}
        </div>
      `).join('');
    });
  </script>
@endpush