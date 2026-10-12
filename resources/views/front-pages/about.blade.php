@extends('layouts.app')

@section('title', $about->meta_title ?: 'About Us | Aparatus Pastime')
@section('meta_description', $about->meta_description)
@section('active_nav', 'about')

@php
    // Tailwind CDN needs full class names, so colour keys are mapped here
    $statColors = [
        'navy'   => 'text-brand-navy',
        'orange' => 'text-brand-orange',
    ];
    $beliefColors = [
        'blue'   => 'bg-soft-blue text-brand-blue',
        'orange' => 'bg-soft-orange text-brand-orange',
        'mint'   => 'bg-soft-mint text-emerald-600',
        'yellow' => 'bg-soft-yellow text-amber-500',
    ];
@endphp

@section('content')

    <!-- ABOUT HERO -->
    <section class="bg-brand-navy text-white py-14 md:py-20 px-4 relative overflow-hidden">
      <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full bg-brand-orange/20 blur-3xl pointer-events-none"></div>

      <div class="max-w-4xl mx-auto text-center relative z-10 space-y-3">
        @if ($about->hero_badge)
        <span class="inline-block bg-brand-orange text-white text-xs font-bold font-heading px-3.5 py-1 rounded-full uppercase tracking-wider">
          <i class="fa-solid fa-heart mr-1.5"></i>{{ $about->hero_badge }}
        </span>
        @endif
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-white leading-tight">
          {{ $about->hero_title }}
          @if ($about->hero_title_highlight)
            <br><span class="text-play-yellow">{{ $about->hero_title_highlight }}</span>
          @endif
        </h1>
        @if ($about->hero_description)
        <p class="text-xs sm:text-sm md:text-base text-white/90 max-w-xl mx-auto font-sans leading-relaxed">
          {{ $about->hero_description }}
        </p>
        @endif
      </div>
    </section>

    <!-- SECTION 1: OUR STORY -->
    <section class="py-14 md:py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center">
          <div class="space-y-4">
            @if ($about->story_badge)
            <span class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3 py-1 rounded-full font-heading">
              {{ $about->story_badge }}
            </span>
            @endif
            <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy">{{ $about->story_heading }}</h2>
            @if ($about->story_paragraph_1)
            <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans">{{ $about->story_paragraph_1 }}</p>
            @endif
            @if ($about->story_paragraph_2)
            <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans">{{ $about->story_paragraph_2 }}</p>
            @endif

            @if ($stats->isNotEmpty())
            <div class="pt-2 flex items-center gap-6 font-heading">
              @foreach ($stats as $stat)
                @if (!$loop->first)
                  <div class="w-px h-10 bg-brand-border"></div>
                @endif
                <div>
                  <div class="text-2xl sm:text-3xl font-bold {{ $statColors[$stat->color] ?? 'text-brand-navy' }}">{{ $stat->value }}</div>
                  <div class="text-xs text-brand-muted font-sans font-semibold">{{ $stat->label }}</div>
                </div>
              @endforeach
            </div>
            @endif
          </div>

          @if ($about->story_image_url)
          <div class="aspect-16/11 rounded-3xl overflow-hidden bg-soft-blue p-3 relative shadow-md">
            <img src="{{ $about->story_image_url }}" alt="{{ $about->story_image_alt }}" class="w-full h-full object-cover rounded-2xl">
          </div>
          @endif
        </div>
      </div>
    </section>

    <!-- SECTION 2: WHAT WE BELIEVE -->
    @if ($beliefs->isNotEmpty())
    <section class="py-14 md:py-20 bg-warm-cream border-y border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        <div class="text-center max-w-xl mx-auto mb-12">
          @if ($about->beliefs_badge)
          <span class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
            {{ $about->beliefs_badge }}
          </span>
          @endif
          <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy mt-2">{{ $about->beliefs_heading }}</h2>
          @if ($about->beliefs_description)
          <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">{{ $about->beliefs_description }}</p>
          @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          @foreach ($beliefs as $belief)
          <div class="bg-white p-6 rounded-3xl border border-brand-border space-y-3 shadow-xs text-center">
            <div class="w-14 h-14 rounded-2xl {{ $beliefColors[$belief->color] ?? $beliefColors['blue'] }} flex items-center justify-center text-2xl mx-auto">
              <i class="fa-solid {{ $belief->icon ?: 'fa-star' }}"></i>
            </div>
            <h3 class="font-heading font-bold text-base text-dark-navy">{{ $belief->title }}</h3>
            <p class="text-xs text-body-text leading-relaxed font-sans">{{ $belief->description }}</p>
          </div>
          @endforeach
        </div>

      </div>
    </section>
    @endif

    <!-- SECTION 3: OUR PROMISE -->
    <section class="py-14 md:py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-brand-navy to-[#0a4582] rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-10">
            <div class="space-y-3">
              @if ($about->promise_badge)
              <span class="text-xs font-bold text-play-yellow uppercase tracking-widest font-heading">{{ $about->promise_badge }}</span>
              @endif
              <h2 class="text-2xl sm:text-3xl font-bold font-heading text-white">{{ $about->promise_heading }}</h2>
              @if ($about->promise_description)
              <p class="text-xs sm:text-sm text-white/90 font-sans leading-relaxed">{{ $about->promise_description }}</p>
              @endif
            </div>
            <div class="flex flex-wrap gap-4 justify-start lg:justify-end">
              @if ($about->promise_btn1_text)
              <a href="{{ url($about->promise_btn1_url ?: '/') }}" class="btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-md transition font-heading">
                {{ $about->promise_btn1_text }}
              </a>
              @endif
              @if ($about->promise_btn2_text)
              <a href="{{ url($about->promise_btn2_url ?: '/') }}" class="bg-white/20 hover:bg-white/30 text-white font-bold font-heading text-xs sm:text-sm px-6 py-3.5 rounded-xl border border-white/40 transition">
                {{ $about->promise_btn2_text }}
              </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection