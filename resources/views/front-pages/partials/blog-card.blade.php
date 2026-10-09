<article
  class="bg-white rounded-2xl border border-brand-border overflow-hidden shadow-xs hover:shadow-lg transition flex flex-col justify-between group">
  <div>
    <a href="{{ route('blog.show', ['slug' => $blog->slug]) }}"
      class="block aspect-16/10 overflow-hidden bg-soft-blue relative">
      @if ($blog->image_url)
        <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}"
          class="w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
      @endif
      @if ($blog->category)
        <span
          class="absolute top-3 left-3 bg-brand-navy/95 text-white text-[11px] font-bold font-heading px-3 py-1 rounded-full shadow-sm">
          {{ $blog->category }}
        </span>
      @endif
    </a>
    <div class="p-5">
      <div class="flex items-center gap-3 text-xs text-brand-muted mb-2 font-medium font-sans">
        @if ($blog->date_label)
          <span><i class="fa-regular fa-calendar mr-1 text-brand-orange"></i>{{ $blog->date_label }}</span>
          <span>•</span>
        @endif
        <span><i class="fa-regular fa-clock mr-1 text-brand-blue"></i>{{ $blog->read_time_label }}</span>
      </div>
      <h3
        class="font-heading font-bold text-dark-navy text-base md:text-lg mb-2 group-hover:text-brand-orange transition line-clamp-2">
        <a href="{{ route('blog.show', ['slug' => $blog->slug]) }}">{{ $blog->title }}</a>
      </h3>
      @if ($blog->short_description)
        <p class="text-xs md:text-sm text-body-text line-clamp-3 leading-relaxed mb-4 font-sans">
          {{ $blog->short_description }}
        </p>
      @endif
    </div>
  </div>
  <div class="px-5 pb-5">
    <a href="{{ route('blog.show', ['slug' => $blog->slug]) }}"
      class="text-brand-blue hover:text-brand-orange text-xs md:text-sm font-bold font-heading flex items-center gap-1.5 transition">
      <span>Read Full Article</span>
      <i class="fa-solid fa-arrow-right text-xs"></i>
    </a>
  </div>
</article>