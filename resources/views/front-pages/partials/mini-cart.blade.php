{{-- Mini cart drawer: fully server-driven (JSON from cart.mini) --}}
<div id="mini-cart" aria-hidden="true">
  <div id="mini-cart-backdrop" class="drawer-backdrop fixed inset-0 z-50 bg-black/60 backdrop-blur-xs transition-opacity"></div>

  <div class="cart-drawer-panel fixed top-0 right-0 bottom-0 w-full max-w-md bg-white z-50 shadow-2xl flex flex-col">
    <div class="p-4 border-b border-brand-border flex items-center justify-between bg-warm-cream shrink-0">
      <div class="flex items-center gap-2.5">
        <div class="w-9 h-9 rounded-xl bg-soft-orange text-brand-orange flex items-center justify-center text-base">
          <i class="fa-solid fa-bag-shopping"></i>
        </div>
        <div>
          <h3 class="font-heading font-bold text-dark-navy text-lg leading-tight">YOUR PLAY BAG</h3>
          <p id="mc-subtitle" class="text-[11px] text-brand-muted font-sans">&nbsp;</p>
        </div>
      </div>
      <button type="button" data-mc-close class="w-8 h-8 rounded-full hover:bg-gray-100 text-dark-navy flex items-center justify-center transition cursor-pointer" aria-label="Close">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>
    </div>

    <div id="mc-shipping" class="bg-soft-blue px-4 py-3 border-b border-blue-100 shrink-0 hidden"></div>
    <div id="mc-error" class="hidden px-4 py-2 text-xs font-semibold text-red-600 bg-red-50 border-b border-red-100 font-heading shrink-0"></div>
    <div id="mc-items" class="flex-1 overflow-y-auto p-4 space-y-3.5"></div>
    <div id="mc-footer" class="p-4 border-t border-brand-border bg-warm-cream space-y-3 shrink-0 hidden"></div>
  </div>
</div>

<script>
(function () {
  const urls = {
    mini:     @json(Route::has('cart.mini') ? route('cart.mini') : url('cart/mini')),
    update:   @json(Route::has('cart.update') ? route('cart.update') : url('cart/update')),
    remove:   @json(Route::has('cart.remove') ? route('cart.remove') : url('cart/remove')),
    cart:     @json(url('cart')),
    checkout: @json(url('checkout')),
    shop:     @json(route('shop')),
  };
  const csrf = @json(csrf_token());

  const root     = document.getElementById('mini-cart');
  const backdrop = root.querySelector('.drawer-backdrop');
  const panel    = root.querySelector('.cart-drawer-panel');
  const elSub    = document.getElementById('mc-subtitle');
  const elShip   = document.getElementById('mc-shipping');
  const elErr    = document.getElementById('mc-error');
  const elItems  = document.getElementById('mc-items');
  const elFoot   = document.getElementById('mc-footer');

  const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const money = (n) => '₹' + Number(n || 0).toLocaleString('en-IN');

  let isOpen = false;

  function setHeaderCount(n) {
    document.querySelectorAll('#header-cart-count, [data-cart-count]').forEach((el) => {
      el.textContent = n;
      el.classList.toggle('hidden', !(n > 0));
    });
  }

  function showError(msg) {
    elErr.textContent = msg || '';
    elErr.classList.toggle('hidden', !msg);
  }

  function render(d) {
    const count = d.count || 0;
    setHeaderCount(count);
    elSub.textContent = count + (count === 1 ? ' item' : ' items') + ' ready for fun';

    // Free-shipping bar: hidden when no threshold is configured
    if (d.free_shipping_threshold) {
      elShip.classList.remove('hidden');
      elShip.innerHTML = d.amount_for_free_shipping > 0
        ? `<div class="text-xs text-brand-blue font-semibold mb-1.5 flex justify-between font-heading">
             <span>Add <strong>${money(d.amount_for_free_shipping)}</strong> more for <strong>FREE Delivery</strong></span>
             <span>${d.free_shipping_percent}%</span>
           </div>
           <div class="w-full bg-blue-200 rounded-full h-2 overflow-hidden">
             <div class="bg-brand-orange h-2 rounded-full transition-all duration-500" style="width:${d.free_shipping_percent}%"></div>
           </div>`
        : `<div class="text-xs text-emerald-700 font-bold flex items-center gap-1.5 font-heading">
             <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
             <span>You unlocked <strong>FREE Standard Delivery</strong></span>
           </div>`;
    } else {
      elShip.classList.add('hidden');
    }

    if (!d.items || !d.items.length) {
      elItems.innerHTML = `
        <div class="h-full flex flex-col items-center justify-center text-center p-6 space-y-4">
          <div class="w-20 h-20 rounded-3xl bg-soft-orange flex items-center justify-center text-brand-orange text-3xl shadow-inner">
            <i class="fa-solid fa-bag-shopping"></i>
          </div>
          <div>
            <h4 class="font-heading font-bold text-dark-navy text-lg">Your play bag is empty</h4>
            <p class="text-xs text-body-text mt-1 max-w-xs font-sans">Looks like your play bag is empty. Let's find something fun!</p>
          </div>
          <a href="${esc(urls.shop)}" class="inline-block btn-play-orange text-xs px-6 py-3 rounded-xl transition">START SHOPPING →</a>
        </div>`;
      elFoot.classList.add('hidden');
      return;
    }

    elItems.innerHTML = d.items.map((it) => {
      const atMin = it.qty <= it.min_qty;
      return `
      <div class="flex gap-3 pb-3 border-b border-brand-border items-center">
        ${it.image
          ? `<img src="${esc(it.image)}" alt="${esc(it.name)}" class="w-16 h-16 object-contain rounded-xl bg-soft-blue p-1.5 border border-brand-border shrink-0">`
          : `<div class="w-16 h-16 rounded-xl bg-soft-blue border border-brand-border shrink-0 flex items-center justify-center text-brand-border"><i class="fa-solid fa-image"></i></div>`}
        <div class="flex-1 min-w-0">
          <h4 class="text-xs font-bold font-heading text-dark-navy line-clamp-1 hover:text-brand-orange transition">
            <a href="${esc(it.url)}">${esc(it.name)}</a>
          </h4>
          ${it.attrs ? `<div class="text-[10px] text-brand-muted font-sans truncate">${esc(it.attrs)}</div>` : ''}
          <div class="text-xs font-extrabold font-heading text-brand-navy mt-0.5">${money(it.total)}</div>
          <div class="flex items-center justify-between mt-1.5">
            <div class="flex items-center border border-brand-border rounded-lg bg-white shadow-2xs">
              <button type="button" data-mc-qty="${it.id}" data-action="minus" ${atMin ? 'disabled' : ''} class="px-2 py-0.5 text-xs text-brand-navy hover:text-brand-orange font-bold cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">-</button>
              <span class="px-2 text-xs font-bold text-dark-navy font-heading">${it.qty}</span>
              <button type="button" data-mc-qty="${it.id}" data-action="plus" class="px-2 py-0.5 text-xs text-brand-navy hover:text-brand-orange font-bold cursor-pointer">+</button>
            </div>
            <button type="button" data-mc-remove="${it.id}" class="text-xs text-red-400 hover:text-red-600 transition p-1 cursor-pointer" title="Remove">
              <i class="fa-regular fa-trash-can"></i>
            </button>
          </div>
        </div>
      </div>`;
    }).join('');

    elFoot.classList.remove('hidden');
    elFoot.innerHTML = `
      <div class="space-y-1.5 text-xs font-sans">
        <div class="flex justify-between text-brand-muted"><span>Subtotal:</span><span class="font-bold text-dark-navy font-heading">${money(d.subtotal)}</span></div>
        ${d.discount > 0 ? `<div class="flex justify-between text-emerald-600 font-semibold font-heading"><span>Discount${d.coupon ? ' (' + esc(d.coupon) + ')' : ''}:</span><span>-${money(d.discount)}</span></div>` : ''}
        ${d.tax > 0 ? `<div class="flex justify-between text-brand-muted"><span>Tax:</span><span class="font-heading">${money(d.tax)}</span></div>` : ''}
        <div class="flex justify-between text-sm font-bold text-dark-navy pt-2 border-t border-brand-border font-heading"><span>Total Amount:</span><span class="text-brand-navy">${money(d.total)}</span></div>
      </div>
      <div class="space-y-2 pt-1 font-heading">
        <a href="${esc(urls.checkout)}" class="w-full btn-play-orange py-3 px-4 rounded-xl shadow-md transition flex items-center justify-center gap-2 text-xs sm:text-sm text-center">
          <span>CHECKOUT NOW</span><i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
        <a href="${esc(urls.cart)}" class="w-full bg-white hover:bg-soft-blue text-brand-blue border border-brand-blue/30 font-bold py-2.5 px-4 rounded-xl transition text-xs text-center block">GO TO CART →</a>
      </div>`;
  }

  async function load() {
    try {
      const res = await fetch(urls.mini, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
      if (!res.ok) throw new Error('load failed');
      render(await res.json());
    } catch (e) {
      elItems.innerHTML = '<div class="p-8 text-center text-sm text-brand-muted font-heading">Could not load your play bag. Please try again.</div>';
    }
  }

  async function mutate(url, fields) {
    showError('');
    const fd = new FormData();
    Object.entries(fields).forEach(([k, v]) => fd.append(k, v));
    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
        body: fd,
      });
      if (!res.ok) {
        let data = {};
        try { data = await res.json(); } catch (e) {}
        showError(data.message || 'Could not update your play bag.');
      }
    } catch (e) {
      showError('Network error. Please try again.');
    }
    await load();
  }

  function open() {
    isOpen = true;
    root.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    showError('');
    backdrop.classList.add('active');
    panel.classList.add('active');
    load();
  }

  function close() {
    isOpen = false;
    root.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    backdrop.classList.remove('active');
    panel.classList.remove('active');
  }

  document.addEventListener('click', (e) => {
    if (e.target.closest('#header-cart-btn, #mobile-bottom-cart-btn, .open-cart-drawer-btn')) {
      e.preventDefault();
      open();
      return;
    }
    if (e.target === backdrop || e.target.closest('[data-mc-close]')) { close(); return; }

    const q = e.target.closest('[data-mc-qty]');
    if (q && !q.disabled) {
      mutate(urls.update, { item_id: q.dataset.mcQty, action: q.dataset.action });
      return;
    }
    const r = e.target.closest('[data-mc-remove]');
    if (r) mutate(urls.remove, { id: r.dataset.mcRemove });
  });

  document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && isOpen) close(); });

  // Add-to-cart script dispatches this; keep an open drawer in sync
  window.addEventListener('cart:added', () => { if (isOpen) load(); });

  window.MiniCart = { open, close, refresh: load };
})();
</script>