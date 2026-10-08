@extends('layouts.app')

@section('title', 'Privacy Policy | Aparatus Pastime')
@section('active_nav', 'policy')

@section('content')
  <div class="py-10 md:py-16">
    <div class="max-w-4xl mx-auto px-4">

      <div class="bg-white rounded-3xl border border-brand-border p-6 sm:p-12 shadow-sm space-y-6 font-body text-xs sm:text-sm text-body-text leading-relaxed">

        <div class="pb-4 border-b border-brand-border space-y-1">
          <span class="inline-block text-xs font-bold uppercase tracking-wider text-brand-blue font-heading bg-soft-blue px-3 py-1 rounded-full border border-sky-blue/30">LEGAL & PRIVACY</span>
          <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">Privacy Policy</h1>
          <p class="text-xs text-brand-muted">Last Updated: March 2026 • Aparatus Pastime</p>
        </div>

        <div class="space-y-4">
          <h2 class="text-base font-bold font-heading text-brand-navy">1. Overview & Commitment</h2>
          <p>Aparatus Pastime ("we", "us", "our") is dedicated to protecting your family's personal privacy. This Privacy Policy outlines how we collect, process, and safeguard your data when you visit our website, register an account, or purchase our toys, games, STEM kits, and outdoor play goods.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">2. Information We Collect</h2>
          <p>We only collect data essential for providing seamless e-commerce services, including:</p>
          <ul class="list-disc list-inside space-y-1 text-brand-muted pl-2">
            <li>Contact details (Full name, shipping address, email, contact telephone).</li>
            <li>Transaction & Order History (Items purchased, delivery addresses, payment confirmation tokens).</li>
            <li>Technical data (Browser type, device operating system, IP address for security encryption).</li>
          </ul>

          <h2 class="text-base font-bold font-heading text-brand-navy">3. How We Use Your Information</h2>
          <p>We utilize your information strictly to:</p>
          <ul class="list-disc list-inside space-y-1 text-brand-muted pl-2">
            <li>Process, fulfill, and dispatch your product shipments safely.</li>
            <li>Send order tracking alerts, electronic invoices, and important customer support updates.</li>
            <li>Improve our curated product catalog and optimize website responsiveness.</li>
          </ul>

          <h2 class="text-base font-bold font-heading text-brand-navy">4. Data Security & Child Privacy</h2>
          <p>We do not deliberately collect personal identifying information directly from children under 13 without parental consent. All payment transactions are processed over 256-bit SSL encrypted channels. We never store credit card numbers or banking passwords on our servers.</p>

          <h2 class="text-base font-bold font-heading text-brand-navy">5. Contact Our Privacy Officer</h2>
          <p>For inquiries regarding your personal data or to request account deletion, please email <strong>privacy@aparatuspastime.com</strong>.</p>
        </div>

      </div>

    </div>
  </div>
@endsection