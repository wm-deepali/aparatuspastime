@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
    :root {
        --bg:#f1f2f4; --surface:#fff; --border:#e3e5e8; --text-primary:#202223; --text-secondary:#6d7175; --text-hint:#8c9196;
        --accent:#303d89; --accent-light:#f0f1fc; --green:#007a5e; --green-bg:#e3f1ec; --red:#b22222; --red-bg:#fce8e8;
        --radius-sm:8px; --radius-md:12px; --shadow-card:0 1px 3px rgba(0,0,0,.08), 0 0 0 1px var(--border);
        --font:'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .list-page { background: var(--bg); padding: 24px 28px; min-height: 100vh; font-family: var(--font); color: var(--text-primary); }
    .list-page * { box-sizing: border-box; }
    .list-page-header { display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
    .list-page-header h1 { font-size:20px; font-weight:650; margin:0; }
    .crumb { font-size:12.5px; color:var(--text-hint); margin-top:3px; }
    .crumb a { color:var(--accent); text-decoration:none; }
    .crumb span { margin:0 5px; }

    .btn-primary-dash { display:inline-flex; align-items:center; gap:6px; background:var(--accent); color:#fff !important; border:none; border-radius:var(--radius-sm); padding:8px 16px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none !important; font-family:var(--font); box-shadow:0 1px 3px rgba(48,61,137,.25); white-space:nowrap; }
    .btn-primary-dash:hover { background:#252f70; }

    .list-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-md); box-shadow:var(--shadow-card); overflow:hidden; margin-bottom:20px; }
    .list-card-head { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid var(--border); background:#fafafa; }
    .list-card-head h5 { font-size:13px; font-weight:650; margin:0; }

    .data-table { width:100%; border-collapse:collapse; }
    .data-table thead tr { background:#fafafa; border-bottom:1px solid var(--border); }
    .data-table thead th { padding:10px 16px; font-size:11px; font-weight:650; text-transform:uppercase; letter-spacing:.05em; color:var(--text-secondary); white-space:nowrap; text-align:left; }
    .data-table tbody tr { border-bottom:1px solid var(--border); }
    .data-table tbody tr:last-child { border-bottom:none; }
    .data-table tbody tr:hover { background:#fafbfc; }
    .data-table td { padding:12px 16px; font-size:13px; vertical-align:middle; }

    .id-chip { display:inline-block; background:var(--bg); border:1px solid var(--border); border-radius:6px; padding:2px 8px; font-size:11.5px; font-family:monospace; color:var(--text-secondary); }
    .cat-chip { display:inline-block; background:var(--accent-light); color:var(--accent); border-radius:6px; padding:2px 9px; font-size:11.5px; font-weight:600; white-space:nowrap; }
    .q-text { font-weight:600; line-height:1.4; }
    .q-sub { font-size:11.5px; color:var(--text-hint); margin-top:3px; font-family:monospace; }

    .pill { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:600; white-space:nowrap; }
    .pill::before { content:''; width:6px; height:6px; border-radius:50%; }
    .pill-active { background:var(--green-bg); color:var(--green); } .pill-active::before { background:var(--green); }
    .pill-inactive { background:var(--red-bg); color:var(--red); } .pill-inactive::before { background:var(--red); }

    .action-btn { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:var(--radius-sm); border:1px solid var(--border); background:var(--surface); color:var(--text-secondary); cursor:pointer; font-size:12px; text-decoration:none !important; }
    .action-btn:hover { background:var(--bg); }
    .action-btn.edit:hover { background:var(--accent-light); color:var(--accent); }
    .action-btn.danger:hover { background:var(--red-bg); color:var(--red); }

    .empty-row { text-align:center; padding:36px 16px; color:var(--text-hint); font-size:13px; }
    .alert-ok { background:var(--green-bg); color:var(--green); border:1px solid #b9dccf; border-radius:var(--radius-sm); padding:10px 14px; font-size:13px; margin-bottom:16px; }
    .alert-err { background:var(--red-bg); color:var(--red); border:1px solid #f5c0c0; border-radius:var(--radius-sm); padding:10px 14px; font-size:13px; margin-bottom:16px; }
    .info-banner { background:var(--accent-light); border:1px solid #c7cdf5; border-radius:var(--radius-md); padding:12px 18px; margin-bottom:20px; font-size:13px; color:var(--accent); font-weight:500; }

    @media(max-width:768px) { .list-page { padding:16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <div class="list-page-header">
                <div>
                    <h1>Pages</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>Pages
                    </div>
                </div>
                <a href="{{ route('admin.dynamic-pages.create') }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add Page
                </a>
            </div>

            <div class="info-banner">
                Policy and info pages shown on the website (Terms, Privacy, Shipping and so on).
                Built-in pages can be edited or hidden but not deleted, because the footer links to them.
            </div>

            @if (session('success'))
                <div class="alert-ok">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert-err">{{ $errors->first() }}</div>
            @endif

            <div class="list-card">
                <div class="list-card-head"><h5>All Pages</h5></div>
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th>Page</th>
                                <th style="width:180px">Badge</th>
                                <th style="width:160px">Date shown</th>
                                <th style="width:90px">Type</th>
                                <th style="width:100px">Status</th>
                                <th style="width:120px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pages as $p)
                                <tr id="page{{ $p->id }}">
                                    <td><span class="id-chip">{{ $p->id }}</span></td>
                                    <td>
                                        <div class="q-text">{{ $p->heading }}</div>
                                        <div class="q-sub">/{{ $p->slug }}</div>
                                    </td>
                                    <td>{{ $p->badge_text ?: '—' }}</td>
                                    <td>{{ $p->date_line ?: '—' }}</td>
                                    <td><span class="cat-chip">{{ $p->is_system ? 'Built-in' : 'Custom' }}</span></td>
                                    <td>
                                        <span class="pill {{ $p->status ? 'pill-active' : 'pill-inactive' }}">{{ $p->status ? 'Active' : 'Hidden' }}</span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ $p->url }}" target="_blank" class="action-btn" title="View on site">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.dynamic-pages.edit', $p->id) }}" class="action-btn edit" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            @unless ($p->is_system)
                                                <button type="button" class="action-btn danger" title="Delete"
                                                    onclick="removeItem('{{ route('admin.dynamic-pages.index') }}/{{ $p->id }}', 'page{{ $p->id }}', 'Delete page?', 'This page will be removed from the site.')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endunless
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="empty-row">No pages yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
const CSRF = "{{ csrf_token() }}";

function doDelete(url, rowId) {
    fetch(url, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json().catch(() => ({})).then(res => ({ ok: r.ok, res })))
    .then(({ ok, res }) => {
        const msg = (res && res.message) ? res.message : (ok ? 'Deleted.' : 'Could not delete this page.');
        if (ok) {
            const row = document.getElementById(rowId);
            if (row) row.remove();
        }
        if (window.Swal) Swal.fire(ok ? 'Deleted!' : 'Error', msg, ok ? 'success' : 'error');
        else alert(msg);
    })
    .catch(() => {
        if (window.Swal) Swal.fire('Error', 'Could not delete this page.', 'error');
        else alert('Could not delete this page.');
    });
}

function removeItem(url, rowId, title, text) {
    if (window.Swal) {
        Swal.fire({
            title: title, text: text, icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#d33', confirmButtonText: 'Yes, Delete'
        }).then(result => { if (result.isConfirmed) doDelete(url, rowId); });
    } else if (confirm(title + '\n' + text)) {
        doDelete(url, rowId);
    }
}
</script>