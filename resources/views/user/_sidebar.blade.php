{{--
Shared account sidebar.
Usage:
@include('user._sidebar', ['active' => 'addresses'])
@include('user._sidebar', ['active' => 'dashboard', 'withUser' => true])
--}}
@php
  $active = $active ?? '';
  $withUser = $withUser ?? false;

  $blueHover = 'hover:bg-soft-blue hover:text-brand-blue';

  // [key, route name, icon, label, hover classes]
  $accountNav = [
    ['dashboard', 'user.dashboard', 'fa-shapes', 'My Playroom', $blueHover],
    ['orders', 'user.orders', 'fa-box-open', 'My Orders', $blueHover],
    ['track-order', 'user.track-order', 'fa-truck-fast', 'Track Order', $blueHover],
    ['wishlist', 'user.wishlist', 'fa-heart', 'Wishlist', 'hover:bg-soft-yellow hover:text-amber-800'],
    ['reviews', 'user.reviews', 'fa-star', 'My Reviews', 'hover:bg-soft-purple hover:text-purple-play'],
    ['addresses', 'user.addresses', 'fa-location-dot', 'Addresses', $blueHover],
    ['profile', 'user.profile', 'fa-user-pen', 'Profile Details', 'hover:bg-soft-mint hover:text-emerald-700'],
    ['password', 'user.password', 'fa-key', 'Change Password', $blueHover],
    ['notifications', 'user.notifications', 'fa-bell', 'Notifications', 'hover:bg-soft-orange hover:text-brand-orange'],
  ];

  $itemBase = 'flex items-center gap-3 py-2.5 px-3.5 rounded-2xl transition';
  $itemActive = 'bg-soft-orange text-brand-orange font-bold border border-brand-orange/20';

  // Per-item active style overrides (reviews uses purple)
  $activeStyles = [
    'reviews' => 'bg-soft-purple text-purple-play font-bold border border-purple-play/30',
    'wishlist' => 'bg-soft-yellow text-amber-800 font-bold border border-play-yellow/40',
  ];

  // Logged-in customer (tries the customer guard first, then the default guard)
  $customer = auth('customer')->user() ?? auth()->user();
  $customerName = $customer->name ?? 'Guest';
  $customerEmail = $customer->email ?? '';
  $customerInitial = strtoupper(mb_substr(trim($customerName), 0, 1)) ?: 'G';
@endphp

<aside class="lg:col-span-3 bg-white rounded-3xl border border-brand-border p-5 space-y-4 shadow-sm">

  @if ($withUser)
    <div class="flex items-center gap-3 pb-4 border-b border-brand-border">
      <div
        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-orange to-play-yellow text-white flex items-center justify-center font-heading font-bold text-xl shadow-xs">
        {{ $customerInitial }}
      </div>
      <div class="min-w-0">
        <h3 id="user-name-label" class="font-heading font-bold text-sm text-brand-navy truncate">{{ $customerName }}</h3>
        <p id="user-email-label" class="text-xs text-brand-muted truncate font-body">{{ $customerEmail }}</p>
      </div>
    </div>
  @endif

  <nav class="space-y-1 text-xs font-semibold font-heading">
    @foreach ($accountNav as $n)
      @php $isActive = $active === $n[0]; @endphp
      <a href="{{ route($n[1]) }}"
        class="{{ $itemBase }} {{ $isActive ? ($activeStyles[$n[0]] ?? $itemActive) : $n[4] . ' text-dark-navy' }}">
        <i class="fa-solid {{ $n[2] }} w-4 {{ $isActive ? '' : 'text-brand-muted' }}"></i>
        <span>{{ $n[3] }}</span>
      </a>
    @endforeach

    @if ($withUser)
      <div class="pt-3 border-t border-brand-border">
        <form method="POST" action="{{ route('user.logout') }}">
          @csrf
          <button type="submit" id="dash-signout-btn"
            class="w-full flex items-center gap-3 py-2.5 px-3.5 rounded-2xl text-red-600 hover:bg-soft-coral hover:text-red-700 transition text-left">
            <i class="fa-solid fa-arrow-right-from-bracket w-4"></i>
            <span>Sign Out</span>
          </button>
        </form>
      </div>
    @endif
  </nav>
</aside>