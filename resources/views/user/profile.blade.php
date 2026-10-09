@extends('layouts.app')

@section('title', 'Profile Details | Aparatus Pastime')
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
        <span class="text-brand-navy font-bold">Profile Details</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('user._sidebar', ['active' => 'profile'])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-8 shadow-sm space-y-6 max-w-3xl">
            <div class="pb-4 border-b border-brand-border">
              <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-orange font-heading bg-soft-orange px-3 py-1 rounded-full border border-brand-orange/20 mb-2">
                APARATUS PROFILE
              </span>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Personal Profile</h1>
              <p class="text-xs text-brand-muted font-body mt-1">Update your basic contact details and account preferences.</p>
            </div>

            <form id="profile-form" class="space-y-4 text-xs font-body" novalidate>
              @csrf
              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">Full Name *</label>
                <input type="text" name="name" required maxlength="100" value="{{ $customer->name }}" class="w-full px-4 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">Email Address *</label>
                <input type="email" name="email" required value="{{ $customer->email }}" class="w-full px-4 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block font-bold text-brand-navy mb-1.5 font-heading">Phone Number (with WhatsApp delivery notifications) *</label>
                  <input type="tel" name="mobile" required maxlength="10" inputmode="numeric" placeholder="9876543210" value="{{ $mobile }}" class="w-full px-4 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
                </div>
                <div>
                  <label class="block font-bold text-brand-navy mb-1.5 font-heading">Alternate Mobile (optional)</label>
                  <input type="tel" name="alternate_mobile" maxlength="10" inputmode="numeric" placeholder="9876543210" value="{{ $alternateMobile }}" class="w-full px-4 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
                </div>
              </div>

              <p id="profile-error" class="hidden text-red-600 font-semibold"></p>

              <div class="pt-2">
                <button type="submit" id="profile-btn" class="bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-xs py-3.5 px-6 rounded-2xl shadow transition cursor-pointer disabled:opacity-60">
                  SAVE CHANGES
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
      const form = document.getElementById('profile-form');
      const btn = document.getElementById('profile-btn');
      const errorEl = document.getElementById('profile-error');

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorEl.classList.add('hidden');
        btn.disabled = true;
        btn.textContent = 'SAVING...';

        const fd = new FormData(form);

        try {
          const res = await fetch(@json(route('user.profile.update')), {
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
          } else {
            const first = data.errors ? Object.values(data.errors)[0][0] : null;
            errorEl.textContent = first || data.message || 'Could not save profile. Please try again.';
            errorEl.classList.remove('hidden');
          }
        } catch (err) {
          errorEl.textContent = 'Network error. Please try again.';
          errorEl.classList.remove('hidden');
        }

        btn.disabled = false;
        btn.textContent = 'SAVE CHANGES';
      });
    });
  </script>
@endpush