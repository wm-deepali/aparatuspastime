@extends('layouts.app')

@section('title', 'FAQ & Help Center | Aparatus - Sports Goods & Toys')
@section('meta_description', 'Find instant answers to common questions about Aparatus sports goods, toys, delivery speeds, safety testing, and 7-day returns.')
@section('active_nav', 'faq')

@push('styles')
  <style>
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

  @php
    // Badge colour per category (full class names so Tailwind can see them)
    $faqColors = [
      'blue' => 'bg-soft-blue text-brand-blue border-brand-blue/20',
      'orange' => 'bg-soft-orange text-brand-orange border-brand-orange/20',
      'purple' => 'bg-soft-purple text-purple-700 border-purple-200',
      'rose' => 'bg-rose-100 text-rose-700 border-rose-200',
      'mint' => 'bg-soft-mint text-emerald-700 border-emerald-200',
      'yellow' => 'bg-soft-yellow text-amber-800 border-amber-200',
    ];

    $contact = $contact ?? [];
    $totalFaqs = $categories->sum(fn($c) => $c->faqs->count());
  @endphp

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

      <!-- HERO SECTION -->
      <section
        class="bg-gradient-to-br from-brand-navy via-brand-blue to-dark-navy text-white rounded-3xl sm:rounded-[32px] p-8 sm:p-12 lg:p-16 relative overflow-hidden shadow-xl">
        <div class="absolute -top-16 -right-16 w-80 h-80 bg-brand-orange/30 rounded-full blur-3xl pointer-events-none">
        </div>
        <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-play-yellow/20 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="max-w-3xl mx-auto text-center relative z-10 space-y-4">
          <span
            class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-md px-4 py-1.5 rounded-full text-play-yellow text-xs font-bold font-heading border border-white/20 shadow-xs uppercase tracking-wider">
            <i class="fa-solid fa-headset text-brand-orange"></i>
            <span>Aparatus Help Desk</span>
          </span>

          <h1
            class="text-3xl sm:text-4xl md:text-5xl font-extrabold font-heading text-white leading-tight tracking-tight">
            FREQUENTLY ASKED QUESTIONS
          </h1>

          <p class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed max-w-xl mx-auto">
            Got questions about sports gear, toys, dispatch speeds, or returns? Search instant answers or explore by
            category below.
          </p>

          @if ($totalFaqs > 0)
            <div class="pt-4 max-w-2xl mx-auto">
              <div
                class="relative bg-white/95 backdrop-blur-md rounded-2xl p-1.5 shadow-2xl border border-white/40 flex items-center gap-2">
                <div
                  class="w-10 h-10 rounded-xl bg-soft-blue text-brand-blue flex items-center justify-center text-base shrink-0 ml-1">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" id="faq-search-input"
                  placeholder="Search topics (e.g. shipping, return, safety, payment)..."
                  class="w-full py-2.5 pr-4 text-xs sm:text-sm text-dark-navy placeholder:text-brand-muted bg-transparent focus:outline-none font-sans font-medium">
                <button id="faq-clear-btn"
                  class="hidden px-3 py-1.5 text-xs text-brand-muted hover:text-dark-navy font-bold font-heading transition">
                  Clear
                </button>
              </div>

              <!-- Quick category chips -->
              @if ($categories->count() > 1)
                <div
                  class="flex flex-wrap items-center justify-center gap-2 pt-3 text-[11px] font-heading font-semibold text-white/90">
                  <span class="text-white/60">Browse:</span>
                  @foreach ($categories->take(4) as $c)
                    <button type="button"
                      class="quick-cat-chip px-3 py-1 rounded-full bg-white/10 hover:bg-white/25 backdrop-blur-sm border border-white/20 transition cursor-pointer"
                      data-cat="{{ $c->slug }}">
                      @if ($c->icon)<i class="fa-solid {{ $c->icon }} mr-1 text-[10px]"></i>@endif{{ $c->name }}
                    </button>
                  @endforeach
                </div>
              @endif
            </div>
          @endif
        </div>
      </section>

      @if ($totalFaqs === 0)
        <div class="bg-white rounded-3xl border border-brand-border p-10 text-center shadow-xs">
          <h3 class="font-heading font-bold text-lg text-dark-navy">Help articles are coming soon</h3>
          <p class="text-xs sm:text-sm text-body-text max-w-md mx-auto font-sans mt-2">
            In the meantime, please reach out to our team directly.
          </p>
          <a href="{{ route('contact') }}"
            class="btn-play-orange inline-block text-xs px-5 py-2.5 rounded-xl font-heading font-bold shadow-xs mt-4">
            Contact Us
          </a>
        </div>
      @else

        <!-- CATEGORY SELECTOR CARDS -->
        <section class="space-y-4">
          <div class="flex items-center justify-between">
            <h2 class="text-lg sm:text-xl font-bold font-heading text-dark-navy flex items-center gap-2">
              <i class="fa-solid fa-shapes text-brand-orange"></i>
              <span>Browse By Category</span>
            </h2>
            <button id="show-all-cats-btn"
              class="text-xs font-bold font-heading text-brand-blue hover:text-brand-orange transition cursor-pointer">
              View All Questions →
            </button>
          </div>

          <div id="faq-category-cards" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach ($categories as $c)
              <button type="button" data-cat="{{ $c->slug }}"
                class="faq-cat-card p-4 rounded-2xl border text-left transition duration-200 cursor-pointer flex flex-col justify-between group bg-white hover:bg-soft-blue text-dark-navy border-brand-border shadow-2xs">
                <div class="flex items-center justify-between mb-3">
                  <div
                    class="cat-icon w-9 h-9 rounded-xl flex items-center justify-center text-sm bg-soft-blue text-brand-blue group-hover:bg-brand-blue group-hover:text-white transition">
                    <i class="fa-solid {{ $c->icon ?: 'fa-circle-question' }}"></i>
                  </div>
                  <span
                    class="cat-count text-[10px] font-extrabold font-heading px-2 py-0.5 rounded-full bg-warm-cream text-brand-muted border border-brand-border">
                    {{ $c->faqs->count() }}
                  </span>
                </div>
                <div>
                  <h4 class="cat-name font-heading font-bold text-xs sm:text-sm line-clamp-1 text-dark-navy">{{ $c->name }}
                  </h4>
                  <p class="cat-sub text-[10px] mt-0.5 text-brand-muted font-sans">Explore topics</p>
                </div>
              </button>
            @endforeach
          </div>
        </section>

        <!-- MAIN 2-COLUMN LAYOUT -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

          <!-- LEFT: FAQ ACCORDION -->
          <div class="lg:col-span-8 space-y-6">

            <div
              class="bg-white rounded-2xl border border-brand-border p-4 flex flex-wrap items-center justify-between gap-3 shadow-2xs">
              <div class="flex items-center gap-2.5">
                <span id="current-filter-badge"
                  class="px-3 py-1 rounded-full bg-soft-blue text-brand-blue font-bold font-heading text-xs">
                  All Topics
                </span>
                <span id="faq-count-text" class="text-xs text-brand-muted font-sans font-medium">
                  Showing {{ $totalFaqs }} Questions
                </span>
              </div>

              <button id="expand-all-btn"
                class="px-3 py-1 rounded-xl bg-warm-cream hover:bg-soft-blue text-dark-navy border border-brand-border text-xs font-bold font-heading transition cursor-pointer shadow-2xs">
                <i class="fa-solid fa-arrows-up-down mr-1 text-[10px]"></i>
                <span id="expand-all-text">Expand All</span>
              </button>
            </div>

            <div id="faq-accordion-container" class="space-y-3.5">
              @foreach ($categories as $c)
                @foreach ($c->faqs as $faq)
                  <div
                    class="faq-accordion-item bg-white rounded-2xl border border-brand-border overflow-hidden transition shadow-2xs"
                    data-cat="{{ $c->slug }}"
                    data-text="{{ \Illuminate\Support\Str::lower($faq->question . ' ' . strip_tags($faq->answer)) }}">
                    <button type="button"
                      class="faq-accordion-header w-full p-4 sm:p-5 flex items-center justify-between text-left font-heading font-bold text-xs sm:text-sm text-dark-navy hover:text-brand-blue transition cursor-pointer select-none">
                      <div class="flex items-center gap-3 min-w-0 pr-4">
                        <span
                          class="w-8 h-8 rounded-xl {{ $faqColors[$c->color] ?? $faqColors['blue'] }} flex items-center justify-center text-xs shrink-0 shadow-2xs border">
                          <i class="fa-solid {{ $c->icon ?: 'fa-circle-question' }}"></i>
                        </span>
                        <span class="leading-snug">{{ $faq->question }}</span>
                      </div>
                      <div
                        class="w-7 h-7 rounded-full bg-warm-cream flex items-center justify-center shrink-0 border border-brand-border/70">
                        <i
                          class="fa-solid fa-chevron-down faq-chevron text-xs text-brand-muted transition-transform duration-300"></i>
                      </div>
                    </button>
                    <div class="faq-accordion-content">
                      <div
                        class="faq-accordion-inner px-5 pb-5 pt-1 text-xs sm:text-sm text-body-text font-sans leading-relaxed border-t border-brand-border/60">
                        <p class="pt-3">{!! nl2br(e($faq->answer)) !!}</p>
                        <div
                          class="mt-4 pt-3 border-t border-brand-border/50 flex flex-wrap items-center justify-between gap-3 text-[11px] text-brand-muted">
                          <div class="flex items-center gap-1.5 font-heading">
                            <span class="font-bold text-dark-navy">Category:</span>
                            <span class="text-brand-blue font-semibold">{{ $c->name }}</span>
                          </div>
                          <div class="faq-feedback flex items-center gap-2">
                            <span class="font-medium">Was this helpful?</span>
                            <button type="button"
                              class="faq-feedback-btn px-2.5 py-1 rounded-lg bg-warm-cream hover:bg-soft-mint hover:text-emerald-700 border border-brand-border transition cursor-pointer font-bold">👍
                              Yes</button>
                            <button type="button"
                              class="faq-feedback-btn px-2.5 py-1 rounded-lg bg-warm-cream hover:bg-soft-coral hover:text-red-700 border border-brand-border transition cursor-pointer font-bold">👎
                              No</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              @endforeach
            </div>

            <!-- EMPTY SEARCH STATE -->
            <div id="faq-empty-state"
              class="hidden bg-white rounded-3xl border border-brand-border p-10 text-center space-y-4 shadow-xs">
              <div
                class="w-16 h-16 rounded-2xl bg-soft-orange text-brand-orange flex items-center justify-center text-2xl mx-auto shadow-inner">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
              <h3 class="font-heading font-bold text-lg text-dark-navy">No Answers Found</h3>
              <p class="text-xs sm:text-sm text-body-text max-w-md mx-auto font-sans">
                We couldn't find any questions matching your search. Try different keywords or contact our team directly.
              </p>
              <button id="reset-search-btn"
                class="btn-play-orange text-xs px-5 py-2.5 rounded-xl font-heading font-bold shadow-xs">
                Reset Search Filter
              </button>
            </div>

          </div>

          <!-- RIGHT: SIDEBAR -->
          <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

            <!-- Help channels (each hidden when not configured) -->
            @if (!empty($contact['whatsapp']) || !empty($contact['phone']) || !empty($contact['email']))
              <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-brand-border">
                  <div
                    class="w-10 h-10 rounded-2xl bg-soft-orange text-brand-orange flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-comments"></i>
                  </div>
                  <div>
                    <h3 class="font-heading font-bold text-sm sm:text-base text-dark-navy leading-tight">Need Quick
                      Assistance?</h3>
                    <p class="text-[11px] text-brand-muted font-sans">Our support team is here to help</p>
                  </div>
                </div>

                @if (!empty($contact['whatsapp']))
                  <a href="https://api.whatsapp.com/send?phone={{ $contact['whatsapp'] }}&text={{ rawurlencode('Hi Aparatus Team, I have a question regarding an order.') }}"
                    target="_blank" rel="noopener"
                    class="w-full p-3.5 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 flex items-center justify-between text-emerald-800 transition group shadow-2xs">
                    <div class="flex items-center gap-3">
                      <div
                        class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-lg group-hover:scale-110 transition shadow-xs">
                        <i class="fa-brands fa-whatsapp"></i>
                      </div>
                      <div>
                        <div class="text-xs font-bold font-heading">Chat on WhatsApp</div>
                        <div class="text-[10px] text-emerald-600 font-sans">Instant live reply</div>
                      </div>
                    </div>
                    <i class="fa-solid fa-arrow-right text-xs text-emerald-600 group-hover:translate-x-1 transition"></i>
                  </a>
                @endif

                @if (!empty($contact['phone']))
                  <a href="tel:{{ $contact['phone'] }}"
                    class="w-full p-3.5 rounded-2xl bg-soft-blue hover:bg-blue-100 border border-blue-200 flex items-center justify-between text-brand-navy transition group shadow-2xs">
                    <div class="flex items-center gap-3">
                      <div
                        class="w-9 h-9 rounded-xl bg-brand-blue text-white flex items-center justify-center text-sm group-hover:scale-110 transition shadow-xs">
                        <i class="fa-solid fa-phone"></i>
                      </div>
                      <div>
                        <div class="text-xs font-bold font-heading">{{ $contact['phone_display'] ?: $contact['phone'] }}</div>
                        @if (!empty($contact['hours']))
                          <div class="text-[10px] text-brand-muted font-sans">{{ $contact['hours'] }}</div>
                        @endif
                      </div>
                    </div>
                    <i class="fa-solid fa-arrow-right text-xs text-brand-blue group-hover:translate-x-1 transition"></i>
                  </a>
                @endif

                @if (!empty($contact['email']))
                  <a href="mailto:{{ $contact['email'] }}"
                    class="w-full p-3.5 rounded-2xl bg-warm-cream hover:bg-soft-yellow border border-brand-border flex items-center justify-between text-dark-navy transition group shadow-2xs">
                    <div class="flex items-center gap-3">
                      <div
                        class="w-9 h-9 rounded-xl bg-brand-orange text-white flex items-center justify-center text-sm group-hover:scale-110 transition shadow-xs">
                        <i class="fa-regular fa-envelope"></i>
                      </div>
                      <div>
                        <div class="text-xs font-bold font-heading">{{ $contact['email'] }}</div>
                        <div class="text-[10px] text-brand-muted font-sans">Official email ticketing</div>
                      </div>
                    </div>
                    <i class="fa-solid fa-arrow-right text-xs text-brand-orange group-hover:translate-x-1 transition"></i>
                  </a>
                @endif
              </div>
            @endif

            <!-- Self-service shortcuts -->
            <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-3">
              <h3 class="font-heading font-bold text-sm text-dark-navy pb-2 border-b border-brand-border">
                Quick Self-Service Tools
              </h3>
              <div class="space-y-2 font-heading text-xs">
                <a href="{{ route('user.track-order') }}"
                  class="p-2.5 rounded-xl bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-navy flex items-center justify-between transition group">
                  <span class="flex items-center gap-2 font-bold">
                    <i class="fa-solid fa-truck text-brand-blue group-hover:text-white"></i>
                    <span>Track Live Order</span>
                  </span>
                  <i class="fa-solid fa-chevron-right text-[10px] text-brand-muted group-hover:text-white"></i>
                </a>
                <a href="{{ route('contact') }}"
                  class="p-2.5 rounded-xl bg-soft-orange hover:bg-brand-orange hover:text-white text-dark-navy flex items-center justify-between transition group">
                  <span class="flex items-center gap-2 font-bold">
                    <i class="fa-solid fa-paper-plane text-brand-orange group-hover:text-white"></i>
                    <span>Submit Support Ticket</span>
                  </span>
                  <i class="fa-solid fa-chevron-right text-[10px] text-brand-muted group-hover:text-white"></i>
                </a>
                <a href="{{ route('returns') }}"
                  class="p-2.5 rounded-xl bg-soft-mint hover:bg-emerald-600 hover:text-white text-emerald-800 flex items-center justify-between transition group">
                  <span class="flex items-center gap-2 font-bold">
                    <i class="fa-solid fa-rotate-left text-emerald-600 group-hover:text-white"></i>
                    <span>Return Policy</span>
                  </span>
                  <i class="fa-solid fa-chevron-right text-[10px] text-brand-muted group-hover:text-white"></i>
                </a>
              </div>
            </div>

            <!-- SIDEBAR CARD 3: APARATUS TRUST BADGES -->
            <div
              class="bg-gradient-to-br from-soft-blue via-soft-yellow/20 to-soft-mint/30 rounded-3xl border border-brand-border p-6 space-y-3.5">
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

      @endif

    </div>
  </div>

  {{-- FAQ structured data for Google --}}
  @if ($totalFaqs > 0)
    @php
      $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $categories->flatMap(fn($c) => $c->faqs)->map(fn($f) => [
          '@type' => 'Question',
          'name' => $f->question,
          'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f->answer)],
        ])->values()->all(),
      ];
    @endphp
    <script
      type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
  @endif
@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const items = [...document.querySelectorAll('.faq-accordion-item')];
      if (!items.length) return;

      const catCards = [...document.querySelectorAll('.faq-cat-card')];
      const searchInput = document.getElementById('faq-search-input');
      const clearBtn = document.getElementById('faq-clear-btn');
      const emptyState = document.getElementById('faq-empty-state');
      const filterBadge = document.getElementById('current-filter-badge');
      const countText = document.getElementById('faq-count-text');
      const expandBtn = document.getElementById('expand-all-btn');
      const expandText = document.getElementById('expand-all-text');

      const total = items.length;
      let activeCat = 'all';
      let allExpanded = false;

      const cardOn = 'faq-cat-card p-4 rounded-2xl border text-left transition duration-200 cursor-pointer flex flex-col justify-between group bg-brand-orange text-white border-brand-orange shadow-md scale-[1.02]';
      const cardOff = 'faq-cat-card p-4 rounded-2xl border text-left transition duration-200 cursor-pointer flex flex-col justify-between group bg-white hover:bg-soft-blue text-dark-navy border-brand-border shadow-2xs';

      const paintCards = () => {
        catCards.forEach(card => {
          const on = card.dataset.cat === activeCat;
          card.className = on ? cardOn : cardOff;
          card.querySelector('.cat-icon').className = 'cat-icon w-9 h-9 rounded-xl flex items-center justify-center text-sm ' +
            (on ? 'bg-white/20 text-white' : 'bg-soft-blue text-brand-blue group-hover:bg-brand-blue group-hover:text-white transition');
          card.querySelector('.cat-count').className = 'cat-count text-[10px] font-extrabold font-heading px-2 py-0.5 rounded-full ' +
            (on ? 'bg-white/25 text-white' : 'bg-warm-cream text-brand-muted border border-brand-border');
          card.querySelector('.cat-name').className = 'cat-name font-heading font-bold text-xs sm:text-sm line-clamp-1 ' + (on ? 'text-white' : 'text-dark-navy');
          card.querySelector('.cat-sub').className = 'cat-sub text-[10px] mt-0.5 font-sans ' + (on ? 'text-white/80' : 'text-brand-muted');
        });
      };

      const resetExpand = () => {
        allExpanded = false;
        expandText.textContent = 'Expand All';
      };

      const apply = () => {
        const q = (searchInput?.value || '').trim().toLowerCase();
        let shown = 0;
        let inCat = 0;

        items.forEach(it => {
          const catOk = activeCat === 'all' || it.dataset.cat === activeCat;
          if (catOk) inCat++;
          const match = catOk && (!q || it.dataset.text.includes(q));
          it.classList.toggle('hidden', !match);
          if (match) shown++;
        });

        if (activeCat === 'all') {
          filterBadge.textContent = 'All Topics';
          filterBadge.className = 'px-3 py-1 rounded-full bg-soft-blue text-brand-blue font-bold font-heading text-xs';
        } else {
          const card = catCards.find(c => c.dataset.cat === activeCat);
          filterBadge.textContent = card ? card.querySelector('.cat-name').textContent.trim() : 'Selected Topic';
          filterBadge.className = 'px-3 py-1 rounded-full bg-soft-orange text-brand-orange font-bold font-heading text-xs';
        }

        countText.textContent = `Showing ${shown} of ${inCat} Questions`;
        emptyState.classList.toggle('hidden', shown > 0);
        paintCards();
      };

      const setCat = (cat) => {
        activeCat = (activeCat === cat) ? 'all' : cat;
        resetExpand();
        apply();
      };

      const resetAll = () => {
        activeCat = 'all';
        if (searchInput) searchInput.value = '';
        clearBtn?.classList.add('hidden');
        resetExpand();
        apply();
      };

      catCards.forEach(card => card.addEventListener('click', () => setCat(card.dataset.cat)));

      document.querySelectorAll('.quick-cat-chip').forEach(chip => {
        chip.addEventListener('click', () => {
          activeCat = chip.dataset.cat;
          resetExpand();
          apply();
          document.getElementById('faq-accordion-container')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
      });

      searchInput?.addEventListener('input', () => {
        clearBtn.classList.toggle('hidden', searchInput.value.trim().length === 0);
        resetExpand();
        apply();
      });

      clearBtn?.addEventListener('click', () => {
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        resetExpand();
        apply();
      });

      document.getElementById('reset-search-btn')?.addEventListener('click', resetAll);
      document.getElementById('show-all-cats-btn')?.addEventListener('click', resetAll);

      // Accordion open / close
      items.forEach(it => {
        it.querySelector('.faq-accordion-header').addEventListener('click', () => it.classList.toggle('active'));
      });

      // Expand / collapse all (visible items only)
      expandBtn?.addEventListener('click', () => {
        allExpanded = !allExpanded;
        expandText.textContent = allExpanded ? 'Collapse All' : 'Expand All';
        items.forEach(it => {
          if (!it.classList.contains('hidden')) it.classList.toggle('active', allExpanded);
        });
      });

      // Feedback
      document.querySelectorAll('.faq-feedback-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          btn.parentElement.innerHTML = '<span class="text-emerald-600 font-bold font-heading"><i class="fa-solid fa-check mr-1"></i>Thank you for your feedback!</span>';
          Components.showToast('Thank you for helping us improve our FAQ answers!', 'success');
        });
      });

      apply();
    });
  </script>
@endpush