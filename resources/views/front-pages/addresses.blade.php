@extends('layouts.app')

@section('title', 'Saved Addresses | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('/') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('account.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Addresses</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('front-pages._sidebar', ['active' => 'addresses'])

        <!-- MAIN CONTENT -->
        <div class="lg:col-span-9 space-y-6">

          <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-brand-border gap-4">
            <div>
              <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-brand-navy">MY ADDRESSES</h1>
              <p class="text-xs text-brand-muted font-body mt-1">Manage multiple home, work, and gift delivery locations.</p>
            </div>
            <button id="open-add-addr-modal" class="bg-brand-orange hover:bg-brand-bright-orange text-white text-xs font-bold font-heading px-5 py-3 rounded-2xl shadow-sm transition flex items-center gap-2 shrink-0 cursor-pointer">
              <i class="fa-solid fa-plus text-xs"></i>
              <span>ADD NEW ADDRESS</span>
            </button>
          </div>

          <!-- Address Cards Grid -->
          <div id="addresses-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Injected via JavaScript -->
          </div>

        </div>

      </div>

    </div>
  </div>

  <!-- ADD ADDRESS MODAL -->
  <div id="address-modal" class="modal-wrapper fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="modal-content-box bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-8 relative">
      <button id="close-addr-modal" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-soft-blue text-brand-navy hover:bg-brand-orange hover:text-white flex items-center justify-center transition cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <h3 class="font-heading font-extrabold text-xl text-brand-navy mb-4 flex items-center gap-2">
        <i class="fa-solid fa-location-dot text-brand-orange"></i>
        Add Delivery Address
      </h3>

      <form id="new-addr-form" class="space-y-4 text-xs font-body">
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">Full Name *</label>
            <input type="text" id="na-name" required placeholder="Aarav Sharma" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
          </div>
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">Address Type</label>
            <select id="na-type" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
              <option value="Home">Home</option>
              <option value="Work">Work / Office</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block font-bold text-brand-navy mb-1 font-heading">Street Address / Flat / Building *</label>
          <input type="text" id="na-address" required placeholder="Flat 402, Lotus Greens" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
        </div>

        <div class="grid grid-cols-3 gap-3">
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">City *</label>
            <input type="text" id="na-city" required placeholder="Noida" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
          </div>
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">State *</label>
            <input type="text" id="na-state" required placeholder="UP" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
          </div>
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">PIN Code *</label>
            <input type="text" id="na-pin" required placeholder="201303" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
          </div>
        </div>

        <div>
          <label class="block font-bold text-brand-navy mb-1 font-heading">Phone Number *</label>
          <input type="tel" id="na-phone" required placeholder="+91 98765 43210" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
        </div>

        <div class="flex items-center gap-2 pt-1">
          <input type="checkbox" id="na-default" class="rounded text-brand-blue focus:ring-brand-blue">
          <label for="na-default" class="text-brand-muted cursor-pointer font-medium">Set as default shipping address</label>
        </div>

        <button type="submit" class="w-full bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-sm py-3.5 rounded-2xl shadow-md transition cursor-pointer">
          SAVE ADDRESS
        </button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { State } from '{{ asset("assets/js/state.js") }}';
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const grid = document.getElementById('addresses-grid');
      const modal = document.getElementById('address-modal');
      const openModalBtn = document.getElementById('open-add-addr-modal');
      const closeModalBtn = document.getElementById('close-addr-modal');

      const renderAddresses = () => {
        const list = State.getAddresses();
        grid.innerHTML = list.map(a => {
          const typeBg = a.type === 'Home'
            ? 'bg-soft-yellow text-amber-800 border-play-yellow'
            : a.type === 'Work'
            ? 'bg-soft-blue text-brand-blue border-sky-blue'
            : 'bg-soft-mint text-emerald-800 border-mint';

          return `
            <div class="bg-white rounded-3xl border ${a.isDefault ? 'border-brand-orange ring-2 ring-brand-orange/20 shadow-md' : 'border-brand-border shadow-sm'} p-6 flex flex-col justify-between space-y-4">
              <div>
                <div class="flex items-center justify-between pb-3 border-b border-brand-border">
                  <div class="flex items-center gap-2">
                    <span class="font-bold font-heading text-base text-brand-navy">${a.name}</span>
                    <span class="${typeBg} px-2.5 py-0.5 rounded-full text-[10px] font-bold font-heading uppercase border">${a.type}</span>
                  </div>
                  ${a.isDefault ? '<span class="text-[10px] font-bold bg-brand-orange text-white px-2.5 py-0.5 rounded-full font-heading">PRIMARY</span>' : ''}
                </div>

                <div class="pt-3 text-xs text-brand-muted space-y-1 font-body">
                  <p class="text-brand-navy font-bold flex items-start gap-2">
                    <i class="fa-solid fa-location-dot text-brand-orange mt-0.5 text-xs"></i>
                    <span>${a.address}</span>
                  </p>
                  <p class="pl-4">${a.city}, ${a.state} - ${a.postalCode}</p>
                  <p class="pl-4 font-medium"><i class="fa-solid fa-phone text-gray-400 mr-1 text-[10px]"></i>Phone: ${a.phone}</p>
                </div>
              </div>

              <div class="pt-3 border-t border-brand-border flex items-center justify-between text-xs font-body">
                ${!a.isDefault ? `
                  <button class="set-default-btn text-brand-blue hover:text-brand-orange font-bold font-heading cursor-pointer" data-id="${a.id}">
                    Set as Primary
                  </button>
                ` : '<span class="text-emerald-700 font-bold font-heading"><i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i>Default Destination</span>'}

                <button class="delete-addr-btn text-red-500 hover:text-red-700 font-bold cursor-pointer" data-id="${a.id}">
                  Delete
                </button>
              </div>
            </div>
          `;
        }).join('');

        grid.querySelectorAll('.set-default-btn').forEach(btn => {
          btn.onclick = () => {
            State.setDefaultAddress(btn.getAttribute('data-id'));
            renderAddresses();
            Components.showToast('Default address updated', 'success');
          };
        });

        grid.querySelectorAll('.delete-addr-btn').forEach(btn => {
          btn.onclick = () => {
            if (confirm('Delete this address?')) {
              State.deleteAddress(btn.getAttribute('data-id'));
              renderAddresses();
              Components.showToast('Address removed', 'info');
            }
          };
        });
      };

      openModalBtn.onclick = () => modal.classList.add('active');
      closeModalBtn.onclick = () => modal.classList.remove('active');
      modal.onclick = (e) => { if (e.target === modal) modal.classList.remove('active'); };

      document.getElementById('new-addr-form').onsubmit = (e) => {
        e.preventDefault();
        const newAddr = {
          name: document.getElementById('na-name').value,
          type: document.getElementById('na-type').value,
          address: document.getElementById('na-address').value,
          city: document.getElementById('na-city').value,
          state: document.getElementById('na-state').value,
          postalCode: document.getElementById('na-pin').value,
          phone: document.getElementById('na-phone').value,
          isDefault: document.getElementById('na-default').checked
        };
        State.addAddress(newAddr);
        renderAddresses();
        modal.classList.remove('active');
        document.getElementById('new-addr-form').reset();
        Components.showToast('New address added successfully!', 'success');
      };

      renderAddresses();
    });
  </script>
@endpush