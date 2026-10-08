// Aparatus Pastime - Modern Playful Premium Kids Theme Components & UI Engine

import { products } from './data/products.js';
import { categories } from './data/categories.js';
import { blogs } from './data/blogs.js';
import { State } from './state.js';

export const Components = {
  // Toast Notification Trigger
  showToast(message, type = 'success', prefix = '') {
    let container = document.getElementById('toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    const borderClass = type === 'success' ? 'toast-success' : type === 'orange' ? 'toast-orange' : 'toast-info';
    const bgCircle = type === 'success' 
      ? 'bg-emerald-100 text-emerald-600' 
      : type === 'orange' 
      ? 'bg-orange-100 text-brand-orange' 
      : 'bg-blue-100 text-brand-blue';
    const iconClass = type === 'success' 
      ? 'fa-circle-check' 
      : type === 'orange' 
      ? 'fa-bag-shopping' 
      : 'fa-sparkles';
    const titleText = type === 'orange' ? 'Added to Play Bag! 🛍️' : type === 'success' ? 'Success! ✨' : 'Note 💡';

    toast.className = `toast-item ${borderClass}`;
    toast.innerHTML = `
      <div class="w-10 h-10 rounded-2xl ${bgCircle} flex items-center justify-center text-lg shrink-0 shadow-2xs">
        <i class="fa-solid ${iconClass}"></i>
      </div>
      <div class="flex-1 min-w-0">
        <h6 class="text-[10.5px] sm:text-[11px] uppercase tracking-wider font-bold font-heading text-brand-muted leading-tight">${titleText}</h6>
        <p class="text-xs sm:text-[13px] font-bold font-heading text-dark-navy leading-snug line-clamp-2 mt-0.5">${message}</p>
      </div>
      ${type === 'orange' ? `
        <button class="toast-view-cart text-[11px] font-bold font-heading text-brand-blue hover:text-brand-orange bg-soft-blue hover:bg-soft-orange px-2.5 py-1.5 rounded-xl transition whitespace-nowrap shrink-0 cursor-pointer border border-brand-blue/20">
          VIEW BAG
        </button>
      ` : ''}
      <button class="text-gray-400 hover:text-dark-navy p-1.5 rounded-xl hover:bg-gray-100 transition focus:outline-none shrink-0 cursor-pointer ml-1" onclick="this.closest('.toast-item').remove()">
        <i class="fa-solid fa-xmark text-xs"></i>
      </button>
    `;



    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 350);
    }, 4000);
  },

  // Open Quick View Modal
  openQuickView(productId, prefix = '') {
    const product = products.find(p => p.id === Number(productId));
    if (!product) return;

    let modal = document.getElementById('quick-view-modal');
    if (!modal) {
      modal = document.createElement('div');
      modal.id = 'quick-view-modal';
      document.body.appendChild(modal);
    }

    const starsHtml = Array.from({ length: 5 }, (_, i) => {
      return i < Math.floor(product.rating)
        ? '<i class="fa-solid fa-star star-filled text-xs"></i>'
        : '<i class="fa-solid fa-star star-empty text-xs"></i>';
    }).join('');

    // Select pastel background for product card container
    const pastelBgs = ['bg-soft-blue', 'bg-soft-yellow', 'bg-soft-mint', 'bg-soft-orange', 'bg-soft-purple'];
    const pBg = pastelBgs[product.id % pastelBgs.length];

    modal.className = 'fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/60 backdrop-blur-xs transition-all duration-300';
    modal.style.display = 'flex';

    modal.innerHTML = `
      <div class="modal-content-box bg-white rounded-3xl shadow-2xl max-w-3xl w-full overflow-hidden relative max-h-[90vh] flex flex-col md:flex-row border border-brand-border">
        <button id="close-quick-view" class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full bg-white/95 text-brand-navy shadow-md hover:bg-brand-orange hover:text-white transition flex items-center justify-center cursor-pointer">
          <i class="fa-solid fa-xmark text-sm"></i>
        </button>

        <div class="md:w-1/2 p-6 ${pBg} flex flex-col items-center justify-center relative shrink-0">
          <span class="absolute top-4 left-4 bg-brand-orange text-white text-[11px] font-bold font-heading px-3 py-1 rounded-full shadow-sm">
            ${product.badge || 'POPULAR'}
          </span>
          <img id="qv-main-img" src="${product.images[0]}" alt="${product.name}" class="max-h-60 w-auto object-contain rounded-2xl transition duration-300 drop-shadow-sm">
          ${product.images.length > 1 ? `
            <div class="flex gap-2 mt-4">
              ${product.images.map((img, idx) => `
                <button class="qv-thumb-btn border-2 ${idx === 0 ? 'border-brand-blue' : 'border-transparent'} rounded-xl p-1 bg-white w-12 h-12 flex items-center justify-center shadow-xs transition cursor-pointer" data-img="${img}">
                  <img src="${img}" class="w-full h-full object-contain rounded-lg">
                </button>
              `).join('')}
            </div>
          ` : ''}
        </div>

        <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-between overflow-y-auto">
          <div>
            <div class="flex items-center gap-2 mb-2">
              <span class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-2.5 py-0.5 rounded-full font-heading">
                ${product.categoryName}
              </span>
              <span class="text-xs font-bold text-brand-navy bg-play-yellow/30 px-2.5 py-0.5 rounded-full font-heading">
                AGE: ${product.ageLabel}
              </span>
            </div>
            
            <h2 class="text-xl md:text-2xl font-bold font-heading text-dark-navy mb-2 leading-snug">${product.name}</h2>
            
            <div class="flex items-center gap-2 mb-3">
              <div class="flex items-center">${starsHtml}</div>
              <span class="text-xs font-bold text-dark-navy">${product.rating}</span>
              <span class="text-xs text-brand-muted font-sans">(${product.reviewCount} reviews)</span>
            </div>

            <div class="flex items-baseline gap-3 mb-3 font-heading">
              <span class="text-2xl font-bold text-brand-navy">₹${product.price.toLocaleString()}</span>
              <span class="text-sm text-brand-muted line-through">₹${product.originalPrice.toLocaleString()}</span>
              <span class="text-xs font-bold text-brand-orange bg-soft-orange px-2 py-0.5 rounded-full">${product.discount}% OFF</span>
            </div>

            <p class="text-xs text-body-text leading-relaxed mb-4 font-sans line-clamp-3">
              ${product.shortDescription}
            </p>

            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-4 bg-emerald-50 px-3 py-2 rounded-xl">
              <i class="fa-solid fa-circle-check text-emerald-500"></i>
              <span>In Stock (${product.stock} units) • Ready to ship</span>
            </div>
          </div>

          <div>
            <div class="flex items-center gap-3 mb-3">
              <div class="flex items-center border border-brand-border rounded-xl bg-white shadow-xs p-0.5">
                <button id="qv-qty-minus" class="w-8 h-8 rounded-lg text-brand-navy hover:bg-soft-blue hover:text-brand-blue font-bold transition flex items-center justify-center cursor-pointer shrink-0"><i class="fa-solid fa-minus text-xs"></i></button>
                <input id="qv-qty-input" type="number" value="1" min="1" max="${product.stock}" class="w-10 h-8 text-center text-sm font-bold text-dark-navy font-heading focus:outline-none p-0 m-0 bg-transparent flex items-center justify-center leading-none" readonly>
                <button id="qv-qty-plus" class="w-8 h-8 rounded-lg text-brand-navy hover:bg-soft-blue hover:text-brand-blue font-bold transition flex items-center justify-center cursor-pointer shrink-0"><i class="fa-solid fa-plus text-xs"></i></button>
              </div>

              <button id="qv-add-to-cart" data-id="${product.id}" class="flex-1 btn-play-orange py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 text-xs sm:text-sm font-heading font-bold cursor-pointer">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>ADD TO CART</span>
              </button>
            </div>

            <div class="flex items-center justify-between pt-3 border-t border-brand-border text-xs font-heading">
              <a href="${prefix}product?slug=${product.slug}" class="text-brand-blue hover:text-brand-orange font-bold flex items-center gap-1.5 transition">
                <span>View Full Details & Specs</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </a>
              <button class="wishlist-toggle-btn text-brand-muted hover:text-red-500 transition flex items-center gap-1.5 cursor-pointer" data-id="${product.id}">
                <i class="${State.isInWishlist(product.id) ? 'fa-solid fa-heart text-red-500' : 'fa-regular fa-heart'}"></i>
                <span>Wishlist</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    `;

    const closeModal = () => {
      modal.style.display = 'none';
      modal.innerHTML = '';
    };

    const closeBtn = document.getElementById('close-quick-view');
    if (closeBtn) closeBtn.onclick = closeModal;
    modal.onclick = (e) => {
      if (e.target === modal) closeModal();
    };

    // ESC key closes modal
    const handleEsc = (e) => {
      if (e.key === 'Escape') {
        closeModal();
        document.removeEventListener('keydown', handleEsc);
      }
    };
    document.addEventListener('keydown', handleEsc);

    // Thumbnail Switcher
    const thumbs = modal.querySelectorAll('.qv-thumb-btn');
    const mainImg = document.getElementById('qv-main-img');
    thumbs.forEach(t => {
      t.onclick = () => {
        thumbs.forEach(btn => btn.classList.replace('border-brand-blue', 'border-transparent'));
        t.classList.replace('border-transparent', 'border-brand-blue');
        mainImg.src = t.getAttribute('data-img');
      };
    });

    // Qty +/-
    const qtyInput = document.getElementById('qv-qty-input');
    document.getElementById('qv-qty-minus').onclick = () => {
      let val = parseInt(qtyInput.value) || 1;
      if (val > 1) qtyInput.value = val - 1;
    };
    document.getElementById('qv-qty-plus').onclick = () => {
      let val = parseInt(qtyInput.value) || 1;
      if (val < product.stock) qtyInput.value = val + 1;
    };

    // Add to cart from modal
    document.getElementById('qv-add-to-cart').onclick = () => {
      const qty = parseInt(qtyInput.value) || 1;
      State.addToCart(product.id, qty);
      Components.showToast(`${product.name} (x${qty}) added to your play bag!`, 'orange', prefix);
      closeModal();
    };
  },


  // Render Product Card
  renderProductCard(product, prefix = '') {
    const isWished = State.isInWishlist(product.id);
    const starsHtml = Array.from({ length: 5 }, (_, i) => {
      return i < Math.floor(product.rating)
        ? '<i class="fa-solid fa-star star-filled text-[10px] sm:text-[11px]"></i>'
        : '<i class="fa-solid fa-star star-empty text-[10px] sm:text-[11px]"></i>';
    }).join('');

    // Select pastel image background for lively card feel
    const pastelBgs = ['bg-soft-blue', 'bg-soft-yellow', 'bg-soft-mint', 'bg-soft-orange', 'bg-soft-purple'];
    const pBg = pastelBgs[product.id % pastelBgs.length];

    return `
      <div class="product-card group bg-white border border-brand-border p-2.5 sm:p-3.5 xl:p-4 flex flex-col justify-between relative overflow-hidden h-full">
        
        <!-- Top Tags & Wishlist / Quick View -->
        <div class="relative w-full">
          <div class="product-image-container relative ${pBg} aspect-square flex items-center justify-center p-0 overflow-hidden mb-2 sm:mb-2.5 rounded-xl sm:rounded-2xl">
            <!-- Badge / Tag (Clean left-aligned with max width to prevent overlap) -->
            <span class="absolute top-2 left-2 max-w-[58%] truncate bg-brand-orange text-white text-[9px] sm:text-[10px] font-bold font-heading px-2 py-0.5 rounded-md shadow-2xs z-10 uppercase tracking-wide">
              ${product.badge || 'POPULAR'}
            </span>

            <!-- Top Right Action Badges: Wishlist & Quick View (Crisp outline icons with smooth hover & touch states) -->
            <div class="absolute top-2 right-2 sm:top-2.5 sm:right-2.5 flex flex-col gap-1.5 z-10">
              <button class="card-action-btn wishlist-btn ${isWished ? 'is-active text-red-500' : 'text-slate-600'}" data-id="${product.id}" title="${isWished ? 'Remove from Wishlist' : 'Add to Wishlist'}" aria-label="Wishlist">
                <i class="${isWished ? 'fa-solid fa-heart text-red-500' : 'fa-regular fa-heart'} text-xs sm:text-sm"></i>
              </button>
              <button class="card-action-btn quick-view-btn text-slate-600" data-id="${product.id}" title="Quick View" aria-label="Quick View">
                <i class="fa-regular fa-eye text-xs sm:text-sm"></i>
              </button>
            </div>

            <!-- Product Image (Edge to edge with zero left/right padding) -->
            <a href="${prefix}product?slug=${product.slug}" class="w-full h-full flex items-center justify-center p-0 overflow-hidden">
              <img src="${product.images[0]}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
            </a>

            <!-- Quick View Hover Button (Desktop) -->
            <button class="quick-view-btn hidden md:flex absolute bottom-2 inset-x-2 bg-dark-navy/90 hover:bg-brand-orange text-white text-xs font-bold py-2 px-3 rounded-xl shadow-md items-center justify-center gap-1.5 opacity-0 group-hover:opacity-100 transition duration-200 z-10 font-heading cursor-pointer" data-id="${product.id}">
              <i class="fa-solid fa-eye text-xs"></i>
              <span>QUICK VIEW</span>
            </button>
          </div>
        </div>

        <!-- Product Meta -->
        <div class="flex-1 flex flex-col justify-between">
          <div>
            <div class="flex items-center justify-between gap-1 text-[10px] sm:text-[11px] mb-1 font-heading">
              <span class="uppercase font-bold tracking-wide text-brand-blue text-[9px] sm:text-[10px] truncate max-w-[55%]">${product.categoryName}</span>
              <span class="text-brand-navy bg-play-yellow/35 px-1.5 py-0.5 rounded-md font-bold text-[8.5px] sm:text-[9.5px] whitespace-nowrap shrink-0">AGE: ${product.ageLabel}</span>
            </div>

            <h3 class="product-title font-heading font-bold text-dark-navy text-xs sm:text-sm line-clamp-2 mb-1.5 hover:text-brand-orange transition min-h-[2rem] sm:min-h-[2.5rem] leading-snug">
              <a href="${prefix}product?slug=${product.slug}">${product.name}</a>
            </h3>

            <div class="flex items-center gap-1.5 mb-2 sm:mb-2.5">
              <div class="flex items-center text-amber-400">${starsHtml}</div>
              <span class="text-[10px] sm:text-[11px] font-bold text-dark-navy">${product.rating}</span>
              <span class="text-[10px] sm:text-[11px] text-brand-muted font-sans">(${product.reviewCount})</span>
            </div>
          </div>

          <!-- Price & Add to Cart -->
          <div>
            <div class="flex items-baseline gap-1.5 sm:gap-2 mb-2 sm:mb-2.5 font-heading flex-wrap">
              <span class="text-sm sm:text-base font-bold text-brand-navy">₹${product.price.toLocaleString()}</span>
              <span class="text-xs text-brand-muted line-through font-normal">₹${product.originalPrice.toLocaleString()}</span>
              <span class="text-[9.5px] sm:text-[10px] font-bold text-brand-orange bg-soft-orange px-1.5 py-0.5 rounded-full whitespace-nowrap">${product.discount}% OFF</span>
            </div>

            <button class="add-to-cart-btn w-full btn-play-blue hover:btn-play-orange text-white font-bold font-heading text-xs sm:text-sm py-2 sm:py-2.5 px-3 rounded-xl shadow-2xs transition flex items-center justify-center gap-1.5 sm:gap-2 cursor-pointer" data-id="${product.id}">
              <i class="fa-solid fa-bag-shopping text-xs shrink-0"></i>
              <span class="truncate">ADD TO CART</span>
            </button>
          </div>
        </div>

      </div>
    `;
  },

  // Render Category Card
  renderCategoryCard(cat, prefix = '') {
    const bgClass = cat.pastelBg || 'bg-soft-orange';
    const cleanTagline = (cat.tagline || 'EXPLORE').replace('→', '').trim();
    return `
      <a href="${prefix}shop?category=${cat.slug}" class="category-card group ${bgClass} border border-brand-border/80 hover:border-brand-orange/40 p-2 sm:p-2.5 xl:p-3 rounded-2xl xl:rounded-3xl flex flex-col items-center justify-between text-center shadow-2xs hover:shadow-md transition-all duration-300">
        <div class="w-full aspect-square bg-white rounded-xl sm:rounded-2xl overflow-hidden mb-2 relative flex items-center justify-center p-1 sm:p-1.5 shadow-2xs border border-white/70">
          <img src="${cat.image}" alt="${cat.name}" class="w-full h-full object-cover rounded-lg sm:rounded-xl group-hover:scale-108 transition-transform duration-500 ease-out" loading="lazy">
          <span class="absolute bottom-1.5 right-1.5 sm:bottom-2 sm:right-2 w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-brand-orange text-white flex items-center justify-center shadow-md text-[10px] sm:text-xs group-hover:scale-110 group-hover:bg-brand-navy border-2 border-white transition duration-200">
            <i class="fa-solid fa-arrow-right"></i>
          </span>
        </div>
        <div class="w-full flex flex-col items-center justify-center">
          <h3 class="font-heading font-bold text-dark-navy text-xs sm:text-[13px] xl:text-sm group-hover:text-brand-orange transition leading-tight min-h-[2rem] sm:min-h-[2.25rem] flex items-center justify-center text-center px-0.5">${cat.name}</h3>
          <span class="text-[8.5px] sm:text-[9.5px] xl:text-[10.5px] font-bold text-brand-blue font-heading mt-0.5 flex items-center justify-center gap-1 group-hover:text-brand-orange transition uppercase tracking-normal sm:tracking-wide leading-none text-center">
            <span>${cleanTagline}</span>
            <i class="fa-solid fa-arrow-right text-[7px] sm:text-[8px] group-hover:translate-x-0.5 transition-transform"></i>
          </span>
        </div>
      </a>
    `;
  },

  // Render Blog Card
  renderBlogCard(blog, prefix = '') {
    return `
      <article class="bg-white rounded-2xl border border-brand-border overflow-hidden shadow-xs hover:shadow-lg transition flex flex-col justify-between group">
        <div>
          <div class="aspect-16/10 overflow-hidden bg-soft-blue relative">
            <img src="${blog.image}" alt="${blog.title}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
            <span class="absolute top-3 left-3 bg-brand-navy/95 text-white text-[11px] font-bold font-heading px-3 py-1 rounded-full shadow-sm">
              ${blog.category}
            </span>
          </div>
          <div class="p-5">
            <div class="flex items-center gap-3 text-xs text-brand-muted mb-2 font-medium font-sans">
              <span><i class="fa-regular fa-calendar mr-1 text-brand-orange"></i>${blog.date}</span>
              <span>•</span>
              <span><i class="fa-regular fa-clock mr-1 text-brand-blue"></i>${blog.readTime}</span>
            </div>
            <h3 class="font-heading font-bold text-dark-navy text-base md:text-lg mb-2 group-hover:text-brand-orange transition line-clamp-2">
              <a href="${prefix}blog-detail?slug=${blog.slug}">${blog.title}</a>
            </h3>
            <p class="text-xs md:text-sm text-body-text line-clamp-3 leading-relaxed mb-4 font-sans">
              ${blog.excerpt}
            </p>
          </div>
        </div>
        <div class="px-5 pb-5">
          <a href="${prefix}blog-detail?slug=${blog.slug}" class="text-brand-blue hover:text-brand-orange text-xs md:text-sm font-bold font-heading flex items-center gap-1.5 transition">
            <span>Read Full Article</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
          </a>
        </div>
      </article>
    `;
  },

  // Render Global Header
  renderHeader(activeNav = 'home', prefix = '') {
    const user = State.getUser();
    const cartCount = State.getCartCount();
    const wishlistCount = State.getWishlistCount();

    return `
      <!-- TOP MINI STRIP -->
      <div class="bg-brand-navy text-white text-[10px] sm:text-xs py-1 sm:py-1.5 px-3 sm:px-4 border-b border-white/10 font-heading">
        <div class="max-w-7xl mx-auto relative flex items-center justify-center min-h-[20px] sm:min-h-[22px]">
          <!-- Centered Free Shipping Announcement -->
          <div class="flex items-center justify-center gap-1.5 sm:gap-2 text-center">
            <span class="bg-brand-orange text-white text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 uppercase tracking-tight shadow-2xs">FREE SHIPPING</span>
            <span class="tracking-wide text-[10px] sm:text-xs font-semibold">ON ORDERS ABOVE ₹999</span>
          </div>
          <!-- Right-aligned Help Contact (Desktop & Tablet) -->
          <div class="hidden sm:flex items-center gap-2 text-white/90 shrink-0 absolute right-0 top-1/2 -translate-y-1/2">
            <a href="${prefix}contact" class="hover:text-play-yellow transition flex items-center gap-1 text-[10px] sm:text-xs font-semibold">
              <i class="fa-solid fa-headset text-play-yellow text-[10px] sm:text-xs"></i>
              <span>Need Help? Contact Us</span>
            </a>
          </div>
        </div>
      </div>

      <!-- MAIN HEADER ROW -->
      <header id="site-header" class="bg-white border-b border-brand-border sticky top-0 z-40 transition-all duration-200 shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 py-2.5 sm:py-3">
          <div class="flex items-center justify-between gap-3 sm:gap-6 md:gap-8">
            
            <!-- Mobile Menu Toggle & Brand Logo -->
            <div class="flex items-center gap-3">
              <button id="mobile-menu-toggle" class="lg:hidden text-dark-navy hover:text-brand-orange p-1.5 rounded-xl focus:outline-none transition cursor-pointer" aria-label="Open Menu">
                <i class="fa-solid fa-bars text-xl"></i>
              </button>

              <a href="${prefix}index" class="flex items-center gap-2 shrink-0">
                <img src="${prefix}assets/logo.png" alt="Aparatus Pastime - Kids Toys & Sports" class="h-9 sm:h-11 md:h-12 w-auto object-contain">
              </a>
            </div>

            <!-- SEARCH BAR (CENTER) -->
            <div class="hidden md:flex flex-1 max-w-xl relative">
              <form action="${prefix}search" method="GET" class="w-full relative">
                <input 
                  type="text" 
                  name="q" 
                  id="global-search-input"
                  placeholder="Search toys, games, sports & more..." 
                  autocomplete="off"
                  class="w-full pl-11 pr-10 py-2.5 bg-soft-blue/60 hover:bg-soft-blue border border-brand-border rounded-full text-xs sm:text-sm text-dark-navy placeholder:text-brand-muted focus:outline-none focus:border-brand-blue focus:bg-white transition font-sans"
                >
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3 text-brand-blue text-sm"></i>
                <button type="button" id="search-clear-btn" class="hidden absolute right-3.5 top-2.5 text-brand-muted hover:text-dark-navy cursor-pointer">
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </form>

              <!-- LIVE SEARCH SUGGESTIONS DROPDOWN -->
              <div id="search-suggestions-dropdown" class="hidden absolute top-full left-0 right-0 mt-2 bg-white border border-brand-border rounded-2xl shadow-2xl z-50 p-4 overflow-hidden font-heading">
                <div class="mb-3">
                  <span class="text-[11px] font-bold uppercase tracking-wider text-brand-muted">POPULAR SEARCHES</span>
                  <div class="flex flex-wrap gap-1.5 mt-2 font-sans">
                    ${['Building Blocks', 'Board Games', 'Football', 'STEM Toys', 'Outdoor Games', 'Birthday Gifts'].map(term => `
                      <a href="${prefix}search?q=${encodeURIComponent(term)}" class="text-xs bg-soft-blue hover:bg-soft-orange text-dark-navy hover:text-brand-orange px-3 py-1 rounded-full transition font-semibold">
                        <i class="fa-solid fa-sparkles text-[10px] text-play-yellow mr-1"></i>${term}
                      </a>
                    `).join('')}
                  </div>
                </div>

                <div id="search-live-results" class="border-t border-brand-border pt-3 space-y-2">
                  <span class="text-[11px] font-bold uppercase tracking-wider text-brand-muted">MATCHING PRODUCTS</span>
                  <div id="search-live-products" class="space-y-1.5 max-h-48 overflow-y-auto"></div>
                </div>
              </div>
            </div>

            <!-- RIGHT ACTION ICONS (Wishlist, Cart, Account) -->
            <div class="flex items-center gap-1 sm:gap-2.5">
              
              <!-- Wishlist -->
              <a href="${prefix}account/wishlist" class="relative p-2 text-dark-navy hover:text-brand-orange rounded-xl transition" title="Wishlist">
                <i class="fa-regular fa-heart text-lg sm:text-xl"></i>
                <span id="header-wishlist-count" class="${wishlistCount > 0 ? '' : 'hidden'} absolute top-0.5 right-0.5 bg-brand-orange text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center font-heading">
                  ${wishlistCount}
                </span>
              </a>

              <!-- Cart Drawer Trigger -->
              <button id="header-cart-btn" class="relative p-2 text-dark-navy hover:text-brand-orange rounded-xl transition cursor-pointer" title="Cart">
                <i class="fa-solid fa-bag-shopping text-lg sm:text-xl"></i>
                <span id="header-cart-count" class="${cartCount > 0 ? '' : 'hidden'} absolute top-0.5 right-0.5 bg-brand-orange text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center font-heading">
                  ${cartCount}
                </span>
              </button>

              <!-- Account Dropdown -->
              <div class="relative group">
                <a href="${prefix}account/dashboard" class="flex items-center gap-1.5 p-2 text-dark-navy hover:text-brand-orange rounded-xl transition">
                  <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-soft-blue text-brand-blue flex items-center justify-center text-sm">
                    <i class="fa-solid fa-user"></i>
                  </div>
                  <span class="hidden xl:inline text-xs font-bold font-heading">${user.isLoggedIn ? user.firstName : 'Account'}</span>
                  <i class="fa-solid fa-chevron-down text-[10px] hidden xl:inline text-brand-muted"></i>
                </a>

                <!-- Account Hover Menu -->
                <div class="absolute right-0 top-full mt-1 w-52 bg-white border border-brand-border rounded-2xl shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 font-heading">
                  <div class="px-4 py-2 border-b border-brand-border">
                    <p class="text-xs text-brand-muted font-sans">Welcome to Playroom,</p>
                    <p class="text-sm font-bold text-dark-navy truncate">${user.isLoggedIn ? `${user.firstName} ${user.lastName}` : 'Guest Explorer'}</p>
                  </div>
                  <a href="${prefix}account/dashboard" class="block px-4 py-2 text-xs text-dark-navy hover:bg-soft-blue hover:text-brand-blue transition">
                    <i class="fa-solid fa-gauge mr-2 text-brand-blue"></i>My Playroom
                  </a>
                  <a href="${prefix}account/orders" class="block px-4 py-2 text-xs text-dark-navy hover:bg-soft-blue hover:text-brand-blue transition">
                    <i class="fa-solid fa-box mr-2 text-brand-blue"></i>My Orders
                  </a>
                  <a href="${prefix}account/wishlist" class="block px-4 py-2 text-xs text-dark-navy hover:bg-soft-blue hover:text-brand-blue transition">
                    <i class="fa-solid fa-heart mr-2 text-brand-orange"></i>My Wishlist
                  </a>
                  <a href="${prefix}account/addresses" class="block px-4 py-2 text-xs text-dark-navy hover:bg-soft-blue hover:text-brand-blue transition">
                    <i class="fa-solid fa-location-dot mr-2 text-brand-blue"></i>Addresses
                  </a>
                  <div class="border-t border-brand-border mt-1 pt-1">
                    ${user.isLoggedIn ? `
                      <a href="${prefix}login" id="header-logout-btn" class="block px-4 py-2 text-xs text-red-500 hover:bg-red-50 transition">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>Sign Out
                      </a>
                    ` : `
                      <a href="${prefix}login" class="block px-4 py-2 text-xs text-brand-blue font-bold hover:bg-soft-blue transition">
                        <i class="fa-solid fa-lock mr-2"></i>Sign In / Join Club
                      </a>
                    `}
                  </div>
                </div>
              </div>

            </div>

          </div>

          <!-- MOBILE SEARCH BAR (BELOW MAIN ROW) -->
          <div class="mt-2 md:hidden">
            <form action="${prefix}search" method="GET" class="relative">
              <input 
                type="text" 
                name="q" 
                placeholder="Search toys, games, sports & more..." 
                class="w-full pl-9 pr-8 py-2 bg-soft-blue/60 border border-brand-border rounded-full text-xs text-dark-navy placeholder:text-brand-muted focus:outline-none focus:border-brand-blue focus:bg-white font-sans"
              >
              <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-2.5 text-brand-blue text-xs"></i>
            </form>
          </div>
        </div>

        <!-- SECOND NAVIGATION ROW (DESKTOP) -->
        <nav class="hidden lg:block border-t border-brand-border/80 bg-white/95 backdrop-blur-md text-xs xl:text-sm font-bold font-heading relative shadow-2xs">
          <div class="max-w-[1440px] mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 flex items-center justify-center min-h-[46px] xl:min-h-[50px] relative">
            <div class="flex items-center justify-center gap-1 lg:gap-1.5 xl:gap-2.5 py-1 mx-auto">
              
              <a href="${prefix}index" class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 ${activeNav === 'home' ? 'text-brand-orange bg-orange-50 border border-orange-200/80 shadow-2xs font-extrabold' : 'text-dark-navy hover:text-brand-orange hover:bg-orange-50/70 hover:shadow-2xs'}">
                <i class="fa-solid fa-house-chimney text-[11px] xl:text-xs ${activeNav === 'home' ? 'text-brand-orange' : 'text-slate-400'}"></i>
                <span>Home</span>
              </a>

              <a href="${prefix}shop" class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 ${activeNav === 'shop' ? 'text-brand-orange bg-orange-50 border border-orange-200/80 shadow-2xs font-extrabold' : 'text-dark-navy hover:text-brand-orange hover:bg-orange-50/70 hover:shadow-2xs'}">
                <i class="fa-solid fa-bag-shopping text-[11px] xl:text-xs ${activeNav === 'shop' ? 'text-brand-orange' : 'text-slate-400'}"></i>
                <span>Shop</span>
              </a>

              <a href="${prefix}categories" class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 ${activeNav === 'categories' ? 'text-brand-orange bg-orange-50 border border-orange-200/80 shadow-2xs font-extrabold' : 'text-dark-navy hover:text-brand-orange hover:bg-orange-50/70 hover:shadow-2xs'}">
                <i class="fa-solid fa-shapes text-[11px] xl:text-xs ${activeNav === 'categories' ? 'text-brand-orange' : 'text-slate-400'}"></i>
                <span>Categories</span>
              </a>

              <!-- MEGA MENU TRIGGER -->
              <div class="group py-1">
                <button class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 text-dark-navy group-hover:text-brand-orange group-hover:bg-orange-50/80 group-hover:border-orange-200/80 border border-transparent rounded-xl transition-all duration-200 flex items-center gap-1.5 focus:outline-none cursor-pointer">
                  <i class="fa-solid fa-compass text-[11px] xl:text-xs text-brand-orange"></i>
                  <span class="font-bold">Shop By</span>
                  <span class="bg-gradient-to-r from-brand-orange to-amber-500 text-white text-[8px] xl:text-[9px] font-extrabold px-1.5 py-0.5 rounded-full uppercase tracking-wider shadow-2xs">MEGA</span>
                  <i class="fa-solid fa-chevron-down text-[9px] text-brand-muted group-hover:text-brand-orange group-hover:rotate-180 transition-transform duration-200"></i>
                </button>

                <!-- CREATIVE MEGA MENU DROPDOWN (100% SOLID CRISP WHITE CANVAS WITH 5 DISTINCT THEMED SOLID PASTEL CARDS) -->
                <div class="mega-menu-container absolute left-0 right-0 top-full w-full bg-white border-b-2 border-brand-orange/40 shadow-2xl z-50 text-dark-navy max-h-[calc(100vh-115px)] overflow-y-auto">
                  
                  <!-- Top Rainbow Playful Accent Bar -->
                  <div class="h-1.5 w-full bg-gradient-to-r from-brand-orange via-amber-400 via-emerald-400 via-brand-blue to-purple-500"></div>

                  <div class="max-w-[1440px] mx-auto px-3 sm:px-4 lg:px-5 xl:px-8 py-3.5 xl:py-5 space-y-3.5 xl:space-y-4 relative z-10">
                    
                    <!-- 5-COLUMN DIRECTORY GRID WITH SOLID THEMED PASTEL CARDS -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-2.5 xl:gap-4 items-stretch">
                      
                      <!-- Col 1: SHOP BY CATEGORY (Warm Coral Card) -->
                      <div class="bg-[#FFF9F5] border border-orange-200/90 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-orange-300 transition-all duration-200">
                        <div class="space-y-2">
                          <div class="flex items-center gap-2 pb-2 border-b border-orange-200/70">
                            <div class="w-6 h-6 xl:w-7 xl:h-7 rounded-lg xl:rounded-xl bg-brand-orange text-white flex items-center justify-center text-[10px] xl:text-xs shadow-2xs shrink-0">
                              <i class="fa-solid fa-shapes"></i>
                            </div>
                            <div class="min-w-0">
                              <h4 class="text-[11px] xl:text-xs font-bold uppercase tracking-wider text-dark-navy font-heading truncate">
                                CATEGORIES
                              </h4>
                              <span class="text-[9px] xl:text-[10px] text-brand-muted font-normal font-sans block truncate">Browse by toy type</span>
                            </div>
                          </div>
                          <ul class="space-y-0.5 xl:space-y-1 text-xs font-semibold font-sans">
                            <li>
                              <a href="${prefix}shop?category=toys" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-orange-100 text-brand-orange flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-cubes"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-brand-orange leading-tight text-[11px] xl:text-xs truncate">Kids Toys & Building</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Blocks, Figures & Sets</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-brand-orange group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=games" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-dice-d20"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-purple-600 leading-tight text-[11px] xl:text-xs truncate">Board Games & Puzzles</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Family, Tactics & Logic</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-purple-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=sports" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-blue-100 text-brand-blue flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-futbol"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-brand-blue leading-tight text-[11px] xl:text-xs truncate">Sports Goods & Fitness</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Cricket, Skates & Balls</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-brand-blue group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=outdoor" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-compass"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-teal-600 leading-tight text-[11px] xl:text-xs truncate">Outdoor & Ride-Ons</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Scooters, Tents & Fun</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-teal-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=educational" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-atom"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-emerald-600 leading-tight text-[11px] xl:text-xs truncate">STEM & Robotics</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Science & Solar Kits</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-emerald-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=activity" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-palette"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-amber-600 leading-tight text-[11px] xl:text-xs truncate">Creative Arts & Crafts</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Clay, DIY & Painting</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-amber-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=gifts" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-gift"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-rose-600 leading-tight text-[11px] xl:text-xs truncate">Curated Gift Hampers</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Birthday & Return Gifts</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-rose-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                          </ul>
                        </div>
                        <div class="pt-2 border-t border-orange-200 mt-1.5 xl:mt-2">
                          <a href="${prefix}categories" class="inline-flex items-center gap-1.5 text-brand-orange hover:text-dark-navy font-bold font-heading text-[10px] xl:text-xs transition">
                            <span>View All Categories</span>
                            <i class="fa-solid fa-arrow-right text-[8px] xl:text-[10px]"></i>
                          </a>
                        </div>
                      </div>

                      <!-- Col 2: SHOP BY AGE (Sky Blue Card) -->
                      <div class="bg-[#F0F7FF] border border-blue-200/90 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-blue-300 transition-all duration-200">
                        <div class="space-y-2">
                          <div class="flex items-center gap-2 pb-2 border-b border-blue-200/70">
                            <div class="w-6 h-6 xl:w-7 xl:h-7 rounded-lg xl:rounded-xl bg-brand-blue text-white flex items-center justify-center text-[10px] xl:text-xs shadow-2xs shrink-0">
                              <i class="fa-solid fa-child-reaching"></i>
                            </div>
                            <div class="min-w-0">
                              <h4 class="text-[11px] xl:text-xs font-bold uppercase tracking-wider text-dark-navy font-heading truncate">
                                BY AGE GROUP
                              </h4>
                              <span class="text-[9px] xl:text-[10px] text-brand-muted font-normal font-sans block truncate">Age-matched discovery</span>
                            </div>
                          </div>
                          <ul class="space-y-0.5 xl:space-y-1.5 text-xs font-semibold font-sans">
                            <li>
                              <a href="${prefix}shop?age=0-2" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-orange-500 text-white font-heading font-bold text-[9px] xl:text-[10px] flex items-center justify-center shadow-2xs group-hover/link:scale-105 transition shrink-0">
                                    0–2
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-brand-orange leading-tight flex items-center gap-1 text-[11px] xl:text-xs truncate">
                                      <i class="fa-solid fa-baby text-brand-orange text-[8px] xl:text-[9px]"></i>
                                      <span class="truncate">Infants & Toddlers</span>
                                    </div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Sensory & Soft Toys</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-brand-orange group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?age=3-5" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-amber-500 text-white font-heading font-bold text-[9px] xl:text-[10px] flex items-center justify-center shadow-2xs group-hover/link:scale-105 transition shrink-0">
                                    3–5
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-amber-600 leading-tight flex items-center gap-1 text-[11px] xl:text-xs truncate">
                                      <i class="fa-solid fa-puzzle-piece text-amber-500 text-[8px] xl:text-[9px]"></i>
                                      <span class="truncate">Curious Explorers</span>
                                    </div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Puzzles, Clay & Learning</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-amber-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?age=6-8" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-brand-blue text-white font-heading font-bold text-[9px] xl:text-[10px] flex items-center justify-center shadow-2xs group-hover/link:scale-105 transition shrink-0">
                                    6–8
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-brand-blue leading-tight flex items-center gap-1 text-[11px] xl:text-xs truncate">
                                      <i class="fa-solid fa-rocket text-brand-blue text-[8px] xl:text-[9px]"></i>
                                      <span class="truncate">Active Adventurers</span>
                                    </div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">STEM Kits & Sports</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-brand-blue group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?age=9-12" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-emerald-600 text-white font-heading font-bold text-[9px] xl:text-[10px] flex items-center justify-center shadow-2xs group-hover/link:scale-105 transition shrink-0">
                                    9–12
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-emerald-600 leading-tight flex items-center gap-1 text-[11px] xl:text-xs truncate">
                                      <i class="fa-solid fa-microscope text-emerald-600 text-[8px] xl:text-[9px]"></i>
                                      <span class="truncate">Creative Thinkers</span>
                                    </div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Robotics & Strategy</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-emerald-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?age=12+" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-purple-600 text-white font-heading font-bold text-[9px] xl:text-[10px] flex items-center justify-center shadow-2xs group-hover/link:scale-105 transition shrink-0">
                                    12+
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-purple-600 leading-tight flex items-center gap-1 text-[11px] xl:text-xs truncate">
                                      <i class="fa-solid fa-crown text-purple-600 text-[8px] xl:text-[9px]"></i>
                                      <span class="truncate">Big Kids & Teens</span>
                                    </div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Complex Kits & Games</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-purple-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                          </ul>
                        </div>
                        <div class="pt-2 border-t border-blue-200 mt-1.5 xl:mt-2">
                          <a href="${prefix}shop" class="inline-flex items-center gap-1.5 text-brand-blue hover:text-dark-navy font-bold font-heading text-[10px] xl:text-xs transition">
                            <span>Find by Milestone Guide</span>
                            <i class="fa-solid fa-arrow-right text-[8px] xl:text-[10px]"></i>
                          </a>
                        </div>
                      </div>

                      <!-- Col 3: SHOP BY INTEREST (Sunny Amber Card) -->
                      <div class="bg-[#FFFDF0] border border-amber-200/90 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-amber-300 transition-all duration-200">
                        <div class="space-y-2">
                          <div class="flex items-center gap-2 pb-2 border-b border-amber-200/70">
                            <div class="w-6 h-6 xl:w-7 xl:h-7 rounded-lg xl:rounded-xl bg-amber-500 text-white flex items-center justify-center text-[10px] xl:text-xs shadow-2xs shrink-0">
                              <i class="fa-solid fa-wand-magic-sparkles"></i>
                            </div>
                            <div class="min-w-0">
                              <h4 class="text-[11px] xl:text-xs font-bold uppercase tracking-wider text-dark-navy font-heading truncate">
                                PLAY STYLE
                              </h4>
                              <span class="text-[9px] xl:text-[10px] text-brand-muted font-normal font-sans block truncate">Passion & interests</span>
                            </div>
                          </div>
                          <ul class="space-y-0.5 xl:space-y-1 text-xs font-semibold font-sans">
                            <li>
                              <a href="${prefix}shop?category=toys" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-orange-100 text-brand-orange flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-cubes"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-brand-orange leading-tight text-[11px] xl:text-xs truncate">Build & Architecture</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Engineering & 3D Sets</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-brand-orange group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=sports" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-blue-100 text-brand-blue flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-person-running"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-brand-blue leading-tight text-[11px] xl:text-xs truncate">Move & Athletics</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Sports, Skates & Action</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-brand-blue group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=games" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-brain"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-purple-600 leading-tight text-[11px] xl:text-xs truncate">Think & Strategy</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Chess, Logic & Mystery</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-purple-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=activity" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-palette"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-amber-600 leading-tight text-[11px] xl:text-xs truncate">Make & Imagine</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Arts, Crafts & Pretend</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-amber-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=educational" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-flask"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-emerald-600 leading-tight text-[11px] xl:text-xs truncate">Discover Science</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Physics, Biology & Space</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-emerald-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=outdoor" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-trophy"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-teal-600 leading-tight text-[11px] xl:text-xs truncate">Lawn Tournaments</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Family Party & Fun</div>
                                  </div>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-teal-600 group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                              </a>
                            </li>
                          </ul>
                        </div>
                        <div class="pt-2 border-t border-amber-200 mt-1.5 xl:mt-2">
                          <a href="${prefix}shop" class="inline-flex items-center gap-1.5 text-amber-600 hover:text-dark-navy font-bold font-heading text-[10px] xl:text-xs transition">
                            <span>Explore All Themes</span>
                            <i class="fa-solid fa-arrow-right text-[8px] xl:text-[10px]"></i>
                          </a>
                        </div>
                      </div>

                      <!-- Col 4: CURATIONS & DEALS (Soft Rose Card) -->
                      <div class="bg-[#FFF5F7] border border-rose-200/90 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-rose-300 transition-all duration-200">
                        <div class="space-y-2">
                          <div class="flex items-center gap-2 pb-2 border-b border-rose-200/70">
                            <div class="w-6 h-6 xl:w-7 xl:h-7 rounded-lg xl:rounded-xl bg-rose-500 text-white flex items-center justify-center text-[10px] xl:text-xs shadow-2xs shrink-0">
                              <i class="fa-solid fa-tags"></i>
                            </div>
                            <div class="min-w-0">
                              <h4 class="text-[11px] xl:text-xs font-bold uppercase tracking-wider text-dark-navy font-heading truncate">
                                CURATED & DEALS
                              </h4>
                              <span class="text-[9px] xl:text-[10px] text-brand-muted font-normal font-sans block truncate">Handpicked collections</span>
                            </div>
                          </div>
                          <ul class="space-y-0.5 xl:space-y-1 text-xs font-semibold font-sans">
                            <li>
                              <a href="${prefix}new-arrivals" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-orange-100 text-brand-orange flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-sparkles"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-brand-orange leading-tight text-[11px] xl:text-xs truncate">Fresh New Arrivals</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">This week's latest drops</div>
                                  </div>
                                </div>
                                <span class="text-[8px] xl:text-[9px] font-bold text-white bg-brand-orange px-1.5 py-0.5 rounded-full font-heading uppercase shrink-0 ml-1">NEW</span>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?filter=bestseller" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-red-100 text-red-500 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-fire"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-red-500 leading-tight text-[11px] xl:text-xs truncate">Top 20 Best Sellers</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Most loved by parents</div>
                                  </div>
                                </div>
                                <span class="text-[8px] xl:text-[9px] font-bold text-white bg-red-500 px-1.5 py-0.5 rounded-full font-heading uppercase shrink-0 ml-1">HOT</span>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?maxPrice=499" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-coins"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-emerald-600 leading-tight text-[11px] xl:text-xs truncate">Pocket Toys < ₹499</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Budget-friendly fun</div>
                                  </div>
                                </div>
                                <span class="text-[8px] xl:text-[9px] font-bold text-white bg-emerald-600 px-1.5 py-0.5 rounded-full font-heading uppercase shrink-0 ml-1">SAVER</span>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?maxPrice=999" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-blue-100 text-brand-blue flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-tags"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-brand-blue leading-tight text-[11px] xl:text-xs truncate">Value Picks < ₹999</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Top-rated smart buys</div>
                                  </div>
                                </div>
                                <span class="text-[8px] xl:text-[9px] font-bold text-white bg-brand-blue px-1.5 py-0.5 rounded-full font-heading uppercase shrink-0 ml-1">VALUE</span>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?category=gifts" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-gift"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-rose-600 leading-tight text-[11px] xl:text-xs truncate">Birthday Gift Finder</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Ready-to-gift combos</div>
                                  </div>
                                </div>
                                <span class="text-[8px] xl:text-[9px] font-bold text-white bg-rose-500 px-1.5 py-0.5 rounded-full font-heading uppercase shrink-0 ml-1">GIFT</span>
                              </a>
                            </li>
                            <li>
                              <a href="${prefix}shop?filter=trending" class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                                <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                  <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                    <i class="fa-solid fa-chart-line"></i>
                                  </div>
                                  <div class="min-w-0">
                                    <div class="font-heading font-bold text-dark-navy group-hover/link:text-purple-600 leading-tight text-[11px] xl:text-xs truncate">Trending This Week</div>
                                    <div class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">Fast selling right now</div>
                                  </div>
                                </div>
                                <span class="text-[8px] xl:text-[9px] font-bold text-white bg-purple-600 px-1.5 py-0.5 rounded-full font-heading uppercase shrink-0 ml-1">TREND</span>
                              </a>
                            </li>
                          </ul>
                        </div>
                        <div class="pt-2 border-t border-rose-200 mt-1.5 xl:mt-2">
                          <a href="${prefix}shop" class="inline-flex items-center gap-1.5 text-rose-600 hover:text-dark-navy font-bold font-heading text-[10px] xl:text-xs transition">
                            <span>Browse All Curations</span>
                            <i class="fa-solid fa-arrow-right text-[8px] xl:text-[10px]"></i>
                          </a>
                        </div>
                      </div>

                      <!-- Col 5: FEATURED SPOTLIGHT CARD & PROMO (Golden Amber Showcase Card) -->
                      <div class="flex flex-col justify-between space-y-2 xl:space-y-3">
                        <div class="bg-[#FFFDF4] border-2 border-amber-300 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-3.5 flex flex-col justify-between shadow-2xs hover:shadow-md transition-all duration-200 relative overflow-hidden group/spotlight">
                          <div>
                            <div class="flex items-center justify-between mb-1 xl:mb-2">
                              <span class="bg-brand-orange text-white text-[9px] xl:text-[10px] font-bold px-2 py-0.5 rounded-full font-heading uppercase tracking-wide shadow-2xs">
                                <i class="fa-solid fa-crown mr-1 text-play-yellow"></i>TOP SELLER
                              </span>
                              <div class="flex items-center gap-1 text-[10px] xl:text-[11px] font-bold text-dark-navy font-heading">
                                <i class="fa-solid fa-star text-amber-500 text-[10px] xl:text-xs"></i>
                                <span>4.9</span>
                                <span class="text-[8px] xl:text-[9px] text-brand-muted font-normal">(428)</span>
                              </div>
                            </div>
                            <h5 class="font-heading font-bold text-dark-navy text-[11px] xl:text-xs leading-snug truncate">Magnetic 3D Master Tiles</h5>
                            <p class="text-[9px] xl:text-[10px] text-brand-muted mt-0.5 font-sans leading-relaxed truncate">100-piece translucent building set</p>
                          </div>

                          <div class="my-1.5 xl:my-2 flex items-center justify-center p-1.5 xl:p-2 bg-white rounded-lg xl:rounded-xl shadow-xs border border-amber-200/80">
                            <img src="${products[4]?.images[0] || 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=800&q=80'}" alt="Magnetic 3D Master Tiles" class="h-14 xl:h-20 w-auto object-contain drop-shadow-md group-hover/spotlight:scale-105 transition duration-300">
                          </div>

                          <div>
                            <div class="flex items-baseline gap-1.5 mb-1.5 font-heading">
                              <span class="text-xs xl:text-sm font-bold text-dark-navy">₹2,199</span>
                              <span class="text-[10px] xl:text-xs text-brand-muted line-through font-normal">₹2,899</span>
                              <span class="text-[8px] xl:text-[9px] font-bold text-white bg-brand-orange px-1.5 py-0.2 rounded-full">24% OFF</span>
                            </div>
                            <a href="${prefix}product?slug=magnetic-learning-set" class="w-full btn-play-orange text-[10px] xl:text-xs py-1.5 xl:py-2 px-2 rounded-lg xl:rounded-xl text-center block transition font-heading font-bold text-white shadow-md hover:shadow-lg truncate">
                              PLAY SOMETHING NEW →
                            </a>
                          </div>
                        </div>

                        <!-- Mini Coupon Banner -->
                        <div class="bg-[#F0F7FF] border border-blue-200 rounded-lg xl:rounded-xl p-2 xl:p-2.5 flex items-center justify-between text-[10px] xl:text-xs font-heading shadow-2xs">
                          <div class="flex items-center gap-1.5 min-w-0">
                            <div class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-blue-100 text-brand-blue flex items-center justify-center text-[10px] shrink-0">
                              <i class="fa-solid fa-gift"></i>
                            </div>
                            <div class="min-w-0">
                              <div class="text-[8px] xl:text-[9px] text-brand-muted leading-tight truncate">First Order Discount</div>
                              <div class="font-bold text-dark-navy truncate">10% OFF: <span class="text-brand-orange font-mono font-bold">PLAY10</span></div>
                            </div>
                          </div>
                          <span class="text-[8px] xl:text-[9px] bg-brand-orange text-white px-1.5 py-0.5 rounded-full font-bold shadow-2xs shrink-0 ml-1">ACTIVE</span>
                        </div>
                      </div>

                    </div>

                    <!-- BOTTOM MINI PERKS STRIP INSIDE MEGA MENU -->
                    <div class="bg-[#F8FAFC] -mx-3 -mb-3.5 sm:-mx-4 sm:-mb-3.5 lg:-mx-5 lg:-mb-3.5 xl:-mx-8 xl:-mb-5 px-3 sm:px-4 lg:px-5 xl:px-8 py-2.5 xl:py-3 border-t border-slate-200 flex flex-wrap items-center justify-between gap-2.5 xl:gap-4 text-[10px] xl:text-xs font-heading text-dark-navy">
                      <div class="flex items-center gap-3 xl:gap-6 flex-wrap">
                        <span class="flex items-center gap-1.5 text-dark-navy font-bold">
                          <i class="fa-solid fa-shield-heart text-emerald-500 text-xs xl:text-sm"></i>
                          <span>100% Non-Toxic</span>
                        </span>
                        <span class="flex items-center gap-1.5 text-dark-navy font-bold">
                          <i class="fa-solid fa-truck-fast text-brand-blue text-xs xl:text-sm"></i>
                          <span>Free Shipping > ₹999</span>
                        </span>
                        <span class="flex items-center gap-1.5 text-dark-navy font-bold">
                          <i class="fa-solid fa-rotate-left text-amber-500 text-xs xl:text-sm"></i>
                          <span>7-Day Replacement</span>
                        </span>
                        <span class="flex items-center gap-1.5 text-dark-navy font-bold">
                          <i class="fa-solid fa-gift text-purple-500 text-xs xl:text-sm"></i>
                          <span>Free Gift Wrap</span>
                        </span>
                      </div>
                      <a href="${prefix}shop" class="text-brand-orange hover:text-dark-navy font-bold flex items-center gap-1 transition shrink-0 ml-auto">
                        <span>Browse Entire Catalog (500+ Toys)</span>
                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                      </a>
                    </div>

                  </div>
                </div>
              </div>

              <a href="${prefix}new-arrivals" class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 ${activeNav === 'new-arrivals' ? 'text-brand-orange bg-orange-50 border border-orange-200/80 shadow-2xs font-extrabold' : 'text-dark-navy hover:text-brand-orange hover:bg-orange-50/70 hover:shadow-2xs'}">
                <i class="fa-solid fa-wand-magic-sparkles text-[11px] xl:text-xs text-emerald-500"></i>
                <span>New Arrivals</span>
                <span class="bg-emerald-100 text-emerald-700 text-[8px] xl:text-[9px] font-extrabold px-1.5 py-0.5 rounded-full hidden xl:inline-block leading-none">NEW</span>
              </a>

              <a href="${prefix}shop?filter=bestseller" class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 ${activeNav === 'bestsellers' ? 'text-brand-orange bg-orange-50 border border-orange-200/80 shadow-2xs font-extrabold' : 'text-dark-navy hover:text-brand-orange hover:bg-orange-50/70 hover:shadow-2xs'}">
                <i class="fa-solid fa-fire text-[11px] xl:text-xs text-amber-500"></i>
                <span>Best Sellers</span>
                <span class="bg-amber-100 text-amber-800 text-[8px] xl:text-[9px] font-extrabold px-1.5 py-0.5 rounded-full hidden xl:inline-block leading-none">HOT</span>
              </a>

              <a href="${prefix}shop" class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 ${activeNav === 'age' ? 'text-brand-orange bg-orange-50 border border-orange-200/80 shadow-2xs font-extrabold' : 'text-dark-navy hover:text-brand-orange hover:bg-orange-50/70 hover:shadow-2xs'}">
                <i class="fa-solid fa-child-reaching text-[11px] xl:text-xs text-purple-500"></i>
                <span>Shop By Age</span>
              </a>

              <a href="${prefix}contact" class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5 ${activeNav === 'contact' ? 'text-brand-orange bg-orange-50 border border-orange-200/80 shadow-2xs font-extrabold' : 'text-dark-navy hover:text-brand-orange hover:bg-orange-50/70 hover:shadow-2xs'}">
                <i class="fa-solid fa-headset text-[11px] xl:text-xs text-brand-blue"></i>
                <span>Contact</span>
              </a>

            </div>

            <!-- Certified Safe Pill Badge (Floating on ultra-wide screens without offsetting the center) -->
            <div class="hidden 2xl:flex absolute right-6 text-xs font-bold text-brand-blue items-center gap-1.5 font-heading bg-soft-blue/80 border border-blue-100 px-3 py-1 rounded-full shrink-0 shadow-2xs pointer-events-none">
              <i class="fa-solid fa-shield-halved text-emerald-500"></i>
              <span>100% Non-Toxic & Child-Safe</span>
            </div>

          </div>
        </nav>
      </header>

      <!-- MOBILE & TABLET SIDEBAR NAVIGATION & MEGA MENU DRAWER -->
      <div id="mobile-nav-drawer" class="lg:hidden">
        <div id="mobile-nav-backdrop" class="drawer-backdrop fixed inset-0 z-50 bg-black/60 backdrop-blur-xs transition-opacity duration-300"></div>
        <div class="mobile-nav-drawer-panel fixed top-0 left-0 bottom-0 w-[88vw] sm:w-[420px] max-w-[480px] bg-white z-50 shadow-2xl flex flex-col justify-between overflow-hidden">
          
          <!-- Top Rainbow Playful Accent Bar -->
          <div class="h-1.5 w-full bg-gradient-to-r from-brand-orange via-amber-400 via-emerald-400 via-brand-blue to-purple-500 shrink-0"></div>

          <!-- Drawer Top Brand Bar -->
          <div class="p-3.5 sm:p-4 bg-gradient-to-b from-[#FFF9F5] to-white border-b border-brand-border/80 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
              <a href="${prefix}index" class="flex items-center gap-2">
                <img src="${prefix}assets/logo.png" alt="Aparatus" class="h-8 sm:h-9 w-auto object-contain">
              </a>
              <span class="text-[9px] uppercase tracking-wider font-extrabold px-2 py-0.5 rounded-full bg-soft-orange text-brand-orange border border-orange-200 shadow-2xs font-heading">
                PLAY CLUB
              </span>
            </div>
            <button id="close-mobile-nav" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-orange-50 text-dark-navy hover:text-brand-orange flex items-center justify-center transition shadow-2xs cursor-pointer" aria-label="Close Menu">
              <i class="fa-solid fa-xmark text-base"></i>
            </button>
          </div>

          <!-- User Greeting Chip / Explorer Pass -->
          <div class="px-3.5 sm:px-4 py-2 bg-gradient-to-r from-blue-50/90 via-sky-50/50 to-indigo-50/90 border-b border-blue-100/80 flex items-center justify-between gap-2 shrink-0">
            <div class="flex items-center gap-2.5 min-w-0">
              <div class="w-7 h-7 rounded-full bg-brand-blue text-white flex items-center justify-center text-xs font-bold shrink-0 shadow-2xs font-heading">
                ${user.isLoggedIn ? (user.firstName ? user.firstName[0].toUpperCase() : 'U') : '<i class="fa-solid fa-user"></i>'}
              </div>
              <div class="min-w-0">
                <p class="text-[11px] font-bold font-heading text-dark-navy truncate">
                  ${user.isLoggedIn ? `Hi, ${user.firstName} ${user.lastName}` : 'Welcome, Play Explorer! 🎈'}
                </p>
                <p class="text-[9px] text-brand-blue font-sans font-semibold truncate">
                  ${user.isLoggedIn ? 'VIP Playroom Member' : 'Use code PLAY15 for 15% OFF'}
                </p>
              </div>
            </div>
            <a href="${user.isLoggedIn ? `${prefix}account/dashboard` : `${prefix}login`}" class="text-[10px] font-bold font-heading text-brand-blue hover:text-white hover:bg-brand-blue bg-white px-2.5 py-1 rounded-lg border border-blue-200/80 shrink-0 shadow-2xs transition">
              ${user.isLoggedIn ? 'Dashboard' : 'Sign In'}
            </a>
          </div>

          <!-- Drawer Search Bar Quick Access -->
          <div class="px-3.5 sm:px-4 pt-3 shrink-0">
            <form action="${prefix}search" method="GET" class="relative">
              <input 
                type="text" 
                name="q" 
                placeholder="Search 500+ toys, games, sports..." 
                class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-dark-navy placeholder:text-brand-muted focus:outline-none focus:border-brand-blue focus:bg-white font-sans"
              >
              <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-brand-blue text-xs"></i>
            </form>
          </div>

          <!-- Drawer Scrollable Content -->
          <div class="p-3.5 sm:p-4 space-y-3 overflow-y-auto flex-1 custom-scrollbar">
            
            <!-- Quick Core Navigation Grid -->
            <div class="grid grid-cols-2 gap-2">
              <a href="${prefix}index" class="flex items-center gap-2 p-2 rounded-xl bg-orange-50/80 border border-orange-200/80 hover:bg-orange-100/80 text-dark-navy hover:text-brand-orange transition shadow-2xs group">
                <div class="w-7 h-7 rounded-lg bg-brand-orange text-white flex items-center justify-center text-xs shadow-2xs shrink-0 group-hover:scale-105 transition">
                  <i class="fa-solid fa-house-chimney"></i>
                </div>
                <div class="min-w-0">
                  <div class="font-heading font-bold text-xs leading-tight">Home</div>
                  <div class="text-[9px] text-brand-muted font-sans truncate">Playroom Hub</div>
                </div>
              </a>
              <a href="${prefix}shop" class="flex items-center gap-2 p-2 rounded-xl bg-blue-50/80 border border-blue-200/80 hover:bg-blue-100/80 text-dark-navy hover:text-brand-blue transition shadow-2xs group">
                <div class="w-7 h-7 rounded-lg bg-brand-blue text-white flex items-center justify-center text-xs shadow-2xs shrink-0 group-hover:scale-105 transition">
                  <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <div class="min-w-0">
                  <div class="font-heading font-bold text-xs leading-tight">Catalog</div>
                  <div class="text-[9px] text-brand-muted font-sans truncate">All Products</div>
                </div>
              </a>
              <a href="${prefix}new-arrivals" class="flex items-center gap-2 p-2 rounded-xl bg-emerald-50/80 border border-emerald-200/80 hover:bg-emerald-100/80 text-dark-navy hover:text-emerald-700 transition shadow-2xs group">
                <div class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs shadow-2xs shrink-0 group-hover:scale-105 transition">
                  <i class="fa-solid fa-wand-magic-sparkles"></i>
                </div>
                <div class="min-w-0">
                  <div class="font-heading font-bold text-xs leading-tight flex items-center gap-1">
                    <span>New</span>
                    <span class="bg-emerald-200 text-emerald-800 text-[8px] px-1 rounded font-extrabold">NEW</span>
                  </div>
                  <div class="text-[9px] text-brand-muted font-sans truncate">Fresh Drops</div>
                </div>
              </a>
              <a href="${prefix}shop?filter=bestseller" class="flex items-center gap-2 p-2 rounded-xl bg-amber-50/80 border border-amber-200/80 hover:bg-amber-100/80 text-dark-navy hover:text-amber-700 transition shadow-2xs group">
                <div class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs shadow-2xs shrink-0 group-hover:scale-105 transition">
                  <i class="fa-solid fa-fire"></i>
                </div>
                <div class="min-w-0">
                  <div class="font-heading font-bold text-xs leading-tight flex items-center gap-1">
                    <span>Popular</span>
                    <span class="bg-amber-200 text-amber-900 text-[8px] px-1 rounded font-extrabold">HOT</span>
                  </div>
                  <div class="text-[9px] text-brand-muted font-sans truncate">Best Sellers</div>
                </div>
              </a>
            </div>

            <!-- MEGA MENU TITLE -->
            <div class="flex items-center justify-between pt-2 pb-0.5 px-0.5">
              <span class="text-[11px] font-extrabold uppercase tracking-wider text-dark-navy font-heading flex items-center gap-1.5">
                <i class="fa-solid fa-compass text-brand-orange"></i>
                <span>SHOP BY MEGA MENU</span>
              </span>
              <span class="text-[9px] font-extrabold text-brand-orange bg-orange-100 px-2 py-0.5 rounded-full uppercase tracking-wide">
                DRAWER EXPLORER
              </span>
            </div>

            <!-- 1. CATEGORIES ACCORDION CARD (Warm Coral) -->
            <div class="mobile-drawer-accordion-card bg-[#FFF9F5] border border-orange-200/90 rounded-2xl p-3 shadow-2xs">
              <button type="button" class="mobile-drawer-accordion-toggle w-full flex items-center justify-between text-left focus:outline-none cursor-pointer">
                <div class="flex items-center gap-2.5 min-w-0">
                  <div class="w-7 h-7 rounded-xl bg-brand-orange text-white flex items-center justify-center text-xs shadow-2xs shrink-0">
                    <i class="fa-solid fa-shapes"></i>
                  </div>
                  <div class="min-w-0">
                    <div class="font-heading font-bold text-xs text-dark-navy truncate">Popular Categories</div>
                    <div class="text-[9px] text-brand-muted font-sans truncate">Toys, Games, Sports & More</div>
                  </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0 ml-2">
                  <span class="bg-orange-100 text-brand-orange text-[9px] font-extrabold px-1.5 py-0.5 rounded-md font-heading">6</span>
                  <i class="mobile-drawer-accordion-chevron fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
                </div>
              </button>
              
              <div class="mobile-drawer-accordion-content space-y-1 pt-2.5 mt-2 border-t border-orange-200/70 text-xs font-semibold font-sans">
                ${categories.map(c => `
                  <a href="${prefix}shop?category=${c.slug}" class="p-1.5 rounded-xl hover:bg-white transition flex items-center justify-between text-dark-navy hover:text-brand-orange group/item">
                    <div class="flex items-center gap-2 min-w-0">
                      <div class="w-6 h-6 rounded-lg bg-orange-100 text-brand-orange flex items-center justify-center text-[10px] group-hover/item:scale-110 transition shrink-0">
                        <i class="fa-solid ${c.icon}"></i>
                      </div>
                      <div class="min-w-0">
                        <span class="font-heading font-bold text-dark-navy group-hover/item:text-brand-orange text-xs block truncate">${c.name}</span>
                      </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[8px] text-slate-400 group-hover/item:text-brand-orange group-hover/item:translate-x-0.5 transition shrink-0"></i>
                  </a>
                `).join('')}
                <div class="pt-1.5 border-t border-orange-100">
                  <a href="${prefix}categories" class="flex items-center justify-center gap-1.5 text-[11px] font-bold font-heading text-brand-orange hover:text-dark-navy py-1 transition">
                    <span>View All Categories</span>
                    <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>
            </div>

            <!-- 2. AGE GROUPS ACCORDION CARD (Cool Sky) -->
            <div class="mobile-drawer-accordion-card bg-[#F6FAFD] border border-blue-200/90 rounded-2xl p-3 shadow-2xs">
              <button type="button" class="mobile-drawer-accordion-toggle w-full flex items-center justify-between text-left focus:outline-none cursor-pointer">
                <div class="flex items-center gap-2.5 min-w-0">
                  <div class="w-7 h-7 rounded-xl bg-brand-blue text-white flex items-center justify-center text-xs shadow-2xs shrink-0">
                    <i class="fa-solid fa-child"></i>
                  </div>
                  <div class="min-w-0">
                    <div class="font-heading font-bold text-xs text-dark-navy truncate">Shop By Age Group</div>
                    <div class="text-[9px] text-brand-muted font-sans truncate">Age-Matched Milestone Guide</div>
                  </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0 ml-2">
                  <span class="bg-blue-100 text-brand-blue text-[9px] font-extrabold px-1.5 py-0.5 rounded-md font-heading">5</span>
                  <i class="mobile-drawer-accordion-chevron fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
                </div>
              </button>

              <div class="mobile-drawer-accordion-content hidden space-y-1 pt-2.5 mt-2 border-t border-blue-200/70 text-xs font-semibold font-sans">
                <a href="${prefix}shop?age=0-2" class="p-1.5 rounded-xl hover:bg-white transition flex items-center justify-between text-dark-navy hover:text-brand-orange group/item">
                  <div class="flex items-center gap-2 min-w-0">
                    <div class="w-6 h-6 rounded-lg bg-orange-500 text-white font-heading font-bold text-[9px] flex items-center justify-center shadow-2xs shrink-0">0–2</div>
                    <div class="min-w-0">
                      <div class="font-heading font-bold text-xs text-dark-navy group-hover/item:text-brand-orange truncate">Infants & Toddlers</div>
                      <div class="text-[9px] text-brand-muted truncate">Sensory & Soft Toys</div>
                    </div>
                  </div>
                  <i class="fa-solid fa-chevron-right text-[8px] text-slate-400 group-hover/item:text-brand-orange transition shrink-0"></i>
                </a>

                <a href="${prefix}shop?age=3-5" class="p-1.5 rounded-xl hover:bg-white transition flex items-center justify-between text-dark-navy hover:text-amber-600 group/item">
                  <div class="flex items-center gap-2 min-w-0">
                    <div class="w-6 h-6 rounded-lg bg-amber-500 text-white font-heading font-bold text-[9px] flex items-center justify-center shadow-2xs shrink-0">3–5</div>
                    <div class="min-w-0">
                      <div class="font-heading font-bold text-xs text-dark-navy group-hover/item:text-amber-600 truncate">Curious Explorers</div>
                      <div class="text-[9px] text-brand-muted truncate">Puzzles, Clay & Learning</div>
                    </div>
                  </div>
                  <i class="fa-solid fa-chevron-right text-[8px] text-slate-400 group-hover/item:text-amber-600 transition shrink-0"></i>
                </a>

                <a href="${prefix}shop?age=6-8" class="p-1.5 rounded-xl hover:bg-white transition flex items-center justify-between text-dark-navy hover:text-brand-blue group/item">
                  <div class="flex items-center gap-2 min-w-0">
                    <div class="w-6 h-6 rounded-lg bg-brand-blue text-white font-heading font-bold text-[9px] flex items-center justify-center shadow-2xs shrink-0">6–8</div>
                    <div class="min-w-0">
                      <div class="font-heading font-bold text-xs text-dark-navy group-hover/item:text-brand-blue truncate">Active Adventurers</div>
                      <div class="text-[9px] text-brand-muted truncate">STEM Kits & Sports</div>
                    </div>
                  </div>
                  <i class="fa-solid fa-chevron-right text-[8px] text-slate-400 group-hover/item:text-brand-blue transition shrink-0"></i>
                </a>

                <a href="${prefix}shop?age=9-12" class="p-1.5 rounded-xl hover:bg-white transition flex items-center justify-between text-dark-navy hover:text-emerald-600 group/item">
                  <div class="flex items-center gap-2 min-w-0">
                    <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-heading font-bold text-[9px] flex items-center justify-center shadow-2xs shrink-0">9–12</div>
                    <div class="min-w-0">
                      <div class="font-heading font-bold text-xs text-dark-navy group-hover/item:text-emerald-600 truncate">Creative Thinkers</div>
                      <div class="text-[9px] text-brand-muted truncate">Robotics & Strategy</div>
                    </div>
                  </div>
                  <i class="fa-solid fa-chevron-right text-[8px] text-slate-400 group-hover/item:text-emerald-600 transition shrink-0"></i>
                </a>

                <a href="${prefix}shop?age=12+" class="p-1.5 rounded-xl hover:bg-white transition flex items-center justify-between text-dark-navy hover:text-purple-600 group/item">
                  <div class="flex items-center gap-2 min-w-0">
                    <div class="w-6 h-6 rounded-lg bg-purple-600 text-white font-heading font-bold text-[9px] flex items-center justify-center shadow-2xs shrink-0">12+</div>
                    <div class="min-w-0">
                      <div class="font-heading font-bold text-xs text-dark-navy group-hover/item:text-purple-600 truncate">Big Kids & Teens</div>
                      <div class="text-[9px] text-brand-muted truncate">Complex Kits & Games</div>
                    </div>
                  </div>
                  <i class="fa-solid fa-chevron-right text-[8px] text-slate-400 group-hover/item:text-purple-600 transition shrink-0"></i>
                </a>

                <div class="pt-1.5 border-t border-blue-100">
                  <a href="${prefix}shop" class="flex items-center justify-center gap-1.5 text-[11px] font-bold font-heading text-brand-blue hover:text-dark-navy py-1 transition">
                    <span>Find by Milestone Guide</span>
                    <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>
            </div>

            <!-- 3. DISCOVERY THEMES ACCORDION CARD (Sunny Amber) -->
            <div class="mobile-drawer-accordion-card bg-[#FFFDF0] border border-amber-200/90 rounded-2xl p-3 shadow-2xs">
              <button type="button" class="mobile-drawer-accordion-toggle w-full flex items-center justify-between text-left focus:outline-none cursor-pointer">
                <div class="flex items-center gap-2.5 min-w-0">
                  <div class="w-7 h-7 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs shadow-2xs shrink-0">
                    <i class="fa-solid fa-lightbulb"></i>
                  </div>
                  <div class="min-w-0">
                    <div class="font-heading font-bold text-xs text-dark-navy truncate">Discovery Themes</div>
                    <div class="text-[9px] text-brand-muted font-sans truncate">Curated by Play Style</div>
                  </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0 ml-2">
                  <span class="bg-amber-100 text-amber-700 text-[9px] font-extrabold px-1.5 py-0.5 rounded-md font-heading">4</span>
                  <i class="mobile-drawer-accordion-chevron fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
                </div>
              </button>

              <div class="mobile-drawer-accordion-content hidden pt-2.5 mt-2 border-t border-amber-200/70">
                <div class="grid grid-cols-2 gap-2">
                  <a href="${prefix}shop?tag=creative" class="p-2 rounded-xl bg-white border border-amber-100 hover:border-amber-300 hover:shadow-2xs transition group/btn flex flex-col items-center text-center">
                    <div class="w-6 h-6 rounded-lg bg-pink-100 text-pink-500 flex items-center justify-center text-xs mb-1 group-hover/btn:scale-110 transition">
                      <i class="fa-solid fa-palette"></i>
                    </div>
                    <span class="font-heading font-bold text-dark-navy text-[11px] group-hover/btn:text-pink-600 truncate w-full">Arts & Crafts</span>
                    <span class="text-[8px] text-brand-muted font-sans">DIY & Painting</span>
                  </a>
                  <a href="${prefix}shop?tag=sports" class="p-2 rounded-xl bg-white border border-amber-100 hover:border-amber-300 hover:shadow-2xs transition group/btn flex flex-col items-center text-center">
                    <div class="w-6 h-6 rounded-lg bg-blue-100 text-brand-blue flex items-center justify-center text-xs mb-1 group-hover/btn:scale-110 transition">
                      <i class="fa-solid fa-volleyball"></i>
                    </div>
                    <span class="font-heading font-bold text-dark-navy text-[11px] group-hover/btn:text-brand-blue truncate w-full">Active Play</span>
                    <span class="text-[8px] text-brand-muted font-sans">Fitness & Fun</span>
                  </a>
                  <a href="${prefix}shop?tag=mind" class="p-2 rounded-xl bg-white border border-amber-100 hover:border-amber-300 hover:shadow-2xs transition group/btn flex flex-col items-center text-center">
                    <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs mb-1 group-hover/btn:scale-110 transition">
                      <i class="fa-solid fa-brain"></i>
                    </div>
                    <span class="font-heading font-bold text-dark-navy text-[11px] group-hover/btn:text-emerald-600 truncate w-full">Brain Teasers</span>
                    <span class="text-[8px] text-brand-muted font-sans">Logic & IQ</span>
                  </a>
                  <a href="${prefix}shop?tag=pretend" class="p-2 rounded-xl bg-white border border-amber-100 hover:border-amber-300 hover:shadow-2xs transition group/btn flex flex-col items-center text-center">
                    <div class="w-6 h-6 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-xs mb-1 group-hover/btn:scale-110 transition">
                      <i class="fa-solid fa-masks-theater"></i>
                    </div>
                    <span class="font-heading font-bold text-dark-navy text-[11px] group-hover/btn:text-amber-600 truncate w-full">Role Play</span>
                    <span class="text-[8px] text-brand-muted font-sans">Costumes & Sets</span>
                  </a>
                </div>
              </div>
            </div>

            <!-- 4. FEATURED SPOTLIGHT & BEST SELLER (Fresh Emerald) -->
            <div class="mobile-drawer-accordion-card bg-[#F4FAF6] border border-emerald-200/90 rounded-2xl p-3 shadow-2xs">
              <a href="${prefix}product-details?id=1" class="flex items-center gap-3 bg-white p-2 rounded-xl border border-emerald-100 hover:border-emerald-300 transition group/spotlight">
                <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-50 shrink-0 relative">
                  <img src="${prefix}assets/images/products/soccer-ball.jpg" alt="Match Pro Football" class="w-full h-full object-cover group-hover/spotlight:scale-105 transition duration-300">
                  <span class="absolute top-0.5 left-0.5 bg-brand-orange text-white text-[7px] font-bold px-1 rounded font-heading">
                    TOP
                  </span>
                </div>
                <div class="min-w-0 flex-1">
                  <span class="text-[8px] font-extrabold text-emerald-700 uppercase tracking-wider block font-heading">FEATURED STAR</span>
                  <h5 class="font-heading font-bold text-xs text-dark-navy group-hover/spotlight:text-brand-orange transition truncate">Match Pro Football - Size 5</h5>
                  <div class="flex items-center justify-between mt-1">
                    <span class="text-[10px] text-amber-500 font-bold flex items-center gap-1">
                      <i class="fa-solid fa-star"></i>4.8
                    </span>
                    <span class="font-heading font-extrabold text-xs text-brand-blue">₹999</span>
                  </div>
                </div>
              </a>
            </div>

            <!-- 5. PLAY CLUB PERKS & SPECIAL PROMO (Royal Lavender) -->
            <div class="bg-[#FAF7FE] border border-purple-200/90 rounded-2xl p-3 shadow-2xs space-y-2">
              <div class="bg-gradient-to-br from-purple-600 to-indigo-700 text-white rounded-xl p-2.5 shadow-xs space-y-1.5 relative overflow-hidden">
                <div class="flex items-center justify-between">
                  <span class="inline-block bg-amber-400 text-purple-950 text-[8px] font-extrabold px-1.5 py-0.5 rounded font-heading uppercase tracking-wide">
                    PLAY CLUB PASS
                  </span>
                  <span class="text-amber-300 text-[10px] font-mono font-bold">15% OFF</span>
                </div>
                <h5 class="font-heading font-extrabold text-xs leading-tight">
                  Flat 15% OFF On 1st Order
                </h5>
                <p class="text-[9px] text-purple-100 font-sans">
                  Use code <span class="font-mono font-bold text-amber-300 bg-purple-800/60 px-1 py-0.5 rounded">PLAY15</span> at checkout
                </p>
                <a href="${prefix}new-arrivals" class="inline-block bg-white text-purple-700 hover:bg-amber-300 hover:text-purple-950 font-heading font-bold text-[9px] px-2.5 py-1 rounded-md transition shadow-2xs">
                  Claim Discount Now →
                </a>
              </div>

              <!-- Quick Customer Links in Drawer -->
              <div class="pt-1 grid grid-cols-2 gap-1.5 text-[10px] font-heading font-semibold text-dark-navy">
                <a href="${prefix}track-order" class="flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-purple-100/70 text-purple-800 transition">
                  <i class="fa-solid fa-truck-fast text-[10px] text-purple-600"></i>
                  <span>Track Order</span>
                </a>
                <a href="${prefix}faq" class="flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-purple-100/70 text-purple-800 transition">
                  <i class="fa-regular fa-circle-question text-[10px] text-purple-600"></i>
                  <span>Help & FAQ</span>
                </a>
                <a href="${prefix}contact" class="flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-purple-100/70 text-purple-800 transition">
                  <i class="fa-solid fa-headset text-[10px] text-purple-600"></i>
                  <span>Contact Us</span>
                </a>
                <a href="${prefix}about" class="flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-purple-100/70 text-purple-800 transition">
                  <i class="fa-solid fa-book-open text-[10px] text-purple-600"></i>
                  <span>Our Story</span>
                </a>
              </div>
            </div>

          </div>

          <!-- Drawer Sticky Bottom Actions -->
          <div class="p-3 sm:p-4 bg-gradient-to-t from-slate-50 to-white border-t border-brand-border/80 space-y-2 shrink-0">
            <!-- Mini Trust Strip -->
            <div class="flex items-center justify-between text-[9px] text-brand-muted font-sans px-1">
              <span class="flex items-center gap-1 font-bold text-dark-navy">
                <i class="fa-solid fa-shield-heart text-emerald-500"></i>Non-Toxic
              </span>
              <span class="flex items-center gap-1 font-bold text-dark-navy">
                <i class="fa-solid fa-truck-fast text-brand-blue"></i>Free Ship > ₹999
              </span>
              <span class="flex items-center gap-1 font-bold text-dark-navy">
                <i class="fa-solid fa-rotate-left text-amber-500"></i>7-Day Return
              </span>
            </div>

            <!-- Primary Big CTA -->
            <a href="${user.isLoggedIn ? `${prefix}account/dashboard` : `${prefix}login`}" class="w-full btn-play-blue text-xs py-2.5 px-4 rounded-xl flex items-center justify-center gap-2 transition shadow-md font-heading font-bold">
              <i class="fa-regular fa-user"></i>
              <span>${user.isLoggedIn ? 'MY PLAYROOM DASHBOARD' : 'SIGN IN / JOIN PLAY CLUB'}</span>
              <i class="fa-solid fa-arrow-right text-[10px] ml-auto"></i>
            </a>
          </div>

        </div>
      </div>
    `;
  },

  // Render Global Playful Creative Footer (Comprehensive Directory)
  renderFooter(prefix = '') {
    return `
      <footer class="bg-gradient-to-b from-[#072d56] via-[#062444] to-[#041930] text-white font-sans relative overflow-hidden">
        
        <!-- Ambient Background Glows -->
        <div class="absolute -top-32 left-1/4 w-96 h-96 rounded-full bg-brand-blue/25 blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-20 w-80 h-80 rounded-full bg-brand-orange/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 left-10 w-72 h-72 rounded-full bg-mint/10 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-8 relative z-10">
          
          <!-- 1. VIP PLAY LOOP & NEWSLETTER BANNER -->
          <div class="bg-gradient-to-r from-[#0c4a8a] via-[#083b74] to-[#0c4a8a] border border-white/20 rounded-3xl p-6 sm:p-8 mb-10 shadow-2xl relative overflow-hidden">
            <!-- Decorative Stars -->
            <div class="absolute top-3 right-8 text-play-yellow/40 text-xl deco-star"><i class="fa-solid fa-star"></i></div>
            <div class="absolute bottom-4 right-1/3 text-sky-blue/30 text-lg deco-star"><i class="fa-solid fa-sparkles"></i></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center relative z-10">
              <div class="lg:col-span-7 space-y-2">
                <div class="inline-flex items-center gap-2 bg-play-yellow text-dark-navy text-[11px] font-bold font-heading px-3 py-1 rounded-full shadow-xs uppercase tracking-wider">
                  <i class="fa-solid fa-sparkles text-brand-orange"></i>
                  <span>LET'S STAY IN THE PLAY LOOP</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-bold font-heading text-white tracking-tight">
                  Get 10% Off Your First Order
                </h3>
                <p class="text-xs sm:text-sm text-white/85 max-w-xl font-sans leading-relaxed">
                  Join 15,000+ parents! Get new toy releases, weekend activity ideas, STEM guides, and exclusive member discounts.
                </p>
              </div>

              <div class="lg:col-span-5">
                <form id="footer-playclub-form" onsubmit="event.preventDefault(); alert('🎉 Yay! Welcome to the Aparatus Play Loop! Use code PLAY10 at checkout for 10% off your order.'); this.reset();" class="space-y-2">
                  <div class="flex flex-col sm:flex-row items-center gap-2 bg-white/15 p-1.5 rounded-2xl border border-white/25 backdrop-blur-md">
                    <input 
                      type="email" 
                      required 
                      placeholder="Enter your email address" 
                      class="w-full px-4 py-2.5 bg-transparent text-xs sm:text-sm text-white placeholder:text-white/60 focus:outline-none font-sans"
                    >
                    <button type="submit" class="w-full sm:w-auto btn-play-orange text-xs px-6 py-3 rounded-xl transition shrink-0 flex items-center justify-center gap-2 cursor-pointer font-heading">
                      <span>JOIN THE FUN →</span>
                    </button>
                  </div>
                  <p class="text-[11px] text-white/75 text-center sm:text-left flex items-center justify-center sm:justify-start gap-1.5 font-sans">
                    <i class="fa-solid fa-shield-heart text-emerald-400"></i>
                    <span>Zero spam • Instant 10% coupon code (PLAY10)</span>
                  </p>
                </form>
              </div>
            </div>
          </div>

          <!-- 2. TRUST & ASSURANCE STRIP (4 Mini Badges) -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-12">
            
            <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-soft-orange/20 text-brand-orange flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-shield-heart"></i>
              </div>
              <div>
                <h5 class="font-heading font-bold text-xs text-white">100% Child-Safe</h5>
                <p class="text-[10px] text-white/70">Non-toxic & EN-71 certified</p>
              </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-sky-blue/20 text-sky-blue flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-truck-fast"></i>
              </div>
              <div>
                <h5 class="font-heading font-bold text-xs text-white">Free Fast Shipping</h5>
                <p class="text-[10px] text-white/70">On orders above ₹999</p>
              </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-mint/20 text-mint flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-rotate-left"></i>
              </div>
              <div>
                <h5 class="font-heading font-bold text-xs text-white">7-Day Easy Returns</h5>
                <p class="text-[10px] text-white/70">Hassle-free replacement</p>
              </div>
            </div>

            <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-purple-play/20 text-purple-play flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-lock"></i>
              </div>
              <div>
                <h5 class="font-heading font-bold text-xs text-white">Secure Checkout</h5>
                <p class="text-[10px] text-white/70">UPI, Cards & Net Banking</p>
              </div>
            </div>

          </div>

          <!-- 3. COMPREHENSIVE 6-COLUMN FOOTER DIRECTORY -->
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 mb-12">
            
            <!-- BRAND & CONTACT CENTER (Span 4) -->
            <div class="lg:col-span-4 space-y-4">
              
              <!-- Brand Identity -->
              <a href="${prefix}index" class="inline-block bg-white p-3 rounded-2xl shadow-lg border border-white/40 hover:scale-105 transition-transform duration-300">
                <img src="${prefix}assets/logo.png" alt="Aparatus Pastime" class="h-10 w-auto object-contain">
              </a>

              <div class="space-y-1">
                <span class="inline-block bg-brand-orange text-white text-[10px] font-bold font-heading px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-xs">
                  KIDS • TOYS • GAMES • ACTIVE PLAY
                </span>
                <p class="text-xs font-bold font-heading text-white tracking-widest uppercase">
                  PLAY. LEARN. EXPLORE.
                </p>
              </div>

              <p class="text-white/80 text-xs leading-relaxed font-sans max-w-sm">
                Aparatus Pastime curates premium sports equipment, tactical board games, educational STEM kits, and creative activity toys built for joyful childhood adventures and family memories.
              </p>

              <!-- Direct Contact Details -->
              <div class="space-y-2 pt-2 text-xs font-sans text-white/85">
                <div class="flex items-center gap-2.5">
                  <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-play-yellow text-xs shrink-0">
                    <i class="fa-solid fa-phone"></i>
                  </div>
                  <span>+91 98765 43210 <span class="text-white/50 text-[11px]">(Mon–Sat, 9AM–7PM)</span></span>
                </div>
                <div class="flex items-center gap-2.5">
                  <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-mint text-xs shrink-0">
                    <i class="fa-solid fa-envelope"></i>
                  </div>
                  <a href="mailto:support@aparatuspastime.com" class="hover:text-mint transition">support@aparatuspastime.com</a>
                </div>
                <div class="flex items-center gap-2.5">
                  <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-sky-blue text-xs shrink-0">
                    <i class="fa-solid fa-location-dot"></i>
                  </div>
                  <span>Mumbai & Bengaluru, India</span>
                </div>
              </div>

              <!-- Social Media Channels -->
              <div class="pt-2">
                <span class="text-[11px] font-bold font-heading text-white/70 uppercase tracking-wider block mb-2">CONNECT WITH US</span>
                <div class="flex items-center gap-2.5">
                  <a href="https://instagram.com" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-gradient-to-tr hover:from-amber-500 hover:via-pink-500 hover:to-purple-600 text-white flex items-center justify-center transition hover:scale-110 shadow-xs" title="Instagram">
                    <i class="fa-brands fa-instagram"></i>
                  </a>
                  <a href="https://facebook.com" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-blue-600 text-white flex items-center justify-center transition hover:scale-110 shadow-xs" title="Facebook">
                    <i class="fa-brands fa-facebook-f"></i>
                  </a>
                  <a href="https://youtube.com" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-red-600 text-white flex items-center justify-center transition hover:scale-110 shadow-xs" title="YouTube">
                    <i class="fa-brands fa-youtube"></i>
                  </a>
                  <a href="https://wa.me/919876543210" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-emerald-500 text-white flex items-center justify-center transition hover:scale-110 shadow-xs" title="WhatsApp Support">
                    <i class="fa-brands fa-whatsapp"></i>
                  </a>
                </div>
              </div>

            </div>

            <!-- 5 ORGANIZED DIRECTORY COLUMNS (Span 8) -->
            <div class="lg:col-span-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 sm:gap-6">
              
              <!-- COLUMN 1: SHOP CATEGORIES -->
              <div class="space-y-3 font-sans text-xs">
                <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-play-yellow flex items-center gap-1.5">
                  <i class="fa-solid fa-shapes"></i>
                  <span>SHOP</span>
                </h4>
                <ul class="space-y-2 text-white/80">
                  <li><a href="${prefix}shop?category=toys" class="hover:text-play-yellow transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Kids Toys</a></li>
                  <li><a href="${prefix}shop?category=games" class="hover:text-play-yellow transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Board Games</a></li>
                  <li><a href="${prefix}shop?category=sports" class="hover:text-play-yellow transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Sports Goods</a></li>
                  <li><a href="${prefix}shop?category=outdoor" class="hover:text-play-yellow transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Outdoor Play</a></li>
                  <li><a href="${prefix}shop?category=educational" class="hover:text-play-yellow transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>STEM Kits</a></li>
                  <li><a href="${prefix}shop?category=activity" class="hover:text-play-yellow transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Creative Arts</a></li>
                  <li><a href="${prefix}shop?category=gifts" class="hover:text-play-yellow transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Gifts & Sets</a></li>
                  <li><a href="${prefix}categories" class="hover:text-play-yellow transition flex items-center gap-1.5 font-bold text-play-yellow/90"><i class="fa-solid fa-arrow-right text-[9px]"></i>All Categories</a></li>
                </ul>
              </div>

              <!-- COLUMN 2: DISCOVER BY AGE -->
              <div class="space-y-3 font-sans text-xs">
                <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-sky-blue flex items-center gap-1.5">
                  <i class="fa-solid fa-child-reaching"></i>
                  <span>BY AGE</span>
                </h4>
                <ul class="space-y-2 text-white/80">
                  <li><a href="${prefix}shop?age=0-2" class="hover:text-sky-blue transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>0–2 Years</a></li>
                  <li><a href="${prefix}shop?age=3-5" class="hover:text-sky-blue transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>3–5 Years</a></li>
                  <li><a href="${prefix}shop?age=6-8" class="hover:text-sky-blue transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>6–8 Years</a></li>
                  <li><a href="${prefix}shop?age=9-12" class="hover:text-sky-blue transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>9–12 Years</a></li>
                  <li><a href="${prefix}shop?age=12+" class="hover:text-sky-blue transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>12+ Years</a></li>
                  <li><a href="${prefix}new-arrivals" class="hover:text-sky-blue transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>New Arrivals</a></li>
                  <li><a href="${prefix}shop?filter=bestseller" class="hover:text-sky-blue transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Best Sellers</a></li>
                  <li><a href="${prefix}shop?filter=trending" class="hover:text-sky-blue transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Trending Now</a></li>
                </ul>
              </div>

              <!-- COLUMN 3: CUSTOMER CARE -->
              <div class="space-y-3 font-sans text-xs">
                <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-mint flex items-center gap-1.5">
                  <i class="fa-solid fa-headset"></i>
                  <span>HELP & CARE</span>
                </h4>
                <ul class="space-y-2 text-white/80">
                  <li><a href="${prefix}track-order" class="hover:text-mint transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Track Order</a></li>
                  <li><a href="${prefix}faq" class="hover:text-mint transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Help & FAQ</a></li>
                  <li><a href="${prefix}contact" class="hover:text-mint transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Contact Us</a></li>
                  <li><a href="${prefix}shipping-policy" class="hover:text-mint transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Shipping Info</a></li>
                  <li><a href="${prefix}returns" class="hover:text-mint transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Easy Returns</a></li>
                  <li><a href="${prefix}cancellation-policy" class="hover:text-mint transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Cancellation</a></li>
                  <li><a href="${prefix}payment-policy" class="hover:text-mint transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Payment Safety</a></li>
                  <li><a href="https://wa.me/919876543210" target="_blank" rel="noopener" class="text-emerald-400 hover:text-emerald-300 transition flex items-center gap-1.5 font-semibold"><i class="fa-brands fa-whatsapp text-[11px]"></i>Live WhatsApp</a></li>
                </ul>
              </div>

              <!-- COLUMN 4: MY ACCOUNT -->
              <div class="space-y-3 font-sans text-xs">
                <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-purple-play flex items-center gap-1.5">
                  <i class="fa-solid fa-user-astronaut"></i>
                  <span>MY ACCOUNT</span>
                </h4>
                <ul class="space-y-2 text-white/80">
                  <li><a href="${prefix}account/dashboard" class="hover:text-purple-play transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Dashboard</a></li>
                  <li><a href="${prefix}account/orders" class="hover:text-purple-play transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>My Orders</a></li>
                  <li><a href="${prefix}account/wishlist" class="hover:text-purple-play transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>My Wishlist</a></li>
                  <li><a href="${prefix}account/addresses" class="hover:text-purple-play transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Saved Addresses</a></li>
                  <li><a href="${prefix}account/reviews" class="hover:text-purple-play transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Product Reviews</a></li>
                  <li><a href="${prefix}account/profile" class="hover:text-purple-play transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Profile Details</a></li>
                  <li><a href="${prefix}account/password" class="hover:text-purple-play transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Change Password</a></li>
                  <li><a href="${prefix}account/notifications" class="hover:text-purple-play transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Notifications</a></li>
                </ul>
              </div>

              <!-- COLUMN 5: ABOUT & POLICIES -->
              <div class="space-y-3 font-sans text-xs">
                <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-soft-coral flex items-center gap-1.5">
                  <i class="fa-solid fa-heart"></i>
                  <span>ABOUT & INFO</span>
                </h4>
                <ul class="space-y-2 text-white/80">
                  <li><a href="${prefix}about" class="hover:text-soft-coral transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Our Story</a></li>
                  <li><a href="${prefix}blog" class="hover:text-soft-coral transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Playroom Blog</a></li>
                  <li><a href="${prefix}about" class="hover:text-soft-coral transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Safety Standards</a></li>
                  <li><a href="${prefix}terms" class="hover:text-soft-coral transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Terms of Service</a></li>
                  <li><a href="${prefix}privacy-policy" class="hover:text-soft-coral transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Privacy Policy</a></li>
                  <li><a href="${prefix}cookie-policy" class="hover:text-soft-coral transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Cookie Policy</a></li>
                  <li><a href="${prefix}search" class="hover:text-soft-coral transition flex items-center gap-1.5"><i class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Search Toys</a></li>
                  <li><a href="${prefix}shop" class="hover:text-soft-coral transition flex items-center gap-1.5 font-bold text-soft-coral/90"><i class="fa-solid fa-arrow-right text-[9px]"></i>View Catalog</a></li>
                </ul>
              </div>

            </div>

          </div>

          <!-- 4. PLAYROOM TOPIC PILLS / POPULAR SEARCHES -->
          <div class="py-6 border-y border-white/10 my-8">
            <div class="flex flex-col sm:flex-row items-center gap-3">
              <span class="font-heading font-bold text-xs uppercase tracking-wider text-play-yellow shrink-0 flex items-center gap-1.5">
                <i class="fa-solid fa-tags text-brand-orange"></i>
                <span>POPULAR PLAY TOPICS:</span>
              </span>
              <div class="flex flex-wrap items-center gap-2 text-xs font-sans">
                <a href="${prefix}shop?category=educational" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#STEMRobotics</a>
                <a href="${prefix}shop?category=toys" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#MagneticTiles</a>
                <a href="${prefix}shop?category=sports" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#KashmirWillowCricket</a>
                <a href="${prefix}shop?category=games" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#BoardGamesNight</a>
                <a href="${prefix}shop?category=outdoor" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#OutdoorAdventures</a>
                <a href="${prefix}shop?category=activity" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#ArtStudioEasel</a>
                <a href="${prefix}shop?category=gifts" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#BirthdayGiftSets</a>
                <a href="${prefix}shop?age=3-5" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#PreschoolPlay</a>
                <a href="${prefix}shop?age=9-12" class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">#STEMforKids</a>
              </div>
            </div>
          </div>

          <!-- 5. BOTTOM BAR & TRUST BADGES -->
          <div class="flex flex-col lg:flex-row items-center justify-between gap-4 text-xs text-white/70 font-sans">
            <div class="flex flex-col sm:flex-row items-center gap-2 text-center sm:text-left">
              <span class="font-heading font-bold text-white flex items-center gap-1.5">
                <i class="fa-solid fa-sparkles text-play-yellow"></i>
                <span>Aparatus Pastime</span>
              </span>
              <span class="hidden sm:inline text-white/40">•</span>
              <span>Play. Learn. Explore.</span>
              <span class="hidden sm:inline text-white/40">•</span>
              <span>© 2026 Aparatus Pastime. All rights reserved.</span>
            </div>

            <!-- Payment Icons & SSL Badges -->
            <div class="flex flex-wrap items-center justify-center gap-3">
              <span class="text-[11px] text-emerald-400 flex items-center gap-1.5 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20 font-heading">
                <i class="fa-solid fa-lock"></i>
                <span>256-Bit SSL Encrypted</span>
              </span>
              <div class="flex items-center gap-3 text-lg text-white/80 bg-white/5 px-3.5 py-1 rounded-xl border border-white/10">
                <i class="fa-brands fa-cc-visa text-blue-400" title="Visa"></i>
                <i class="fa-brands fa-cc-mastercard text-orange-400" title="Mastercard"></i>
                <i class="fa-solid fa-credit-card text-emerald-400" title="RuPay Cards"></i>
                <i class="fa-solid fa-mobile-screen-button text-amber-300" title="UPI (GPay / PhonePe / Paytm)"></i>
                <i class="fa-solid fa-building-columns text-sky-300" title="Net Banking"></i>
                <i class="fa-solid fa-money-bill-wave text-green-400" title="Cash on Delivery"></i>
              </div>
            </div>
          </div>

        </div>
      </footer>
    `;
  },

  // Render Mobile Bottom Navigation Bar
  renderMobileBottomNav(activeTab = 'home', prefix = '') {
    const cartCount = State.getCartCount();
    const wishCount = State.getWishlistCount();

    return `
      <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-brand-border z-40 px-2 py-1.5 shadow-lg">
        <div class="grid grid-cols-5 gap-1 text-center font-heading text-[10px]">
          
          <a href="${prefix}index" class="flex flex-col items-center py-1 rounded-xl transition ${activeTab === 'home' ? 'text-brand-orange font-bold' : 'text-brand-muted hover:text-dark-navy'}">
            <i class="fa-solid fa-house text-base mb-0.5"></i>
            <span>Home</span>
          </a>

          <a href="${prefix}shop" class="flex flex-col items-center py-1 rounded-xl transition ${activeTab === 'shop' ? 'text-brand-orange font-bold' : 'text-brand-muted hover:text-dark-navy'}">
            <i class="fa-solid fa-store text-base mb-0.5"></i>
            <span>Shop</span>
          </a>

          <a href="${prefix}categories" class="flex flex-col items-center py-1 rounded-xl transition ${activeTab === 'categories' ? 'text-brand-orange font-bold' : 'text-brand-muted hover:text-dark-navy'}">
            <i class="fa-solid fa-shapes text-base mb-0.5"></i>
            <span>Categories</span>
          </a>

          <a href="${prefix}account/wishlist" class="relative flex flex-col items-center py-1 rounded-xl transition ${activeTab === 'wishlist' ? 'text-brand-orange font-bold' : 'text-brand-muted hover:text-dark-navy'}">
            <i class="fa-regular fa-heart text-base mb-0.5"></i>
            <span class="${wishCount > 0 ? '' : 'hidden'} absolute top-0 right-3 bg-brand-orange text-white text-[9px] font-bold w-3.5 h-3.5 rounded-full flex items-center justify-center">
              ${wishCount}
            </span>
            <span>Wishlist</span>
          </a>

          <a href="${prefix}account/dashboard" class="flex flex-col items-center py-1 rounded-xl transition ${activeTab === 'account' ? 'text-brand-orange font-bold' : 'text-brand-muted hover:text-dark-navy'}">
            <i class="fa-regular fa-user text-base mb-0.5"></i>
            <span>Account</span>
          </a>

        </div>
      </div>
    `;
  },

  // Initialize Global Interactions
  initGlobalInteractions(prefix = '') {
    // 1. Cart Drawer Triggers
    const cartBtns = document.querySelectorAll('#header-cart-btn, #mobile-bottom-cart-btn, .open-cart-drawer-btn');
    cartBtns.forEach(btn => {
      btn.onclick = (e) => {
        e.preventDefault();
        Components.openCartDrawer(prefix);
      };
    });

    // 2. Mobile Menu Drawer Triggers & Accordions
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileNavDrawer = document.getElementById('mobile-nav-drawer');
    const closeMobileNav = document.getElementById('close-mobile-nav');
    const mobileNavBackdrop = document.getElementById('mobile-nav-backdrop');

    if (mobileMenuToggle && mobileNavDrawer) {
      const openNav = () => {
        mobileNavDrawer.querySelector('.drawer-backdrop')?.classList.add('active');
        mobileNavDrawer.querySelector('.mobile-nav-drawer-panel')?.classList.add('active');
        document.body.style.overflow = 'hidden';
      };

      const closeNav = () => {
        mobileNavDrawer.querySelector('.drawer-backdrop')?.classList.remove('active');
        mobileNavDrawer.querySelector('.mobile-nav-drawer-panel')?.classList.remove('active');
        document.body.style.overflow = '';
      };

      mobileMenuToggle.onclick = (e) => {
        e.preventDefault();
        openNav();
      };

      closeMobileNav?.addEventListener('click', closeNav);
      mobileNavBackdrop?.addEventListener('click', closeNav);

      // Auto-close on link navigation
      const navLinks = mobileNavDrawer.querySelectorAll('a');
      navLinks.forEach(link => {
        link.addEventListener('click', () => {
          closeNav();
        });
      });

      // Mobile Drawer Mega-Menu Accordion Expand / Collapse
      const accordionToggles = mobileNavDrawer.querySelectorAll('.mobile-drawer-accordion-toggle');
      accordionToggles.forEach(toggle => {
        toggle.onclick = (e) => {
          e.preventDefault();
          const card = toggle.closest('.mobile-drawer-accordion-card');
          const content = card?.querySelector('.mobile-drawer-accordion-content');
          const chevron = toggle.querySelector('.mobile-drawer-accordion-chevron');

          if (content) {
            const isHidden = content.classList.contains('hidden');
            if (isHidden) {
              content.classList.remove('hidden');
              chevron?.classList.add('rotate-180');
            } else {
              content.classList.add('hidden');
              chevron?.classList.remove('rotate-180');
            }
          }
        };
      });
    }

    // 3. Search Autocomplete in Header
    const searchInput = document.getElementById('global-search-input');
    const suggestionsDropdown = document.getElementById('search-suggestions-dropdown');
    const searchClearBtn = document.getElementById('search-clear-btn');
    const liveProductsContainer = document.getElementById('search-live-products');

    if (searchInput && suggestionsDropdown) {
      searchInput.addEventListener('focus', () => {
        suggestionsDropdown.classList.remove('hidden');
      });

      searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim().toLowerCase();
        if (query.length > 0) {
          searchClearBtn?.classList.remove('hidden');
          const matched = products.filter(p => 
            p.name.toLowerCase().includes(query) || 
            p.categoryName.toLowerCase().includes(query) ||
            p.shortDescription.toLowerCase().includes(query)
          ).slice(0, 3);

          if (matched.length > 0 && liveProductsContainer) {
            liveProductsContainer.innerHTML = matched.map(p => `
              <a href="${prefix}product?slug=${p.slug}" class="flex items-center gap-2.5 p-2 hover:bg-soft-blue rounded-xl transition">
                <img src="${p.images[0]}" class="w-9 h-9 object-contain bg-soft-blue rounded-lg border border-brand-border">
                <div class="flex-1 min-w-0">
                  <div class="text-xs font-bold text-dark-navy truncate font-heading">${p.name}</div>
                  <div class="text-[11px] font-bold text-brand-orange font-heading">₹${p.price.toLocaleString()}</div>
                </div>
              </a>
            `).join('');
          } else if (liveProductsContainer) {
            liveProductsContainer.innerHTML = `<div class="text-xs text-brand-muted py-2 font-sans">No matching toys or games found.</div>`;
          }
        } else {
          searchClearBtn?.classList.add('hidden');
          if (liveProductsContainer) liveProductsContainer.innerHTML = '';
        }
      });

      searchClearBtn?.addEventListener('click', () => {
        searchInput.value = '';
        searchClearBtn.classList.add('hidden');
        if (liveProductsContainer) liveProductsContainer.innerHTML = '';
        searchInput.focus();
      });

      document.addEventListener('click', (e) => {
        if (!e.target.closest('#site-header')) {
          suggestionsDropdown.classList.add('hidden');
        }
      });
    }

    // // 5. Add To Cart Event Delegation
    // document.addEventListener('click', (e) => {
    //   const atcBtn = e.target.closest('.add-to-cart-btn');
    //   if (atcBtn) {
    //     e.preventDefault();
    //     const id = atcBtn.getAttribute('data-id');
    //     const prod = State.addToCart(id, 1);
    //     if (prod) {
    //       Components.showToast(`${prod.name} added to your play bag!`, 'orange', prefix);
    //     }
    //   }
    // });

    // 6. Wishlist Toggle Event Delegation
    document.addEventListener('click', (e) => {
      const wishBtn = e.target.closest('.wishlist-btn, .wishlist-toggle-btn');
      if (wishBtn) {
        e.preventDefault();
        const id = wishBtn.getAttribute('data-id');
        const added = State.toggleWishlist(id);
        const icon = wishBtn.querySelector('i');
        if (icon) {
          if (added) {
            icon.className = 'fa-solid fa-heart text-xs sm:text-sm text-red-500';
            wishBtn.classList.add('is-active');
            wishBtn.classList.add('text-red-500');
            wishBtn.classList.remove('text-slate-600');
            wishBtn.setAttribute('title', 'Remove from Wishlist');
            Components.showToast('Saved to your Wishlist!', 'success');
          } else {
            icon.className = 'fa-regular fa-heart text-xs sm:text-sm';
            wishBtn.classList.remove('is-active');
            wishBtn.classList.remove('text-red-500');
            wishBtn.classList.add('text-slate-600');
            wishBtn.setAttribute('title', 'Add to Wishlist');
            Components.showToast('Removed from Wishlist', 'info');
          }
        }
      }
    });

    // 7. Update Cart & Wishlist Counters dynamically
    window.addEventListener('aparatus:cart-updated', () => {
      const count = State.getCartCount();
      const headerCartCount = document.getElementById('header-cart-count');
      if (headerCartCount) {
        headerCartCount.textContent = count;
        if (count > 0) headerCartCount.classList.remove('hidden');
        else headerCartCount.classList.add('hidden');
      }
    });

    window.addEventListener('aparatus:wishlist-updated', () => {
      const count = State.getWishlistCount();
      const headerWishCount = document.getElementById('header-wishlist-count');
      if (headerWishCount) {
        headerWishCount.textContent = count;
        if (count > 0) headerWishCount.classList.remove('hidden');
        else headerWishCount.classList.add('hidden');
      }
    });

    // 8. Logout Trigger
    document.getElementById('header-logout-btn')?.addEventListener('click', () => {
      State.logout();
      Components.showToast('You have signed out successfully.', 'info');
    });
  }
};
