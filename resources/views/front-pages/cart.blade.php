@extends('layouts.app')

@section('title', 'Your Play Bag | Aparatus Pastime')
@section('active_nav', 'cart')

@php
  $hasItems = $cart && $cart->items->isNotEmpty();
  $s = $summary ?? [
    'count' => 0, 'mrp_total' => 0, 'savings' => 0, 'subtotal' => 0,
    'discount' => 0, 'tax' => 0, 'grand_total' => 0, 'coupon_code' => null,
  ];
  $threshold = (float) ($freeShippingThreshold ?? 0);
  $fmt = fn($n) => '₹' . number_format((float) $n, 0, '.', ',');
@endphp

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4" id="cart-page"
         data-threshold="{{ $threshold }}"
         data-coupon="{{ $s['coupon_code'] }}">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-4 font-heading">
        <a href="{{ url('/') }}" class="hover:text-brand-orange transition">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-dark-navy font-bold">Your Play Bag</span>
      </nav>

      <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-2xl bg-soft-orange text-brand-orange flex items-center justify-center text-xl shadow-xs">
          <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy">
          YOUR PLAY BAG
          <span id="cart-title-count" class="text-brand-muted text-base sm:text-lg font-normal font-sans">({{ $s['count'] }} {{ $s['count'] === 1 ? 'item' : 'items' }})</span>
        </h1>
      </div>

      <!-- CART CONTENT -->
      <div id="cart-active-layout" class="{{ $hasItems ? '' : 'hidden' }} grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT: ITEMS -->
        <div class="lg:col-span-8 space-y-4">

          @if ($threshold > 0)
            <div class="bg-soft-blue border border-blue-200 rounded-2xl p-4 shadow-2xs">
              <div id="cart-free-shipping-text" class="text-xs font-bold font-heading text-brand-blue flex justify-between mb-1.5"></div>
              <div class="w-full bg-blue-200 rounded-full h-2.5 overflow-hidden">
                <div id="cart-free-shipping-bar" class="bg-brand-orange h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
              </div>
            </div>
          @endif

          <div class="bg-white rounded-3xl border border-brand-border overflow-hidden shadow-xs">
            <div class="p-4 sm:p-5 border-b border-brand-border bg-warm-cream hidden md:grid grid-cols-12 text-xs font-bold font-heading text-dark-navy">
              <div class="col-span-6">PRODUCT</div>
              <div class="col-span-2 text-center">PRICE</div>
              <div class="col-span-2 text-center">QUANTITY</div>
              <div class="col-span-2 text-right">TOTAL</div>
            </div>

            <div id="cart-items-container" class="divide-y divide-brand-border">
              @if ($hasItems)
                @foreach ($cart->items as $item)
                  @php
                    $product = $item->product;
                    $minQty  = max(1, (int) ($product->min_qty ?? 1));
                    $addonUnit = (float) $item->addons->sum('price');
                    $unitPrice = (float) $item->price + $addonUnit;

                    $attrs = $item->selected_attributes;
                    if (is_string($attrs)) { $attrs = json_decode($attrs, true); }
                    $attrText = collect($attrs ?? [])
                      ->map(fn($a) => trim(($a['attribute'] ?? '') . ': ' . ($a['value'] ?? ''), ': '))
                      ->filter()->implode(', ');

                    // ADJUST: image column to match how you store images
                    $img = $item->imageVariant->image
                      ?? $product?->images->first()?->image
                      ?? null;
                  @endphp

                  <div class="p-4 sm:p-5 flex flex-col md:grid md:grid-cols-12 gap-4 items-center"
                       data-row="{{ $item->id }}" data-min="{{ $minQty }}">

                    <div class="md:col-span-6 flex items-center gap-3.5 w-full">
                      @if ($img)
                        <img src="{{ asset('storage/' . ltrim($img, '/')) }}" alt="{{ $product->name ?? '' }}"
                             class="w-16 h-16 sm:w-20 sm:h-20 object-contain rounded-2xl bg-soft-blue p-2 border border-brand-border shrink-0">
                      @else
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-soft-blue border border-brand-border shrink-0 flex items-center justify-center text-brand-border">
                          <i class="fa-solid fa-image"></i>
                        </div>
                      @endif

                      <div class="min-w-0 flex-1">
                        <h4 class="font-heading font-bold text-xs sm:text-sm text-dark-navy hover:text-brand-orange transition line-clamp-2">
                          @if ($product)
                            <a href="{{ route('product', ['slug' => $product->slug]) }}">{{ $product->name }}</a>
                          @else
                            Product unavailable
                          @endif
                        </h4>

                        @if ($attrText)
                          <div class="text-[11px] text-brand-muted font-sans mt-0.5">{{ $attrText }}</div>
                        @endif

                        @foreach ($item->addons as $addon)
                          @if ($addon->detail)
                            <div class="text-[11px] text-brand-muted font-sans">+ {{ $addon->detail }} ({{ $fmt($addon->price) }})</div>
                          @endif
                        @endforeach

                        <button type="button" data-remove="{{ $item->id }}"
                                class="text-xs text-red-500 hover:text-red-700 font-bold font-heading mt-2 transition flex items-center gap-1 cursor-pointer">
                          <i class="fa-regular fa-trash-can text-[11px]"></i><span>Remove</span>
                        </button>
                      </div>
                    </div>

                    <div class="md:col-span-2 text-center w-full md:w-auto flex justify-between md:block">
                      <span class="text-xs text-brand-muted md:hidden font-sans">Price:</span>
                      <span class="text-xs sm:text-sm font-bold font-heading text-dark-navy">{{ $fmt($unitPrice) }}</span>
                    </div>

                    <div class="md:col-span-2 flex justify-between md:justify-center items-center w-full md:w-auto">
                      <span class="text-xs text-brand-muted md:hidden font-sans">Quantity:</span>
                      <div class="flex items-center border border-brand-border rounded-xl bg-white shadow-2xs p-1">
                        <button type="button" data-qty="{{ $item->id }}" data-action="minus"
                                {{ $item->quantity <= $minQty ? 'disabled' : '' }}
                                class="w-7 h-7 rounded-lg text-xs font-bold text-dark-navy hover:bg-soft-blue hover:text-brand-blue flex items-center justify-center cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">-</button>
                        <span data-qty-value class="w-8 text-center text-xs font-bold font-heading text-dark-navy">{{ $item->quantity }}</span>
                        <button type="button" data-qty="{{ $item->id }}" data-action="plus"
                                class="w-7 h-7 rounded-lg text-xs font-bold text-dark-navy hover:bg-soft-blue hover:text-brand-blue flex items-center justify-center cursor-pointer">+</button>
                      </div>
                    </div>

                    <div class="md:col-span-2 text-right w-full md:w-auto flex justify-between md:block">
                      <span class="text-xs text-brand-muted md:hidden font-sans">Total:</span>
                      <span data-line-total class="text-xs sm:text-sm font-bold font-heading text-brand-navy">{{ $fmt($item->total) }}</span>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>

          <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 text-xs font-bold font-heading text-brand-blue hover:text-brand-orange transition">
              <i class="fa-solid fa-arrow-left text-xs"></i><span>CONTINUE EXPLORING →</span>
            </a>
            <button type="button" id="clear-cart-btn" class="text-xs text-red-500 hover:text-red-700 font-bold font-heading transition cursor-pointer">
              <i class="fa-regular fa-trash-can mr-1"></i>Clear Play Bag
            </button>
          </div>
        </div>

        <!-- RIGHT: SUMMARY -->
        <div class="lg:col-span-4 space-y-6">

          <div class="bg-white rounded-3xl border border-brand-border p-5 shadow-xs space-y-3">
            <h3 class="font-heading font-bold text-xs uppercase tracking-wider text-dark-navy flex items-center gap-1.5">
              <i class="fa-solid fa-tag text-brand-orange"></i><span>HAVE A COUPON CODE?</span>
            </h3>
            <form id="apply-coupon-form" class="flex gap-2">
              <input type="text" id="coupon-input" placeholder="Enter coupon code" autocomplete="off"
                     class="flex-1 px-3 py-2 bg-soft-blue/60 border border-brand-border rounded-xl text-xs uppercase font-bold text-dark-navy focus:outline-none focus:border-brand-blue font-sans">
              <button type="submit" id="coupon-apply-btn" class="btn-play-orange text-xs px-4 py-2 rounded-xl transition cursor-pointer">APPLY</button>
            </form>
            <div id="coupon-status" class="text-xs font-semibold font-heading"></div>
          </div>

          <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-4">
            <h3 class="font-heading font-bold text-sm uppercase tracking-wider text-dark-navy pb-3 border-b border-brand-border">ORDER SUMMARY</h3>

            <div class="space-y-2.5 text-xs font-sans">
              <div id="summary-mrp-row" class="{{ $s['savings'] > 0 ? 'flex' : 'hidden' }} justify-between text-body-text">
                <span>MRP Total</span>
                <span id="summary-mrp" class="line-through font-heading">{{ $fmt($s['mrp_total']) }}</span>
              </div>
              <div id="summary-savings-row" class="{{ $s['savings'] > 0 ? 'flex' : 'hidden' }} justify-between text-emerald-600 font-semibold font-heading">
                <span>You Save</span>
                <span id="summary-savings">-{{ $fmt($s['savings']) }}</span>
              </div>

              <div class="flex justify-between text-body-text">
                <span>Subtotal</span>
                <span id="summary-subtotal" class="font-bold text-dark-navy font-heading">{{ $fmt($s['subtotal']) }}</span>
              </div>

              <div id="summary-discount-row" class="{{ $s['discount'] > 0 ? 'flex' : 'hidden' }} justify-between text-emerald-600 font-semibold font-heading">
                <span>Coupon Discount (<span id="summary-coupon-code">{{ $s['coupon_code'] }}</span>)</span>
                <span id="summary-discount">-{{ $fmt($s['discount']) }}</span>
              </div>

              <div id="summary-tax-row" class="{{ $s['tax'] > 0 ? 'flex' : 'hidden' }} justify-between text-body-text">
                <span>Tax</span>
                <span id="summary-tax" class="font-heading">{{ $fmt($s['tax']) }}</span>
              </div>

              <div class="border-t border-brand-border pt-3 flex justify-between items-baseline font-heading">
                <span class="text-sm font-bold text-dark-navy">Grand Total</span>
                <span id="summary-total" class="text-xl font-bold text-brand-navy">{{ $fmt($s['grand_total']) }}</span>
              </div>
            </div>

            <div class="pt-2 space-y-2">
              <a href="{{ route('checkout') }}" class="w-full btn-play-orange py-3.5 px-4 rounded-xl shadow-md transition flex items-center justify-center gap-2 text-xs sm:text-sm text-center">
                <span>PROCEED TO CHECKOUT</span><i class="fa-solid fa-arrow-right text-xs"></i>
              </a>
            </div>

            <div class="pt-2 text-center text-[11px] text-brand-muted flex items-center justify-center gap-1.5 font-sans">
              <i class="fa-solid fa-shield-halved text-emerald-500"></i>
              <span>256-Bit SSL Encrypted & Secure Checkout</span>
            </div>
          </div>
        </div>
      </div>

      <!-- EMPTY VIEW -->
      <div id="cart-empty-layout" class="{{ $hasItems ? 'hidden' : '' }} bg-white rounded-3xl border border-brand-border p-12 md:p-16 text-center space-y-4 max-w-2xl mx-auto shadow-xs">
        <div class="w-24 h-24 rounded-3xl bg-soft-orange text-brand-orange flex items-center justify-center text-4xl mx-auto shadow-inner">
          <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy">Your play bag is empty.</h2>
        <p class="text-xs sm:text-sm text-body-text max-w-md mx-auto font-sans leading-relaxed">Looks like your play bag is empty. Let's find something fun!</p>
        <div class="pt-4">
          <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-lg transition">
            <span>START SHOPPING →</span>
          </a>
        </div>
      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      // Check `php artisan route:list --name=cart` and adjust names/paths if they differ
      const urls = {
        update:       @json(Route::has('cart.update') ? route('cart.update') : url('cart/update')),
        remove:       @json(Route::has('cart.remove') ? route('cart.remove') : url('cart/remove')),
        clear:        @json(Route::has('cart.clear') ? route('cart.clear') : url('cart/clear')),
        applyCoupon:  @json(Route::has('cart.coupon.apply') ? route('cart.coupon.apply') : url('cart/apply-coupon')),
        removeCoupon: @json(Route::has('cart.coupon.remove') ? route('cart.coupon.remove') : url('cart/remove-coupon')),
      };
      const csrf = @json(csrf_token());

      const page        = document.getElementById('cart-page');
      const threshold   = parseFloat(page.dataset.threshold) || 0;
      const itemsBox    = document.getElementById('cart-items-container');
      const activeEl    = document.getElementById('cart-active-layout');
      const emptyEl     = document.getElementById('cart-empty-layout');
      const titleCount  = document.getElementById('cart-title-count');
      const couponInput = document.getElementById('coupon-input');
      const couponStat  = document.getElementById('coupon-status');

      const money = (n) => '₹' + Number(n || 0).toLocaleString('en-IN');
      const $ = (id) => document.getElementById(id);
      const toast = (msg, type = 'info') => Components.showToast(msg, type);

      async function post(url, fields = {}) {
        const fd = new FormData();
        Object.entries(fields).forEach(([k, v]) => fd.append(k, v));
        const res = await fetch(url, {
          method: 'POST',
          headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
          body: fd,
        });
        let data = {};
        try { data = await res.json(); } catch (e) {}
        if (!res.ok || data.status === false) {
          throw new Error(data.message || 'Something went wrong. Please try again.');
        }
        return data;
      }

      function setHeaderCount(n) {
        document.querySelectorAll('#header-cart-count, [data-cart-count]').forEach((el) => {
          el.textContent = n;
          el.classList.toggle('hidden', !(n > 0));
        });
      }

      function toggleRow(id, show) {
        const el = $(id);
        if (!el) return;
        el.classList.toggle('hidden', !show);
        el.classList.toggle('flex', show);
      }

      function renderShipping(subtotal) {
        const text = $('cart-free-shipping-text');
        const bar = $('cart-free-shipping-bar');
        if (!text || !bar || !threshold) return;

        const remaining = Math.max(0, threshold - subtotal);
        const pct = Math.min(100, Math.floor((subtotal / threshold) * 100));

        text.innerHTML = remaining > 0
          ? `<span>Add <strong>${money(remaining)}</strong> more to unlock <strong>FREE Delivery</strong></span><span>${pct}%</span>`
          : `<span class="text-emerald-700">You unlocked <strong>FREE Delivery</strong></span><span>100%</span>`;
        bar.style.width = pct + '%';
      }

      function renderCouponStatus(code) {
        if (code) {
          couponStat.className = 'text-xs font-bold text-emerald-600 mt-1 font-heading flex items-center justify-between';
          couponStat.innerHTML = '<span></span><button type="button" id="coupon-remove-btn" class="text-red-500 hover:text-red-700 cursor-pointer">Remove</button>';
          couponStat.querySelector('span').textContent = `Coupon ${code} applied`;
        } else {
          couponStat.className = 'text-xs font-semibold font-heading';
          couponStat.textContent = '';
        }
      }

      function showEmptyIfNeeded() {
        if (!itemsBox.querySelector('[data-row]')) {
          activeEl.classList.add('hidden');
          emptyEl.classList.remove('hidden');
        }
      }

      function applySummary(s) {
        if (!s) return;
        const count = s.count || 0;
        titleCount.textContent = `(${count} ${count === 1 ? 'item' : 'items'})`;
        setHeaderCount(count);

        $('summary-subtotal').textContent = money(s.subtotal);
        $('summary-total').textContent = money(s.grand_total);

        toggleRow('summary-mrp-row', s.savings > 0);
        toggleRow('summary-savings-row', s.savings > 0);
        $('summary-mrp').textContent = money(s.mrp_total);
        $('summary-savings').textContent = '-' + money(s.savings);

        toggleRow('summary-discount-row', s.discount > 0);
        $('summary-discount').textContent = '-' + money(s.discount);
        $('summary-coupon-code').textContent = s.coupon_code || '';

        toggleRow('summary-tax-row', s.tax > 0);
        $('summary-tax').textContent = money(s.tax);

        renderShipping(s.subtotal);
        renderCouponStatus(s.coupon_code);
        if (!s.coupon_code) { /* keep any typed code */ }
        if (count === 0) showEmptyIfNeeded();
      }

      function afterMutation(data) {
        applySummary(data.summary);
        if (data.coupon_removed && data.coupon_message) toast(data.coupon_message, 'info');
      }

      // Qty + remove (delegated)
      itemsBox.addEventListener('click', async (e) => {
        const q = e.target.closest('[data-qty]');
        if (q && !q.disabled) {
          const row = q.closest('[data-row]');
          q.disabled = true;
          try {
            const data = await post(urls.update, { item_id: q.dataset.qty, action: q.dataset.action });
            row.querySelector('[data-qty-value]').textContent = data.quantity;
            row.querySelector('[data-line-total]').textContent = money(data.item_total);
            const min = parseInt(row.dataset.min, 10) || 1;
            row.querySelector('[data-action="minus"]').disabled = data.quantity <= min;
            afterMutation(data);
          } catch (err) {
            toast(err.message, 'info');
          } finally {
            if (q.dataset.action === 'plus') q.disabled = false;
          }
          return;
        }

        const r = e.target.closest('[data-remove]');
        if (r) {
          r.disabled = true;
          try {
            const data = await post(urls.remove, { id: r.dataset.remove });
            r.closest('[data-row]').remove();
            toast('Item removed from your play bag', 'info');
            afterMutation(data);
            showEmptyIfNeeded();
          } catch (err) {
            r.disabled = false;
            toast(err.message, 'info');
          }
        }
      });

      // Clear all
      $('clear-cart-btn')?.addEventListener('click', async () => {
        if (!confirm('Are you sure you want to empty your play bag?')) return;
        try {
          await post(urls.clear);
          itemsBox.innerHTML = '';
          setHeaderCount(0);
          titleCount.textContent = '(0 items)';
          showEmptyIfNeeded();
          toast('Play bag emptied', 'info');
        } catch (err) {
          toast(err.message, 'info');
        }
      });

      // Apply coupon
      $('apply-coupon-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const code = couponInput.value.trim();
        if (!code) return;
        const btn = $('coupon-apply-btn');
        btn.disabled = true;
        try {
          const data = await post(urls.applyCoupon, { coupon_code: code });
          couponInput.value = '';
          applySummary(data.summary);
          toast(data.message || 'Coupon applied', 'success');
        } catch (err) {
          couponStat.className = 'text-xs font-bold text-red-500 mt-1 font-heading';
          couponStat.textContent = err.message;
        } finally {
          btn.disabled = false;
        }
      });

      // Remove coupon
      couponStat.addEventListener('click', async (e) => {
        if (!e.target.closest('#coupon-remove-btn')) return;
        try {
          const data = await post(urls.removeCoupon);
          applySummary(data.summary);
          toast('Coupon removed', 'info');
        } catch (err) {
          toast(err.message, 'info');
        }
      });

      // Initial state from server-rendered data
      renderCouponStatus(page.dataset.coupon || null);
      renderShipping(parseFloat(@json((float) $s['subtotal'])) || 0);
    });
  </script>
@endpush