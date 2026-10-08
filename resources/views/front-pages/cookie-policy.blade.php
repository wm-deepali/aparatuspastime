@extends('layouts.app')

@section('title', 'Cookie Policy | Aparatus Pastime')
@section('active_nav', 'policy')

@section('content')
  <div class="py-10 md:py-16">
    <div class="max-w-4xl mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-12 shadow-sm space-y-6 font-body text-xs sm:text-sm text-body-text leading-relaxed">

        <div class="pb-4 border-b border-brand-border space-y-1">
          <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue font-heading bg-soft-blue px-3 py-1 rounded-full border border-sky-blue/30">DIGITAL TRANSPARENCY</span>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Cookie & Storage Policy</h1>
          <p class="text-xs text-brand-muted">Last Updated: March 2026 • Aparatus Pastime</p>
        </div>

        <div class="space-y-4">
          <h2 class="text-base font-bold font-heading text-brand-navy">1. What Are Cookies & Web Storage?</h2>
          <p>Cookies and local web storage are small data files stored in your web browser that enable our website to remember your shopping cart contents, saved wishlist items, and personal login session between page visits without requiring constant re-entry.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">2. How We Use Cookies & Storage</h2>
          <ul class="list-disc list-inside space-y-1 text-brand-muted pl-2">
            <li><strong>Essential Functional Storage:</strong> Retain items in your Play Bag and maintain secure checkout authentication tokens.</li>
            <li><strong>Performance & Analytics:</strong> Help us identify high-interest toy categories and optimize page loading performance.</li>
            <li><strong>Preferences:</strong> Remember your preferred shopping filters and recently viewed play items.</li>
          </ul>

          <h2 class="text-base font-bold font-heading text-brand-navy">3. Managing Your Preferences</h2>
          <p>You may adjust or clear cookies through your browser settings at any time. Note that clearing local storage will reset your active play bag and saved wishlist on this device.</p>
        </div>

      </div>

    </div>
  </div>
@endsection