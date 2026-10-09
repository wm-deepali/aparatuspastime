@extends('layouts.app')

@section('title', 'Forgot Password | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-12 md:py-16">
    <div class="max-w-md mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-8 shadow-xl space-y-6 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-24 h-24 bg-soft-yellow rounded-full -z-0 opacity-70 pointer-events-none"></div>

        <div class="text-center space-y-2 relative z-10">
          <div class="w-16 h-16 rounded-full bg-soft-blue text-brand-blue flex items-center justify-center text-2xl mx-auto border border-sky-blue/30 shadow-xs">
            <i class="fa-solid fa-key text-brand-blue"></i>
          </div>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Forgot Password?</h1>
          <p class="text-xs text-brand-muted font-body">
            Enter your registered email address and we'll send you a password reset link to get back to playing!
          </p>
        </div>

        <div id="forgot-success-alert" class="hidden p-4 rounded-2xl bg-soft-mint border border-mint text-dark-navy text-xs font-body space-y-2 relative z-10">
          <div class="font-bold font-heading flex items-center gap-1.5 text-emerald-800">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            <span>Reset Link Sent</span>
          </div>
          <p id="forgot-success-msg">Check your inbox for password reset instructions.</p>
        </div>

        <form id="forgot-form" class="space-y-4 text-xs font-body relative z-10" novalidate>
          @csrf
          <div>
            <label class="block font-bold text-brand-navy mb-1.5 font-heading">Registered Email Address</label>
            <input type="email" id="forgot-email" name="email" required placeholder="name@example.com"
                   value="{{ old('email') }}"
                   class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
            <p id="forgot-error" class="hidden text-red-600 font-semibold mt-1.5"></p>
          </div>

          <button type="submit" id="forgot-btn"
                  class="w-full bg-brand-navy hover:bg-brand-orange text-white font-bold font-heading text-sm py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition disabled:opacity-60">
            SEND RESET LINK
          </button>
        </form>

        <div class="text-center pt-2 text-xs text-brand-muted relative z-10">
          Remember your password?
          <a href="{{ route('user.login') }}" class="text-brand-orange hover:text-brand-bright-orange font-bold font-heading ml-1">Back to Sign In →</a>
        </div>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('forgot-form');
      const btn = document.getElementById('forgot-btn');
      const errorEl = document.getElementById('forgot-error');
      const successBox = document.getElementById('forgot-success-alert');

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorEl.classList.add('hidden');
        btn.disabled = true;
        btn.textContent = 'SENDING...';

        try {
          const res = await fetch(@json(route('forgot-password.send')), {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
            },
            body: JSON.stringify({ email: document.getElementById('forgot-email').value }),
          });
          const data = await res.json();

          if (res.ok) {
            document.getElementById('forgot-success-msg').textContent = data.message;
            form.classList.add('hidden');
            successBox.classList.remove('hidden');
            Components.showToast('Password reset link sent!', 'success');
          } else {
            const msg = data.errors?.email?.[0] || data.message || 'Something went wrong. Please try again.';
            errorEl.textContent = msg;
            errorEl.classList.remove('hidden');
          }
        } catch (err) {
          errorEl.textContent = 'Network error. Please try again.';
          errorEl.classList.remove('hidden');
        } finally {
          btn.disabled = false;
          btn.textContent = 'SEND RESET LINK';
        }
      });
    });
  </script>
@endpush