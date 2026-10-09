@extends('layouts.app')

@section('title', 'Saved Addresses | Aparatus Pastime')
@section('active_nav', 'account')

@section('content')
  <div class="py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4">

      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-brand-muted mb-6 font-sans">
        <a href="{{ route('home') }}" class="hover:text-brand-orange transition font-semibold">Home</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <a href="{{ route('user.dashboard') }}" class="hover:text-brand-orange transition font-semibold">My Playroom</a>
        <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
        <span class="text-brand-navy font-bold">My Addresses</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- SIDEBAR -->
        @include('user._sidebar', ['active' => 'addresses'])

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
          @if($addresses->isEmpty())
            <div class="bg-white rounded-3xl border border-brand-border p-10 text-center space-y-2">
              <div class="w-14 h-14 rounded-full bg-soft-blue text-brand-blue flex items-center justify-center text-xl mx-auto">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <h3 class="font-heading font-bold text-brand-navy">No saved addresses yet</h3>
              <p class="text-xs text-brand-muted font-body">Add a delivery address to speed up checkout.</p>
            </div>
          @else
            <div id="addresses-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
              @foreach($addresses as $a)
                @php
                  $type = strtolower($a->address_type ?: 'home');
                  $typeBg = match ($type) {
                      'home' => 'bg-soft-yellow text-amber-800 border-play-yellow',
                      'work' => 'bg-soft-blue text-brand-blue border-sky-blue',
                      default => 'bg-soft-mint text-emerald-800 border-mint',
                  };
                @endphp
                <div class="bg-white rounded-3xl border {{ $a->is_default ? 'border-brand-orange ring-2 ring-brand-orange/20 shadow-md' : 'border-brand-border shadow-sm' }} p-6 flex flex-col justify-between space-y-4">
                  <div>
                    <div class="flex items-center justify-between pb-3 border-b border-brand-border">
                      <div class="flex items-center gap-2">
                        <span class="font-bold font-heading text-base text-brand-navy">{{ $a->name }}</span>
                        <span class="{{ $typeBg }} px-2.5 py-0.5 rounded-full text-[10px] font-bold font-heading uppercase border">{{ $type }}</span>
                      </div>
                      @if($a->is_default)
                        <span class="text-[10px] font-bold bg-brand-orange text-white px-2.5 py-0.5 rounded-full font-heading">PRIMARY</span>
                      @endif
                    </div>

                    <div class="pt-3 text-xs text-brand-muted space-y-1 font-body">
                      <p class="text-brand-navy font-bold flex items-start gap-2">
                        <i class="fa-solid fa-location-dot text-brand-orange mt-0.5 text-xs"></i>
                        <span>{{ $a->address_line_1 }}@if($a->address_line_2), {{ $a->address_line_2 }}@endif</span>
                      </p>
                      <p class="pl-4">
                        {{ collect([$a->city?->name, $a->state?->name])->filter()->implode(', ') }} - {{ $a->pincode }}
                      </p>
                      <p class="pl-4 font-medium"><i class="fa-solid fa-phone text-gray-400 mr-1 text-[10px]"></i>Phone: {{ $a->phone }}</p>
                      @if($a->email)
                        <p class="pl-4 font-medium"><i class="fa-solid fa-envelope text-gray-400 mr-1 text-[10px]"></i>{{ $a->email }}</p>
                      @endif
                    </div>
                  </div>

                  <div class="pt-3 border-t border-brand-border flex items-center justify-between text-xs font-body">
                    @if(!$a->is_default)
                      <button class="set-default-btn text-brand-blue hover:text-brand-orange font-bold font-heading cursor-pointer" data-id="{{ $a->id }}">
                        Set as Primary
                      </button>
                    @else
                      <span class="text-emerald-700 font-bold font-heading"><i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i>Default Destination</span>
                    @endif

                    <button class="delete-addr-btn text-red-500 hover:text-red-700 font-bold cursor-pointer" data-id="{{ $a->id }}">
                      Delete
                    </button>
                  </div>
                </div>
              @endforeach
            </div>
          @endif

        </div>

      </div>

    </div>
  </div>

  <!-- ADD ADDRESS MODAL -->
  <div id="address-modal" class="modal-wrapper fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="modal-content-box bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 sm:p-8 relative max-h-[90vh] overflow-y-auto">
      <button id="close-addr-modal" type="button" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-soft-blue text-brand-navy hover:bg-brand-orange hover:text-white flex items-center justify-center transition cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <h3 class="font-heading font-extrabold text-xl text-brand-navy mb-4 flex items-center gap-2">
        <i class="fa-solid fa-location-dot text-brand-orange"></i>
        Add Delivery Address
      </h3>

      <form id="new-addr-form" class="space-y-4 text-xs font-body" novalidate>
        @csrf
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">Full Name *</label>
            <input type="text" name="name" required placeholder="Aarav Sharma" value="{{ $customer->name }}" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
          </div>
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">Address Type</label>
            <select name="address_type" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
              <option value="home">Home</option>
              <option value="work">Work / Office</option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">Email *</label>
            <input type="email" name="email" required placeholder="name@example.com" value="{{ $customer->email }}" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
          </div>
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">Phone Number *</label>
            <input type="tel" name="phone" required placeholder="9876543210" value="{{ $customer->mobile }}" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
          </div>
        </div>

        <div>
          <label class="block font-bold text-brand-navy mb-1 font-heading">Street Address / Flat / Building *</label>
          <input type="text" name="address_line_1" required placeholder="Flat 402, Lotus Greens" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
        </div>

        <div>
          <label class="block font-bold text-brand-navy mb-1 font-heading">Landmark / Area (optional)</label>
          <input type="text" name="address_line_2" placeholder="Near City Mall" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none focus:border-brand-blue font-medium">
        </div>

        <div class="grid grid-cols-3 gap-3">
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">State *</label>
            <select name="state_id" id="na-state" required class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
              <option value="">Select</option>
              @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">City *</label>
            <select name="city_id" id="na-city" required disabled class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
              <option value="">Select state first</option>
            </select>
          </div>
          <div>
            <label class="block font-bold text-brand-navy mb-1 font-heading">PIN Code *</label>
            <input type="text" name="pincode" required maxlength="6" inputmode="numeric" placeholder="201303" class="w-full px-3.5 py-2.5 bg-soft-blue/30 border border-brand-border rounded-xl focus:outline-none font-medium">
          </div>
        </div>

        <div class="flex items-center gap-2 pt-1">
          <input type="checkbox" name="is_default" id="na-default" value="1" class="rounded text-brand-blue focus:ring-brand-blue">
          <label for="na-default" class="text-brand-muted cursor-pointer font-medium">Set as default shipping address</label>
        </div>

        <p id="addr-error" class="hidden text-red-600 font-semibold"></p>

        <button type="submit" id="addr-save-btn" class="w-full bg-brand-orange hover:bg-brand-bright-orange text-white font-bold font-heading text-sm py-3.5 rounded-2xl shadow-md transition cursor-pointer disabled:opacity-60">
          SAVE ADDRESS
        </button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script type="module">
    import { Components } from '{{ asset("assets/js/components.js") }}';

    document.addEventListener('DOMContentLoaded', () => {
      const csrf = document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('#new-addr-form [name=_token]').value;

      const urls = {
        store: @json(route('user.addresses.store')),
        default: @json(route('user.addresses.default', ['address' => '__ID__'])),
        destroy: @json(route('user.addresses.destroy', ['address' => '__ID__'])),
        cities: @json(route('checkout.cities', ['state' => '__ID__'])),
      };

      const modal = document.getElementById('address-modal');
      const form = document.getElementById('new-addr-form');
      const stateSel = document.getElementById('na-state');
      const citySel = document.getElementById('na-city');
      const errorEl = document.getElementById('addr-error');
      const saveBtn = document.getElementById('addr-save-btn');

      const request = async (url, method, body = null) => {
        const res = await fetch(url, {
          method,
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
            'X-Requested-With': 'XMLHttpRequest',
          },
          body,
        });
        const data = await res.json().catch(() => ({}));
        return { ok: res.ok, data };
      };

      const reloadSoon = () => setTimeout(() => window.location.reload(), 600);

      // ── Modal open / close ──
      document.getElementById('open-add-addr-modal').onclick = () => modal.classList.add('active');
      document.getElementById('close-addr-modal').onclick = () => modal.classList.remove('active');
      modal.onclick = (e) => { if (e.target === modal) modal.classList.remove('active'); };

      // ── State → City ──
      stateSel.addEventListener('change', async () => {
        citySel.innerHTML = '<option value="">Loading...</option>';
        citySel.disabled = true;

        if (!stateSel.value) {
          citySel.innerHTML = '<option value="">Select state first</option>';
          return;
        }

        try {
          const res = await fetch(urls.cities.replace('__ID__', stateSel.value), {
            headers: { 'Accept': 'application/json' },
          });
          const cities = await res.json();
          citySel.innerHTML = '<option value="">Select city</option>' +
            cities.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
          citySel.disabled = false;
        } catch (e) {
          citySel.innerHTML = '<option value="">Could not load cities</option>';
        }
      });

      // ── Save address ──
      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorEl.classList.add('hidden');
        saveBtn.disabled = true;
        saveBtn.textContent = 'SAVING...';

        try {
          const { ok, data } = await request(urls.store, 'POST', new FormData(form));

          if (ok) {
            Components.showToast(data.message || 'Address added!', 'success');
            modal.classList.remove('active');
            reloadSoon();
            return;
          }

          const first = data.errors ? Object.values(data.errors)[0][0] : null;
          errorEl.textContent = first || data.message || 'Could not save address. Please try again.';
          errorEl.classList.remove('hidden');
        } catch (err) {
          errorEl.textContent = 'Network error. Please try again.';
          errorEl.classList.remove('hidden');
        }

        saveBtn.disabled = false;
        saveBtn.textContent = 'SAVE ADDRESS';
      });

      // ── Set default ──
      document.querySelectorAll('.set-default-btn').forEach(btn => {
        btn.onclick = async () => {
          btn.disabled = true;
          const { ok, data } = await request(urls.default.replace('__ID__', btn.dataset.id), 'POST');
          if (ok) {
            Components.showToast(data.message, 'success');
            reloadSoon();
          } else {
            btn.disabled = false;
            Components.showToast(data.message || 'Something went wrong', 'error');
          }
        };
      });

      // ── Delete ──
      document.querySelectorAll('.delete-addr-btn').forEach(btn => {
        btn.onclick = async () => {
          if (!confirm('Delete this address?')) return;
          btn.disabled = true;
          const { ok, data } = await request(urls.destroy.replace('__ID__', btn.dataset.id), 'DELETE');
          if (ok) {
            Components.showToast(data.message, 'info');
            reloadSoon();
          } else {
            btn.disabled = false;
            Components.showToast(data.message || 'Something went wrong', 'error');
          }
        };
      });
    });
  </script>
@endpush