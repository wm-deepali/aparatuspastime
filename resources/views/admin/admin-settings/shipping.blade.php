<form action="{{ route('admin.admin-setting.shipping.store') }}" method="POST">
    @csrf
    <div class="settings-content">

        <div class="settings-section">
            <h3 class="settings-section-title"><i class="fa-solid fa-truck-fast"></i> Shipping Charges</h3>
            <p class="settings-section-desc">Choose how shipping is calculated for customer orders.</p>

            <div class="form-grid">
                <div class="field-group">
                    <label class="field-label">Calculate Shipping Based On <span class="req">*</span></label>
                    <select name="shipping_type" id="shipping_type" class="field-select">
                        <option value="order_value" {{ ($shipping->shipping_type ?? '') == 'order_value' ? 'selected' : '' }}>Order Value</option>
                        <option value="weight" {{ ($shipping->shipping_type ?? '') == 'weight' ? 'selected' : '' }}>Weight</option>
                        <option value="pcs" {{ ($shipping->shipping_type ?? '') == 'pcs' ? 'selected' : '' }}>Number of Pcs</option>
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label">Free Delivery Above (Min. Order Value)</label>
                    <div class="input-wrap">
                        <span class="input-prefix">₹</span>
                        <input type="number" min="0" step="0.01" name="free_delivery_threshold"
                            class="field-input" value="{{ $shipping->free_delivery_threshold ?? '' }}">
                    </div>
                    <span class="field-hint">Leave empty to disable free delivery.</span>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        {{-- ═══ ORDER VALUE SLABS ═══ --}}
        <div class="settings-section ship-block" id="block-order_value">
            <h3 class="settings-section-title"><i class="fa-solid fa-indian-rupee-sign"></i> Order Value Slabs</h3>
            <p class="settings-section-desc">Charges by order value range and delivery zone.</p>

            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Min Order Value</th><th>Max Order Value</th>
                        <th>Local</th><th>State</th><th>Inter State</th><th></th>
                    </tr>
                </thead>
                <tbody id="slabBody">
                    @forelse($slabs ?? [] as $i => $slab)
                        @include('admin.admin-settings.shipping-slab-row', ['i' => $i, 'slab' => $slab])
                    @empty
                        @include('admin.admin-settings.shipping-slab-row', ['i' => 0, 'slab' => null])
                    @endforelse
                </tbody>
            </table>
            <button type="button" class="btn-secondary-dash" style="margin-top:12px" onclick="addSlabRow()">
                <i class="fa fa-plus"></i> Add Slab
            </button>
        </div>

        {{-- ═══ WEIGHT / PCS ═══ --}}
        <div class="settings-section ship-block" id="block-weight">
            <h3 class="settings-section-title"><i class="fa-solid fa-weight-hanging"></i> Weight Based</h3>
            <p class="settings-section-desc">Product weight is entered in grams on each product; total is calculated automatically.</p>

            <div class="form-grid">
                <div class="field-group">
                    <label class="field-label">Minimum Weight (grams)</label>
                    <input type="number" min="0" name="min_weight" class="field-input" value="{{ $shipping->min_weight ?? '' }}">
                </div>
                <div class="field-group">
                    <label class="field-label">Extra Weight Step</label>
                    <select name="weight_step" class="field-select">
                        @foreach([100 => '100 gm', 200 => '200 gm', 250 => '250 gm', 500 => '500 gm', 1000 => '1 Kg'] as $g => $label)
                            <option value="{{ $g }}" {{ ($shipping->weight_step ?? '') == $g ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-3" style="margin-top:16px">
                @foreach(['local' => 'Local', 'state' => 'State Wise', 'inter' => 'Inter State'] as $k => $label)
                    <div class="field-group">
                        <label class="field-label">{{ $label }} Charge (min weight)</label>
                        <input type="number" min="0" step="0.01" name="weight_{{ $k }}_charge" class="field-input"
                            value="{{ $shipping->{'weight_'.$k.'_charge'} ?? '' }}">
                    </div>
                @endforeach
                @foreach(['local' => 'Local', 'state' => 'State Wise', 'inter' => 'Inter State'] as $k => $label)
                    <div class="field-group">
                        <label class="field-label">{{ $label }} – Per Extra Step</label>
                        <input type="number" min="0" step="0.01" name="weight_{{ $k }}_extra" class="field-input"
                            value="{{ $shipping->{'weight_'.$k.'_extra'} ?? '' }}">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="settings-section ship-block" id="block-pcs">
            <h3 class="settings-section-title"><i class="fa-solid fa-cubes"></i> Pcs Based</h3>
            <p class="settings-section-desc">Charge for a minimum number of pcs, then per extra pc.</p>

            <div class="form-grid">
                <div class="field-group">
                    <label class="field-label">Minimum Number of Pcs</label>
                    <input type="number" min="1" name="min_pcs" class="field-input" value="{{ $shipping->min_pcs ?? '' }}">
                </div>
            </div>

            <div class="form-grid-3" style="margin-top:16px">
                @foreach(['local' => 'Local', 'state' => 'State Wise', 'inter' => 'Inter State'] as $k => $label)
                    <div class="field-group">
                        <label class="field-label">{{ $label }} Charge (min pcs)</label>
                        <input type="number" min="0" step="0.01" name="pcs_{{ $k }}_charge" class="field-input"
                            value="{{ $shipping->{'pcs_'.$k.'_charge'} ?? '' }}">
                    </div>
                @endforeach
                @foreach(['local' => 'Local', 'state' => 'State Wise', 'inter' => 'Inter State'] as $k => $label)
                    <div class="field-group">
                        <label class="field-label">{{ $label }} – Per Extra Pc</label>
                        <input type="number" min="0" step="0.01" name="pcs_{{ $k }}_extra" class="field-input"
                            value="{{ $shipping->{'pcs_'.$k.'_extra'} ?? '' }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="action-bar">
        <button type="submit" class="btn-primary-dash"><i class="fa fa-floppy-disk"></i> Save Shipping Settings</button>
    </div>
</form>

<script>
    function toggleShipBlocks() {
        const t = document.getElementById('shipping_type').value;
        document.querySelectorAll('.ship-block').forEach(b => b.style.display = 'none');
        document.getElementById('block-' + t).style.display = 'block';
    }
    document.getElementById('shipping_type').addEventListener('change', toggleShipBlocks);
    document.addEventListener('DOMContentLoaded', toggleShipBlocks);

    let slabIndex = {{ max(count($slabs ?? []), 1) }};
    function addSlabRow() {
        const row = `<tr>
            <td><input type="number" step="0.01" name="slabs[${slabIndex}][min]" class="field-input"></td>
            <td><input type="number" step="0.01" name="slabs[${slabIndex}][max]" class="field-input"></td>
            <td><input type="number" step="0.01" name="slabs[${slabIndex}][local]" class="field-input"></td>
            <td><input type="number" step="0.01" name="slabs[${slabIndex}][state]" class="field-input"></td>
            <td><input type="number" step="0.01" name="slabs[${slabIndex}][inter]" class="field-input"></td>
            <td><button type="button" class="btn-danger-soft" onclick="this.closest('tr').remove()"><i class="fa fa-trash"></i></button></td>
        </tr>`;
        document.getElementById('slabBody').insertAdjacentHTML('beforeend', row);
        slabIndex++;
    }
</script>