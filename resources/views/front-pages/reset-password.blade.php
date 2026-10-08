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
            Please choose a strong, secure password with at least 6 characters.
          </p>
        </div>

        <form id="reset-pw-form" class="space-y-4 text-xs font-body relative z-10">
          @csrf
          <div>
            <label class="block font-bold text-brand-navy mb-1.5 font-heading">New Password *</label>
            <input type="password" id="new-pw" name="password" required minlength="6" placeholder="••••••••" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
          </div>

          <div>
            <label class="block font-bold text-brand-navy mb-1.5 font-heading">Confirm New Password *</label>
            <input type="password" id="confirm-new-pw" name="password_confirmation" required minlength="6" placeholder="••••••••" class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
            <p id="reset-pw-error" class="hidden mt-1.5 text-[11px] font-bold text-red-500 font-heading">Passwords do not match.</p>
          </div>

          <button type="submit" class="w-full bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-sm py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition">
            UPDATE PASSWORD
          </button>
        </form>

        <div class="text-center pt-2 text-xs text-brand-muted relative z-10">
          <a href="{{ route('login') }}" class="text-brand-blue hover:text-brand-orange font-bold font-heading">Back to Sign In →</a>
        </div>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const loginUrl = @json(route('login'));
      const errorEl = document.getElementById('reset-pw-error');

      document.getElementById('reset-pw-form').addEventListener('submit', (e) => {
        e.preventDefault();
        const p1 = document.getElementById('new-pw').value;
        const p2 = document.getElementById('confirm-new-pw').value;

        if (p1 !== p2) {
          errorEl.classList.remove('hidden');
          return;
        }
        errorEl.classList.add('hidden');

        Components.showToast('Your password has been successfully updated!', 'success');
        setTimeout(() => { window.location.href = loginUrl; }, 600);
      });
    });
  </script>
@endpush