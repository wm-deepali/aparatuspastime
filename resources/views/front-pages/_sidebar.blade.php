{{--
  Shared account sidebar.
  Usage:
    @include('front-pages._sidebar', ['active' => 'addresses'])
    @include('front-pages._sidebar', ['active' => 'dashboard', 'withUser' => true])
--}}
@php
  $active   = $active ?? '';
  $withUser = $withUser ?? false;

  $blueHover = 'hover:bg-soft-blue hover:text-brand-blue';

  // [key, route name, icon, label, hover classes]
  $accountNav = [
    ['dashboard',     'account.dashboard',     'fa-shapes',      'My Playroom',     $blueHover],
    ['orders',        'account.orders',        'fa-box-open',    'My Orders',       $blueHover],
    ['track-order',   'account.track-order',   'fa-truck-fast',  'Track Order',     $blueHover],
    ['wishlist',      'account.wishlist',      'fa-heart',       'Wishlist',        'hover:bg-soft-yellow hover:text-amber-800'],
    ['reviews',       'account.reviews',       'fa-star',        'My Reviews',      'hover:bg-soft-purple hover:text-purple-play'],
    ['addresses',     'account.addresses',     'fa-location-dot','Addresses',       $blueHover],
    ['profile',       'account.profile',       'fa-user-pen',    'Profile Details', 'hover:bg-soft-mint hover:text-emerald-700'],
    ['password',      'account.password',      'fa-key',         'Change Password', $blueHover],
    ['notifications', 'account.notifications', 'fa-bell',        'Notifications',   'hover:bg-soft-orange hover:text-brand-orange'],
  ];

  $itemBase   = 'flex items-center gap-3 py-2.5 px-3.5 rounded-2xl transition';
  $itemActive = 'bg-soft-orange text-brand-orange font-bold border border-brand-orange/20';

  // Per-item active style overrides (reviews uses purple)
  $activeStyles = [
    'reviews'  => 'bg-soft-purple text-purple-play font-bold border border-purple-play/30',
    'wishlist' => 'bg-soft-yellow text-amber-800 font-bold border border-play-yellow/40',
  ];
@endphp

<aside class="lg:col-span-3 bg-white rounded-3xl border border-brand-border p-5 space-y-4 shadow-sm">

  @if ($withUser)
    <div class="flex items-center gap-3 pb-4 border-b border-brand-border">
      <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-orange to-play-yellow text-white flex items-center justify-center font-heading font-bold text-xl shadow-xs">
        A
      </div>
      <div class="min-w-0">
        <h3 id="user-name-label" class="font-heading font-bold text-sm text-brand-navy truncate">Aarav Sharma</h3>
        <p id="user-email-label" class="text-xs text-brand-muted truncate font-body">aarav.sharma@example.com</p>
      </div>
    </div>
  @endif

  <nav class="space-y-1 text-xs font-semibold font-heading">
    @foreach ($accountNav as $n)
      @php $isActive = $active === $n[0]; @endphp
      <a href="{{ route($n[1]) }}" class="{{ $itemBase }} {{ $isActive ? ($activeStyles[$n[0]] ?? $itemActive) : $n[4] . ' text-dark-navy' }}">
        <i class="fa-solid {{ $n[2] }} w-4 {{ $isActive ? '' : 'text-brand-muted' }}"></i>
        <span>{{ $n[3] }}</span>
      </a>
    @endforeach

    @if ($withUser)
      <div class="pt-3 border-t border-brand-border">
        <a href="{{ route('login') }}" id="dash-signout-btn" class="flex items-center gap-3 py-2.5 px-3.5 rounded-2xl text-red-600 hover:bg-soft-coral hover:text-red-700 transition">
          <i class="fa-solid fa-arrow-right-from-bracket w-4"></i>
          <span>Sign Out</span>
        </a>
      </div>
    @endif
  </nav>
</aside>