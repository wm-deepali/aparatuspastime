@extends('layouts.app')

@section('title', ($q !== '' ? 'Search results for "' . $q . '"' : 'All Products') . ' | Aparatus Pastime - Kids Toys & Sports')
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
          <h1 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy">
            @if ($q !== '')
              Search results for <span class="text-brand-orange">"{{ $q }}"</span>
            @else
              All Products
            @endif
          </h1>
          <p class="text-xs sm:text-sm text-body-text mt-1 font-sans">
            Found {{ $products->total() }} matching play {{ \Illuminate\Support\Str::plural('item', $products->total()) }}
          </p>
        </div>

        <div class="w-full md:w-80">
          <form action="{{ route('search') }}" method="GET" class="relative">
            <input type="text" name="q" value="{{ $q }}" placeholder="Search toys, games, sports & more..."
              class="w-full pl-10 pr-4 py-2.5 bg-white border border-brand-border rounded-full text-xs text-dark-navy focus:outline-none focus:border-brand-blue font-sans shadow-2xs">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-brand-blue text-xs"></i>
          </form>
        </div>
      </div>

      @if ($products->count())

        <!-- SORT -->
        <div class="flex items-center justify-between pb-4 mb-6 font-heading">
          <div class="text-xs sm:text-sm font-bold text-dark-navy">
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}
          </div>
          <form method="GET" action="{{ route('search') }}" class="flex items-center gap-2 text-xs">
            <input type="hidden" name="q" value="{{ $q }}">
            <span class="text-brand-muted hidden sm:inline">Sort By:</span>
            <select name="sort" onchange="this.form.submit()"
              class="bg-white border border-brand-border text-dark-navy text-xs font-bold px-3 py-2 rounded-xl focus:outline-none cursor-pointer shadow-2xs">
              <option value="relevance"  {{ $sort === 'relevance' ? 'selected' : '' }}>Most Relevant</option>
              <option value="newest"     {{ $sort === 'newest' ? 'selected' : '' }}>Newest First</option>
              <option value="price-low"  {{ $sort === 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
              <option value="price-high" {{ $sort === 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
          </form>
        </div>

        <!-- RESULTS GRID -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5 sm:gap-4 xl:gap-6">
          @foreach ($products as $product)
            @include('front-pages.partials.product-card', ['product' => $product])
          @endforeach
        </div>

        <div class="mt-8">
          {{ $products->links() }}
        </div>

      @else

        <!-- EMPTY SEARCH STATE -->
        <div class="bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 max-w-xl mx-auto shadow-xs">
          <div class="w-20 h-20 rounded-3xl bg-soft-orange text-brand-orange flex items-center justify-center text-3xl mx-auto shadow-inner">
            <i class="fa-solid fa-magnifying-glass"></i>
          </div>
          <h3 class="font-heading font-bold text-xl text-dark-navy">Oops! We couldn't find that.</h3>
          <p class="text-xs sm:text-sm text-body-text max-w-sm mx-auto font-sans leading-relaxed">
            Check the spelling or try a different word. You can also browse our categories below.
          </p>

          @if (!empty($popularSearches))
            <div class="flex flex-wrap gap-1.5 justify-center font-sans">
              @foreach ($popularSearches as $term)
                <a href="{{ route('search', ['q' => $term]) }}"
                  class="text-xs bg-soft-blue hover:bg-soft-orange text-dark-navy hover:text-brand-orange px-3 py-1 rounded-full transition font-semibold">
                  {{ $term }}
                </a>
              @endforeach
            </div>
          @endif

          <div class="pt-2 flex flex-wrap gap-2 justify-center font-heading">
            <a href="{{ route('categories') }}" class="btn-play-orange text-xs px-6 py-2.5 rounded-xl shadow-xs transition">
              EXPLORE CATEGORIES
            </a>
            <a href="{{ route('shop') }}" class="bg-white hover:bg-soft-blue text-dark-navy font-bold text-xs px-6 py-2.5 rounded-xl border border-brand-border transition">
              VIEW ALL PRODUCTS
            </a>
          </div>
        </div>

      @endif

    </div>
  </div>
@endsection