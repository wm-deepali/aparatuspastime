@extends('layouts.app')

@section('title', 'My Reviews | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('account.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Reviews</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('front-pages._sidebar', ['active' => 'reviews'])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="pb-4 border-b border-brand-border">
            <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">MY REVIEWS</h1>
            <p class="text-xs text-brand-muted font-body mt-1">Manage your feedback on purchased playtime and learning products.</p>
          </div>

          <!-- Reviews List -->
          <div id="reviews-list-container" class="space-y-4">
            <!-- Injected via JavaScript -->
          </div>

        </div>

      </div>

    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { State } from '{{ asset("assets/js/state.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const base = @json(url('/') . '/');

      const container = document.getElementById('reviews-list-container');
      const renderReviews = () => {
        const reviews = State.getReviews();

        if (reviews.length === 0) {
          container.innerHTML = `
            <div class="bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 shadow-sm">
              <div class="w-16 h-16 rounded-full bg-soft-purple text-purple-play flex items-center justify-center text-2xl mx-auto">
                <i class="fa-regular fa-star"></i>
              </div>
              <h3 class="font-heading font-extrabold text-lg text-brand-navy">You haven't reviewed any products yet.</h3>
              <p class="text-xs sm:text-sm text-brand-muted max-w-sm mx-auto font-body">Share your experiences on toys & games you have purchased to help other families choose!</p>
            </div>
          `;
          return;
        }

        const renderStars = (rating) => {
          return Array.from({ length: 5 }, (_, i) => {
            return i < rating
              ? '<i class="fa-solid fa-star text-play-yellow text-sm"></i>'
              : '<i class="fa-solid fa-star text-gray-200 text-sm"></i>';
          }).join('');
        };

        container.innerHTML = reviews.map(r => `
          <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-sm space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-brand-border">
              <div>
                <h3 class="font-heading font-bold text-base text-brand-navy">
                  <a href="${base}product?slug=${r.productSlug}" class="hover:text-brand-orange transition">${r.productName}</a>
                </h3>
                <div class="text-[11px] text-brand-muted mt-0.5 font-medium">Reviewed on ${r.date}</div>
              </div>
              <div class="flex items-center gap-1">${renderStars(r.rating)}</div>
            </div>

            <div>
              <h4 class="font-bold text-sm text-brand-navy font-heading mb-1">${r.title}</h4>
              <p class="text-xs text-body-text leading-relaxed font-body">${r.comment}</p>
            </div>

            <div class="pt-2 flex justify-end">
              <button class="delete-review-btn text-xs text-red-500 hover:text-red-700 font-bold transition cursor-pointer" data-id="${r.id}">
                <i class="fa-regular fa-trash-can mr-1"></i>Delete Review
              </button>
            </div>
          </div>
        `).join('');

        container.querySelectorAll('.delete-review-btn').forEach(btn => {
          btn.onclick = () => {
            if (confirm('Delete this review?')) {
              State.deleteReview(btn.getAttribute('data-id'));
              renderReviews();
              Components.showToast('Review deleted', 'info');
            }
          };
        });
      };

      renderReviews();
    });
  </script>
@endpush