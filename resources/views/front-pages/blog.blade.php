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
        <span class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
          <i class="fa-solid fa-book-open mr-1"></i>PLAYROOM INSPIRATION
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-dark-navy">
          THE PLAYROOM
        </h1>
        <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed">
          Ideas, guides and inspiration for better playtime.
        </p>
      </div>

      <!-- FEATURED ARTICLE HERO BANNER -->
      <div id="blog-featured-banner" class="bg-white rounded-3xl border border-brand-border overflow-hidden shadow-sm grid grid-cols-1 lg:grid-cols-12 items-center">
        <!-- Injected via JavaScript -->
      </div>

      <!-- BLOG ARTICLES GRID -->
      <div class="space-y-6">
        <h2 class="font-heading font-bold text-xl text-dark-navy pb-3 border-b border-brand-border">Latest Articles & Guides</h2>
        <div id="blog-articles-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
          <!-- Injected via JavaScript -->
        </div>
      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { blogs } from '{{ asset("assets/js/data/blogs.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const base = @json(url('/') . '/');

      // Featured post
      const feat = blogs[0];
      const featBanner = document.getElementById('blog-featured-banner');
      if (featBanner && feat) {
        featBanner.innerHTML = `
          <div class="lg:col-span-7 aspect-16/10 lg:aspect-auto lg:h-full bg-soft-blue relative overflow-hidden">
            <img src="${feat.bannerImage}" alt="${feat.title}" class="w-full h-full object-cover">
            <span class="absolute top-4 left-4 bg-brand-orange text-white text-xs font-bold font-heading px-3.5 py-1 rounded-full shadow-xs">
              FEATURED STORY
            </span>
          </div>
          <div class="lg:col-span-5 p-6 sm:p-10 space-y-3 font-sans">
            <div class="flex items-center gap-2 text-xs text-brand-muted">
              <span><i class="fa-regular fa-calendar mr-1 text-brand-orange"></i>${feat.date}</span>
              <span>•</span>
              <span><i class="fa-regular fa-clock mr-1 text-brand-blue"></i>${feat.readTime}</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold font-heading text-dark-navy hover:text-brand-orange transition">
              <a href="${base}blog-detail?slug=${feat.slug}">${feat.title}</a>
            </h2>
            <p class="text-xs sm:text-sm text-body-text leading-relaxed">
              ${feat.excerpt}
            </p>
            <div class="pt-2">
              <a href="${base}blog-detail?slug=${feat.slug}" class="btn-play-orange text-xs px-6 py-2.5 rounded-xl shadow-xs transition inline-flex items-center gap-1.5 font-heading">
                <span>READ ARTICLE</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
              </a>
            </div>
          </div>
        `;
      }

      // Remaining articles grid
      const grid = document.getElementById('blog-articles-grid');
      if (grid) {
        grid.innerHTML = blogs.map(b => Components.renderBlogCard(b, base)).join('');
      }
    });
  </script>
@endpush