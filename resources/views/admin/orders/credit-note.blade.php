<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Note #{{ $cn['credit_note_no'] }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif; font-size: 13px; color: #202223; background: #f1f2f4; padding: 32px 20px; }
        .invoice-wrap { max-width: 780px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.10); }
        .inv-header { background: #fff; border-bottom: 4px solid #b22222; padding: 24px 40px; display: table; width: 100%; }
        .inv-header-left { display: table-cell; vertical-align: top; width: 60%; }
        .inv-header-right { display: table-cell; vertical-align: top; width: 40%; text-align: right; }
        .brand-name { font-size: 20px; font-weight: 700; color: #1B4B91; }
        .brand-tagline { font-size: 11px; font-weight: 700; color: #b22222; letter-spacing: 2px; text-transform: uppercase; margin-top: 3px; }
        .brand-address { font-size: 11.5px; color: #6d7175; margin-top: 10px; line-height: 1.7; }
        .inv-label { font-size: 24px; font-weight: 700; color: #b22222; letter-spacing: 3px; text-transform: uppercase; }
        .inv-number { font-size: 16px; font-weight: 700; color: #1B4B91; margin-top: 4px; font-family: 'Courier New', monospace; }
        .inv-date { font-size: 12px; color: #6d7175; margin-top: 5px; }
        .inv-status-badge { display: inline-block; margin-top: 10px; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; background: #fce8e8; color: #b22222; }
        .inv-body { padding: 32px 40px; }
        .meta-row { display: table; width: 100%; margin-bottom: 28px; }
        .meta-col { display: table-cell; width: 50%; vertical-align: top; }
        .meta-col:last-child { text-align: right; }
        .meta-heading { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #8c9196; margin-bottom: 8px; padding-bottom: 6px; border-bottom: 1px solid #e3e5e8; }
        .meta-name { font-size: 14px; font-weight: 700; margin-bottom: 3px; }
        .meta-detail { font-size: 12px; color: #6d7175; line-height: 1.7; }
        .meta-info-row { display: table; width: 100%; margin-bottom: 4px; }
        .meta-info-label { display: table-cell; font-size: 11px; color: #8c9196; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; width: 130px; padding-bottom: 4px; text-align: right; padding-right: 10px; }
        .meta-info-value { display: table-cell; font-size: 12px; font-weight: 600; text-align: right; }
        .items-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .items-table thead tr { background: #f8f9fa; }
        .items-table thead th { font-size: 10.5px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: #8c9196; padding: 10px 14px; border-top: 1px solid #e3e5e8; border-bottom: 1px solid #e3e5e8; text-align: left; }
        .items-table thead th.right { text-align: right; }
        .items-table thead th.center { text-align: center; }
        .items-table tbody tr { border-bottom: 1px solid #f1f2f4; }
        .items-table tbody tr:last-child { border-bottom: 1px solid #e3e5e8; }
        .items-table tbody td { padding: 13px 14px; vertical-align: top; }
        .items-table tbody td.right { text-align: right; }
        .items-table tbody td.center { text-align: center; }
        .item-name { font-weight: 600; margin-bottom: 2px; }
        .item-variant { font-size: 11px; color: #8c9196; margin-top: 2px; }
        .item-sku { font-size: 10.5px; color: #adb5bd; font-family: 'Courier New', monospace; margin-top: 1px; }
        .totals-wrap { display: table; width: 100%; }
        .totals-left { display: table-cell; width: 52%; vertical-align: top; padding-right: 20px; }
        .totals-right { display: table-cell; width: 48%; vertical-align: top; }
        .totals-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .totals-table td { padding: 7px 14px; font-size: 12.5px; }
        .t-label { color: #6d7175; }
        .t-value { text-align: right; font-weight: 600; color: #b22222; }
        .totals-table .t-total td { border-top: 2px solid #b22222; padding-top: 10px; font-size: 15px; font-weight: 700; }
        .totals-table .t-total .t-value { font-size: 17px; }
        .inv-notes { margin-top: 20px; padding: 16px 20px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #b22222; }
        .inv-notes p { font-size: 12px; color: #6d7175; line-height: 1.6; }
        .inv-notes strong { color: #202223; }
        .inv-footer { background: #f8f9fa; border-top: 1px solid #e3e5e8; padding: 16px 40px; text-align: center; }
        .inv-footer p { font-size: 11.5px; color: #8c9196; line-height: 1.6; }
        .inv-footer strong { color: #202223; }
        .print-bar { max-width: 780px; margin: 0 auto 20px; display: flex; justify-content: space-between; align-items: center; gap: 10px; }
        .btn-back, .btn-print { display: inline-flex; align-items: center; gap: 6px; background: #fff; color: #202223; border: 1px solid #e3e5e8; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 500; text-decoration: none; cursor: pointer; }
        .btn-pdf { display: inline-flex; align-items: center; gap: 6px; background: #b22222; color: #fff; border: none; border-radius: 8px; padding: 8px 18px; font-size: 13px; font-weight: 600; text-decoration: none; cursor: pointer; }
        @media print {
            body { background: #fff; padding: 0; }
            .print-bar { display: none; }
            .invoice-wrap { box-shadow: none; border-radius: 0; }
        }
    </style>
</head>

<body>

    @if(!$isPdf)
        <div class="print-bar">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn-back">← Back to Order</a>
            <div style="display:flex;gap:8px">
                <button onclick="window.print()" class="btn-print">🖨 Print</button>
                <a href="{{ route('admin.credit-notes.download', $refund) }}" class="btn-pdf">⬇ Download PDF</a>
            </div>
        </div>
    @endif

    <div class="invoice-wrap">

        {{-- Header --}}
        <div class="inv-header">
            <div class="inv-header-left">
                @if($logo_64)
                    <div style="margin-bottom:8px;"><img src="{{ $logo_64 }}" style="max-height:85px;"></div>
                @else
                    <div class="brand-name">{{ $setting->company_name ?? config('app.name') }}</div>
                @endif
                <div class="brand-tagline">Credit Note</div>
                <div class="brand-address">
                    @if($setting?->company_address){{ $setting->company_address }}<br>@endif
                    @if($setting?->city || $setting?->state || $setting?->company_pincode)
                        {{ optional($setting->city)->name ?? '' }}@if($setting?->city && $setting?->state), @endif{{ optional($setting->state)->name ?? '' }}@if($setting?->company_pincode) - {{ $setting->company_pincode }}@endif<br>
                    @endif
                    @if($setting?->company_gstin)GSTIN: {{ $setting->company_gstin }}<br>@endif
                    @if($setting?->company_pan)PAN: {{ $setting->company_pan }}<br>@endif
                    @if($setting?->company_phone)Phone: {{ $setting->company_phone }}<br>@endif
                    @if($setting?->company_email){{ $setting->company_email }}@endif
                </div>
            </div>
            <div class="inv-header-right">
                <div class="inv-label">Credit Note</div>
                <div class="inv-number">#{{ $cn['credit_note_no'] }}</div>
                <div class="inv-date">
                    Date: {{ $cn['refund_date']->format($setting->invoice_date_format ?? 'd M Y') }}
                </div>
                <div><span class="inv-status-badge">{{ $cn['reason'] }}</span></div>
            </div>
        </div>

        <div class="inv-body">

            {{-- Customer + reference --}}
            <div class="meta-row">
                <div class="meta-col">
                    <div class="meta-heading">Issued To</div>
                    <div class="meta-name">{{ $invoice->customer_name ?? $order->customer_name }}</div>
                    <div class="meta-detail">
                        {{ $invoice->billing_address ?? trim($order->address_line_1 . ' ' . $order->address_line_2) }}<br>
                        {{ $invoice->customer_email ?? $order->customer_email }}<br>
                        {{ $invoice->customer_phone ?? $order->customer_phone }}
                    </div>
                </div>
                <div class="meta-col">
                    <div class="meta-heading" style="text-align:right">Reference Details</div>
                    <div class="meta-info-row">
                        <div class="meta-info-label">Order #</div>
                        <div class="meta-info-value" style="font-family:'Courier New',monospace;color:#1B4B91">{{ $order->order_number }}</div>
                    </div>
                    @if($invoice)
                        <div class="meta-info-row">
                            <div class="meta-info-label">Original Invoice</div>
                            <div class="meta-info-value" style="font-family:'Courier New',monospace">{{ $invoice->invoice_number }}</div>
                        </div>
                        <div class="meta-info-row">
                            <div class="meta-info-label">Invoice Date</div>
                            <div class="meta-info-value">{{ optional($invoice->invoice_date)->format('d M Y') }}</div>
                        </div>
                    @endif
                    <div class="meta-info-row">
                        <div class="meta-info-label">Refund UTR</div>
                        <div class="meta-info-value" style="font-family:'Courier New',monospace;font-size:11px">{{ $cn['utr_id'] }}</div>
                    </div>
                </div>
            </div>

            {{-- Items --}}
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Item Description</th>
                        <th class="center" style="width:70px">Qty</th>
                        <th class="right" style="width:110px">Unit Price</th>
                        <th class="right" style="width:110px">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cn['items'] as $i => $item)
                        @php
                            $variantLabel = null;
                            if (!empty($item->selected_attributes)) {
                                $variantLabel = collect($item->selected_attributes)->map(function ($value, $key) {
                                    if (is_array($value)) {
                                        $attrName = $value['attribute'] ?? $value['name'] ?? $key;
                                        $attrVal = $value['value'] ?? $value['label'] ?? reset($value);
                                        return $attrName . ': ' . $attrVal;
                                    }
                                    return $key . ': ' . $value;
                                })->join(' · ');
                            }
                            $sku = optional($item->skuVariant)->sku ?? ($item->sku ?? optional($item->product)->sku);
                            $lineTotal = ($item->price * $item->quantity) + $item->addons->sum('price');
                        @endphp
                        <tr>
                            <td style="color:#8c9196;font-size:12px">{{ $i + 1 }}</td>
                            <td>
                                <div class="item-name">{{ $item->product_name ?? ($item->product->name ?? 'Product') }}</div>
                                @if($variantLabel)<div class="item-variant">{{ $variantLabel }}</div>@endif
                                @if($sku)<div class="item-sku">SKU: {{ $sku }}</div>@endif
                                @if($item->addons->isNotEmpty())
                                    <div class="item-variant" style="margin-top:3px">
                                        @foreach($item->addons as $addon)
                                            + {{ $addon->detail }} (&#8377;{{ number_format($addon->price, 2) }})<br>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="center">{{ $item->quantity }}</td>
                            <td class="right">&#8377;{{ number_format($item->price, 2) }}</td>
                            <td class="right">&#8377;{{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals --}}
            <div class="totals-wrap">
                <div class="totals-left">
                    <div class="inv-notes">
                        <p>
                            <strong>Reason:</strong> {{ $cn['reason'] }}<br>
                            This credit note reverses the GST charged on
                            @if($invoice) invoice <strong>{{ $invoice->invoice_number }}</strong> @else order <strong>#{{ $order->order_number }}</strong> @endif
                            and confirms the refund of &#8377;{{ number_format($cn['refund_amount'], 2) }} to the customer.
                        </p>
                    </div>
                </div>
                <div class="totals-right">
                    <table class="totals-table">
                        <tr>
                            <td class="t-label">Taxable Value Reversed</td>
                            <td class="t-value">− &#8377;{{ number_format($cn['taxable'], 2) }}</td>
                        </tr>
                        @if($setting?->show_gst_breakup)
                            @if($cn['igst'] > 0)
                                <tr><td class="t-label">IGST Reversed</td><td class="t-value">− &#8377;{{ number_format($cn['igst'], 2) }}</td></tr>
                            @endif
                            @if($cn['cgst'] > 0)
                                <tr><td class="t-label">CGST Reversed</td><td class="t-value">− &#8377;{{ number_format($cn['cgst'], 2) }}</td></tr>
                            @endif
                            @if($cn['sgst'] > 0)
                                <tr><td class="t-label">SGST Reversed</td><td class="t-value">− &#8377;{{ number_format($cn['sgst'], 2) }}</td></tr>
                            @endif
                        @elseif($cn['tax'] > 0)
                            <tr><td class="t-label">GST Reversed</td><td class="t-value">− &#8377;{{ number_format($cn['tax'], 2) }}</td></tr>
                        @endif
                        <tr class="t-total">
                            <td class="t-label">Refund Amount</td>
                            <td class="t-value">&#8377;{{ number_format($cn['refund_amount'], 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($setting?->terms_conditions)
                <div class="inv-notes" style="margin-top:28px">
                    <p><strong>Terms & Conditions</strong></p>
                    <div style="margin-top:10px;">{!! nl2br(e($setting->terms_conditions)) !!}</div>
                </div>
            @endif
        </div>

        <div class="inv-footer">
            <p>
                <strong>{{ $setting->company_name ?? config('app.name') }}</strong>
                @if($setting?->company_gstin) &nbsp;·&nbsp; GSTIN: {{ $setting->company_gstin }} @endif
                @if($setting?->company_email) &nbsp;·&nbsp; {{ $setting->company_email }} @endif
                @if($setting?->company_phone) &nbsp;·&nbsp; {{ $setting->company_phone }} @endif
                &nbsp;·&nbsp; Credit Note #{{ $cn['credit_note_no'] }}
            </p>
            <p style="margin-top:4px;font-size:11px">This credit note was generated on {{ now()->format('d M Y, h:i A') }}</p>
        </div>
    </div>
</body>

</html>