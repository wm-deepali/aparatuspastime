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
        <a href="{{ route('account.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">Profile Details</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('front-pages._sidebar', ['active' => 'profile'])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-8 shadow-sm space-y-6 max-w-2xl">
            <div class="pb-4 border-b border-brand-border">
              <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-orange font-heading bg-soft-orange px-3 py-1 rounded-full border border-brand-orange/20 mb-2">
                APARATUS PROFILE
              </span>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Personal Profile</h1>
              <p class="text-xs text-brand-muted font-body mt-1">Update your basic contact details and account preferences.</p>
            </div>

            <form id="profile-form" class="space-y-4 text-xs font-body">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block font-bold text-brand-navy mb-1.5 font-heading">First Name *</label>
                  <input type="text" id="prof-fname" required class="w-full px-4 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
                </div>
                <div>
                  <label class="block font-bold text-brand-navy mb-1.5 font-heading">Last Name *</label>
                  <input type="text" id="prof-lname" required class="w-full px-4 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
                </div>
              </div>

              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">Email Address *</label>
                <input type="email" id="prof-email" required class="w-full px-4 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div>
                <label class="block font-bold text-brand-navy mb-1.5 font-heading">Phone Number (with WhatsApp delivery notifications) *</label>
                <input type="tel" id="prof-phone" required class="w-full px-4 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
              </div>

              <div class="pt-2">
                <button type="submit" class="bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-xs py-3.5 px-6 rounded-2xl shadow transition cursor-pointer">
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
    import { State } from '{{ asset("assets/js/state.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const user = State.getUser();
      document.getElementById('prof-fname').value = user.firstName || '';
      document.getElementById('prof-lname').value = user.lastName || '';
      document.getElementById('prof-email').value = user.email || '';
      document.getElementById('prof-phone').value = user.phone || '';

      document.getElementById('profile-form').onsubmit = (e) => {
        e.preventDefault();
        const updated = {
          ...user,
          firstName: document.getElementById('prof-fname').value,
          lastName: document.getElementById('prof-lname').value,
          email: document.getElementById('prof-email').value,
          phone: document.getElementById('prof-phone').value
        };
        State.saveUser(updated);
        Components.showToast('Profile information saved!', 'success');
      };
    });
  </script>
@endpush