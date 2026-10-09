@extends('layouts.app')

@section('title', 'My Reviews | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('user.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Reviews</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        @include('user._sidebar', ['active' => 'reviews', 'customer' => $customer])

        <div class="lg:col-span-9 space-y-6">

          <div class="pb-4 border-b border-brand-border">
            <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">MY REVIEWS</h1>
            <p class="text-xs text-brand-muted font-body mt-1">Manage your feedback on purchased playtime and learning products.</p>
          </div>

          @if (session('success'))
            <div class="bg-soft-mint border border-mint text-emerald-800 rounded-2xl p-4 text-xs font-bold font-body">{{ session('success') }}</div>
          @endif
          @if (session('error'))
            <div class="bg-soft-coral border border-red-300 text-red-800 rounded-2xl p-4 text-xs font-bold font-body">{{ session('error') }}</div>
          @endif

          <!-- WAITING FOR YOUR REVIEW -->
          @if ($toReview->isNotEmpty())
            <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-sm space-y-3">
              <h2 class="font-heading font-extrabold text-xs uppercase tracking-wider text-brand-navy flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-brand-orange"></i>
                WAITING FOR YOUR REVIEW
              </h2>
              <div class="divide-y divide-brand-border">
                @foreach ($toReview as $item)
                  <div class="py-3 flex items-center justify-between gap-3 text-xs font-body">
                    <div class="min-w-0">
                      <p class="font-bold font-heading text-sm text-brand-navy">{{ $item->product_name }}</p>
                      <p class="text-[11px] text-brand-muted">Order {{ $item->order->order_number }}</p>
                    </div>
                    <a href="{{ route('user.reviews.create', ['item' => $item->id]) }}"
                      class="px-4 py-2 bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading rounded-xl transition shrink-0">
                      Write a Review
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <!-- REVIEWS LIST -->
          <div class="space-y-4">
            @forelse ($reviews as $r)
              @php
                $pill = match ($r->status) {
                    'approved' => 'bg-soft-mint text-emerald-800 border-mint',
                    'rejected' => 'bg-soft-coral text-red-800 border-red-300',
                    default    => 'bg-soft-yellow text-amber-800 border-amber-300',
                };
              @endphp
              <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-sm space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-3 border-b border-brand-border">
                  <div>
                    <h3 class="font-heading font-bold text-base text-brand-navy">
                      @if ($r->product)
                        <a href="{{ route('product', ['slug' => $r->product->slug]) }}" class="hover:text-brand-orange transition">{{ $r->product->name }}</a>
                      @else
                        Product no longer available
                      @endif
                    </h3>
                    <div class="text-[11px] text-brand-muted mt-0.5 font-medium">Reviewed on {{ $r->created_at->format('d M Y') }}</div>
                  </div>
                  <div class="flex items-center gap-3">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $pill }}">{{ $r->status_label }}</span>
                    <div class="flex items-center gap-1">
                      @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star text-sm {{ $i <= $r->rating ? 'text-play-yellow' : 'text-gray-200' }}"></i>
                      @endfor
                    </div>
                  </div>
                </div>

                <div>
                  @if ($r->title)
                    <h4 class="font-bold text-sm text-brand-navy font-heading mb-1">{{ $r->title }}</h4>
                  @endif
                  <p class="text-xs text-body-text leading-relaxed font-body">{{ $r->review }}</p>
                </div>

                <div class="pt-2 flex justify-end">
                  <form method="POST" action="{{ route('user.reviews.destroy', $r) }}" onsubmit="return confirm('Delete this review?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-bold transition cursor-pointer">
                      <i class="fa-regular fa-trash-can mr-1"></i>Delete Review
                    </button>
                  </form>
                </div>
              </div>
            @empty
              <div class="bg-white rounded-3xl border border-brand-border p-12 text-center space-y-4 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-soft-purple text-purple-play flex items-center justify-center text-2xl mx-auto">
                  <i class="fa-regular fa-star"></i>
                </div>
                <h3 class="font-heading font-extrabold text-lg text-brand-navy">You haven't reviewed any products yet.</h3>
                <p class="text-xs sm:text-sm text-brand-muted max-w-sm mx-auto font-body">Once an order is delivered, you can share your experience here to help other families choose!</p>
              </div>
            @endforelse

            {{ $reviews->links() }}
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection