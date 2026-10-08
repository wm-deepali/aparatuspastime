@extends('layouts.app')

@section('title', 'Shipping & Delivery Policy | Aparatus Pastime')
@section('active_nav', 'policy')

@section('content')
  <div class="py-10 md:py-16">
    <div class="max-w-4xl mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-12 shadow-sm space-y-6 font-body text-xs sm:text-sm text-body-text leading-relaxed">

        <div class="pb-4 border-b border-brand-border space-y-1">
          <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue font-heading bg-soft-blue px-3 py-1 rounded-full border border-sky-blue/30">FULFILLMENT & SPEED</span>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Shipping & Delivery Policy</h1>
          <p class="text-xs text-brand-muted">Last Updated: March 2026 • Aparatus Pastime</p>
        </div>

        <div class="space-y-4">
          <h2 class="text-base font-bold font-heading text-brand-navy">1. Free Shipping on Orders Above ₹999</h2>
          <p>We are delighted to provide <strong>FREE Standard Delivery</strong> across all Indian serviceable pin codes on every order with a subtotal of <strong>₹999 or higher</strong>. For orders below ₹999, a flat shipping fee of ₹49 applies.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">2. Dispatch Timelines</h2>
          <p>All in-stock toys, board games, STEM kits, and sports gear are packed with care, eco-friendly cushioning, and dispatched within <strong>24 business hours</strong> of order verification.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">3. Estimated Transit Times</h2>
          <ul class="list-disc list-inside space-y-1 text-brand-muted pl-2">
            <li><strong>Tier 1 Metros (Delhi NCR, Mumbai, Bengaluru, Chennai, Kolkata, Hyderabad):</strong> 2 to 4 business days.</li>
            <li><strong>Tier 2 & 3 Regional Hubs:</strong> 4 to 6 business days.</li>
            <li><strong>Special North-East & Island Destinations:</strong> 6 to 8 business days.</li>
          </ul>

          <h2 class="text-base font-bold font-heading text-brand-navy">4. Real-Time Tracking</h2>
          <p>As soon as your shipment is dispatched, an Air Waybill (AWB) tracking link is sent via WhatsApp and Email. You can also monitor your package directly on our <a href="{{ route('track-order') }}" class="text-brand-orange font-bold font-heading hover:underline">Track Order page →</a></p>
        </div>

      </div>

    </div>
  </div>
@endsection