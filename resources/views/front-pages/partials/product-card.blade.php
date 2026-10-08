@php
    // Eager-loaded images (avoids the per-card query in getDisplayImageAttribute)
    $img      = $product->images->firstWhere('is_default', 1) ?? $product->images->first();
    $imgUrl   = $img ? asset('storage/' . ($img->thumb ?? $img->image)) : asset('assets/images/placeholder.png');
    $pastel   = ['bg-soft-blue', 'bg-soft-yellow', 'bg-soft-mint', 'bg-soft-orange', 'bg-soft-purple'][$product->id % 5];
    $url      = url('product') . '?slug=' . $product->slug;
    $hasDisc  = $product->mrp && $product->mrp > $product->price;
    $discPct  = $hasDisc ? round((($product->mrp - $product->price) / $product->mrp) * 100) : 0;
    $rating   = (float) $product->rating_avg;

    // Badge comes from collections; badge_color may be "#hex" or Tailwind classes
    $badge      = $product->collections->first(fn ($c) => filled($c->badge_text));
    $badgeColor = (string) ($badge->badge_color ?? '');
    $badgeHex   = \Illuminate\Support\Str::startsWith($badgeColor, '#');
    $badgeClass = $badgeHex ? 'text-white' : ($badgeColor ?: 'bg-brand-orange text-white');
@endphp

<div class="product-card group bg-white border border-brand-border p-2.5 sm:p-3.5 xl:p-4 flex flex-col justify-between relative overflow-hidden h-full">

  <div class="relative w-full">
    <div class="product-image-container relative {{ $pastel }} aspect-square flex items-center justify-center p-0 overflow-hidden mb-2 sm:mb-2.5 rounded-xl sm:rounded-2xl">

      @if ($badge)
        <span class="absolute top-2 left-2 max-w-[58%] truncate {{ $badgeClass }} text-[9px] sm:text-[10px] font-bold font-heading px-2 py-0.5 rounded-md shadow-2xs z-10 uppercase tracking-wide"
              @if ($badgeHex) style="background-color: {{ $badgeColor }}" @endif>
          {{ $badge->badge_text }}
        </span>
      @endif

      <div class="absolute top-2 right-2 sm:top-2.5 sm:right-2.5 flex flex-col gap-1.5 z-10">
        <button class="card-action-btn wishlist-btn text-slate-600" data-id="{{ $product->id }}" title="Add to Wishlist" aria-label="Wishlist">
          <i class="fa-regular fa-heart text-xs sm:text-sm"></i>
        </button>
        <button class="card-action-btn quick-view-btn text-slate-600" data-id="{{ $product->id }}" title="Quick View" aria-label="Quick View">
          <i class="fa-regular fa-eye text-xs sm:text-sm"></i>
        </button>
      </div>

      <a href="{{ $url }}" class="w-full h-full flex items-center justify-center p-0 overflow-hidden">
        <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
      </a>

      <button class="quick-view-btn hidden md:flex absolute bottom-2 inset-x-2 bg-dark-navy/90 hover:bg-brand-orange text-white text-xs font-bold py-2 px-3 rounded-xl shadow-md items-center justify-center gap-1.5 opacity-0 group-hover:opacity-100 transition duration-200 z-10 font-heading cursor-pointer" data-id="{{ $product->id }}">
        <i class="fa-solid fa-eye text-xs"></i>
        <span>QUICK VIEW</span>
      </button>
    </div>
  </div>

  <div class="flex-1 flex flex-col justify-between">
    <div>
      <div class="flex items-center justify-between gap-1 text-[10px] sm:text-[11px] mb-1 font-heading">
        <span class="uppercase font-bold tracking-wide text-brand-blue text-[9px] sm:text-[10px] truncate max-w-[55%]">{{ $product->category->name ?? '' }}</span>
        @if ($product->age_label)
          <span class="text-brand-navy bg-play-yellow/35 px-1.5 py-0.5 rounded-md font-bold text-[8.5px] sm:text-[9.5px] whitespace-nowrap shrink-0">AGE: {{ $product->age_label }}</span>
        @endif
      </div>

      <h3 class="product-title font-heading font-bold text-dark-navy text-xs sm:text-sm line-clamp-2 mb-1.5 hover:text-brand-orange transition min-h-[2rem] sm:min-h-[2.5rem] leading-snug">
        <a href="{{ $url }}">{{ $product->name }}</a>
      </h3>

      <div class="flex items-center gap-1.5 mb-2 sm:mb-2.5">
        <div class="flex items-center text-amber-400">
          @for ($i = 1; $i <= 5; $i++)
            <i class="fa-solid fa-star {{ $i <= floor($rating) ? 'star-filled' : 'star-empty' }} text-[10px] sm:text-[11px]"></i>
          @endfor
        </div>
        <span class="text-[10px] sm:text-[11px] font-bold text-dark-navy">{{ number_format($rating, 1) }}</span>
        <span class="text-[10px] sm:text-[11px] text-brand-muted font-sans">({{ $product->reviews_count }})</span>
      </div>
    </div>

    <div>
      <div class="flex items-baseline gap-1.5 sm:gap-2 mb-2 sm:mb-2.5 font-heading flex-wrap">
        <span class="text-sm sm:text-base font-bold text-brand-navy">₹{{ number_format($product->price) }}</span>
        @if ($hasDisc)
          <span class="text-xs text-brand-muted line-through font-normal">₹{{ number_format($product->mrp) }}</span>
          <span class="text-[9.5px] sm:text-[10px] font-bold text-brand-orange bg-soft-orange px-1.5 py-0.5 rounded-full whitespace-nowrap">{{ $discPct }}% OFF</span>
        @endif
      </div>

      <button class="add-to-cart-btn w-full btn-play-blue hover:btn-play-orange text-white font-bold font-heading text-xs sm:text-sm py-2 sm:py-2.5 px-3 rounded-xl shadow-2xs transition flex items-center justify-center gap-1.5 sm:gap-2 cursor-pointer" data-id="{{ $product->id }}">
        <i class="fa-solid fa-bag-shopping text-xs shrink-0"></i>
        <span class="truncate">ADD TO CART</span>
      </button>
    </div>
  </div>

</div>