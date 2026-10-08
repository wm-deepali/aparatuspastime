@extends('layouts.app')

@section('title', 'Sign In | Aparatus - Sports Goods & Toys')
@section('active_nav', 'account')

@section('content')
  <div class="relative py-10 md:py-16 overflow-hidden min-h-[calc(100vh-140px)] flex items-center justify-center">

    <!-- Background Blobs -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-soft-yellow rounded-full blur-3xl opacity-70 pointer-events-none -z-10 animate-pulse"></div>
    <div class="absolute bottom-0 right-10 w-96 h-96 bg-soft-orange rounded-full blur-3xl opacity-60 pointer-events-none -z-10"></div>
    <div class="absolute top-1/3 -left-20 w-80 h-80 bg-soft-blue rounded-full blur-3xl opacity-70 pointer-events-none -z-10"></div>

    <!-- Floating Sticker Badges -->
    <div class="hidden xl:flex items-center gap-2 absolute top-20 left-16 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-brand-border text-xs font-bold font-heading text-brand-navy rotate-[-6deg] pointer-events-none z-0">
      <span class="text-base">⚽</span><span>Quality Sports Goods</span>
    </div>
    <div class="hidden xl:flex items-center gap-2 absolute bottom-24 left-20 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-brand-border text-xs font-bold font-heading text-brand-orange rotate-[4deg] pointer-events-none z-0">
      <span class="text-base">⭐</span><span>15,000+ Happy Families</span>
    </div>
    <div class="hidden xl:flex items-center gap-2 absolute top-24 right-16 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-brand-border text-xs font-bold font-heading text-emerald-700 rotate-[5deg] pointer-events-none z-0">
      <span class="text-base">🛡️</span><span>100% Non-Toxic Toys</span>
    </div>
    <div class="hidden xl:flex items-center gap-2 absolute bottom-20 right-20 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl shadow-lg border border-brand-border text-xs font-bold font-heading text-purple-700 rotate-[-5deg] pointer-events-none z-0">
      <span class="text-base">🎯</span><span>Active & Screen-Free</span>
    </div>

    <!-- CARD CONTAINER -->
    <div class="w-full max-w-5xl mx-auto px-4 sm:px-6 relative z-10">

      <div class="bg-white rounded-3xl sm:rounded-[32px] border border-brand-border overflow-hidden shadow-2xl grid grid-cols-1 md:grid-cols-12">

        <!-- LEFT: IMAGE PANEL (5 COLS) -->
        <div class="hidden md:flex md:col-span-5 flex-col justify-between p-8 lg:p-10 text-white relative overflow-hidden bg-brand-navy select-none min-h-[580px]">
          <img
            src="https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=1000&q=85"
            alt="Children Playing Joyfully"
            class="absolute inset-0 w-full h-full object-cover scale-105 hover:scale-110 transition duration-700 ease-out"
          >
          <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-brand-navy/80 to-brand-navy/60"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-dark-navy/90 via-brand-navy/70 to-transparent"></div>

          <div class="relative z-10 flex items-center justify-between">
            <div class="inline-flex items-center gap-2 bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-2xl shadow-md border border-white/40">
              <img src="{{ asset('assets/logo.png') }}" alt="Aparatus - Sports Goods & Toys" class="h-8 w-auto object-contain">
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-[10px] font-bold font-heading border border-white/30 shadow-xs uppercase">
              <span class="w-2 h-2 rounded-full bg-play-yellow animate-ping"></span>
              <span>Sports Goods & Toys</span>
            </span>
          </div>

          <div class="relative z-10 space-y-4 my-auto py-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-play-yellow text-dark-navy text-xs font-bold font-heading shadow-md uppercase">
              <i class="fa-solid fa-sparkles text-brand-orange"></i>
              <span>APARATUS BENEFITS</span>
            </div>

            <h2 class="text-2xl lg:text-3xl font-extrabold font-heading text-white leading-snug drop-shadow-md">
              Your Gateway to Sports Goods & Quality Toys
            </h2>

            <p class="text-xs text-white/90 font-sans leading-relaxed">
              Sign in to manage orders, track shipments, save favorites, and explore curated sports gear and toys.
            </p>

            <div class="space-y-2.5 pt-2">
              <div class="flex items-center gap-2.5 text-xs text-white/95 font-sans font-medium">
                <span class="w-5 h-5 rounded-full bg-emerald-500/90 text-white flex items-center justify-center text-[10px] shrink-0 shadow-xs"><i class="fa-solid fa-check"></i></span>
                <span>Fast 1-Click Express Checkout</span>
              </div>
              <div class="flex items-center gap-2.5 text-xs text-white/95 font-sans font-medium">
                <span class="w-5 h-5 rounded-full bg-play-yellow text-brand-navy flex items-center justify-center text-[10px] shrink-0 shadow-xs font-bold"><i class="fa-solid fa-gift"></i></span>
                <span>Surprise Birthday Play Bundles</span>
              </div>
              <div class="flex items-center gap-2.5 text-xs text-white/95 font-sans font-medium">
                <span class="w-5 h-5 rounded-full bg-sky-blue text-brand-navy flex items-center justify-center text-[10px] shrink-0 shadow-xs"><i class="fa-solid fa-truck-fast"></i></span>
                <span>Live WhatsApp Dispatch Updates</span>
              </div>
            </div>
          </div>

          <div class="relative z-10 pt-4 border-t border-white/20 flex items-center justify-between gap-3">
            <div class="flex items-center -space-x-2">
              <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" alt="Parent">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&q=80" class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" alt="Parent">
              <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=100&q=80" class="w-7 h-7 rounded-full border-2 border-white object-cover shadow-xs" alt="Parent">
            </div>
            <div class="text-right">
              <div class="text-[11px] font-bold font-heading text-play-yellow flex items-center justify-end gap-1">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                <span class="text-white ml-0.5">4.9/5</span>
              </div>
              <p class="text-[10px] text-white/70 font-sans">Trusted by 15k+ Parents</p>
            </div>
          </div>
        </div>

        <!-- RIGHT: LOGIN FORM (7 COLS) -->
        <div class="md:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-center space-y-6">

          <div>
            <div class="flex items-center justify-between gap-2 mb-2">
              <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-orange font-heading bg-soft-orange px-3 py-1 rounded-full border border-brand-orange/20 shadow-2xs">
                <i class="fa-solid fa-user mr-1"></i>APARATUS ACCOUNT
              </span>
              <a href="{{ route('home') }}" class="text-xs text-brand-muted hover:text-brand-orange font-heading font-semibold transition flex items-center gap-1">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Back to Store</span>
              </a>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold font-heading text-dark-navy">WELCOME BACK!</h1>
            <p class="text-xs sm:text-sm text-brand-muted mt-1 font-sans">Sign in to your Aparatus account for sports goods & toys.</p>
          </div>

          <!-- Google Login -->
          <div>
            <button type="button" id="google-login-btn" class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white border-2 border-brand-border hover:bg-soft-blue hover:border-brand-blue rounded-2xl text-xs font-bold font-heading text-brand-navy shadow-xs transition duration-200 cursor-pointer group">
              <svg class="w-4 h-4 group-hover:scale-110 transition shrink-0" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
              <span>Continue with Google</span>
            </button>

            <div class="flex items-center my-4">
              <div class="flex-1 border-t border-brand-border"></div>
              <span class="px-3 text-[11px] text-brand-muted uppercase font-bold font-heading">or sign in with email</span>
              <div class="flex-1 border-t border-brand-border"></div>
            </div>
          </div>

          <!-- Email Password Form -->
          <form id="login-form" class="space-y-4 text-xs font-body">
            @csrf
            <div>
              <label class="block font-bold text-dark-navy mb-1.5 font-heading">Email Address</label>
              <div class="relative">
                <i class="fa-regular fa-envelope absolute left-4 top-3.5 text-brand-muted text-xs"></i>
                <input
                  type="email"
                  id="login-email"
                  name="email"
                  required
                  placeholder="name@example.com"
                  class="w-full pl-10 pr-4 py-3 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 font-medium font-sans transition"
                >
              </div>
            </div>

            <div>
              <div class="flex justify-between items-center mb-1.5">
                <label class="font-bold text-dark-navy font-heading">Password</label>
                <a href="{{ route('forgot-password') }}" class="text-[11px] text-brand-blue hover:text-brand-orange font-bold font-heading transition">Forgot Password?</a>
              </div>
              <div class="relative">
                <i class="fa-solid fa-lock absolute left-4 top-3.5 text-brand-muted text-xs"></i>
                <input
                  type="password"
                  id="login-password"
                  name="password"
                  required
                  placeholder="••••••••"
                  class="w-full pl-10 pr-11 py-3 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/20 font-medium font-sans transition"
                >
                <button type="button" id="toggle-pw-btn" class="absolute right-3.5 top-3.5 text-brand-muted hover:text-dark-navy cursor-pointer">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <label class="flex items-center cursor-pointer">
                <input type="checkbox" id="remember-me" name="remember" checked class="rounded text-brand-blue focus:ring-brand-blue cursor-pointer">
                <span class="ml-2 text-brand-muted text-xs font-medium font-sans">Remember me on this browser</span>
              </label>
            </div>

            <button type="submit" class="w-full btn-play-orange text-white font-bold font-heading text-sm py-3.5 px-6 rounded-2xl shadow-md hover:shadow-lg transition duration-200 cursor-pointer flex items-center justify-center gap-2">
              <span>SIGN IN TO APARATUS</span>
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
          </form>

          <div class="text-center pt-2 text-xs text-brand-muted border-t border-brand-border/70 font-sans">
            Don't have an account yet?
            <a href="{{ route('signup') }}" class="text-brand-orange hover:text-brand-bright-orange font-bold font-heading ml-1 hover:underline">
              Create an Aparatus Account →
            </a>
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
      const dashboardUrl = @json(route('account.dashboard'));

      // Show/Hide password toggle
      const pwInput = document.getElementById('login-password');
      const togglePw = document.getElementById('toggle-pw-btn');
      if (togglePw && pwInput) {
        togglePw.onclick = () => {
          const isPw = pwInput.type === 'password';
          pwInput.type = isPw ? 'text' : 'password';
          togglePw.querySelector('i').className = isPw ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        };
      }

      // Email login
      document.getElementById('login-form')?.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = document.getElementById('login-email').value;
        const pw = document.getElementById('login-password').value;
        State.login(email, pw);
        Components.showToast('🎉 Welcome back to Aparatus!', 'success');
        setTimeout(() => { window.location.href = dashboardUrl; }, 500);
      });

      // Google sign-in (demo)
      document.getElementById('google-login-btn')?.addEventListener('click', () => {
        State.login('google.user@example.com', 'demo');
        Components.showToast('🚀 Google Sign-In successful!', 'success');
        setTimeout(() => { window.location.href = dashboardUrl; }, 500);
      });
    });
  </script>
@endpush