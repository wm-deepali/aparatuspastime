@extends('layouts.app')

@php
  $loggedIn = auth('customer')->check();
@endphp

@section('title', 'My Wishlist | Aparatus Pastime')
@section('active_nav', 'wishlist')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        @if ($loggedIn)
          <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
          <a href="{{ route('user.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        @endif
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Wish List</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR (logged-in customers only) -->
        @if ($loggedIn)
          @include('user._sidebar', ['active' => 'wishlist'])
        @endif

        <!-- MAIN CONTENT -->
        <div class="{{ $loggedIn ? 'lg:col-span-9' : 'lg:col-span-12' }} space-y-6">

          <div class="flex items-center justify-between pb-4 border-b border-brand-border">
            <div>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">MY WISH LIST</h1>
              <p id="wishlist-count-desc" class="text-xs text-brand-muted font-body mt-1">
                {{ $products->count() }} saved item{{ $products->count() === 1 ? '' : 's' }}
              </p>
            </div>
            <button type="button" id="clear-wishlist-btn"
              class="{{ $products->isEmpty() ? 'hidden' : '' }} text-xs text-red-500 hover:text-red-700 font-bold font-heading cursor-pointer">
              Clear Wishlist
            </button>
          </div>

          <!-- Wishlist Grid -->
          <div id="wishlist-products-grid" data-wishlist-page
            class="{{ $products->isEmpty() ? 'hidden' : '' }} grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
            @foreach ($products as $item)
              @include('front-pages.partials.product-card', ['product' => $item])
            @endforeach
          </div>

          <!-- Empty Wishlist State -->
          <div id="wishlist-empty-state"
            class="{{ $products->isEmpty() ? '' : 'hidden' }} bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 shadow-sm">
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
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const grid = document.getElementById('wishlist-products-grid');
      const emptyState = document.getElementById('wishlist-empty-state');
      const countDesc = document.getElementById('wishlist-count-desc');
      const clearBtn = document.getElementById('clear-wishlist-btn');

      // Keeps the count text / empty state correct when cards are removed
      // (the layout script removes a card when its heart is un-clicked here)
      const sync = () => {
        const n = grid.querySelectorAll('.product-card').length;
        countDesc.textContent = `${n} saved item${n === 1 ? '' : 's'}`;
        grid.classList.toggle('hidden', n === 0);
        emptyState.classList.toggle('hidden', n !== 0);
        clearBtn.classList.toggle('hidden', n === 0);
      };

      new MutationObserver(sync).observe(grid, { childList: true });

      clearBtn.addEventListener('click', async () => {
        if (!confirm('Clear all items from your wishlist?')) return;

        clearBtn.disabled = true;
        try {
          const res = await fetch(@json(route('wishlist.clear')), {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'X-CSRF-TOKEN': @json(csrf_token()),
              'X-Requested-With': 'XMLHttpRequest',
            },
          });
          const data = await res.json().catch(() => ({}));

          if (res.ok && data.status) {
            grid.innerHTML = '';   // observer updates count + empty state
            document.querySelectorAll('[data-wishlist-count]').forEach(el => {
              el.textContent = 0;
              el.classList.add('hidden');
            });
            Components.showToast('Wishlist cleared', 'info');
          } else {
            Components.showToast(data.message || 'Could not clear wishlist.', 'error');
          }
        } catch (e) {
          Components.showToast('Network error. Please try again.', 'error');
        }
        clearBtn.disabled = false;
      });
    });
  </script>
@endpush