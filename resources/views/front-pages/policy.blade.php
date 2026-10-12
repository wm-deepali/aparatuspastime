@extends('layouts.app')

@section('title', ($page->meta_title ?: $page->heading) . ' | Aparatus Pastime')
@section('meta_description', $page->meta_description ?: $page->heading . ' - Aparatus Pastime')
@section('active_nav', 'policy')

@push('styles')
<style>
  /* Styles the HTML coming from the admin editor so it matches the old static policy pages */
  .policy-content > * + * { margin-top: 1rem; }
  .policy-content h2 { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #073B73; margin-top: 1.5rem; }
  .policy-content h3 { font-family: 'Outfit', sans-serif; font-size: .9rem; font-weight: 700; color: #073B73; margin-top: 1.25rem; }
  .policy-content ul { list-style: disc; padding-left: 1.25rem; }
  .policy-content ol { list-style: decimal; padding-left: 1.25rem; }
  .policy-content li + li { margin-top: .35rem; }
  .policy-content a { color: #1261A0; text-decoration: underline; }
  .policy-content a:hover { color: #F58220; }
  .policy-content strong { color: #172B4D; }
</style>
@endpush

@section('content')
  <div class="py-10 md:py-16">
    <div class="max-w-4xl mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-12 shadow-sm space-y-6 font-body text-xs sm:text-sm text-body-text leading-relaxed">

        <div class="pb-4 border-b border-brand-border space-y-1">
          @if ($page->badge_text)
            <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue font-heading bg-soft-blue px-3 py-1 rounded-full border border-sky-blue/30">{{ $page->badge_text }}</span>
          @endif
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">{{ $page->heading }}</h1>
          @if ($page->date_line)
            <p class="text-xs text-brand-muted">{{ $page->date_line }} • Aparatus Pastime</p>
          @endif
        </div>

        <div class="policy-content">
          {!! $page->content !!}
        </div>

      </div>

    </div>
  </div>
@endsection