@extends('layouts.app')

@section('title', 'Cancellation Policy | Aparatus Pastime')
@section('active_nav', 'home')

@section('content')
  <div class="py-10 md:py-16">
    <div class="max-w-4xl mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-12 shadow-sm space-y-6 font-body text-xs sm:text-sm text-body-text leading-relaxed">

        <div class="pb-4 border-b border-brand-border space-y-1">
          <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue font-heading bg-soft-blue px-3 py-1 rounded-full border border-sky-blue/30">ORDER FLEXIBILITY</span>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Cancellation Policy</h1>
          <p class="text-xs text-brand-muted">Last Updated: March 2026 • Aparatus Pastime</p>
        </div>

        <div class="space-y-4">
          <h2 class="text-base font-bold font-heading text-brand-navy">1. Pre-Dispatch Cancellations</h2>
          <p>You may cancel your order at any point prior to warehouse dispatch (typically within 2 to 4 hours of placing the order) directly through your Customer Dashboard under "My Orders" or by contacting customer support at support@aparatuspastime.com.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">2. Post-Dispatch Cancellations</h2>
          <p>If your package has already been handed over to our delivery partner, you can simply decline acceptance at the time of doorstep delivery. Once the package returns to our fulfillment center, a 100% full refund will be processed immediately.</p>
        </div>

      </div>

    </div>
  </div>
@endsection