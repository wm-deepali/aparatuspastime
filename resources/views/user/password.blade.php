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
        <a href="{{ route('user.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">Change Password</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('user._sidebar', ['active' => 'password'])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-8 shadow-sm space-y-6 max-w-xl">
            <div class="pb-4 border-b border-brand-border">
              <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue font-heading bg-soft-blue px-3 py-1 rounded-full border border-sky-blue/30 mb-2">
                ACCOUNT SECURITY
              </span>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Change Password</h1>
              <p class="text-xs text-brand-muted font-body mt-1">For security, choose a strong password with at least 8 characters.</p>
            </div>

            @if($customer->google_id)
              <div class="p-4 rounded-2xl bg-soft-blue/50 border border-sky-blue/30 text-xs font-body text-brand-navy">
                Signed up with Google and never set a password?
                <a href="{{ route('forgot-password') }}" class="font-bold text-brand-blue underline font-heading">Set one via Forgot Password</a>.
              </div>
            @endif

            <form id="cp-form" class="space-y-4 text-xs font-body" novalidate>
              @csrf
              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">Current Password *</label>
                <input type="password" name="current_password" required placeholder="••••••••" autocomplete="current-password" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">New Password *</label>
                <input type="password" name="password" required minlength="8" placeholder="••••••••" autocomplete="new-password" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">Confirm New Password *</label>
                <input type="password" name="password_confirmation" required minlength="8" placeholder="••••••••" autocomplete="new-password" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <p id="cp-error" class="hidden text-red-600 font-semibold"></p>

              <div class="pt-2">
                <button type="submit" id="cp-btn" class="bg-brand-navy hover:bg-brand-orange text-white font-bold font-heading text-xs py-3.5 px-6 rounded-2xl shadow transition cursor-pointer disabled:opacity-60">
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
      const form = document.getElementById('cp-form');
      const btn = document.getElementById('cp-btn');
      const errorEl = document.getElementById('cp-error');

      const showError = (msg) => {
        errorEl.textContent = msg;
        errorEl.classList.remove('hidden');
      };

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorEl.classList.add('hidden');

        const fd = new FormData(form);

        if (fd.get('password').length < 8) return showError('New password must be at least 8 characters.');
        if (fd.get('password') !== fd.get('password_confirmation')) return showError('New passwords do not match.');

        btn.disabled = true;
        btn.textContent = 'UPDATING...';

        try {
          const res = await fetch(@json(route('user.password.update')), {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': fd.get('_token'),
            },
            body: fd,
          });
          const data = await res.json().catch(() => ({}));

          if (res.ok) {
            Components.showToast(data.message, 'success');
            form.reset();
          } else {
            const first = data.errors ? Object.values(data.errors)[0][0] : null;
            showError(first || data.message || 'Could not update password. Please try again.');
          }
        } catch (err) {
          showError('Network error. Please try again.');
        }

        btn.disabled = false;
        btn.textContent = 'UPDATE PASSWORD';
      });
    });
  </script>
@endpush