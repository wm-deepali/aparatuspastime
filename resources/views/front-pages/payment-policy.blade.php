@extends('layouts.app')

@section('title', 'Payment & Security Policy | Aparatus Pastime')
@section('active_nav', 'policy')

@section('content')
  <div class="py-10 md:py-16">
    <div class="max-w-4xl mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-12 shadow-sm space-y-6 font-body text-xs sm:text-sm text-body-text leading-relaxed">

        <div class="pb-4 border-b border-brand-border space-y-1">
          <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue font-heading bg-soft-blue px-3 py-1 rounded-full border border-sky-blue/30">100% SAFE CHECKOUT</span>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Payment & Security Policy</h1>
          <p class="text-xs text-brand-muted">Last Updated: March 2026 • Aparatus Pastime</p>
        </div>

        <div class="space-y-4">
          <h2 class="text-base font-bold font-heading text-brand-navy">1. Accepted Payment Channels</h2>
          <p>We provide a wide array of secure digital and offline payment options across India:</p>
          <ul class="list-disc list-inside space-y-1 text-brand-muted pl-2">
            <li><strong>Unified Payments Interface (UPI):</strong> Google Pay, PhonePe, Paytm, BHIM, Amazon Pay.</li>
            <li><strong>Credit & Debit Cards:</strong> Visa, MasterCard, RuPay, Diners Club, and American Express.</li>
            <li><strong>Internet Banking:</strong> Supported across 50+ leading Indian public and private banks.</li>
            <li><strong>Cash on Delivery (COD):</strong> Available for eligible retail orders under ₹5,000.</li>
          </ul>

          <h2 class="text-base font-bold font-heading text-brand-navy">2. Payment Security Architecture</h2>
          <p>All online checkouts utilize PCI-DSS Level 1 compliant gateway gateways protected with 256-bit SSL encryption. We never access, store, or transmit your card CVVs or confidential PINs.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">3. Failed Transactions & Auto-Refunds</h2>
          <p>If amount is debited from your account during a failed connection, bank reconciliation automatically credits the funds back to your source account within 48 to 72 business hours.</p>
        </div>

      </div>

    </div>
  </div>
@endsection