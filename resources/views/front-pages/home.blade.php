@extends('layouts.app')

@section('title', 'Aparatus Pastime | Kids Toys, Games & Sports Goods - Play. Learn. Explore.')
@section('meta_description', 'Discover premium curated kids toys, board games, sports goods, tactical puzzles, and educational STEM sets at Aparatus Pastime. Built for active play, curiosity, and family fun.')
@section('active_nav', 'home')

@section('content')

  @php
    use Illuminate\Support\Str;

    // ───────── Helpers ─────────
    $sections = $sections ?? collect();
    $sec = fn($key) => $sections->get($key);
    $secOn = fn($key) => !$sections->has($key) || (bool) $sections->get($key)->status;

    // Resolve a link: absolute URL as-is, anything else through url()
    $href = fn($l) => blank($l) ? '#' : (Str::startsWith($l, ['http://', 'https://', '#', 'mailto:', 'tel:']) ? $l : url($l));

    // Resolve an image: URL / assets path / storage path
    $imgUrl = function ($p) {
      if (blank($p)) return asset('assets/images/placeholder.png');
      if (Str::startsWith($p, ['http://', 'https://'])) return $p;
      if (Str::startsWith($p, ['assets/', 'images/'])) return asset($p);
      return asset('storage/' . $p);
    };

    // Initials from a name ("Neha & Rohan K." → NR)
    $initials = function ($name) {
      $words = preg_split('/\s+/', trim(preg_replace('/[^\pL\s]/u', ' ', (string) $name)), -1, PREG_SPLIT_NO_EMPTY);
      return strtoupper(collect($words)->take(2)->map(fn($w) => Str::substr($w, 0, 1))->implode(''));
    };

    // Decode JSON "extra" safely
    $extraOf = function ($row) {
      $x = $row->extra ?? null;
      return is_array($x) ? $x : (json_decode((string) $x, true) ?: []);
    };

    // ───────── Colour maps (full class names so Tailwind can see them) ─────────
    $heroBadge = [
      'orange' => ['wrap' => 'bg-brand-orange text-white', 'icon' => 'text-play-yellow'],
      'mint' => ['wrap' => 'bg-mint text-dark-navy', 'icon' => 'text-brand-blue'],
      'sky' => ['wrap' => 'bg-sky-blue text-dark-navy', 'icon' => 'text-brand-orange'],
      'blue' => ['wrap' => 'bg-brand-blue text-white', 'icon' => 'text-play-yellow'],
    ];
    $heroHighlight = [
      'yellow' => 'text-play-yellow',
      'mint' => 'text-mint',
      'sky' => 'text-sky-blue',
      'orange' => 'text-brand-orange',
    ];

    $uspColors = [
      'blue' => ['wrap' => 'bg-soft-blue border-blue-100', 'icon' => 'bg-brand-blue'],
      'orange' => ['wrap' => 'bg-soft-orange border-orange-100', 'icon' => 'bg-brand-orange'],
      'mint' => ['wrap' => 'bg-soft-mint border-emerald-100', 'icon' => 'bg-emerald-500'],
      'yellow' => ['wrap' => 'bg-soft-yellow border-amber-100', 'icon' => 'bg-amber-500'],
      'purple' => ['wrap' => 'bg-soft-purple border-purple-100', 'icon' => 'bg-purple-500'],
      'coral' => ['wrap' => 'bg-soft-coral border-rose-100', 'icon' => 'bg-rose-500'],
    ];

    $interestColors = [
      'orange' => ['card' => 'bg-soft-orange border-orange-200', 'icon' => 'bg-brand-orange text-white'],
      'yellow' => ['card' => 'bg-soft-yellow border-amber-200', 'icon' => 'bg-amber-400 text-dark-navy'],
      'blue' => ['card' => 'bg-soft-blue border-blue-200', 'icon' => 'bg-brand-blue text-white'],
      'purple' => ['card' => 'bg-soft-purple border-purple-200', 'icon' => 'bg-purple-500 text-white'],
      'mint' => ['card' => 'bg-soft-mint border-emerald-200', 'icon' => 'bg-emerald-500 text-white'],
      'coral' => ['card' => 'bg-soft-coral border-rose-200', 'icon' => 'bg-rose-500 text-white'],
    ];

    $featureColors = [
      'blue' => 'bg-soft-blue text-brand-blue',
      'orange' => 'bg-soft-orange text-brand-orange',
      'yellow' => 'bg-soft-yellow text-amber-500',
      'mint' => 'bg-soft-mint text-emerald-600',
      'purple' => 'bg-soft-purple text-purple-600',
      'coral' => 'bg-soft-coral text-rose-600',
    ];

    $testiColors = [
      'yellow' => ['card' => 'from-soft-yellow/90 via-white to-soft-yellow/40 border-amber-200/90', 'quote' => 'text-amber-500/10', 'tag' => 'text-amber-900 bg-amber-100/90 border-amber-200', 'tagicon' => 'text-brand-orange', 'line' => 'border-amber-200/60', 'avatar' => 'bg-amber-500'],
      'blue' => ['card' => 'from-soft-blue/90 via-white to-soft-blue/40 border-blue-200/90', 'quote' => 'text-blue-500/10', 'tag' => 'text-brand-navy bg-blue-100/90 border-blue-200', 'tagicon' => 'text-brand-blue', 'line' => 'border-blue-200/60', 'avatar' => 'bg-brand-navy'],
      'mint' => ['card' => 'from-soft-mint/90 via-white to-soft-mint/40 border-emerald-200/90', 'quote' => 'text-emerald-500/10', 'tag' => 'text-emerald-900 bg-emerald-100/90 border-emerald-200', 'tagicon' => 'text-emerald-600', 'line' => 'border-emerald-200/60', 'avatar' => 'bg-emerald-600'],
      'orange' => ['card' => 'from-soft-orange/90 via-white to-soft-orange/40 border-orange-200/90', 'quote' => 'text-orange-500/10', 'tag' => 'text-orange-900 bg-orange-100/90 border-orange-200', 'tagicon' => 'text-brand-orange', 'line' => 'border-orange-200/60', 'avatar' => 'bg-brand-orange'],
      'purple' => ['card' => 'from-soft-purple/90 via-white to-soft-purple/40 border-purple-200/90', 'quote' => 'text-purple-500/10', 'tag' => 'text-purple-900 bg-purple-100/90 border-purple-200', 'tagicon' => 'text-purple-600', 'line' => 'border-purple-200/60', 'avatar' => 'bg-purple-600'],
      'sky' => ['card' => 'from-soft-sky/90 via-white to-soft-sky/40 border-sky-200/90', 'quote' => 'text-sky-500/10', 'tag' => 'text-sky-900 bg-sky-100/90 border-sky-200', 'tagicon' => 'text-brand-blue', 'line' => 'border-sky-200/60', 'avatar' => 'bg-brand-blue'],
    ];
  @endphp

  <!-- 1. FULL WIDTH HERO SLIDER -->
  @if ($sliders->isNotEmpty())
    <section class="relative bg-brand-navy overflow-hidden">
      <div id="hero-slider"
        class="hero-slider-container relative w-full h-[400px] xs:h-[420px] sm:h-[460px] md:h-[500px] lg:h-[520px] select-none">

        @foreach ($sliders as $slide)
          @php
            $bc = $heroBadge[$slide->badge_color] ?? $heroBadge['orange'];
            $hl = $heroHighlight[$slide->highlight_color] ?? $heroHighlight['yellow'];
            $headingTag = $loop->first ? 'h1' : 'h2';
          @endphp
          <div class="hero-slide {{ $loop->first ? 'active' : '' }}">
            <img src="{{ $imgUrl($slide->image) }}" alt="{{ $slide->image_alt ?: strip_tags($slide->title_line1) }}"
              class="hero-bg-img absolute inset-0 w-full h-full object-cover" @if (!$loop->first) loading="lazy" @endif>

            <!-- Scrim / Gradient Overlay -->
            <div
              class="absolute inset-0 bg-gradient-to-r from-[#073B73]/95 via-[#073B73]/80 md:via-[#073B73]/50 to-transparent">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#073B73]/80 via-transparent to-transparent"></div>

            <!-- Content -->
            <div class="relative max-w-7xl mx-auto px-4 sm:px-8 md:px-12 w-full h-full flex items-center z-10">
              <div class="max-w-xl text-white space-y-2.5 sm:space-y-4 py-4 sm:py-6">

                @if ($slide->badge_text)
                  <div
                    class="inline-flex items-center gap-1.5 sm:gap-2 {{ $bc['wrap'] }} text-[10px] sm:text-xs font-bold font-heading px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full shadow-md tracking-wider uppercase">
                    @if ($slide->badge_icon)
                      <i class="fa-solid {{ $slide->badge_icon }} {{ $bc['icon'] }}"></i>
                    @endif
                    <span>{{ $slide->badge_text }}</span>
                  </div>
                @endif

                <{{ $headingTag }}
                  class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold font-heading leading-tight tracking-tight text-white drop-shadow-md">
                  {{ $slide->title_line1 }}@if ($slide->title_line2)<br><span class="{{ $hl }}">{{ $slide->title_line2 }}</span>@endif
                </{{ $headingTag }}>

                @if ($slide->description)
                  <p
                    class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed max-w-md line-clamp-2 sm:line-clamp-none">
                    {{ $slide->description }}
                  </p>
                @endif

                @if ($slide->btn1_text || $slide->btn2_text)
                  <div class="pt-1 sm:pt-2 flex flex-wrap items-center gap-2 sm:gap-3">
                    @if ($slide->btn1_text)
                      <a href="{{ $href($slide->btn1_link) }}"
                        class="btn-play-orange text-xs sm:text-sm px-5 sm:px-8 py-2.5 sm:py-3.5 rounded-xl shadow-lg flex items-center gap-1.5 sm:gap-2 whitespace-nowrap">
                        <span>{{ $slide->btn1_text }}</span>
                      </a>
                    @endif
                    @if ($slide->btn2_text)
                      <a href="{{ $href($slide->btn2_link) }}"
                        class="bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-bold font-heading px-4 sm:px-6 py-2.5 sm:py-3.5 rounded-xl border border-white/40 backdrop-blur-md transition whitespace-nowrap">
                        {{ $slide->btn2_text }}
                      </a>
                    @endif
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach

        @if ($sliders->count() > 1)
          <!-- Floating Navigation Arrows (sm and up) -->
          <button id="hero-prev"
            class="hidden sm:flex absolute left-3 md:left-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/20 hover:bg-brand-orange text-white items-center justify-center transition backdrop-blur-md z-20 shadow-lg border border-white/30 cursor-pointer"
            aria-label="Previous Slide">
            <i class="fa-solid fa-chevron-left text-sm"></i>
          </button>
          <button id="hero-next"
            class="hidden sm:flex absolute right-3 md:right-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/20 hover:bg-brand-orange text-white items-center justify-center transition backdrop-blur-md z-20 shadow-lg border border-white/30 cursor-pointer"
            aria-label="Next Slide">
            <i class="fa-solid fa-chevron-right text-sm"></i>
          </button>

          <!-- Slide Indicators -->
          <div
            class="absolute bottom-2.5 sm:bottom-4 inset-x-0 flex items-center justify-center gap-1.5 sm:gap-2 z-20 px-2 sm:px-4">
            @foreach ($sliders as $slide)
              <button
                class="hero-dot flex items-center gap-1.5 sm:gap-2 {{ $loop->first ? 'bg-brand-orange text-white shadow-md' : 'bg-black/40 hover:bg-black/60 text-white/80' }} px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading transition"
                data-slide="{{ $loop->index }}">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full {{ $loop->first ? 'bg-white' : 'bg-white/40' }}"></span>
                @if ($slide->nav_label)
                  <span>{{ $slide->nav_label }}</span>
                @endif
              </button>
            @endforeach
          </div>
        @endif

      </div>
    </section>
  @endif

  <!-- 2. TRUST / USP STRIP -->
  @if ($usps->isNotEmpty())
    <section class="bg-white border-b border-brand-border py-4 sm:py-5 shadow-2xs">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-{{ min(max($usps->count(), 1), 4) }} gap-3 sm:gap-5">
          @foreach ($usps as $usp)
            @php $uc = $uspColors[$usp->color] ?? $uspColors['blue']; @endphp
            <div class="flex items-center gap-3 p-2.5 rounded-2xl {{ $uc['wrap'] }} border">
              <div
                class="w-10 h-10 rounded-xl {{ $uc['icon'] }} text-white flex items-center justify-center text-base shrink-0 shadow-xs">
                <i class="fa-solid {{ $usp->icon }}"></i>
              </div>
              <div>
                <h4 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">{{ $usp->title }}</h4>
                @if ($usp->subtitle)
                  <p class="text-[11px] text-body-text font-sans">{{ $usp->subtitle }}</p>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <!-- 3. CATEGORY SECTION -->
  @if ($secOn('categories'))
    @php $S = $sec('categories'); @endphp
    <section class="py-10 sm:py-14 bg-warm-cream/50">
      <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">

        @if ($S && ($S->badge_text || $S->title || $S->subtitle))
          <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-10">
            @if ($S->badge_text)
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading inline-flex items-center gap-1.5 shadow-2xs border border-orange-200/60">
                @if ($S->badge_icon)
                  <i class="fa-solid {{ $S->badge_icon }} text-brand-orange text-xs"></i>
                @endif
                <span>{{ $S->badge_text }}</span>
              </span>
            @endif
            @if ($S->title)
              <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold font-heading text-dark-navy mt-2.5 tracking-tight">
                {{ $S->title }}
              </h2>
            @endif
            @if ($S->subtitle)
              <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans max-w-md mx-auto">{{ $S->subtitle }}</p>
            @endif
          </div>
        @endif

        @if ($categories->isNotEmpty())
          <div id="home-categories-grid"
            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-2.5 sm:gap-3.5 xl:gap-4">
            @foreach ($categories as $cat)
              @php
                $bgClass = $cat->pastel_bg ?: 'bg-soft-orange';
                $tagline = trim(str_replace('→', '', $cat->tagline ?: 'EXPLORE'));
                $img = $imgUrl($cat->image ?: null);
                if (!$cat->image) {
                  $img = asset('assets/images/category-placeholder.png');
                }
              @endphp

              <a href="{{ url('shop') }}?category={{ $cat->slug }}"
                class="category-card group {{ $bgClass }} border border-brand-border/80 hover:border-brand-orange/40 p-2 sm:p-2.5 xl:p-3 rounded-2xl xl:rounded-3xl flex flex-col items-center justify-between text-center shadow-2xs hover:shadow-md transition-all duration-300">
                <div
                  class="w-full aspect-square bg-white rounded-xl sm:rounded-2xl overflow-hidden mb-2 relative flex items-center justify-center p-1 sm:p-1.5 shadow-2xs border border-white/70">
                  <img src="{{ $img }}" alt="{{ $cat->name }}" loading="lazy"
                    class="w-full h-full object-cover rounded-lg sm:rounded-xl group-hover:scale-108 transition-transform duration-500 ease-out">
                  <span
                    class="absolute bottom-1.5 right-1.5 sm:bottom-2 sm:right-2 w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-brand-orange text-white flex items-center justify-center shadow-md text-[10px] sm:text-xs group-hover:scale-110 group-hover:bg-brand-navy border-2 border-white transition duration-200">
                    <i class="fa-solid fa-arrow-right"></i>
                  </span>
                </div>
                <div class="w-full flex flex-col items-center justify-center">
                  <h3
                    class="font-heading font-bold text-dark-navy text-xs sm:text-[13px] xl:text-sm group-hover:text-brand-orange transition leading-tight min-h-[2rem] sm:min-h-[2.25rem] flex items-center justify-center text-center px-0.5">
                    {{ $cat->name }}
                  </h3>
                  <span
                    class="text-[8.5px] sm:text-[9.5px] xl:text-[10.5px] font-bold text-brand-blue font-heading mt-0.5 flex items-center justify-center gap-1 group-hover:text-brand-orange transition uppercase tracking-normal sm:tracking-wide leading-none text-center">
                    <span>{{ $tagline }}</span>
                    <i
                      class="fa-solid fa-arrow-right text-[7px] sm:text-[8px] group-hover:translate-x-0.5 transition-transform"></i>
                  </span>
                </div>
              </a>
            @endforeach
          </div>
        @else
          <p class="text-center text-sm text-body-text font-sans py-6">Categories are coming soon.</p>
        @endif

      </div>
    </section>
  @endif

  <!-- 4. TRENDING PRODUCTS -->
  @php
    $trendingLabels = [
      'new_arrival' => 'NEW ARRIVALS',
      'best_seller' => 'BEST SELLERS',
      'trending' => 'TRENDING',
    ];
  @endphp
  @if ($secOn('trending'))
    @php $S = $sec('trending'); @endphp
    <section class="py-12 md:py-16 bg-white border-y border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
          <div>
            @if ($S?->badge_text)
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3 py-1 rounded-full font-heading">
                {{ $S->badge_text }}
              </span>
            @endif
            @if ($S?->title)
              <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy mt-2">{{ $S->title }}</h2>
            @endif
            @if ($S?->subtitle)
              <p class="text-xs sm:text-sm text-body-text mt-1 font-sans">{{ $S->subtitle }}</p>
            @endif
          </div>

          <!-- Tabs -->
          <div
            class="w-full sm:w-auto overflow-x-auto no-scrollbar flex items-center justify-between sm:justify-start gap-1 sm:gap-1.5 bg-soft-blue p-1 sm:p-1.5 rounded-2xl border border-brand-border self-start sm:self-auto font-heading">
            @foreach ($trendingLabels as $code => $label)
              <button type="button" data-trending-tab="{{ $code }}"
                class="trending-tab-btn {{ $loop->first ? 'active px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition bg-brand-navy text-white shadow-xs cursor-pointer flex-1 sm:flex-initial text-center' : 'px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition text-dark-navy hover:text-brand-orange cursor-pointer flex-1 sm:flex-initial text-center' }}">
                {{ $label }}
              </button>
            @endforeach
          </div>
        </div>

        @foreach ($trendingLabels as $code => $label)
          <div data-trending-panel="{{ $code }}"
            class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 {{ $loop->first ? '' : 'hidden' }}">
            @forelse ($trendingTabs[$code] as $product)
              @include('front-pages.partials.product-card', ['product' => $product])
            @empty
              <p class="col-span-full text-center text-sm text-body-text font-sans py-10">
                No products here yet. Check back soon!
              </p>
            @endforelse
          </div>
        @endforeach

        @if ($S?->button_text)
          <div class="mt-10 text-center">
            <a href="{{ $href($S->button_link ?: '/shop') }}"
              class="inline-flex items-center gap-2 btn-play-blue text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-md transition font-heading">
              <span>{{ $S->button_text }}</span>
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
        @endif

      </div>
    </section>
  @endif

  <!-- 5. OUR CURRENT FAVOURITES -->
  @if ($secOn('favourites') && $favourites->isNotEmpty())
    @php $S = $sec('favourites'); @endphp
    <section class="py-12 md:py-16 bg-warm-cream">
      <div class="max-w-7xl mx-auto px-4">

        @if ($S && ($S->badge_text || $S->title || $S->subtitle))
          <div class="text-center max-w-xl mx-auto mb-10">
            @if ($S->badge_text)
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
                {{ $S->badge_text }}
              </span>
            @endif
            @if ($S->title)
              <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">{{ $S->title }}</h2>
            @endif
            @if ($S->subtitle)
              <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">{{ $S->subtitle }}</p>
            @endif
          </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">

          @foreach ($favourites as $product)
            @php
              $img = $product->images->firstWhere('is_default', 1) ?? $product->images->first();
              $favImg = $img ? asset('storage/' . $img->image) : asset('assets/images/placeholder.png');
              $pastel = $loop->odd ? 'bg-soft-yellow' : 'bg-soft-blue';
              $btnClass = $loop->odd ? 'btn-play-orange' : 'btn-play-blue';
              $hasDisc = $product->mrp && $product->mrp > $product->price;
              $discPct = $hasDisc ? round((($product->mrp - $product->price) / $product->mrp) * 100) : 0;

              $badge = $product->collections->first(fn($c) => filled($c->badge_text));
              $badgeColor = (string) ($badge->badge_color ?? '');
              $badgeHex = Str::startsWith($badgeColor, '#');
              $badgeClass = $badgeHex ? 'text-white' : ($badgeColor ?: 'bg-brand-orange text-white');
            @endphp

            <div
              class="bg-white rounded-3xl border border-brand-border p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6 shadow-sm hover:shadow-lg transition duration-300">
              <div
                class="w-full md:w-1/2 aspect-square {{ $pastel }} rounded-2xl p-6 flex items-center justify-center relative shrink-0">
                @if ($badge)
                  <span
                    class="absolute top-3 left-3 {{ $badgeClass }} text-[10px] font-bold px-2.5 py-0.5 rounded-full font-heading uppercase"
                    @if ($badgeHex) style="background-color: {{ $badgeColor }}" @endif>
                    {{ $badge->badge_text }}
                  </span>
                @endif
                <img src="{{ $favImg }}" alt="{{ $product->name }}" loading="lazy"
                  class="max-h-52 w-auto object-contain drop-shadow-sm">
              </div>
              <div class="flex-1 space-y-2.5">
                <span class="text-xs font-bold text-brand-blue uppercase tracking-wider font-heading">
                  {{ $product->category->name ?? '' }}@if ($product->age_label) • AGE {{ $product->age_label }}@endif
                </span>
                <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">{{ $product->name }}</h3>
                @if ($product->short_description)
                  <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans line-clamp-3">
                    {{ $product->short_description }}
                  </p>
                @endif
                <div class="flex items-baseline gap-2 pt-1 font-heading">
                  <span class="text-xl font-bold text-brand-navy">₹{{ number_format($product->price) }}</span>
                  @if ($hasDisc)
                    <span class="text-xs text-brand-muted line-through">₹{{ number_format($product->mrp) }}</span>
                    <span class="text-xs font-bold text-brand-orange bg-soft-orange px-2 py-0.5 rounded-full">{{ $discPct }}%
                      OFF</span>
                  @endif
                </div>
                <div class="pt-2">
                  <a href="{{ route('product', ['slug' => $product->slug]) }}"
                    class="inline-flex items-center gap-2 {{ $btnClass }} text-xs px-6 py-2.5 rounded-xl shadow-xs transition font-heading">
                    <span>VIEW PRODUCT</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                  </a>
                </div>
              </div>
            </div>
          @endforeach

        </div>

      </div>
    </section>
  @endif

  <!-- 6. SHOP BY AGE -->
  <section class="py-12 md:py-16 bg-white border-t border-brand-border">
    <div class="max-w-7xl mx-auto px-4">

      <div class="text-center max-w-2xl mx-auto mb-10">
        <span
          class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3.5 py-1 rounded-full font-heading">
          AGE DISCOVERY
        </span>
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">
          FIND THE RIGHT FIT FOR THEIR AGE
        </h2>
        <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">
          Developmentally aligned play equipment curated for every growth milestone.
        </p>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5">

        <a href="{{ route('shop') }}?age=0-2"
          class="age-card bg-soft-orange border border-orange-200 p-4 sm:p-5 flex flex-col items-center text-center group">
          <div
            class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-brand-orange mb-3 group-hover:scale-110 transition">
            <i class="fa-solid fa-baby"></i>
          </div>
          <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">0–2 Years</span>
          <span class="text-xs font-bold text-brand-orange font-heading mt-0.5">Little Discoverers</span>
          <p class="text-[11px] text-body-text font-sans mt-1">Sensory, textures & soft building</p>
        </a>

        <a href="{{ route('shop') }}?age=3-5"
          class="age-card bg-soft-yellow border border-amber-200 p-4 sm:p-5 flex flex-col items-center text-center group">
          <div
            class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-amber-500 mb-3 group-hover:scale-110 transition">
            <i class="fa-solid fa-puzzle-piece"></i>
          </div>
          <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">3–5 Years</span>
          <span class="text-xs font-bold text-amber-600 font-heading mt-0.5">Curious Explorers</span>
          <p class="text-[11px] text-body-text font-sans mt-1">Blocks, creative art & basic puzzles</p>
        </a>

        <a href="{{ route('shop') }}?age=6-8"
          class="age-card bg-soft-blue border border-blue-200 p-4 sm:p-5 flex flex-col items-center text-center group">
          <div
            class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-brand-blue mb-3 group-hover:scale-110 transition">
            <i class="fa-solid fa-rocket"></i>
          </div>
          <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">6–8 Years</span>
          <span class="text-xs font-bold text-brand-blue font-heading mt-0.5">Active Adventurers</span>
          <p class="text-[11px] text-body-text font-sans mt-1">Starter sports, lawn games & sets</p>
        </a>

        <a href="{{ route('shop') }}?age=9-12"
          class="age-card bg-soft-mint border border-emerald-200 p-4 sm:p-5 flex flex-col items-center text-center group">
          <div
            class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-emerald-600 mb-3 group-hover:scale-110 transition">
            <i class="fa-solid fa-microscope"></i>
          </div>
          <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">9–12 Years</span>
          <span class="text-xs font-bold text-emerald-600 font-heading mt-0.5">Creative Thinkers</span>
          <p class="text-[11px] text-body-text font-sans mt-1">STEM robotics & team athletics</p>
        </a>

        <a href="{{ route('shop') }}?age=12+"
          class="age-card bg-soft-purple border border-purple-200 p-4 sm:p-5 flex flex-col items-center text-center group col-span-2 sm:col-span-1">
          <div
            class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-purple-600 mb-3 group-hover:scale-110 transition">
            <i class="fa-solid fa-crown"></i>
          </div>
          <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">12+ Years</span>
          <span class="text-xs font-bold text-purple-600 font-heading mt-0.5">Big Kids & Teens</span>
          <p class="text-[11px] text-body-text font-sans mt-1">Strategy boards, match gear & family</p>
        </a>

      </div>

    </div>
  </section>

  <!-- 7. SHOP BY INTEREST -->
  @if ($secOn('interests') && $interests->isNotEmpty())
    @php $S = $sec('interests'); @endphp
    <section class="py-12 md:py-16 bg-warm-cream">
      <div class="max-w-7xl mx-auto px-4">

        @if ($S && ($S->badge_text || $S->title || $S->subtitle))
          <div class="text-center max-w-xl mx-auto mb-10">
            @if ($S->badge_text)
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
                {{ $S->badge_text }}
              </span>
            @endif
            @if ($S->title)
              <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">{{ $S->title }}</h2>
            @endif
            @if ($S->subtitle)
              <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">{{ $S->subtitle }}</p>
            @endif
          </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
          @foreach ($interests as $interest)
            @php $ic = $interestColors[$interest->color] ?? $interestColors['orange']; @endphp
            <a href="{{ $href($interest->link) }}" class="interest-card {{ $ic['card'] }} border p-4 text-center group">
              <div
                class="w-12 h-12 rounded-2xl {{ $ic['icon'] }} flex items-center justify-center text-lg mx-auto mb-2 shadow-xs group-hover:scale-110 transition">
                <i class="fa-solid {{ $interest->icon }}"></i>
              </div>
              <span class="font-heading font-bold text-dark-navy text-sm block">{{ $interest->title }}</span>
              @if ($interest->subtitle)
                <span class="text-[11px] text-body-text font-sans">{{ $interest->subtitle }}</span>
              @endif
            </a>
          @endforeach
        </div>

      </div>
    </section>
  @endif

  <!-- 8. FEATURED CATEGORY SECTION -->
  @if ($spotlightCategory && $spotlightProducts->isNotEmpty())
    <section class="py-12 md:py-16 bg-soft-mint border-y border-emerald-100">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-8 gap-4">
          <div class="max-w-2xl">
            <div class="flex flex-wrap items-center gap-2 mb-2 font-heading text-xs">
              <span class="bg-emerald-600 text-white px-3 py-0.5 rounded-full font-bold uppercase">
                {{ $spotlightCategory->name }}
              </span>
              @foreach ($spotlightCategory->children->take(3) as $sub)
                <a href="{{ url('shop') }}?category={{ $spotlightCategory->slug }}&q={{ urlencode($sub->name) }}"
                  class="bg-white text-emerald-800 border border-emerald-200 hover:border-emerald-400 px-3 py-0.5 rounded-full font-bold uppercase transition">
                  {{ $sub->name }}
                </a>
              @endforeach
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy uppercase">
              {{ $spotlightCategory->sub_title ?: $spotlightCategory->name }}
            </h2>
            @if ($spotlightCategory->description)
              <p class="text-xs sm:text-sm text-body-text mt-2 font-sans line-clamp-3">
                {{ $spotlightCategory->description }}
              </p>
            @endif
          </div>

          <a href="{{ url('shop') }}?category={{ $spotlightCategory->slug }}"
            class="btn-play-blue text-xs sm:text-sm px-6 py-3 rounded-xl shadow-xs self-start lg:self-auto font-heading">
            <span>EXPLORE {{ strtoupper($spotlightCategory->name) }} →</span>
          </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
          @foreach ($spotlightProducts as $product)
            @include('front-pages.partials.product-card', ['product' => $product])
          @endforeach
        </div>

      </div>
    </section>
  @endif

  <!-- 9. SECOND FEATURED CATEGORY SECTION -->
  @if ($secondCategory && $secondProducts->isNotEmpty())
    <section class="py-12 md:py-16 bg-soft-blue border-b border-blue-100">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-8 gap-4">
          <div class="max-w-2xl">
            <span
              class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-white border border-blue-200 px-3 py-1 rounded-full font-heading">
              {{ $secondCategory->name }}
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2 uppercase">
              {{ $secondCategory->sub_title ?: $secondCategory->name }}
            </h2>
            @if ($secondCategory->description)
              <p class="text-xs sm:text-sm text-body-text mt-2 font-sans line-clamp-3">
                {{ $secondCategory->description }}
              </p>
            @endif
          </div>

          <a href="{{ url('shop') }}?category={{ $secondCategory->slug }}"
            class="btn-play-orange text-xs sm:text-sm px-6 py-3 rounded-xl shadow-xs self-start lg:self-auto font-heading">
            <span>SHOP {{ strtoupper($secondCategory->name) }} →</span>
          </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
          @foreach ($secondProducts as $product)
            @include('front-pages.partials.product-card', ['product' => $product])
          @endforeach
        </div>

      </div>
    </section>
  @endif

  <!-- 10. PROMOTIONAL BANNER -->
  @if ($secOn('promo_banner') && $sec('promo_banner') && ($sec('promo_banner')->title || $sec('promo_banner')->subtitle))
    @php $S = $sec('promo_banner'); @endphp
    <section class="py-12 md:py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4">

        <div
          class="bg-gradient-to-r from-brand-navy via-brand-blue to-brand-navy rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden shadow-xl">
          <div class="absolute -right-8 -bottom-8 w-48 h-48 rounded-full bg-brand-orange/30 blur-2xl pointer-events-none">
          </div>
          <div class="absolute top-4 right-1/4 text-play-yellow text-2xl deco-star"><i class="fa-solid fa-star"></i>
          </div>
          <div class="absolute bottom-6 left-1/3 text-sky-blue text-xl deco-star"><i class="fa-solid fa-sparkles"></i>
          </div>

          <div class="relative z-10 max-w-2xl space-y-3 sm:space-y-4">
            @if ($S->badge_text)
              <span
                class="inline-block bg-brand-orange text-white text-xs font-bold font-heading px-3.5 py-1 rounded-full uppercase tracking-wider">
                {{ $S->badge_text }}
              </span>
            @endif
            @if ($S->title)
              <h2 class="text-2xl sm:text-4xl md:text-5xl font-bold font-heading leading-tight">
                {{ $S->title }}@if ($S->title_highlight)<br><span class="text-play-yellow">{{ $S->title_highlight }}</span>@endif
              </h2>
            @endif
            @if ($S->subtitle)
              <p class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed">{{ $S->subtitle }}</p>
            @endif
            @if ($S->button_text)
              <div class="pt-2">
                <a href="{{ $href($S->button_link ?: '/shop') }}"
                  class="inline-flex items-center gap-2 btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-lg transition font-heading">
                  <span>{{ $S->button_text }}</span>
                </a>
              </div>
            @endif
          </div>
        </div>

      </div>
    </section>
  @endif

  <!-- 11. WHY FAMILIES LOVE US -->
  @if ($secOn('why_us') && $features->isNotEmpty())
    @php $S = $sec('why_us'); @endphp
    <section class="py-12 md:py-16 bg-warm-cream border-t border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        @if ($S && ($S->badge_text || $S->title || $S->subtitle))
          <div class="text-center max-w-xl mx-auto mb-10">
            @if ($S->badge_text)
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3.5 py-1 rounded-full font-heading">
                {{ $S->badge_text }}
              </span>
            @endif
            @if ($S->title)
              <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">{{ $S->title }}</h2>
            @endif
            @if ($S->subtitle)
              <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">{{ $S->subtitle }}</p>
            @endif
          </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
          @foreach ($features as $feature)
            <div
              class="bg-white p-5 rounded-2xl border border-brand-border text-center space-y-2.5 shadow-2xs {{ $loop->last && $loop->count % 2 === 1 ? 'col-span-1 sm:col-span-2 lg:col-span-1' : '' }}">
              <div
                class="w-12 h-12 rounded-2xl {{ $featureColors[$feature->color] ?? $featureColors['blue'] }} flex items-center justify-center text-xl mx-auto">
                <i class="fa-solid {{ $feature->icon }}"></i>
              </div>
              <h4 class="font-heading font-bold text-sm text-dark-navy">{{ $feature->title }}</h4>
              @if ($feature->description)
                <p class="text-[11px] text-body-text font-sans leading-relaxed">{{ $feature->description }}</p>
              @endif
            </div>
          @endforeach
        </div>

      </div>
    </section>
  @endif

  <!-- 12. TESTIMONIALS SLIDER -->
  @if ($secOn('testimonials') && $testimonials->isNotEmpty())
    @php
      $S = $sec('testimonials');
      $tExtra = $S ? $extraOf($S) : [];
    @endphp
    <section class="py-12 md:py-16 bg-white border-t border-brand-border overflow-hidden">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 sm:mb-10 gap-4">
          <div>
            @if ($S?->badge_text)
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading inline-flex items-center gap-1.5 shadow-2xs border border-orange-200/60">
                @if ($S->badge_icon)
                  <i class="fa-solid {{ $S->badge_icon }} text-brand-orange text-xs"></i>
                @endif
                <span>{{ $S->badge_text }}</span>
              </span>
            @endif
            @if ($S?->title)
              <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold font-heading text-dark-navy mt-2.5 tracking-tight">
                {{ $S->title }}
              </h2>
            @endif
            @if ($S?->subtitle)
              <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans max-w-lg">{{ $S->subtitle }}</p>
            @endif
          </div>

          <div class="flex items-center gap-3 sm:gap-4 self-start md:self-auto">
            @if (!empty($tExtra['rating']))
              <div
                class="hidden sm:flex items-center gap-2 bg-soft-yellow/80 border border-amber-200 px-3 py-1.5 rounded-2xl shadow-2xs">
                <div class="flex text-amber-400 text-xs gap-0.5">
                  @for ($s = 1; $s <= 5; $s++)
                    <i class="fa-solid fa-star"></i>
                  @endfor
                </div>
                <span class="text-xs font-bold font-heading text-dark-navy">{{ $tExtra['rating'] }}</span>
                @if (!empty($tExtra['reviews']))
                  <span class="text-[11px] text-brand-muted font-sans">{{ $tExtra['reviews'] }}</span>
                @endif
              </div>
            @endif

            <div class="flex items-center gap-2">
              <button id="testimonial-prev"
                class="w-10 h-10 rounded-full bg-white hover:bg-brand-orange text-dark-navy hover:text-white border border-brand-border hover:border-brand-orange shadow-2xs flex items-center justify-center transition cursor-pointer"
                aria-label="Previous Review">
                <i class="fa-solid fa-arrow-left text-xs"></i>
              </button>
              <button id="testimonial-next"
                class="w-10 h-10 rounded-full bg-white hover:bg-brand-orange text-dark-navy hover:text-white border border-brand-border hover:border-brand-orange shadow-2xs flex items-center justify-center transition cursor-pointer"
                aria-label="Next Review">
                <i class="fa-solid fa-arrow-right text-xs"></i>
              </button>
            </div>
          </div>
        </div>

        <div id="testimonial-slider-container" class="relative overflow-hidden select-none -mx-2 px-2 py-2">
          <div id="testimonial-track" class="flex transition-transform duration-500 ease-out">

            @foreach ($testimonials as $t)
              @php
                $tc = $testiColors[$t->color] ?? $testiColors['yellow'];
                $rate = (int) ($t->rating ?: 5);
              @endphp
              <div class="testimonial-slide w-full md:w-1/2 lg:w-1/3 shrink-0 px-2 sm:px-3">
                <div
                  class="bg-gradient-to-br {{ $tc['card'] }} border p-6 sm:p-7 rounded-3xl flex flex-col justify-between h-full relative overflow-hidden shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300">
                  <i
                    class="fa-solid fa-quote-right absolute top-5 right-5 text-4xl {{ $tc['quote'] }} pointer-events-none"></i>
                  <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                      <div class="flex text-xs gap-0.5">
                        @for ($s = 1; $s <= 5; $s++)
                          <i class="fa-solid fa-star {{ $s <= $rate ? 'text-amber-400' : 'text-gray-300' }}"></i>
                        @endfor
                      </div>
                      @if ($t->product_tag)
                        <span
                          class="text-[10px] font-bold {{ $tc['tag'] }} border px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-heading">
                          @if ($t->tag_icon)
                            <i class="fa-solid {{ $t->tag_icon }} {{ $tc['tagicon'] }} text-[9px]"></i>
                          @endif
                          {{ $t->product_tag }}
                        </span>
                      @endif
                    </div>
                    <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed italic mb-4">
                      "{{ $t->review }}"
                    </p>
                  </div>
                  <div class="pt-4 border-t {{ $tc['line'] }} flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                      <div
                        class="w-9 h-9 rounded-full {{ $tc['avatar'] }} text-white font-heading font-bold text-xs flex items-center justify-center shadow-xs">
                        {{ $initials($t->customer_name) }}
                      </div>
                      <div>
                        <h5 class="font-heading font-bold text-dark-navy text-xs sm:text-sm leading-tight">
                          {{ $t->customer_name }}</h5>
                        @if ($t->customer_title)
                          <span class="text-[11px] text-brand-muted font-sans">{{ $t->customer_title }}</span>
                        @endif
                      </div>
                    </div>
                    @if ($t->is_verified)
                      <span
                        class="text-[10px] font-bold text-emerald-700 bg-emerald-100/90 px-2 py-0.5 rounded-full font-heading inline-flex items-center gap-1 shrink-0">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i> Verified
                      </span>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach

          </div>
        </div>

        <div id="testimonial-dots" class="flex items-center justify-center gap-2 mt-6 sm:mt-8"></div>

      </div>
    </section>
  @endif

   <!-- 13. BLOG SECTION -->
  @if ($secOn('blogs') && $blogs->isNotEmpty())
    @php $S = $sec('blogs'); @endphp
    <section class="py-12 md:py-16 bg-warm-cream border-t border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
          <div>
            @if ($S?->badge_text)
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3.5 py-1 rounded-full font-heading">
                {{ $S->badge_text }}
              </span>
            @endif
            @if ($S?->title)
              <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy mt-2">{{ $S->title }}</h2>
            @endif
            @if ($S?->subtitle)
              <p class="text-xs sm:text-sm text-body-text mt-1 font-sans">{{ $S->subtitle }}</p>
            @endif
          </div>
          @if ($S?->button_text)
            <a href="{{ $href($S->button_link ?: route('blogs')) }}"
              class="text-xs sm:text-sm font-bold font-heading text-brand-blue hover:text-brand-orange transition flex items-center gap-1.5 self-start sm:self-auto">
              <span>{{ $S->button_text }}</span>
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach ($blogs as $blog)
            @include('front-pages.partials.blog-card', ['blog' => $blog])
          @endforeach
        </div>

      </div>
    </section>
  @endif
@endsection

@push('scripts')
  <!-- HOMEPAGE SCRIPT -->
  <script type="module">

    document.addEventListener('DOMContentLoaded', () => {

      // 1. Trending tabs (panels are server-rendered, just toggle visibility)
      const tabBtns = document.querySelectorAll('[data-trending-tab]');
      const tabPanels = document.querySelectorAll('[data-trending-panel]');
      const tabOn = 'trending-tab-btn active px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition bg-brand-navy text-white shadow-xs cursor-pointer flex-1 sm:flex-initial text-center';
      const tabOff = 'trending-tab-btn px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition text-dark-navy hover:text-brand-orange cursor-pointer flex-1 sm:flex-initial text-center';

      tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          const key = btn.dataset.trendingTab;
          tabBtns.forEach(b => b.className = b === btn ? tabOn : tabOff);
          tabPanels.forEach(p => p.classList.toggle('hidden', p.dataset.trendingPanel !== key));
        });
      });


      // 2. Hero Slider Carousel logic
      const slides = document.querySelectorAll('.hero-slide');
      const dots = document.querySelectorAll('.hero-dot');
      let currentSlide = 0;
      let slideInterval = null;

      const showSlide = (idx) => {
        slides.forEach((s, i) => s.classList.toggle('active', i === idx));
        dots.forEach((d, i) => {
          const dotSpan = d.querySelector('span:first-child');
          if (i === idx) {
            d.className = 'hero-dot flex items-center gap-1.5 sm:gap-2 bg-brand-orange text-white px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading shadow-md transition';
            if (dotSpan) dotSpan.className = 'w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white';
          } else {
            d.className = 'hero-dot flex items-center gap-1.5 sm:gap-2 bg-black/40 hover:bg-black/60 text-white/80 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading transition';
            if (dotSpan) dotSpan.className = 'w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white/40';
          }
        });
        currentSlide = idx;
      };

      const nextSlide = () => {
        if (!slides.length) return;
        showSlide((currentSlide + 1) % slides.length);
      };

      const prevSlide = () => {
        if (!slides.length) return;
        showSlide((currentSlide - 1 + slides.length) % slides.length);
      };

      document.getElementById('hero-next')?.addEventListener('click', nextSlide);
      document.getElementById('hero-prev')?.addEventListener('click', prevSlide);
      dots.forEach(dot => {
        dot.addEventListener('click', () => {
          const idx = parseInt(dot.getAttribute('data-slide'));
          showSlide(idx);
        });
      });

      const startAutoSlide = () => {
        if (slides.length < 2) return;
        slideInterval = setInterval(nextSlide, 5500);
      };
      const stopAutoSlide = () => {
        if (slideInterval) clearInterval(slideInterval);
      };

      const heroContainer = document.getElementById('hero-slider');
      heroContainer?.addEventListener('mouseenter', stopAutoSlide);
      heroContainer?.addEventListener('mouseleave', startAutoSlide);
      startAutoSlide();

      // Mobile Touch Swipe on Hero Slider
      let touchStartX = 0;
      let touchEndX = 0;
      heroContainer?.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });
      heroContainer?.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        if (touchEndX < touchStartX - 40) nextSlide();
        if (touchEndX > touchStartX + 40) prevSlide();
      }, { passive: true });

      // 7. Testimonial Carousel Logic
      const tTrack = document.getElementById('testimonial-track');
      const tPrev = document.getElementById('testimonial-prev');
      const tNext = document.getElementById('testimonial-next');
      const tDotsContainer = document.getElementById('testimonial-dots');
      const tContainer = document.getElementById('testimonial-slider-container');
      const tSlides = document.querySelectorAll('.testimonial-slide');

      if (tTrack && tSlides.length) {
        let tIndex = 0;
        let tInterval = null;

        const getCardsPerView = () => {
          if (window.innerWidth >= 1024) return 3;
          if (window.innerWidth >= 768) return 2;
          return 1;
        };

        const getMaxIndex = () => Math.max(0, tSlides.length - getCardsPerView());

        const renderDots = () => {
          if (!tDotsContainer) return;
          const maxIdx = getMaxIndex();
          tDotsContainer.innerHTML = '';
          if (maxIdx === 0) return;
          for (let i = 0; i <= maxIdx; i++) {
            const dot = document.createElement('button');
            dot.className = i === tIndex
              ? 'w-7 h-2.5 bg-brand-orange rounded-full transition-all duration-300 cursor-pointer shadow-xs'
              : 'w-2.5 h-2.5 bg-gray-300 hover:bg-gray-400 rounded-full transition-all duration-300 cursor-pointer';
            dot.setAttribute('aria-label', `Go to testimonial slide ${i + 1}`);
            dot.addEventListener('click', () => {
              tIndex = i;
              updateTestimonialSlider();
            });
            tDotsContainer.appendChild(dot);
          }
        };

        const updateTestimonialSlider = () => {
          const perView = getCardsPerView();
          const maxIdx = getMaxIndex();
          if (tIndex > maxIdx) tIndex = maxIdx;
          if (tIndex < 0) tIndex = 0;

          tTrack.style.transform = `translateX(-${tIndex * (100 / perView)}%)`;
          renderDots();
        };

        const nextTestimonial = () => {
          const maxIdx = getMaxIndex();
          tIndex = (tIndex >= maxIdx) ? 0 : tIndex + 1;
          updateTestimonialSlider();
        };

        const prevTestimonial = () => {
          const maxIdx = getMaxIndex();
          tIndex = (tIndex <= 0) ? maxIdx : tIndex - 1;
          updateTestimonialSlider();
        };

        tNext?.addEventListener('click', nextTestimonial);
        tPrev?.addEventListener('click', prevTestimonial);

        const startTestimonialAuto = () => {
          if (getMaxIndex() === 0) return;
          tInterval = setInterval(nextTestimonial, 5000);
        };
        const stopTestimonialAuto = () => {
          if (tInterval) clearInterval(tInterval);
        };

        tContainer?.addEventListener('mouseenter', stopTestimonialAuto);
        tContainer?.addEventListener('mouseleave', startTestimonialAuto);
        startTestimonialAuto();

        let tTouchStartX = 0;
        let tTouchEndX = 0;
        tContainer?.addEventListener('touchstart', (e) => {
          tTouchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        tContainer?.addEventListener('touchend', (e) => {
          tTouchEndX = e.changedTouches[0].screenX;
          if (tTouchEndX < tTouchStartX - 40) nextTestimonial();
          if (tTouchEndX > tTouchStartX + 40) prevTestimonial();
        }, { passive: true });

        window.addEventListener('resize', updateTestimonialSlider);

        updateTestimonialSlider();
      }
    });
  </script>
@endpush