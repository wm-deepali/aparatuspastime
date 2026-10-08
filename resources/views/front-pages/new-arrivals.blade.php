@extends('layouts.app')

@section('title', 'New Arrivals | Aparatus Pastime - Kids Toys & Sports')
@section('meta_description', 'Discover the latest curated additions to Aparatus Pastime. New games, sports gear, and innovative learning toys.')
@section('active_nav', 'new-arrivals')

@section('content')
  <div class="py-6 sm:py-8 lg:py-10">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-4 font-heading">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('shop') }}" class="hover:text-brand-orange transition">Shop</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-dark-navy font-bold">New Arrivals</span>
      </nav>

      <!-- HERO HEADER -->
      <div class="bg-brand-navy rounded-3xl text-white p-6 sm:p-10 mb-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-lg relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-60 h-60 rounded-full bg-brand-orange/25 blur-3xl pointer-events-none"></div>

        <div class="space-y-2 text-center sm:text-left relative z-10">
          <span class="bg-brand-orange text-white text-[11px] font-bold px-3 py-1 rounded-full font-heading uppercase tracking-wider inline-flex items-center gap-1.5">
            <i class="fa-solid fa-sparkles text-play-yellow"></i>
            <span>FRESHLY LAUNCHED</span>
          </span>
          <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-white">NEW ARRIVALS ARE HERE</h1>
          <p class="text-xs sm:text-sm text-white/90 max-w-lg font-sans">
            Hand-picked new additions designed for memorable playtime, tactical challenges, and wholesome athletic energy.
          </p>
        </div>
        <div class="text-center bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl shrink-0 relative z-10">
          <div class="text-2xl font-bold font-heading text-play-yellow">100%</div>
          <div class="text-xs text-white/90 font-heading">Certified Non-Toxic</div>
        </div>
      </div>

      <!-- FILTER & SORT CONTROLS -->
      <div class="flex items-center justify-between pb-4 mb-6 border-b border-brand-border font-heading">
        <div id="new-arrivals-count" class="text-xs sm:text-sm font-bold text-dark-navy">Showing New Launches</div>
        <div class="flex items-center gap-2 text-xs">
          <span class="text-brand-muted hidden sm:inline">Sort By:</span>
          <select id="new-sort" class="bg-white border border-brand-border text-dark-navy text-xs font-bold px-3 py-2 rounded-xl focus:outline-none cursor-pointer shadow-2xs">
            <option value="featured">Featured First</option>
            <option value="price-low">Price: Low to High</option>
            <option value="price-high">Price: High to Low</option>
            <option value="rating">Top Rated</option>
          </select>
        </div>
      </div>

      <!-- PRODUCTS GRID -->
      <div id="new-arrivals-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5 sm:gap-4 xl:gap-6">
        <!-- Injected via JavaScript -->
      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { products } from '{{ asset("assets/js/data/products.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const base = @json(url('/') . '/');

      const grid = document.getElementById('new-arrivals-grid');
      const sortSelect = document.getElementById('new-sort');
      const countLabel = document.getElementById('new-arrivals-count');

      const render = () => {
        let list = products.filter(p => p.newArrival || p.badge === 'New Arrival' || p.id <= 8);
        const sortVal = sortSelect.value;

        if (sortVal === 'price-low') list.sort((a, b) => a.price - b.price);
        else if (sortVal === 'price-high') list.sort((a, b) => b.price - a.price);
        else if (sortVal === 'rating') list.sort((a, b) => b.rating - a.rating);

        countLabel.textContent = `Showing ${list.length} Fresh Items`;
        if (grid) grid.innerHTML = list.map(p => Components.renderProductCard(p, base)).join('');
      };

      sortSelect?.addEventListener('change', render);
      render();
    });
  </script>
@endpush