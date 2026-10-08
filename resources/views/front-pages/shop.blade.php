@extends('layouts.app')

@section('title', ($activeCategory ? $activeCategory->name : 'Find Something Fun') . ' | Aparatus Pastime - Kids Toys, Games & Sports')
@section('meta_description', $activeCategory->meta_description ?? 'Explore our collection of toys, games, sports and activities for curious little minds and active families.')
@section('active_nav', 'shop')

@section('content')
  @php
    $allSelected = empty($catSlugs);
  @endphp

  <div class="py-6 sm:py-8 lg:py-10">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-4 font-heading">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-dark-navy font-bold">{{ $activeCategory->name ?? 'Shop Play Collection' }}</span>
      </nav>

      <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 mb-6 border-b border-brand-border gap-4">
        <div>
          <span class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3 py-0.5 rounded-full font-heading">CURATED PLAYTIME</span>
          <h1 id="shop-page-title" class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-1">{{ strtoupper($activeCategory->name ?? 'Find Something Fun') }}</h1>
          <p id="shop-product-count" class="text-xs sm:text-sm text-body-text mt-1 font-sans">
            @if ($products->total() > 0)
              Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} curated play product{{ $products->total() === 1 ? '' : 's' }}
            @else
              Explore our collection of toys, games, sports and activities.
            @endif
          </p>
        </div>

        <div class="flex items-center gap-3">
          <button id="mobile-filter-btn" type="button" class="lg:hidden flex items-center gap-2 bg-white hover:bg-soft-blue text-dark-navy px-4 py-2.5 rounded-xl border border-brand-border text-xs font-bold font-heading shadow-2xs transition cursor-pointer">
            <i class="fa-solid fa-sliders text-brand-orange"></i><span>FILTERS</span>
          </button>
          <div class="flex items-center gap-2 text-xs font-heading">
            <label for="sort-select" class="text-brand-muted hidden sm:inline">Sort By:</label>
            <select id="sort-select" class="bg-white border border-brand-border text-dark-navy text-xs font-bold px-3 py-2.5 rounded-xl focus:outline-none focus:border-brand-blue cursor-pointer shadow-2xs">
              <option value="featured" @selected($sort === 'featured')>Featured Picks</option>
              <option value="newest" @selected($sort === 'newest')>Newest Arrivals</option>
              <option value="price-low" @selected($sort === 'price-low')>Price: Low to High</option>
              <option value="price-high" @selected($sort === 'price-high')>Price: High to Low</option>
              <option value="rating" @selected($sort === 'rating')>Customer Rating</option>
            </select>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 xl:gap-8 items-start">

        <!-- DESKTOP SIDEBAR -->
        <aside class="hidden lg:block lg:col-span-3 bg-white rounded-3xl border border-brand-border p-4 xl:p-5 sticky top-24 shadow-2xs">
          <div class="flex items-center justify-between pb-3 mb-5 border-b border-brand-border">
            <div class="flex items-center gap-2 font-heading">
              <i class="fa-solid fa-sliders text-brand-orange"></i>
              <h3 class="font-bold text-sm text-dark-navy">FILTER PLAY</h3>
            </div>
            <a href="{{ route('shop') }}" class="text-xs text-brand-muted hover:text-brand-orange transition font-heading font-bold">Reset</a>
          </div>

          <form method="GET" action="{{ route('shop') }}" class="shop-filter-form space-y-5" data-auto="1">
            <input type="hidden" name="sort" value="{{ $sort }}">
            @if ($collectionSlug)<input type="hidden" name="filter" value="{{ $collectionSlug }}">@endif

            <div>
              <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-dark-navy mb-3 flex items-center gap-1.5"><i class="fa-solid fa-shapes text-brand-blue"></i><span>CATEGORY</span></h4>
              <div class="space-y-1.5 text-xs font-heading">
                <label class="flex items-center justify-between p-2 rounded-xl hover:bg-soft-blue cursor-pointer transition">
                  <div class="flex items-center gap-2"><input type="checkbox" class="filter-cat-all rounded text-brand-blue" @checked($allSelected)><span class="text-dark-navy font-semibold">All Categories</span></div>
                </label>
                @foreach ($categories as $c)
                  <label class="flex items-center justify-between p-2 rounded-xl hover:bg-soft-blue cursor-pointer transition">
                    <div class="flex items-center gap-2"><input type="checkbox" name="category[]" value="{{ $c->slug }}" class="filter-cat-cb rounded text-brand-blue" @checked(in_array($c->slug, $catSlugs))><span class="text-dark-navy font-semibold">{{ $c->name }}</span></div>
                    <span class="text-[10px] text-brand-muted font-bold">{{ $c->products_count }}</span>
                  </label>
                  @foreach ($c->children as $child)
                    <label class="flex items-center gap-2 p-1.5 pl-7 rounded-lg hover:bg-soft-blue cursor-pointer transition">
                      <input type="checkbox" name="category[]" value="{{ $child->slug }}" class="filter-cat-cb rounded text-brand-blue" @checked(in_array($child->slug, $catSlugs))><span class="text-dark-navy font-medium">{{ $child->name }}</span>
                    </label>
                  @endforeach
                @endforeach
              </div>
            </div>

            <div class="pt-4 border-t border-brand-border">
              <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-dark-navy mb-3 flex items-center gap-1.5"><i class="fa-solid fa-child text-brand-orange"></i><span>AGE GROUP</span></h4>
              <div class="space-y-1.5 text-xs font-heading">
                @foreach ($ageGroups as $key => $a)
                  <label class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-soft-blue cursor-pointer">
                    <input type="checkbox" name="age[]" value="{{ $key }}" class="rounded text-brand-blue" @checked(in_array($key, $ages))><span class="text-dark-navy font-semibold">{{ $a['label'] }}</span>
                  </label>
                @endforeach
              </div>
            </div>

            <div class="pt-4 border-t border-brand-border">
              <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-dark-navy mb-3 flex items-center gap-1.5"><i class="fa-solid fa-tags text-emerald-500"></i><span>PRICE RANGE</span></h4>
              <div class="space-y-1.5 text-xs font-heading">
                @foreach ($priceRanges as $key => $p)
                  <label class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-soft-blue cursor-pointer">
                    <input type="radio" name="price" value="{{ $key }}" class="text-brand-blue" @checked($priceKey === $key)><span class="text-dark-navy font-semibold">{{ $p['label'] }}</span>
                  </label>
                @endforeach
              </div>
            </div>

            <div class="pt-4 border-t border-brand-border">
              <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-dark-navy mb-3 flex items-center gap-1.5"><i class="fa-solid fa-star text-play-yellow"></i><span>RATING</span></h4>
              <div class="space-y-1.5 text-xs font-heading">
                @foreach ($ratings as $key => $label)
                  <label class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-soft-blue cursor-pointer">
                    <input type="radio" name="rating" value="{{ $key }}" class="text-brand-blue" @checked($rating === (string) $key)><span class="text-dark-navy font-semibold">{{ $label }}</span>
                  </label>
                @endforeach
              </div>
            </div>
          </form>
        </aside>

        <!-- PRODUCT GRID -->
        <div class="lg:col-span-9 space-y-8 min-w-0">
          @if ($products->count())
            <div id="shop-products-grid" class="grid grid-cols-2 md:grid-cols-3 gap-3.5 sm:gap-4 xl:gap-6">
              @foreach ($products as $product)
                @include('front-pages.partials.product-card', ['product' => $product])
              @endforeach
            </div>

            @if ($products->hasPages())
              <div class="pt-2">{{ $products->links() }}</div>
            @endif
          @else
            <div id="shop-empty-state" class="bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 shadow-2xs">
              <div class="w-20 h-20 rounded-3xl bg-soft-orange text-brand-orange flex items-center justify-center text-3xl mx-auto shadow-inner"><i class="fa-solid fa-box-open"></i></div>
              <h3 class="font-heading font-bold text-xl text-dark-navy">Hmm... we couldn't find that</h3>
              <p class="text-xs sm:text-sm text-body-text max-w-sm mx-auto font-sans">Try adjusting your category, age group or price filters to explore our curated toys and sports gear.</p>
              <a href="{{ route('shop') }}" class="btn-play-orange inline-block text-xs px-6 py-3 rounded-xl transition font-heading">RESET ALL FILTERS</a>
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>

  <!-- MOBILE FILTER DRAWER -->
  <div id="mobile-filter-drawer" class="lg:hidden">
    <div id="mobile-filter-backdrop" class="drawer-backdrop fixed inset-0 z-50 bg-black/60 backdrop-blur-xs transition-opacity duration-300"></div>
    <div class="filter-drawer-panel fixed top-0 right-0 bottom-0 w-[88vw] sm:w-[400px] max-w-[440px] bg-white z-50 shadow-2xl flex flex-col justify-between overflow-hidden">
      <div class="h-1.5 w-full bg-gradient-to-r from-brand-orange via-amber-400 via-emerald-400 via-brand-blue to-purple-500 shrink-0"></div>

      <div class="p-4 bg-gradient-to-b from-[#FFF9F5] to-white border-b border-brand-border/80 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-2.5 font-heading">
          <div class="w-8 h-8 rounded-xl bg-brand-orange text-white flex items-center justify-center text-xs shadow-2xs"><i class="fa-solid fa-sliders"></i></div>
          <div>
            <h3 class="font-bold text-sm sm:text-base text-dark-navy leading-tight">Filter Play Items</h3>
            <span class="text-[10px] text-brand-muted font-sans block">Refine your toy discovery</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <a href="{{ route('shop') }}" class="text-[11px] font-extrabold text-brand-orange hover:text-dark-navy font-heading px-2.5 py-1 bg-orange-50 hover:bg-orange-100 border border-orange-200/80 rounded-lg transition shadow-2xs">Reset All</a>
          <button id="close-mobile-filter" type="button" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-orange-50 text-dark-navy hover:text-brand-orange flex items-center justify-center transition shadow-2xs cursor-pointer" aria-label="Close Filter Drawer"><i class="fa-solid fa-xmark text-base"></i></button>
        </div>
      </div>

      <form method="GET" action="{{ route('shop') }}" class="shop-filter-form contents">
        <input type="hidden" name="sort" value="{{ $sort }}">
        @if ($collectionSlug)<input type="hidden" name="filter" value="{{ $collectionSlug }}">@endif

        <div id="mobile-filters-content" class="p-4 space-y-5 overflow-y-auto flex-1 custom-scrollbar">

          <div class="bg-[#FFF9F5] rounded-2xl p-3.5 border border-orange-200/80 space-y-2.5 shadow-2xs">
            <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-dark-navy flex items-center justify-between">
              <span class="flex items-center gap-1.5 text-brand-orange"><i class="fa-solid fa-shapes"></i><span>CATEGORY</span></span>
              <span class="text-[9px] bg-orange-100 text-brand-orange font-bold px-1.5 py-0.5 rounded-full">Select multiple</span>
            </h4>
            <div class="space-y-1.5 text-xs font-heading">
              <label class="flex items-center justify-between p-2 rounded-xl bg-white hover:bg-orange-50/60 border border-orange-100 cursor-pointer transition">
                <div class="flex items-center gap-2"><input type="checkbox" class="filter-cat-all rounded text-brand-blue" @checked($allSelected)><span class="text-dark-navy font-semibold">All Categories</span></div>
              </label>
              @foreach ($categories as $c)
                <label class="flex items-center justify-between p-2 rounded-xl bg-white hover:bg-orange-50/60 border border-orange-100 cursor-pointer transition">
                  <div class="flex items-center gap-2"><input type="checkbox" name="category[]" value="{{ $c->slug }}" class="filter-cat-cb rounded text-brand-blue" @checked(in_array($c->slug, $catSlugs))><span class="text-dark-navy font-semibold">{{ $c->name }}</span></div>
                  <span class="text-[10px] text-brand-muted font-bold">{{ $c->products_count }}</span>
                </label>
                @foreach ($c->children as $child)
                  <label class="flex items-center gap-2 p-2 pl-7 rounded-xl bg-white hover:bg-orange-50/60 border border-orange-100 cursor-pointer transition">
                    <input type="checkbox" name="category[]" value="{{ $child->slug }}" class="filter-cat-cb rounded text-brand-blue" @checked(in_array($child->slug, $catSlugs))><span class="text-dark-navy font-medium">{{ $child->name }}</span>
                  </label>
                @endforeach
              @endforeach
            </div>
          </div>

          <div class="bg-[#F6FAFD] rounded-2xl p-3.5 border border-blue-200/80 space-y-2.5 shadow-2xs">
            <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-dark-navy flex items-center justify-between">
              <span class="flex items-center gap-1.5 text-brand-blue"><i class="fa-solid fa-child"></i><span>AGE GROUP</span></span>
              <span class="text-[9px] bg-blue-100 text-brand-blue font-bold px-1.5 py-0.5 rounded-full">Milestones</span>
            </h4>
            <div class="space-y-1.5 text-xs font-heading">
              @foreach ($ageGroups as $key => $a)
                <label class="flex items-center gap-2 p-2 rounded-xl bg-white hover:bg-blue-50/60 border border-blue-100 cursor-pointer transition">
                  <input type="checkbox" name="age[]" value="{{ $key }}" class="rounded text-brand-blue" @checked(in_array($key, $ages))><span class="text-dark-navy font-semibold">{{ $a['label'] }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div class="bg-[#F4FAF6] rounded-2xl p-3.5 border border-emerald-200/80 space-y-2.5 shadow-2xs">
            <h4 class="font-heading font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 text-emerald-600"><i class="fa-solid fa-tags"></i><span>PRICE RANGE</span></h4>
            <div class="space-y-1.5 text-xs font-heading">
              @foreach ($priceRanges as $key => $p)
                <label class="flex items-center gap-2 p-2 rounded-xl bg-white hover:bg-emerald-50/60 border border-emerald-100 cursor-pointer transition">
                  <input type="radio" name="price" value="{{ $key }}" class="text-brand-blue" @checked($priceKey === $key)><span class="text-dark-navy font-semibold">{{ $p['label'] }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div class="bg-[#FFFDF0] rounded-2xl p-3.5 border border-amber-200/80 space-y-2.5 shadow-2xs">
            <h4 class="font-heading font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 text-amber-600"><i class="fa-solid fa-star text-play-yellow"></i><span>CUSTOMER RATING</span></h4>
            <div class="space-y-1.5 text-xs font-heading">
              @foreach ($ratings as $key => $label)
                <label class="flex items-center gap-2 p-2 rounded-xl bg-white hover:bg-amber-50/60 border border-amber-100 cursor-pointer transition">
                  <input type="radio" name="rating" value="{{ $key }}" class="text-brand-blue" @checked($rating === (string) $key)><span class="text-dark-navy font-semibold">{{ $label }}</span>
                </label>
              @endforeach
            </div>
          </div>

        </div>

        <div class="p-4 bg-gradient-to-t from-slate-50 to-white border-t border-brand-border/80 shrink-0">
          <button type="submit" class="w-full btn-play-orange font-bold text-xs sm:text-sm py-3 px-4 rounded-xl shadow-md transition cursor-pointer flex items-center justify-center gap-2 font-heading">
            <i class="fa-solid fa-check"></i><span>APPLY FILTERS</span>
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Sort — keep every other filter in the URL, reset to page 1
      const sortSelect = document.getElementById('sort-select');
      sortSelect?.addEventListener('change', () => {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortSelect.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
      });

      // Filter forms: "All Categories" logic + auto-submit on desktop
      document.querySelectorAll('.shop-filter-form').forEach(form => {
        const all  = form.querySelector('.filter-cat-all');
        const cats = form.querySelectorAll('.filter-cat-cb');

        all?.addEventListener('change', () => {
          if (all.checked) cats.forEach(c => c.checked = false);
          else all.checked = true;
        });
        cats.forEach(c => c.addEventListener('change', () => {
          if (c.checked && all) all.checked = false;
          if (all && ![...cats].some(x => x.checked)) all.checked = true;
        }));

        if (form.dataset.auto === '1') form.addEventListener('change', () => form.submit());
      });

      // Mobile drawer
      const drawer   = document.getElementById('mobile-filter-drawer');
      const backdrop = drawer.querySelector('.drawer-backdrop');
      const panel    = drawer.querySelector('.filter-drawer-panel');
      const setOpen  = (open) => {
        backdrop.classList.toggle('active', open);
        panel.classList.toggle('active', open);
        document.body.style.overflow = open ? 'hidden' : '';
      };
      document.getElementById('mobile-filter-btn')?.addEventListener('click', () => setOpen(true));
      document.getElementById('close-mobile-filter')?.addEventListener('click', () => setOpen(false));
      document.getElementById('mobile-filter-backdrop')?.addEventListener('click', () => setOpen(false));
    });
  </script>
@endpush