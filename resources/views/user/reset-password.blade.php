@extends('layouts.app')

@section('title', 'Reset Password | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-12 md:py-16">
    <div class="max-w-md mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-8 shadow-xl space-y-6 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-soft-orange rounded-full -z-0 opacity-70 pointer-events-none"></div>

        <div class="text-center space-y-2 relative z-10">
          <div class="w-16 h-16 rounded-full bg-soft-orange text-brand-orange flex items-center justify-center text-2xl mx-auto border border-brand-orange/30 shadow-xs">
            <i class="fa-solid fa-lock"></i>
          </div>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Set New Password</h1>
          <p class="text-xs text-brand-muted font-body">
            Please choose a strong, secure password with at least 8 characters.
          </p>
        </div>

        <form id="reset-pw-form" class="space-y-4 text-xs font-body relative z-10" novalidate>
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">
          <input type="hidden" name="email" value="{{ $email }}">

          <div>
            <label class="block font-bold text-brand-navy mb-1.5 font-heading">New Password *</label>
            <input type="password" id="new-pw" name="password" required minlength="8" placeholder="••••••••" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
          </div>

          <div>
            <label class="block font-bold text-brand-navy mb-1.5 font-heading">Confirm New Password *</label>
            <input type="password" id="confirm-new-pw" name="password_confirmation" required minlength="8" placeholder="••••••••" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
            <p id="reset-pw-error" class="hidden mt-1.5 text-[11px] font-bold text-red-500 font-heading"></p>
          </div>

          <button type="submit" id="reset-pw-btn" class="w-full bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-sm py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition disabled:opacity-60">
            UPDATE PASSWORD
          </button>
        </form>

        <div class="text-center pt-2 text-xs text-brand-muted relative z-10 space-x-3">
          <a href="{{ route('forgot-password') }}" class="text-brand-blue hover:text-brand-orange font-bold font-heading">Request new link</a>
          <a href="{{ route('user.login') }}" class="text-brand-blue hover:text-brand-orange font-bold font-heading">Back to Sign In →</a>
        </div>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('reset-pw-form');
      const btn = document.getElementById('reset-pw-btn');
      const errorEl = document.getElementById('reset-pw-error');

      const showError = (msg) => {
        errorEl.textContent = msg;
        errorEl.classList.remove('hidden');
      };

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorEl.classList.add('hidden');

        const p1 = document.getElementById('new-pw').value;
        const p2 = document.getElementById('confirm-new-pw').value;

        if (p1.length < 8) return showError('Password must be at least 8 characters.');
        if (p1 !== p2) return showError('Passwords do not match.');

        btn.disabled = true;
        btn.textContent = 'UPDATING...';

        const fd = new FormData(form);

        try {
          const res = await fetch(@json(route('reset-password.update')), {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': fd.get('_token'),
            },
            body: fd,
          });
          const data = await res.json();

          if (res.ok) {
            Components.showToast(data.message, 'success');
            setTimeout(() => { window.location.href = data.redirect; }, 1000);
            return;
          }

          const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
          showError(firstError || data.message || 'Something went wrong. Please try again.');
        } catch (err) {
          showError('Network error. Please try again.');
        }

        btn.disabled = false;
        btn.textContent = 'UPDATE PASSWORD';
      });
    });
  </script>
@endpush