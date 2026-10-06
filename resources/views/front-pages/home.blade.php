<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <title>Aparatus Pastime | Kids Toys, Games & Sports Goods - Play. Learn. Explore.</title>
  <meta name="description"
    content="Discover premium curated kids toys, board games, sports goods, tactical puzzles, and educational STEM sets at Aparatus Pastime. Built for active play, curiosity, and family fun.">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">

  <!-- Google Fonts: Outfit & Nunito -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <!-- Tailwind CSS CDN with Custom Brand Tokens -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'brand-blue': '#1261A0',
            'brand-navy': '#073B73',
            'brand-orange': '#F58220',
            'brand-bright-orange': '#FF9F1C',
            'play-yellow': '#FFD447',
            'sky-blue': '#7DD3FC',
            'mint': '#8FE3CF',
            'soft-coral': '#FF8A80',
            'purple-play': '#A78BFA',
            'warm-cream': '#FFFDF7',
            'soft-blue': '#F0F8FF',
            'soft-yellow': '#FFF9E6',
            'soft-mint': '#F0FFF9',
            'soft-orange': '#FFF4EA',
            'soft-purple': '#F5F3FF',
            'soft-sky': '#F0F9FF',
            'dark-navy': '#172B4D',
            'body-text': '#465466',
            'brand-muted': '#7A8795',
            'brand-border': '#E8EDF2',
          },
          fontFamily: {
            sans: ['Nunito', 'sans-serif'],
            heading: ['Outfit', 'sans-serif'],
            body: ['Nunito', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body class="has-bottom-nav bg-warm-cream text-body-text">

  <!-- HEADER CONTAINER (Injected dynamically) -->
  <div id="header-root"></div>

  <!-- MAIN HOMEPAGE CONTENT -->
  <main>

    <!-- 1. FULL WIDTH HERO SLIDER (1920x480-520px Desktop, 390x320px Mobile) -->
    <section class="relative bg-brand-navy overflow-hidden">
      <div id="hero-slider"
        class="hero-slider-container relative w-full h-[400px] xs:h-[420px] sm:h-[460px] md:h-[500px] lg:h-[520px] select-none">

        <!-- Slide 1: Toys & Imaginative Play -->
        <div class="hero-slide active">
          <img src="https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?auto=format&fit=crop&w=2000&q=85"
            alt="Kids playing with colorful toys" class="hero-bg-img absolute inset-0 w-full h-full object-cover">

          <!-- Scrim / Gradient Overlay -->
          <div
            class="absolute inset-0 bg-gradient-to-r from-[#073B73]/95 via-[#073B73]/80 md:via-[#073B73]/50 to-transparent">
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-[#073B73]/80 via-transparent to-transparent"></div>

          <!-- Content -->
          <div class="relative max-w-7xl mx-auto px-4 sm:px-8 md:px-12 w-full h-full flex items-center z-10">
            <div class="max-w-xl text-white space-y-2.5 sm:space-y-4 py-4 sm:py-6">

              <!-- Tag Badge with Star Deco -->
              <div
                class="inline-flex items-center gap-1.5 sm:gap-2 bg-brand-orange text-white text-[10px] sm:text-xs font-bold font-heading px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full shadow-md tracking-wider uppercase">
                <i class="fa-solid fa-sparkles text-play-yellow"></i>
                <span>EXPLORE & IMAGINE • PLAYTIME SPECIALS</span>
              </div>

              <!-- Main Title -->
              <h1
                class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold font-heading leading-tight tracking-tight text-white drop-shadow-md">
                BIG FUN<br><span class="text-play-yellow">STARTS HERE</span>
              </h1>

              <!-- Subtitle -->
              <p class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed max-w-md line-clamp-2 sm:line-clamp-none">
                Discover toys, games and activities made for curious little minds. Built for joyful discovery,
                creativity, and lasting childhood memories.
              </p>

              <!-- Buttons -->
              <div class="pt-1 sm:pt-2 flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="pages/shop.html?category=toys"
                  class="btn-play-orange text-xs sm:text-sm px-5 sm:px-8 py-2.5 sm:py-3.5 rounded-xl shadow-lg flex items-center gap-1.5 sm:gap-2 whitespace-nowrap">
                  <span>SHOP TOYS →</span>
                </a>
                <a href="pages/categories.html"
                  class="bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-bold font-heading px-4 sm:px-6 py-2.5 sm:py-3.5 rounded-xl border border-white/40 backdrop-blur-md transition whitespace-nowrap">
                  EXPLORE ALL CATEGORIES
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 2: STEM & Learning -->
        <div class="hero-slide">
          <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=2000&q=85"
            alt="STEM Learning & Magnetic Sets" class="hero-bg-img absolute inset-0 w-full h-full object-cover">

          <div
            class="absolute inset-0 bg-gradient-to-r from-[#073B73]/95 via-[#073B73]/80 md:via-[#073B73]/50 to-transparent">
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-[#073B73]/80 via-transparent to-transparent"></div>

          <div class="relative max-w-7xl mx-auto px-4 sm:px-8 md:px-12 w-full h-full flex items-center z-10">
            <div class="max-w-xl text-white space-y-2.5 sm:space-y-4 py-4 sm:py-6">

              <div
                class="inline-flex items-center gap-1.5 sm:gap-2 bg-mint text-dark-navy text-[10px] sm:text-xs font-bold font-heading px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full shadow-md tracking-wider uppercase">
                <i class="fa-solid fa-atom text-brand-blue"></i>
                <span>CURIOUS MINDS • STEM & DISCOVERY</span>
              </div>

              <h2
                class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold font-heading leading-tight tracking-tight text-white drop-shadow-md">
                PLAY. LEARN.<br><span class="text-mint">EXPLORE.</span>
              </h2>

              <p class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed max-w-md line-clamp-2 sm:line-clamp-none">
                From STEM kits to creative games, find something that sparks curiosity, hands-on problem solving, and
                imagination.
              </p>

              <div class="pt-1 sm:pt-2 flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="pages/shop.html?category=educational"
                  class="btn-play-orange text-xs sm:text-sm px-5 sm:px-8 py-2.5 sm:py-3.5 rounded-xl shadow-lg flex items-center gap-1.5 sm:gap-2 whitespace-nowrap">
                  <span>EXPLORE LEARNING →</span>
                </a>
                <a href="pages/shop.html?filter=trending"
                  class="bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-bold font-heading px-4 sm:px-6 py-2.5 sm:py-3.5 rounded-xl border border-white/40 backdrop-blur-md transition whitespace-nowrap">
                  TRENDING NOW
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 3: Outdoor & Active Sports -->
        <div class="hero-slide">
          <img src="https://images.unsplash.com/photo-1517649763962-0c623266ddc0?auto=format&fit=crop&w=2000&q=85"
            alt="Active outdoor kids sports" class="hero-bg-img absolute inset-0 w-full h-full object-cover">

          <div
            class="absolute inset-0 bg-gradient-to-r from-[#073B73]/95 via-[#073B73]/80 md:via-[#073B73]/50 to-transparent">
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-[#073B73]/80 via-transparent to-transparent"></div>

          <div class="relative max-w-7xl mx-auto px-4 sm:px-8 md:px-12 w-full h-full flex items-center z-10">
            <div class="max-w-xl text-white space-y-2.5 sm:space-y-4 py-4 sm:py-6">

              <div
                class="inline-flex items-center gap-1.5 sm:gap-2 bg-sky-blue text-dark-navy text-[10px] sm:text-xs font-bold font-heading px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full shadow-md tracking-wider uppercase">
                <i class="fa-solid fa-volleyball text-brand-orange"></i>
                <span>GET ACTIVE • OUTDOOR GEAR</span>
              </div>

              <h2
                class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold font-heading leading-tight tracking-tight text-white drop-shadow-md">
                GET OUT &<br><span class="text-sky-blue">PLAY</span>
              </h2>

              <p class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed max-w-md line-clamp-2 sm:line-clamp-none">
                Active games and sports gear for little adventurers. Build coordination, cardiovascular agility, and
                team spirit.
              </p>

              <div class="pt-1 sm:pt-2 flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="pages/shop.html?category=outdoor"
                  class="btn-play-orange text-xs sm:text-sm px-5 sm:px-8 py-2.5 sm:py-3.5 rounded-xl shadow-lg flex items-center gap-1.5 sm:gap-2 whitespace-nowrap">
                  <span>SHOP OUTDOOR PLAY →</span>
                </a>
                <a href="pages/shop.html?category=sports"
                  class="bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-bold font-heading px-4 sm:px-6 py-2.5 sm:py-3.5 rounded-xl border border-white/40 backdrop-blur-md transition whitespace-nowrap">
                  SPORTS GEAR
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 4: Perfect Gifts -->
        <div class="hero-slide">
          <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?auto=format&fit=crop&w=2000&q=85"
            alt="Curated toy gift boxes" class="hero-bg-img absolute inset-0 w-full h-full object-cover">

          <div
            class="absolute inset-0 bg-gradient-to-r from-[#073B73]/95 via-[#073B73]/80 md:via-[#073B73]/50 to-transparent">
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-[#073B73]/80 via-transparent to-transparent"></div>

          <div class="relative max-w-7xl mx-auto px-4 sm:px-8 md:px-12 w-full h-full flex items-center z-10">
            <div class="max-w-xl text-white space-y-2.5 sm:space-y-4 py-4 sm:py-6">

              <div
                class="inline-flex items-center gap-1.5 sm:gap-2 bg-brand-orange text-white text-[10px] sm:text-xs font-bold font-heading px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-full shadow-md tracking-wider uppercase">
                <i class="fa-solid fa-gift text-play-yellow"></i>
                <span>BIRTHDAYS & SURPRISES</span>
              </div>

              <h2
                class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold font-heading leading-tight tracking-tight text-white drop-shadow-md">
                THE PERFECT<br><span class="text-play-yellow">GIFT</span>
              </h2>

              <p class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed max-w-md line-clamp-2 sm:line-clamp-none">
                Fun finds for birthdays, celebrations and every special moment. Curated bundles that make unboxing
                unforgettable.
              </p>

              <div class="pt-1 sm:pt-2 flex flex-wrap items-center gap-2 sm:gap-3">
                <a href="pages/shop.html?category=gifts"
                  class="btn-play-orange text-xs sm:text-sm px-5 sm:px-8 py-2.5 sm:py-3.5 rounded-xl shadow-lg flex items-center gap-1.5 sm:gap-2 whitespace-nowrap">
                  <span>SHOP GIFTS →</span>
                </a>
                <a href="pages/shop.html?filter=bestseller"
                  class="bg-white/20 hover:bg-white/30 text-white text-xs sm:text-sm font-bold font-heading px-4 sm:px-6 py-2.5 sm:py-3.5 rounded-xl border border-white/40 backdrop-blur-md transition whitespace-nowrap">
                  TOP BEST SELLERS
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Sleek Floating Navigation Arrows (Visible on sm and up) -->
        <button id="hero-prev"
          class="hidden sm:flex absolute left-3 md:left-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/20 hover:bg-brand-orange text-white items-center justify-center transition backdrop-blur-md z-20 shadow-lg border border-white/30 cursor-pointer"
          aria-label="Previous Slide">
          <i class="fa-solid fa-chevron-left text-sm"></i>
        </button>
        <button id="hero-next"
          class="hidden sm:flex absolute right-3 md:right-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/20 hover:bg-brand-orange text-white items-center justify-center transition backdrop-blur-md z-20 shadow-lg border border-white/30 cursor-pointer"
          aria-label="Next Slide">
          <i class="fa-solid fa-chevron-right text-sm"></i>
        </button>

        <!-- Slide Indicators -->
        <div class="absolute bottom-2.5 sm:bottom-4 inset-x-0 flex items-center justify-center gap-1.5 sm:gap-2 z-20 px-2 sm:px-4">
          <button
            class="hero-dot flex items-center gap-1.5 sm:gap-2 bg-brand-orange text-white px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading shadow-md transition"
            data-slide="0">
            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white"></span>
            <span>TOYS</span>
          </button>
          <button
            class="hero-dot flex items-center gap-1.5 sm:gap-2 bg-black/40 hover:bg-black/60 text-white/80 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading transition"
            data-slide="1">
            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white/40"></span>
            <span>STEM</span>
          </button>
          <button
            class="hero-dot flex items-center gap-1.5 sm:gap-2 bg-black/40 hover:bg-black/60 text-white/80 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading transition"
            data-slide="2">
            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white/40"></span>
            <span>OUTDOOR</span>
          </button>
          <button
            class="hero-dot flex items-center gap-1.5 sm:gap-2 bg-black/40 hover:bg-black/60 text-white/80 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading transition"
            data-slide="3">
            <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white/40"></span>
            <span>GIFTS</span>
          </button>
        </div>

      </div>
    </section>

    <!-- 2. TRUST / USP STRIP (Pastel Badges) -->
    <section class="bg-white border-b border-brand-border py-4 sm:py-5 shadow-2xs">
      <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">

          <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-soft-blue border border-blue-100">
            <div
              class="w-10 h-10 rounded-xl bg-brand-blue text-white flex items-center justify-center text-base shrink-0 shadow-xs">
              <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
              <h4 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">SAFE & QUALITY PRODUCTS</h4>
              <p class="text-[11px] text-body-text font-sans">100% Non-toxic & child-safe</p>
            </div>
          </div>

          <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-soft-orange border border-orange-100">
            <div
              class="w-10 h-10 rounded-xl bg-brand-orange text-white flex items-center justify-center text-base shrink-0 shadow-xs">
              <i class="fa-solid fa-truck"></i>
            </div>
            <div>
              <h4 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">FAST DELIVERY</h4>
              <p class="text-[11px] text-body-text font-sans">Free on orders above ₹999</p>
            </div>
          </div>

          <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-soft-mint border border-emerald-100">
            <div
              class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-base shrink-0 shadow-xs">
              <i class="fa-solid fa-lock"></i>
            </div>
            <div>
              <h4 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">SECURE PAYMENTS</h4>
              <p class="text-[11px] text-body-text font-sans">UPI, Cards & Net Banking</p>
            </div>
          </div>

          <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-soft-yellow border border-amber-100">
            <div
              class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-base shrink-0 shadow-xs">
              <i class="fa-solid fa-rotate-left"></i>
            </div>
            <div>
              <h4 class="font-heading font-bold text-xs sm:text-sm text-dark-navy">EASY RETURNS</h4>
              <p class="text-[11px] text-body-text font-sans">Hassle-free 7-day policy</p>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- 3. CATEGORY SECTION ("WHAT DO THEY LOVE?") -->
    <section class="py-10 sm:py-14 bg-warm-cream/50">
      <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-10">
          <span
            class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading inline-flex items-center gap-1.5 shadow-2xs border border-orange-200/60">
            <i class="fa-solid fa-sparkles text-brand-orange text-xs"></i>
            <span>DISCOVER PLAYTIME</span>
          </span>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold font-heading text-dark-navy mt-2.5 tracking-tight">
            WHAT DO THEY LOVE?
          </h2>
          <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans max-w-md mx-auto">
            Explore fun, games and activities for every kind of kid.
          </p>
        </div>

        <div id="home-categories-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-2.5 sm:gap-3.5 xl:gap-4">
          <!-- Injected via JavaScript from categories.js with individual pastel backgrounds -->
        </div>

      </div>
    </section>

    <!-- 4. TRENDING PRODUCTS ("THEY'RE LOVING THESE") -->
    <section class="py-12 md:py-16 bg-white border-y border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
          <div>
            <span
              class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3 py-1 rounded-full font-heading">
              HOTTEST PICKS
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy mt-2">
              THEY'RE LOVING THESE
            </h2>
            <p class="text-xs sm:text-sm text-body-text mt-1 font-sans">Popular picks for playtime and family smiles.
            </p>
          </div>

          <!-- Tabs: NEW ARRIVALS / BEST SELLERS / TRENDING (Single line on all viewports) -->
          <div
            class="w-full sm:w-auto overflow-x-auto no-scrollbar flex items-center justify-between sm:justify-start gap-1 sm:gap-1.5 bg-soft-blue p-1 sm:p-1.5 rounded-2xl border border-brand-border self-start sm:self-auto font-heading">
            <button id="tab-new-arrivals"
              class="trending-tab-btn active px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition bg-brand-navy text-white shadow-xs cursor-pointer flex-1 sm:flex-initial text-center">
              NEW ARRIVALS
            </button>
            <button id="tab-best-sellers"
              class="trending-tab-btn px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition text-dark-navy hover:text-brand-orange cursor-pointer flex-1 sm:flex-initial text-center">
              BEST SELLERS
            </button>
            <button id="tab-trending"
              class="trending-tab-btn px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition text-dark-navy hover:text-brand-orange cursor-pointer flex-1 sm:flex-initial text-center">
              TRENDING
            </button>
          </div>
        </div>

        <!-- Product Grid: 4 Desktop, 3 Tablet, 2 Mobile -->
        <div id="home-trending-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
          <!-- Injected via JavaScript -->
        </div>

        <div class="mt-10 text-center">
          <a href="pages/shop.html"
            class="inline-flex items-center gap-2 btn-play-blue text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-md transition font-heading">
            <span>DISCOVER ALL PRODUCTS</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
          </a>
        </div>

      </div>
    </section>

    <!-- 5. SPECIAL TWO-PRODUCT SECTION ("OUR CURRENT FAVOURITES") -->
    <section class="py-12 md:py-16 bg-warm-cream">
      <div class="max-w-7xl mx-auto px-4">

        <div class="text-center max-w-xl mx-auto mb-10">
          <span
            class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
            HANDPICKED STANDOUTS
          </span>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">
            OUR CURRENT FAVOURITES
          </h2>
          <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">
            Two timeless play sets designed for endless creativity and hours of smiles.
          </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">

          <!-- Product 1 Editorial Card -->
          <div
            class="bg-white rounded-3xl border border-brand-border p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6 shadow-sm hover:shadow-lg transition duration-300">
            <div
              class="w-full md:w-1/2 aspect-square bg-soft-yellow rounded-2xl p-6 flex items-center justify-center relative shrink-0">
              <span
                class="absolute top-3 left-3 bg-brand-orange text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full font-heading">
                BEST FOR CREATIVE KIDS
              </span>
              <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=600&q=80"
                alt="Magnetic 3D Architect Tiles" class="max-h-52 w-auto object-contain drop-shadow-sm">
            </div>
            <div class="flex-1 space-y-2.5">
              <span class="text-xs font-bold text-brand-blue uppercase tracking-wider font-heading">STEM & LEARNING •
                AGE 3+</span>
              <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">Magnetic 3D Architect Master Tiles
              </h3>
              <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans line-clamp-3">
                100-piece translucent magnetic geometric tiles engineered for spatial building, geometric intuition, and
                open-ended architectural wonder.
              </p>
              <div class="flex items-baseline gap-2 pt-1 font-heading">
                <span class="text-xl font-bold text-brand-navy">₹2,199</span>
                <span class="text-xs text-brand-muted line-through">₹2,799</span>
                <span class="text-xs font-bold text-brand-orange bg-soft-orange px-2 py-0.5 rounded-full">21% OFF</span>
              </div>
              <div class="pt-2">
                <a href="pages/product.html?slug=magnetic-learning-set"
                  class="inline-flex items-center gap-2 btn-play-orange text-xs px-6 py-2.5 rounded-xl shadow-xs transition font-heading">
                  <span>VIEW PRODUCT</span>
                  <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Product 2 Editorial Card -->
          <div
            class="bg-white rounded-3xl border border-brand-border p-6 sm:p-8 flex flex-col md:flex-row items-center gap-6 shadow-sm hover:shadow-lg transition duration-300">
            <div
              class="w-full md:w-1/2 aspect-square bg-soft-blue rounded-2xl p-6 flex items-center justify-center relative shrink-0">
              <span
                class="absolute top-3 left-3 bg-brand-blue text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full font-heading">
                TOP OUTDOOR PICK
              </span>
              <img src="https://images.unsplash.com/photo-1511886929837-354d827aae26?auto=format&fit=crop&w=600&q=80"
                alt="Match Pro Classic Football" class="max-h-52 w-auto object-contain drop-shadow-xs">
            </div>
            <div class="flex-1 space-y-2.5">
              <span class="text-xs font-bold text-brand-blue uppercase tracking-wider font-heading">SPORTS GOODS • AGE
                9–12</span>
              <h3 class="text-lg sm:text-xl font-bold font-heading text-dark-navy">Match Pro Classic Football - Size 5
              </h3>
              <p class="text-xs sm:text-sm text-body-text leading-relaxed font-sans line-clamp-3">
                Hand-stitched PU leather match ball with latex bladder, inflation pump, and accessories. Built for
                flight accuracy and durable outdoor play.
              </p>
              <div class="flex items-baseline gap-2 pt-1 font-heading">
                <span class="text-xl font-bold text-brand-navy">₹999</span>
                <span class="text-xs text-brand-muted line-through">₹1,299</span>
                <span class="text-xs font-bold text-brand-orange bg-soft-orange px-2 py-0.5 rounded-full">23% OFF</span>
              </div>
              <div class="pt-2">
                <a href="pages/product.html?slug=classic-football"
                  class="inline-flex items-center gap-2 btn-play-blue text-xs px-6 py-2.5 rounded-xl shadow-xs transition font-heading">
                  <span>VIEW PRODUCT</span>
                  <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!-- 6. SHOP BY AGE ("FIND THE RIGHT FIT FOR THEIR AGE") -->
    <section class="py-12 md:py-16 bg-white border-t border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        <div class="text-center max-w-2xl mx-auto mb-10">
          <span
            class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3.5 py-1 rounded-full font-heading">
            AGE DISCOVERY
          </span>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">
            FIND THE RIGHT FIT FOR THEIR AGE
          </h2>
          <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">
            Developmentally aligned play equipment curated for every growth milestone.
          </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-5">

          <!-- 0-2 -->
          <a href="pages/shop.html?age=0-2"
            class="age-card bg-soft-orange border border-orange-200 p-4 sm:p-5 flex flex-col items-center text-center group">
            <div
              class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-brand-orange mb-3 group-hover:scale-110 transition">
              <i class="fa-solid fa-baby"></i>
            </div>
            <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">0–2 Years</span>
            <span class="text-xs font-bold text-brand-orange font-heading mt-0.5">Little Discoverers</span>
            <p class="text-[11px] text-body-text font-sans mt-1">Sensory, textures & soft building</p>
          </a>

          <!-- 3-5 -->
          <a href="pages/shop.html?age=3-5"
            class="age-card bg-soft-yellow border border-amber-200 p-4 sm:p-5 flex flex-col items-center text-center group">
            <div
              class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-amber-500 mb-3 group-hover:scale-110 transition">
              <i class="fa-solid fa-puzzle-piece"></i>
            </div>
            <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">3–5 Years</span>
            <span class="text-xs font-bold text-amber-600 font-heading mt-0.5">Curious Explorers</span>
            <p class="text-[11px] text-body-text font-sans mt-1">Blocks, creative art & basic puzzles</p>
          </a>

          <!-- 6-8 -->
          <a href="pages/shop.html?age=6-8"
            class="age-card bg-soft-blue border border-blue-200 p-4 sm:p-5 flex flex-col items-center text-center group">
            <div
              class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-brand-blue mb-3 group-hover:scale-110 transition">
              <i class="fa-solid fa-rocket"></i>
            </div>
            <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">6–8 Years</span>
            <span class="text-xs font-bold text-brand-blue font-heading mt-0.5">Active Adventurers</span>
            <p class="text-[11px] text-body-text font-sans mt-1">Starter sports, lawn games & sets</p>
          </a>

          <!-- 9-12 -->
          <a href="pages/shop.html?age=9-12"
            class="age-card bg-soft-mint border border-emerald-200 p-4 sm:p-5 flex flex-col items-center text-center group">
            <div
              class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-emerald-600 mb-3 group-hover:scale-110 transition">
              <i class="fa-solid fa-microscope"></i>
            </div>
            <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">9–12 Years</span>
            <span class="text-xs font-bold text-emerald-600 font-heading mt-0.5">Creative Thinkers</span>
            <p class="text-[11px] text-body-text font-sans mt-1">STEM robotics & team athletics</p>
          </a>

          <!-- 12+ -->
          <a href="pages/shop.html?age=12+"
            class="age-card bg-soft-purple border border-purple-200 p-4 sm:p-5 flex flex-col items-center text-center group col-span-2 sm:col-span-1">
            <div
              class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-white shadow-xs flex items-center justify-center text-2xl sm:text-3xl text-purple-600 mb-3 group-hover:scale-110 transition">
              <i class="fa-solid fa-crown"></i>
            </div>
            <span class="text-lg sm:text-xl font-bold font-heading text-dark-navy">12+ Years</span>
            <span class="text-xs font-bold text-purple-600 font-heading mt-0.5">Big Kids & Teens</span>
            <p class="text-[11px] text-body-text font-sans mt-1">Strategy boards, match gear & family</p>
          </a>

        </div>

      </div>
    </section>

    <!-- 7. SHOP BY INTEREST ("WHAT ARE THEY INTO?") -->
    <section class="py-12 md:py-16 bg-warm-cream">
      <div class="max-w-7xl mx-auto px-4">

        <div class="text-center max-w-xl mx-auto mb-10">
          <span
            class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading">
            PASSION & HOBBIES
          </span>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">
            WHAT ARE THEY INTO?
          </h2>
          <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">
            Follow their curiosity with curated interest-based collections.
          </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">

          <a href="pages/shop.html?category=toys"
            class="interest-card bg-soft-orange border border-orange-200 p-4 text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-brand-orange text-white flex items-center justify-center text-lg mx-auto mb-2 shadow-xs group-hover:scale-110 transition">
              <i class="fa-solid fa-cubes"></i>
            </div>
            <span class="font-heading font-bold text-dark-navy text-sm block">BUILD</span>
            <span class="text-[11px] text-body-text font-sans">Blocks & Magnetics</span>
          </a>

          <a href="pages/shop.html?category=activity"
            class="interest-card bg-soft-yellow border border-amber-200 p-4 text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-amber-400 text-dark-navy flex items-center justify-center text-lg mx-auto mb-2 shadow-xs group-hover:scale-110 transition">
              <i class="fa-solid fa-paintbrush"></i>
            </div>
            <span class="font-heading font-bold text-dark-navy text-sm block">CREATE</span>
            <span class="text-[11px] text-body-text font-sans">Art & Craft Kits</span>
          </a>

          <a href="pages/shop.html?category=sports"
            class="interest-card bg-soft-blue border border-blue-200 p-4 text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-brand-blue text-white flex items-center justify-center text-lg mx-auto mb-2 shadow-xs group-hover:scale-110 transition">
              <i class="fa-solid fa-person-running"></i>
            </div>
            <span class="font-heading font-bold text-dark-navy text-sm block">MOVE</span>
            <span class="text-[11px] text-body-text font-sans">Football & Sports</span>
          </a>

          <a href="pages/shop.html?category=games"
            class="interest-card bg-soft-purple border border-purple-200 p-4 text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-purple-500 text-white flex items-center justify-center text-lg mx-auto mb-2 shadow-xs group-hover:scale-110 transition">
              <i class="fa-solid fa-brain"></i>
            </div>
            <span class="font-heading font-bold text-dark-navy text-sm block">THINK</span>
            <span class="text-[11px] text-body-text font-sans">Puzzles & Tactics</span>
          </a>

          <a href="pages/shop.html?category=educational"
            class="interest-card bg-soft-mint border border-emerald-200 p-4 text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-lg mx-auto mb-2 shadow-xs group-hover:scale-110 transition">
              <i class="fa-solid fa-flask"></i>
            </div>
            <span class="font-heading font-bold text-dark-navy text-sm block">DISCOVER</span>
            <span class="text-[11px] text-body-text font-sans">STEM Science Labs</span>
          </a>

          <a href="pages/shop.html?category=outdoor"
            class="interest-card bg-soft-coral border border-rose-200 p-4 text-center group">
            <div
              class="w-12 h-12 rounded-2xl bg-soft-coral text-white flex items-center justify-center text-lg mx-auto mb-2 shadow-xs group-hover:scale-110 transition">
              <i class="fa-solid fa-trophy"></i>
            </div>
            <span class="font-heading font-bold text-dark-navy text-sm block">COMPETE</span>
            <span class="text-[11px] text-body-text font-sans">Lawn Tournaments</span>
          </a>

        </div>

      </div>
    </section>

    <!-- 8. STEM SECTION ("SMART PLAY STARTS HERE" - Soft Mint Background) -->
    <section class="py-12 md:py-16 bg-soft-mint border-y border-emerald-100">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-8 gap-4">
          <div class="max-w-2xl">
            <div class="flex flex-wrap items-center gap-2 mb-2 font-heading text-xs">
              <span class="bg-emerald-600 text-white px-3 py-0.5 rounded-full font-bold">SCIENCE</span>
              <span
                class="bg-white text-emerald-800 border border-emerald-200 px-3 py-0.5 rounded-full font-bold">MATH</span>
              <span
                class="bg-white text-emerald-800 border border-emerald-200 px-3 py-0.5 rounded-full font-bold">BUILD</span>
              <span
                class="bg-white text-emerald-800 border border-emerald-200 px-3 py-0.5 rounded-full font-bold">EXPLORE</span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy">
              SMART PLAY STARTS HERE
            </h2>
            <p class="text-xs sm:text-sm text-body-text mt-2 font-sans">
              Make learning exciting with STEM kits, puzzles, experiments and creative challenges designed for active
              problem solving.
            </p>
          </div>

          <a href="pages/shop.html?category=educational"
            class="btn-play-blue text-xs sm:text-sm px-6 py-3 rounded-xl shadow-xs self-start lg:self-auto font-heading">
            <span>EXPLORE STEM KITS →</span>
          </a>
        </div>

        <div id="home-stem-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
          <!-- Injected via JavaScript -->
        </div>

      </div>
    </section>

    <!-- 9. OUTDOOR PLAY SECTION ("LET'S GET OUTSIDE" - Soft Blue Background) -->
    <section class="py-12 md:py-16 bg-soft-blue border-b border-blue-100">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-8 gap-4">
          <div class="max-w-2xl">
            <span
              class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-white border border-blue-200 px-3 py-1 rounded-full font-heading">
              FRESH AIR & MOVEMENT
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">
              LET'S GET OUTSIDE
            </h2>
            <p class="text-xs sm:text-sm text-body-text mt-2 font-sans">
              More movement. More fresh air. More fun. Explore footballs, badminton sets, lawn games, and park
              essentials.
            </p>
          </div>

          <a href="pages/shop.html?category=outdoor"
            class="btn-play-orange text-xs sm:text-sm px-6 py-3 rounded-xl shadow-xs self-start lg:self-auto font-heading">
            <span>SHOP OUTDOOR PLAY →</span>
          </a>
        </div>

        <div id="home-outdoor-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
          <!-- Injected via JavaScript -->
        </div>

      </div>
    </section>

    <!-- 10. PROMOTIONAL BANNER ("MORE PLAY. MORE MEMORIES.") -->
    <section class="py-12 md:py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4">

        <div
          class="bg-gradient-to-r from-brand-navy via-brand-blue to-brand-navy rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden shadow-xl">
          <!-- Floating decorative stars/bubbles -->
          <div
            class="absolute -right-8 -bottom-8 w-48 h-48 rounded-full bg-brand-orange/30 blur-2xl pointer-events-none">
          </div>
          <div class="absolute top-4 right-1/4 text-play-yellow text-2xl deco-star"><i class="fa-solid fa-star"></i>
          </div>
          <div class="absolute bottom-6 left-1/3 text-sky-blue text-xl deco-star"><i class="fa-solid fa-sparkles"></i>
          </div>

          <div class="relative z-10 max-w-2xl space-y-3 sm:space-y-4">
            <span
              class="inline-block bg-brand-orange text-white text-xs font-bold font-heading px-3.5 py-1 rounded-full uppercase tracking-wider">
              SEASON OF ADVENTURE
            </span>
            <h2 class="text-2xl sm:text-4xl md:text-5xl font-bold font-heading leading-tight">
              MORE PLAY.<br><span class="text-play-yellow">MORE MEMORIES.</span>
            </h2>
            <p class="text-xs sm:text-sm md:text-base text-white/90 font-sans leading-relaxed">
              Discover something exciting for their next adventure. From backyard championships to living room board
              game triumphs.
            </p>
            <div class="pt-2">
              <a href="pages/shop.html"
                class="inline-flex items-center gap-2 btn-play-orange text-xs sm:text-sm px-8 py-3.5 rounded-xl shadow-lg transition font-heading">
                <span>SHOP NOW →</span>
              </a>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- 11. WHY APARATUS PASTIME ("WHY FAMILIES LOVE US") -->
    <section class="py-12 md:py-16 bg-warm-cream border-t border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        <div class="text-center max-w-xl mx-auto mb-10">
          <span
            class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3.5 py-1 rounded-full font-heading">
            OUR COMMITMENT
          </span>
          <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold font-heading text-dark-navy mt-2">
            WHY FAMILIES LOVE US
          </h2>
          <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans">
            Crafting wholesome play experiences with trusted quality and honest care.
          </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

          <div class="bg-white p-5 rounded-2xl border border-brand-border text-center space-y-2.5 shadow-2xs">
            <div
              class="w-12 h-12 rounded-2xl bg-soft-blue text-brand-blue flex items-center justify-center text-xl mx-auto">
              <i class="fa-solid fa-award"></i>
            </div>
            <h4 class="font-heading font-bold text-sm text-dark-navy">QUALITY YOU CAN TRUST</h4>
            <p class="text-[11px] text-body-text font-sans leading-relaxed">Certified non-toxic, BPA-free materials that
              withstand active play.</p>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-brand-border text-center space-y-2.5 shadow-2xs">
            <div
              class="w-12 h-12 rounded-2xl bg-soft-orange text-brand-orange flex items-center justify-center text-xl mx-auto">
              <i class="fa-solid fa-child-reaching"></i>
            </div>
            <h4 class="font-heading font-bold text-sm text-dark-navy">MADE FOR REAL PLAY</h4>
            <p class="text-[11px] text-body-text font-sans leading-relaxed">Open-ended kits that encourage real
              movement, thought, and discovery.</p>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-brand-border text-center space-y-2.5 shadow-2xs">
            <div
              class="w-12 h-12 rounded-2xl bg-soft-yellow text-amber-500 flex items-center justify-center text-xl mx-auto">
              <i class="fa-solid fa-truck-fast"></i>
            </div>
            <h4 class="font-heading font-bold text-sm text-dark-navy">FAST & RELIABLE DELIVERY</h4>
            <p class="text-[11px] text-body-text font-sans leading-relaxed">Safely packed with express tracking straight
              to your doorstep.</p>
          </div>

          <div class="bg-white p-5 rounded-2xl border border-brand-border text-center space-y-2.5 shadow-2xs">
            <div
              class="w-12 h-12 rounded-2xl bg-soft-mint text-emerald-600 flex items-center justify-center text-xl mx-auto">
              <i class="fa-solid fa-rotate-left"></i>
            </div>
            <h4 class="font-heading font-bold text-sm text-dark-navy">EASY RETURNS</h4>
            <p class="text-[11px] text-body-text font-sans leading-relaxed">7-day replacement guarantee so you shop with
              100% confidence.</p>
          </div>

          <div
            class="bg-white p-5 rounded-2xl border border-brand-border text-center space-y-2.5 shadow-2xs col-span-1 sm:col-span-2 lg:col-span-1">
            <div
              class="w-12 h-12 rounded-2xl bg-soft-purple text-purple-600 flex items-center justify-center text-xl mx-auto">
              <i class="fa-solid fa-heart"></i>
            </div>
            <h4 class="font-heading font-bold text-sm text-dark-navy">CAREFULLY CURATED PICKS</h4>
            <p class="text-[11px] text-body-text font-sans leading-relaxed">Only items we would proudly give to our own
              kids and families.</p>
          </div>

        </div>

      </div>
    </section>

    <!-- 12. TESTIMONIALS SLIDER ("WHAT PARENTS ARE SAYING") -->
    <section class="py-12 md:py-16 bg-white border-t border-brand-border overflow-hidden">
      <div class="max-w-7xl mx-auto px-4">

        <!-- Header with Title, Trust Rating & Slider Controls -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 sm:mb-10 gap-4">
          <div>
            <span
              class="text-xs font-bold uppercase tracking-wider text-brand-orange bg-soft-orange px-3.5 py-1 rounded-full font-heading inline-flex items-center gap-1.5 shadow-2xs border border-orange-200/60">
              <i class="fa-solid fa-face-smile text-brand-orange text-xs"></i>
              <span>HAPPY FAMILIES</span>
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold font-heading text-dark-navy mt-2.5 tracking-tight">
              WHAT PARENTS ARE SAYING
            </h2>
            <p class="text-xs sm:text-sm text-body-text mt-1.5 font-sans max-w-lg">
              Real feedback from families and educators who made playtime memorable.
            </p>
          </div>

          <!-- Rating Trust Badge & Navigation Controls -->
          <div class="flex items-center gap-3 sm:gap-4 self-start md:self-auto">
            <!-- Mini Trust Stat -->
            <div class="hidden sm:flex items-center gap-2 bg-soft-yellow/80 border border-amber-200 px-3 py-1.5 rounded-2xl shadow-2xs">
              <div class="flex text-amber-400 text-xs gap-0.5">
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
              </div>
              <span class="text-xs font-bold font-heading text-dark-navy">4.9/5</span>
              <span class="text-[11px] text-brand-muted font-sans">(1,200+ Reviews)</span>
            </div>

            <!-- Arrow Buttons -->
            <div class="flex items-center gap-2">
              <button id="testimonial-prev"
                class="w-10 h-10 rounded-full bg-white hover:bg-brand-orange text-dark-navy hover:text-white border border-brand-border hover:border-brand-orange shadow-2xs flex items-center justify-center transition cursor-pointer"
                aria-label="Previous Review">
                <i class="fa-solid fa-arrow-left text-xs"></i>
              </button>
              <button id="testimonial-next"
                class="w-10 h-10 rounded-full bg-white hover:bg-brand-orange text-dark-navy hover:text-white border border-brand-border hover:border-brand-orange shadow-2xs flex items-center justify-center transition cursor-pointer"
                aria-label="Next Review">
                <i class="fa-solid fa-arrow-right text-xs"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Testimonials Carousel Viewport -->
        <div id="testimonial-slider-container" class="relative overflow-hidden select-none -mx-2 px-2 py-2">
          <div id="testimonial-track" class="flex transition-transform duration-500 ease-out">
            
            <!-- Slide 1: Pooja Sharma -->
            <div class="testimonial-slide w-full md:w-1/2 lg:w-1/3 shrink-0 px-2 sm:px-3">
              <div class="bg-gradient-to-br from-soft-yellow/90 via-white to-soft-yellow/40 border border-amber-200/90 p-6 sm:p-7 rounded-3xl flex flex-col justify-between h-full relative overflow-hidden shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300">
                <i class="fa-solid fa-quote-right absolute top-5 right-5 text-4xl text-amber-500/10 pointer-events-none"></i>
                <div>
                  <div class="flex items-center justify-between gap-2 mb-3">
                    <div class="flex text-amber-400 text-xs gap-0.5">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span class="text-[10px] font-bold text-amber-900 bg-amber-100/90 border border-amber-200 px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-heading">
                      <i class="fa-solid fa-shapes text-brand-orange text-[9px]"></i> Magnetic 3D Tiles
                    </span>
                  </div>
                  <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed italic mb-4">
                    "The Magnetic 3D Tiles kept our 5-year-old completely engaged for hours without touching an iPad. The plastic quality is top-notch with smooth edges and vibrant colors."
                  </p>
                </div>
                <div class="pt-4 border-t border-amber-200/60 flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-amber-500 text-white font-heading font-bold text-xs flex items-center justify-center shadow-xs">
                      PS
                    </div>
                    <div>
                      <h5 class="font-heading font-bold text-dark-navy text-xs sm:text-sm leading-tight">Pooja Sharma</h5>
                      <span class="text-[11px] text-brand-muted font-sans">Parent of 2, Bengaluru</span>
                    </div>
                  </div>
                  <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/90 px-2 py-0.5 rounded-full font-heading inline-flex items-center gap-1 shrink-0">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i> Verified
                  </span>
                </div>
              </div>
            </div>

            <!-- Slide 2: Vikram Mehta -->
            <div class="testimonial-slide w-full md:w-1/2 lg:w-1/3 shrink-0 px-2 sm:px-3">
              <div class="bg-gradient-to-br from-soft-blue/90 via-white to-soft-blue/40 border border-blue-200/90 p-6 sm:p-7 rounded-3xl flex flex-col justify-between h-full relative overflow-hidden shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300">
                <i class="fa-solid fa-quote-right absolute top-5 right-5 text-4xl text-blue-500/10 pointer-events-none"></i>
                <div>
                  <div class="flex items-center justify-between gap-2 mb-3">
                    <div class="flex text-amber-400 text-xs gap-0.5">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span class="text-[10px] font-bold text-brand-navy bg-blue-100/90 border border-blue-200 px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-heading">
                      <i class="fa-solid fa-futbol text-brand-blue text-[9px]"></i> Match Pro Football
                    </span>
                  </div>
                  <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed italic mb-4">
                    "We bought the Match Pro football and cricket starter kit for the weekend park games. Excellent craftsmanship, balanced weight, and the included pump made it a great gift."
                  </p>
                </div>
                <div class="pt-4 border-t border-blue-200/60 flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-brand-navy text-white font-heading font-bold text-xs flex items-center justify-center shadow-xs">
                      VM
                    </div>
                    <div>
                      <h5 class="font-heading font-bold text-dark-navy text-xs sm:text-sm leading-tight">Vikram Mehta</h5>
                      <span class="text-[11px] text-brand-muted font-sans">Dad & Youth Coach, Mumbai</span>
                    </div>
                  </div>
                  <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/90 px-2 py-0.5 rounded-full font-heading inline-flex items-center gap-1 shrink-0">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i> Verified
                  </span>
                </div>
              </div>
            </div>

            <!-- Slide 3: Neha & Rohan K. -->
            <div class="testimonial-slide w-full md:w-1/2 lg:w-1/3 shrink-0 px-2 sm:px-3">
              <div class="bg-gradient-to-br from-soft-mint/90 via-white to-soft-mint/40 border border-emerald-200/90 p-6 sm:p-7 rounded-3xl flex flex-col justify-between h-full relative overflow-hidden shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300">
                <i class="fa-solid fa-quote-right absolute top-5 right-5 text-4xl text-emerald-500/10 pointer-events-none"></i>
                <div>
                  <div class="flex items-center justify-between gap-2 mb-3">
                    <div class="flex text-amber-400 text-xs gap-0.5">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-900 bg-emerald-100/90 border border-emerald-200 px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-heading">
                      <i class="fa-solid fa-chess-knight text-emerald-600 text-[9px]"></i> Board Game Night
                    </span>
                  </div>
                  <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed italic mb-4">
                    "Kingdoms & Conquests became our Friday family tradition. Clear instructions, solid wooden components, and great fun for teenagers and adults alike."
                  </p>
                </div>
                <div class="pt-4 border-t border-emerald-200/60 flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-heading font-bold text-xs flex items-center justify-center shadow-xs">
                      NR
                    </div>
                    <div>
                      <h5 class="font-heading font-bold text-dark-navy text-xs sm:text-sm leading-tight">Neha & Rohan K.</h5>
                      <span class="text-[11px] text-brand-muted font-sans">Family Game Night, Delhi</span>
                    </div>
                  </div>
                  <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/90 px-2 py-0.5 rounded-full font-heading inline-flex items-center gap-1 shrink-0">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i> Verified
                  </span>
                </div>
              </div>
            </div>

            <!-- Slide 4: Ananya Deshmukh -->
            <div class="testimonial-slide w-full md:w-1/2 lg:w-1/3 shrink-0 px-2 sm:px-3">
              <div class="bg-gradient-to-br from-soft-orange/90 via-white to-soft-orange/40 border border-orange-200/90 p-6 sm:p-7 rounded-3xl flex flex-col justify-between h-full relative overflow-hidden shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300">
                <i class="fa-solid fa-quote-right absolute top-5 right-5 text-4xl text-orange-500/10 pointer-events-none"></i>
                <div>
                  <div class="flex items-center justify-between gap-2 mb-3">
                    <div class="flex text-amber-400 text-xs gap-0.5">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span class="text-[10px] font-bold text-orange-900 bg-orange-100/90 border border-orange-200 px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-heading">
                      <i class="fa-solid fa-cubes text-brand-orange text-[9px]"></i> Wooden Sensory Train
                    </span>
                  </div>
                  <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed italic mb-4">
                    "As an early educator, child safety is paramount. Aparatus toys exceeded every expectation—non-toxic organic finish, zero sharp corners, and superb tactile learning!"
                  </p>
                </div>
                <div class="pt-4 border-t border-orange-200/60 flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-brand-orange text-white font-heading font-bold text-xs flex items-center justify-center shadow-xs">
                      AD
                    </div>
                    <div>
                      <h5 class="font-heading font-bold text-dark-navy text-xs sm:text-sm leading-tight">Ananya Deshmukh</h5>
                      <span class="text-[11px] text-brand-muted font-sans">Early Educator & Mom, Pune</span>
                    </div>
                  </div>
                  <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/90 px-2 py-0.5 rounded-full font-heading inline-flex items-center gap-1 shrink-0">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i> Verified
                  </span>
                </div>
              </div>
            </div>

            <!-- Slide 5: Siddharth Roy -->
            <div class="testimonial-slide w-full md:w-1/2 lg:w-1/3 shrink-0 px-2 sm:px-3">
              <div class="bg-gradient-to-br from-soft-purple/90 via-white to-soft-purple/40 border border-purple-200/90 p-6 sm:p-7 rounded-3xl flex flex-col justify-between h-full relative overflow-hidden shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300">
                <i class="fa-solid fa-quote-right absolute top-5 right-5 text-4xl text-purple-500/10 pointer-events-none"></i>
                <div>
                  <div class="flex items-center justify-between gap-2 mb-3">
                    <div class="flex text-amber-400 text-xs gap-0.5">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span class="text-[10px] font-bold text-purple-900 bg-purple-100/90 border border-purple-200 px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-heading">
                      <i class="fa-solid fa-atom text-purple-600 text-[9px]"></i> Solar STEM Rover
                    </span>
                  </div>
                  <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed italic mb-4">
                    "The Solar STEM Robotics kit was a huge surprise. My 7-year-old constructed motorized rovers with real working solar panels. Highly recommended for curious minds!"
                  </p>
                </div>
                <div class="pt-4 border-t border-purple-200/60 flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-purple-600 text-white font-heading font-bold text-xs flex items-center justify-center shadow-xs">
                      SR
                    </div>
                    <div>
                      <h5 class="font-heading font-bold text-dark-navy text-xs sm:text-sm leading-tight">Siddharth Roy</h5>
                      <span class="text-[11px] text-brand-muted font-sans">Tech Dad, Kolkata</span>
                    </div>
                  </div>
                  <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/90 px-2 py-0.5 rounded-full font-heading inline-flex items-center gap-1 shrink-0">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i> Verified
                  </span>
                </div>
              </div>
            </div>

            <!-- Slide 6: Kavita & Amit Patel -->
            <div class="testimonial-slide w-full md:w-1/2 lg:w-1/3 shrink-0 px-2 sm:px-3">
              <div class="bg-gradient-to-br from-soft-sky/90 via-white to-soft-sky/40 border border-sky-200/90 p-6 sm:p-7 rounded-3xl flex flex-col justify-between h-full relative overflow-hidden shadow-2xs hover:shadow-md hover:-translate-y-1 transition duration-300">
                <i class="fa-solid fa-quote-right absolute top-5 right-5 text-4xl text-sky-500/10 pointer-events-none"></i>
                <div>
                  <div class="flex items-center justify-between gap-2 mb-3">
                    <div class="flex text-amber-400 text-xs gap-0.5">
                      <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <span class="text-[10px] font-bold text-sky-900 bg-sky-100/90 border border-sky-200 px-2 py-0.5 rounded-full inline-flex items-center gap-1 font-heading">
                      <i class="fa-solid fa-medal text-brand-blue text-[9px]"></i> Pro Badminton Kit
                    </span>
                  </div>
                  <p class="text-xs sm:text-sm text-body-text font-sans leading-relaxed italic mb-4">
                    "Lightning fast shipping and delightful gift wrap! The badminton racquets are lightweight yet durable for our 10-year-old twins. Outdoor play is now their favorite part of the day."
                  </p>
                </div>
                <div class="pt-4 border-t border-sky-200/60 flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-brand-blue text-white font-heading font-bold text-xs flex items-center justify-center shadow-xs">
                      KP
                    </div>
                    <div>
                      <h5 class="font-heading font-bold text-dark-navy text-xs sm:text-sm leading-tight">Kavita & Amit Patel</h5>
                      <span class="text-[11px] text-brand-muted font-sans">Parents of Twins, Ahmedabad</span>
                    </div>
                  </div>
                  <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100/90 px-2 py-0.5 rounded-full font-heading inline-flex items-center gap-1 shrink-0">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-[9px]"></i> Verified
                  </span>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Slider Pagination Indicator Dots -->
        <div id="testimonial-dots" class="flex items-center justify-center gap-2 mt-6 sm:mt-8">
          <!-- Injected dynamically via JS -->
        </div>

      </div>
    </section>

    <!-- 13. BLOG SECTION ("PLAYROOM INSPIRATION") -->
    <section class="py-12 md:py-16 bg-warm-cream border-t border-brand-border">
      <div class="max-w-7xl mx-auto px-4">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
          <div>
            <span
              class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-3.5 py-1 rounded-full font-heading">
              IDEAS & GUIDES
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold font-heading text-dark-navy mt-2">
              PLAYROOM INSPIRATION
            </h2>
            <p class="text-xs sm:text-sm text-body-text mt-1 font-sans">
              Ideas, guides and inspiration for better playtime.
            </p>
          </div>
          <a href="pages/blog.html"
            class="text-xs sm:text-sm font-bold font-heading text-brand-blue hover:text-brand-orange transition flex items-center gap-1.5 self-start sm:self-auto">
            <span>VIEW ALL INSPIRATION</span>
            <i class="fa-solid fa-arrow-right text-xs"></i>
          </a>
        </div>

        <div id="home-blogs-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Injected via JavaScript -->
        </div>

      </div>
    </section>

  </main>

  <!-- FOOTER CONTAINER (Injected dynamically) -->
  <div id="footer-root"></div>

  <!-- MOBILE BOTTOM NAV CONTAINER -->
  <div id="mobile-bottom-nav-root"></div>

  <!-- JAVASCRIPT INITIALIZATION SCRIPT -->
  <script type="module">
    import { products } from '{{ asset("assets/js/data/products.js") }}';
    import { categories } from '{{ asset("assets/js/data/categories.js") }}';
    import { blogs } from '{{ asset("assets/js/data/blogs.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      // 1. Render Header, Footer, Bottom Nav
      document.getElementById('header-root').innerHTML = Components.renderHeader('home', '');
      document.getElementById('footer-root').innerHTML = Components.renderFooter('');
      document.getElementById('mobile-bottom-nav-root').innerHTML = Components.renderMobileBottomNav('home', '');

      // 2. Initialize Global interactions (Cart drawer, search, quick view, wishlist)
      Components.initGlobalInteractions('');

      // 3. Render Categories Grid (All 7 categories with individual pastel styling)
      const categoriesGrid = document.getElementById('home-categories-grid');
      if (categoriesGrid) {
        categoriesGrid.innerHTML = categories.map(cat => Components.renderCategoryCard(cat, '')).join('');
      }

      // 4. Render Trending Products with Tabs Switcher
      const trendingGrid = document.getElementById('home-trending-grid');
      const tabNewArrivals = document.getElementById('tab-new-arrivals');
      const tabBestSellers = document.getElementById('tab-best-sellers');
      const tabTrending = document.getElementById('tab-trending');

      const renderTrending = (type) => {
        let filtered = [];
        if (type === 'new') {
          filtered = products.filter(p => p.newArrival || p.badge === 'New Arrival').slice(0, 8);
          if (filtered.length < 4) filtered = products.slice(0, 8);
        } else if (type === 'best') {
          filtered = products.filter(p => p.bestSeller || p.badge === 'Best Seller' || p.featured).slice(0, 8);
        } else {
          filtered = products.filter(p => p.trending || p.rating >= 4.7).slice(0, 8);
        }
        if (trendingGrid) {
          trendingGrid.innerHTML = filtered.map(p => Components.renderProductCard(p, '')).join('');
        }
      };

      renderTrending('new');

      const setActiveTab = (activeBtn) => {
        [tabNewArrivals, tabBestSellers, tabTrending].forEach(btn => {
          if (btn === activeBtn) {
            btn.className = 'trending-tab-btn active px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition bg-brand-navy text-white shadow-xs cursor-pointer flex-1 sm:flex-initial text-center';
          } else {
            btn.className = 'trending-tab-btn px-3 sm:px-4 py-2 rounded-xl text-[11px] sm:text-xs font-bold whitespace-nowrap transition text-dark-navy hover:text-brand-orange cursor-pointer flex-1 sm:flex-initial text-center';
          }
        });
      };

      tabNewArrivals?.addEventListener('click', () => {
        setActiveTab(tabNewArrivals);
        renderTrending('new');
      });

      tabBestSellers?.addEventListener('click', () => {
        setActiveTab(tabBestSellers);
        renderTrending('best');
      });

      tabTrending?.addEventListener('click', () => {
        setActiveTab(tabTrending);
        renderTrending('trending');
      });

      // 5. Render STEM Products Grid (4 items)
      const stemGrid = document.getElementById('home-stem-grid');
      if (stemGrid) {
        const stemProds = products.filter(p => p.category === 'educational' || p.ageGroup === '9-12').slice(0, 4);
        stemGrid.innerHTML = stemProds.map(p => Components.renderProductCard(p, '')).join('');
      }

      // 6. Render Outdoor Products Grid (4 items)
      const outdoorGrid = document.getElementById('home-outdoor-grid');
      if (outdoorGrid) {
        const outdoorProds = products.filter(p => p.category === 'outdoor' || p.category === 'sports').slice(0, 4);
        outdoorGrid.innerHTML = outdoorProds.map(p => Components.renderProductCard(p, '')).join('');
      }

      // 7. Render Blog Articles (3 cards)
      const blogsGrid = document.getElementById('home-blogs-grid');
      if (blogsGrid) {
        blogsGrid.innerHTML = blogs.slice(0, 3).map(blog => Components.renderBlogCard(blog, '')).join('');
      }

      // 8. Hero Slider Carousel logic
      const slides = document.querySelectorAll('.hero-slide');
      const dots = document.querySelectorAll('.hero-dot');
      let currentSlide = 0;
      let slideInterval = null;

      const showSlide = (idx) => {
        slides.forEach((s, i) => s.classList.toggle('active', i === idx));
        dots.forEach((d, i) => {
          if (i === idx) {
            d.className = 'hero-dot flex items-center gap-1.5 sm:gap-2 bg-brand-orange text-white px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading shadow-md transition';
            const dotSpan = d.querySelector('span:first-child');
            if (dotSpan) dotSpan.className = 'w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white';
          } else {
            d.className = 'hero-dot flex items-center gap-1.5 sm:gap-2 bg-black/40 hover:bg-black/60 text-white/80 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-[11px] font-bold font-heading transition';
            const dotSpan = d.querySelector('span:first-child');
            if (dotSpan) dotSpan.className = 'w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-white/40';
          }
        });
        currentSlide = idx;
      };

      const nextSlide = () => {
        showSlide((currentSlide + 1) % slides.length);
      };

      const prevSlide = () => {
        showSlide((currentSlide - 1 + slides.length) % slides.length);
      };

      document.getElementById('hero-next')?.addEventListener('click', nextSlide);
      document.getElementById('hero-prev')?.addEventListener('click', prevSlide);
      dots.forEach(dot => {
        dot.addEventListener('click', () => {
          const idx = parseInt(dot.getAttribute('data-slide'));
          showSlide(idx);
        });
      });

      // Auto-slide every 5.5 seconds + pause on hover
      const startAutoSlide = () => {
        slideInterval = setInterval(nextSlide, 5500);
      };
      const stopAutoSlide = () => {
        if (slideInterval) clearInterval(slideInterval);
      };

      const heroContainer = document.getElementById('hero-slider');
      heroContainer?.addEventListener('mouseenter', stopAutoSlide);
      heroContainer?.addEventListener('mouseleave', startAutoSlide);
      startAutoSlide();

      // Mobile Touch Swipe on Hero Slider
      let touchStartX = 0;
      let touchEndX = 0;
      heroContainer?.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });
      heroContainer?.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        if (touchEndX < touchStartX - 40) nextSlide();
        if (touchEndX > touchStartX + 40) prevSlide();
      }, { passive: true });

      // 9. Testimonial Carousel Logic ("WHAT PARENTS ARE SAYING")
      const tTrack = document.getElementById('testimonial-track');
      const tPrev = document.getElementById('testimonial-prev');
      const tNext = document.getElementById('testimonial-next');
      const tDotsContainer = document.getElementById('testimonial-dots');
      const tContainer = document.getElementById('testimonial-slider-container');
      const tSlides = document.querySelectorAll('.testimonial-slide');
      
      let tIndex = 0;
      let tInterval = null;

      const getCardsPerView = () => {
        if (window.innerWidth >= 1024) return 3;
        if (window.innerWidth >= 768) return 2;
        return 1;
      };

      const getMaxIndex = () => {
        const perView = getCardsPerView();
        return Math.max(0, tSlides.length - perView);
      };

      const renderDots = () => {
        if (!tDotsContainer) return;
        const maxIdx = getMaxIndex();
        tDotsContainer.innerHTML = '';
        for (let i = 0; i <= maxIdx; i++) {
          const dot = document.createElement('button');
          dot.className = i === tIndex 
            ? 'w-7 h-2.5 bg-brand-orange rounded-full transition-all duration-300 cursor-pointer shadow-xs' 
            : 'w-2.5 h-2.5 bg-gray-300 hover:bg-gray-400 rounded-full transition-all duration-300 cursor-pointer';
          dot.setAttribute('aria-label', `Go to testimonial slide ${i + 1}`);
          dot.addEventListener('click', () => {
            tIndex = i;
            updateTestimonialSlider();
          });
          tDotsContainer.appendChild(dot);
        }
      };

      const updateTestimonialSlider = () => {
        const perView = getCardsPerView();
        const maxIdx = getMaxIndex();
        if (tIndex > maxIdx) tIndex = maxIdx;
        if (tIndex < 0) tIndex = 0;
        
        const cardPercentage = 100 / perView;
        if (tTrack) {
          tTrack.style.transform = `translateX(-${tIndex * cardPercentage}%)`;
        }

        renderDots();
      };

      const nextTestimonial = () => {
        const maxIdx = getMaxIndex();
        tIndex = (tIndex >= maxIdx) ? 0 : tIndex + 1;
        updateTestimonialSlider();
      };

      const prevTestimonial = () => {
        const maxIdx = getMaxIndex();
        tIndex = (tIndex <= 0) ? maxIdx : tIndex - 1;
        updateTestimonialSlider();
      };

      tNext?.addEventListener('click', nextTestimonial);
      tPrev?.addEventListener('click', prevTestimonial);

      const startTestimonialAuto = () => {
        tInterval = setInterval(nextTestimonial, 5000);
      };
      const stopTestimonialAuto = () => {
        if (tInterval) clearInterval(tInterval);
      };

      tContainer?.addEventListener('mouseenter', stopTestimonialAuto);
      tContainer?.addEventListener('mouseleave', startTestimonialAuto);
      startTestimonialAuto();

      // Mobile Touch Swipe on Testimonials Slider
      let tTouchStartX = 0;
      let tTouchEndX = 0;
      tContainer?.addEventListener('touchstart', (e) => {
        tTouchStartX = e.changedTouches[0].screenX;
      }, { passive: true });
      tContainer?.addEventListener('touchend', (e) => {
        tTouchEndX = e.changedTouches[0].screenX;
        if (tTouchEndX < tTouchStartX - 40) nextTestimonial();
        if (tTouchEndX > tTouchStartX + 40) prevTestimonial();
      }, { passive: true });

      window.addEventListener('resize', () => {
        updateTestimonialSlider();
      });

      updateTestimonialSlider();
    });
  </script>
</body>

</html>