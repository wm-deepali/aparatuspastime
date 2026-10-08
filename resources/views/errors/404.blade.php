@extends('layouts.app')

@section('title', 'Page Not Found | Aparatus Pastime')
@section('active_nav', 'home')

@section('content')
  <div class="py-16 md:py-24 relative overflow-hidden">
    <!-- Decorative floating toy shapes -->
    <div class="absolute top-12 left-10 text-play-yellow text-4xl animate-bounce opacity-70 pointer-events-none">
      <i class="fa-solid fa-star"></i>
    </div>
    <div class="absolute top-20 right-16 text-sky-blue text-3xl animate-pulse opacity-70 pointer-events-none">
      <i class="fa-solid fa-shapes"></i>
    </div>
    <div class="absolute bottom-16 left-20 text-soft-coral text-3xl animate-spin opacity-50 pointer-events-none" style="animation-duration: 8s;">
      <i class="fa-solid fa-asterisk"></i>
    </div>

    <div class="max-w-xl mx-auto px-4 text-center space-y-6 relative z-10">

      <div class="space-y-3">
        <div class="relative inline-block">
          <span class="text-8xl sm:text-9xl font-extrabold font-heading text-brand-orange/20 tracking-wider">404</span>
          <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-4xl sm:text-5xl font-extrabold font-heading text-brand-navy">🎈 404 🚀</span>
          </div>
        </div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold font-heading text-brand-navy">
          UH-OH! THIS PAGE WENT OUT TO PLAY.
        </h1>
        <p class="text-xs sm:text-sm text-brand-muted max-w-md mx-auto font-body leading-relaxed">
          We couldn't find what you're looking for. It might have rolled under the sofa or moved to another playroom!
        </p>
      </div>

      <!-- SEARCH SHORTCUT -->
      <div class="max-w-md mx-auto pt-2">
        <form action="{{ route('search') }}" method="GET" class="relative">
          <input
            type="text"
            name="q"
            placeholder="Search toys, games, sports & more..."
            class="w-full pl-11 pr-24 py-3.5 bg-white border border-brand-border rounded-2xl text-xs text-dark-navy focus:outline-none focus:border-brand-blue shadow-sm font-body"
          >
          <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-brand-muted text-sm"></i>
          <button type="submit" class="absolute right-2 top-2 bottom-2 bg-brand-orange hover:bg-brand-bright-orange text-white text-xs font-bold font-heading px-5 rounded-xl transition shadow-xs">
            SEARCH
          </button>
        </form>
      </div>

      <!-- BUTTONS -->
      <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="w-full sm:w-auto bg-brand-navy hover:bg-brand-blue text-white font-bold font-heading text-xs px-8 py-3.5 rounded-2xl shadow transition">
          BACK TO HOME
        </a>
        <a href="{{ route('shop') }}" class="w-full sm:w-auto bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-xs px-8 py-3.5 rounded-2xl shadow transition">
          SHOP TOYS →
        </a>
      </div>

    </div>
  </div>
@endsection