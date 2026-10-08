@extends('layouts.app')

@section('title', 'Change Password | Aparatus Pastime')
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
        <span class="text-brand-navy font-bold">Change Password</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('front-pages._sidebar', ['active' => 'password'])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-8 shadow-sm space-y-6 max-w-xl">
            <div class="pb-4 border-b border-brand-border">
              <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue font-heading bg-soft-blue px-3 py-1 rounded-full border border-sky-blue/30 mb-2">
                ACCOUNT SECURITY
              </span>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Change Password</h1>
              <p class="text-xs text-brand-muted font-body mt-1">For security, choose a strong password with at least 6 characters.</p>
            </div>

            <form id="cp-form" class="space-y-4 text-xs font-body">
              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">Current Password *</label>
                <input type="password" id="cp-current" required placeholder="••••••••" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">New Password *</label>
                <input type="password" id="cp-new" required minlength="6" placeholder="••••••••" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">Confirm New Password *</label>
                <input type="password" id="cp-confirm" required minlength="6" placeholder="••••••••" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div class="pt-2">
                <button type="submit" class="bg-brand-navy hover:bg-brand-orange text-white font-bold font-heading text-xs py-3.5 px-6 rounded-2xl shadow transition cursor-pointer">
                  UPDATE PASSWORD
                </button>
              </div>
            </form>
          </div>

        </div>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('cp-form').onsubmit = (e) => {
        e.preventDefault();
        const p1 = document.getElementById('cp-new').value;
        const p2 = document.getElementById('cp-confirm').value;
        if (p1 !== p2) {
          alert('New passwords do not match.');
          return;
        }
        Components.showToast('Password updated successfully!', 'success');
        document.getElementById('cp-form').reset();
      };
    });
  </script>
@endpush