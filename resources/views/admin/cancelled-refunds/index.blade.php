@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --bg:#f1f2f4; --surface:#fff; --border:#e3e5e8; --text-primary:#202223; --text-secondary:#6d7175;
            --text-hint:#8c9196; --accent:#303d89; --accent-light:#f0f1fc; --green:#007a5e; --green-bg:#e3f1ec;
            --red:#b22222; --amber:#916a00; --amber-bg:#fff5cc; --radius-sm:8px; --radius-md:12px;
            --shadow-card:0 1px 3px rgba(0,0,0,.08),0 0 0 1px var(--border);
            --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
        }
        .list-page{background:var(--bg);padding:24px 28px;min-height:100vh;font-family:var(--font);color:var(--text-primary)}
        .list-page *{box-sizing:border-box}
        .list-page-header h1{font-size:20px;font-weight:650;margin:0}
        .crumb{font-size:12.5px;color:var(--text-hint);margin:3px 0 20px}
        .crumb a{color:var(--accent);text-decoration:none}.crumb span{margin:0 5px}
        .stat-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px}
        @media(max-width:800px){.stat-strip{grid-template-columns:1fr}}
        .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);padding:16px 18px;box-shadow:var(--shadow-card)}
        .stat-label{font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:var(--text-hint);margin-bottom:6px}
        .stat-value{font-size:22px;font-weight:700;line-height:1}
        .btn-primary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--accent);color:#fff!important;border:none;border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none!important;font-family:var(--font)}
        .btn-secondary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--surface);color:var(--text-primary)!important;border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none!important;font-family:var(--font)}
        .list-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);overflow:hidden}
        .tabs{display:flex;gap:4px;padding:12px 20px 0;border-bottom:1px solid var(--border)}
        .tab{padding:9px 14px;font-size:13px;font-weight:600;color:var(--text-secondary);text-decoration:none;border-bottom:2px solid transparent}
        .tab.active{color:var(--accent);border-bottom-color:var(--accent)}
        .filter-bar{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;gap:8px}
        .filter-control{height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 11px;font-size:13px;min-width:260px;font-family:var(--font)}
        .data-table{width:100%;border-collapse:collapse}
        .data-table thead tr{background:#fafafa;border-bottom:1px solid var(--border)}
        .data-table thead th{padding:10px 16px;font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);text-align:left;white-space:nowrap}
        .data-table tbody tr{border-bottom:1px solid var(--border)}
        .data-table td{padding:13px 16px;font-size:13px;vertical-align:middle}
        .order-id{color:var(--accent);font-weight:700;font-family:'SF Mono','Fira Mono',monospace;text-decoration:none}
        .pill{display:inline-flex;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600}
        .pill-pending{background:var(--amber-bg);color:var(--amber)}
        .pill-done{background:var(--green-bg);color:var(--green)}
        .success-banner{display:flex;gap:10px;background:var(--green-bg);border:1px solid #b2dfd2;border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;font-size:13px;font-weight:500;color:var(--green)}
        .mf-label{display:block;font-size:12px;font-weight:600;color:#6d7175;text-transform:uppercase;letter-spacing:.03em;margin-bottom:5px}
        .mf-input{width:100%;border:1px solid #e3e5e8;border-radius:8px;padding:8px 10px;font-size:13px;font-family:inherit;outline:none}
        .refund-tab{flex:1;border:1px solid #e3e5e8;border-radius:8px;padding:10px 12px;text-align:center;cursor:pointer;font-size:13px;font-weight:500;color:#202223;background:#fff}
        @media(max-width:768px){.list-page{padding:16px}}
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            @if(session('success'))
                <div class="success-banner"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="success-banner" style="background:#fce8e8;border-color:#f0c0c0;color:#b22222">
                    <i class="fa fa-times-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <div class="list-page-header">
                <h1>Cancelled Order Refunds</h1>
                <div class="crumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>Cancelled Order Refunds
                </div>
            </div>

            <div class="stat-strip">
                <div class="stat-card">
                    <div class="stat-label">Refunds Pending</div>
                    <div class="stat-value" style="color:var(--amber)">{{ number_format($stats['pending_count']) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Pending Amount</div>
                    <div class="stat-value" style="color:var(--red)">₹{{ number_format($stats['pending_amount'], 0) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Already Refunded</div>
                    <div class="stat-value" style="color:var(--green)">{{ number_format($stats['refunded_count']) }}</div>
                </div>
            </div>

            <div class="list-card">
                <div class="tabs">
                    <a class="tab {{ $tab === 'pending' ? 'active' : '' }}" href="{{ route('admin.cancelled-refunds.index', ['tab' => 'pending']) }}">Pending Refund</a>
                    <a class="tab {{ $tab === 'refunded' ? 'active' : '' }}" href="{{ route('admin.cancelled-refunds.index', ['tab' => 'refunded']) }}">Refunded</a>
                </div>

                <form method="GET" class="filter-bar">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="search" value="{{ request('search') }}" class="filter-control"
                        placeholder="Order number, customer name or email">
                    <button class="btn-primary-dash" type="submit"><i class="fa fa-search"></i> Search</button>
                    <a href="{{ route('admin.cancelled-refunds.index', ['tab' => $tab]) }}" class="btn-secondary-dash">Reset</a>
                </form>

                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Payment</th>
                                <th>Amount</th>
                                <th>Cancelled On</th>
                                <th>Status</th>
                                <th style="width:150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php $done = $order->refundTransactions->where('status', 'completed')->last(); @endphp
                                <tr>
                                    <td><a class="order-id" href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->order_number }}</a></td>
                                    <td>
                                        <div style="font-weight:500">{{ $order->customer_name }}</div>
                                        <div style="font-size:11.5px;color:var(--text-hint)">{{ $order->customer_email }}</div>
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? '—')) }}</td>
                                    <td style="font-weight:700">₹{{ number_format($done->amount ?? $order->grand_total, 2) }}</td>
                                    <td style="color:var(--text-secondary)">{{ $order->updated_at->format('d M Y') }}</td>
                                    <td>
                                        @if($done)
                                            <span class="pill pill-done">Refunded</span>
                                            <div style="font-size:11px;color:var(--text-hint);margin-top:3px">UTR: {{ $done->utr_id }}</div>
                                        @else
                                            <span class="pill pill-pending">Refund pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$done)
                                            <button type="button" class="btn-primary-dash"
                                                onclick="openCancelRefund({{ \Illuminate\Support\Js::from([
                                                    'id' => $order->id,
                                                    'order' => $order->order_number,
                                                    'customer' => $order->customer_name,
                                                    'amount' => (float) $order->grand_total,
                                                ]) }})">
                                                <i class="fa fa-credit-card"></i> Refund
                                            </button>
                                        @else
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-secondary-dash">View</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" style="text-align:center;padding:48px;color:var(--text-hint)">
                                    No orders in this list.
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="padding:14px 20px;border-top:1px solid var(--border)">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Refund Modal ===== --}}
    <div class="modal fade" id="cancelRefundModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius:12px;border:1px solid #e3e5e8;overflow:hidden">
                <div class="modal-header" style="border-bottom:1px solid #e3e5e8;padding:18px 20px">
                    <h5 class="modal-title" style="font-size:15px;font-weight:600;margin:0">Process Refund — Cancelled Order</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" id="cancelRefundForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" style="padding:20px">
                        <div id="cr-info" style="background:#f1f2f4;border:1px solid #e3e5e8;border-radius:8px;padding:12px;margin-bottom:16px;font-size:13px"></div>

                        <div style="margin-bottom:14px">
                            <label class="mf-label">Refund Amount (₹) <span style="color:#b22222">*</span></label>
                            <input type="number" step="0.01" min="1" name="amount" id="cr-amount" class="mf-input" required>
                        </div>

                        <div style="margin-bottom:14px">
                            <label class="mf-label">Payment Method <span style="color:#b22222">*</span></label>
                            <div style="display:flex;gap:8px">
                                <label id="cr-tab-neft_rtgs_imps" class="refund-tab">
                                    <input type="radio" name="refund_method" value="neft_rtgs_imps" style="display:none"
                                        onchange="crToggle('neft_rtgs_imps')" required> NEFT / RTGS / IMPS
                                </label>
                                <label id="cr-tab-upi" class="refund-tab">
                                    <input type="radio" name="refund_method" value="upi" style="display:none"
                                        onchange="crToggle('upi')"> UPI
                                </label>
                            </div>
                        </div>

                        <div id="cr-method-neft_rtgs_imps" style="display:none">
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                                <div><label class="mf-label">Bank Name</label><input type="text" name="bank_name" class="mf-input"></div>
                                <div><label class="mf-label">Account Holder</label><input type="text" name="account_name" class="mf-input"></div>
                                <div><label class="mf-label">Account Number</label><input type="text" name="account_number" class="mf-input"></div>
                                <div><label class="mf-label">IFSC Code</label><input type="text" name="ifsc_code" class="mf-input"></div>
                                <div><label class="mf-label">Bank Branch</label><input type="text" name="bank_branch" class="mf-input"></div>
                                <div>
                                    <label class="mf-label">Account Type</label>
                                    <select name="account_type" class="mf-input">
                                        <option value="">Select…</option>
                                        <option value="savings">Savings</option>
                                        <option value="current">Current</option>
                                        <option value="salary">Salary</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="cr-method-upi" style="display:none">
                            <label class="mf-label">UPI ID</label>
                            <input type="text" name="upi_id" class="mf-input" placeholder="name@upi">
                        </div>

                        <div style="margin:14px 0">
                            <label class="mf-label">Reference / UTR ID <span style="color:#b22222">*</span></label>
                            <input type="text" name="utr_id" required class="mf-input">
                        </div>
                        <div style="margin-bottom:14px">
                            <label class="mf-label">Remarks</label>
                            <textarea name="remarks" rows="2" class="mf-input"></textarea>
                        </div>
                        <div>
                            <label class="mf-label">Payment Proof</label>
                            <input type="file" name="payment_proof" accept="image/*,application/pdf" class="mf-input" style="padding:6px">
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #e3e5e8;padding:14px 20px;display:flex;justify-content:flex-end;gap:8px">
                        <button type="button" class="btn-secondary-dash" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn-primary-dash"><i class="fa fa-paper-plane"></i> Submit Refund</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')

<script>
function openCancelRefund(o) {
    document.getElementById('cr-info').innerHTML =
        '<div><b>Order:</b> #' + o.order + '</div><div><b>Customer:</b> ' + o.customer + '</div>' +
        '<div><b>Order total:</b> ₹' + Number(o.amount).toLocaleString('en-IN') + '</div>';

    var form = document.getElementById('cancelRefundForm');
    form.reset();
    form.action = '/admin/cancelled-refunds/' + o.id + '/refund';

    var amt = document.getElementById('cr-amount');
    amt.value = o.amount;
    amt.max = o.amount;

    ['neft_rtgs_imps', 'upi'].forEach(function (m) {
        document.getElementById('cr-method-' + m).style.display = 'none';
        var t = document.getElementById('cr-tab-' + m);
        t.style.borderColor = '#e3e5e8'; t.style.color = '#202223'; t.style.background = '#fff';
    });
    $('#cancelRefundModal').modal('show');
}

function crToggle(selected) {
    ['neft_rtgs_imps', 'upi'].forEach(function (m) {
        document.getElementById('cr-method-' + m).style.display = (m === selected) ? 'block' : 'none';
        var t = document.getElementById('cr-tab-' + m);
        var on = (m === selected);
        t.style.borderColor = on ? '#303d89' : '#e3e5e8';
        t.style.color = on ? '#303d89' : '#202223';
        t.style.background = on ? '#f0f1fc' : '#fff';
    });
}
</script>