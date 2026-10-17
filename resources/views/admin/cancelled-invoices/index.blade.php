@include('admin.top-header')
<div class="main-section">
    @include('admin.header')

    <style>
        :root{--bg:#f1f2f4;--surface:#fff;--border:#e3e5e8;--text-primary:#202223;--text-secondary:#6d7175;--text-hint:#8c9196;
            --accent:#303d89;--green:#007a5e;--green-bg:#e3f1ec;--red:#b22222;--red-bg:#fce8e8;--amber:#916a00;--amber-bg:#fff5cc;
            --radius-sm:8px;--radius-md:12px;--shadow-card:0 1px 3px rgba(0,0,0,.08),0 0 0 1px var(--border);
            --font:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif}
        .list-page{background:var(--bg);padding:24px 28px;min-height:100vh;font-family:var(--font);color:var(--text-primary)}
        .list-page *{box-sizing:border-box}
        .list-page h1{font-size:20px;font-weight:650;margin:0}
        .crumb{font-size:12.5px;color:var(--text-hint);margin:3px 0 16px}
        .crumb a{color:var(--accent);text-decoration:none}.crumb span{margin:0 5px}
        .stat-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px}
        @media(max-width:800px){.stat-strip{grid-template-columns:1fr}}
        .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);padding:16px 18px;box-shadow:var(--shadow-card)}
        .stat-label{font-size:11.5px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:var(--text-hint);margin-bottom:6px}
        .stat-value{font-size:22px;font-weight:700;line-height:1}
        .btn-primary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--accent);color:#fff!important;border:none;border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none!important;font-family:var(--font)}
        .btn-secondary-dash{display:inline-flex;align-items:center;gap:6px;background:var(--surface);color:var(--text-primary)!important;border:1px solid var(--border);border-radius:var(--radius-sm);padding:8px 16px;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none!important;font-family:var(--font)}
        .list-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);overflow:hidden}
        .filter-bar{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end}
        .fg{display:flex;flex-direction:column;gap:5px}
        .fg label{font-size:12px;font-weight:600;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.03em}
        .filter-control{height:36px;border:1px solid var(--border);border-radius:var(--radius-sm);padding:0 11px;font-size:13px;font-family:var(--font);min-width:150px}
        .data-table{width:100%;border-collapse:collapse}
        .data-table thead tr{background:#fafafa;border-bottom:1px solid var(--border)}
        .data-table thead th{padding:10px 16px;font-size:11px;font-weight:650;text-transform:uppercase;letter-spacing:.05em;color:var(--text-secondary);text-align:left;white-space:nowrap}
        .data-table tbody tr{border-bottom:1px solid var(--border)}
        .data-table tbody tr:hover{background:#fafbfc}
        .data-table td{padding:13px 16px;font-size:13px;vertical-align:middle}
        .mono{font-family:'SF Mono','Fira Mono',monospace;font-weight:700;color:var(--accent);text-decoration:none}
        .pill{display:inline-flex;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:600;white-space:nowrap}
        .pill-cancel{background:var(--red-bg);color:var(--red)}
        .pill-done{background:var(--green-bg);color:var(--green)}
        .pill-pending{background:var(--amber-bg);color:var(--amber)}
        .pill-na{background:#ececec;color:#666}
        .action-btn{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:var(--radius-sm);border:1px solid var(--border);background:var(--surface);color:var(--text-secondary);text-decoration:none;font-size:12px}
        .action-btn:hover{background:#f0f1fc;color:var(--accent)}
        .pagination-bar{padding:14px 20px;border-top:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap}
        @media(max-width:768px){.list-page{padding:16px}}
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            @include('admin.partials.cancellation-tabs')

            <h1>Cancelled Invoices</h1>
            <div class="crumb">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>Cancelled Invoices
            </div>

            <div class="stat-strip">
                <div class="stat-card">
                    <div class="stat-label">Cancelled Invoices</div>
                    <div class="stat-value" style="color:var(--red)">{{ number_format($stats['total']) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Value</div>
                    <div class="stat-value">₹{{ number_format($stats['total_value'], 0) }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Refund Still Pending</div>
                    <div class="stat-value" style="color:var(--amber)">{{ number_format($stats['refund_pending']) }}</div>
                </div>
            </div>

            <div class="list-card">
                <form method="GET" action="{{ route('admin.cancelled-invoices.index') }}" class="filter-bar">
                    <div class="fg" style="flex:1;min-width:220px">
                        <label>Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="filter-control"
                            placeholder="Invoice #, order #, customer…">
                    </div>
                    <div class="fg">
                        <label>From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="filter-control">
                    </div>
                    <div class="fg">
                        <label>To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="filter-control">
                    </div>
                    <div style="display:flex;gap:8px">
                        <button type="submit" class="btn-primary-dash"><i class="fa fa-search"></i> Search</button>
                        <a href="{{ route('admin.cancelled-invoices.index') }}" class="btn-secondary-dash">Reset</a>
                    </div>
                </form>

                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Invoice Date</th>
                                <th>Cancelled On</th>
                                <th>Amount</th>
                                <th>Invoice Status</th>
                                <th>Refund</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                @php
                                    $order = $invoice->order;
                                    $refund = $order->refundTransactions->where('status', 'completed')->last();
                                @endphp
                                <tr>
                                    <td><span class="mono">{{ $invoice->invoice_number }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="mono">#{{ $order->order_number }}</a>
                                    </td>
                                    <td>
                                        <div style="font-weight:500">{{ $order->customer_name }}</div>
                                        <div style="font-size:11.5px;color:var(--text-hint)">{{ $order->customer_email }}</div>
                                    </td>
                                    <td style="color:var(--text-secondary)">{{ $invoice->created_at->format('d M Y') }}</td>
                                    <td style="color:var(--text-secondary)">{{ $order->updated_at->format('d M Y') }}</td>
                                    <td style="font-weight:700">₹{{ number_format($order->grand_total, 2) }}</td>
                                    <td><span class="pill pill-cancel">Cancelled</span></td>
                                    <td>
                                        @if($refund)
                                            <span class="pill pill-done">Refunded</span>
                                            <div style="font-size:11px;color:var(--text-hint);margin-top:3px">UTR: {{ $refund->utr_id }}</div>
                                        @elseif($order->payment_status === 'paid')
                                            <a href="{{ route('admin.cancelled-refunds.index', ['search' => $order->order_number]) }}"
                                               class="pill pill-pending" style="text-decoration:none">Refund pending →</a>
                                        @else
                                            <span class="pill pill-na">No refund needed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank"
                                           class="action-btn" title="View Invoice"><i class="fa fa-file-pdf-o"></i></a>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                           class="action-btn" title="View Order"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" style="text-align:center;padding:48px;color:var(--text-hint)">
                                    No cancelled invoices found.
                                </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-bar">
                    <div style="font-size:12.5px;color:var(--text-hint)">
                        @if($invoices->total() > 0)
                            Showing {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }} of {{ number_format($invoices->total()) }}
                        @else
                            No results
                        @endif
                    </div>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')