@extends('layouts.app')

@section('title', 'Search Results | Aparatus Pastime - Kids Toys & Sports')
@section('active_nav', 'shop')

@section('content')
  <div class="py-6 sm:py-8 lg:py-10">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-4 font-heading">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('shop') }}" class="hover:text-brand-orange transition">Shop</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-dark-navy font-bold">Search</span>
      </nav>

      <!-- SEARCH TITLE & QUERY BAR -->
      <div class="pb-6 mb-8 border-b border-brand-border flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 id="search-heading" class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy">
            Search results for <span id="search-query-text" class="text-brand-orange">"..."</span>
          </h1>
          <p id="search-count" class="text-xs sm:text-sm text-body-text mt-1 font-sans">Searching...</p>
        </div>

        <div class="w-full md:w-80">
          <form action="{{ route('search') }}" method="GET" class="relative">
            <input
              type="text"
              name="q"
              id="refine-search-input"
              placeholder="Search toys, games, sports & more..."
              class="w-full pl-10 pr-4 py-2.5 bg-white border border-brand-border rounded-full text-xs text-dark-navy focus:outline-none focus:border-brand-blue font-sans shadow-2xs"
            >
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-brand-blue text-xs"></i>
          </form>
        </div>
      </div>

      <!-- RESULTS GRID -->
      <div id="search-results-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5 sm:gap-4 xl:gap-6">
        <!-- Injected via JavaScript -->
      </div>

      <!-- EMPTY SEARCH STATE -->
      <div id="search-empty-state" class="hidden bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 max-w-xl mx-auto shadow-xs">
        <div class="w-20 h-20 rounded-3xl bg-soft-orange text-brand-orange flex items-center justify-center text-3xl mx-auto shadow-inner">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <h3 class="font-heading font-bold text-xl text-dark-navy">Oops! We couldn't find that.</h3>
        <p class="text-xs sm:text-sm text-body-text max-w-sm mx-auto font-sans leading-relaxed">
          Try searching for football, puzzles, STEM or gifts. Or browse our categories below.
        </p>
        <div class="pt-2 flex flex-wrap gap-2 justify-center font-heading">
          <a href="{{ route('categories') }}" class="btn-play-orange text-xs px-6 py-2.5 rounded-xl shadow-xs transition">
            EXPLORE CATEGORIES
          </a>
          <a href="{{ route('shop') }}" class="bg-white hover:bg-soft-blue text-dark-navy font-bold text-xs px-6 py-2.5 rounded-xl border border-brand-border transition">
            VIEW ALL PRODUCTS
          </a>
        </div>
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

      const query = (new URLSearchParams(window.location.search).get('q') || '').trim();

      const queryText = document.getElementById('search-query-text');
      const countLabel = document.getElementById('search-count');
      const refineInput = document.getElementById('refine-search-input');
      const grid = document.getElementById('search-results-grid');
      const emptyState = document.getElementById('search-empty-state');

      queryText.textContent = query ? `"${query}"` : 'All Products';
      if (refineInput) refineInput.value = query;

      let matched;
      if (query) {
        const q = query.toLowerCase();
        matched = products.filter(p =>
          p.name.toLowerCase().includes(q) ||
          p.categoryName.toLowerCase().includes(q) ||
          p.category.toLowerCase().includes(q) ||
          p.shortDescription.toLowerCase().includes(q) ||
          (p.badge && p.badge.toLowerCase().includes(q))
        );
      } else {
        matched = [...products];
      }

      countLabel.textContent = `Found ${matched.length} matching play item${matched.length === 1 ? '' : 's'}`;

      if (matched.length === 0) {
        grid.innerHTML = '';
        emptyState.classList.remove('hidden');
      } else {
        emptyState.classList.add('hidden');
        grid.innerHTML = matched.map(p => Components.renderProductCard(p, base)).join('');
      }
    });
  </script>
@endpush