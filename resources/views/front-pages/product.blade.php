@extends('layouts.app')

@php
  use Illuminate\Support\Str;

  // ── Images (default image first) ───────────────────────────────
  $images = $product->images->sortByDesc('is_default')->values();
  $imgUrls = $images->map(fn($i) => asset('storage/' . $i->image))->all();
  $mainImg = $imgUrls[0] ?? null;

  // ── Price / discount ───────────────────────────────────────────
  $hasDiscount = $product->mrp > $product->price;
  $discountPct = $hasDiscount ? round((($product->mrp - $product->price) / $product->mrp) * 100) : 0;

  // ── Stock ──────────────────────────────────────────────────────
  $inStock = $product->stock > 0;
  $minQty = max(1, (int) $product->min_qty);

  // ── Age tag ("3+" / "3–5") ─────────────────────────────────────
  $ageLabel = $product->age_label;

  // ── Badge comes from collections ───────────────────────────────
  $badge = $product->collections->first(fn($c) => filled($c->badge_text));

 $specs = $product->attributeValues
    ->filter(fn ($pav) => $pav->attribute && $pav->value)
    ->groupBy('attribute_id')
    ->map(fn ($group) => (object) [
        'name'    => $group->first()->attribute->name,
        'icon'    => $group->first()->attribute->icon ?? null,
        'display' => $group->pluck('value.value')->filter()->unique()->implode(', '),
    ])
    ->filter(fn ($s) => filled($s->display))
    ->values();


 // ── What's in the box (falls back to the product itself) ───────
  $included = $product->includedItems;

  // ── Developmental benefits & overview highlights (admin-managed) ─
  $benefits = $product->benefits;
  $highlights = $product->highlights;

  // ── Tax wording comes from Invoice Settings (tax_type) ─────────
  $taxInclusive = ($invoice_setting->tax_type ?? 'inclusive') === 'inclusive';
  $taxLabel = $taxInclusive ? 'Inclusive of all GST' : 'Exclusive of GST (added at checkout)';
  $benefitColors = ['text-brand-blue', 'text-amber-500', 'text-emerald-600', 'text-purple-600'];
  $highlightStyles = [
    ['bg-soft-blue', 'border-blue-100', 'bg-brand-blue'],
    ['bg-soft-orange', 'border-orange-100', 'bg-brand-orange'],
    ['bg-soft-mint', 'border-emerald-100', 'bg-emerald-600'],
  ];
  // ── Reviews ────────────────────────────────────────────────────
  $reviews = $product->approvedReviews()->latest()->take(6)->get();

  // ── Bundle companion (first related product) ───────────────────
  $bundle = $related->first();
  $bundleSum = $bundle ? $product->price + $bundle->price : 0;
  $bundleTotal = $bundle ? round($bundleSum * 0.9) : 0;
  $bundleSave = $bundle ? $bundleSum - $bundleTotal : 0;

  // ── Routes (safe fallbacks until they exist) ───────────────────
  $cartAddUrl = Route::has('cart.add') ? route('cart.add') : '#';
  $reviewUrl = Route::has('product.review') ? route('product.review') : '#';

  $shareText = urlencode('Check out ' . $product->name . ' on Aparatus Pastime! ' . url()->current());
@endphp

@section('title', ($product->meta_title ?: $product->name) . ' | Aparatus Pastime')
@section('meta_description', $product->meta_description ?: Str::limit(strip_tags($product->short_description ?: $product->description), 155))
@section('active_nav', 'shop')

@section('content')
  <div class="py-6 sm:py-8 lg:py-10">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">

      <!-- BREADCRUMB & SOCIAL ACTIONS BAR -->
      <div
        class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-2 border-b border-brand-border text-xs font-heading">
        <nav class="flex items-center gap-2 text-brand-muted flex-wrap">
          <a href="{{ route('home') }}" class="hover:text-brand-orange transition flex items-center gap-1.5">
            <i class="fa-solid fa-house text-xs"></i><span>Home</span>
          </a>
          <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
          <a href="{{ route('shop') }}" class="hover:text-brand-orange transition">Shop Catalog</a>
          @if ($product->category)
            <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
            <a href="{{ route('shop', ['category' => $product->category->slug]) }}"
              class="hover:text-brand-orange transition font-semibold text-brand-blue">{{ $product->category->name }}</a>
          @endif
          <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
          <span class="text-dark-navy font-bold truncate max-w-[220px] sm:max-w-sm">{{ $product->name }}</span>
        </nav>

        <div class="flex items-center gap-2.5 text-xs font-heading text-brand-muted">
          <span class="hidden sm:inline font-semibold">Share Play Joy:</span>
          <a href="https://api.whatsapp.com/send?text={{ $shareText }}" target="_blank" rel="noopener"
            class="w-8 h-8 rounded-full bg-emerald-100 hover:bg-emerald-500 hover:text-white text-emerald-700 flex items-center justify-center transition shadow-2xs"
            title="Share on WhatsApp">
            <i class="fa-brands fa-whatsapp text-sm"></i>
          </a>
          <button type="button" id="copy-link-btn"
            class="px-3 py-1 rounded-full bg-white hover:bg-soft-blue text-dark-navy border border-brand-border flex items-center gap-1.5 transition shadow-2xs cursor-pointer font-bold">
            <i class="fa-regular fa-copy text-xs"></i><span class="text-[11px]">Copy Link</span>
          </button>
        </div>
      </div>

      <!-- MAIN SHOWCASE GRID -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 xl:gap-8 items-start mb-10">

        <!-- CARD 1 (LEFT): GALLERY & TRUST PERKS -->
        <div
          class="lg:col-span-6 xl:col-span-7 bg-white rounded-3xl border border-brand-border p-4 sm:p-6 xl:p-7 shadow-xs space-y-4">

          <div
            class="relative bg-gradient-to-br from-soft-blue via-soft-yellow/20 to-soft-mint/30 rounded-3xl border border-brand-border p-4 sm:p-8 aspect-square sm:aspect-16/12 flex items-center justify-center overflow-hidden group select-none shadow-inner">

            <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
              @if ($badge)
                <span
                  class="{{ $badge->badge_color ?: 'bg-brand-orange text-white' }} text-xs font-bold font-heading px-3.5 py-1 rounded-full shadow-md uppercase tracking-wider">{{ $badge->badge_text }}</span>
              @endif
              @if ($product->is_non_toxic)
              <span
                class="bg-white/95 backdrop-blur-md text-emerald-700 text-[11px] font-bold font-heading px-3 py-0.5 rounded-full shadow-xs border border-emerald-200 flex items-center gap-1.5">
                <i class="fa-solid fa-shield-heart text-emerald-500"></i>
                <span>100% Non-Toxic</span>
              </span>
              @endif
            </div>

            <div class="absolute top-4 right-4 flex items-center gap-2 z-10">
              <button type="button"
                class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/95 backdrop-blur-xs shadow-md border border-slate-200/80 text-dark-navy hover:text-red-500 hover:scale-110 active:scale-95 flex items-center justify-center transition cursor-pointer"
                title="Save to Wishlist">
                <i class="fa-regular fa-heart text-base sm:text-lg"></i>
              </button>
            </div>

            <div class="w-full h-full flex items-center justify-center p-2 cursor-zoom-in">
              @if ($mainImg)
                <img id="pdp-main-image" src="{{ $mainImg }}" alt="{{ $product->name }}"
                  class="max-h-[360px] max-w-full object-contain transition duration-300 drop-shadow-md group-hover:scale-105">
              @else
                <i class="fa-solid fa-image text-6xl text-brand-border"></i>
              @endif
            </div>

            @if (count($imgUrls) > 1)
              <button type="button" id="gallery-prev"
                class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/90 hover:bg-brand-orange hover:text-white text-dark-navy flex items-center justify-center shadow-lg transition cursor-pointer z-10 border border-brand-border"
                aria-label="Previous image">
                <i class="fa-solid fa-chevron-left text-xs sm:text-sm"></i>
              </button>
              <button type="button" id="gallery-next"
                class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/90 hover:bg-brand-orange hover:text-white text-dark-navy flex items-center justify-center shadow-lg transition cursor-pointer z-10 border border-brand-border"
                aria-label="Next image">
                <i class="fa-solid fa-chevron-right text-xs sm:text-sm"></i>
              </button>
            @endif
          </div>

          @if (count($imgUrls) > 1)
            <div id="pdp-thumbnails" class="flex items-center gap-2.5 sm:gap-3 justify-center overflow-x-auto py-1">
              @foreach ($imgUrls as $i => $url)
                <button type="button" data-idx="{{ $i }}" data-src="{{ $url }}"
                  class="thumb-btn border-2 {{ $i === 0 ? 'border-brand-blue scale-105 shadow-md' : 'border-transparent opacity-75 hover:opacity-100' }} rounded-2xl p-1.5 bg-white w-16 h-16 flex items-center justify-center shadow-xs transition hover:scale-105 cursor-pointer">
                  <img src="{{ $url }}" alt="{{ $product->name }} {{ $i + 1 }}"
                    class="w-full h-full object-contain rounded-xl" loading="lazy">
                </button>
              @endforeach
            </div>
          @endif

          <!-- Trust Perks Ribbon -->
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-2.5 xl:gap-3 pt-2 font-heading">
            <div
              class="bg-soft-blue px-2.5 py-2.5 sm:py-3 rounded-2xl border border-blue-100/90 flex items-center justify-center gap-1.5 sm:gap-2 shadow-2xs hover:shadow-xs transition">
              <i class="fa-solid fa-gift text-brand-orange text-sm sm:text-base shrink-0"></i>
              <span class="font-bold text-dark-navy text-xs xl:text-[13px] whitespace-nowrap">Free Gift Wrap</span>
            </div>
            <div
              class="bg-soft-mint px-2.5 py-2.5 sm:py-3 rounded-2xl border border-emerald-100/90 flex items-center justify-center gap-1.5 sm:gap-2 shadow-2xs hover:shadow-xs transition">
              <i class="fa-solid fa-truck-fast text-emerald-600 text-sm sm:text-base shrink-0"></i>
              <span class="font-bold text-dark-navy text-xs xl:text-[13px] whitespace-nowrap">Ships in 24h</span>
            </div>
            <div
              class="bg-soft-yellow px-2.5 py-2.5 sm:py-3 rounded-2xl border border-amber-100/90 flex items-center justify-center gap-1.5 sm:gap-2 shadow-2xs hover:shadow-xs transition">
              <i class="fa-solid fa-award text-amber-500 text-sm sm:text-base shrink-0"></i>
              <span class="font-bold text-dark-navy text-xs xl:text-[13px] whitespace-nowrap">Certified Safe</span>
            </div>
            <div
              class="bg-soft-purple px-2.5 py-2.5 sm:py-3 rounded-2xl border border-purple-100/90 flex items-center justify-center gap-1.5 sm:gap-2 shadow-2xs hover:shadow-xs transition">
              <i class="fa-solid fa-rotate-left text-purple-600 text-sm sm:text-base shrink-0"></i>
              <span class="font-bold text-dark-navy text-xs xl:text-[13px] whitespace-nowrap">7-Day Returns</span>
            </div>
          </div>

        </div>

        <!-- CARD 2 (RIGHT): PURCHASE HUB -->
        <div
          class="lg:col-span-6 xl:col-span-5 bg-white rounded-3xl border border-brand-border p-4 sm:p-6 xl:p-7 shadow-xs space-y-5">

          <div class="space-y-2.5">
            <div class="flex flex-wrap items-center gap-2">
              @if ($product->category)
                <span
                  class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3 py-1 rounded-full font-heading border border-blue-100">{{ $product->category->name }}</span>
              @endif
              @if ($ageLabel)
                <span
                  class="text-[11px] sm:text-xs font-bold text-brand-navy bg-play-yellow/30 px-3 py-1 rounded-full font-heading border border-amber-200/60">AGE:
                  {{ strtoupper($ageLabel) }} YEARS</span>
              @endif
              <span
                class="inline-flex items-center gap-1.5 text-[11px] sm:text-xs font-bold {{ $inStock ? 'text-emerald-700 bg-emerald-100/70' : 'text-red-600 bg-red-100/70' }} px-2.5 py-1 rounded-full font-heading md:ml-auto">
                <span class="w-2 h-2 rounded-full {{ $inStock ? 'bg-emerald-500 animate-ping' : 'bg-red-500' }}"></span>
                <span>{{ $inStock ? 'In Stock (' . $product->stock . ' units)' : 'Out of Stock' }}</span>
              </span>
            </div>

            <h1
              class="text-xl sm:text-2xl md:text-3xl font-extrabold font-heading text-dark-navy leading-tight tracking-tight">
              {{ $product->name }}
            </h1>

            <div class="flex items-center gap-2.5 pt-0.5">
              <div class="flex items-center gap-0.5 text-sm">
                @for ($s = 1; $s <= 5; $s++)
                  <i
                    class="fa-solid fa-star {{ $s <= floor($product->rating_avg) ? 'text-amber-400' : 'text-gray-300' }}"></i>
                @endfor
              </div>
              <span
                class="text-xs sm:text-sm font-bold font-heading text-dark-navy">{{ number_format($product->rating_avg, 1) }}</span>
              <span class="text-brand-muted">•</span>
              <a href="#sec-reviews"
                class="text-xs font-bold font-heading text-brand-blue hover:text-brand-orange transition underline underline-offset-2">
                {{ $product->reviews_count }} Verified Parent Reviews
              </a>
            </div>
          </div>

          <!-- Price & Deal Box -->
          <div
            class="bg-gradient-to-r from-soft-orange via-soft-yellow/40 to-soft-orange p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-amber-200/80 shadow-2xs space-y-2">
            <div class="flex items-baseline gap-2.5">
              <span
                class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">₹{{ number_format($product->price) }}</span>
              @if ($hasDiscount)
                <span
                  class="text-sm sm:text-base text-brand-muted line-through font-sans">₹{{ number_format($product->mrp) }}</span>
                <span
                  class="text-[11px] sm:text-xs font-bold text-white bg-brand-orange px-2.5 py-0.5 rounded-full font-heading shadow-xs">{{ $discountPct }}%
                  OFF</span>
              @endif
            </div>
            <div
              class="flex items-center justify-between text-xs text-body-text font-sans pt-1 border-t border-amber-200/60">
              <span class="text-emerald-700 font-bold font-heading flex items-center gap-1 text-[11px] sm:text-xs">
                <i class="fa-solid fa-truck-fast text-brand-orange"></i>
                <span>{{ $product->delivery_charge > 0 ? 'Delivery charge ₹' . number_format($product->delivery_charge) : 'Free Standard Delivery on this order' }}</span>
              </span>
              <span class="text-brand-muted text-[10px] sm:text-[11px]">{{ $taxLabel }}</span>
            </div>
          </div>

          @if ($product->short_description)
            <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans">{{ $product->short_description }}</p>
          @endif

          <!-- Developmental Benefits (dynamic) -->
          @if ($benefits->count())
            <div class="bg-warm-cream p-3.5 sm:p-4 rounded-2xl border border-brand-border space-y-2">
              <h4 class="text-xs font-bold uppercase tracking-wider text-dark-navy font-heading flex items-center gap-1.5">
                <i class="fa-solid fa-atom text-brand-orange"></i><span>DEVELOPMENTAL BENEFITS</span>
              </h4>
              <div class="grid grid-cols-2 gap-2 text-xs text-body-text font-sans">
                @foreach ($benefits as $benefit)
                  <div class="flex items-center gap-2 bg-white p-2 rounded-xl border border-brand-border shadow-2xs">
                    <i
                      class="{{ $benefit->icon ?: 'fa-solid fa-star' }} {{ $benefitColors[$loop->index % count($benefitColors)] }} text-sm shrink-0"></i>
                    <span class="text-[11px] sm:text-xs font-semibold text-dark-navy leading-tight">{{ $benefit->title }}</span>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <!-- Delivery Pincode Checker -->
          <div class="bg-soft-blue/60 p-3.5 sm:p-4 rounded-2xl border border-blue-200 space-y-2 font-sans text-xs">
            <div class="flex items-center justify-between font-heading font-bold text-dark-navy">
              <span class="flex items-center gap-1.5">
                <i class="fa-solid fa-location-dot text-brand-blue"></i><span>Check Delivery & Pincode</span>
              </span>
              <span class="text-[11px] text-brand-blue">Free delivery &gt; ₹999</span>
            </div>
            <div class="flex items-center gap-2">
              <input id="pincode-input" type="text" maxlength="6" placeholder="Enter 6-digit Pincode"
                class="flex-1 min-w-0 px-3 py-2 bg-white border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue text-xs font-bold text-dark-navy">
              <button type="button" id="pincode-check-btn"
                class="btn-play-blue text-xs font-bold px-4 py-2 rounded-xl transition cursor-pointer font-heading shrink-0">CHECK</button>
            </div>
            <div id="pincode-result" data-delivery="{{ $product->delivery_time ?: '2 to 7 days' }}"
              class="text-[11px] text-emerald-700 font-semibold hidden font-heading"></div>
          </div>

          <!-- Qty & CTAs — submitted via AJAX (data-cart-form → CartController@add) -->
          <form id="add-to-cart-form" action="{{ $cartAddUrl }}" method="POST" data-cart-form class="space-y-2.5 pt-1">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5 sm:gap-3">
              <div class="sm:col-span-7 flex items-stretch gap-2 sm:gap-2.5">
                <div
                  class="flex items-center border-2 border-brand-border rounded-xl sm:rounded-2xl bg-white h-12 shrink-0 p-0.5 shadow-2xs">
                  <button type="button" id="pdp-qty-minus"
                    class="w-8 h-full text-brand-navy hover:bg-soft-blue hover:text-brand-blue font-bold text-sm transition rounded-lg flex items-center justify-center cursor-pointer"
                    aria-label="Decrease quantity">
                    <i class="fa-solid fa-minus text-[10px]"></i>
                  </button>
                  <input id="pdp-qty-input" name="quantity" type="number" value="{{ $minQty }}" min="{{ $minQty }}"
                    max="{{ max($product->stock, $minQty) }}"
                    class="w-8 text-center text-sm font-bold text-dark-navy focus:outline-none font-heading" readonly>
                  <button type="button" id="pdp-qty-plus"
                    class="w-8 h-full text-brand-navy hover:bg-soft-blue hover:text-brand-blue font-bold text-sm transition rounded-lg flex items-center justify-center cursor-pointer"
                    aria-label="Increase quantity">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                  </button>
                </div>

                <button type="submit" @disabled(!$inStock)
                  class="flex-1 btn-play-orange text-xs sm:text-sm py-3 px-4 rounded-xl sm:rounded-2xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 font-heading font-bold cursor-pointer whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                  <i class="fa-solid fa-bag-shopping text-sm shrink-0"></i><span>ADD TO CART</span>
                </button>
              </div>

              <div class="sm:col-span-5 flex">
                <button type="submit" name="buy_now" value="1" @disabled(!$inStock)
                  class="w-full btn-play-blue text-xs sm:text-sm py-3 px-4 rounded-xl sm:rounded-2xl shadow-sm hover:shadow-md transition font-heading font-bold cursor-pointer flex items-center justify-center gap-2 whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                  <i class="fa-solid fa-bolt text-play-yellow text-xs shrink-0"></i><span>BUY NOW</span>
                </button>
              </div>
            </div>

            @if ($minQty > 1)
              <p class="text-[11px] text-brand-muted font-sans">Minimum order quantity: {{ $minQty }}</p>
            @endif

            <!-- Trust Seals -->
            <div
              class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-4 text-[10.5px] sm:text-[11px] text-brand-muted font-sans pt-1">
              <span class="flex items-center gap-1"><i class="fa-solid fa-lock text-emerald-500"></i>256-Bit SSL
                Secured</span>
              <span>•</span>
              <span class="flex items-center gap-1"><i class="fa-solid fa-truck text-brand-blue"></i>Air Express
                Shipping</span>
              <span>•</span>
              <span class="flex items-center gap-1"><i class="fa-solid fa-shield-heart text-amber-500"></i>7-Day
                Replacement Guarantee</span>
            </div>
          </form>

        </div>
      </div>

      <!-- FREQUENTLY BOUGHT TOGETHER (companion = first related product) — submitted via AJAX (data-bundle-form) -->
      @if ($bundle)
        <form action="{{ $cartAddUrl }}" method="POST" data-bundle-form
          class="bg-gradient-to-r from-soft-blue via-soft-yellow/40 to-soft-orange rounded-3xl border border-brand-border p-5 sm:p-7 mb-10 shadow-xs">
          @csrf
          <input type="hidden" name="product_ids[]" value="{{ $product->id }}">
          <input type="hidden" name="product_ids[]" value="{{ $bundle->id }}">
          <input type="hidden" name="bundle" value="1">

          <div class="flex flex-col xl:flex-row items-center justify-between gap-5">
            <div class="space-y-1.5 text-center xl:text-left">
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-white px-3 py-1 rounded-full font-heading shadow-2xs inline-block border border-orange-200/60">
                <i class="fa-solid fa-gift mr-1 text-play-yellow"></i>PLAYROOM BUNDLE DEAL
              </span>
              <h3 class="text-lg sm:text-xl xl:text-2xl font-bold font-heading text-dark-navy">Frequently Bought Together
              </h3>
              <p class="text-xs sm:text-sm text-body-text font-sans max-w-md">
                Pair this item with our top-rated creative play companion and unlock an extra 10% combo discount!
              </p>
            </div>

            <div class="flex flex-wrap sm:flex-nowrap items-center justify-center gap-3 xl:gap-4 w-full xl:w-auto">
              <div class="flex items-center gap-2 shrink-0">
                <div
                  class="w-14 h-14 rounded-2xl bg-white p-1.5 border border-brand-border shadow-xs flex items-center justify-center">
                  @if ($mainImg)<img src="{{ $mainImg }}" alt="{{ $product->name }}"
                  class="w-full h-full object-contain">@else<i class="fa-solid fa-image text-brand-border"></i>@endif
                </div>
                <span class="text-base font-bold text-dark-navy font-heading">+</span>
                <div
                  class="w-14 h-14 rounded-2xl bg-white p-1.5 border border-brand-border shadow-xs flex items-center justify-center">
                  @if ($bundle->display_image)<img src="{{ $bundle->display_image }}" alt="{{ $bundle->name }}"
                  class="w-full h-full object-contain">@else<i class="fa-solid fa-image text-brand-border"></i>@endif
                </div>
              </div>

              <div class="text-center sm:text-left shrink-0">
                <div class="text-[11px] text-brand-muted font-heading font-semibold">Combined Bundle Price</div>
                <div class="flex items-baseline gap-1.5 font-heading">
                  <span class="text-lg xl:text-xl font-bold text-brand-navy">₹{{ number_format($bundleTotal) }}</span>
                  <span class="text-[10px] text-brand-orange font-bold bg-soft-orange px-2 py-0.5 rounded-full">Save
                    ₹{{ number_format($bundleSave) }}</span>
                </div>
              </div>

              <button type="submit"
                class="w-full sm:w-auto btn-play-orange text-xs px-5 py-3 rounded-xl shadow-md transition font-heading font-bold cursor-pointer shrink-0">
                ADD BOTH TO CART →
              </button>
            </div>
          </div>
        </form>
      @endif

      <!-- QUICK JUMP BAR -->
      <div
        class="sticky top-0 z-30 bg-white/95 backdrop-blur-md rounded-2xl border border-brand-border p-2 mb-8 shadow-sm overflow-x-auto">
        <div class="flex items-center gap-2 min-w-max text-xs font-heading font-bold text-dark-navy">
          <span class="px-3 py-1.5 text-brand-muted text-[11px] uppercase tracking-wider flex items-center gap-1">
            <i class="fa-solid fa-compass text-brand-orange"></i><span>Jump To:</span>
          </span>
          <a href="#sec-description"
            class="px-4 py-2 rounded-xl bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-blue transition flex items-center gap-1.5">
            <i class="fa-solid fa-align-left text-xs"></i><span>Overview</span>
          </a>
          @if ($specs->count())
            <a href="#sec-specifications"
              class="px-4 py-2 rounded-xl bg-soft-purple hover:bg-purple-600 hover:text-white text-purple-700 transition flex items-center gap-1.5">
              <i class="fa-solid fa-list-check text-xs"></i><span>Specifications</span>
            </a>
          @endif
          <a href="#sec-included"
            class="px-4 py-2 rounded-xl bg-soft-mint hover:bg-emerald-600 hover:text-white text-emerald-700 transition flex items-center gap-1.5">
            <i class="fa-solid fa-box-open text-xs"></i><span>What's In The Box</span>
          </a>
          @if (filled($product->how_to_use))
          <a href="#sec-care"
            class="px-4 py-2 rounded-xl bg-soft-yellow hover:bg-amber-500 hover:text-white text-amber-800 transition flex items-center gap-1.5">
            <i class="fa-solid fa-shield-heart text-xs"></i><span>Safety & Care</span>
          </a>
          @endif
          @if (filled($product->delivery_returns))
          <a href="#sec-shipping"
            class="px-4 py-2 rounded-xl bg-soft-orange hover:bg-brand-orange hover:text-white text-brand-orange transition flex items-center gap-1.5">
            <i class="fa-solid fa-truck-fast text-xs"></i><span>Shipping & Returns</span>
          </a>
          @endif
          <a href="#sec-reviews"
            class="px-4 py-2 rounded-xl bg-brand-navy/10 hover:bg-brand-navy hover:text-white text-dark-navy transition flex items-center gap-1.5">
            <i class="fa-solid fa-star text-xs text-amber-500"></i><span>Reviews ({{ $product->reviews_count }})</span>
          </a>
        </div>
      </div>

      <!-- DETAIL SECTIONS -->
      <div class="space-y-8 mb-14">

        <!-- 1. OVERVIEW -->
        <section id="sec-description"
          class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6 scroll-mt-32">
          <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-brand-border">
            <div class="flex items-center gap-3">
              <span
                class="w-10 h-10 rounded-2xl bg-soft-blue text-brand-blue flex items-center justify-center text-base shrink-0"><i
                  class="fa-solid fa-book-open-reader"></i></span>
              <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-blue font-heading">PLAY &
                  DEVELOPMENT</span>
                <h2 class="text-xl sm:text-2xl font-bold font-heading text-dark-navy">Product Overview & Story</h2>
              </div>
            </div>
            <span
              class="text-xs font-bold text-emerald-700 bg-soft-mint px-3.5 py-1.5 rounded-full font-heading border border-emerald-200 flex items-center gap-1.5">
              <i class="fa-solid fa-certificate text-emerald-500"></i><span>Age-Appropriate Design</span>
            </span>
          </div>

          <div class="space-y-3 font-sans leading-relaxed text-body-text text-sm sm:text-base">
            {!! $product->description !!}
          </div>

          @if ($highlights->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-brand-border">
              @foreach ($highlights as $highlight)
                @php $st = $highlightStyles[$loop->index % count($highlightStyles)]; @endphp
                <div class="p-5 rounded-2xl {{ $st[0] }} border {{ $st[1] }} space-y-2">
                  <div
                    class="w-10 h-10 rounded-xl {{ $st[2] }} text-white flex items-center justify-center text-sm shadow-2xs">
                    <i class="{{ $highlight->icon ?: 'fa-solid fa-star' }}"></i>
                  </div>
                  <h4 class="font-heading font-bold text-sm sm:text-base text-dark-navy">{{ $highlight->title }}</h4>
                  @if ($highlight->description)
                    <p class="text-xs text-body-text leading-relaxed font-sans">{{ $highlight->description }}</p>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </section>

        <!-- 2. SPECIFICATIONS (dynamic) -->
        @if ($specs->count())
          <section id="sec-specifications"
            class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6 scroll-mt-32">
            <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-brand-border">
              <div class="flex items-center gap-3">
                <span
                  class="w-10 h-10 rounded-2xl bg-soft-purple text-purple-600 flex items-center justify-center text-base shrink-0"><i
                    class="fa-solid fa-sliders"></i></span>
                <div>
                  <span class="text-xs font-bold uppercase tracking-wider text-purple-700 font-heading">TECHNICAL
                    METRICS</span>
                  <h2 class="text-xl sm:text-2xl font-bold font-heading text-dark-navy">Product Specifications</h2>
                </div>
              </div>
              <span
                class="text-xs font-bold text-brand-navy bg-soft-purple px-3.5 py-1.5 rounded-full font-heading border border-purple-200">Verified
                Specifications</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
              @foreach ($specs as $sv)
                <div
                  class="p-4 rounded-2xl bg-warm-cream border border-brand-border hover:border-brand-blue/40 transition flex items-start gap-3.5">
                  <div
                    class="w-10 h-10 rounded-xl text-brand-blue bg-soft-blue border border-blue-200 flex items-center justify-center shrink-0 shadow-2xs">
                    <i class="{{ $sv->icon ?: 'fa-solid fa-cubes' }} text-sm"></i>
                  </div>
                  <div class="min-w-0">
                    <div class="text-[11px] font-bold text-brand-muted uppercase tracking-wider font-heading">{{ $sv->name }}
                    </div>
                    <div class="text-xs sm:text-sm font-bold text-dark-navy font-heading mt-0.5">{{ $sv->display }}</div>
                  </div>
                </div>
              @endforeach
            </div>
          </section>
        @endif

        <!-- 3. WHAT'S IN THE BOX -->
        <section id="sec-included"
          class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6 scroll-mt-32">
          <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-brand-border">
            <div class="flex items-center gap-3">
              <span
                class="w-10 h-10 rounded-2xl bg-soft-mint text-emerald-600 flex items-center justify-center text-base shrink-0"><i
                  class="fa-solid fa-box-open"></i></span>
              <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 font-heading">COMPLETE PLAY
                  PACKAGE</span>
                <h2 class="text-xl sm:text-2xl font-bold font-heading text-dark-navy">What's In The Box</h2>
              </div>
            </div>
            <span
              class="text-xs font-bold text-emerald-700 bg-emerald-100 px-3.5 py-1.5 rounded-full font-heading flex items-center gap-1.5">
              <i class="fa-solid fa-box-check"></i><span>Sealed & Verified Package</span>
            </span>
          </div>

          <div class="space-y-4">
            <p class="text-xs sm:text-sm text-brand-muted font-sans">Every box is packed securely in our tamper-evident
              child-safe packaging:</p>
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-body-text font-sans">
              @forelse ($included as $item)
                <li
                  class="flex items-center gap-3 p-3.5 rounded-2xl bg-soft-blue/40 border border-blue-100 hover:bg-soft-blue/70 transition">
                  <div
                    class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 text-xs shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                  </div>
                  <span class="font-bold text-xs sm:text-sm text-dark-navy font-heading">{{ $item->title }}</span>
                </li>
              @empty
                <li
                  class="flex items-center gap-3 p-3.5 rounded-2xl bg-soft-blue/40 border border-blue-100 hover:bg-soft-blue/70 transition">
                  <div
                    class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 text-xs shadow-2xs">
                    <i class="fa-solid fa-check"></i>
                  </div>
                  <span class="font-bold text-xs sm:text-sm text-dark-navy font-heading">1 × {{ $product->name }}</span>
                </li>
              @endforelse
            </ul>
          </div>
        </section>

        <!-- 4. SAFETY & CARE (single textarea: how_to_use) -->
        @if (filled($product->how_to_use))
          <section id="sec-care"
            class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6 scroll-mt-32">
            <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-brand-border">
              <div class="flex items-center gap-3">
                <span
                  class="w-10 h-10 rounded-2xl bg-soft-yellow text-amber-600 flex items-center justify-center text-base shrink-0"><i
                    class="fa-solid fa-shield-heart"></i></span>
                <div>
                  <span class="text-xs font-bold uppercase tracking-wider text-amber-700 font-heading">PARENT CARE & SAFETY
                    GUIDE</span>
                  <h2 class="text-xl sm:text-2xl font-bold font-heading text-dark-navy">Care & Setup Guidelines</h2>
                </div>
              </div>
              @if ($product->is_non_toxic)
                <span
                  class="text-xs font-bold text-dark-navy bg-warm-cream px-3.5 py-1.5 rounded-full font-heading border border-amber-200">100%
                  Non-Toxic Certified</span>
              @endif
            </div>

            <div class="space-y-3 font-sans leading-relaxed text-body-text text-sm sm:text-base">
              {!! $product->how_to_use !!}
            </div>
          </section>
        @endif

        <!-- 5. SHIPPING & RETURNS (single textarea: delivery_returns) -->
        @if (filled($product->delivery_returns))
          <section id="sec-shipping"
            class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6 scroll-mt-32">
            <div class="flex items-center gap-3 pb-4 border-b border-brand-border">
              <span
                class="w-10 h-10 rounded-2xl bg-soft-orange text-brand-orange flex items-center justify-center text-base shrink-0"><i
                  class="fa-solid fa-truck-ramp-box"></i></span>
              <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-orange font-heading">TRUST &
                  LOGISTICS</span>
                <h2 class="text-xl sm:text-2xl font-bold font-heading text-dark-navy">Shipping, Delivery & Easy Returns
                </h2>
              </div>
            </div>

            <div class="space-y-3 font-sans leading-relaxed text-body-text text-sm sm:text-base">
              {!! $product->delivery_returns !!}
            </div>
          </section>
        @endif

        <!-- 6. REVIEWS -->
        <section id="sec-reviews"
          class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-8 scroll-mt-32">
          <div class="flex items-center justify-between flex-wrap gap-3 pb-4 border-b border-brand-border">
            <div class="flex items-center gap-3">
              <span
                class="w-10 h-10 rounded-2xl bg-soft-yellow text-amber-500 flex items-center justify-center text-base shrink-0"><i
                  class="fa-solid fa-star"></i></span>
              <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-navy font-heading">FAMILY
                  EXPERIENCES</span>
                <h2 class="text-xl sm:text-2xl font-bold font-heading text-dark-navy">Verified Parent Reviews</h2>
              </div>
            </div>
            <span
              class="text-xs font-bold text-amber-700 bg-soft-yellow px-3.5 py-1.5 rounded-full font-heading border border-amber-200">
              {{ $product->reviews_count }} Reviews Submitted
            </span>
          </div>

          <div
            class="flex flex-col md:flex-row gap-6 p-6 rounded-2xl bg-warm-cream border border-brand-border items-center justify-between">
            <div class="flex items-center gap-5 text-center md:text-left">
              <div class="text-5xl font-extrabold font-heading text-dark-navy">
                {{ number_format($product->rating_avg, 1) }}
              </div>
              <div class="space-y-1">
                <div class="flex justify-center md:justify-start gap-1">
                  @for ($s = 1; $s <= 5; $s++)
                    <i
                      class="fa-solid fa-star {{ $s <= floor($product->rating_avg) ? 'text-amber-400' : 'text-gray-300' }}"></i>
                  @endfor
                </div>
                <div class="text-xs text-brand-muted font-sans">Based on {{ $product->reviews_count }} verified parent
                  reviews</div>
                <div
                  class="text-[11px] font-bold text-emerald-700 bg-emerald-100/70 px-2.5 py-0.5 rounded-full inline-block font-heading">
                  <i class="fa-solid fa-heart text-red-500 mr-1"></i>98% Would Recommend To A Friend
                </div>
              </div>
            </div>

            <div>
              <button type="button" id="toggle-review-form-btn"
                class="btn-play-orange text-xs sm:text-sm px-6 py-3.5 rounded-2xl transition cursor-pointer font-heading font-bold flex items-center gap-2 shadow-md">
                <i class="fa-solid fa-pen-to-square"></i><span>WRITE A PARENT REVIEW</span>
              </button>
            </div>
          </div>

          <form id="write-review-form" action="{{ $reviewUrl }}" method="POST"
            class="hidden bg-soft-blue/40 p-6 sm:p-8 rounded-3xl border border-blue-200 space-y-4 shadow-sm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <h4 class="font-heading font-bold text-base text-dark-navy">Share Your Family's Experience</h4>
            <p class="text-xs text-brand-muted">Your review helps other parents pick the best toys for their children.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-dark-navy mb-1 font-heading">Your Name *</label>
                <input type="text" name="name" required placeholder="E.g. Priya Sharma"
                  class="w-full px-4 py-2.5 bg-white border border-brand-border rounded-xl text-xs focus:outline-none focus:border-brand-blue font-sans font-medium">
              </div>
              <div>
                <label class="block text-xs font-bold text-dark-navy mb-1 font-heading">Rating *</label>
                <select name="rating"
                  class="w-full px-4 py-2.5 bg-white border border-brand-border rounded-xl text-xs focus:outline-none focus:border-brand-blue font-sans font-medium">
                  <option value="5">★★★★★ (5 Stars - Amazing Fun)</option>
                  <option value="4">★★★★☆ (4 Stars - Great Quality)</option>
                  <option value="3">★★★☆☆ (3 Stars - Good)</option>
                  <option value="2">★★☆☆☆ (2 Stars - Below Average)</option>
                  <option value="1">★☆☆☆☆ (1 Star - Poor)</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-dark-navy mb-1 font-heading">Headline *</label>
              <input type="text" name="title" required placeholder="What did they love the most?"
                class="w-full px-4 py-2.5 bg-white border border-brand-border rounded-xl text-xs focus:outline-none focus:border-brand-blue font-sans">
            </div>

            <div>
              <label class="block text-xs font-bold text-dark-navy mb-1 font-heading">Your Review *</label>
              <textarea name="comment" rows="3" required
                placeholder="Share details about build quality, child engagement, and durability..."
                class="w-full px-4 py-2.5 bg-white border border-brand-border rounded-xl text-xs focus:outline-none focus:border-brand-blue font-sans"></textarea>
            </div>

            <div class="flex items-center gap-3 pt-2">
              <button type="submit"
                class="btn-play-orange text-xs px-8 py-3 rounded-xl transition cursor-pointer font-heading font-bold shadow-md">SUBMIT
                REVIEW</button>
              <button type="button" id="cancel-review-btn"
                class="px-4 py-3 text-xs text-brand-muted hover:text-dark-navy font-heading font-bold cursor-pointer">Cancel</button>
            </div>
          </form>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 font-sans">
            @forelse ($reviews as $r)
              <div class="p-5 sm:p-6 rounded-2xl bg-white border border-brand-border space-y-3 shadow-2xs">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-3">
                    <div
                      class="w-10 h-10 rounded-2xl bg-gradient-to-br from-soft-blue to-soft-yellow text-brand-navy flex items-center justify-center font-extrabold text-sm font-heading border border-brand-border">
                      {{ strtoupper(mb_substr($r->name ?? 'P', 0, 1)) }}
                    </div>
                    <div>
                      <h5 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">{{ $r->name ?? 'Parent' }}</h5>
                      <span class="text-[10px] text-emerald-600 font-bold font-heading flex items-center gap-1">
                        <i class="fa-solid fa-circle-check"></i>Verified Family Purchase
                      </span>
                    </div>
                  </div>
                  <span class="text-[11px] text-brand-muted font-heading">{{ $r->created_at?->format('M d, Y') }}</span>
                </div>
                <div class="flex text-amber-400 text-xs">
                  @for ($s = 0; $s < (int) $r->rating; $s++)<i class="fa-solid fa-star"></i>@endfor
                </div>
                @if ($r->title)
                <h6 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">{{ $r->title }}</h6>@endif
                <p class="text-xs text-body-text leading-relaxed font-sans">{{ $r->comment }}</p>
              </div>
            @empty
              <p class="md:col-span-2 text-center text-xs sm:text-sm text-brand-muted py-4">No reviews yet — be the first to
                share your family's experience.</p>
            @endforelse
          </div>
        </section>

      </div>

      <!-- RELATED PRODUCTS -->
      @if ($related->count())
        <section class="mt-14">
          <div class="flex items-center justify-between mb-8 pb-3 border-b border-brand-border">
            <div>
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3 py-1 rounded-full font-heading">CURATED
                RECOMMENDATIONS</span>
              <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy mt-1.5">You May Also Like</h2>
            </div>
            <a href="{{ $product->category ? route('shop', ['category' => $product->category->slug]) : route('shop') }}"
              class="text-xs sm:text-sm font-bold font-heading text-brand-blue hover:text-brand-orange transition flex items-center gap-1">
              <span>Explore All Toys</span>
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>
          <div id="related-products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach ($related as $item)
              @include('front-pages.partials.product-card', ['product' => $item])
            @endforeach
          </div>
        </section>
      @endif

      <!-- RECENTLY VIEWED -->
      @if ($recentlyViewed->count())
        <section id="recently-viewed-section" class="mt-14">
          <div class="flex items-center justify-between mb-8 pb-3 border-b border-brand-border">
            <div>
              <span
                class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3 py-1 rounded-full font-heading">YOUR
                BROWSING HISTORY</span>
              <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy mt-1.5">Recently Viewed</h2>
            </div>
          </div>
          <div id="recently-viewed-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach ($recentlyViewed as $item)
              @include('front-pages.partials.product-card', ['product' => $item])
            @endforeach
          </div>
        </section>
      @endif

    </div>
  </div>

  <!-- STICKY BOTTOM PURCHASE BAR -->
  <div id="sticky-pdp-bar"
    class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-brand-border z-40 py-2.5 px-4 shadow-2xl transition-transform duration-300 translate-y-full hidden lg:block">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
      <div class="flex items-center gap-3 min-w-0">
        @if ($mainImg)
          <img src="{{ $mainImg }}" alt=""
            class="w-11 h-11 object-contain rounded-xl bg-soft-blue p-1 border border-brand-border shrink-0">
        @endif
        <div class="min-w-0 truncate">
          <div class="text-xs font-bold font-heading text-dark-navy truncate">{{ $product->name }}</div>
          <div class="flex items-baseline gap-2 font-heading">
            <span class="text-sm font-bold text-brand-navy">₹{{ number_format($product->price) }}</span>
            @if ($hasDiscount)
              <span class="text-[11px] text-brand-muted line-through">₹{{ number_format($product->mrp) }}</span>
            @endif
          </div>
        </div>
      </div>
      <div class="flex items-center gap-3 shrink-0">
        <button type="submit" form="add-to-cart-form" @disabled(!$inStock)
          class="btn-play-orange text-xs py-2.5 px-6 rounded-xl shadow-md transition font-heading font-bold cursor-pointer flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
          <i class="fa-solid fa-bag-shopping"></i><span>ADD TO CART</span>
        </button>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Copy link
      document.getElementById('copy-link-btn')?.addEventListener('click', () => {
        navigator.clipboard.writeText(window.location.href);
      });

      // Gallery
      const mainImg = document.getElementById('pdp-main-image');
      const thumbs = Array.from(document.querySelectorAll('.thumb-btn'));
      let idx = 0;
      const show = (i) => {
        if (!mainImg || !thumbs.length) return;
        idx = (i + thumbs.length) % thumbs.length;
        mainImg.src = thumbs[idx].dataset.src;
        thumbs.forEach((b, n) => {
          b.className = `thumb-btn border-2 ${n === idx ? 'border-brand-blue scale-105 shadow-md' : 'border-transparent opacity-75 hover:opacity-100'} rounded-2xl p-1.5 bg-white w-16 h-16 flex items-center justify-center shadow-xs transition hover:scale-105 cursor-pointer`;
        });
      };
      thumbs.forEach((b, n) => b.addEventListener('click', () => show(n)));
      document.getElementById('gallery-prev')?.addEventListener('click', () => show(idx - 1));
      document.getElementById('gallery-next')?.addEventListener('click', () => show(idx + 1));

      // Qty stepper
      const qty = document.getElementById('pdp-qty-input');
      if (qty) {
        const min = parseInt(qty.min) || 1;
        const max = parseInt(qty.max) || min;
        document.getElementById('pdp-qty-minus')?.addEventListener('click', () => {
          const v = parseInt(qty.value) || min;
          if (v > min) qty.value = v - 1;
        });
        document.getElementById('pdp-qty-plus')?.addEventListener('click', () => {
          const v = parseInt(qty.value) || min;
          if (v < max) qty.value = v + 1;
        });
      }

      // Pincode checker (format check only)
      const pinBtn = document.getElementById('pincode-check-btn');
      pinBtn?.addEventListener('click', () => {
        const pin = document.getElementById('pincode-input').value.trim();
        const res = document.getElementById('pincode-result');
        res.classList.remove('hidden');
        if (/^\d{6}$/.test(pin)) {
          res.innerHTML = `<i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i>Delivering to <strong>${pin}</strong> in <strong>${res.dataset.delivery}</strong>`;
        } else {
          res.innerHTML = '<span class="text-red-500 font-bold"><i class="fa-solid fa-circle-exclamation mr-1"></i>Please enter a valid 6-digit Indian postal code.</span>';
        }
      });

      // Review form toggle
      const reviewForm = document.getElementById('write-review-form');
      document.getElementById('toggle-review-form-btn')?.addEventListener('click', () => {
        reviewForm.classList.toggle('hidden');
        if (!reviewForm.classList.contains('hidden')) {
          reviewForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      });
      document.getElementById('cancel-review-btn')?.addEventListener('click', () => reviewForm.classList.add('hidden'));

      // Sticky bar
      const sticky = document.getElementById('sticky-pdp-bar');
      if (sticky) {
        window.addEventListener('scroll', () => {
          sticky.classList.toggle('translate-y-full', window.scrollY <= 400);
        });
      }
    });
  </script>
@endpush