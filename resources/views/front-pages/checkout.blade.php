<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Checkout | Aparatus Pastime</title>

  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'brand-blue': '#1261A0',
            'brand-navy': '#073B73',
            'brand-orange': '#F58220',
            'brand-bright-orange': '#FF9F1C',
            'play-yellow': '#FFD447',
            'sky-blue': '#7DD3FC',
            'mint': '#8FE3CF',
            'soft-coral': '#FF8A80',
            'purple-play': '#A78BFA',
            'warm-cream': '#FFFDF7',
            'soft-blue': '#F0F8FF',
            'soft-yellow': '#FFF9E6',
            'soft-mint': '#F0FFF9',
            'soft-orange': '#FFF4EA',
            'soft-purple': '#F5F3FF',
            'soft-sky': '#F0F9FF',
            'dark-navy': '#172B4D',
            'body-text': '#465466',
            'brand-muted': '#7A8795',
            'brand-border': '#E8EDF2',
          },
          fontFamily: {
            sans: ['Nunito', 'sans-serif'],
            heading: ['Outfit', 'sans-serif'],
            body: ['Nunito', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>
<body class="bg-warm-cream text-body-text">

  <!-- DISTRACTION-FREE CHECKOUT HEADER -->
  <header class="bg-white border-b border-brand-border py-3.5 shadow-2xs">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
      <a href="{{ url('/') }}" class="flex items-center gap-2">
        <img src="{{ asset('assets/logo.png') }}" alt="Aparatus Pastime" class="h-10 w-auto">
      </a>
      <div class="flex items-center gap-2 text-xs font-bold font-heading text-emerald-700 bg-emerald-50 px-3.5 py-1.5 rounded-full border border-emerald-200">
        <i class="fa-solid fa-lock text-emerald-600"></i>
        <span>256-Bit SSL Encrypted Checkout</span>
      </div>
    </div>
  </header>

  <!-- CHECKOUT CONTENT -->
  <main class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT: CHECKOUT FORM STEPS (7 COLS) -->
        <div class="lg:col-span-7 space-y-6">

          <form id="checkout-form" class="space-y-6">

            <!-- STEP 1: CONTACT & DELIVERY DETAILS -->
            <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-4">
              <div class="flex items-center gap-3 pb-3 border-b border-brand-border font-heading">
                <span class="w-7 h-7 rounded-full bg-brand-blue text-white text-xs font-bold flex items-center justify-center">1</span>
                <h2 class="font-bold text-base text-dark-navy">Contact & Delivery Information</h2>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-sans">
                <div class="sm:col-span-2">
                  <label class="block font-bold text-dark-navy mb-1 font-heading">Email Address (for order tracking) *</label>
                  <input type="email" id="checkout-email" required placeholder="name@example.com" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue">
                </div>
                <div>
                  <label class="block font-bold text-dark-navy mb-1 font-heading">First Name *</label>
                  <input type="text" id="checkout-fname" required placeholder="First Name" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue">
                </div>
                <div>
                  <label class="block font-bold text-dark-navy mb-1 font-heading">Last Name *</label>
                  <input type="text" id="checkout-lname" required placeholder="Last Name" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue">
                </div>
                <div class="sm:col-span-2">
                  <label class="block font-bold text-dark-navy mb-1 font-heading">Phone Number (for courier updates) *</label>
                  <input type="tel" id="checkout-phone" required placeholder="+91 98765 43210" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue">
                </div>
              </div>
            </div>

            <!-- STEP 2: SHIPPING ADDRESS -->
            <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-4">
              <div class="flex items-center gap-3 pb-3 border-b border-brand-border font-heading">
                <span class="w-7 h-7 rounded-full bg-brand-blue text-white text-xs font-bold flex items-center justify-center">2</span>
                <h2 class="font-bold text-base text-dark-navy">Shipping Address</h2>
              </div>

              <!-- Quick Saved Address Selector -->
              <div id="saved-addresses-selector" class="space-y-2">
                <span class="text-[11px] font-bold uppercase tracking-wider text-brand-muted font-heading">SAVED ADDRESSES</span>
                <div id="saved-address-cards" class="grid grid-cols-1 sm:grid-cols-2 gap-3"></div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-2 font-sans">
                <div class="sm:col-span-2">
                  <label class="block font-bold text-dark-navy mb-1 font-heading">Street Address / Flat / Building *</label>
                  <input type="text" id="checkout-address" required placeholder="Flat No, Apartment, Street name" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue">
                </div>
                <div>
                  <label class="block font-bold text-dark-navy mb-1 font-heading">City *</label>
                  <input type="text" id="checkout-city" required placeholder="City" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue">
                </div>
                <div>
                  <label class="block font-bold text-dark-navy mb-1 font-heading">State *</label>
                  <input type="text" id="checkout-state" required placeholder="State" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue">
                </div>
                <div>
                  <label class="block font-bold text-dark-navy mb-1 font-heading">Postal Code (PIN) *</label>
                  <input type="text" id="checkout-pincode" required placeholder="6-digit PIN code" class="w-full px-3.5 py-2.5 bg-soft-blue/40 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue">
                </div>
                <div>
                  <label class="block font-bold text-dark-navy mb-1 font-heading">Country</label>
                  <input type="text" value="India" readonly class="w-full px-3.5 py-2.5 bg-gray-100 border border-brand-border rounded-xl text-brand-muted cursor-not-allowed">
                </div>
              </div>
            </div>

            <!-- STEP 3: PAYMENT METHOD -->
            <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-4">
              <div class="flex items-center gap-3 pb-3 border-b border-brand-border font-heading">
                <span class="w-7 h-7 rounded-full bg-brand-blue text-white text-xs font-bold flex items-center justify-center">3</span>
                <h2 class="font-bold text-base text-dark-navy">Payment Method</h2>
              </div>

              <div class="space-y-3 text-xs font-heading">
                <label class="flex items-center justify-between p-3.5 rounded-2xl border-2 border-brand-orange bg-soft-orange cursor-pointer transition">
                  <div class="flex items-center gap-3">
                    <input type="radio" name="paymentMethod" value="UPI (Google Pay / PhonePe)" checked class="text-brand-orange">
                    <div>
                      <span class="font-bold text-dark-navy block text-sm">UPI Instant Pay</span>
                      <span class="text-brand-muted text-[11px] font-sans">Google Pay, PhonePe, Paytm, BHIM UPI</span>
                    </div>
                  </div>
                  <i class="fa-solid fa-mobile-screen-button text-brand-orange text-lg"></i>
                </label>

                <label class="flex items-center justify-between p-3.5 rounded-2xl border border-brand-border bg-white hover:border-brand-blue cursor-pointer transition">
                  <div class="flex items-center gap-3">
                    <input type="radio" name="paymentMethod" value="Credit / Debit Card" class="text-brand-blue">
                    <div>
                      <span class="font-bold text-dark-navy block text-sm">Credit or Debit Card</span>
                      <span class="text-brand-muted text-[11px] font-sans">Visa, MasterCard, RuPay, Maestro</span>
                    </div>
                  </div>
                  <i class="fa-solid fa-credit-card text-brand-blue text-lg"></i>
                </label>

                <label class="flex items-center justify-between p-3.5 rounded-2xl border border-brand-border bg-white hover:border-brand-blue cursor-pointer transition">
                  <div class="flex items-center gap-3">
                    <input type="radio" name="paymentMethod" value="Net Banking" class="text-brand-blue">
                    <div>
                      <span class="font-bold text-dark-navy block text-sm">Net Banking</span>
                      <span class="text-brand-muted text-[11px] font-sans">50+ major Indian banks supported</span>
                    </div>
                  </div>
                  <i class="fa-solid fa-building-columns text-brand-blue text-lg"></i>
                </label>

                <label class="flex items-center justify-between p-3.5 rounded-2xl border border-brand-border bg-white hover:border-brand-blue cursor-pointer transition">
                  <div class="flex items-center gap-3">
                    <input type="radio" name="paymentMethod" value="Cash on Delivery" class="text-brand-blue">
                    <div>
                      <span class="font-bold text-dark-navy block text-sm">Cash on Delivery (COD)</span>
                      <span class="text-brand-muted text-[11px] font-sans">Pay securely at your doorstep upon arrival</span>
                    </div>
                  </div>
                  <i class="fa-solid fa-money-bill-wave text-emerald-600 text-lg"></i>
                </label>
              </div>
            </div>

            <!-- Submit Order CTA -->
            <button type="submit" id="place-order-btn" class="w-full btn-play-orange py-4 px-6 rounded-2xl text-base shadow-lg transition flex items-center justify-center gap-2 cursor-pointer font-heading">
              <i class="fa-solid fa-circle-check"></i>
              <span>COMPLETE & PLACE ORDER</span>
            </button>
          </form>

        </div>

        <!-- RIGHT: ORDER SUMMARY PREVIEW (5 COLS) -->
        <div class="lg:col-span-5 space-y-6 sticky top-8">

          <div class="bg-white rounded-3xl border border-brand-border p-6 shadow-xs space-y-4">
            <h3 class="font-heading font-bold text-sm uppercase tracking-wider text-dark-navy pb-3 border-b border-brand-border flex items-center justify-between">
              <span>BAG ITEMS SUMMARY</span>
              <a href="{{ route('cart') }}" class="text-xs text-brand-blue hover:text-brand-orange">Edit Bag</a>
            </h3>

            <!-- Item Mini Previews -->
            <div id="checkout-items-preview" class="space-y-3 max-h-64 overflow-y-auto pr-1">
              <!-- Injected via JavaScript -->
            </div>

            <!-- Price Breakdown -->
            <div class="pt-4 border-t border-brand-border space-y-2.5 text-xs font-sans">
              <div class="flex justify-between text-body-text">
                <span>Subtotal</span>
                <span id="checkout-subtotal" class="font-bold text-dark-navy font-heading">₹0</span>
              </div>
              <div id="checkout-discount-row" class="hidden justify-between text-emerald-600 font-bold font-heading">
                <span>Coupon Discount (<span id="checkout-coupon-code"></span>)</span>
                <span id="checkout-discount">-₹0</span>
              </div>
              <div class="flex justify-between text-body-text">
                <span>Estimated Shipping</span>
                <span id="checkout-shipping" class="font-bold font-heading">FREE</span>
              </div>
              <div class="border-t border-brand-border pt-3 flex justify-between items-baseline font-heading">
                <span class="text-sm font-bold text-dark-navy">Total to Pay</span>
                <span id="checkout-total" class="text-2xl font-bold text-brand-navy">₹0</span>
              </div>
            </div>

            <!-- Guarantee Box -->
            <div class="p-3 bg-soft-blue rounded-2xl border border-blue-100 text-center text-xs text-brand-blue font-heading space-y-1">
              <div class="font-bold flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-gift text-brand-orange"></i>
                <span>Aparatus Pastime Play Guarantee</span>
              </div>
              <p class="text-[11px] text-body-text font-sans">100% genuine toys & active sports gear with doorstep support.</p>
            </div>
          </div>

        </div>

      </div>

    </div>
  </main>

  <footer class="bg-white border-t border-brand-border py-6 text-center text-xs text-brand-muted font-sans">
    <div class="max-w-7xl mx-auto px-4">
      <p>© {{ date('Y') }} Aparatus Pastime. All transactions are protected by bank-grade 256-bit encryption.</p>
    </div>
  </footer>

  <!-- CHECKOUT JAVASCRIPT -->
  <script type="module">
    import { State } from '{{ asset("assets/js/state.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const base = @json(url('/') . '/');

      const cart = State.getCart();
      const calc = State.getCartCalculations();
      const user = State.getUser();
      const addresses = State.getAddresses();

      if (cart.length === 0) {
        window.location.href = base + '/cart';
        return;
      }

      // Prefill user data
      if (user) {
        document.getElementById('checkout-fname').value = user.firstName || '';
        document.getElementById('checkout-lname').value = user.lastName || '';
        document.getElementById('checkout-email').value = user.email || '';
        document.getElementById('checkout-phone').value = user.phone || '';
      }

      // Render Saved Address Cards
      const addressContainer = document.getElementById('saved-address-cards');
      if (addressContainer && addresses.length > 0) {
        addressContainer.innerHTML = addresses.map(addr => `
          <div class="p-3 rounded-2xl border ${addr.isDefault ? 'border-brand-blue bg-soft-blue' : 'border-brand-border bg-white'} cursor-pointer hover:border-brand-blue transition saved-address-card" data-id="${addr.id}">
            <div class="flex items-center justify-between text-xs font-bold font-heading mb-1">
              <span class="text-dark-navy">${addr.type}</span>
              ${addr.isDefault ? '<span class="text-[10px] bg-brand-blue text-white px-2 py-0.2 rounded-full">Default</span>' : ''}
            </div>
            <p class="text-[11px] text-body-text font-sans line-clamp-2">${addr.address}, ${addr.city}, ${addr.state} - ${addr.postalCode}</p>
          </div>
        `).join('');

        // Pre-fill default
        const def = addresses.find(a => a.isDefault) || addresses[0];
        if (def) {
          document.getElementById('checkout-address').value = def.address;
          document.getElementById('checkout-city').value = def.city;
          document.getElementById('checkout-state').value = def.state;
          document.getElementById('checkout-pincode').value = def.postalCode;
        }

        document.querySelectorAll('.saved-address-card').forEach(card => {
          card.addEventListener('click', () => {
            const id = Number(card.getAttribute('data-id'));
            const selected = addresses.find(a => a.id === id);
            if (selected) {
              document.getElementById('checkout-address').value = selected.address;
              document.getElementById('checkout-city').value = selected.city;
              document.getElementById('checkout-state').value = selected.state;
              document.getElementById('checkout-pincode').value = selected.postalCode;
              document.querySelectorAll('.saved-address-card').forEach(c => {
                c.className = 'p-3 rounded-2xl border border-brand-border bg-white cursor-pointer hover:border-brand-blue transition saved-address-card';
              });
              card.className = 'p-3 rounded-2xl border-2 border-brand-blue bg-soft-blue cursor-pointer saved-address-card';
            }
          });
        });
      }

      // Render Item Previews
      const itemsPreview = document.getElementById('checkout-items-preview');
      itemsPreview.innerHTML = cart.map(item => `
        <div class="flex items-center gap-3 pb-2.5 border-b border-brand-border">
          <img src="${item.image}" class="w-12 h-12 object-contain bg-soft-blue rounded-xl p-1 border border-brand-border shrink-0">
          <div class="flex-1 min-w-0">
            <h5 class="text-xs font-bold font-heading text-dark-navy truncate">${item.name}</h5>
            <div class="text-[11px] text-brand-muted font-sans">Qty: ${item.quantity} × ₹${item.price.toLocaleString()}</div>
          </div>
          <span class="text-xs font-bold font-heading text-brand-navy">₹${(item.price * item.quantity).toLocaleString()}</span>
        </div>
      `).join('');

      // Render Calculations
      document.getElementById('checkout-subtotal').textContent = `₹${calc.subtotal.toLocaleString()}`;
      document.getElementById('checkout-total').textContent = `₹${calc.total.toLocaleString()}`;
      document.getElementById('checkout-shipping').innerHTML = calc.shipping === 0
        ? '<span class="text-emerald-600 font-bold">FREE</span>'
        : `₹${calc.shipping}`;

      const discRow = document.getElementById('checkout-discount-row');
      if (calc.discount > 0) {
        discRow.classList.remove('hidden');
        discRow.classList.add('flex');
        document.getElementById('checkout-coupon-code').textContent = calc.coupon;
        document.getElementById('checkout-discount').textContent = `-₹${calc.discount.toLocaleString()}`;
      }

      // Form Submit -> Create Order -> Redirect to Order Success
      document.getElementById('checkout-form').addEventListener('submit', (e) => {
        e.preventDefault();

        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
        const shippingAddress = {
          name: `${document.getElementById('checkout-fname').value} ${document.getElementById('checkout-lname').value}`,
          email: document.getElementById('checkout-email').value,
          phone: document.getElementById('checkout-phone').value,
          address: `${document.getElementById('checkout-address').value}, ${document.getElementById('checkout-city').value}, ${document.getElementById('checkout-state').value} - ${document.getElementById('checkout-pincode').value}`
        };

        const newOrder = State.createOrder({
          paymentMethod,
          shippingAddress
        });

        Components.showToast('🎉 Order placed successfully!', 'success');
        setTimeout(() => {
          window.location.href = `${base}order-success?orderId=${newOrder.id}`;
        }, 500);
      });
    });
  </script>
</body>
</html>