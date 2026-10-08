@extends('layouts.app')

@section('title', 'Returns & Refund Policy | Aparatus Pastime')
@section('active_nav', 'policy')

@section('content')
  <div class="py-10 md:py-16">
    <div class="max-w-4xl mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-12 shadow-sm space-y-6 font-body text-xs sm:text-sm text-body-text leading-relaxed">

        <div class="pb-4 border-b border-brand-border space-y-1">
          <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-orange font-heading bg-soft-orange px-3 py-1 rounded-full border border-brand-orange/20">7-DAY GUARANTEE</span>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Return & Refund Policy</h1>
          <p class="text-xs text-brand-muted">Last Updated: March 2026 • Aparatus Pastime</p>
        </div>

        <div class="space-y-4">
          <h2 class="text-base font-bold font-heading text-brand-navy">1. 7-Day Hassle-Free Returns</h2>
          <p>We want every playtime item to be a delight. If your product is damaged during transit, has a manufacturing defect, or differs from the ordered specification, you may request a return or free replacement within <strong>7 calendar days</strong> of receiving your shipment.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">2. Return Eligibility Conditions</h2>
          <ul class="list-disc list-inside space-y-1 text-brand-muted pl-2">
            <li>The item must be in its original condition with all accessories, manuals, and packaging intact.</li>
            <li>Board games, STEM kits, and wooden puzzles must contain all components and tokens.</li>
            <li>Free gifts or bundle accessories included with the promotional order must also be returned.</li>
          </ul>

          <h2 class="text-base font-bold font-heading text-brand-navy">3. Doorstep Pickup & Inspection</h2>
          <p>Once you initiate a return from your Account Dashboard under "My Orders", our courier partner will pick up the package from your address within 48 to 72 hours. Once inspected at our hub, your refund is approved.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">4. Refund Processing Speed</h2>
          <p>Refunds are initiated immediately upon inspection approval. For online payments (UPI, Cards, NetBanking), credits will reflect in your account within <strong>3 to 5 business days</strong>. For COD orders, refunds are transferred directly to your bank account or UPI ID.</p>
        </div>

      </div>

    </div>
  </div>
@search.blade.php