@extends('layouts.app')

@section('title', 'Write a Review | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-2xl mx-auto px-4">

      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('user.reviews') }}" class="hover:text-brand-orange transition font-semibold">My Reviews</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">Write a Review</span>
      </nav>

      <form method="POST" action="{{ route('user.reviews.store') }}"
        class="bg-white rounded-3xl border border-brand-border p-6 sm:p-10 shadow-sm space-y-6 text-xs font-body">
        @csrf
        <input type="hidden" name="order_item_id" value="{{ $item->id }}">

        <div>
          <h1 class="text-2xl font-extrabold font-heading text-brand-navy">Write a Review</h1>
          <p class="text-brand-muted mt-1">{{ $item->product_name }} · Order {{ $item->order->order_number }}</p>
        </div>

        <!-- Rating -->
        <div>
          <label class="block font-bold text-brand-navy mb-2 font-heading">Your Rating *</label>
          <div class="flex flex-row-reverse justify-end gap-1">
            @for ($i = 5; $i >= 1; $i--)
              <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="peer sr-only"
                @checked(old('rating') == $i) required>
              <label for="star{{ $i }}"
                class="cursor-pointer text-2xl text-gray-300 peer-checked:text-play-yellow hover:text-play-yellow transition">
                <i class="fa-solid fa-star"></i>
              </label>
            @endfor
          </div>
          @error('rating') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Title -->
        <div>
          <label class="block font-bold text-brand-navy mb-1.5 font-heading">Title</label>
          <input type="text" name="title" value="{{ old('title') }}" maxlength="120" placeholder="Sum it up in a few words"
            class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
          @error('title') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Review -->
        <div>
          <label class="block font-bold text-brand-navy mb-1.5 font-heading">Your Review *</label>
          <textarea name="review" rows="5" required minlength="10" maxlength="2000" placeholder="What did you and your little one think?"
            class="w-full px-4 py-3 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">{{ old('review') }}</textarea>
          @error('review') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
          <a href="{{ route('user.reviews') }}" class="px-5 py-3 font-bold font-heading text-brand-muted hover:text-brand-navy">Cancel</a>
          <button type="submit"
            class="px-6 py-3 bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading rounded-xl shadow transition cursor-pointer">
            SUBMIT REVIEW
          </button>
        </div>
      </form>

    </div>
  </div>
@endsection