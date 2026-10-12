@extends('layouts.app')

@section('title', ($collection->meta_title ?: $collection->name) . ' | Aparatus Pastime - Kids Toys & Sports')
@section('meta_description', $collection->meta_description ?: 'Shop ' . $collection->name . ' at Aparatus Pastime - kids toys, games & sports goods.')
@section('active_nav', 'collection-' . $collection->slug)

@section('content')
  <div class="py-6 sm:py-8 lg:py-10">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-4 font-heading">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('shop') }}" class="hover:text-brand-orange transition">Shop</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-dark-navy font-bold">{{ $collection->name }}</span>
      </nav>

      <!-- HERO HEADER -->
      <div class="bg-brand-navy rounded-3xl text-white p-6 sm:p-10 mb-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-lg relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-60 h-60 rounded-full bg-brand-orange/25 blur-3xl pointer-events-none"></div>

        <div class="space-y-2 text-center sm:text-left relative z-10">
          <span class="bg-brand-orange text-white text-[11px] font-bold px-3 py-1 rounded-full font-heading uppercase tracking-wider inline-flex items-center gap-1.5">
            <i class="fa-solid {{ $collection->header_icon ?: 'fa-sparkles' }} text-play-yellow"></i>
            <span>{{ $collection->header_badge ?: 'COLLECTION' }}</span>
          </span>
          <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-white uppercase">{{ $collection->name }}</h1>
          <p class="text-xs sm:text-sm text-white/90 max-w-lg font-sans">
            {{ $collection->meta_description ?: 'Hand-picked toys, games and sports gear chosen for joyful, memorable playtime.' }}
          </p>
        </div>
        <div class="text-center bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl shrink-0 relative z-10">
          <div class="text-2xl font-bold font-heading text-play-yellow">{{ $products->total() }}</div>
          <div class="text-xs text-white/90 font-heading">{{ \Illuminate\Support\Str::plural('Item', $products->total()) }} in this collection</div>
        </div>
      </div>

      <!-- SORT CONTROLS -->
      <div class="flex items-center justify-between pb-4 mb-6 border-b border-brand-border font-heading">
        <div class="text-xs sm:text-sm font-bold text-dark-navy">
          @if ($products->total() > 0)
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}
          @else
            No products yet
          @endif
        </div>
        <form method="GET" action="{{ route('collections.show', ['slug' => $collection->slug]) }}" class="flex items-center gap-2 text-xs">
          <span class="text-brand-muted hidden sm:inline">Sort By:</span>
          <select name="sort" onchange="this.form.submit()"
            class="bg-white border border-brand-border text-dark-navy text-xs font-bold px-3 py-2 rounded-xl focus:outline-none cursor-pointer shadow-2xs">
            <option value="featured"   {{ $sort === 'featured' ? 'selected' : '' }}>Featured First</option>
            <option value="price-low"  {{ $sort === 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price-high" {{ $sort === 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
          </select>
        </form>
      </div>

      <!-- PRODUCTS GRID -->
      @if ($products->count())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5 sm:gap-4 xl:gap-6">
          @foreach ($products as $product)
            @include('front-pages.partials.product-card', ['product' => $product])
          @endforeach
        </div>

        <div class="mt-8">
          {{ $products->links() }}
        </div>
      @else
        <div class="text-center py-16 bg-white rounded-3xl border border-brand-border">
          <div class="w-14 h-14 rounded-full bg-soft-orange text-brand-orange flex items-center justify-center text-2xl mx-auto mb-3">
            <i class="fa-solid fa-box-open"></i>
          </div>
          <h3 class="font-heading font-bold text-dark-navy text-base">Nothing here yet</h3>
          <p class="text-xs text-body-text font-sans mt-1 mb-4">New products are added to this collection regularly.</p>
          <a href="{{ route('shop') }}" class="btn-play-orange text-xs px-6 py-3 rounded-xl font-heading inline-block">BROWSE ALL PRODUCTS →</a>
        </div>
      @endif

    </div>
  </div>
@endsection