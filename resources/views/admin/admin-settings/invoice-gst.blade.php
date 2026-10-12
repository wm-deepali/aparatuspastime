@php
    $sepValue = old('invoice_separator', $invoice_setting->invoice_separator ?? '/');
    $cityList = $invoice_cities ?? collect();
    $selectedCity = old('company_city', $invoice_setting->company_city ?? '');
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.invoice-settings.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="settings-layout">

        <div class="settings-sidenav">
            <span class="settings-sidenav-label">Sections</span>
            <a href="#inv-header" class="active"><i class="fa-solid fa-building"></i> Invoice Header</a>
            <a href="#inv-tax"><i class="fa-solid fa-percent"></i> Tax (GST)</a>
            <a href="#inv-settings"><i class="fa-solid fa-sliders"></i> Invoice Settings</a>
        </div>

        <div class="settings-content">

            <!-- Invoice Header -->
            <div class="settings-section" id="inv-header">
                <div class="settings-section-title"><i class="fa-solid fa-building"></i> Invoice Header</div>
                <p class="settings-section-desc">This information appears at the top of every invoice sent to customers.</p>

                <div class="form-grid">
                    <div class="field-group col-full">
                        <label class="field-label">Company Name</label>
                        <input type="text" name="company_name"
                            value="{{ old('company_name', $invoice_setting->company_name ?? '') }}"
                            class="field-input" placeholder="e.g. Business Registered Name.">
                    </div>

                    <div class="field-group col-full">
                        <label class="field-label">Company Logo</label>
                        <div class="upload-area">
                            <input type="file" id="invoiceLogoInput" name="company_logo" accept="image/*">
                            <div class="upload-icon"><i class="fa fa-cloud-upload"></i></div>
                            <div class="upload-label">Upload Invoice Logo</div>
                            <div class="upload-sub">PNG, JPG · recommended 300×80px, will appear on PDF invoices</div>
                        </div>

                        {{-- Existing (saved) logo --}}
                        @if (!empty($invoice_setting->company_logo))
                            <div id="invoiceLogoExisting" style="margin-top:15px;text-align:center">
                                <img src="{{ asset('storage/' . $invoice_setting->company_logo) }}" alt="Company Logo"
                                    style="max-width:100%;max-height:120px;border-radius:8px;border:1px solid #ddd;padding:5px;">
                            </div>
                        @endif

                        {{-- New file preview --}}
                        <div id="invoiceLogoPreview" style="display:none;margin-top:15px;text-align:center">
                            <img id="invoiceLogoPreviewImg" src="" alt="Preview"
                                style="max-width:100%;max-height:120px;border-radius:8px;border:1px solid #ddd;padding:5px;">
                            <div style="margin-top:8px">
                                <button type="button" onclick="clearInvoiceLogo()"
                                    style="font-size:12px;color:#b22222;background:none;border:none;cursor:pointer;padding:0;">
                                    <i class="fa fa-times"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="field-group col-full">
                        <label class="field-label">Full Registered Address</label>
                        <textarea class="field-textarea" name="company_address" rows="3"
                            placeholder="House / Building No., Street, Area">{{ old('company_address', $invoice_setting->company_address ?? '') }}</textarea>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Country</label>
                        <input type="text" class="field-input" value="India" readonly>
                    </div>

                    <div class="field-group">
                        <label class="field-label">State</label>
                        <select class="field-select" name="company_state" id="state_id">
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}"
                                    {{ old('company_state', $invoice_setting->company_state ?? '') == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label">City</label>
                        <select name="company_city" id="city_id" class="field-select">
                            <option value="">Select City</option>
                            @foreach ($cityList as $city)
                                <option value="{{ $city->id }}" {{ $selectedCity == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Pin Code</label>
                        <input type="text" name="company_pincode" class="field-input" placeholder="226001"
                            maxlength="6"
                            value="{{ old('company_pincode', $invoice_setting->company_pincode ?? '') }}">
                    </div>

                    <div class="field-group gst-field">
                        <label class="field-label">GST Number (GSTIN)</label>
                        <input type="text" name="company_gstin" class="field-input monospace"
                            placeholder="22AAAAA0000A1Z5" maxlength="15"
                            value="{{ old('company_gstin', $invoice_setting->company_gstin ?? '') }}">
                        <span class="field-hint">15-character GST Identification Number.</span>
                    </div>

                    <div class="field-group gst-field">
                        <label class="field-label">PAN Number</label>
                        <input type="text" name="company_pan" class="field-input monospace"
                            placeholder="AAAAA0000A" maxlength="10"
                            value="{{ old('company_pan', $invoice_setting->company_pan ?? '') }}">
                        <span class="field-hint">10-character Permanent Account Number.</span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Contact Phone</label>
                        <input type="text" name="company_phone" class="field-input"
                            value="{{ old('company_phone', $invoice_setting->company_phone ?? '') }}">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Contact Email</label>
                        <input type="email" name="company_email" class="field-input"
                            placeholder="info@businessdomain.com"
                            value="{{ old('company_email', $invoice_setting->company_email ?? '') }}">
                    </div>

                    <div class="field-group col-full">
                        <label class="field-label">Invoice Footer Note</label>
                        <textarea class="field-textarea" rows="2" name="terms_conditions"
                            placeholder="e.g. Thank you for shopping with us! For queries contact support@busnessdomain.com">{{ old('terms_conditions', $invoice_setting->terms_conditions ?? '') }}</textarea>
                        <span class="field-hint">Appears at the bottom of every invoice.</span>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <!-- Tax / GST -->
            <div class="settings-section" id="inv-tax">
                <div class="settings-section-title"><i class="fa-solid fa-percent"></i> Tax / GST Settings</div>
                <p class="settings-section-desc">Define how GST is applied to orders and displayed on invoices.</p>

                <div class="form-grid">
                    <div class="field-group gst-field">
                        <label class="field-label">CGST (%)</label>
                        <input type="number" step="0.01" name="cgst" class="field-input"
                            value="{{ old('cgst', $invoice_setting->cgst ?? 9) }}">
                    </div>

                    <div class="field-group gst-field">
                        <label class="field-label">SGST (%)</label>
                        <input type="number" step="0.01" name="sgst" class="field-input"
                            value="{{ old('sgst', $invoice_setting->sgst ?? 9) }}">
                    </div>

                    <div class="field-group gst-field">
                        <label class="field-label">IGST (%)</label>
                        <input type="number" step="0.01" name="igst" class="field-input"
                            value="{{ old('igst', $invoice_setting->igst ?? 18) }}">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Tax Inclusive / Exclusive</label>
                        <select class="field-select" name="tax_type">
                            <option value="inclusive"
                                {{ old('tax_type', $invoice_setting->tax_type ?? 'inclusive') == 'inclusive' ? 'selected' : '' }}>
                                Tax Inclusive (prices include GST)
                            </option>
                            <option value="exclusive"
                                {{ old('tax_type', $invoice_setting->tax_type ?? 'inclusive') == 'exclusive' ? 'selected' : '' }}>
                                Tax Exclusive (GST added on checkout)
                            </option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Business Type</label>
                        <select class="field-select" name="business_type" id="business_type">
                            <option value="registered"
                                {{ old('business_type', $invoice_setting->business_type ?? 'registered') == 'registered' ? 'selected' : '' }}>
                                Registered
                            </option>
                            <option value="unregistered"
                                {{ old('business_type', $invoice_setting->business_type ?? 'registered') == 'unregistered' ? 'selected' : '' }}>
                                Unregistered
                            </option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:16px">
                    <div class="toggle-row gst-field">
                        <div>
                            <div class="toggle-info-label">Show GST Breakup on Invoice</div>
                            <div class="toggle-info-sub">Display CGST + SGST / IGST split separately.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="show_gst_breakup" value="1"
                                {{ old('show_gst_breakup', $invoice_setting->show_gst_breakup ?? 1) ? 'checked' : '' }}>
                            <span class="toggle-track"></span>
                        </label>
                    </div>
                </div>
            </div>

            <hr class="section-divider">

            <!-- Invoice Settings -->
            <div class="settings-section" id="inv-settings">
                <div class="settings-section-title"><i class="fa-solid fa-sliders"></i> Invoice Settings</div>
                <p class="settings-section-desc">Control how invoice numbers are generated and formatted.</p>

                <div class="form-grid">
                    <div class="field-group">
                        <label class="field-label">Invoice Prefix</label>
                        <input type="text" name="invoice_prefix" class="field-input monospace" id="invPrefix"
                            placeholder="e.g. INV, OC, GST" oninput="updatePreview()"
                            value="{{ old('invoice_prefix', $invoice_setting->invoice_prefix ?? 'INV') }}">
                        <span class="field-hint">Short code prefixed to every invoice number.</span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Starting Serial Number</label>
                        <input name="invoice_serial" type="number" class="field-input monospace" id="invSerial"
                            value="{{ old('invoice_serial', $invoice_setting->invoice_serial ?? 1) }}" min="1"
                            oninput="updatePreview()">
                        <span class="field-hint">Next invoice will use this number.</span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Year in Invoice No.</label>
                        <select class="field-select" id="invYear" name="invoice_year_format" onchange="updatePreview()">
                            <option value="none"
                                {{ old('invoice_year_format', $invoice_setting->invoice_year_format ?? 'slash') == 'none' ? 'selected' : '' }}>
                                None
                            </option>
                            <option value="slash"
                                {{ old('invoice_year_format', $invoice_setting->invoice_year_format ?? 'slash') == 'slash' ? 'selected' : '' }}>
                                FY Slash (2025-26)
                            </option>
                            <option value="year"
                                {{ old('invoice_year_format', $invoice_setting->invoice_year_format ?? 'slash') == 'year' ? 'selected' : '' }}>
                                Year Only (2025)
                            </option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Separator</label>
                        <select class="field-select" id="invSep" name="invoice_separator" onchange="updatePreview()">
                            <option value="/" {{ $sepValue == '/' ? 'selected' : '' }}>/</option>
                            <option value="-" {{ $sepValue == '-' ? 'selected' : '' }}>-</option>
                            <option value="#" {{ $sepValue == '#' ? 'selected' : '' }}>#</option>
                        </select>
                    </div>

                    <div class="field-group col-full">
                        <label class="field-label">Preview</label>
                        <div class="serial-preview">
                            <span class="serial-preview-label">Next invoice:</span>
                            <span class="serial-preview-value" id="serialPreview">OC-2025-26-1001</span>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Invoice Date Format</label>
                        <select class="field-select" name="invoice_date_format">
                            <option value="d/m/Y"
                                {{ old('invoice_date_format', $invoice_setting->invoice_date_format ?? 'd M Y') == 'd/m/Y' ? 'selected' : '' }}>
                                DD/MM/YYYY
                            </option>
                            <option value="d M Y"
                                {{ old('invoice_date_format', $invoice_setting->invoice_date_format ?? 'd M Y') == 'd M Y' ? 'selected' : '' }}>
                                D MMM YYYY
                            </option>
                            <option value="m-d-Y"
                                {{ old('invoice_date_format', $invoice_setting->invoice_date_format ?? 'd M Y') == 'm-d-Y' ? 'selected' : '' }}>
                                MM-DD-YYYY
                            </option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:20px">
                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Auto-generate Invoice on Order</div>
                            <div class="toggle-info-sub">Automatically create invoice when order is placed.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="auto_generate_invoice" value="1"
                                {{ old('auto_generate_invoice', $invoice_setting->auto_generate_invoice ?? 1) ? 'checked' : '' }}>
                            <span class="toggle-track"></span>
                        </label>
                    </div>
                    <div class="toggle-row">
                        <div>
                            <div class="toggle-info-label">Email Invoice to Customer</div>
                            <div class="toggle-info-sub">Attach PDF invoice to the order confirmation email.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="email_invoice_customer" value="1"
                                {{ old('email_invoice_customer', $invoice_setting->email_invoice_customer ?? 1) ? 'checked' : '' }}>
                            <span class="toggle-track"></span>
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="action-bar">
        <button type="button" class="btn-secondary-dash" onclick="window.location.reload()">Discard Changes</button>
        <button class="btn-primary-dash" type="submit">
            <i class="fa fa-save"></i> Save GST &amp; Invoice Settings
        </button>
    </div>
</form>

<script>
    (function () {
        const input = document.getElementById('invoiceLogoInput');
        const box = document.getElementById('invoiceLogoPreview');
        const img = document.getElementById('invoiceLogoPreviewImg');
        const existing = document.getElementById('invoiceLogoExisting');
        if (!input) return;

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                box.style.display = 'block';
                if (existing) existing.style.display = 'none';
            };
            reader.readAsDataURL(file);
        });

        window.clearInvoiceLogo = function () {
            input.value = '';
            img.src = '';
            box.style.display = 'none';
            if (existing) existing.style.display = 'block';
        };
    })();
</script>