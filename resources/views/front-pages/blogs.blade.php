@extends('layouts.app')

@section('title', 'The Playroom Blog | Aparatus Pastime - Play Ideas & Guides')
@section('meta_description', 'Ideas, guides, and inspiration for better playtime, developmental toys, STEM learning, and outdoor family fun.')
@section('active_nav', 'home')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 space-y-10">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted font-heading">
        <a href="{{ url('/') }}" class="hover:text-brand-orange transition">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-dark-navy font-bold">The Playroom</span>
      </nav>

      <!-- HERO HEADER -->
      <div class="text-center max-w-2xl mx-auto space-y-2">
        <span
          class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
          <i class="fa-solid fa-book-open mr-1"></i>PLAYROOM INSPIRATION
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-dark-navy">THE PLAYROOM</h1>
        <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed">
          Ideas, guides and inspiration for better playtime.
        </p>
      </div>

      <!-- TOPIC FILTERS -->
      @if ($topics->count() > 1 || $cat || $tag)
        <div class="flex flex-wrap items-center justify-center gap-2 font-heading text-xs">
          <a href="{{ route('blogs') }}"
            class="px-3.5 py-1.5 rounded-xl font-bold transition {{ !$cat && !$tag ? 'bg-brand-navy text-white' : 'bg-soft-blue text-brand-blue hover:bg-brand-blue hover:text-white' }}">
            All
          </a>
          @foreach ($topics as $t)
            <a href="{{ route('blogs', ['cat' => $t->category_slug]) }}"
              class="px-3.5 py-1.5 rounded-xl font-bold transition {{ $cat === $t->category_slug ? 'bg-brand-navy text-white' : 'bg-soft-blue text-brand-blue hover:bg-brand-blue hover:text-white' }}">
              {{ $t->category }}
            </a>
          @endforeach
          @if ($tag)
            <span class="px-3.5 py-1.5 rounded-xl font-bold bg-brand-orange text-white">#{{ $tag }}</span>
          @endif
        </div>
      @endif

      <!-- FEATURED ARTICLE HERO BANNER -->
      @if ($featured)
        <div
          class="bg-white rounded-3xl border border-brand-border overflow-hidden shadow-sm grid grid-cols-1 lg:grid-cols-12 items-center">
          <div class="lg:col-span-7 aspect-16/10 lg:aspect-auto lg:h-full bg-soft-blue relative overflow-hidden">
            @if ($featured->banner_url)
              <img src="{{ $featured->banner_url }}" alt="{{ $featured->title }}" class="w-full h-full object-cover">
            @endif
            <span
              class="absolute top-4 left-4 bg-brand-orange text-white text-xs font-bold font-heading px-3.5 py-1 rounded-full shadow-xs">
              FEATURED STORY
            </span>
          </div>
          <div class="lg:col-span-5 p-6 sm:p-10 space-y-3 font-sans">
            <div class="flex items-center gap-2 text-xs text-brand-muted">
              @if ($featured->date_label)
                <span><i class="fa-regular fa-calendar mr-1 text-brand-orange"></i>{{ $featured->date_label }}</span>
                <span>•</span>
              @endif
              <span><i class="fa-regular fa-clock mr-1 text-brand-blue"></i>{{ $featured->read_time_label }}</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold font-heading text-dark-navy hover:text-brand-orange transition">
              <a href="{{ route('blog.show', ['slug' => $featured->slug]) }}">{{ $featured->title }}</a>
            </h2>
            @if ($featured->short_description)
              <p class="text-xs sm:text-sm text-body-text leading-relaxed">{{ $featured->short_description }}</p>
            @endif
            <div class="pt-2">
              <a href="{{ route('blog.show', ['slug' => $featured->slug]) }}"
                class="btn-play-orange text-xs px-6 py-2.5 rounded-xl shadow-xs transition inline-flex items-center gap-1.5 font-heading">
                <span>READ ARTICLE</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
              </a>
            </div>
          </div>
        </div>
      @endif

      <!-- BLOG ARTICLES GRID -->
      <div class="space-y-6">
        <h2 class="font-heading font-bold text-xl text-dark-navy pb-3 border-b border-brand-border">Latest Articles & Guides</h2>

        @if ($blogs->isNotEmpty())
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach ($blogs as $blog)
              @include('front-pages.partials.blog-card', ['blog' => $blog])
            @endforeach
          </div>

          @if ($blogs->hasPages())
            <div class="pt-4">{{ $blogs->links() }}</div>
          @endif
        @else
          <p class="text-center text-sm text-body-text font-sans py-10">No articles found. Check back soon!</p>
        @endif
      </div>

    </div>
  </div>
@endsection