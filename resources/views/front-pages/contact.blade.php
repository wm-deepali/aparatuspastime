@extends('layouts.app')

@section('title', 'Contact Us | Aparatus Pastime - Kids Toys & Sports')
@section('meta_description', 'Have a question about an order, gift bundle or product? Contact the Aparatus Pastime team.')
@section('active_nav', 'contact')

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

      <!-- 3 COLORFUL CONTACT CARDS -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 sm:gap-4 lg:gap-6">

        <!-- CALL US CARD -->
        <a href="tel:+919876543210" class="group bg-gradient-to-br from-blue-50 to-[#EDF5FD] rounded-3xl border border-blue-200/90 p-4 sm:p-4.5 xl:p-6 flex items-center gap-3 sm:gap-3.5 xl:gap-4 shadow-2xs hover:shadow-md hover:border-blue-300 transition-all duration-200">
          <div class="w-11 h-11 sm:w-12 sm:h-12 xl:w-14 xl:h-14 rounded-2xl bg-brand-blue text-white flex items-center justify-center text-lg sm:text-xl xl:text-2xl shrink-0 shadow-2xs group-hover:scale-105 transition duration-200">
            <i class="fa-solid fa-phone"></i>
          </div>
          <div class="min-w-0 flex-1">
            <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-brand-blue font-heading block">CALL US</span>
            <div class="font-heading font-extrabold text-sm sm:text-base lg:text-[15px] xl:text-lg text-dark-navy group-hover:text-brand-blue transition whitespace-nowrap leading-snug">
              +91 98765 43210
            </div>
            <p class="text-[10px] sm:text-xs text-brand-muted font-sans truncate leading-tight mt-0.5">Mon–Sat: 9 AM – 7 PM IST</p>
          </div>
        </a>

        <!-- EMAIL US CARD -->
        <a href="mailto:support@aparatus.com" class="group bg-gradient-to-br from-orange-50 to-[#FFF4EC] rounded-3xl border border-orange-200/90 p-4 sm:p-4.5 xl:p-6 flex items-center gap-3 sm:gap-3.5 xl:gap-4 shadow-2xs hover:shadow-md hover:border-orange-300 transition-all duration-200">
          <div class="w-11 h-11 sm:w-12 sm:h-12 xl:w-14 xl:h-14 rounded-2xl bg-brand-orange text-white flex items-center justify-center text-lg sm:text-xl xl:text-2xl shrink-0 shadow-2xs group-hover:scale-105 transition duration-200">
            <i class="fa-solid fa-envelope"></i>
          </div>
          <div class="min-w-0 flex-1">
            <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-brand-orange font-heading block">EMAIL US</span>
            <div class="font-heading font-extrabold text-xs sm:text-sm lg:text-[13px] xl:text-base text-dark-navy group-hover:text-brand-orange transition whitespace-nowrap leading-snug" title="support@aparatus.com">
              support@aparatus.com
            </div>
            <p class="text-[10px] sm:text-xs text-brand-muted font-sans truncate leading-tight mt-0.5">Fast response within 24h</p>
          </div>
        </a>

        <!-- VISIT US CARD -->
        <div class="group bg-gradient-to-br from-amber-50 to-[#FFFBEA] rounded-3xl border border-amber-200/90 p-4 sm:p-4.5 xl:p-6 flex items-center gap-3 sm:gap-3.5 xl:gap-4 shadow-2xs hover:shadow-md hover:border-amber-300 transition-all duration-200">
          <div class="w-11 h-11 sm:w-12 sm:h-12 xl:w-14 xl:h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-lg sm:text-xl xl:text-2xl shrink-0 shadow-2xs group-hover:scale-105 transition duration-200">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          <div class="min-w-0 flex-1">
            <span class="text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-amber-700 font-heading block">VISIT US</span>
            <div class="font-heading font-extrabold text-xs sm:text-sm lg:text-[13px] xl:text-base text-dark-navy leading-snug whitespace-nowrap">
              Sector 62, Noida
            </div>
            <p class="text-[10px] sm:text-xs text-brand-muted font-sans truncate leading-tight mt-0.5">Uttar Pradesh - 201309</p>
          </div>
        </div>

      </div>

      <!-- DIRECT MESSAGE FORM -->
      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-xs space-y-6 max-w-4xl mx-auto">
        <h2 class="font-heading font-bold text-xl text-dark-navy pb-3 border-b border-brand-border">
          Send Us a Direct Message
        </h2>

        <form id="contact-form" class="space-y-4 text-xs font-sans">
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
              <select id="contact-subject" name="subject" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none font-sans cursor-pointer">
                <option value="Product Inquiry">Product Inquiry / Age Advice</option>
                <option value="Order Status">Order Status & Tracking</option>
                <option value="Returns & Exchanges">Returns & Exchanges</option>
                <option value="Bulk / Gifting Orders">Bulk & Birthday Gifting</option>
                <option value="Other">Other Question</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block font-bold text-dark-navy mb-1.5 font-heading">Your Message *</label>
            <textarea id="contact-message" name="message" rows="4" required placeholder="Tell us how we can help make playtime better..." class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-sans"></textarea>
          </div>

          <div>
            <button type="submit" class="btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-md transition cursor-pointer font-heading">
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
      document.getElementById('contact-form')?.addEventListener('submit', (e) => {
        e.preventDefault();
        Components.showToast('Thank you! Your message has been sent. We will reply shortly.', 'success');
        e.target.reset();
      });
    });
  </script>
@endpush