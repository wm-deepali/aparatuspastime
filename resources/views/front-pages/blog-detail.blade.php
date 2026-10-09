@extends('layouts.app')

@section('title', $blog->meta_title ?: $blog->title . ' | Aparatus Pastime')
@section('meta_description', $blog->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($blog->short_description ?: $blog->content), 160))
@section('active_nav', 'home')

@section('content')

  <!-- READING SCROLL PROGRESS BAR -->
  <div id="reading-progress-bar"
    class="fixed top-0 left-0 h-1 bg-gradient-to-r from-brand-orange via-play-yellow to-brand-blue z-50 transition-all duration-100"
    style="width: 0%;"></div>

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
          @if ($blog->category)
            <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
            <a href="{{ route('blogs', ['cat' => $blog->category_slug]) }}"
              class="text-brand-blue font-bold hover:text-brand-orange transition">{{ $blog->category }}</a>
          @endif
          <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
          <span class="text-dark-navy font-bold truncate max-w-[200px] sm:max-w-md">{{ $blog->title }}</span>
        </nav>

        <a href="{{ route('blogs') }}"
          class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-orange hover:text-brand-navy transition bg-soft-orange px-3 py-1.5 rounded-full border border-brand-orange/20">
          <i class="fa-solid fa-arrow-left text-[10px]"></i>
          <span>All Playroom Stories</span>
        </a>
      </div>

      <!-- MAIN 2-COLUMN GRID -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- ARTICLE COLUMN -->
        <div class="lg:col-span-8 space-y-8">

          <article
            class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 md:p-12 shadow-xs space-y-8 relative overflow-hidden">
            <div class="absolute -top-16 -right-16 w-48 h-48 bg-soft-yellow rounded-full -z-0 opacity-70 pointer-events-none blur-xl"></div>
            <div class="absolute top-1/2 -left-20 w-40 h-40 bg-soft-blue rounded-full -z-0 opacity-70 pointer-events-none blur-xl"></div>

            <!-- HEADER META -->
            <div class="space-y-4 relative z-10">
              <div class="flex flex-wrap items-center gap-2.5">
                @if ($blog->category)
                  <span
                    class="inline-flex items-center gap-1.5 bg-soft-orange text-brand-orange text-xs font-bold font-heading px-4 py-1.5 rounded-full border border-brand-orange/20 uppercase tracking-wider shadow-2xs">
                    <i class="fa-solid fa-shapes text-xs"></i>
                    <span>{{ $blog->category }}</span>
                  </span>
                @endif
                @if ($blog->views_label)
                  <span
                    class="inline-flex items-center gap-1.5 bg-soft-blue text-brand-blue text-xs font-bold font-heading px-3.5 py-1.5 rounded-full border border-brand-blue/20">
                    <i class="fa-solid fa-eye text-[11px]"></i>
                    <span>{{ $blog->views_label }}</span>
                  </span>
                @endif
              </div>

              <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold font-heading text-brand-navy leading-snug tracking-tight">
                {{ $blog->title }}
              </h1>

              <!-- AUTHOR & DATE ROW -->
              <div class="flex flex-wrap items-center justify-between gap-4 pt-3 pb-4 border-b border-brand-border/70">
                @if ($blog->author_name)
                  <div class="flex items-center gap-3.5">
                    @if ($blog->author_avatar_url)
                      <img src="{{ $blog->author_avatar_url }}" alt="{{ $blog->author_name }}"
                        class="w-12 h-12 rounded-full object-cover border-2 border-brand-orange shadow-xs">
                    @else
                      <div
                        class="w-12 h-12 rounded-full bg-brand-orange text-white font-heading font-bold flex items-center justify-center border-2 border-brand-orange shadow-xs">
                        {{ $blog->author_initials }}
                      </div>
                    @endif
                    <div>
                      <div class="flex items-center gap-1.5">
                        <span class="font-bold text-sm sm:text-base text-dark-navy font-heading">{{ $blog->author_name }}</span>
                        <i class="fa-solid fa-circle-check text-brand-blue text-xs"></i>
                      </div>
                      @if ($blog->author_role)
                        <p class="text-xs text-brand-muted font-sans font-medium">{{ $blog->author_role }}</p>
                      @endif
                    </div>
                  </div>
                @endif

                <div class="flex items-center gap-3 text-xs text-brand-muted font-sans font-semibold">
                  @if ($blog->date_label)
                    <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar text-brand-orange"></i>
                      <span>{{ $blog->date_label }}</span></span>
                    <span>•</span>
                  @endif
                  <span class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-brand-blue"></i>
                    <span>{{ $blog->read_time_label }}</span></span>
                </div>
              </div>
            </div>

            <!-- HERO BANNER IMAGE -->
            @if ($blog->banner_url)
              <div
                class="rounded-2xl sm:rounded-3xl overflow-hidden aspect-16/9 bg-soft-blue shadow-inner border border-brand-border relative group">
                <img src="{{ $blog->banner_url }}" alt="{{ $blog->title }}"
                  class="w-full h-full object-cover group-hover:scale-[1.02] transition duration-500 ease-out">
              </div>
            @endif

            <!-- KEY TAKEAWAYS -->
            @if (!empty($blog->key_takeaways))
              <div
                class="bg-gradient-to-r from-soft-blue via-soft-yellow/25 to-soft-mint/30 rounded-2xl p-5 sm:p-7 border border-brand-border relative">
                <div class="flex items-center gap-2.5 text-xs font-bold uppercase tracking-wider text-brand-navy font-heading mb-3">
                  <span class="w-6 h-6 rounded-full bg-brand-orange text-white flex items-center justify-center text-xs shadow-2xs">
                    <i class="fa-solid fa-sparkles"></i>
                  </span>
                  <span>KEY TAKEAWAYS FOR PARENTS</span>
                </div>
                <ul class="space-y-2.5 text-xs sm:text-sm text-dark-navy font-sans leading-relaxed">
                  @foreach ($blog->key_takeaways as $item)
                    <li class="flex items-start gap-2.5">
                      <i class="fa-solid fa-circle-check text-brand-orange text-xs mt-1 shrink-0"></i>
                      <span>{{ $item }}</span>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- ARTICLE BODY -->
            <div class="w-full text-base sm:text-lg text-body-text font-body leading-relaxed space-y-6">
              {!! $blog->content !!}
            </div>

            <!-- REACTIONS -->
            <div
              class="p-5 sm:p-6 bg-warm-cream rounded-2xl border border-brand-border/80 flex flex-col sm:flex-row items-center justify-between gap-4">
              <div>
                <h4 class="font-heading font-bold text-dark-navy text-sm sm:text-base">Did this inspire your playtime?</h4>
                <p class="text-xs text-brand-muted font-sans">Tap a reaction below to let our editorial team know!</p>
              </div>
              <div class="flex items-center gap-2 flex-wrap">
                <button type="button" data-reaction="Helpful"
                  class="reaction-btn px-4 py-2 rounded-xl bg-white border border-brand-border hover:border-brand-orange hover:bg-soft-orange text-dark-navy text-xs font-bold font-heading flex items-center gap-2 transition cursor-pointer shadow-2xs">
                  <span>❤️</span> <span>Helpful</span>
                </button>
                <button type="button" data-reaction="Great Idea"
                  class="reaction-btn px-4 py-2 rounded-xl bg-white border border-brand-border hover:border-brand-blue hover:bg-soft-blue text-dark-navy text-xs font-bold font-heading flex items-center gap-2 transition cursor-pointer shadow-2xs">
                  <span>💡</span> <span>Great Idea</span>
                </button>
                <button type="button" data-reaction="Will Try"
                  class="reaction-btn px-4 py-2 rounded-xl bg-white border border-brand-border hover:border-emerald-500 hover:bg-soft-mint text-dark-navy text-xs font-bold font-heading flex items-center gap-2 transition cursor-pointer shadow-2xs">
                  <span>🎉</span> <span>Will Try</span>
                </button>
              </div>
            </div>

            <!-- TAGS -->
            @if (!empty($blog->tags))
              <div class="flex flex-wrap items-center gap-2 pt-2">
                <span class="text-xs font-bold text-brand-muted font-heading uppercase mr-1">Tags:</span>
                <div class="flex flex-wrap gap-2">
                  @foreach ($blog->tags as $t)
                    <a href="{{ route('blogs', ['tag' => $t]) }}"
                      class="px-3 py-1 rounded-full bg-warm-cream border border-brand-border text-xs font-bold font-heading text-brand-navy hover:bg-brand-orange hover:text-white hover:border-brand-orange transition shadow-2xs">
                      #{{ $t }}
                    </a>
                  @endforeach
                </div>
              </div>
            @endif

            <!-- SHARE -->
            <div class="pt-6 border-t border-brand-border flex flex-col sm:flex-row items-center justify-between gap-4">
              <span class="text-xs font-bold font-heading text-brand-navy uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-share-nodes text-brand-orange"></i>
                SHARE THIS PLAYROOM STORY
              </span>
              <div class="flex items-center gap-2.5">
                <button id="share-x-btn"
                  class="w-10 h-10 rounded-full bg-soft-blue hover:bg-brand-blue hover:text-white text-brand-blue flex items-center justify-center transition shadow-2xs cursor-pointer"
                  title="Share on X"><i class="fa-brands fa-x-twitter"></i></button>
                <button id="share-fb-btn"
                  class="w-10 h-10 rounded-full bg-soft-blue hover:bg-brand-navy hover:text-white text-brand-navy flex items-center justify-center transition shadow-2xs cursor-pointer"
                  title="Share on Facebook"><i class="fa-brands fa-facebook"></i></button>
                <button id="share-wa-btn"
                  class="w-10 h-10 rounded-full bg-soft-mint hover:bg-emerald-600 hover:text-white text-emerald-700 flex items-center justify-center transition shadow-2xs cursor-pointer"
                  title="Share on WhatsApp"><i class="fa-brands fa-whatsapp text-base"></i></button>
                <button id="share-copy-btn"
                  class="px-3.5 py-2 rounded-full bg-soft-orange hover:bg-brand-orange hover:text-white text-brand-orange flex items-center gap-1.5 transition shadow-2xs cursor-pointer text-xs font-bold font-heading"
                  title="Copy Link">
                  <i class="fa-solid fa-link text-xs"></i><span>Copy Link</span>
                </button>
              </div>
            </div>

            <!-- AUTHOR BIO -->
            @if ($blog->author_name && $blog->author_bio)
              <div
                class="bg-warm-cream rounded-2xl p-6 border border-brand-border flex flex-col sm:flex-row items-center sm:items-start gap-5 text-center sm:text-left">
                @if ($blog->author_avatar_url)
                  <img src="{{ $blog->author_avatar_url }}" alt="{{ $blog->author_name }}"
                    class="w-20 h-20 rounded-2xl object-cover border-2 border-brand-orange shadow-sm shrink-0">
                @else
                  <div
                    class="w-20 h-20 rounded-2xl bg-brand-orange text-white font-heading font-bold text-xl flex items-center justify-center border-2 border-brand-orange shadow-sm shrink-0">
                    {{ $blog->author_initials }}
                  </div>
                @endif
                <div class="space-y-2">
                  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                      <h3 class="text-base font-bold font-heading text-dark-navy">{{ $blog->author_name }}</h3>
                      @if ($blog->author_role)
                        <p class="text-xs text-brand-orange font-heading font-semibold">{{ $blog->author_role }}</p>
                      @endif
                    </div>
                    <span
                      class="inline-block bg-white px-3 py-1 rounded-full text-[11px] font-bold font-heading text-brand-blue border border-brand-border">
                      <i class="fa-solid fa-award mr-1 text-play-yellow"></i> Aparatus Editorial Contributor
                    </span>
                  </div>
                  <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans">{{ $blog->author_bio }}</p>
                </div>
              </div>
            @endif

            <!-- PREVIOUS / NEXT -->
            @if ($prevBlog || $nextBlog)
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-brand-border">
                @if ($prevBlog)
                  <a href="{{ route('blog.show', ['slug' => $prevBlog->slug]) }}"
                    class="p-4 rounded-2xl bg-white hover:bg-soft-blue/50 border border-brand-border transition group flex items-center gap-3.5">
                    <div
                      class="w-10 h-10 rounded-xl bg-soft-blue text-brand-blue flex items-center justify-center shrink-0 group-hover:bg-brand-blue group-hover:text-white transition">
                      <i class="fa-solid fa-arrow-left text-sm"></i>
                    </div>
                    <div class="overflow-hidden">
                      <span class="text-[10px] uppercase font-bold tracking-wider text-brand-muted font-heading block">Previous Story</span>
                      <span class="text-xs sm:text-sm font-bold font-heading text-dark-navy group-hover:text-brand-orange transition truncate block">{{ $prevBlog->title }}</span>
                    </div>
                  </a>
                @else
                  <div></div>
                @endif

                @if ($nextBlog)
                  <a href="{{ route('blog.show', ['slug' => $nextBlog->slug]) }}"
                    class="p-4 rounded-2xl bg-white hover:bg-soft-orange/50 border border-brand-border transition group flex items-center justify-between gap-3.5 text-right sm:flex-row-reverse">
                    <div
                      class="w-10 h-10 rounded-xl bg-soft-orange text-brand-orange flex items-center justify-center shrink-0 group-hover:bg-brand-orange group-hover:text-white transition">
                      <i class="fa-solid fa-arrow-right text-sm"></i>
                    </div>
                    <div class="overflow-hidden">
                      <span class="text-[10px] uppercase font-bold tracking-wider text-brand-muted font-heading block">Next Story</span>
                      <span class="text-xs sm:text-sm font-bold font-heading text-dark-navy group-hover:text-brand-orange transition truncate block">{{ $nextBlog->title }}</span>
                    </div>
                  </a>
                @endif
              </div>
            @endif

          </article>
        </div>

        <!-- SIDEBAR -->
        <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

          <!-- Toys in this article -->
          @if ($sideProducts->isNotEmpty())
            <div class="bg-white rounded-3xl border border-brand-border p-5 sm:p-6 shadow-xs space-y-4">
              <div class="flex items-center justify-between pb-3 border-b border-brand-border">
                <h3 class="font-heading font-bold text-sm sm:text-base text-brand-navy flex items-center gap-2">
                  <i class="fa-solid fa-basket-shopping text-brand-orange"></i>
                  <span>Toys In This Article</span>
                </h3>
                <a href="{{ route('shop') }}"
                  class="text-[11px] font-bold font-heading text-brand-blue hover:text-brand-orange transition">View All →</a>
              </div>

              <div class="space-y-3">
                @foreach ($sideProducts as $p)
                  @php
                    $pImg = $p->images->firstWhere('is_default', 1) ?? $p->images->first();
                    $pImgUrl = $pImg ? asset('storage/' . $pImg->image) : asset('assets/images/placeholder.png');
                  @endphp
                  <div
                    class="flex items-center gap-3 p-2.5 rounded-2xl bg-warm-cream/80 hover:bg-soft-blue/40 border border-brand-border transition group">
                    <div
                      class="w-16 h-16 rounded-xl bg-white p-1 border border-brand-border shrink-0 flex items-center justify-center overflow-hidden">
                      <img src="{{ $pImgUrl }}" alt="{{ $p->name }}"
                        class="w-full h-full object-contain group-hover:scale-110 transition duration-300">
                    </div>
                    <div class="flex-1 min-w-0">
                      @if ($p->category)
                        <span class="text-[10px] font-bold font-heading text-brand-orange uppercase">{{ $p->category->name }}</span>
                      @endif
                      <h4 class="text-xs font-bold font-heading text-dark-navy truncate group-hover:text-brand-blue transition">
                        <a href="{{ route('product', ['slug' => $p->slug]) }}">{{ $p->name }}</a>
                      </h4>
                      <div class="flex items-center justify-between mt-1">
                        <span class="text-xs font-extrabold text-dark-navy font-heading">₹{{ number_format($p->price) }}</span>
                        <a href="{{ route('product', ['slug' => $p->slug]) }}"
                          class="text-[11px] font-bold font-heading text-brand-blue hover:text-brand-orange transition">View →</a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <!-- Trending stories -->
          @if ($trending->isNotEmpty())
            <div class="bg-white rounded-3xl border border-brand-border p-5 sm:p-6 shadow-xs space-y-4">
              <h3 class="font-heading font-bold text-sm sm:text-base text-brand-navy flex items-center gap-2 pb-3 border-b border-brand-border">
                <i class="fa-solid fa-fire text-brand-orange"></i>
                <span>Trending Playroom Stories</span>
              </h3>

              <div class="space-y-3.5">
                @foreach ($trending as $b)
                  <div class="flex items-center gap-3 group">
                    <span class="text-base font-extrabold font-heading {{ $loop->first ? 'text-brand-orange' : 'text-gray-300' }} shrink-0 w-4">
                      {{ $loop->iteration }}
                    </span>
                    @if ($b->image_url)
                      <div class="w-12 h-12 rounded-xl overflow-hidden bg-soft-blue shrink-0">
                        <img src="{{ $b->image_url }}" alt="{{ $b->title }}"
                          class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                      </div>
                    @endif
                    <div class="flex-1 min-w-0">
                      <span class="text-[10px] font-bold font-heading text-brand-muted uppercase">{{ $b->read_time_label }}</span>
                      <h4 class="text-xs font-bold font-heading text-dark-navy group-hover:text-brand-orange transition line-clamp-2 leading-snug">
                        <a href="{{ route('blog.show', ['slug' => $b->slug]) }}">{{ $b->title }}</a>
                      </h4>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <!-- Topics -->
          @if ($topics->isNotEmpty())
            <div class="bg-white rounded-3xl border border-brand-border p-5 sm:p-6 shadow-xs space-y-3">
              <h3 class="font-heading font-bold text-sm text-brand-navy pb-2 border-b border-brand-border">
                Explore Playroom Topics
              </h3>
              <div class="flex flex-wrap gap-2 pt-1 font-heading text-xs">
                @foreach ($topics as $t)
                  <a href="{{ route('blogs', ['cat' => $t->category_slug]) }}"
                    class="px-3 py-1.5 rounded-xl bg-soft-blue text-brand-blue font-bold hover:bg-brand-blue hover:text-white transition shadow-2xs">
                    {{ $t->category }}
                  </a>
                @endforeach
              </div>
            </div>
          @endif

          <!-- Newsletter -->
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
              <input type="email" id="blog-newsletter-email" required placeholder="Enter parent's email..."
                class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/60 text-xs focus:outline-none focus:ring-2 focus:ring-play-yellow font-sans">
              <button type="submit"
                class="w-full btn-play-orange text-xs py-2.5 rounded-xl font-heading font-bold shadow-md hover:scale-[1.02] transition cursor-pointer flex items-center justify-center gap-1.5">
                <span>Join Free Club</span>
                <i class="fa-solid fa-paper-plane text-xs"></i>
              </button>
            </form>
          </div>

          <!-- Safety badge -->
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

      <!-- RELATED ARTICLES -->
      @if ($related->isNotEmpty())
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
            <a href="{{ route('blogs') }}"
              class="text-xs sm:text-sm font-bold font-heading text-brand-blue hover:text-brand-orange transition flex items-center gap-1.5">
              <span>Browse All Playroom Guides</span>
              <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($related as $b)
              @include('front-pages.partials.blog-card', ['blog' => $b])
            @endforeach
          </div>
        </section>
      @endif

    </div>
  </div>

@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {

      // Reading progress bar
      window.addEventListener('scroll', () => {
        const total = document.documentElement.scrollHeight - window.innerHeight;
        const progress = total > 0 ? (window.scrollY / total) * 100 : 0;
        const bar = document.getElementById('reading-progress-bar');
        if (bar) bar.style.width = `${Math.min(progress, 100)}%`;
      });

      // Share
      const shareUrl = window.location.href;
      const shareTitle = @json($blog->title);

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
        navigator.clipboard.writeText(shareUrl)
          .then(() => Components.showToast('Article link copied to clipboard!', 'success'))
          .catch(() => Components.showToast('Article link ready to share!', 'orange'));
      });

      // Reactions (toggle highlight only)
      document.querySelectorAll('[data-reaction]').forEach(btn => {
        btn.addEventListener('click', () => {
          const on = btn.classList.toggle('bg-soft-orange');
          btn.classList.toggle('ring-2', on);
          btn.classList.toggle('ring-brand-orange', on);
          if (on) Components.showToast(`Thanks for your feedback! Marked as ${btn.dataset.reaction}.`, 'success');
        });
      });

      // Newsletter
      document.getElementById('blog-newsletter-form')?.addEventListener('submit', (e) => {
        e.preventDefault();
        const input = document.getElementById('blog-newsletter-email');
        if (input?.value) {
          Components.showToast(`🎉 Welcome to Aparatus! Verification sent to ${input.value}`, 'success');
          input.value = '';
        }
      });
    });
  </script>
@endpush