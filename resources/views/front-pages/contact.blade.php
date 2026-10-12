@extends('layouts.app')

@section('active_nav', 'contact')

@php
    $telHref   = $setting->phone ? 'tel:' . preg_replace('/[^\d+]/', '', $setting->phone) : null;
    $mapUrl    = $setting->google_map_url;
    $addrTitle = $setting->address_short ?: \Illuminate\Support\Str::limit($setting->business_address, 40);
@endphp

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 space-y-8">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted font-heading">
        <a href="{{ url('/') }}" class="hover:text-brand-orange transition">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-dark-navy font-bold">Contact</span>
      </nav>

      <!-- HERO HEADER -->
      <div class="text-center max-w-xl mx-auto space-y-2">
        <span class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
          <i class="fa-solid fa-headset text-brand-blue mr-1"></i>CUSTOMER CARE
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-dark-navy">
          LET'S TALK
        </h1>
        <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed">
          Have a question about an order or product? We're happy to help.
        </p>
      </div>

      <!-- CONTACT CARDS -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 sm:gap-4 lg:gap-6">

        <!-- CALL US CARD -->
        @if ($telHref)
        <a href="{{ $telHref }}" class="group bg-gradient-to-br from-blue-50 to-[#EDF5FD] rounded-3xl border border-blue-200/90 p-4 sm:p-4.5 xl:p-6 flex items-center gap-3 sm:gap-3.5 xl:gap-4 shadow-2xs hover:shadow-md hover:border-blue-300 transition-all duration-200">
          <div class="w-11 h-11 sm:w-12 sm:h-12 xl:w-14 xl:h-14 rounded-2xl bg-brand-blue text-white flex items-center justify-center text-lg sm:text-xl xl:text-2xl shrink-0 shadow-2xs group-hover:scale-105 transition duration-200">
            <i class="fa-solid fa-phone"></i>
          </div>
          <div class="min-w-0 flex-1">
            <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-brand-blue font-heading block">CALL US</span>
            <div class="font-heading font-extrabold text-sm sm:text-base lg:text-[15px] xl:text-lg text-dark-navy group-hover:text-brand-blue transition whitespace-nowrap leading-snug">
              {{ $setting->phone }}
            </div>
            @if ($setting->working_hours)
            <p class="text-[10px] sm:text-xs text-brand-muted font-sans truncate leading-tight mt-0.5">{{ $setting->working_hours }}</p>
            @endif
          </div>
        </a>
        @endif

        <!-- EMAIL US CARD -->
        @if ($setting->support_email)
        <a href="mailto:{{ $setting->support_email }}" class="group bg-gradient-to-br from-orange-50 to-[#FFF4EC] rounded-3xl border border-orange-200/90 p-4 sm:p-4.5 xl:p-6 flex items-center gap-3 sm:gap-3.5 xl:gap-4 shadow-2xs hover:shadow-md hover:border-orange-300 transition-all duration-200">
          <div class="w-11 h-11 sm:w-12 sm:h-12 xl:w-14 xl:h-14 rounded-2xl bg-brand-orange text-white flex items-center justify-center text-lg sm:text-xl xl:text-2xl shrink-0 shadow-2xs group-hover:scale-105 transition duration-200">
            <i class="fa-solid fa-envelope"></i>
          </div>
          <div class="min-w-0 flex-1">
            <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-brand-orange font-heading block">EMAIL US</span>
            <div class="font-heading font-extrabold text-xs sm:text-sm lg:text-[13px] xl:text-base text-dark-navy group-hover:text-brand-orange transition whitespace-nowrap leading-snug" title="{{ $setting->support_email }}">
              {{ $setting->support_email }}
            </div>
            @if ($setting->email_response_note)
            <p class="text-[10px] sm:text-xs text-brand-muted font-sans truncate leading-tight mt-0.5">{{ $setting->email_response_note }}</p>
            @endif
          </div>
        </a>
        @endif

        <!-- VISIT US CARD -->
        @if ($setting->business_address || $setting->address_short)
        <{{ $mapUrl ? 'a' : 'div' }} @if ($mapUrl) href="{{ $mapUrl }}" target="_blank" rel="noopener" @endif class="group bg-gradient-to-br from-amber-50 to-[#FFFBEA] rounded-3xl border border-amber-200/90 p-4 sm:p-4.5 xl:p-6 flex items-center gap-3 sm:gap-3.5 xl:gap-4 shadow-2xs hover:shadow-md hover:border-amber-300 transition-all duration-200">
          <div class="w-11 h-11 sm:w-12 sm:h-12 xl:w-14 xl:h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-lg sm:text-xl xl:text-2xl shrink-0 shadow-2xs group-hover:scale-105 transition duration-200">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          <div class="min-w-0 flex-1">
            <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-amber-700 font-heading block">VISIT US</span>
            <div class="font-heading font-extrabold text-xs sm:text-sm lg:text-[13px] xl:text-base text-dark-navy leading-snug whitespace-nowrap">
              {{ $addrTitle }}
            </div>
            @if ($setting->business_address)
            <p class="text-[10px] sm:text-xs text-brand-muted font-sans truncate leading-tight mt-0.5" title="{{ $setting->business_address }}">{{ $setting->business_address }}</p>
            @endif
          </div>
        </{{ $mapUrl ? 'a' : 'div' }}>
        @endif

      </div>

      <!-- DIRECT MESSAGE FORM -->
      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-xs space-y-6 max-w-4xl mx-auto">
        <h2 class="font-heading font-bold text-xl text-dark-navy pb-3 border-b border-brand-border">
          Send Us a Direct Message
        </h2>

        <form id="contact-form" action="{{ route('contact.store') }}" method="POST" class="space-y-4 text-xs font-sans">
          @csrf
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-bold text-dark-navy mb-1.5 font-heading">Your Full Name *</label>
              <input type="text" id="contact-name" name="name" required placeholder="Aarav Sharma" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-sans">
            </div>
            <div>
              <label class="block font-bold text-dark-navy mb-1.5 font-heading">Email Address *</label>
              <input type="email" id="contact-email" name="email" required placeholder="name@example.com" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-sans">
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-bold text-dark-navy mb-1.5 font-heading">Phone Number</label>
              <input type="tel" id="contact-phone" name="phone" placeholder="+91 98765 43210" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-sans">
            </div>
            <div>
              <label class="block font-bold text-dark-navy mb-1.5 font-heading">Subject *</label>
              <select id="contact-subject" name="subject" required class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none font-sans cursor-pointer">
                @foreach ($subjects as $subject)
                  <option value="{{ $subject }}">{{ $subject }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div>
            <label class="block font-bold text-dark-navy mb-1.5 font-heading">Your Message *</label>
            <textarea id="contact-message" name="message" rows="4" required placeholder="Tell us how we can help make playtime better..." class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-sans"></textarea>
          </div>

          <div>
            <button type="submit" id="contact-submit" class="btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-md transition cursor-pointer font-heading">
              SEND MESSAGE →
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('contact-form');
      const btn  = document.getElementById('contact-submit');
      if (!form) return;

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const label = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'SENDING...';

        try {
          const res = await fetch(form.action, {
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            },
            body: new FormData(form)
          });
          const data = await res.json().catch(() => ({}));

          if (res.ok) {
            Components.showToast(data.message || 'Thank you! Your message has been sent.', 'success');
            form.reset();
          } else if (res.status === 422 && data.errors) {
            const first = Object.values(data.errors)[0][0];
            Components.showToast(first, 'error');
          } else {
            Components.showToast('Something went wrong. Please try again.', 'error');
          }
        } catch (err) {
          Components.showToast('Network error. Please try again.', 'error');
        } finally {
          btn.disabled = false;
          btn.innerHTML = label;
        }
      });
    });
  </script>
@endpush