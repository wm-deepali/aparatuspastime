@extends('layouts.app')

@section('title', 'Create Account | Aparatus - Sports Goods & Toys')
@section('active_nav', 'account')

@php
  $inputCls = 'w-full pl-10 pr-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 font-medium font-sans transition';
  $errCls = 'hidden mt-1 text-[11px] font-semibold text-red-500 font-sans';
  $googleUrl = route('user.google', array_filter(['redirect' => request('redirect')]));
  $freeShip = (float) ($general->free_shipping_threshold ?? 0);
@endphp

@section('content')
  <div class="relative py-10 md:py-16 overflow-hidden min-h-[calc(100vh-140px)] flex items-center justify-center">

    <div class="absolute top-10 right-1/4 w-96 h-96 bg-soft-orange rounded-full blur-3xl opacity-60 pointer-events-none -z-10 animate-pulse"></div>
    <div class="absolute bottom-5 left-10 w-96 h-96 bg-soft-yellow rounded-full blur-3xl opacity-70 pointer-events-none -z-10"></div>
    <div class="absolute top-1/2 -right-20 w-80 h-80 bg-soft-mint rounded-full blur-3xl opacity-60 pointer-events-none -z-10"></div>

    <div class="hidden xl:flex items-center gap-2 absolute top-20 left-16 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-brand-border text-xs font-bold font-heading text-brand-orange rotate-[-6deg] pointer-events-none z-0"><span class="text-base">🎁</span><span>10% Off First Order</span></div>
    <div class="hidden xl:flex items-center gap-2 absolute bottom-24 left-20 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-brand-border text-xs font-bold font-heading text-emerald-700 rotate-[4deg] pointer-events-none z-0"><span class="text-base">🌱</span><span>Safe & Eco-Friendly</span></div>
    <div class="hidden xl:flex items-center gap-2 absolute top-24 right-16 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-brand-border text-xs font-bold font-heading text-brand-blue rotate-[5deg] pointer-events-none z-0"><span class="text-base">⚽</span><span>Premium Sports Goods</span></div>
    <div class="hidden xl:flex items-center gap-2 absolute bottom-20 right-20 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-brand-border text-xs font-bold font-heading text-purple-700 rotate-[-4deg] pointer-events-none z-0"><span class="text-base">✨</span><span>Creative Quality Toys</span></div>

    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 relative z-10">
      <div class="bg-white rounded-3xl sm:rounded-[32px] border border-brand-border overflow-hidden shadow-2xl grid grid-cols-1 md:grid-cols-12">

        <!-- LEFT PANEL -->
        <div class="hidden md:flex md:col-span-5 flex-col justify-between p-8 lg:p-10 text-white relative overflow-hidden bg-brand-navy select-none min-h-[640px]">
          <img src="https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=1000&q=85"
               alt="Child exploring toys" class="absolute inset-0 w-full h-full object-cover scale-105">
          <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-brand-navy/85 to-brand-navy/60"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-dark-navy/90 via-brand-navy/70 to-transparent"></div>

          <div class="relative z-10 flex items-center justify-between">
            <div class="inline-flex items-center gap-2 bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-2xl shadow-md border border-white/40">
              <img src="{{ asset('assets/logo.png') }}" alt="Aparatus - Sports Goods & Toys" class="h-8 w-auto object-contain">
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-play-yellow text-dark-navy text-[10px] font-extrabold font-heading shadow-md uppercase">
              <i class="fa-solid fa-medal text-brand-orange"></i><span>Sports Goods & Toys</span>
            </span>
          </div>

          <div class="relative z-10 space-y-4 my-auto py-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-play-yellow text-xs font-bold font-heading border border-white/20 uppercase">
              <i class="fa-solid fa-gift text-brand-orange"></i><span>WELCOME TO APARATUS</span>
            </div>
            <h2 class="text-2xl lg:text-3xl font-extrabold font-heading text-white leading-snug drop-shadow-md">Premium Sports Goods & Mindful Toys for Kids</h2>
            <p class="text-xs text-white/90 font-sans leading-relaxed">Create your account for faster checkout, seamless order tracking, and exclusive discounts on sports gear and toys.</p>

            <div class="space-y-3 pt-2">
              <div class="flex items-center gap-3 text-xs text-white/95 font-sans font-medium">
                <span class="w-6 h-6 rounded-full bg-soft-orange text-brand-orange flex items-center justify-center text-xs shrink-0 font-bold shadow-xs"><i class="fa-solid fa-tag"></i></span>
                <span><strong>Flat 10% Off</strong> your 1st order (Code: PLAY10)</span>
              </div>
              <div class="flex items-center gap-3 text-xs text-white/95 font-sans font-medium">
                <span class="w-6 h-6 rounded-full bg-soft-mint text-emerald-700 flex items-center justify-center text-xs shrink-0 font-bold shadow-xs"><i class="fa-solid fa-truck-fast"></i></span>
                <span><strong>Free Express Shipping</strong> on orders above ₹999</span>
              </div>
              <div class="flex items-center gap-3 text-xs text-white/95 font-sans font-medium">
                <span class="w-6 h-6 rounded-full bg-soft-purple text-purple-700 flex items-center justify-center text-xs shrink-0 font-bold shadow-xs"><i class="fa-solid fa-shield-heart"></i></span>
                <span><strong>100% Certified Safe</strong> & Lab Tested Toys</span>
              </div>
              <div class="flex items-center gap-3 text-xs text-white/95 font-sans font-medium">
                <span class="w-6 h-6 rounded-full bg-soft-blue text-brand-blue flex items-center justify-center text-xs shrink-0 font-bold shadow-xs"><i class="fa-solid fa-baseball-bat-ball"></i></span>
                <span><strong>Authentic Sports Gear</strong> & Active Play Kits</span>
              </div>
            </div>
          </div>

          <div class="relative z-10 pt-4 border-t border-white/20 flex items-center justify-between gap-3">
            <div class="flex items-center -space-x-2">
              <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=100&q=80" class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" alt="Parent">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" alt="Parent">
              <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80" class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" alt="Parent">
            </div>
            <div class="text-right">
              <div class="text-[11px] font-bold font-heading text-play-yellow flex items-center justify-end gap-1">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                <span class="text-white ml-0.5">4.9/5</span>
              </div>
              <p class="text-[10px] text-white/70 font-sans">15,000+ Happy Families</p>
            </div>
          </div>
        </div>

        <!-- RIGHT: FORM -->
        <div class="md:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-center space-y-6">

          <div>
            <div class="flex items-center justify-between gap-2 mb-2">
              <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-orange font-heading bg-soft-orange px-3 py-1 rounded-full border border-brand-orange/20"><i class="fa-solid fa-user-plus mr-1"></i>CREATE ACCOUNT</span>
              <a href="{{ route('home') }}" class="text-xs text-brand-muted hover:text-brand-orange font-heading font-semibold transition flex items-center gap-1"><i class="fa-solid fa-arrow-left text-[10px]"></i><span>Back to Store</span></a>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold font-heading text-dark-navy">CREATE AN ACCOUNT</h1>
            <p class="text-xs sm:text-sm text-brand-muted mt-1 font-sans">Join for faster checkout, sports goods and quality toys.</p>
          </div>

          <div>
            <a href="{{ $googleUrl }}" class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white border-2 border-brand-border hover:bg-soft-blue hover:border-brand-blue rounded-2xl text-xs font-bold font-heading text-brand-navy shadow-xs transition duration-200 group">
              <svg class="w-4 h-4 group-hover:scale-110 transition shrink-0" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
              <span>Sign Up with Google</span>
            </a>

            <div class="flex items-center my-4">
              <div class="flex-1 border-t border-brand-border"></div>
              <span class="px-3 text-[11px] text-brand-muted uppercase font-bold font-heading">or create with email</span>
              <div class="flex-1 border-t border-brand-border"></div>
            </div>
          </div>

          <form id="signup-form" data-auth-form method="POST" action="{{ route('user.register.submit') }}" class="space-y-4 text-xs font-body" novalidate>
            @csrf
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">

            <div data-form-error class="{{ $errors->any() ? '' : 'hidden' }} text-xs font-semibold text-red-600 bg-red-50 border border-red-100 rounded-xl px-3 py-2 font-heading">{{ $errors->first() }}</div>

            <div>
              <label for="su-name" class="block font-bold text-dark-navy mb-1.5 font-heading">Full Name *</label>
              <div class="relative">
                <i class="fa-regular fa-user absolute left-4 top-3 text-brand-muted text-xs"></i>
                <input type="text" id="su-name" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="100" placeholder="Aarav Sharma" class="{{ $inputCls }}">
              </div>
              <p data-error-for="name" class="{{ $errCls }}"></p>
            </div>

            <div>
              <label for="su-email" class="block font-bold text-dark-navy mb-1.5 font-heading">Email Address *</label>
              <div class="relative">
                <i class="fa-regular fa-envelope absolute left-4 top-3 text-brand-muted text-xs"></i>
                <input type="email" id="su-email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="name@example.com" class="{{ $inputCls }}">
              </div>
              <p data-error-for="email" class="{{ $errCls }}"></p>
            </div>

            <div>
              <label for="su-mobile" class="block font-bold text-dark-navy mb-1.5 font-heading">WhatsApp Mobile Number *</label>
              <div class="relative">
                <i class="fa-brands fa-whatsapp absolute left-4 top-3 text-emerald-600 text-xs"></i>
                <input type="tel" id="su-mobile" name="mobile" value="{{ old('mobile') }}" inputmode="numeric" maxlength="10" autocomplete="tel-national" placeholder="9876543210" class="{{ $inputCls }}">
              </div>
              <p data-error-for="mobile" class="{{ $errCls }}"></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
              <div>
                <label for="su-password" class="block font-bold text-dark-navy mb-1.5 font-heading">Password *</label>
                <div class="relative">
                  <i class="fa-solid fa-lock absolute left-4 top-3 text-brand-muted text-xs"></i>
                  <input type="password" id="su-password" name="password" autocomplete="new-password" placeholder="At least 8 characters" class="{{ $inputCls }} pr-10">
                  <button type="button" data-toggle-password="su-password" class="absolute right-3 top-3 text-brand-muted hover:text-dark-navy cursor-pointer" aria-label="Show or hide password"><i class="fa-regular fa-eye text-xs"></i></button>
                </div>
                <p data-error-for="password" class="{{ $errCls }}"></p>
              </div>
              <div>
                <label for="su-cpassword" class="block font-bold text-dark-navy mb-1.5 font-heading">Confirm Password *</label>
                <div class="relative">
                  <i class="fa-solid fa-lock absolute left-4 top-3 text-brand-muted text-xs"></i>
                  <input type="password" id="su-cpassword" name="password_confirmation" autocomplete="new-password" placeholder="Repeat password" class="{{ $inputCls }}">
                </div>
              </div>
            </div>

            <div>
              <div class="flex items-start gap-2 pt-1">
                <input type="checkbox" id="su-terms" name="terms" value="1" class="rounded text-brand-blue focus:ring-brand-blue mt-0.5 cursor-pointer">
                <label for="su-terms" class="text-[11px] text-brand-muted leading-relaxed cursor-pointer font-sans">
                  I agree to the <a href="{{ route('terms') }}" class="text-brand-blue font-bold hover:underline">Terms & Conditions</a> and acknowledge the <a href="{{ route('privacy-policy') }}" class="text-brand-blue font-bold hover:underline">Privacy Policy</a>.
                </label>
              </div>
              <p data-error-for="terms" class="{{ $errCls }}"></p>
            </div>

            <button type="submit" class="w-full btn-play-orange text-white font-bold font-heading text-sm py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition duration-200 cursor-pointer flex items-center justify-center gap-2">
              <span>CREATE ACCOUNT</span><i class="fa-solid fa-sparkles text-xs"></i>
            </button>
          </form>

          <div class="text-center pt-2 text-xs text-brand-muted border-t border-brand-border/70 font-sans">
            Already have an account?
            <a href="{{ route('user.login', array_filter(['redirect' => request('redirect')])) }}" class="text-brand-blue hover:text-brand-orange font-bold font-heading ml-1 hover:underline">Sign In →</a>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  @include('user.auth-script')
@endpush