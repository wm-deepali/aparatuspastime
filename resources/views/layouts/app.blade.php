<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Aparatus Pastime | Kids Toys, Games & Sports Goods - Play. Learn. Explore.')</title>
  <meta name="description"
    content="@yield('meta_description', 'Discover premium curated kids toys, board games, sports goods, tactical puzzles, and educational STEM sets at Aparatus Pastime. Built for active play, curiosity, and family fun.')">

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

  @stack('styles')
</head>

@php
  // Active nav key (set per page via the active_nav section, e.g. shop, categories). Defaults to 'home'
  $activeNav = trim($__env->yieldContent('active_nav', 'home'));

  $navBase = 'px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 rounded-xl transition-all duration-200 flex items-center gap-1.5';
  $navOn = 'text-brand-orange bg-orange-50 border border-orange-200/80 shadow-2xs font-extrabold';
  $navOff = 'text-dark-navy hover:text-brand-orange hover:bg-orange-50/70 hover:shadow-2xs';

  // [category slug, icon bg, color token, icon, title, subtitle]
  $megaCategories = [
    ['toys', 'bg-orange-100', 'brand-orange', 'fa-cubes', 'Kids Toys & Building', 'Blocks, Figures & Sets'],
    ['games', 'bg-purple-100', 'purple-600', 'fa-dice-d20', 'Board Games & Puzzles', 'Family, Tactics & Logic'],
    ['sports', 'bg-blue-100', 'brand-blue', 'fa-futbol', 'Sports Goods & Fitness', 'Cricket, Skates & Balls'],
    ['outdoor', 'bg-teal-100', 'teal-600', 'fa-compass', 'Outdoor & Ride-Ons', 'Scooters, Tents & Fun'],
    ['educational', 'bg-emerald-100', 'emerald-600', 'fa-atom', 'STEM & Robotics', 'Science & Solar Kits'],
    ['activity', 'bg-amber-100', 'amber-600', 'fa-palette', 'Creative Arts & Crafts', 'Clay, DIY & Painting'],
    ['gifts', 'bg-rose-100', 'rose-600', 'fa-gift', 'Curated Gift Hampers', 'Birthday & Return Gifts'],
  ];

  // [age query, badge bg, badge label, color token, icon, icon color, title, subtitle]
  $ages = [
    ['0-2', 'bg-orange-500', '0–2', 'brand-orange', 'fa-baby', 'text-brand-orange', 'Infants & Toddlers', 'Sensory & Soft Toys'],
    ['3-5', 'bg-amber-500', '3–5', 'amber-600', 'fa-puzzle-piece', 'text-amber-500', 'Curious Explorers', 'Puzzles, Clay & Learning'],
    ['6-8', 'bg-brand-blue', '6–8', 'brand-blue', 'fa-rocket', 'text-brand-blue', 'Active Adventurers', 'STEM Kits & Sports'],
    ['9-12', 'bg-emerald-600', '9–12', 'emerald-600', 'fa-microscope', 'text-emerald-600', 'Creative Thinkers', 'Robotics & Strategy'],
    ['12+', 'bg-purple-600', '12+', 'purple-600', 'fa-crown', 'text-purple-600', 'Big Kids & Teens', 'Complex Kits & Games'],
  ];

  // [category slug, icon bg, color token, icon, title, subtitle]
  $megaThemes = [
    ['toys', 'bg-orange-100', 'brand-orange', 'fa-cubes', 'Build & Architecture', 'Engineering & 3D Sets'],
    ['sports', 'bg-blue-100', 'brand-blue', 'fa-person-running', 'Move & Athletics', 'Sports, Skates & Action'],
    ['games', 'bg-purple-100', 'purple-600', 'fa-brain', 'Think & Strategy', 'Chess, Logic & Mystery'],
    ['activity', 'bg-amber-100', 'amber-600', 'fa-palette', 'Make & Imagine', 'Arts, Crafts & Pretend'],
    ['educational', 'bg-emerald-100', 'emerald-600', 'fa-flask', 'Discover Science', 'Physics, Biology & Space'],
    ['outdoor', 'bg-teal-100', 'teal-600', 'fa-trophy', 'Lawn Tournaments', 'Family Party & Fun'],
  ];

  // [full url, icon bg, color token, icon, title, subtitle, badge text, badge bg]
  $megaDeals = [
    [route('new-arrivals'), 'bg-orange-100', 'brand-orange', 'fa-sparkles', 'Fresh New Arrivals', "This week's latest drops", 'NEW', 'bg-brand-orange'],
    [route('shop', ['filter' => 'bestseller']), 'bg-red-100', 'red-500', 'fa-fire', 'Top 20 Best Sellers', 'Most loved by parents', 'HOT', 'bg-red-500'],
    [route('shop', ['maxPrice' => 499]), 'bg-emerald-100', 'emerald-600', 'fa-coins', 'Pocket Toys < ₹499', 'Budget-friendly fun', 'SAVER', 'bg-emerald-600'],
    [route('shop', ['maxPrice' => 999]), 'bg-blue-100', 'brand-blue', 'fa-tags', 'Value Picks < ₹999', 'Top-rated smart buys', 'VALUE', 'bg-brand-blue'],
    [route('shop', ['category' => 'gifts']), 'bg-rose-100', 'rose-600', 'fa-gift', 'Birthday Gift Finder', 'Ready-to-gift combos', 'GIFT', 'bg-rose-500'],
    [route('shop', ['filter' => 'trending']), 'bg-purple-100', 'purple-600', 'fa-chart-line', 'Trending This Week', 'Fast selling right now', 'TREND', 'bg-purple-600'],
  ];

  // [shop query params, label]
  $footerTopics = [
    [['category' => 'educational'], '#STEMRobotics'],
    [['category' => 'toys'], '#MagneticTiles'],
    [['category' => 'sports'], '#KashmirWillowCricket'],
    [['category' => 'games'], '#BoardGamesNight'],
    [['category' => 'outdoor'], '#OutdoorAdventures'],
    [['category' => 'activity'], '#ArtStudioEasel'],
    [['category' => 'gifts'], '#BirthdayGiftSets'],
    [['age' => '3-5'], '#PreschoolPlay'],
    [['age' => '9-12'], '#STEMforKids'],
  ];
@endphp

<body class="has-bottom-nav bg-warm-cream text-body-text">

  <!-- ============================================================
       HEADER
       ============================================================ -->

  <!-- TOP MINI STRIP -->
  <div
    class="bg-brand-navy text-white text-[10px] sm:text-xs py-1 sm:py-1.5 px-3 sm:px-4 border-b border-white/10 font-heading">
    <div class="max-w-7xl mx-auto relative flex items-center justify-center min-h-[20px] sm:min-h-[22px]">
      <!-- Centered Free Shipping Announcement -->
      <div class="flex items-center justify-center gap-1.5 sm:gap-2 text-center">
        <span
          class="bg-brand-orange text-white text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 uppercase tracking-tight shadow-2xs">FREE
          SHIPPING</span>
        <span class="tracking-wide text-[10px] sm:text-xs font-semibold">ON ORDERS ABOVE ₹999</span>
      </div>
      <!-- Right-aligned Help Contact (Desktop & Tablet) -->
      <div class="hidden sm:flex items-center gap-2 text-white/90 shrink-0 absolute right-0 top-1/2 -translate-y-1/2">
        <a href="{{ route('contact') }}"
          class="hover:text-play-yellow transition flex items-center gap-1 text-[10px] sm:text-xs font-semibold">
          <i class="fa-solid fa-headset text-play-yellow text-[10px] sm:text-xs"></i>
          <span>Need Help? Contact Us</span>
        </a>
      </div>
    </div>
  </div>

  <!-- MAIN HEADER ROW -->
  <header id="site-header"
    class="bg-white border-b border-brand-border sticky top-0 z-40 transition-all duration-200 shadow-2xs">
    <div class="max-w-7xl mx-auto px-4 py-2.5 sm:py-3">
      <div class="flex items-center justify-between gap-3 sm:gap-6 md:gap-8">

        <!-- Mobile Menu Toggle & Brand Logo -->
        <div class="flex items-center gap-3">
          <button id="mobile-menu-toggle"
            class="lg:hidden text-dark-navy hover:text-brand-orange p-1.5 rounded-xl focus:outline-none transition cursor-pointer"
            aria-label="Open Menu">
            <i class="fa-solid fa-bars text-xl"></i>
          </button>

          <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
            <img src="{{ asset('assets/logo.png') }}" alt="Aparatus Pastime - Kids Toys & Sports"
              class="h-9 sm:h-11 md:h-12 w-auto object-contain">
          </a>
        </div>

        <!-- SEARCH BAR (CENTER) -->
        <div class="hidden md:flex flex-1 max-w-xl relative">
          <form action="{{ route('search') }}" method="GET" class="w-full relative">
            <input type="text" name="q" id="global-search-input" placeholder="Search toys, games, sports & more..."
              autocomplete="off"
              class="w-full pl-11 pr-10 py-2.5 bg-soft-blue/60 hover:bg-soft-blue border border-brand-border rounded-full text-xs sm:text-sm text-dark-navy placeholder:text-brand-muted focus:outline-none focus:border-brand-blue focus:bg-white transition font-sans">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3 text-brand-blue text-sm"></i>
            <button type="button" id="search-clear-btn"
              class="hidden absolute right-3.5 top-2.5 text-brand-muted hover:text-dark-navy cursor-pointer">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </form>

          <!-- LIVE SEARCH SUGGESTIONS DROPDOWN -->
          <div id="search-suggestions-dropdown"
            class="hidden absolute top-full left-0 right-0 mt-2 bg-white border border-brand-border rounded-2xl shadow-2xl z-50 p-4 overflow-hidden font-heading">
            <div class="mb-3">
              <span class="text-[11px] font-bold uppercase tracking-wider text-brand-muted">POPULAR SEARCHES</span>
              <div class="flex flex-wrap gap-1.5 mt-2 font-sans">
                @foreach (['Building Blocks', 'Board Games', 'Football', 'STEM Toys', 'Outdoor Games', 'Birthday Gifts'] as $term)
                  <a href="{{ route('search', ['q' => $term]) }}"
                    class="text-xs bg-soft-blue hover:bg-soft-orange text-dark-navy hover:text-brand-orange px-3 py-1 rounded-full transition font-semibold">
                    <i class="fa-solid fa-sparkles text-[10px] text-play-yellow mr-1"></i>{{ $term }}
                  </a>
                @endforeach
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
          <a href="{{ route('account.wishlist') }}"
            class="relative p-2 text-dark-navy hover:text-brand-orange rounded-xl transition" title="Wishlist">
            <i class="fa-regular fa-heart text-lg sm:text-xl"></i>
            <span id="header-wishlist-count"
              class="hidden absolute top-0.5 right-0.5 bg-brand-orange text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center font-heading">0</span>
          </a>

          <!-- Cart Drawer Trigger -->
          <button id="header-cart-btn"
            class="relative p-2 text-dark-navy hover:text-brand-orange rounded-xl transition cursor-pointer"
            title="Cart">
            <i class="fa-solid fa-bag-shopping text-lg sm:text-xl"></i>
            <span id="header-cart-count"
  class="{{ ($cartCount ?? 0) > 0 ? '' : 'hidden' }} absolute top-0.5 right-0.5 bg-brand-orange text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center font-heading">{{ $cartCount ?? 0 }}</span>
          </button>

          <!-- Account Dropdown -->
          <div class="relative group">
            <a href="{{ route('account.dashboard') }}"
              class="flex items-center gap-1.5 p-2 text-dark-navy hover:text-brand-orange rounded-xl transition">
              <div
                class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-soft-blue text-brand-blue flex items-center justify-center text-sm">
                <i class="fa-solid fa-user"></i>
              </div>
              <span id="header-account-name" class="hidden xl:inline text-xs font-bold font-heading">Account</span>
              <i class="fa-solid fa-chevron-down text-[10px] hidden xl:inline text-brand-muted"></i>
            </a>

            <!-- Account Hover Menu -->
            <div
              class="absolute right-0 top-full mt-1 w-52 bg-white border border-brand-border rounded-2xl shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 font-heading">
              <div class="px-4 py-2 border-b border-brand-border">
                <p class="text-xs text-brand-muted font-sans">Welcome to Playroom,</p>
                <p id="header-user-fullname" class="text-sm font-bold text-dark-navy truncate">Guest Explorer</p>
              </div>
              <a href="{{ route('account.dashboard') }}"
                class="block px-4 py-2 text-xs text-dark-navy hover:bg-soft-blue hover:text-brand-blue transition">
                <i class="fa-solid fa-gauge mr-2 text-brand-blue"></i>My Playroom
              </a>
              <a href="{{ route('account.orders') }}"
                class="block px-4 py-2 text-xs text-dark-navy hover:bg-soft-blue hover:text-brand-blue transition">
                <i class="fa-solid fa-box mr-2 text-brand-blue"></i>My Orders
              </a>
              <a href="{{ route('account.wishlist') }}"
                class="block px-4 py-2 text-xs text-dark-navy hover:bg-soft-blue hover:text-brand-blue transition">
                <i class="fa-solid fa-heart mr-2 text-brand-orange"></i>My Wishlist
              </a>
              <a href="{{ route('account.addresses') }}"
                class="block px-4 py-2 text-xs text-dark-navy hover:bg-soft-blue hover:text-brand-blue transition">
                <i class="fa-solid fa-location-dot mr-2 text-brand-blue"></i>Addresses
              </a>
              <div class="border-t border-brand-border mt-1 pt-1">
                <!-- Logged-in state -->
                <div data-auth="in" class="hidden">
                  <a href="{{ route('login') }}" id="header-logout-btn"
                    class="block px-4 py-2 text-xs text-red-500 hover:bg-red-50 transition">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i>Sign Out
                  </a>
                </div>
                <!-- Guest state -->
                <div data-auth="out">
                  <a href="{{ route('login') }}"
                    class="block px-4 py-2 text-xs text-brand-blue font-bold hover:bg-soft-blue transition">
                    <i class="fa-solid fa-lock mr-2"></i>Sign In / Join Club
                  </a>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

      <!-- MOBILE SEARCH BAR (BELOW MAIN ROW) -->
      <div class="mt-2 md:hidden">
        <form action="{{ route('search') }}" method="GET" class="relative">
          <input type="text" name="q" placeholder="Search toys, games, sports & more..."
            class="w-full pl-9 pr-8 py-2 bg-soft-blue/60 border border-brand-border rounded-full text-xs text-dark-navy placeholder:text-brand-muted focus:outline-none focus:border-brand-blue focus:bg-white font-sans">
          <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-2.5 text-brand-blue text-xs"></i>
        </form>
      </div>
    </div>

    <!-- SECOND NAVIGATION ROW (DESKTOP) -->
    <nav
      class="hidden lg:block border-t border-brand-border/80 bg-white/95 backdrop-blur-md text-xs xl:text-sm font-bold font-heading relative shadow-2xs">
      <div
        class="max-w-[1440px] mx-auto px-3 sm:px-4 lg:px-6 xl:px-8 flex items-center justify-center min-h-[46px] xl:min-h-[50px] relative">
        <div class="flex items-center justify-center gap-1 lg:gap-1.5 xl:gap-2.5 py-1 mx-auto">

          <a href="{{ route('home') }}" class="{{ $navBase }} {{ $activeNav === 'home' ? $navOn : $navOff }}">
            <i
              class="fa-solid fa-house-chimney text-[11px] xl:text-xs {{ $activeNav === 'home' ? 'text-brand-orange' : 'text-slate-400' }}"></i>
            <span>Home</span>
          </a>

          <a href="{{ route('shop') }}" class="{{ $navBase }} {{ $activeNav === 'shop' ? $navOn : $navOff }}">
            <i
              class="fa-solid fa-bag-shopping text-[11px] xl:text-xs {{ $activeNav === 'shop' ? 'text-brand-orange' : 'text-slate-400' }}"></i>
            <span>Shop</span>
          </a>

          <a href="{{ route('categories') }}"
            class="{{ $navBase }} {{ $activeNav === 'categories' ? $navOn : $navOff }}">
            <i
              class="fa-solid fa-shapes text-[11px] xl:text-xs {{ $activeNav === 'categories' ? 'text-brand-orange' : 'text-slate-400' }}"></i>
            <span>Categories</span>
          </a>

          <!-- MEGA MENU TRIGGER -->
          <div class="group py-1">
            <button
              class="px-2.5 lg:px-3 xl:px-4 py-1.5 xl:py-2 text-dark-navy group-hover:text-brand-orange group-hover:bg-orange-50/80 group-hover:border-orange-200/80 border border-transparent rounded-xl transition-all duration-200 flex items-center gap-1.5 focus:outline-none cursor-pointer">
              <i class="fa-solid fa-compass text-[11px] xl:text-xs text-brand-orange"></i>
              <span class="font-bold">Shop By</span>
              <span
                class="bg-gradient-to-r from-brand-orange to-amber-500 text-white text-[8px] xl:text-[9px] font-extrabold px-1.5 py-0.5 rounded-full uppercase tracking-wider shadow-2xs">MEGA</span>
              <i
                class="fa-solid fa-chevron-down text-[9px] text-brand-muted group-hover:text-brand-orange group-hover:rotate-180 transition-transform duration-200"></i>
            </button>

            <!-- MEGA MENU DROPDOWN -->
            <div
              class="mega-menu-container absolute left-0 right-0 top-full w-full bg-white border-b-2 border-brand-orange/40 shadow-2xl z-50 text-dark-navy max-h-[calc(100vh-115px)] overflow-y-auto">

              <!-- Top Rainbow Playful Accent Bar -->
              <div
                class="h-1.5 w-full bg-gradient-to-r from-brand-orange via-amber-400 via-emerald-400 via-brand-blue to-purple-500">
              </div>

              <div
                class="max-w-[1440px] mx-auto px-3 sm:px-4 lg:px-5 xl:px-8 py-3.5 xl:py-5 space-y-3.5 xl:space-y-4 relative z-10">

                <!-- 5-COLUMN DIRECTORY GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-2.5 xl:gap-4 items-stretch">

                  <!-- Col 1: SHOP BY CATEGORY (Warm Coral Card) -->
                  <div
                    class="bg-[#FFF9F5] border border-orange-200/90 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-orange-300 transition-all duration-200">
                    <div class="space-y-2">
                      <div class="flex items-center gap-2 pb-2 border-b border-orange-200/70">
                        <div
                          class="w-6 h-6 xl:w-7 xl:h-7 rounded-lg xl:rounded-xl bg-brand-orange text-white flex items-center justify-center text-[10px] xl:text-xs shadow-2xs shrink-0">
                          <i class="fa-solid fa-shapes"></i>
                        </div>
                        <div class="min-w-0">
                          <h4
                            class="text-[11px] xl:text-xs font-bold uppercase tracking-wider text-dark-navy font-heading truncate">
                            CATEGORIES</h4>
                          <span
                            class="text-[9px] xl:text-[10px] text-brand-muted font-normal font-sans block truncate">Browse
                            by toy type</span>
                        </div>
                      </div>
                      <ul class="space-y-0.5 xl:space-y-1 text-xs font-semibold font-sans">
                        @foreach ($megaCategories as $i)
                          <li>
                            <a href="{{ route('shop', ['category' => $i[0]]) }}"
                              class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                              <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                <div
                                  class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg {{ $i[1] }} text-{{ $i[2] }} flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                  <i class="fa-solid {{ $i[3] }}"></i>
                                </div>
                                <div class="min-w-0">
                                  <div
                                    class="font-heading font-bold text-dark-navy group-hover/link:text-{{ $i[2] }} leading-tight text-[11px] xl:text-xs truncate">
                                    {{ $i[4] }}
                                  </div>
                                  <div
                                    class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">
                                    {{ $i[5] }}
                                  </div>
                                </div>
                              </div>
                              <i
                                class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-{{ $i[2] }} group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="pt-2 border-t border-orange-200 mt-1.5 xl:mt-2">
                      <a href="{{ route('categories') }}"
                        class="inline-flex items-center gap-1.5 text-brand-orange hover:text-dark-navy font-bold font-heading text-[10px] xl:text-xs transition">
                        <span>View All Categories</span>
                        <i class="fa-solid fa-arrow-right text-[8px] xl:text-[10px]"></i>
                      </a>
                    </div>
                  </div>

                  <!-- Col 2: SHOP BY AGE (Sky Blue Card) -->
                  <div
                    class="bg-[#F0F7FF] border border-blue-200/90 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-blue-300 transition-all duration-200">
                    <div class="space-y-2">
                      <div class="flex items-center gap-2 pb-2 border-b border-blue-200/70">
                        <div
                          class="w-6 h-6 xl:w-7 xl:h-7 rounded-lg xl:rounded-xl bg-brand-blue text-white flex items-center justify-center text-[10px] xl:text-xs shadow-2xs shrink-0">
                          <i class="fa-solid fa-child-reaching"></i>
                        </div>
                        <div class="min-w-0">
                          <h4
                            class="text-[11px] xl:text-xs font-bold uppercase tracking-wider text-dark-navy font-heading truncate">
                            BY AGE GROUP</h4>
                          <span
                            class="text-[9px] xl:text-[10px] text-brand-muted font-normal font-sans block truncate">Age-matched
                            discovery</span>
                        </div>
                      </div>
                      <ul class="space-y-0.5 xl:space-y-1.5 text-xs font-semibold font-sans">
                        @foreach ($ages as $a)
                          <li>
                            <a href="{{ route('shop', ['age' => $a[0]]) }}"
                              class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                              <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                <div
                                  class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg {{ $a[1] }} text-white font-heading font-bold text-[9px] xl:text-[10px] flex items-center justify-center shadow-2xs group-hover/link:scale-105 transition shrink-0">
                                  {{ $a[2] }}
                                </div>
                                <div class="min-w-0">
                                  <div
                                    class="font-heading font-bold text-dark-navy group-hover/link:text-{{ $a[3] }} leading-tight flex items-center gap-1 text-[11px] xl:text-xs truncate">
                                    <i class="fa-solid {{ $a[4] }} {{ $a[5] }} text-[8px] xl:text-[9px]"></i>
                                    <span class="truncate">{{ $a[6] }}</span>
                                  </div>
                                  <div
                                    class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">
                                    {{ $a[7] }}
                                  </div>
                                </div>
                              </div>
                              <i
                                class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-{{ $a[3] }} group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="pt-2 border-t border-blue-200 mt-1.5 xl:mt-2">
                      <a href="{{ route('shop') }}"
                        class="inline-flex items-center gap-1.5 text-brand-blue hover:text-dark-navy font-bold font-heading text-[10px] xl:text-xs transition">
                        <span>Find by Milestone Guide</span>
                        <i class="fa-solid fa-arrow-right text-[8px] xl:text-[10px]"></i>
                      </a>
                    </div>
                  </div>

                  <!-- Col 3: SHOP BY INTEREST (Sunny Amber Card) -->
                  <div
                    class="bg-[#FFFDF0] border border-amber-200/90 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-amber-300 transition-all duration-200">
                    <div class="space-y-2">
                      <div class="flex items-center gap-2 pb-2 border-b border-amber-200/70">
                        <div
                          class="w-6 h-6 xl:w-7 xl:h-7 rounded-lg xl:rounded-xl bg-amber-500 text-white flex items-center justify-center text-[10px] xl:text-xs shadow-2xs shrink-0">
                          <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </div>
                        <div class="min-w-0">
                          <h4
                            class="text-[11px] xl:text-xs font-bold uppercase tracking-wider text-dark-navy font-heading truncate">
                            PLAY STYLE</h4>
                          <span
                            class="text-[9px] xl:text-[10px] text-brand-muted font-normal font-sans block truncate">Passion
                            & interests</span>
                        </div>
                      </div>
                      <ul class="space-y-0.5 xl:space-y-1 text-xs font-semibold font-sans">
                        @foreach ($megaThemes as $i)
                          <li>
                            <a href="{{ route('shop', ['category' => $i[0]]) }}"
                              class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                              <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                <div
                                  class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg {{ $i[1] }} text-{{ $i[2] }} flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                  <i class="fa-solid {{ $i[3] }}"></i>
                                </div>
                                <div class="min-w-0">
                                  <div
                                    class="font-heading font-bold text-dark-navy group-hover/link:text-{{ $i[2] }} leading-tight text-[11px] xl:text-xs truncate">
                                    {{ $i[4] }}
                                  </div>
                                  <div
                                    class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">
                                    {{ $i[5] }}
                                  </div>
                                </div>
                              </div>
                              <i
                                class="fa-solid fa-chevron-right text-[7px] xl:text-[8px] text-slate-400 group-hover/link:text-{{ $i[2] }} group-hover/link:translate-x-0.5 transition shrink-0 ml-1"></i>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="pt-2 border-t border-amber-200 mt-1.5 xl:mt-2">
                      <a href="{{ route('shop') }}"
                        class="inline-flex items-center gap-1.5 text-amber-600 hover:text-dark-navy font-bold font-heading text-[10px] xl:text-xs transition">
                        <span>Explore All Themes</span>
                        <i class="fa-solid fa-arrow-right text-[8px] xl:text-[10px]"></i>
                      </a>
                    </div>
                  </div>

                  <!-- Col 4: CURATIONS & DEALS (Soft Rose Card) -->
                  <div
                    class="bg-[#FFF5F7] border border-rose-200/90 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-4 flex flex-col justify-between shadow-2xs hover:shadow-md hover:border-rose-300 transition-all duration-200">
                    <div class="space-y-2">
                      <div class="flex items-center gap-2 pb-2 border-b border-rose-200/70">
                        <div
                          class="w-6 h-6 xl:w-7 xl:h-7 rounded-lg xl:rounded-xl bg-rose-500 text-white flex items-center justify-center text-[10px] xl:text-xs shadow-2xs shrink-0">
                          <i class="fa-solid fa-tags"></i>
                        </div>
                        <div class="min-w-0">
                          <h4
                            class="text-[11px] xl:text-xs font-bold uppercase tracking-wider text-dark-navy font-heading truncate">
                            CURATED & DEALS</h4>
                          <span
                            class="text-[9px] xl:text-[10px] text-brand-muted font-normal font-sans block truncate">Handpicked
                            collections</span>
                        </div>
                      </div>
                      <ul class="space-y-0.5 xl:space-y-1 text-xs font-semibold font-sans">
                        @foreach ($megaDeals as $d)
                          <li>
                            <a href="{{ $d[0] }}"
                              class="p-1 xl:p-1.5 -mx-0.5 rounded-lg xl:rounded-xl hover:bg-white transition flex items-center justify-between group/link">
                              <div class="flex items-center gap-1.5 xl:gap-2 min-w-0">
                                <div
                                  class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg {{ $d[1] }} text-{{ $d[2] }} flex items-center justify-center text-[9px] xl:text-[10px] group-hover/link:scale-110 transition shrink-0">
                                  <i class="fa-solid {{ $d[3] }}"></i>
                                </div>
                                <div class="min-w-0">
                                  <div
                                    class="font-heading font-bold text-dark-navy group-hover/link:text-{{ $d[2] }} leading-tight text-[11px] xl:text-xs truncate">
                                    {{ $d[4] }}
                                  </div>
                                  <div
                                    class="text-[9px] xl:text-[10px] text-brand-muted font-normal truncate hidden sm:block">
                                    {{ $d[5] }}
                                  </div>
                                </div>
                              </div>
                              <span
                                class="text-[8px] xl:text-[9px] font-bold text-white {{ $d[7] }} px-1.5 py-0.5 rounded-full font-heading uppercase shrink-0 ml-1">{{ $d[6] }}</span>
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="pt-2 border-t border-rose-200 mt-1.5 xl:mt-2">
                      <a href="{{ route('shop') }}"
                        class="inline-flex items-center gap-1.5 text-rose-600 hover:text-dark-navy font-bold font-heading text-[10px] xl:text-xs transition">
                        <span>Browse All Curations</span>
                        <i class="fa-solid fa-arrow-right text-[8px] xl:text-[10px]"></i>
                      </a>
                    </div>
                  </div>

                  <!-- Col 5: FEATURED SPOTLIGHT CARD & PROMO -->
                  <div class="flex flex-col justify-between space-y-2 xl:space-y-3">
                    <div
                      class="bg-[#FFFDF4] border-2 border-amber-300 rounded-xl xl:rounded-2xl p-2.5 lg:p-3 xl:p-3.5 flex flex-col justify-between shadow-2xs hover:shadow-md transition-all duration-200 relative overflow-hidden group/spotlight">
                      <div>
                        <div class="flex items-center justify-between mb-1 xl:mb-2">
                          <span
                            class="bg-brand-orange text-white text-[9px] xl:text-[10px] font-bold px-2 py-0.5 rounded-full font-heading uppercase tracking-wide shadow-2xs">
                            <i class="fa-solid fa-crown mr-1 text-play-yellow"></i>TOP SELLER
                          </span>
                          <div
                            class="flex items-center gap-1 text-[10px] xl:text-[11px] font-bold text-dark-navy font-heading">
                            <i class="fa-solid fa-star text-amber-500 text-[10px] xl:text-xs"></i>
                            <span>4.9</span>
                            <span class="text-[8px] xl:text-[9px] text-brand-muted font-normal">(428)</span>
                          </div>
                        </div>
                        <h5 class="font-heading font-bold text-dark-navy text-[11px] xl:text-xs leading-snug truncate">
                          Magnetic 3D Master Tiles</h5>
                        <p class="text-[9px] xl:text-[10px] text-brand-muted mt-0.5 font-sans leading-relaxed truncate">
                          100-piece translucent building set</p>
                      </div>

                      <div
                        class="my-1.5 xl:my-2 flex items-center justify-center p-1.5 xl:p-2 bg-white rounded-lg xl:rounded-xl shadow-xs border border-amber-200/80">
                        <img
                          src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=800&q=80"
                          alt="Magnetic 3D Master Tiles"
                          class="h-14 xl:h-20 w-auto object-contain drop-shadow-md group-hover/spotlight:scale-105 transition duration-300">
                      </div>

                      <div>
                        <div class="flex items-baseline gap-1.5 mb-1.5 font-heading">
                          <span class="text-xs xl:text-sm font-bold text-dark-navy">₹2,199</span>
                          <span class="text-[10px] xl:text-xs text-brand-muted line-through font-normal">₹2,899</span>
                          <span
                            class="text-[8px] xl:text-[9px] font-bold text-white bg-brand-orange px-1.5 py-0.2 rounded-full">24%
                            OFF</span>
                        </div>
                        <a href="{{ route('product', ['slug' => 'magnetic-learning-set']) }}"
                          class="w-full btn-play-orange text-[10px] xl:text-xs py-1.5 xl:py-2 px-2 rounded-lg xl:rounded-xl text-center block transition font-heading font-bold text-white shadow-md hover:shadow-lg truncate">
                          PLAY SOMETHING NEW →
                        </a>
                      </div>
                    </div>

                    <!-- Mini Coupon Banner -->
                    <div
                      class="bg-[#F0F7FF] border border-blue-200 rounded-lg xl:rounded-xl p-2 xl:p-2.5 flex items-center justify-between text-[10px] xl:text-xs font-heading shadow-2xs">
                      <div class="flex items-center gap-1.5 min-w-0">
                        <div
                          class="w-5 h-5 xl:w-6 xl:h-6 rounded-md xl:rounded-lg bg-blue-100 text-brand-blue flex items-center justify-center text-[10px] shrink-0">
                          <i class="fa-solid fa-gift"></i>
                        </div>
                        <div class="min-w-0">
                          <div class="text-[8px] xl:text-[9px] text-brand-muted leading-tight truncate">First Order
                            Discount</div>
                          <div class="font-bold text-dark-navy truncate">10% OFF: <span
                              class="text-brand-orange font-mono font-bold">PLAY10</span></div>
                        </div>
                      </div>
                      <span
                        class="text-[8px] xl:text-[9px] bg-brand-orange text-white px-1.5 py-0.5 rounded-full font-bold shadow-2xs shrink-0 ml-1">ACTIVE</span>
                    </div>
                  </div>

                </div>

                <!-- BOTTOM MINI PERKS STRIP INSIDE MEGA MENU -->
                <div
                  class="bg-[#F8FAFC] -mx-3 -mb-3.5 sm:-mx-4 sm:-mb-3.5 lg:-mx-5 lg:-mb-3.5 xl:-mx-8 xl:-mb-5 px-3 sm:px-4 lg:px-5 xl:px-8 py-2.5 xl:py-3 border-t border-slate-200 flex flex-wrap items-center justify-between gap-2.5 xl:gap-4 text-[10px] xl:text-xs font-heading text-dark-navy">
                  <div class="flex items-center gap-3 xl:gap-6 flex-wrap">
                    <span class="flex items-center gap-1.5 text-dark-navy font-bold">
                      <i class="fa-solid fa-shield-heart text-emerald-500 text-xs xl:text-sm"></i>
                      <span>100% Non-Toxic</span>
                    </span>
                    <span class="flex items-center gap-1.5 text-dark-navy font-bold">
                      <i class="fa-solid fa-truck-fast text-brand-blue text-xs xl:text-sm"></i>
                      <span>Free Shipping &gt; ₹999</span>
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
                  <a href="{{ route('shop') }}"
                    class="text-brand-orange hover:text-dark-navy font-bold flex items-center gap-1 transition shrink-0 ml-auto">
                    <span>Browse Entire Catalog (500+ Toys)</span>
                    <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>

              </div>
            </div>
          </div>

          <a href="{{ route('new-arrivals') }}"
            class="{{ $navBase }} {{ $activeNav === 'new-arrivals' ? $navOn : $navOff }}">
            <i class="fa-solid fa-wand-magic-sparkles text-[11px] xl:text-xs text-emerald-500"></i>
            <span>New Arrivals</span>
            <span
              class="bg-emerald-100 text-emerald-700 text-[8px] xl:text-[9px] font-extrabold px-1.5 py-0.5 rounded-full hidden xl:inline-block leading-none">NEW</span>
          </a>

          <a href="{{ route('shop', ['filter' => 'bestseller']) }}"
            class="{{ $navBase }} {{ $activeNav === 'bestsellers' ? $navOn : $navOff }}">
            <i class="fa-solid fa-fire text-[11px] xl:text-xs text-amber-500"></i>
            <span>Best Sellers</span>
            <span
              class="bg-amber-100 text-amber-800 text-[8px] xl:text-[9px] font-extrabold px-1.5 py-0.5 rounded-full hidden xl:inline-block leading-none">HOT</span>
          </a>

          <a href="{{ route('shop') }}" class="{{ $navBase }} {{ $activeNav === 'age' ? $navOn : $navOff }}">
            <i class="fa-solid fa-child-reaching text-[11px] xl:text-xs text-purple-500"></i>
            <span>Shop By Age</span>
          </a>

          <a href="{{ route('contact') }}" class="{{ $navBase }} {{ $activeNav === 'contact' ? $navOn : $navOff }}">
            <i class="fa-solid fa-headset text-[11px] xl:text-xs text-brand-blue"></i>
            <span>Contact</span>
          </a>

        </div>

        <!-- Certified Safe Pill Badge (ultra-wide screens) -->
        <div
          class="hidden 2xl:flex absolute right-6 text-xs font-bold text-brand-blue items-center gap-1.5 font-heading bg-soft-blue/80 border border-blue-100 px-3 py-1 rounded-full shrink-0 shadow-2xs pointer-events-none">
          <i class="fa-solid fa-shield-halved text-emerald-500"></i>
          <span>100% Non-Toxic & Child-Safe</span>
        </div>

      </div>
    </nav>
  </header>

  <!-- MOBILE & TABLET SIDEBAR NAVIGATION & MEGA MENU DRAWER -->
  <div id="mobile-nav-drawer" class="lg:hidden">
    <div id="mobile-nav-backdrop"
      class="drawer-backdrop fixed inset-0 z-50 bg-black/60 backdrop-blur-xs transition-opacity duration-300"></div>
    <div
      class="mobile-nav-drawer-panel fixed top-0 left-0 bottom-0 w-[88vw] sm:w-[420px] max-w-[480px] bg-white z-50 shadow-2xl flex flex-col justify-between overflow-hidden">

      <!-- Top Rainbow Playful Accent Bar -->
      <div
        class="h-1.5 w-full bg-gradient-to-r from-brand-orange via-amber-400 via-emerald-400 via-brand-blue to-purple-500 shrink-0">
      </div>

      <!-- Drawer Top Brand Bar -->
      <div
        class="p-3.5 sm:p-4 bg-gradient-to-b from-[#FFF9F5] to-white border-b border-brand-border/80 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-2.5">
          <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('assets/logo.png') }}" alt="Aparatus" class="h-8 sm:h-9 w-auto object-contain">
          </a>
          <span
            class="text-[9px] uppercase tracking-wider font-extrabold px-2 py-0.5 rounded-full bg-soft-orange text-brand-orange border border-orange-200 shadow-2xs font-heading">
            PLAY CLUB
          </span>
        </div>
        <button id="close-mobile-nav"
          class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-orange-50 text-dark-navy hover:text-brand-orange flex items-center justify-center transition shadow-2xs cursor-pointer"
          aria-label="Close Menu">
          <i class="fa-solid fa-xmark text-base"></i>
        </button>
      </div>

      <!-- User Greeting Chip / Explorer Pass -->
      <div
        class="px-3.5 sm:px-4 py-2 bg-gradient-to-r from-blue-50/90 via-sky-50/50 to-indigo-50/90 border-b border-blue-100/80 flex items-center justify-between gap-2 shrink-0">
        <div class="flex items-center gap-2.5 min-w-0">
          <div id="drawer-avatar"
            class="w-7 h-7 rounded-full bg-brand-blue text-white flex items-center justify-center text-xs font-bold shrink-0 shadow-2xs font-heading">
            <i class="fa-solid fa-user"></i>
          </div>
          <div class="min-w-0">
            <p id="drawer-greeting" class="text-[11px] font-bold font-heading text-dark-navy truncate">Welcome, Play
              Explorer! 🎈</p>
            <p id="drawer-subgreeting" class="text-[9px] text-brand-blue font-sans font-semibold truncate">Use code
              PLAY15 for 15% OFF</p>
          </div>
        </div>
        <a href="{{ route('login') }}" data-href-in="{{ route('account.dashboard') }}"
          data-href-out="{{ route('login') }}" data-text-in="Dashboard" data-text-out="Sign In"
          class="auth-link text-[10px] font-bold font-heading text-brand-blue hover:text-white hover:bg-brand-blue bg-white px-2.5 py-1 rounded-lg border border-blue-200/80 shrink-0 shadow-2xs transition">Sign
          In</a>
      </div>

      <!-- Drawer Search Bar Quick Access -->
      <div class="px-3.5 sm:px-4 pt-3 shrink-0">
        <form action="{{ route('search') }}" method="GET" class="relative">
          <input type="text" name="q" placeholder="Search 500+ toys, games, sports..."
            class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-dark-navy placeholder:text-brand-muted focus:outline-none focus:border-brand-blue focus:bg-white font-sans">
          <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-brand-blue text-xs"></i>
        </form>
      </div>

      <!-- Drawer Scrollable Content -->
      <div class="p-3.5 sm:p-4 space-y-3 overflow-y-auto flex-1 custom-scrollbar">

        <!-- Quick Core Navigation Grid -->
        <div class="grid grid-cols-2 gap-2">
          <a href="{{ route('home') }}"
            class="flex items-center gap-2 p-2 rounded-xl bg-orange-50/80 border border-orange-200/80 hover:bg-orange-100/80 text-dark-navy hover:text-brand-orange transition shadow-2xs group">
            <div
              class="w-7 h-7 rounded-lg bg-brand-orange text-white flex items-center justify-center text-xs shadow-2xs shrink-0 group-hover:scale-105 transition">
              <i class="fa-solid fa-house-chimney"></i>
            </div>
            <div class="min-w-0">
              <div class="font-heading font-bold text-xs leading-tight">Home</div>
              <div class="text-[9px] text-brand-muted font-sans truncate">Playroom Hub</div>
            </div>
          </a>
          <a href="{{ route('shop') }}"
            class="flex items-center gap-2 p-2 rounded-xl bg-blue-50/80 border border-blue-200/80 hover:bg-blue-100/80 text-dark-navy hover:text-brand-blue transition shadow-2xs group">
            <div
              class="w-7 h-7 rounded-lg bg-brand-blue text-white flex items-center justify-center text-xs shadow-2xs shrink-0 group-hover:scale-105 transition">
              <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div class="min-w-0">
              <div class="font-heading font-bold text-xs leading-tight">Catalog</div>
              <div class="text-[9px] text-brand-muted font-sans truncate">All Products</div>
            </div>
          </a>
          <a href="{{ route('new-arrivals') }}"
            class="flex items-center gap-2 p-2 rounded-xl bg-emerald-50/80 border border-emerald-200/80 hover:bg-emerald-100/80 text-dark-navy hover:text-emerald-700 transition shadow-2xs group">
            <div
              class="w-7 h-7 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs shadow-2xs shrink-0 group-hover:scale-105 transition">
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
          <a href="{{ route('shop', ['filter' => 'bestseller']) }}"
            class="flex items-center gap-2 p-2 rounded-xl bg-amber-50/80 border border-amber-200/80 hover:bg-amber-100/80 text-dark-navy hover:text-amber-700 transition shadow-2xs group">
            <div
              class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs shadow-2xs shrink-0 group-hover:scale-105 transition">
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
          <span
            class="text-[11px] font-extrabold uppercase tracking-wider text-dark-navy font-heading flex items-center gap-1.5">
            <i class="fa-solid fa-compass text-brand-orange"></i>
            <span>SHOP BY MEGA MENU</span>
          </span>
          <span
            class="text-[9px] font-extrabold text-brand-orange bg-orange-100 px-2 py-0.5 rounded-full uppercase tracking-wide">
            DRAWER EXPLORER
          </span>
        </div>

        <!-- 1. CATEGORIES ACCORDION CARD (Warm Coral) -->
        <div class="mobile-drawer-accordion-card bg-[#FFF9F5] border border-orange-200/90 rounded-2xl p-3 shadow-2xs">
          <button type="button"
            class="mobile-drawer-accordion-toggle w-full flex items-center justify-between text-left focus:outline-none cursor-pointer">
            <div class="flex items-center gap-2.5 min-w-0">
              <div
                class="w-7 h-7 rounded-xl bg-brand-orange text-white flex items-center justify-center text-xs shadow-2xs shrink-0">
                <i class="fa-solid fa-shapes"></i>
              </div>
              <div class="min-w-0">
                <div class="font-heading font-bold text-xs text-dark-navy truncate">Popular Categories</div>
                <div class="text-[9px] text-brand-muted font-sans truncate">Toys, Games, Sports & More</div>
              </div>
            </div>
            <div class="flex items-center gap-1.5 shrink-0 ml-2">
              <span
                class="bg-orange-100 text-brand-orange text-[9px] font-extrabold px-1.5 py-0.5 rounded-md font-heading">6</span>
              <i
                class="mobile-drawer-accordion-chevron fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
            </div>
          </button>

          <div
            class="mobile-drawer-accordion-content space-y-1 pt-2.5 mt-2 border-t border-orange-200/70 text-xs font-semibold font-sans">
            <!-- Injected via JavaScript from categories.js -->
            <div id="mobile-drawer-categories" class="space-y-1"></div>
            <div class="pt-1.5 border-t border-orange-100">
              <a href="{{ route('categories') }}"
                class="flex items-center justify-center gap-1.5 text-[11px] font-bold font-heading text-brand-orange hover:text-dark-navy py-1 transition">
                <span>View All Categories</span>
                <i class="fa-solid fa-arrow-right text-[9px]"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- 2. AGE GROUPS ACCORDION CARD (Cool Sky) -->
        <div class="mobile-drawer-accordion-card bg-[#F6FAFD] border border-blue-200/90 rounded-2xl p-3 shadow-2xs">
          <button type="button"
            class="mobile-drawer-accordion-toggle w-full flex items-center justify-between text-left focus:outline-none cursor-pointer">
            <div class="flex items-center gap-2.5 min-w-0">
              <div
                class="w-7 h-7 rounded-xl bg-brand-blue text-white flex items-center justify-center text-xs shadow-2xs shrink-0">
                <i class="fa-solid fa-child"></i>
              </div>
              <div class="min-w-0">
                <div class="font-heading font-bold text-xs text-dark-navy truncate">Shop By Age Group</div>
                <div class="text-[9px] text-brand-muted font-sans truncate">Age-Matched Milestone Guide</div>
              </div>
            </div>
            <div class="flex items-center gap-1.5 shrink-0 ml-2">
              <span
                class="bg-blue-100 text-brand-blue text-[9px] font-extrabold px-1.5 py-0.5 rounded-md font-heading">5</span>
              <i
                class="mobile-drawer-accordion-chevron fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
            </div>
          </button>

          <div
            class="mobile-drawer-accordion-content hidden space-y-1 pt-2.5 mt-2 border-t border-blue-200/70 text-xs font-semibold font-sans">
            @foreach ($ages as $a)
              <a href="{{ route('shop', ['age' => $a[0]]) }}"
                class="p-1.5 rounded-xl hover:bg-white transition flex items-center justify-between text-dark-navy hover:text-{{ $a[3] }} group/item">
                <div class="flex items-center gap-2 min-w-0">
                  <div
                    class="w-6 h-6 rounded-lg {{ $a[1] }} text-white font-heading font-bold text-[9px] flex items-center justify-center shadow-2xs shrink-0">
                    {{ $a[2] }}
                  </div>
                  <div class="min-w-0">
                    <div class="font-heading font-bold text-xs text-dark-navy group-hover/item:text-{{ $a[3] }} truncate">
                      {{ $a[6] }}
                    </div>
                    <div class="text-[9px] text-brand-muted truncate">{{ $a[7] }}</div>
                  </div>
                </div>
                <i
                  class="fa-solid fa-chevron-right text-[8px] text-slate-400 group-hover/item:text-{{ $a[3] }} transition shrink-0"></i>
              </a>
            @endforeach

            <div class="pt-1.5 border-t border-blue-100">
              <a href="{{ route('shop') }}"
                class="flex items-center justify-center gap-1.5 text-[11px] font-bold font-heading text-brand-blue hover:text-dark-navy py-1 transition">
                <span>Find by Milestone Guide</span>
                <i class="fa-solid fa-arrow-right text-[9px]"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- 3. DISCOVERY THEMES ACCORDION CARD (Sunny Amber) -->
        <div class="mobile-drawer-accordion-card bg-[#FFFDF0] border border-amber-200/90 rounded-2xl p-3 shadow-2xs">
          <button type="button"
            class="mobile-drawer-accordion-toggle w-full flex items-center justify-between text-left focus:outline-none cursor-pointer">
            <div class="flex items-center gap-2.5 min-w-0">
              <div
                class="w-7 h-7 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs shadow-2xs shrink-0">
                <i class="fa-solid fa-lightbulb"></i>
              </div>
              <div class="min-w-0">
                <div class="font-heading font-bold text-xs text-dark-navy truncate">Discovery Themes</div>
                <div class="text-[9px] text-brand-muted font-sans truncate">Curated by Play Style</div>
              </div>
            </div>
            <div class="flex items-center gap-1.5 shrink-0 ml-2">
              <span
                class="bg-amber-100 text-amber-700 text-[9px] font-extrabold px-1.5 py-0.5 rounded-md font-heading">4</span>
              <i
                class="mobile-drawer-accordion-chevron fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
            </div>
          </button>

          <div class="mobile-drawer-accordion-content hidden pt-2.5 mt-2 border-t border-amber-200/70">
            <div class="grid grid-cols-2 gap-2">
              <a href="{{ route('shop', ['tag' => 'creative']) }}"
                class="p-2 rounded-xl bg-white border border-amber-100 hover:border-amber-300 hover:shadow-2xs transition group/btn flex flex-col items-center text-center">
                <div
                  class="w-6 h-6 rounded-lg bg-pink-100 text-pink-500 flex items-center justify-center text-xs mb-1 group-hover/btn:scale-110 transition">
                  <i class="fa-solid fa-palette"></i>
                </div>
                <span
                  class="font-heading font-bold text-dark-navy text-[11px] group-hover/btn:text-pink-600 truncate w-full">Arts
                  & Crafts</span>
                <span class="text-[8px] text-brand-muted font-sans">DIY & Painting</span>
              </a>
              <a href="{{ route('shop', ['tag' => 'sports']) }}"
                class="p-2 rounded-xl bg-white border border-amber-100 hover:border-amber-300 hover:shadow-2xs transition group/btn flex flex-col items-center text-center">
                <div
                  class="w-6 h-6 rounded-lg bg-blue-100 text-brand-blue flex items-center justify-center text-xs mb-1 group-hover/btn:scale-110 transition">
                  <i class="fa-solid fa-volleyball"></i>
                </div>
                <span
                  class="font-heading font-bold text-dark-navy text-[11px] group-hover/btn:text-brand-blue truncate w-full">Active
                  Play</span>
                <span class="text-[8px] text-brand-muted font-sans">Fitness & Fun</span>
              </a>
              <a href="{{ route('shop', ['tag' => 'mind']) }}"
                class="p-2 rounded-xl bg-white border border-amber-100 hover:border-amber-300 hover:shadow-2xs transition group/btn flex flex-col items-center text-center">
                <div
                  class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs mb-1 group-hover/btn:scale-110 transition">
                  <i class="fa-solid fa-brain"></i>
                </div>
                <span
                  class="font-heading font-bold text-dark-navy text-[11px] group-hover/btn:text-emerald-600 truncate w-full">Brain
                  Teasers</span>
                <span class="text-[8px] text-brand-muted font-sans">Logic & IQ</span>
              </a>
              <a href="{{ route('shop', ['tag' => 'pretend']) }}"
                class="p-2 rounded-xl bg-white border border-amber-100 hover:border-amber-300 hover:shadow-2xs transition group/btn flex flex-col items-center text-center">
                <div
                  class="w-6 h-6 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-xs mb-1 group-hover/btn:scale-110 transition">
                  <i class="fa-solid fa-masks-theater"></i>
                </div>
                <span
                  class="font-heading font-bold text-dark-navy text-[11px] group-hover/btn:text-amber-600 truncate w-full">Role
                  Play</span>
                <span class="text-[8px] text-brand-muted font-sans">Costumes & Sets</span>
              </a>
            </div>
          </div>
        </div>

        <!-- 4. FEATURED SPOTLIGHT & BEST SELLER (Fresh Emerald) -->
        <div class="mobile-drawer-accordion-card bg-[#F4FAF6] border border-emerald-200/90 rounded-2xl p-3 shadow-2xs">
          <a href="{{ route('product', ['id' => 1]) }}"
            class="flex items-center gap-3 bg-white p-2 rounded-xl border border-emerald-100 hover:border-emerald-300 transition group/spotlight">
            <div class="w-14 h-14 rounded-lg overflow-hidden bg-slate-50 shrink-0 relative">
              <img src="{{ asset('assets/images/products/soccer-ball.jpg') }}" alt="Match Pro Football"
                class="w-full h-full object-cover group-hover/spotlight:scale-105 transition duration-300">
              <span
                class="absolute top-0.5 left-0.5 bg-brand-orange text-white text-[7px] font-bold px-1 rounded font-heading">TOP</span>
            </div>
            <div class="min-w-0 flex-1">
              <span
                class="text-[8px] font-extrabold text-emerald-700 uppercase tracking-wider block font-heading">FEATURED
                STAR</span>
              <h5
                class="font-heading font-bold text-xs text-dark-navy group-hover/spotlight:text-brand-orange transition truncate">
                Match Pro Football - Size 5</h5>
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
          <div
            class="bg-gradient-to-br from-purple-600 to-indigo-700 text-white rounded-xl p-2.5 shadow-xs space-y-1.5 relative overflow-hidden">
            <div class="flex items-center justify-between">
              <span
                class="inline-block bg-amber-400 text-purple-950 text-[8px] font-extrabold px-1.5 py-0.5 rounded font-heading uppercase tracking-wide">PLAY
                CLUB PASS</span>
              <span class="text-amber-300 text-[10px] font-mono font-bold">15% OFF</span>
            </div>
            <h5 class="font-heading font-extrabold text-xs leading-tight">Flat 15% OFF On 1st Order</h5>
            <p class="text-[9px] text-purple-100 font-sans">
              Use code <span
                class="font-mono font-bold text-amber-300 bg-purple-800/60 px-1 py-0.5 rounded">PLAY15</span> at
              checkout
            </p>
            <a href="{{ route('new-arrivals') }}"
              class="inline-block bg-white text-purple-700 hover:bg-amber-300 hover:text-purple-950 font-heading font-bold text-[9px] px-2.5 py-1 rounded-md transition shadow-2xs">
              Claim Discount Now →
            </a>
          </div>

          <!-- Quick Customer Links in Drawer -->
          <div class="pt-1 grid grid-cols-2 gap-1.5 text-[10px] font-heading font-semibold text-dark-navy">
            <a href="{{ route('track-order') }}"
              class="flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-purple-100/70 text-purple-800 transition">
              <i class="fa-solid fa-truck-fast text-[10px] text-purple-600"></i>
              <span>Track Order</span>
            </a>
            <a href="{{ route('faq') }}"
              class="flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-purple-100/70 text-purple-800 transition">
              <i class="fa-regular fa-circle-question text-[10px] text-purple-600"></i>
              <span>Help & FAQ</span>
            </a>
            <a href="{{ route('contact') }}"
              class="flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-purple-100/70 text-purple-800 transition">
              <i class="fa-solid fa-headset text-[10px] text-purple-600"></i>
              <span>Contact Us</span>
            </a>
            <a href="{{ route('about') }}"
              class="flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-purple-100/70 text-purple-800 transition">
              <i class="fa-solid fa-book-open text-[10px] text-purple-600"></i>
              <span>Our Story</span>
            </a>
          </div>
        </div>

      </div>

      <!-- Drawer Sticky Bottom Actions -->
      <div
        class="p-3 sm:p-4 bg-gradient-to-t from-slate-50 to-white border-t border-brand-border/80 space-y-2 shrink-0">
        <!-- Mini Trust Strip -->
        <div class="flex items-center justify-between text-[9px] text-brand-muted font-sans px-1">
          <span class="flex items-center gap-1 font-bold text-dark-navy">
            <i class="fa-solid fa-shield-heart text-emerald-500"></i>Non-Toxic
          </span>
          <span class="flex items-center gap-1 font-bold text-dark-navy">
            <i class="fa-solid fa-truck-fast text-brand-blue"></i>Free Ship &gt; ₹999
          </span>
          <span class="flex items-center gap-1 font-bold text-dark-navy">
            <i class="fa-solid fa-rotate-left text-amber-500"></i>7-Day Return
          </span>
        </div>

        <!-- Primary Big CTA -->
        <a href="{{ route('login') }}" data-href-in="{{ route('account.dashboard') }}"
          data-href-out="{{ route('login') }}"
          class="auth-link w-full btn-play-blue text-xs py-2.5 px-4 rounded-xl flex items-center justify-center gap-2 transition shadow-md font-heading font-bold">
          <i class="fa-regular fa-user"></i>
          <span data-text-in="MY PLAYROOM DASHBOARD" data-text-out="SIGN IN / JOIN PLAY CLUB">SIGN IN / JOIN PLAY
            CLUB</span>
          <i class="fa-solid fa-arrow-right text-[10px] ml-auto"></i>
        </a>
      </div>

    </div>
  </div>

  <!-- ============================================================
       MAIN PAGE CONTENT
       ============================================================ -->
  <main>
    @yield('content')
  </main>

  <!-- ============================================================
       FOOTER
       ============================================================ -->
  <footer
    class="bg-gradient-to-b from-[#072d56] via-[#062444] to-[#041930] text-white font-sans relative overflow-hidden">

    <!-- Ambient Background Glows -->
    <div class="absolute -top-32 left-1/4 w-96 h-96 rounded-full bg-brand-blue/25 blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-20 w-80 h-80 rounded-full bg-brand-orange/20 blur-3xl pointer-events-none">
    </div>
    <div class="absolute -bottom-20 left-10 w-72 h-72 rounded-full bg-mint/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-8 relative z-10">

      <!-- 1. VIP PLAY LOOP & NEWSLETTER BANNER -->
      <div
        class="bg-gradient-to-r from-[#0c4a8a] via-[#083b74] to-[#0c4a8a] border border-white/20 rounded-3xl p-6 sm:p-8 mb-10 shadow-2xl relative overflow-hidden">
        <div class="absolute top-3 right-8 text-play-yellow/40 text-xl deco-star"><i class="fa-solid fa-star"></i></div>
        <div class="absolute bottom-4 right-1/3 text-sky-blue/30 text-lg deco-star"><i class="fa-solid fa-sparkles"></i>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center relative z-10">
          <div class="lg:col-span-7 space-y-2">
            <div
              class="inline-flex items-center gap-2 bg-play-yellow text-dark-navy text-[11px] font-bold font-heading px-3 py-1 rounded-full shadow-xs uppercase tracking-wider">
              <i class="fa-solid fa-sparkles text-brand-orange"></i>
              <span>LET'S STAY IN THE PLAY LOOP</span>
            </div>
            <h3 class="text-2xl sm:text-3xl font-bold font-heading text-white tracking-tight">Get 10% Off Your First
              Order</h3>
            <p class="text-xs sm:text-sm text-white/85 max-w-xl font-sans leading-relaxed">
              Join 15,000+ parents! Get new toy releases, weekend activity ideas, STEM guides, and exclusive member
              discounts.
            </p>
          </div>

          <div class="lg:col-span-5">
            <form id="footer-playclub-form"
              onsubmit="event.preventDefault(); alert('🎉 Yay! Welcome to the Aparatus Play Loop! Use code PLAY10 at checkout for 10% off your order.'); this.reset();"
              class="space-y-2">
              <div
                class="flex flex-col sm:flex-row items-center gap-2 bg-white/15 p-1.5 rounded-2xl border border-white/25 backdrop-blur-md">
                <input type="email" required placeholder="Enter your email address"
                  class="w-full px-4 py-2.5 bg-transparent text-xs sm:text-sm text-white placeholder:text-white/60 focus:outline-none font-sans">
                <button type="submit"
                  class="w-full sm:w-auto btn-play-orange text-xs px-6 py-3 rounded-xl transition shrink-0 flex items-center justify-center gap-2 cursor-pointer font-heading">
                  <span>JOIN THE FUN →</span>
                </button>
              </div>
              <p
                class="text-[11px] text-white/75 text-center sm:text-left flex items-center justify-center sm:justify-start gap-1.5 font-sans">
                <i class="fa-solid fa-shield-heart text-emerald-400"></i>
                <span>Zero spam • Instant 10% coupon code (PLAY10)</span>
              </p>
            </form>
          </div>
        </div>
      </div>

      <!-- 2. TRUST & ASSURANCE STRIP -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-12">
        <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-xl bg-soft-orange/20 text-brand-orange flex items-center justify-center text-lg shrink-0">
            <i class="fa-solid fa-shield-heart"></i>
          </div>
          <div>
            <h5 class="font-heading font-bold text-xs text-white">100% Child-Safe</h5>
            <p class="text-[10px] text-white/70">Non-toxic & EN-71 certified</p>
          </div>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-xl bg-sky-blue/20 text-sky-blue flex items-center justify-center text-lg shrink-0">
            <i class="fa-solid fa-truck-fast"></i>
          </div>
          <div>
            <h5 class="font-heading font-bold text-xs text-white">Free Fast Shipping</h5>
            <p class="text-[10px] text-white/70">On orders above ₹999</p>
          </div>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-mint/20 text-mint flex items-center justify-center text-lg shrink-0"><i
              class="fa-solid fa-rotate-left"></i></div>
          <div>
            <h5 class="font-heading font-bold text-xs text-white">7-Day Easy Returns</h5>
            <p class="text-[10px] text-white/70">Hassle-free replacement</p>
          </div>
        </div>
        <div class="bg-white/5 border border-white/10 rounded-2xl p-3.5 flex items-center gap-3">
          <div
            class="w-10 h-10 rounded-xl bg-purple-play/20 text-purple-play flex items-center justify-center text-lg shrink-0">
            <i class="fa-solid fa-lock"></i>
          </div>
          <div>
            <h5 class="font-heading font-bold text-xs text-white">Secure Checkout</h5>
            <p class="text-[10px] text-white/70">UPI, Cards & Net Banking</p>
          </div>
        </div>
      </div>

      <!-- 3. COMPREHENSIVE FOOTER DIRECTORY -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 mb-12">

        <!-- BRAND & CONTACT CENTER (Span 4) -->
        <div class="lg:col-span-4 space-y-4">

          <a href="{{ route('home') }}"
            class="inline-block bg-white p-3 rounded-2xl shadow-lg border border-white/40 hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('assets/logo.png') }}" alt="Aparatus Pastime" class="h-10 w-auto object-contain">
          </a>

          <div class="space-y-1">
            <span
              class="inline-block bg-brand-orange text-white text-[10px] font-bold font-heading px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-xs">
              KIDS • TOYS • GAMES • ACTIVE PLAY
            </span>
            <p class="text-xs font-bold font-heading text-white tracking-widest uppercase">PLAY. LEARN. EXPLORE.</p>
          </div>

          <p class="text-white/80 text-xs leading-relaxed font-sans max-w-sm">
            Aparatus Pastime curates premium sports equipment, tactical board games, educational STEM kits, and creative
            activity toys built for joyful childhood adventures and family memories.
          </p>

          <!-- Direct Contact Details -->
          <div class="space-y-2 pt-2 text-xs font-sans text-white/85">
            <div class="flex items-center gap-2.5">
              <div
                class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-play-yellow text-xs shrink-0">
                <i class="fa-solid fa-phone"></i>
              </div>
              <span>+91 98765 43210 <span class="text-white/50 text-[11px]">(Mon–Sat, 9AM–7PM)</span></span>
            </div>
            <div class="flex items-center gap-2.5">
              <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-mint text-xs shrink-0"><i
                  class="fa-solid fa-envelope"></i></div>
              <a href="mailto:support@aparatuspastime.com"
                class="hover:text-mint transition">support@aparatuspastime.com</a>
            </div>
            <div class="flex items-center gap-2.5">
              <div
                class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-sky-blue text-xs shrink-0">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <span>Mumbai & Bengaluru, India</span>
            </div>
          </div>

          <!-- Social Media Channels -->
          <div class="pt-2">
            <span class="text-[11px] font-bold font-heading text-white/70 uppercase tracking-wider block mb-2">CONNECT
              WITH US</span>
            <div class="flex items-center gap-2.5">
              <a href="https://instagram.com" target="_blank" rel="noopener"
                class="w-9 h-9 rounded-xl bg-white/10 hover:bg-gradient-to-tr hover:from-amber-500 hover:via-pink-500 hover:to-purple-600 text-white flex items-center justify-center transition hover:scale-110 shadow-xs"
                title="Instagram"><i class="fa-brands fa-instagram"></i></a>
              <a href="https://facebook.com" target="_blank" rel="noopener"
                class="w-9 h-9 rounded-xl bg-white/10 hover:bg-blue-600 text-white flex items-center justify-center transition hover:scale-110 shadow-xs"
                title="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="https://youtube.com" target="_blank" rel="noopener"
                class="w-9 h-9 rounded-xl bg-white/10 hover:bg-red-600 text-white flex items-center justify-center transition hover:scale-110 shadow-xs"
                title="YouTube"><i class="fa-brands fa-youtube"></i></a>
              <a href="https://wa.me/919876543210" target="_blank" rel="noopener"
                class="w-9 h-9 rounded-xl bg-white/10 hover:bg-emerald-500 text-white flex items-center justify-center transition hover:scale-110 shadow-xs"
                title="WhatsApp Support"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
          </div>

        </div>

        <!-- 5 ORGANIZED DIRECTORY COLUMNS (Span 8) -->
        <div class="lg:col-span-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 sm:gap-6">

          <!-- COLUMN 1: SHOP -->
          <div class="space-y-3 font-sans text-xs">
            <h4
              class="font-heading font-bold text-xs uppercase tracking-wider text-play-yellow flex items-center gap-1.5">
              <i class="fa-solid fa-shapes"></i><span>SHOP</span>
            </h4>
            <ul class="space-y-2 text-white/80">
              <li><a href="{{ route('shop', ['category' => 'toys']) }}"
                  class="hover:text-play-yellow transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Kids Toys</a></li>
              <li><a href="{{ route('shop', ['category' => 'games']) }}"
                  class="hover:text-play-yellow transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Board Games</a></li>
              <li><a href="{{ route('shop', ['category' => 'sports']) }}"
                  class="hover:text-play-yellow transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Sports Goods</a></li>
              <li><a href="{{ route('shop', ['category' => 'outdoor']) }}"
                  class="hover:text-play-yellow transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Outdoor Play</a></li>
              <li><a href="{{ route('shop', ['category' => 'educational']) }}"
                  class="hover:text-play-yellow transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>STEM Kits</a></li>
              <li><a href="{{ route('shop', ['category' => 'activity']) }}"
                  class="hover:text-play-yellow transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Creative Arts</a></li>
              <li><a href="{{ route('shop', ['category' => 'gifts']) }}"
                  class="hover:text-play-yellow transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Gifts & Sets</a></li>
              <li><a href="{{ route('categories') }}"
                  class="hover:text-play-yellow transition flex items-center gap-1.5 font-bold text-play-yellow/90"><i
                    class="fa-solid fa-arrow-right text-[9px]"></i>All Categories</a></li>
            </ul>
          </div>

          <!-- COLUMN 2: BY AGE -->
          <div class="space-y-3 font-sans text-xs">
            <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-sky-blue flex items-center gap-1.5">
              <i class="fa-solid fa-child-reaching"></i><span>BY AGE</span>
            </h4>
            <ul class="space-y-2 text-white/80">
              <li><a href="{{ route('shop', ['age' => '0-2']) }}"
                  class="hover:text-sky-blue transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>0–2 Years</a></li>
              <li><a href="{{ route('shop', ['age' => '3-5']) }}"
                  class="hover:text-sky-blue transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>3–5 Years</a></li>
              <li><a href="{{ route('shop', ['age' => '6-8']) }}"
                  class="hover:text-sky-blue transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>6–8 Years</a></li>
              <li><a href="{{ route('shop', ['age' => '9-12']) }}"
                  class="hover:text-sky-blue transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>9–12 Years</a></li>
              <li><a href="{{ route('shop', ['age' => '12+']) }}"
                  class="hover:text-sky-blue transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>12+ Years</a></li>
              <li><a href="{{ route('new-arrivals') }}"
                  class="hover:text-sky-blue transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>New Arrivals</a></li>
              <li><a href="{{ route('shop', ['filter' => 'bestseller']) }}"
                  class="hover:text-sky-blue transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Best Sellers</a></li>
              <li><a href="{{ route('shop', ['filter' => 'trending']) }}"
                  class="hover:text-sky-blue transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Trending Now</a></li>
            </ul>
          </div>

          <!-- COLUMN 3: HELP & CARE -->
          <div class="space-y-3 font-sans text-xs">
            <h4 class="font-heading font-bold text-xs uppercase tracking-wider text-mint flex items-center gap-1.5">
              <i class="fa-solid fa-headset"></i><span>HELP & CARE</span>
            </h4>
            <ul class="space-y-2 text-white/80">
              <li><a href="{{ route('track-order') }}" class="hover:text-mint transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Track Order</a></li>
              <li><a href="{{ route('faq') }}" class="hover:text-mint transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Help & FAQ</a></li>
              <li><a href="{{ route('contact') }}" class="hover:text-mint transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Contact Us</a></li>
              <li><a href="{{ route('shipping-policy') }}"
                  class="hover:text-mint transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Shipping Info</a></li>
              <li><a href="{{ route('returns') }}" class="hover:text-mint transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Easy Returns</a></li>
              <li><a href="{{ route('cancellations') }}" class="hover:text-mint transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Cancellation</a></li>
              <li><a href="{{ route('payment-policy') }}"
                  class="hover:text-mint transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Payment Safety</a></li>
              <li><a href="https://wa.me/919876543210" target="_blank" rel="noopener"
                  class="text-emerald-400 hover:text-emerald-300 transition flex items-center gap-1.5 font-semibold"><i
                    class="fa-brands fa-whatsapp text-[11px]"></i>Live WhatsApp</a></li>
            </ul>
          </div>

          <!-- COLUMN 4: MY ACCOUNT -->
          <div class="space-y-3 font-sans text-xs">
            <h4
              class="font-heading font-bold text-xs uppercase tracking-wider text-purple-play flex items-center gap-1.5">
              <i class="fa-solid fa-user-astronaut"></i><span>MY ACCOUNT</span>
            </h4>
            <ul class="space-y-2 text-white/80">
              <li><a href="{{ route('account.dashboard') }}"
                  class="hover:text-purple-play transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Dashboard</a></li>
              <li><a href="{{ route('account.orders') }}"
                  class="hover:text-purple-play transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>My Orders</a></li>
              <li><a href="{{ route('account.wishlist') }}"
                  class="hover:text-purple-play transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>My Wishlist</a></li>
              <li><a href="{{ route('account.addresses') }}"
                  class="hover:text-purple-play transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Saved Addresses</a></li>
              <li><a href="{{ route('account.reviews') }}"
                  class="hover:text-purple-play transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Product Reviews</a></li>
              <li><a href="{{ route('account.profile') }}"
                  class="hover:text-purple-play transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Profile Details</a></li>
              <li><a href="{{ route('account.password') }}"
                  class="hover:text-purple-play transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Change Password</a></li>
              <li><a href="{{ route('account.notifications') }}"
                  class="hover:text-purple-play transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Notifications</a></li>
            </ul>
          </div>

          <!-- COLUMN 5: ABOUT & INFO -->
          <div class="space-y-3 font-sans text-xs">
            <h4
              class="font-heading font-bold text-xs uppercase tracking-wider text-soft-coral flex items-center gap-1.5">
              <i class="fa-solid fa-heart"></i><span>ABOUT & INFO</span>
            </h4>
            <ul class="space-y-2 text-white/80">
              <li><a href="{{ route('about') }}" class="hover:text-soft-coral transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Our Story</a></li>
              <li><a href="{{ route('blogs') }}" class="hover:text-soft-coral transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Playroom Blog</a></li>
              <li><a href="{{ route('about') }}" class="hover:text-soft-coral transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Safety Standards</a></li>
              <li><a href="{{ route('terms') }}" class="hover:text-soft-coral transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Terms of Service</a></li>
              <li><a href="{{ route('privacy-policy') }}"
                  class="hover:text-soft-coral transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Privacy Policy</a></li>
              <li><a href="{{ route('cookie-policy') }}"
                  class="hover:text-soft-coral transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Cookie Policy</a></li>
              <li><a href="{{ route('search') }}" class="hover:text-soft-coral transition flex items-center gap-1.5"><i
                    class="fa-solid fa-chevron-right text-[9px] opacity-60"></i>Search Toys</a></li>
              <li><a href="{{ route('shop') }}"
                  class="hover:text-soft-coral transition flex items-center gap-1.5 font-bold text-soft-coral/90"><i
                    class="fa-solid fa-arrow-right text-[9px]"></i>View Catalog</a></li>
            </ul>
          </div>

        </div>

      </div>

      <!-- 4. POPULAR PLAY TOPICS -->
      <div class="py-6 border-y border-white/10 my-8">
        <div class="flex flex-col sm:flex-row items-center gap-3">
          <span
            class="font-heading font-bold text-xs uppercase tracking-wider text-play-yellow shrink-0 flex items-center gap-1.5">
            <i class="fa-solid fa-tags text-brand-orange"></i>
            <span>POPULAR PLAY TOPICS:</span>
          </span>
          <div class="flex flex-wrap items-center gap-2 text-xs font-sans">
            @foreach ($footerTopics as $topic)
              <a href="{{ route('shop', $topic[0]) }}"
                class="bg-white/10 hover:bg-brand-orange hover:text-white px-3 py-1 rounded-full text-white/80 transition">{{ $topic[1] }}</a>
            @endforeach
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
          <span>© {{ date('Y') }} Aparatus Pastime. All rights reserved.</span>
        </div>

        <!-- Payment Icons & SSL Badges -->
        <div class="flex flex-wrap items-center justify-center gap-3">
          <span
            class="text-[11px] text-emerald-400 flex items-center gap-1.5 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20 font-heading">
            <i class="fa-solid fa-lock"></i>
            <span>256-Bit SSL Encrypted</span>
          </span>
          <div
            class="flex items-center gap-3 text-lg text-white/80 bg-white/5 px-3.5 py-1 rounded-xl border border-white/10">
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

  <!-- MOBILE BOTTOM NAV CONTAINER (still rendered by components.js) -->
  <div id="mobile-bottom-nav-root"></div>

  <!-- GLOBAL SCRIPT: header state sync, mobile bottom nav, cart drawer, search, wishlist -->
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';
    import { State } from '{{ asset("assets/js/state.js") }}';
    import { categories } from '{{ asset("assets/js/data/categories.js") }}';

    setCount('header-cart-count', State.getCartCount());

    document.addEventListener('DOMContentLoaded', () => {
      const activePage = @json($activeNav);
      const base = @json(url('/') . '/');
      const shopUrl = @json(route('shop'));

      // 1. Mobile bottom nav (still JS-rendered)
      document.getElementById('mobile-bottom-nav-root').innerHTML = Components.renderMobileBottomNav(activePage, base);

      // 2. Mobile drawer categories (from categories.js) — must run BEFORE initGlobalInteractions
      //    so the injected links also get the "close drawer on click" listener.
      const drawerCats = document.getElementById('mobile-drawer-categories');
      if (drawerCats) {
        drawerCats.innerHTML = categories.map(c => `
          <a href="${shopUrl}?category=${c.slug}" class="p-1.5 rounded-xl hover:bg-white transition flex items-center justify-between text-dark-navy hover:text-brand-orange group/item">
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
        `).join('');
      }

      // 3. Sync header state from State (cart / wishlist counts + logged-in user)
      const setCount = (id, n) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = n;
        el.classList.toggle('hidden', !(n > 0));
      };
      setCount('header-cart-count', State.getCartCount());
      setCount('header-wishlist-count', State.getWishlistCount());

      const user = State.getUser() || {};
      const loggedIn = !!user.isLoggedIn;
      const first = user.firstName || '';
      const last = user.lastName || '';

      document.querySelectorAll('[data-auth="in"]').forEach(el => el.classList.toggle('hidden', !loggedIn));
      document.querySelectorAll('[data-auth="out"]').forEach(el => el.classList.toggle('hidden', loggedIn));

      const setText = (id, text) => { const el = document.getElementById(id); if (el) el.textContent = text; };
      setText('header-account-name', loggedIn ? first : 'Account');
      setText('header-user-fullname', loggedIn ? `${first} ${last}`.trim() : 'Guest Explorer');
      setText('drawer-greeting', loggedIn ? `Hi, ${first} ${last}`.trim() : 'Welcome, Play Explorer! 🎈');
      setText('drawer-subgreeting', loggedIn ? 'VIP Playroom Member' : 'Use code PLAY15 for 15% OFF');

      const avatar = document.getElementById('drawer-avatar');
      if (avatar && loggedIn) avatar.textContent = first ? first[0].toUpperCase() : 'U';

      document.querySelectorAll('.auth-link').forEach(a => {
        a.setAttribute('href', loggedIn ? a.dataset.hrefIn : a.dataset.hrefOut);
        if (a.dataset.textIn) a.textContent = loggedIn ? a.dataset.textIn : a.dataset.textOut;
      });
      document.querySelectorAll('.auth-link [data-text-in]').forEach(s => {
        s.textContent = loggedIn ? s.dataset.textIn : s.dataset.textOut;
      });

      // 4. Global interactions (cart drawer, mobile drawer, search, quick view, wishlist)
      Components.initGlobalInteractions(base);
    });
  </script>

  <script>
    (function () {
      // ── Shared config ──────────────────────────────────────────────
      const root = @json(rtrim(url('/'), '/') . '/');
      const addUrl = @json(Route::has('cart.add') ? route('cart.add') : url('cart/add'));
      const cartUrl = @json(url('cart'));
      const csrf = @json(csrf_token());
      const pastels = ['bg-soft-blue', 'bg-soft-yellow', 'bg-soft-mint', 'bg-soft-orange', 'bg-soft-purple'];

      // ── Shared helpers ─────────────────────────────────────────────
      const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
      const money = (n) => '₹' + Number(n).toLocaleString('en-IN');

      function busy(btn, on) {
        if (!btn) return;
        btn.disabled = on;
        btn.classList.toggle('opacity-60', on);
      }

      // ── Toast ──────────────────────────────────────────────────────
      function toast(message, type) {
        let box = document.getElementById('toast-container');
        if (!box) {
          box = document.createElement('div');
          box.id = 'toast-container';
          document.body.appendChild(box);
        }
        const ok = type !== 'error';
        const el = document.createElement('div');
        el.className = 'toast-item ' + (ok ? 'toast-orange' : 'toast-info');
        el.innerHTML = `
      <div class="w-10 h-10 rounded-2xl ${ok ? 'bg-orange-100 text-brand-orange' : 'bg-red-100 text-red-500'} flex items-center justify-center text-lg shrink-0 shadow-2xs">
        <i class="fa-solid ${ok ? 'fa-bag-shopping' : 'fa-circle-exclamation'}"></i>
      </div>
      <div class="flex-1 min-w-0">
        <h6 class="text-[10.5px] sm:text-[11px] uppercase tracking-wider font-bold font-heading text-brand-muted leading-tight">${ok ? 'Added to Play Bag! 🛍️' : 'Could not add'}</h6>
        <p class="text-xs sm:text-[13px] font-bold font-heading text-dark-navy leading-snug line-clamp-2 mt-0.5"></p>
      </div>
      ${ok ? `<a href="${cartUrl}" class="text-[11px] font-bold font-heading text-brand-blue hover:text-brand-orange bg-soft-blue hover:bg-soft-orange px-2.5 py-1.5 rounded-xl transition whitespace-nowrap shrink-0 border border-brand-blue/20">VIEW CART</a>` : ''}
      <button type="button" class="text-gray-400 hover:text-dark-navy p-1.5 rounded-xl hover:bg-gray-100 transition shrink-0 cursor-pointer ml-1" aria-label="Close"><i class="fa-solid fa-xmark text-xs"></i></button>`;
        el.querySelector('p').textContent = message;
        el.querySelector('button').onclick = () => el.remove();
        box.appendChild(el);
        setTimeout(() => el.classList.add('show'), 10);
        setTimeout(() => { el.classList.remove('show'); setTimeout(() => el.remove(), 350); }, 4500);
      }

      function setCount(n) {
        document.querySelectorAll('#header-cart-count, [data-cart-count]').forEach((el) => {
          el.textContent = n;
          el.classList.toggle('hidden', !(n > 0));
        });
      }

      // ── Cart request ───────────────────────────────────────────────
      async function postToCart(fd) {
        const res = await fetch(addUrl, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: fd,
        });

        let data = {};
        try { data = await res.json(); } catch (e) { /* non-JSON response */ }

        if (!res.ok || data.status === false) {
          let msg = data.message || 'Something went wrong. Please try again.';
          if (data.errors) msg = Object.values(data.errors)[0][0];
          const err = new Error(msg);
          err.data = data;
          throw err;
        }
        return data;
      }

      function onAdded(data) {
        if (typeof data.cart_count === 'number') setCount(data.cart_count);
        window.dispatchEvent(new CustomEvent('cart:added', { detail: data }));
      }

      // ── Quick View modal ───────────────────────────────────────────
      let modal = null;
      const onKey = (e) => { if (e.key === 'Escape') closeQuickView(); };

      function closeQuickView() {
        if (!modal) return;
        modal.remove();
        modal = null;
        document.body.style.overflow = '';
        document.removeEventListener('keydown', onKey);
      }

      async function openQuickView(id) {
        closeQuickView();

        const current = document.createElement('div');
        modal = current;
        current.id = 'quick-view-modal';
        current.className = 'fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/60 backdrop-blur-xs';
        current.innerHTML = `
      <div class="bg-white rounded-3xl shadow-2xl max-w-3xl w-full overflow-hidden relative max-h-[90vh] flex flex-col border border-brand-border">
        <button type="button" data-qv-close class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full bg-white/95 text-brand-navy shadow-md hover:bg-brand-orange hover:text-white transition flex items-center justify-center cursor-pointer" aria-label="Close">
          <i class="fa-solid fa-xmark text-sm"></i>
        </button>
        <div id="qv-body" class="flex flex-col md:flex-row overflow-y-auto min-h-[220px] items-center justify-center">
          <div class="p-16 text-brand-muted"><i class="fa-solid fa-spinner fa-spin text-2xl"></i></div>
        </div>
      </div>`;

        current.addEventListener('click', (e) => {
          if (e.target === current || e.target.closest('[data-qv-close]')) closeQuickView();
        });
        document.body.appendChild(current);
        document.body.style.overflow = 'hidden';
        document.addEventListener('keydown', onKey);

        const body = current.querySelector('#qv-body');

        try {
          const res = await fetch(root + 'quick-view/' + encodeURIComponent(id), { headers: { 'Accept': 'application/json' } });
          if (!res.ok) throw new Error('not found');
          const p = await res.json();
          if (modal !== current) return;
          renderQuickView(body, p);
        } catch (err) {
          if (modal !== current) return;
          body.className = 'flex items-center justify-center';
          body.innerHTML = '<div class="p-12 text-center text-sm text-brand-muted font-heading">Sorry, we could not load this product. Please try again.</div>';
        }
      }

      function renderQuickView(body, p) {
        const pastel = pastels[p.id % pastels.length];

        const stars = Array.from({ length: 5 }, (_, i) =>
          `<i class="fa-solid fa-star ${i < Math.floor(p.rating) ? 'star-filled' : 'star-empty'} text-xs"></i>`
        ).join('');

        // badge_color can be "#hex" or Tailwind classes — handle both
        let badgeHtml = '';
        if (p.badge) {
          const color = p.badge.color || '';
          const isHex = color.startsWith('#');
          const cls = isHex ? 'text-white' : (color || 'bg-brand-orange text-white');
          const style = isHex ? ` style="background-color:${esc(color)}"` : '';
          badgeHtml = `<span class="absolute top-4 left-4 ${esc(cls)} text-[11px] font-bold font-heading px-3 py-1 rounded-full shadow-sm uppercase"${style}>${esc(p.badge.text)}</span>`;
        }

        const mainImg = p.images[0]
          ? `<img id="qv-main-img" src="${esc(p.images[0])}" alt="${esc(p.name)}" class="max-h-60 w-auto object-contain rounded-2xl transition duration-300 drop-shadow-sm">`
          : '<i class="fa-solid fa-image text-6xl text-brand-border"></i>';

        const thumbs = p.images.length > 1 ? `
      <div class="flex gap-2 mt-4 flex-wrap justify-center">
        ${p.images.map((img, i) => `
          <button type="button" class="qv-thumb-btn border-2 ${i === 0 ? 'border-brand-blue' : 'border-transparent'} rounded-xl p-1 bg-white w-12 h-12 flex items-center justify-center shadow-xs transition cursor-pointer" data-img="${esc(img)}">
            <img src="${esc(img)}" alt="" class="w-full h-full object-contain rounded-lg">
          </button>`).join('')}
      </div>` : '';

        const priceHtml = `
      <div class="flex items-baseline gap-3 mb-3 font-heading">
        <span class="text-2xl font-bold text-brand-navy">${money(p.price)}</span>
        ${p.mrp ? `<span class="text-sm text-brand-muted line-through">${money(p.mrp)}</span>
        <span class="text-xs font-bold text-brand-orange bg-soft-orange px-2 py-0.5 rounded-full">${p.discount}% OFF</span>` : ''}
      </div>`;

        const stockHtml = p.in_stock
          ? `<div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 mb-4 bg-emerald-50 px-3 py-2 rounded-xl"><i class="fa-solid fa-circle-check text-emerald-500"></i><span>In Stock (${p.stock} units) • Ready to ship</span></div>`
          : `<div class="flex items-center gap-2 text-xs font-semibold text-red-600 mb-4 bg-red-50 px-3 py-2 rounded-xl"><i class="fa-solid fa-circle-xmark text-red-500"></i><span>Out of Stock</span></div>`;

        const maxQty = Math.max(p.stock, p.min_qty);

        body.className = 'flex flex-col md:flex-row overflow-y-auto';
        body.innerHTML = `
      <div class="md:w-1/2 p-6 ${pastel} flex flex-col items-center justify-center relative shrink-0">
        ${badgeHtml}
        ${mainImg}
        ${thumbs}
      </div>

      <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-between">
        <div>
          <div class="flex flex-wrap items-center gap-2 mb-2">
            ${p.category ? `<span class="text-xs font-bold uppercase tracking-wider text-brand-blue bg-soft-blue px-2.5 py-0.5 rounded-full font-heading">${esc(p.category)}</span>` : ''}
            ${p.age_label ? `<span class="text-xs font-bold text-brand-navy bg-play-yellow/30 px-2.5 py-0.5 rounded-full font-heading">AGE: ${esc(p.age_label)}</span>` : ''}
          </div>

          <h2 class="text-xl md:text-2xl font-bold font-heading text-dark-navy mb-2 leading-snug">${esc(p.name)}</h2>

          <div class="flex items-center gap-2 mb-3">
            <div class="flex items-center">${stars}</div>
            <span class="text-xs font-bold text-dark-navy">${Number(p.rating).toFixed(1)}</span>
            <span class="text-xs text-brand-muted font-sans">(${p.reviews_count} reviews)</span>
          </div>

          ${priceHtml}

          ${p.short_description ? `<p class="text-xs text-body-text leading-relaxed mb-4 font-sans line-clamp-3">${esc(p.short_description)}</p>` : ''}

          ${stockHtml}
        </div>

        <div>
          <form method="POST" action="${esc(addUrl)}" data-cart-form class="flex items-center gap-3 mb-3">
            <input type="hidden" name="_token" value="${esc(csrf)}">
            <input type="hidden" name="product_id" value="${p.id}">

            <div class="flex items-center border border-brand-border rounded-xl bg-white shadow-xs p-0.5">
              <button type="button" id="qv-qty-minus" class="w-8 h-8 rounded-lg text-brand-navy hover:bg-soft-blue hover:text-brand-blue font-bold transition flex items-center justify-center cursor-pointer shrink-0"><i class="fa-solid fa-minus text-xs"></i></button>
              <input id="qv-qty-input" name="quantity" type="number" value="${p.min_qty}" min="${p.min_qty}" max="${maxQty}" class="w-10 h-8 text-center text-sm font-bold text-dark-navy font-heading focus:outline-none p-0 m-0 bg-transparent leading-none" readonly>
              <button type="button" id="qv-qty-plus" class="w-8 h-8 rounded-lg text-brand-navy hover:bg-soft-blue hover:text-brand-blue font-bold transition flex items-center justify-center cursor-pointer shrink-0"><i class="fa-solid fa-plus text-xs"></i></button>
            </div>

            <button type="submit" ${p.in_stock ? '' : 'disabled'} class="flex-1 btn-play-orange py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center gap-2 text-xs sm:text-sm font-heading font-bold cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
              <i class="fa-solid fa-bag-shopping"></i><span>ADD TO CART</span>
            </button>
          </form>

          ${p.min_qty > 1 ? `<p class="text-[11px] text-brand-muted font-sans mb-2">Minimum order quantity: ${p.min_qty}</p>` : ''}

          <div class="pt-3 border-t border-brand-border text-xs font-heading">
            <a href="${esc(p.url)}" class="text-brand-blue hover:text-brand-orange font-bold flex items-center gap-1.5 transition">
              <span>View Full Details & Specs</span>
              <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
          </div>
        </div>
      </div>`;

        // Thumbnails
        const mainEl = body.querySelector('#qv-main-img');
        const thumbBtns = body.querySelectorAll('.qv-thumb-btn');
        thumbBtns.forEach((t) => t.addEventListener('click', () => {
          thumbBtns.forEach((b) => { b.classList.remove('border-brand-blue'); b.classList.add('border-transparent'); });
          t.classList.remove('border-transparent');
          t.classList.add('border-brand-blue');
          if (mainEl) mainEl.src = t.dataset.img;
        }));

        // Qty stepper
        const qty = body.querySelector('#qv-qty-input');
        body.querySelector('#qv-qty-minus').addEventListener('click', () => {
          const v = parseInt(qty.value) || p.min_qty;
          if (v > p.min_qty) qty.value = v - 1;
        });
        body.querySelector('#qv-qty-plus').addEventListener('click', () => {
          const v = parseInt(qty.value) || p.min_qty;
          if (v < maxQty) qty.value = v + 1;
        });
      }

      // ── Event wiring ───────────────────────────────────────────────

      // Quick View trigger (delegated, works on every product card)
      document.addEventListener('click', (e) => {
        const btn = e.target.closest('.quick-view-btn');
        if (!btn) return;
        e.preventDefault();
        openQuickView(btn.dataset.id);
      });

      // 1) Product-card "ADD TO CART" button
      document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.add-to-cart-btn');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();
        if (btn.disabled) return;

        const fd = new FormData();
        fd.append('product_id', btn.dataset.id); // qty omitted → controller uses min_qty
        busy(btn, true);
        try {
          const data = await postToCart(fd);
          onAdded(data);
          toast(data.product_name ? data.product_name + ' added to your play bag!' : data.message, 'ok');
        } catch (err) {
          toast(err.message, 'error');
        } finally {
          busy(btn, false);
        }
      }, true);

      // 2) Forms marked data-cart-form (Quick View modal, product page)
      document.addEventListener('submit', async (e) => {
        const form = e.target.closest('form[data-cart-form]');
        if (!form) return;
        e.preventDefault();

        const submitter = e.submitter;
        const buyNow = submitter && submitter.name === 'buy_now';
        const fd = new FormData(form);
        if (buyNow) fd.set('buy_now', '1');

        busy(submitter, true);
        try {
          const data = await postToCart(fd);
          onAdded(data);
          if (data.redirect) { window.location.href = data.redirect; return; }
          if (form.closest('#quick-view-modal')) closeQuickView();
          toast(data.product_name ? data.product_name + ' added to your play bag!' : data.message, 'ok');
        } catch (err) {
          toast(err.message, 'error');
        } finally {
          busy(submitter, false);
        }
      });

      // 3) Bundle form ("Add both to cart") — one request per product
      document.addEventListener('submit', async (e) => {
        const form = e.target.closest('form[data-bundle-form]');
        if (!form) return;
        e.preventDefault();

        const ids = Array.from(form.querySelectorAll('input[name="product_ids[]"]')).map((i) => i.value);
        busy(e.submitter, true);
        try {
          let last = null;
          for (const id of ids) { // sequential: both calls share one cart row
            const fd = new FormData();
            fd.append('product_id', id);
            last = await postToCart(fd);
          }
          onAdded(last);
          toast('Both items added to your play bag!', 'ok');
        } catch (err) {
          toast(err.message, 'error');
        } finally {
          busy(e.submitter, false);
        }
      });
    })();
  </script>
  @include('front-pages.partials.mini-cart')
  <!-- PAGE SPECIFIC SCRIPTS -->
  @stack('scripts')
</body>

</html>