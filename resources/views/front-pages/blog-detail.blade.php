@extends('layouts.app')

@section('title', 'Blog Article | Aparatus Pastime')
@section('active_nav', 'home')

@section('content')

  <!-- READING SCROLL PROGRESS BAR -->
  <div id="reading-progress-bar" class="fixed top-0 left-0 h-1 bg-gradient-to-r from-brand-orange via-play-yellow to-brand-blue z-50 transition-all duration-100" style="width: 0%;"></div>

  <!-- MAIN BLOG DETAILS FULL-WIDTH CONTAINER -->
  <div class="py-6 sm:py-8 lg:py-10">
    <div class="w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

      <!-- TOP BREADCRUMB & UTILITY BAR -->
      <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-brand-border text-xs font-heading">
        <nav class="flex items-center gap-2 text-brand-muted flex-wrap">
          <a href="{{ route('home') }}" class="hover:text-brand-orange transition flex items-center gap-1.5 font-bold">
            <i class="fa-solid fa-house text-xs"></i>
            <span>Home</span>
          </a>
          <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
          <a href="{{ route('blogs') }}" class="hover:text-brand-orange transition font-bold">The Playroom Stories</a>
          <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
          <span id="blog-breadcrumb-cat" class="text-brand-blue font-bold">Category</span>
          <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
          <span id="blog-breadcrumb-title" class="text-dark-navy font-bold truncate max-w-[200px] sm:max-w-md">Article</span>
        </nav>

        <div class="flex items-center gap-3">
          <a href="{{ route('blogs') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-orange hover:text-brand-navy transition bg-soft-orange px-3 py-1.5 rounded-full border border-brand-orange/20">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>All Playroom Stories</span>
          </a>
        </div>
      </div>

      <!-- MAIN 2-COLUMN FULL-WIDTH GRID (ARTICLE + STICKY SIDEBAR) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT / MAIN ARTICLE COLUMN (8 COLS) -->
        <div class="lg:col-span-8 space-y-8">

          <article class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 md:p-12 shadow-xs space-y-8 relative overflow-hidden">
            <!-- Decorative playful blobs -->
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-soft-yellow rounded-full -z-0 opacity-70 pointer-events-none blur-xl"></div>
            <div class="absolute top-1/2 -left-20 w-40 h-40 bg-soft-blue rounded-full -z-0 opacity-70 pointer-events-none blur-xl"></div>

            <!-- HEADER META -->
            <div class="space-y-4 relative z-10">
              <div class="flex flex-wrap items-center gap-2.5">
                <span id="blog-category-tag" class="inline-flex items-center gap-1.5 bg-soft-orange text-brand-orange text-xs font-bold font-heading px-4 py-1.5 rounded-full border border-brand-orange/20 uppercase tracking-wider shadow-2xs">
                  <i class="fa-solid fa-shapes text-xs"></i>
                  <span>GAMES & PLAY</span>
                </span>
                <span id="blog-views-tag" class="inline-flex items-center gap-1.5 bg-soft-blue text-brand-blue text-xs font-bold font-heading px-3.5 py-1.5 rounded-full border border-brand-blue/20">
                  <i class="fa-solid fa-eye text-[11px]"></i>
                  <span id="blog-views-count">1.4k reads</span>
                </span>
              </div>

              <h1 id="blog-title" class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold font-heading text-brand-navy leading-snug tracking-tight">
                Loading Play Story...
              </h1>

              <!-- AUTHOR & DATE ROW -->
              <div class="flex flex-wrap items-center justify-between gap-4 pt-3 pb-4 border-b border-brand-border/70">
                <div class="flex items-center gap-3.5">
                  <img id="blog-author-avatar" src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80" alt="Author" class="w-12 h-12 rounded-full object-cover border-2 border-brand-orange shadow-xs">
                  <div>
                    <div class="flex items-center gap-1.5">
                      <span id="blog-author" class="font-bold text-sm sm:text-base text-dark-navy font-heading">Dr. Alisha Sen</span>
                      <i class="fa-solid fa-circle-check text-brand-blue text-xs" title="Verified Play Specialist"></i>
                    </div>
                    <p id="blog-author-role" class="text-xs text-brand-muted font-sans font-medium">Child Development & Play Specialist</p>
                  </div>
                </div>

                <div class="flex items-center gap-3 text-xs text-brand-muted font-sans font-semibold">
                  <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-brand-orange"></i> <span id="blog-date">March 15, 2026</span></span>
                  <span>•</span>
                  <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-brand-blue"></i> <span id="blog-read-time">4 min read</span></span>
                </div>
              </div>
            </div>

            <!-- HERO BANNER IMAGE (FULL WIDTH OF ARTICLE CARD) -->
            <div class="rounded-2xl sm:rounded-3xl overflow-hidden aspect-16/9 bg-soft-blue shadow-inner border border-brand-border relative group">
              <img id="blog-hero-image" src="" alt="Article Banner" class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-500 ease-out">
              <div class="absolute bottom-3 right-3 bg-dark-navy/80 backdrop-blur-md text-white text-[11px] font-heading font-medium px-3 py-1 rounded-full flex items-center gap-1.5">
                <i class="fa-solid fa-camera text-play-yellow"></i>
                <span>Aparatus Playroom Studio</span>
              </div>
            </div>

            <!-- KEY TAKEAWAYS CALLOUT BOX -->
            <div id="blog-takeaways-box" class="bg-gradient-to-r from-soft-blue via-soft-yellow/25 to-soft-mint/30 rounded-2xl p-5 sm:p-7 border border-brand-border relative">
              <div class="flex items-center gap-2.5 text-xs font-bold uppercase tracking-wider text-brand-navy font-heading mb-3">
                <span class="w-6 h-6 rounded-full bg-brand-orange text-white flex items-center justify-center text-xs shadow-2xs">
                  <i class="fa-solid fa-sparkles"></i>
                </span>
                <span>KEY TAKEAWAYS FOR PARENTS</span>
              </div>
              <ul id="blog-takeaways-list" class="space-y-2.5 text-xs sm:text-sm text-dark-navy font-sans leading-relaxed">
                <!-- Injected via JavaScript -->
              </ul>
            </div>

            <!-- ARTICLE BODY CONTENT (FULL WIDTH) -->
            <div id="blog-content-body" class="w-full text-base sm:text-lg text-body-text font-body leading-relaxed space-y-6">
              <!-- Injected via JavaScript -->
            </div>

            <!-- INTERACTIVE REACTIONS BAR -->
            <div class="p-5 sm:p-6 bg-warm-cream rounded-2xl border border-brand-border/80 flex flex-col sm:flex-row items-center justify-between gap-4">
              <div>
                <h4 class="font-heading font-bold text-dark-navy text-sm sm:text-base">Did this inspire your playtime?</h4>
                <p class="text-xs text-brand-muted font-sans">Tap a reaction below to let our editorial team know!</p>
              </div>
              <div class="flex items-center gap-2 flex-wrap">
                <button id="reaction-helpful" class="reaction-btn px-4 py-2 rounded-xl bg-white border border-brand-border hover:border-brand-orange hover:bg-soft-orange text-dark-navy text-xs font-bold font-heading flex items-center gap-2 transition cursor-pointer shadow-2xs">
                  <span>❤️</span> <span>Helpful</span> <span id="count-helpful" class="text-brand-orange font-bold">48</span>
                </button>
                <button id="reaction-idea" class="reaction-btn px-4 py-2 rounded-xl bg-white border border-brand-border hover:border-brand-blue hover:bg-soft-blue text-dark-navy text-xs font-bold font-heading flex items-center gap-2 transition cursor-pointer shadow-2xs">
                  <span>💡</span> <span>Great Idea</span> <span id="count-idea" class="text-brand-blue font-bold">32</span>
                </button>
                <button id="reaction-try" class="reaction-btn px-4 py-2 rounded-xl bg-white border border-brand-border hover:border-emerald-500 hover:bg-soft-mint text-dark-navy text-xs font-bold font-heading flex items-center gap-2 transition cursor-pointer shadow-2xs">
                  <span>🎉</span> <span>Will Try</span> <span id="count-try" class="text-emerald-600 font-bold">65</span>
                </button>
              </div>
            </div>

            <!-- ARTICLE TAGS -->
            <div class="flex flex-wrap items-center gap-2 pt-2">
              <span class="text-xs font-bold text-brand-muted font-heading uppercase mr-1">Tags:</span>
              <div id="blog-tags-container" class="flex flex-wrap gap-2">
                <!-- Injected via JavaScript -->
              </div>
            </div>

            <!-- SOCIAL SHARE BUTTONS -->
            <div class="pt-6 border-t border-brand-border flex flex-col sm:flex-row items-center justify-between gap-4">
              <span class="text-xs font-bold font-heading text-brand-navy uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-share-nodes text-brand-orange"></i>
                SHARE THIS PLAYROOM STORY
              </span>
              <div class="flex items-center gap-2.5">
                <button id="share-x-btn" class="w-10 h-10 rounded-full bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-blue flex items-center justify-center transition shadow-2xs cursor-pointer" title="Share on X">
                  <i class="fa-brands fa-x-twitter"></i>
                </button>
                <button id="share-fb-btn" class="w-10 h-10 rounded-full bg-soft-blue hover:bg-brand-navy hover:text-white text-brand-navy flex items-center justify-center transition shadow-2xs cursor-pointer" title="Share on Facebook">
                  <i class="fa-brands fa-facebook"></i>
                </button>
                <button id="share-wa-btn" class="w-10 h-10 rounded-full bg-soft-mint hover:bg-emerald-600 hover:text-white text-emerald-700 flex items-center justify-center transition shadow-2xs cursor-pointer" title="Share on WhatsApp">
                  <i class="fa-brands fa-whatsapp text-base"></i>
                </button>
                <button id="share-copy-btn" class="px-3.5 py-2 rounded-full bg-soft-orange hover:bg-brand-orange hover:text-white text-brand-orange flex items-center gap-1.5 transition shadow-2xs cursor-pointer text-xs font-bold font-heading" title="Copy Link">
                  <i class="fa-solid fa-link text-xs"></i>
                  <span>Copy Link</span>
                </button>
              </div>
            </div>

            <!-- AUTHOR BIO CARD -->
            <div class="bg-warm-cream rounded-2xl p-6 border border-brand-border flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
              <img id="bio-avatar" src="" alt="Author Bio" class="w-20 h-20 rounded-2xl object-cover border-2 border-brand-orange shadow-sm shrink-0">
              <div class="space-y-2">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                  <div>
                    <h3 id="bio-author-name" class="text-base font-bold font-heading text-dark-navy">Author Name</h3>
                    <p id="bio-author-role" class="text-xs text-brand-orange font-heading font-semibold">Specialist</p>
                  </div>
                  <span class="inline-block bg-white px-3 py-1 rounded-full text-[11px] font-bold font-heading text-brand-blue border border-brand-border">
                    <i class="fa-solid fa-award mr-1 text-play-yellow"></i> Aparatus Editorial Contributor
                  </span>
                </div>
                <p id="bio-author-desc" class="text-xs sm:text-sm text-body-text leading-relaxed font-sans">
                  Author biography details.
                </p>
              </div>
            </div>

            <!-- PREVIOUS / NEXT STORY NAVIGATOR -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-brand-border">
              <div id="prev-article-card" class="p-4 rounded-2xl bg-white hover:bg-soft-blue/50 border border-brand-border transition group flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-soft-blue text-brand-blue flex items-center justify-center shrink-0 group-hover:bg-brand-blue group-hover:text-white transition">
                  <i class="fa-solid fa-arrow-left text-sm"></i>
                </div>
                <div class="overflow-hidden">
                  <span class="text-[10px] uppercase font-bold tracking-wider text-brand-muted font-heading block">Previous Story</span>
                  <a id="prev-article-link" href="#" class="text-xs sm:text-sm font-bold font-heading text-dark-navy group-hover:text-brand-orange transition truncate block">Title</a>
                </div>
              </div>

              <div id="next-article-card" class="p-4 rounded-2xl bg-white hover:bg-soft-orange/50 border border-brand-border transition group flex items-center justify-between gap-3.5 text-right sm:flex-row-reverse">
                <div class="w-10 h-10 rounded-xl bg-soft-orange text-brand-orange flex items-center justify-center shrink-0 group-hover:bg-brand-orange group-hover:text-white transition">
                  <i class="fa-solid fa-arrow-right text-sm"></i>
                </div>
                <div class="overflow-hidden">
                  <span class="text-[10px] uppercase font-bold tracking-wider text-brand-muted font-heading block">Next Story</span>
                  <a id="next-article-link" href="#" class="text-xs sm:text-sm font-bold font-heading text-dark-navy group-hover:text-brand-orange transition truncate block">Title</a>
                </div>
              </div>
            </div>

          </article>
        </div>

        <!-- RIGHT COLUMN / STICKY SIDEBAR (4 COLS) -->
        <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

          <!-- SIDEBAR WIDGET 1: FEATURED TOYS MENTIONED IN STORY -->
          <div class="bg-white rounded-3xl border border-brand-border p-5 sm:p-6 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-brand-border">
              <h3 class="font-heading font-bold text-sm sm:text-base text-brand-navy flex items-center gap-2">
                <i class="fa-solid fa-basket-shopping text-brand-orange"></i>
                <span>Toys In This Article</span>
              </h3>
              <a href="{{ route('shop') }}" class="text-[11px] font-bold font-heading text-brand-blue hover:text-brand-orange transition">View All →</a>
            </div>

            <div id="sidebar-products-list" class="space-y-3">
              <!-- Injected via JavaScript -->
            </div>
          </div>

          <!-- SIDEBAR WIDGET 2: TRENDING PLAYROOM STORIES -->
          <div class="bg-white rounded-3xl border border-brand-border p-5 sm:p-6 shadow-xs space-y-4">
            <h3 class="font-heading font-bold text-sm sm:text-base text-brand-navy flex items-center gap-2 pb-3 border-b border-brand-border">
              <i class="fa-solid fa-fire text-brand-bright-orange"></i>
              <span>Trending Playroom Stories</span>
            </h3>

            <div id="sidebar-trending-list" class="space-y-3.5">
              <!-- Injected via JavaScript -->
            </div>
          </div>

          <!-- SIDEBAR WIDGET 3: EXPLORE TOPICS -->
          <div class="bg-white rounded-3xl border border-brand-border p-5 sm:p-6 shadow-xs space-y-3">
            <h3 class="font-heading font-bold text-sm text-brand-navy pb-2 border-b border-brand-border">
              Explore Playroom Topics
            </h3>
            <div class="flex flex-wrap gap-2 pt-1 font-heading text-xs">
              <a href="{{ route('blogs', ['cat' => 'games']) }}" class="px-3 py-1.5 rounded-xl bg-soft-blue text-brand-blue font-bold hover:bg-brand-blue hover:text-white transition shadow-2xs">🎯 Indoor Games</a>
              <a href="{{ route('blogs', ['cat' => 'sports']) }}" class="px-3 py-1.5 rounded-xl bg-soft-orange text-brand-orange font-bold hover:bg-brand-orange hover:text-white transition shadow-2xs">🏃 Outdoor Sports</a>
              <a href="{{ route('blogs', ['cat' => 'guides']) }}" class="px-3 py-1.5 rounded-xl bg-soft-mint text-emerald-700 font-bold hover:bg-emerald-600 hover:text-white transition shadow-2xs">📖 Buying Guides</a>
              <a href="{{ route('shop', ['category' => 'stem']) }}" class="px-3 py-1.5 rounded-xl bg-soft-purple text-purple-700 font-bold hover:bg-purple-600 hover:text-white transition shadow-2xs">🔬 STEM & Science</a>
              <a href="{{ route('shop', ['category' => 'wooden']) }}" class="px-3 py-1.5 rounded-xl bg-soft-yellow text-amber-800 font-bold hover:bg-amber-600 hover:text-white transition shadow-2xs">🪵 Wooden Toys</a>
            </div>
          </div>

          <!-- SIDEBAR WIDGET 4: VIP PLAYROOM NEWSLETTER -->
          <div class="bg-gradient-to-br from-brand-navy to-brand-blue text-white rounded-3xl p-6 shadow-md relative overflow-hidden space-y-3.5">
            <div class="absolute -right-8 -bottom-8 w-28 h-28 bg-play-yellow/20 rounded-full blur-xl pointer-events-none"></div>
            <span class="inline-block bg-play-yellow text-brand-navy text-[10px] font-extrabold font-heading px-2.5 py-0.5 rounded-full uppercase tracking-wider">
              Aparatus Newsletter
            </span>
            <h4 class="font-heading font-bold text-base sm:text-lg text-white leading-snug">
              Get Sports & Play Guides in Your Inbox
            </h4>
            <p class="text-xs text-white/80 font-sans leading-relaxed">
              Active sports tips, toy guides, and exclusive discounts every week.
            </p>
            <form id="blog-newsletter-form" class="space-y-2 pt-1">
              <input type="email" id="blog-newsletter-email" required placeholder="Enter parent's email..." class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/60 text-xs focus:outline-none focus:ring-2 focus:ring-play-yellow font-sans">
              <button type="submit" class="w-full btn-play-orange text-xs py-2.5 rounded-xl font-heading font-bold shadow-md hover:scale-[1.02] transition cursor-pointer flex items-center justify-center gap-1.5">
                <span>Join Free Club</span>
                <i class="fa-solid fa-paper-plane text-xs"></i>
              </button>
            </form>
          </div>

          <!-- SIDEBAR WIDGET 5: SAFETY TRUST BADGE -->
          <div class="bg-white rounded-3xl border border-brand-border p-5 shadow-xs flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-soft-mint text-emerald-600 flex items-center justify-center text-xl shrink-0">
              <i class="fa-solid fa-shield-heart"></i>
            </div>
            <div>
              <h5 class="text-xs font-bold font-heading text-dark-navy">100% Non-Toxic & Child-Safe</h5>
              <p class="text-[11px] text-brand-muted font-sans">Every toy featured is lab-tested & certified for safe family play.</p>
            </div>
          </div>

        </aside>

      </div>

      <!-- FULL-WIDTH RELATED ARTICLES SECTION -->
      <section class="space-y-6 pt-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-brand-border">
          <div>
            <span class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3 py-0.5 rounded-full font-heading">
              DISCOVER MORE
            </span>
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold font-heading text-brand-navy mt-1">
              More Playroom Inspiration
            </h2>
          </div>
          <a href="{{ route('blogs') }}" class="text-xs sm:text-sm font-bold font-heading text-brand-blue hover:text-brand-orange transition flex items-center gap-1.5">
            <span>Browse All Playroom Guides</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
          </a>
        </div>

        <div id="blog-related-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Injected via JavaScript -->
        </div>
      </section>

    </div>
  </div>

@endsection

@push('scripts')
  <!-- PAGE LOGIC SCRIPT -->
  <script type="module">
    import { blogs } from '{{ asset("assets/js/data/blogs.js") }}';
    import { products } from '{{ asset("assets/js/data/products.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const base = @json(url('/') . '/');

      // Route URLs (built by Laravel so they follow the named routes)
      const blogsUrl = @json(route('blogs'));
      const blogShowTpl = @json(route('blog.show', ['slug' => '__SLUG__']));
      const productTpl = @json(route('product', ['slug' => '__SLUG__']));
      const blogShowUrl = (s) => blogShowTpl.replace('__SLUG__', encodeURIComponent(s));
      const productUrl = (s) => productTpl.replace('__SLUG__', encodeURIComponent(s));

      // 1. Reading progress bar listener
      window.addEventListener('scroll', () => {
        const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = totalHeight > 0 ? (window.scrollY / totalHeight) * 100 : 0;
        const bar = document.getElementById('reading-progress-bar');
        if (bar) bar.style.width = `${Math.min(progress, 100)}%`;
      });

      // 2. Resolve Current Blog Slug (from /blog-detail/{slug}, with ?slug= as a fallback)
      const slug = @json($slug ?? null)
        || new URLSearchParams(window.location.search).get('slug')
        || blogs[0].slug;
      const currentIndex = blogs.findIndex(b => b.slug === slug);
      const blog = currentIndex !== -1 ? blogs[currentIndex] : blogs[0];
      const validIndex = currentIndex !== -1 ? currentIndex : 0;

      // 3. Update Document Metadata & Breadcrumb
      document.title = `${blog.title} | Aparatus Pastime`;
      document.getElementById('blog-breadcrumb-cat').textContent = blog.category;
      document.getElementById('blog-breadcrumb-title').textContent = blog.title;

      // 4. Populate Article Main Elements
      document.getElementById('blog-category-tag').innerHTML = `
        <i class="fa-solid fa-shapes text-xs"></i>
        <span>${blog.category}</span>
      `;
      if (document.getElementById('blog-views-count')) {
        document.getElementById('blog-views-count').textContent = blog.views || '1.8k reads';
      }
      document.getElementById('blog-title').textContent = blog.title;
      document.getElementById('blog-author').textContent = blog.author;
      document.getElementById('blog-author-role').textContent = blog.authorRole || 'Play Specialist';
      document.getElementById('blog-author-avatar').src = blog.authorAvatar || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80';
      document.getElementById('blog-date').textContent = blog.date;
      document.getElementById('blog-read-time').textContent = blog.readTime;
      document.getElementById('blog-hero-image').src = blog.bannerImage || blog.image;
      document.getElementById('blog-hero-image').alt = blog.title;

      // Key Takeaways
      const takeawaysList = document.getElementById('blog-takeaways-list');
      if (takeawaysList && blog.keyTakeaways) {
        takeawaysList.innerHTML = blog.keyTakeaways.map(t => `
          <li class="flex items-start gap-2.5">
            <i class="fa-solid fa-circle-check text-brand-orange text-xs mt-1 shrink-0"></i>
            <span>${t}</span>
          </li>
        `).join('');
      }

      // Article Content Body
      document.getElementById('blog-content-body').innerHTML = blog.content;

      // Tags
      const tagsContainer = document.getElementById('blog-tags-container');
      if (tagsContainer) {
        const tags = blog.tags || ['OutdoorPlay', 'ScreenFree', 'PlayroomIdeas', 'AparatusFun'];
        tagsContainer.innerHTML = tags.map(t => `
          <a href="${blogsUrl}" class="px-3 py-1 rounded-full bg-warm-cream border border-brand-border text-xs font-bold font-heading text-brand-navy hover:bg-brand-orange hover:text-white hover:border-brand-orange transition shadow-2xs">
            #${t}
          </a>
        `).join('');
      }

      // Bio Box
      document.getElementById('bio-avatar').src = blog.authorAvatar || 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80';
      document.getElementById('bio-author-name').textContent = blog.author;
      document.getElementById('bio-author-role').textContent = blog.authorRole || 'Playroom Specialist';
      document.getElementById('bio-author-desc').textContent = blog.authorBio || 'Passionate about hands-on developmental play and joyful family bonding.';

      // Previous / Next Article Navigation
      const prevBlog = blogs[(validIndex - 1 + blogs.length) % blogs.length];
      const nextBlog = blogs[(validIndex + 1) % blogs.length];

      const prevLink = document.getElementById('prev-article-link');
      if (prevLink) {
        prevLink.href = blogShowUrl(prevBlog.slug);
        prevLink.textContent = prevBlog.title;
      }
      const nextLink = document.getElementById('next-article-link');
      if (nextLink) {
        nextLink.href = blogShowUrl(nextBlog.slug);
        nextLink.textContent = nextBlog.title;
      }

      // 5. Social Share Button Handlers
      const shareUrl = window.location.href;
      const shareTitle = blog.title;

      document.getElementById('share-x-btn')?.addEventListener('click', () => {
        window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(shareTitle)}&url=${encodeURIComponent(shareUrl)}`, '_blank');
      });
      document.getElementById('share-fb-btn')?.addEventListener('click', () => {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`, '_blank');
      });
      document.getElementById('share-wa-btn')?.addEventListener('click', () => {
        window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(shareTitle + ' ' + shareUrl)}`, '_blank');
      });
      document.getElementById('share-copy-btn')?.addEventListener('click', () => {
        navigator.clipboard.writeText(shareUrl).then(() => {
          Components.showToast('Article link copied to clipboard!', 'success');
        }).catch(() => {
          Components.showToast('Article link ready to share!', 'orange');
        });
      });

      // 6. Interactive Reactions
      const reactionState = { helpful: false, idea: false, try: false };
      const setupReaction = (btnId, countId, baseCount, typeName) => {
        const btn = document.getElementById(btnId);
        const countSpan = document.getElementById(countId);
        if (!btn || !countSpan) return;

        let count = baseCount;
        btn.addEventListener('click', () => {
          if (!reactionState[typeName]) {
            count++;
            reactionState[typeName] = true;
            btn.classList.add('ring-2', 'ring-brand-orange', 'bg-soft-orange');
            Components.showToast(`Thanks for your feedback! Marked as ${typeName}.`, 'orange');
          } else {
            count--;
            reactionState[typeName] = false;
            btn.classList.remove('ring-2', 'ring-brand-orange', 'bg-soft-orange');
          }
          countSpan.textContent = count;
        });
      };
      setupReaction('reaction-helpful', 'count-helpful', 48, 'helpful');
      setupReaction('reaction-idea', 'count-idea', 32, 'idea');
      setupReaction('reaction-try', 'count-try', 65, 'try');

      // 7. Sidebar Mentioned Products
      const sidebarProductsList = document.getElementById('sidebar-products-list');
      if (sidebarProductsList) {
        const prodIds = blog.recommendedProductIds || [1, 2, 3];
        const recProducts = products.filter(p => prodIds.includes(p.id)).slice(0, 3);

        sidebarProductsList.innerHTML = recProducts.map(p => `
          <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-warm-cream/80 hover:bg-soft-blue/40 border border-brand-border transition group">
            <div class="w-16 h-16 rounded-xl bg-white p-1 border border-brand-border shrink-0 flex items-center justify-center overflow-hidden">
              <img src="${p.images[0]}" alt="${p.name}" class="w-full h-full object-contain group-hover:scale-110 transition duration-300">
            </div>
            <div class="flex-1 min-w-0">
              <span class="text-[10px] font-bold font-heading text-brand-orange uppercase">${p.categoryName}</span>
              <h4 class="text-xs font-bold font-heading text-dark-navy truncate group-hover:text-brand-blue transition">
                <a href="${productUrl(p.slug)}">${p.name}</a>
              </h4>
              <div class="flex items-center justify-between mt-1">
                <span class="text-xs font-extrabold text-dark-navy font-heading">₹${p.price.toLocaleString()}</span>
                <a href="${productUrl(p.slug)}" class="text-[11px] font-bold font-heading text-brand-blue hover:text-brand-orange transition">
                  View →
                </a>
              </div>
            </div>
          </div>
        `).join('');
      }

      // 8. Sidebar Trending Articles
      const sidebarTrendingList = document.getElementById('sidebar-trending-list');
      if (sidebarTrendingList) {
        sidebarTrendingList.innerHTML = blogs.map((b, idx) => `
          <div class="flex items-center gap-3 group">
            <span class="text-base font-extrabold font-heading ${idx === 0 ? 'text-brand-orange' : 'text-gray-300'} shrink-0 w-4">
              ${idx + 1}
            </span>
            <div class="w-12 h-12 rounded-xl overflow-hidden bg-soft-blue shrink-0">
              <img src="${b.image}" alt="${b.title}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
            </div>
            <div class="flex-1 min-w-0">
              <span class="text-[10px] font-bold font-heading text-brand-muted uppercase">${b.readTime}</span>
              <h4 class="text-xs font-bold font-heading text-dark-navy group-hover:text-brand-orange transition line-clamp-2 leading-snug">
                <a href="${blogShowUrl(b.slug)}">${b.title}</a>
              </h4>
            </div>
          </div>
        `).join('');
      }

      // 9. Sidebar Newsletter Submission
      const newsletterForm = document.getElementById('blog-newsletter-form');
      if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
          e.preventDefault();
          const emailInput = document.getElementById('blog-newsletter-email');
          if (emailInput && emailInput.value) {
            Components.showToast(`🎉 Welcome to Aparatus! Verification sent to ${emailInput.value}`, 'success');
            emailInput.value = '';
          }
        });
      }

      // 10. Bottom Related Articles Grid
      const relatedGrid = document.getElementById('blog-related-grid');
      const related = blogs.filter(b => b.id !== blog.id);
      if (relatedGrid) {
        relatedGrid.innerHTML = related.map(b => Components.renderBlogCard(b, base)).join('');
      }
    });
  </script>
@endpush