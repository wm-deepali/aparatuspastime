@extends('layouts.app')

@section('title', 'My Wishlist | Aparatus Pastime')
@section('active_nav', 'wishlist')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ url('/') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('account.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Wish List</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('front-pages._sidebar', ['active' => 'wishlist'])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="flex items-center justify-between pb-4 border-b border-brand-border">
            <div>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">MY WISH LIST</h1>
              <p id="wishlist-count-desc" class="text-xs text-brand-muted font-body mt-1">Things they'd love.</p>
            </div>
            <button id="clear-wishlist-btn" class="text-xs text-red-500 hover:text-red-700 font-bold font-heading cursor-pointer">
              Clear Wishlist
            </button>
          </div>

          <!-- Wishlist Grid -->
          <div id="wishlist-products-grid" class="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            <!-- Injected via JavaScript -->
          </div>

          <!-- Empty Wishlist State -->
          <div id="wishlist-empty-state" class="hidden bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 shadow-sm">
            <div class="w-16 h-16 rounded-full bg-soft-yellow text-amber-500 flex items-center justify-center text-2xl mx-auto">
              <i class="fa-regular fa-heart"></i>
            </div>
            <h3 class="font-heading font-extrabold text-lg text-brand-navy">Nothing here yet. Find something they'll love.</h3>
            <p class="text-xs sm:text-sm text-brand-muted max-w-sm mx-auto font-body">
              Explore our toys, games, and active play goods and click the heart icon on any product to save it.
            </p>
            <div class="pt-2">
              <a href="{{ route('shop') }}" class="inline-block bg-brand-orange hover:bg-brand-bright-orange text-white text-xs font-bold font-heading px-6 py-3 rounded-2xl shadow transition">
                EXPLORE TOYS & GAMES →
              </a>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { products } from '{{ asset("assets/js/data/products.js") }}';
    import { State } from '{{ asset("assets/js/state.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const base = @json(url('/') . '/');

      const grid = document.getElementById('wishlist-products-grid');
      const emptyState = document.getElementById('wishlist-empty-state');
      const countDesc = document.getElementById('wishlist-count-desc');

      const renderWishlist = () => {
        const wishIds = State.getWishlist();
        countDesc.textContent = `${wishIds.length} saved item${wishIds.length === 1 ? '' : 's'}`;

        if (wishIds.length === 0) {
          grid.innerHTML = '';
          emptyState.classList.remove('hidden');
          return;
        }

        emptyState.classList.add('hidden');
        const items = products.filter(p => wishIds.includes(p.id));
        grid.innerHTML = items.map(p => Components.renderProductCard(p, base)).join('');
      };

      document.getElementById('clear-wishlist-btn')?.addEventListener('click', () => {
        if (confirm('Clear all items from your wishlist?')) {
          State.saveWishlist([]);
          renderWishlist();
          Components.showToast('Wishlist cleared', 'info');
        }
      });

      renderWishlist();
    });
  </script>
@endpush