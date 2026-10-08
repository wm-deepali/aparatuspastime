@extends('layouts.app')

@section('title', 'All Categories | Aparatus Pastime - Kids Toys & Sports')
@section('meta_description', 'Browse our complete collection of kids toys, board games, athletic sports gear, outdoor adventure essentials, and STEM kits.')
@section('active_nav', 'categories')

@section('content')

    <!-- CATEGORIES HERO BANNER -->
    <section class="bg-brand-navy text-white py-12 md:py-16 px-4 relative overflow-hidden">
      <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-brand-orange/20 blur-3xl pointer-events-none"></div>

      <div class="max-w-7xl mx-auto text-center space-y-3 relative z-10">
        <span class="text-xs font-bold uppercase tracking-widest text-play-yellow bg-white/10 px-3.5 py-1 rounded-full font-heading">
          <i class="fa-solid fa-shapes mr-1.5"></i>EXPLORE THE PLAYROOM
        </span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold font-heading text-white">
          WHAT DO THEY LOVE?
        </h1>
        <p class="text-xs sm:text-sm md:text-base text-white/90 max-w-xl mx-auto font-sans leading-relaxed">
          From high-energy outdoor sports to thoughtful strategy games and STEM kits, discover products designed to foster lifelong curiosity.
        </p>
      </div>
    </section>

    <!-- CATEGORIES GRID (Pastel Cards) -->
    <section class="py-12 md:py-16">
      <div class="max-w-7xl mx-auto px-4">

        @if ($categories->isEmpty())
          <p class="text-center text-sm text-body-text font-sans py-10">
            Categories are coming soon. Please check back shortly!
          </p>
        @else
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8" id="all-categories-grid">

            @foreach ($categories as $cat)
              @php
                  $bg = $cat->pastel_bg ?: 'bg-soft-blue';
                  $icon = $cat->icon ?: 'fa-shapes';

                  // Images uploaded via admin live in storage/; seeded/static ones may live in public/assets
                  if (!$cat->image) {
                      $img = asset('assets/images/category-placeholder.png');
                  } elseif (\Illuminate\Support\Str::startsWith($cat->image, ['assets/', 'images/'])) {
                      $img = asset($cat->image);
                  } else {
                      $img = asset('storage/' . $cat->image);
                  }
              @endphp

              <div class="{{ $bg }} rounded-3xl border border-brand-border p-6 shadow-xs flex flex-col justify-between group hover:shadow-lg transition duration-300">
                <div>
                  <div class="aspect-16/10 rounded-2xl overflow-hidden bg-white/80 p-3 mb-4 relative flex items-center justify-center shadow-2xs">
                    <img src="{{ $img }}" alt="{{ $cat->name }}" loading="lazy" class="w-full h-full object-cover rounded-xl group-hover:scale-105 transition duration-300">
                    <span class="absolute top-4 left-4 bg-dark-navy text-white text-[11px] font-bold font-heading px-3 py-1 rounded-full shadow-xs">
                      {{ $cat->products_count }} {{ \Illuminate\Support\Str::plural('Product', $cat->products_count) }}
                    </span>
                  </div>

                  <div class="flex items-center gap-2 mb-1.5">
                    <i class="fa-solid {{ $icon }} text-brand-orange text-base"></i>
                    <h3 class="font-heading font-bold text-lg sm:text-xl text-dark-navy">{{ $cat->name }}</h3>
                  </div>

                  @if ($cat->description)
                    <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed mb-4">
                      {{ $cat->description }}
                    </p>
                  @endif

                  @if ($cat->children->isNotEmpty())
                    <div class="flex flex-wrap gap-1.5 mb-6">
                      @foreach ($cat->children as $sub)
                        <a href="{{ url('shop') }}?category={{ $cat->slug }}&q={{ urlencode($sub->name) }}"
                           class="text-[11px] bg-white hover:bg-soft-orange text-dark-navy hover:text-brand-orange px-2.5 py-1 rounded-full border border-brand-border transition font-sans font-semibold">
                          {{ $sub->name }}
                        </a>
                      @endforeach
                    </div>
                  @endif
                </div>

                <a href="{{ url('shop') }}?category={{ $cat->slug }}" class="btn-play-blue hover:btn-play-orange text-xs py-3 px-4 rounded-xl text-center block transition">
                  <span>SHOP {{ strtoupper($cat->name) }} →</span>
                </a>
              </div>
            @endforeach

          </div>
        @endif

      </div>
    </section>

    <!-- PROMOTIONAL CONTACT BANNER -->
    <section class="py-12 bg-white border-t border-brand-border">
      <div class="max-w-7xl mx-auto px-4">
        <div class="bg-soft-yellow rounded-3xl border border-amber-200 p-8 sm:p-12 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xs">
          <div class="space-y-2 max-w-xl text-center md:text-left">
            <span class="text-xs font-bold font-heading text-brand-orange uppercase tracking-wider">NEED INSPIRATION?</span>
            <h3 class="text-2xl font-bold font-heading text-dark-navy">Looking for Age-Specific Recommendations?</h3>
            <p class="text-xs sm:text-sm text-body-text font-sans">
              Our play consultants are happy to help you pick the perfect birthday gift or developmental toy.
            </p>
          </div>
          <a href="{{ route('contact') }}" class="btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-md transition shrink-0">
            TALK TO AN EXPERT →
          </a>
        </div>
      </div>
    </section>

@endsection