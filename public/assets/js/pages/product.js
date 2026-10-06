/**
 * Aparatus Pastime - Product Details Page Controller
 * Handles gallery switcher, quantity stepper, wishlist toggle, pincode checking,
 * reviews submission, tab switching, and bundle upsell logic.
 */

import { products } from '../data/products.js';
import { State } from '../state.js';
import { Components } from '../components.js';

document.addEventListener('DOMContentLoaded', () => {
  // 1. Mount Header, Footer, Bottom Nav
  document.getElementById('header-root').innerHTML = Components.renderHeader('shop', '../');
  document.getElementById('footer-root').innerHTML = Components.renderFooter('../');
  document.getElementById('mobile-bottom-nav-root').innerHTML = Components.renderMobileBottomNav('shop', '../');
  Components.initGlobalInteractions('../');

  // 2. Resolve Product by slug or id
  const urlParams = new URLSearchParams(window.location.search);
  const slug = urlParams.get('slug');
  const id = urlParams.get('id');

  let product = null;
  if (slug) product = products.find(p => p.slug === slug);
  else if (id) product = products.find(p => p.id === Number(id));
  else product = products[0];

  if (!product) product = products[0];

  // Add to recently viewed state
  State.addRecentlyViewed(product.id);

  // 3. Populate Meta & Titles
  document.title = `${product.name} | Aparatus Pastime`;
  document.getElementById('breadcrumb-category').textContent = product.categoryName;
  document.getElementById('breadcrumb-title').textContent = product.name;
  document.getElementById('pdp-badge').textContent = product.badge || 'POPULAR';
  document.getElementById('pdp-category-tag').textContent = product.categoryName;
  document.getElementById('pdp-age-tag').textContent = `AGE: ${product.ageLabel}`;
  document.getElementById('pdp-title').textContent = product.name;
  document.getElementById('pdp-rating-score').textContent = product.rating;
  document.getElementById('pdp-reviews-count').textContent = product.reviewCount;
  document.getElementById('tab-reviews-counter').textContent = product.reviewCount;
  document.getElementById('pdp-price').textContent = `₹${product.price.toLocaleString()}`;
  document.getElementById('pdp-original-price').textContent = `₹${product.originalPrice.toLocaleString()}`;
  document.getElementById('pdp-discount').textContent = `${product.discount}% OFF`;
  document.getElementById('pdp-short-desc').textContent = product.shortDescription;
  document.getElementById('pdp-stock-label').textContent = `In Stock (${product.stock} units)`;

  // Share links
  const shareUrl = encodeURIComponent(window.location.href);
  const shareText = encodeURIComponent(`Check out ${product.name} on Aparatus Pastime!`);
  document.getElementById('share-wa').href = `https://api.whatsapp.com/send?text=${shareText}%20${shareUrl}`;
  document.getElementById('copy-link-btn').onclick = () => {
    navigator.clipboard.writeText(window.location.href);
    Components.showToast('Product link copied to clipboard!', 'info');
  };

  // Sticky Purchase Bar Setup
  document.getElementById('sticky-img').src = product.images[0];
  document.getElementById('sticky-title').textContent = product.name;
  document.getElementById('sticky-price').textContent = `₹${product.price.toLocaleString()}`;
  document.getElementById('sticky-orig').textContent = `₹${product.originalPrice.toLocaleString()}`;

  const stickyBar = document.getElementById('sticky-pdp-bar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      stickyBar.classList.remove('translate-y-full');
    } else {
      stickyBar.classList.add('translate-y-full');
    }
  });
  document.getElementById('sticky-add-btn').onclick = () => {
    State.addToCart(product.id, 1);
    Components.showToast(`${product.name} added to your play bag!`, 'orange');
    Components.openCartDrawer('../');
  };

  // Big Rating & Star Representation
  document.getElementById('pdp-big-rating').textContent = product.rating;
  document.getElementById('pdp-big-count').textContent = `Based on ${product.reviewCount} verified parent reviews`;

  const starsHtml = Array.from({ length: 5 }, (_, i) => {
    return i < Math.floor(product.rating)
      ? '<i class="fa-solid fa-star star-filled text-sm text-amber-400"></i>'
      : '<i class="fa-solid fa-star star-empty text-sm text-gray-300"></i>';
  }).join('');
  document.getElementById('pdp-stars').innerHTML = starsHtml;
  document.getElementById('pdp-big-stars').innerHTML = starsHtml;

  // 4. Gallery Images & Thumbnails
  const mainImg = document.getElementById('pdp-main-image');
  mainImg.src = product.images[0];
  let currentImgIdx = 0;

  const thumbsContainer = document.getElementById('pdp-thumbnails');
  thumbsContainer.innerHTML = product.images.map((img, idx) => `
    <button class="thumb-btn border-2 ${idx === 0 ? 'border-brand-blue scale-105 shadow-md' : 'border-transparent opacity-75 hover:opacity-100'} rounded-2xl p-1.5 bg-white w-16 h-16 flex items-center justify-center shadow-xs transition hover:scale-105 cursor-pointer" data-idx="${idx}">
      <img src="${img}" class="w-full h-full object-contain rounded-xl">
    </button>
  `).join('');

  const updateMainImg = (idx) => {
    currentImgIdx = idx;
    mainImg.src = product.images[idx];
    document.querySelectorAll('.thumb-btn').forEach((btn, i) => {
      btn.className = `thumb-btn border-2 ${i === idx ? 'border-brand-blue scale-105 shadow-md' : 'border-transparent opacity-75 hover:opacity-100'} rounded-2xl p-1.5 bg-white w-16 h-16 flex items-center justify-center shadow-xs transition hover:scale-105 cursor-pointer`;
    });
  };

  document.querySelectorAll('.thumb-btn').forEach(btn => {
    btn.addEventListener('click', () => updateMainImg(Number(btn.getAttribute('data-idx'))));
  });

  document.getElementById('gallery-prev')?.addEventListener('click', () => {
    const next = (currentImgIdx - 1 + product.images.length) % product.images.length;
    updateMainImg(next);
  });
  document.getElementById('gallery-next')?.addEventListener('click', () => {
    const next = (currentImgIdx + 1) % product.images.length;
    updateMainImg(next);
  });

  // 5. Wishlist Button Sync
  const wishBtn = document.getElementById('pdp-wishlist-btn');
  const updateWishIcon = () => {
    const inWish = State.isInWishlist(product.id);
    wishBtn.innerHTML = `<i class="${inWish ? 'fa-solid fa-heart text-red-500' : 'fa-regular fa-heart'} text-lg"></i>`;
  };
  updateWishIcon();
  wishBtn.onclick = () => {
    const added = State.toggleWishlist(product.id);
    updateWishIcon();
    Components.showToast(added ? 'Saved to your Wishlist!' : 'Removed from Wishlist', added ? 'success' : 'info');
  };

  // 6. Qty Stepper
  const qtyInput = document.getElementById('pdp-qty-input');
  document.getElementById('pdp-qty-minus').onclick = () => {
    let val = parseInt(qtyInput.value) || 1;
    if (val > 1) qtyInput.value = val - 1;
  };
  document.getElementById('pdp-qty-plus').onclick = () => {
    let val = parseInt(qtyInput.value) || 1;
    if (val < product.stock) qtyInput.value = val + 1;
  };

  // 7. Add to Cart & Buy Now
  document.getElementById('pdp-add-to-cart-btn').onclick = () => {
    const qty = parseInt(qtyInput.value) || 1;
    State.addToCart(product.id, qty);
    Components.showToast(`${product.name} (x${qty}) added to your play bag!`, 'orange', '../');
  };

  document.getElementById('pdp-buy-now-btn').onclick = () => {
    const qty = parseInt(qtyInput.value) || 1;
    State.addToCart(product.id, qty);
    window.location.href = 'checkout.html';
  };

  // 8. Pincode Checker
  document.getElementById('pincode-check-btn').onclick = () => {
    const pin = document.getElementById('pincode-input').value.trim();
    const res = document.getElementById('pincode-result');
    if (pin.length === 6 && /^\d+$/.test(pin)) {
      res.classList.remove('hidden');
      res.innerHTML = `<i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i>Delivering to <strong>${pin}</strong> by <strong>Thursday, Oct 2</strong> • Express Shipping & COD Available`;
    } else {
      res.classList.remove('hidden');
      res.innerHTML = `<span class="text-red-500 font-bold"><i class="fa-solid fa-circle-exclamation mr-1"></i>Please enter a valid 6-digit Indian postal code.</span>`;
    }
  };

  // 9. Bundle Upsell Card Setup
  document.getElementById('bundle-img-1').src = product.images[0];
  const bundleCompanion = products.find(p => p.id !== product.id && p.id === 5) || products.find(p => p.id !== product.id);
  if (bundleCompanion) {
    document.getElementById('bundle-img-2').src = bundleCompanion.images[0];
    const combined = Math.round((product.price + bundleCompanion.price) * 0.9);
    document.getElementById('bundle-total-price').textContent = `₹${combined.toLocaleString()}`;
    document.getElementById('add-bundle-to-cart-btn').onclick = () => {
      State.addToCart(product.id, 1);
      State.addToCart(bundleCompanion.id, 1);
      Components.showToast(`Bundle added! ${product.name} + ${bundleCompanion.name}`, 'orange', '../');
    };
  }

  // 10. Specifications Cards Renderer
  const specsGrid = document.getElementById('pdp-specs-grid');
  if (specsGrid && product.specifications) {
    const specIcons = {
      'Material': { icon: 'fa-solid fa-layer-group', color: 'text-brand-blue bg-soft-blue border-blue-200' },
      'Size': { icon: 'fa-solid fa-ruler-combined', color: 'text-brand-orange bg-soft-orange border-orange-200' },
      'Dimensions': { icon: 'fa-solid fa-ruler-combined', color: 'text-brand-orange bg-soft-orange border-orange-200' },
      'Board Dimensions': { icon: 'fa-solid fa-ruler-combined', color: 'text-brand-orange bg-soft-orange border-orange-200' },
      'Weight': { icon: 'fa-solid fa-weight-scale', color: 'text-purple-600 bg-soft-purple border-purple-200' },
      'Bladder': { icon: 'fa-solid fa-circle-dot', color: 'text-emerald-600 bg-soft-mint border-emerald-200' },
      'Stitching': { icon: 'fa-solid fa-bezier-curve', color: 'text-pink-600 bg-pink-50 border-pink-200' },
      'Recommended Surface': { icon: 'fa-solid fa-shield-halved', color: 'text-amber-600 bg-soft-yellow border-amber-200' },
      'Players': { icon: 'fa-solid fa-users', color: 'text-brand-blue bg-soft-blue border-blue-200' },
      'Play Time': { icon: 'fa-solid fa-stopwatch', color: 'text-brand-orange bg-soft-orange border-orange-200' },
      'Age Recommendation': { icon: 'fa-solid fa-child-reaching', color: 'text-emerald-600 bg-soft-mint border-emerald-200' },
      'Language': { icon: 'fa-solid fa-language', color: 'text-purple-600 bg-soft-purple border-purple-200' }
    };

    specsGrid.innerHTML = Object.entries(product.specifications).map(([k, v]) => {
      const style = specIcons[k] || { icon: 'fa-solid fa-cubes', color: 'text-brand-blue bg-soft-blue border-blue-200' };
      return `
        <div class="p-4 rounded-2xl bg-warm-cream border border-brand-border hover:border-brand-blue/40 transition flex items-start gap-3.5">
          <div class="w-10 h-10 rounded-xl ${style.color} border flex items-center justify-center shrink-0 shadow-2xs">
            <i class="${style.icon} text-sm"></i>
          </div>
          <div class="min-w-0">
            <div class="text-[11px] font-bold text-brand-muted uppercase tracking-wider font-heading">${k}</div>
            <div class="text-xs sm:text-sm font-bold text-dark-navy font-heading mt-0.5">${v}</div>
          </div>
        </div>
      `;
    }).join('');
  }

  // Description & What's Included
  document.getElementById('pdp-full-desc').innerHTML = `
    <p class="leading-relaxed">${product.description}</p>
  `;

  const includedList = document.getElementById('pdp-included-list');
  if (includedList && product.included) {
    includedList.innerHTML = product.included.map(item => `
      <li class="flex items-center gap-3 p-3.5 rounded-2xl bg-soft-blue/40 border border-blue-100 hover:bg-soft-blue/70 transition">
        <div class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 text-xs shadow-2xs">
          <i class="fa-solid fa-check"></i>
        </div>
        <span class="font-bold text-xs sm:text-sm text-dark-navy font-heading">${item}</span>
      </li>
    `).join('');
  }

  document.getElementById('pdp-how-to-use').textContent = product.howToUse || 'Store in a clean dry place after play. Wipe with a clean cloth.';

  // Badges sync
  const jumpCount = document.getElementById('jump-reviews-count');
  if (jumpCount) jumpCount.textContent = product.reviewCount;
  const totalBadge = document.getElementById('reviews-total-badge');
  if (totalBadge) totalBadge.textContent = product.reviewCount;

  // Reviews List
  const renderReviews = (reviewList) => {
    const reviewsContainer = document.getElementById('pdp-reviews-list');
    if (reviewsContainer && reviewList) {
      reviewsContainer.innerHTML = reviewList.map(r => `
        <div class="p-5 sm:p-6 rounded-2xl bg-white border border-brand-border space-y-3 shadow-2xs">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-soft-blue to-soft-yellow text-brand-navy flex items-center justify-center font-extrabold text-sm font-heading border border-brand-border">
                ${r.user.charAt(0)}
              </div>
              <div>
                <h5 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">${r.user}</h5>
                <span class="text-[10px] text-emerald-600 font-bold font-heading flex items-center gap-1">
                  <i class="fa-solid fa-circle-check"></i>Verified Family Purchase
                </span>
              </div>
            </div>
            <span class="text-[11px] text-brand-muted font-heading">${r.date}</span>
          </div>
          <div class="flex text-amber-400 text-xs">
            ${Array.from({ length: r.rating }, () => '<i class="fa-solid fa-star"></i>').join('')}
          </div>
          <h6 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">${r.title}</h6>
          <p class="text-xs text-body-text leading-relaxed font-sans">${r.comment}</p>
        </div>
      `).join('');
    }
  };

  renderReviews(product.reviews);

  // Write Review Form
  const toggleReviewBtn = document.getElementById('toggle-review-form-btn');
  const cancelReviewBtn = document.getElementById('cancel-review-btn');
  const reviewForm = document.getElementById('write-review-form');
  toggleReviewBtn?.addEventListener('click', () => {
    reviewForm.classList.toggle('hidden');
    if (!reviewForm.classList.contains('hidden')) {
      reviewForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
  });
  cancelReviewBtn?.addEventListener('click', () => {
    reviewForm.classList.add('hidden');
  });

  reviewForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    const name = document.getElementById('review-name').value;
    const rating = parseInt(document.getElementById('review-rating').value);
    const title = document.getElementById('review-title').value;
    const comment = document.getElementById('review-comment').value;

    const newReview = {
      id: Date.now(),
      user: name,
      rating,
      title,
      comment,
      date: new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
    };

    if (!product.reviews) product.reviews = [];
    product.reviews.unshift(newReview);
    product.reviewCount = (product.reviewCount || 0) + 1;

    renderReviews(product.reviews);
    if (jumpCount) jumpCount.textContent = product.reviewCount;
    if (totalBadge) totalBadge.textContent = product.reviewCount;
    document.getElementById('pdp-reviews-count').textContent = product.reviewCount;

    Components.showToast('Thank you! Your parent review has been posted.', 'success');
    reviewForm.reset();
    reviewForm.classList.add('hidden');
  });

  // 11. Related Products
  const relatedGrid = document.getElementById('related-products-grid');
  if (relatedGrid) {
    const related = products.filter(p => p.id !== product.id && p.category === product.category).slice(0, 4);
    if (related.length < 4) {
      const others = products.filter(p => p.id !== product.id && !related.includes(p)).slice(0, 4 - related.length);
      related.push(...others);
    }
    relatedGrid.innerHTML = related.map(p => Components.renderProductCard(p, '../')).join('');
  }

  // 12. Recently Viewed
  const rvIds = State.getRecentlyViewed().filter(rid => rid !== product.id).slice(0, 4);
  if (rvIds.length > 0) {
    const rvSection = document.getElementById('recently-viewed-section');
    const rvGrid = document.getElementById('recently-viewed-grid');
    const rvProds = rvIds.map(rid => products.find(p => p.id === rid)).filter(Boolean);
    if (rvProds.length > 0 && rvGrid && rvSection) {
      rvSection.classList.remove('hidden');
      rvGrid.innerHTML = rvProds.map(p => Components.renderProductCard(p, '../')).join('');
    }
  }
});
