@extends('layouts.app')

@section('title', 'FAQ & Help Center | Aparatus - Sports Goods & Toys')
@section('meta_description', 'Find instant answers to common questions about Aparatus sports goods, toys, delivery speeds, safety testing, and 7-day returns.')
@section('active_nav', 'faq')

@push('styles')
  <style>
    /* Complete clean accordion transition without any content or border leakage */
    .faq-accordion-item {
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .faq-accordion-item.active {
      border-color: #1261A0;
      box-shadow: 0 10px 25px -5px rgba(18, 97, 160, 0.12);
    }
    .faq-accordion-content {
      max-height: 0;
      overflow: hidden;
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
      transition: max-height 0.3s cubic-bezier(0, 1, 0, 1), opacity 0.2s ease, visibility 0.2s ease;
    }
    .faq-accordion-item.active .faq-accordion-content {
      max-height: 1000px;
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
      transition: max-height 0.35s ease-in-out, opacity 0.25s ease-in;
    }
    .faq-accordion-item.active .faq-chevron {
      transform: rotate(180deg);
      color: #F58220;
    }
  </style>
@endpush

@section('content')
  <div class="py-8 md:py-12">
    <div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

      <!-- TOP BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted font-heading">
        <a href="{{ url('/') }}" class="hover:text-brand-orange transition flex items-center gap-1.5 font-bold">
          <i class="fa-solid fa-house text-xs"></i>
          <span>Home</span>
        </a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-dark-navy font-bold">FAQ & Help Desk</span>
      </nav>

      <!-- CREATIVE HERO SECTION -->
      <section class="bg-gradient-to-br from-brand-navy via-brand-blue to-dark-navy text-white rounded-3xl sm:rounded-[32px] p-8 sm:p-12 lg:p-16 relative overflow-hidden shadow-xl">
        <div class="absolute -top-16 -right-16 w-80 h-80 bg-brand-orange/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-play-yellow/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-3xl mx-auto text-center relative z-10 space-y-4">
          <span class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md px-4 py-1.5 rounded-full text-play-yellow text-xs font-bold font-heading border border-white/20 shadow-xs uppercase tracking-wider">
            <i class="fa-solid fa-headset text-brand-orange"></i>
            <span>24/7 Knowledge Base • Aparatus Help Desk</span>
          </span>

          <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-heading text-white leading-tight tracking-tight">
            FREQUENTLY ASKED QUESTIONS
          </h1>

          <p class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed max-w-xl mx-auto">
            Got questions about sports gear, toys, dispatch speeds, or 7-day returns? Search instant answers or explore by category below.
          </p>

          <!-- Interactive Live Search Stage -->
          <div class="pt-4 max-w-2xl mx-auto">
            <div class="relative bg-white/95 backdrop-blur-md rounded-2xl p-1.5 shadow-2xl border border-white/40 flex items-center gap-2">
              <div class="w-10 h-10 rounded-xl bg-soft-blue text-brand-blue flex items-center justify-center text-base shrink-0 ml-1">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
              <input
                type="text"
                id="faq-search-input"
                placeholder="Search topics (e.g. shipping time, 7-day return, toy safety, UPI payment)..."
                class="w-full py-2.5 pr-4 text-xs sm:text-sm text-dark-navy placeholder:text-brand-muted bg-transparent focus:outline-none font-sans font-medium"
              >
              <button id="faq-clear-btn" class="hidden px-3 py-1.5 text-xs text-brand-muted hover:text-dark-navy font-bold font-heading transition">
                Clear
              </button>
            </div>

            <!-- Quick Keyword Tags -->
            <div class="flex flex-wrap items-center justify-center gap-2 pt-3 text-[11px] font-heading font-semibold text-white/90">
              <span class="text-white/60">Popular Searches:</span>
              <button class="quick-search-chip px-3 py-1 rounded-full bg-white/10 hover:bg-white/25 backdrop-blur-sm border border-white/20 transition cursor-pointer" data-query="shipping">
                🚚 Delivery Time
              </button>
              <button class="quick-search-chip px-3 py-1 rounded-full bg-white/10 hover:bg-white/25 backdrop-blur-sm border border-white/20 transition cursor-pointer" data-query="return">
                ↩️ 7-Day Return
              </button>
              <button class="quick-search-chip px-3 py-1 rounded-full bg-white/10 hover:bg-white/25 backdrop-blur-sm border border-white/20 transition cursor-pointer" data-query="safety">
                🛡️ Toy Safety
              </button>
              <button class="quick-search-chip px-3 py-1 rounded-full bg-white/10 hover:bg-white/25 backdrop-blur-sm border border-white/20 transition cursor-pointer" data-query="payment">
                💳 UPI & Cards
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- VISUAL CATEGORY SELECTOR CARDS -->
      <section class="space-y-4">
        <div class="flex items-center justify-between">
          <h2 class="text-lg sm:text-xl font-bold font-heading text-dark-navy flex items-center gap-2">
            <i class="fa-solid fa-shapes text-brand-orange"></i>
            <span>Browse By Category</span>
          </h2>
          <button id="show-all-cats-btn" class="text-xs font-bold font-heading text-brand-blue hover:text-brand-orange transition cursor-pointer">
            View All Questions →
          </button>
        </div>

        <div id="faq-category-cards" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
          <!-- Injected via JavaScript -->
        </div>
      </section>

      <!-- MAIN 2-COLUMN LAYOUT -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT: FAQ ACCORDION LIST (8 COLS) -->
        <div class="lg:col-span-8 space-y-6">

          <!-- Top Results Bar & Controls -->
          <div class="bg-white rounded-2xl border border-brand-border p-4 flex flex-wrap items-center justify-between gap-3 shadow-2xs">
            <div class="flex items-center gap-2.5">
              <span id="current-filter-badge" class="px-3 py-1 rounded-full bg-soft-blue text-brand-blue font-bold font-heading text-xs">
                All Topics
              </span>
              <span id="faq-count-text" class="text-xs text-brand-muted font-sans font-medium">
                Showing 15 Questions
              </span>
            </div>

            <div class="flex items-center gap-2">
              <button id="expand-all-btn" class="px-3 py-1 rounded-xl bg-warm-cream hover:bg-soft-blue text-dark-navy border border-brand-border text-xs font-bold font-heading transition cursor-pointer shadow-2xs">
                <i class="fa-solid fa-arrows-up-down mr-1 text-[10px]"></i>
                <span id="expand-all-text">Expand All</span>
              </button>
            </div>
          </div>

          <!-- FAQ ACCORDION CONTAINER -->
          <div id="faq-accordion-container" class="space-y-3.5">
            <!-- Injected via JavaScript -->
          </div>

          <!-- EMPTY SEARCH RESULTS STATE -->
          <div id="faq-empty-state" class="hidden bg-white rounded-3xl border border-brand-border p-10 text-center space-y-4 shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-soft-orange text-brand-orange flex items-center justify-center text-2xl mx-auto shadow-inner">
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <h3 class="font-heading font-bold text-lg text-dark-navy">No Answers Found</h3>
            <p class="text-xs sm:text-sm text-body-text max-w-md mx-auto font-sans">
              We couldn't find any questions matching your search. Try different keywords or contact our team directly.
            </p>
            <button id="reset-search-btn" class="btn-play-orange text-xs px-5 py-2.5 rounded-xl font-heading font-bold shadow-xs">
              Reset Search Filter
            </button>
          </div>

        </div>

        <!-- RIGHT: STICKY CONTACT & SELF-SERVICE SIDEBAR (4 COLS) -->
        <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

          <!-- SIDEBAR CARD 1: INSTANT HELP CHANNELS -->
          <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-4">
            <div class="flex items-center gap-3 pb-3 border-b border-brand-border">
              <div class="w-10 h-10 rounded-2xl bg-soft-orange text-brand-orange flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-comments"></i>
              </div>
              <div>
                <h3 class="font-heading font-bold text-sm sm:text-base text-dark-navy leading-tight">Need Quick Assistance?</h3>
                <p class="text-[11px] text-brand-muted font-sans">Our support team is here to help</p>
              </div>
            </div>

            <!-- WhatsApp Direct Button -->
            <a
              href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%20Aparatus%20Team%2C%20I%20have%20a%20question%20regarding%20an%20order."
              target="_blank" rel="noopener"
              class="w-full p-3.5 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 flex items-center justify-between text-emerald-800 transition group shadow-2xs"
            >
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-lg group-hover:scale-110 transition shadow-xs">
                  <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                  <div class="text-xs font-bold font-heading">Chat on WhatsApp</div>
                  <div class="text-[10px] text-emerald-600 font-sans">Instant live reply • 2 mins</div>
                </div>
              </div>
              <i class="fa-solid fa-arrow-right text-xs text-emerald-600 group-hover:translate-x-1 transition"></i>
            </a>

            <!-- Phone Call Button -->
            <a
              href="tel:+919876543210"
              class="w-full p-3.5 rounded-2xl bg-soft-blue hover:bg-blue-100 border border-blue-200 flex items-center justify-between text-brand-navy transition group shadow-2xs"
            >
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-brand-blue text-white flex items-center justify-center text-sm group-hover:scale-110 transition shadow-xs">
                  <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                  <div class="text-xs font-bold font-heading">+91 98765 43210</div>
                  <div class="text-[10px] text-brand-muted font-sans">Mon–Sat: 9:00 AM – 7:00 PM IST</div>
                </div>
              </div>
              <i class="fa-solid fa-arrow-right text-xs text-brand-blue group-hover:translate-x-1 transition"></i>
            </a>

            <!-- Email Support Button -->
            <a
              href="mailto:support@aparatus.com"
              class="w-full p-3.5 rounded-2xl bg-warm-cream hover:bg-soft-yellow border border-brand-border flex items-center justify-between text-dark-navy transition group shadow-2xs"
            >
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-brand-orange text-white flex items-center justify-center text-sm group-hover:scale-110 transition shadow-xs">
                  <i class="fa-regular fa-envelope"></i>
                </div>
                <div>
                  <div class="text-xs font-bold font-heading">support@aparatus.com</div>
                  <div class="text-[10px] text-brand-muted font-sans">Official email ticketing</div>
                </div>
              </div>
              <i class="fa-solid fa-arrow-right text-xs text-brand-orange group-hover:translate-x-1 transition"></i>
            </a>
          </div>

          <!-- SIDEBAR CARD 2: SELF-SERVICE SHORTCUTS -->
          <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-3">
            <h3 class="font-heading font-bold text-sm text-dark-navy pb-2 border-b border-brand-border">
              Quick Self-Service Tools
            </h3>
            <div class="space-y-2 font-heading text-xs">
              <a href="{{ route('user.track-order') }}" class="p-2.5 rounded-xl bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-navy flex items-center justify-between transition group">
                <span class="flex items-center gap-2 font-bold">
                  <i class="fa-solid fa-truck text-brand-blue group-hover:text-white"></i>
                  <span>Track Live Order</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] text-brand-muted group-hover:text-white"></i>
              </a>
              <a href="{{ route('contact') }}" class="p-2.5 rounded-xl bg-soft-orange hover:bg-brand-orange hover:text-white text-dark-navy flex items-center justify-between transition group">
                <span class="flex items-center gap-2 font-bold">
                  <i class="fa-solid fa-paper-plane text-brand-orange group-hover:text-white"></i>
                  <span>Submit Support Ticket</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] text-brand-muted group-hover:text-white"></i>
              </a>
              <a href="{{ route('returns') }}" class="p-2.5 rounded-xl bg-soft-mint hover:bg-emerald-600 hover:text-white text-emerald-800 flex items-center justify-between transition group">
                <span class="flex items-center gap-2 font-bold">
                  <i class="fa-solid fa-rotate-left text-emerald-600 group-hover:text-white"></i>
                  <span>7-Day Return Policy</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] text-brand-muted group-hover:text-white"></i>
              </a>
            </div>
          </div>

          <!-- SIDEBAR CARD 3: APARATUS TRUST BADGES -->
          <div class="bg-gradient-to-br from-soft-blue via-soft-yellow/20 to-soft-mint/30 rounded-3xl border border-brand-border p-6 space-y-3.5">
            <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
              <i class="fa-solid fa-shield-heart text-emerald-500"></i>
              <span>The Aparatus Assurance</span>
            </h4>
            <ul class="space-y-2 text-xs text-dark-navy font-sans">
              <li class="flex items-start gap-2">
                <i class="fa-solid fa-check text-emerald-600 mt-0.5 shrink-0 text-[11px]"></i>
                <span>100% Non-toxic & child-safe tested toys.</span>
              </li>
              <li class="flex items-start gap-2">
                <i class="fa-solid fa-check text-emerald-600 mt-0.5 shrink-0 text-[11px]"></i>
                <span>Official Kashmir Willow & certified sports gear.</span>
              </li>
              <li class="flex items-start gap-2">
                <i class="fa-solid fa-check text-emerald-600 mt-0.5 shrink-0 text-[11px]"></i>
                <span>Free Express Delivery on orders over ₹999.</span>
              </li>
            </ul>
          </div>

        </aside>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { faqs } from '{{ asset("assets/js/data/faqs.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const cardsContainer = document.getElementById('faq-category-cards');
      const accordionContainer = document.getElementById('faq-accordion-container');
      const searchInput = document.getElementById('faq-search-input');
      const clearBtn = document.getElementById('faq-clear-btn');
      const emptyState = document.getElementById('faq-empty-state');
      const currentFilterBadge = document.getElementById('current-filter-badge');
      const faqCountText = document.getElementById('faq-count-text');
      const expandAllBtn = document.getElementById('expand-all-btn');
      const expandAllText = document.getElementById('expand-all-text');
      const showAllBtn = document.getElementById('show-all-cats-btn');
      const resetSearchBtn = document.getElementById('reset-search-btn');

      let activeCategory = 'all';
      let allExpanded = false;

      // 1. Render Category Visual Cards
      const renderCategoryCards = () => {
        cardsContainer.innerHTML = faqs.map(cat => {
          const isActive = activeCategory === cat.category;
          return `
            <button
              class="faq-cat-card p-4 rounded-2xl border text-left transition duration-200 cursor-pointer flex flex-col justify-between group ${isActive ? 'bg-brand-orange text-white border-brand-orange shadow-md scale-[1.02]' : 'bg-white hover:bg-soft-blue text-dark-navy border-brand-border shadow-2xs'}"
              data-cat="${cat.category}"
            >
              <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm ${isActive ? 'bg-white/20 text-white' : 'bg-soft-blue text-brand-blue group-hover:bg-brand-blue group-hover:text-white transition'}">
                  <i class="fa-solid ${cat.icon}"></i>
                </div>
                <span class="text-[10px] font-extrabold font-heading px-2 py-0.5 rounded-full ${isActive ? 'bg-white/25 text-white' : 'bg-warm-cream text-brand-muted border border-brand-border'}">
                  ${cat.questions.length}
                </span>
              </div>
              <div>
                <h4 class="font-heading font-bold text-xs sm:text-sm line-clamp-1 ${isActive ? 'text-white' : 'text-dark-navy'}">${cat.categoryName}</h4>
                <p class="text-[10px] mt-0.5 ${isActive ? 'text-white/80' : 'text-brand-muted'} font-sans">Explore topics</p>
              </div>
            </button>
          `;
        }).join('');

        cardsContainer.querySelectorAll('.faq-cat-card').forEach(card => {
          card.addEventListener('click', () => {
            const cat = card.getAttribute('data-cat');
            activeCategory = (activeCategory === cat) ? 'all' : cat;
            renderCategoryCards();
            renderFaqs();
          });
        });
      };

      // 2. Render FAQ Accordions
      const renderFaqs = () => {
        const query = searchInput.value.trim().toLowerCase();
        let list = [];
        let totalInCategory = 0;

        faqs.forEach(group => {
          if (activeCategory === 'all' || activeCategory === group.category) {
            group.questions.forEach(item => {
              totalInCategory++;
              if (!query || item.q.toLowerCase().includes(query) || item.a.toLowerCase().includes(query)) {
                list.push({
                  ...item,
                  categoryName: group.categoryName,
                  category: group.category,
                  icon: group.icon,
                  badgeColor: group.badgeColor || 'bg-soft-blue text-brand-blue'
                });
              }
            });
          }
        });

        if (activeCategory === 'all') {
          currentFilterBadge.textContent = 'All Topics';
          currentFilterBadge.className = 'px-3 py-1 rounded-full bg-soft-blue text-brand-blue font-bold font-heading text-xs';
        } else {
          const currentCatObj = faqs.find(f => f.category === activeCategory);
          currentFilterBadge.textContent = currentCatObj ? currentCatObj.categoryName : 'Selected Topic';
          currentFilterBadge.className = 'px-3 py-1 rounded-full bg-soft-orange text-brand-orange font-bold font-heading text-xs';
        }

        faqCountText.textContent = `Showing ${list.length} of ${totalInCategory} Questions`;

        if (list.length === 0) {
          accordionContainer.innerHTML = '';
          emptyState.classList.remove('hidden');
          return;
        } else {
          emptyState.classList.add('hidden');
        }

        accordionContainer.innerHTML = list.map((faq, idx) => `
          <div class="faq-accordion-item bg-white rounded-2xl border border-brand-border overflow-hidden transition shadow-2xs" data-index="${idx}">
            <button class="faq-accordion-header w-full p-4 sm:p-5 flex items-center justify-between text-left font-heading font-bold text-xs sm:text-sm text-dark-navy hover:text-brand-blue transition cursor-pointer select-none">
              <div class="flex items-center gap-3 min-w-0 pr-4">
                <span class="w-8 h-8 rounded-xl ${faq.badgeColor} flex items-center justify-center text-xs shrink-0 shadow-2xs border">
                  <i class="fa-solid ${faq.icon}"></i>
                </span>
                <span class="leading-snug">${faq.q}</span>
              </div>
              <div class="w-7 h-7 rounded-full bg-warm-cream flex items-center justify-center shrink-0 border border-brand-border/70">
                <i class="fa-solid fa-chevron-down faq-chevron text-xs text-brand-muted transition-transform duration-300"></i>
              </div>
            </button>
            <div class="faq-accordion-content">
              <div class="faq-accordion-inner px-5 pb-5 pt-1 text-xs sm:text-sm text-body-text font-sans leading-relaxed border-t border-brand-border/60">
                <p class="pt-3">${faq.a}</p>
                <div class="mt-4 pt-3 border-t border-brand-border/50 flex flex-wrap items-center justify-between gap-3 text-[11px] text-brand-muted">
                  <div class="flex items-center gap-1.5 font-heading">
                    <span class="font-bold text-dark-navy">Category:</span>
                    <span class="text-brand-blue font-semibold">${faq.categoryName}</span>
                  </div>
                  <div class="flex items-center gap-2">
                    <span class="font-medium">Was this helpful?</span>
                    <button class="faq-feedback-btn px-2.5 py-1 rounded-lg bg-warm-cream hover:bg-soft-mint hover:text-emerald-700 border border-brand-border transition cursor-pointer font-bold" data-vote="yes">
                      👍 Yes
                    </button>
                    <button class="faq-feedback-btn px-2.5 py-1 rounded-lg bg-warm-cream hover:bg-soft-coral hover:text-red-700 border border-brand-border transition cursor-pointer font-bold" data-vote="no">
                      👎 No
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `).join('');

        accordionContainer.querySelectorAll('.faq-accordion-header').forEach(header => {
          header.addEventListener('click', () => {
            const item = header.closest('.faq-accordion-item');
            const isActive = item.classList.contains('active');
            item.classList.toggle('active', !isActive);
          });
        });

        accordionContainer.querySelectorAll('.faq-feedback-btn').forEach(btn => {
          btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const parent = btn.parentElement;
            parent.innerHTML = `<span class="text-emerald-600 font-bold font-heading"><i class="fa-solid fa-check mr-1"></i>Thank you for your feedback!</span>`;
            Components.showToast('Thank you for helping us improve our FAQ answers!', 'success');
          });
        });
      };

      // 3. Search Bar Handlers
      const resetExpandState = () => {
        allExpanded = false;
        if (expandAllText) expandAllText.textContent = 'Expand All';
      };

      searchInput?.addEventListener('input', () => {
        const val = searchInput.value.trim();
        clearBtn.classList.toggle('hidden', val.length === 0);
        resetExpandState();
        renderFaqs();
      });

      clearBtn?.addEventListener('click', () => {
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        resetExpandState();
        renderFaqs();
      });

      resetSearchBtn?.addEventListener('click', () => {
        searchInput.value = '';
        activeCategory = 'all';
        clearBtn.classList.add('hidden');
        resetExpandState();
        renderCategoryCards();
        renderFaqs();
      });

      showAllBtn?.addEventListener('click', () => {
        activeCategory = 'all';
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        resetExpandState();
        renderCategoryCards();
        renderFaqs();
      });

      document.querySelectorAll('.quick-search-chip').forEach(chip => {
        chip.addEventListener('click', () => {
          const query = chip.getAttribute('data-query');
          searchInput.value = query;
          clearBtn.classList.remove('hidden');
          activeCategory = 'all';
          resetExpandState();
          renderCategoryCards();
          renderFaqs();
        });
      });

      expandAllBtn?.addEventListener('click', () => {
        allExpanded = !allExpanded;
        expandAllText.textContent = allExpanded ? 'Collapse All' : 'Expand All';
        accordionContainer.querySelectorAll('.faq-accordion-item').forEach(item => {
          item.classList.toggle('active', allExpanded);
        });
      });

      // Initial Render
      renderCategoryCards();
      renderFaqs();
    });
  </script>
@endpush