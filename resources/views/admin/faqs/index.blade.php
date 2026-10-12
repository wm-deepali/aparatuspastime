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
    .btn-secondary-dash { display:inline-flex; align-items:center; gap:6px; background:var(--surface); color:var(--text-primary) !important; border:1px solid var(--border); border-radius:var(--radius-sm); padding:8px 16px; font-size:13px; font-weight:500; cursor:pointer; font-family:var(--font); }
    .btn-secondary-dash:hover { background:var(--bg); }

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
    .q-sub { font-size:11.5px; color:var(--text-hint); margin-top:3px; max-width:520px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

    .pill { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:600; white-space:nowrap; }
    .pill::before { content:''; width:6px; height:6px; border-radius:50%; }
    .pill-active { background:var(--green-bg); color:var(--green); } .pill-active::before { background:var(--green); }
    .pill-inactive { background:var(--red-bg); color:var(--red); } .pill-inactive::before { background:var(--red); }

    .action-btn { display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; border-radius:var(--radius-sm); border:1px solid var(--border); background:var(--surface); color:var(--text-secondary); cursor:pointer; font-size:12px; }
    .action-btn:hover { background:var(--bg); }
    .action-btn.edit:hover { background:var(--accent-light); color:var(--accent); }
    .action-btn.danger:hover { background:var(--red-bg); color:var(--red); }

    .empty-row { text-align:center; padding:36px 16px; color:var(--text-hint); font-size:13px; }
    .alert-ok { background:var(--green-bg); color:var(--green); border:1px solid #b9dccf; border-radius:var(--radius-sm); padding:10px 14px; font-size:13px; margin-bottom:16px; }
    .alert-err { background:var(--red-bg); color:var(--red); border:1px solid #f5c0c0; border-radius:var(--radius-sm); padding:10px 14px; font-size:13px; margin-bottom:16px; }
    .alert-err ul { margin:0; padding-left:18px; }

    /* modal form fields */
    .f-group { margin-bottom:14px; }
    .f-label { display:block; font-size:12px; font-weight:600; color:var(--text-secondary); text-transform:uppercase; letter-spacing:.03em; margin-bottom:6px; }
    .f-input, .f-select, .f-textarea { width:100%; border:1px solid var(--border); border-radius:var(--radius-sm); padding:8px 12px; font-size:13.5px; font-family:var(--font); outline:none; background:#fff; }
    .f-input:focus, .f-select:focus, .f-textarea:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(48,61,137,.12); }
    .f-hint { font-size:11.5px; color:var(--text-hint); margin-top:4px; }
    .f-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .f-check { display:flex; align-items:center; gap:8px; font-size:13px; font-weight:500; }

    @media(max-width:768px) { .list-page { padding:16px; } }
    </style>

    <div class="app-content content container-fluid">
        <div class="list-page">

            <div class="list-page-header">
                <div>
                    <h1>Manage FAQs</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>Manage FAQs
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <button type="button" class="btn-secondary-dash" onclick="openCategory()">
                        <i class="fa fa-plus"></i> Add Category
                    </button>
                    <button type="button" class="btn-primary-dash" onclick="openFaq()" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                        <i class="fa fa-plus"></i> Add Question
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div class="alert-ok">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert-err"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <!-- CATEGORIES -->
            <div class="list-card">
                <div class="list-card-head"><h5>Categories</h5></div>
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th>Name</th>
                                <th style="width:150px">Icon</th>
                                <th style="width:100px">Color</th>
                                <th style="width:90px">Questions</th>
                                <th style="width:80px">Order</th>
                                <th style="width:100px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $c)
                                <tr id="cat{{ $c->id }}">
                                    <td><span class="id-chip">{{ $c->id }}</span></td>
                                    <td><span class="q-text">{{ $c->name }}</span></td>
                                    <td>
                                        @if ($c->icon)
                                            <i class="fa-solid {{ $c->icon }}"></i> <span style="color:var(--text-hint);font-size:11.5px">{{ $c->icon }}</span>
                                        @else — @endif
                                    </td>
                                    <td><span class="cat-chip">{{ ucfirst($c->color) }}</span></td>
                                    <td>{{ $c->faqs_count }}</td>
                                    <td>{{ $c->sort_order }}</td>
                                    <td>
                                        <span class="pill {{ $c->status ? 'pill-active' : 'pill-inactive' }}">{{ $c->status ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <button type="button" class="action-btn edit" title="Edit"
                                                data-item="{{ json_encode($c->only(['id','name','icon','color','sort_order','status'])) }}"
                                                onclick="openCategory(JSON.parse(this.dataset.item))">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button type="button" class="action-btn danger" title="Delete"
                                                onclick="removeItem('{{ url('admin/faq-categories') }}/{{ $c->id }}', 'cat{{ $c->id }}', 'Delete category?', 'All questions inside it will be deleted too.')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="empty-row">No categories yet. Add one to start adding questions.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- QUESTIONS -->
            <div class="list-card">
                <div class="list-card-head"><h5>Questions</h5></div>
                <div style="overflow-x:auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:60px">ID</th>
                                <th>Question</th>
                                <th style="width:200px">Category</th>
                                <th style="width:80px">Order</th>
                                <th style="width:100px">Status</th>
                                <th style="width:90px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faqs as $f)
                                <tr id="faq{{ $f->id }}">
                                    <td><span class="id-chip">{{ $f->id }}</span></td>
                                    <td>
                                        <div class="q-text">{{ $f->question }}</div>
                                        <div class="q-sub">{{ $f->answer }}</div>
                                    </td>
                                    <td><span class="cat-chip">{{ $f->category->name ?? '—' }}</span></td>
                                    <td>{{ $f->sort_order }}</td>
                                    <td>
                                        <span class="pill {{ $f->status ? 'pill-active' : 'pill-inactive' }}">{{ $f->status ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <button type="button" class="action-btn edit" title="Edit"
                                                data-item="{{ json_encode($f->only(['id','faq_category_id','question','answer','sort_order','status'])) }}"
                                                onclick="openFaq(JSON.parse(this.dataset.item))">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button type="button" class="action-btn danger" title="Delete"
                                                onclick="removeItem('{{ url('admin/faq-items') }}/{{ $f->id }}', 'faq{{ $f->id }}', 'Delete question?', 'This action cannot be undone.')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="empty-row">No questions yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- CATEGORY MODAL -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form class="modal-content" id="categoryForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="categoryMethod" value="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryTitle">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="f-group">
                    <label class="f-label">Name *</label>
                    <input type="text" name="name" id="cat_name" class="f-input" required>
                </div>
                <div class="f-row">
                    <div class="f-group">
                        <label class="f-label">Icon</label>
                        <input type="text" name="icon" id="cat_icon" class="f-input" placeholder="fa-box">
                        <div class="f-hint">Font Awesome class, e.g. fa-truck</div>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Color *</label>
                        <select name="color" id="cat_color" class="f-select" required>
                            @foreach (['blue','orange','purple','rose','mint','yellow'] as $col)
                                <option value="{{ $col }}">{{ ucfirst($col) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="f-row">
                    <div class="f-group">
                        <label class="f-label">Sort Order</label>
                        <input type="number" name="sort_order" id="cat_sort" class="f-input" min="0" value="0">
                    </div>
                    <div class="f-group" style="display:flex;align-items:flex-end">
                        <label class="f-check"><input type="checkbox" name="status" id="cat_status" checked> Active</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-dash" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
    </div>
</div>

<!-- FAQ MODAL -->
<div class="modal fade" id="faqModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="faqForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="faqMethod" value="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="faqTitle">Add Question</h5>
                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="f-group">
                    <label class="f-label">Category *</label>
                    <select name="faq_category_id" id="faq_cat" class="f-select" required>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="f-group">
                    <label class="f-label">Question *</label>
                    <input type="text" name="question" id="faq_q" class="f-input" required>
                </div>
                <div class="f-group">
                    <label class="f-label">Answer *</label>
                    <textarea name="answer" id="faq_a" class="f-textarea" rows="6" required></textarea>
                    <div class="f-hint">Plain text. Line breaks are kept.</div>
                </div>
                <div class="f-row">
                    <div class="f-group">
                        <label class="f-label">Sort Order</label>
                        <input type="number" name="sort_order" id="faq_sort" class="f-input" min="0" value="0">
                    </div>
                    <div class="f-group" style="display:flex;align-items:flex-end">
                        <label class="f-check"><input type="checkbox" name="status" id="faq_status" checked> Active</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary-dash" data-dismiss="modal" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-primary-dash"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
    </div>
</div>

@include('admin.footer')

<script>
const CAT_STORE = "{{ route('admin.faq-categories.store') }}";
const CAT_BASE  = "{{ url('admin/faq-categories') }}";
const FAQ_STORE = "{{ route('admin.faq-items.store') }}";
const FAQ_BASE  = "{{ url('admin/faq-items') }}";
const CSRF      = "{{ csrf_token() }}";

/* ---------- modal helpers (work with BS 5.1+, BS 5.0, jQuery, or plain fallback) ---------- */
function manualShow(el) {
    el.dataset.manual = '1';
    el.style.display = 'block';
    el.classList.add('show');
    el.removeAttribute('aria-hidden');
    document.body.classList.add('modal-open');
    if (!document.getElementById('manualBackdrop')) {
        const b = document.createElement('div');
        b.id = 'manualBackdrop';
        b.className = 'modal-backdrop fade show';
        document.body.appendChild(b);
    }
}

function manualHide(el) {
    el.style.display = 'none';
    el.classList.remove('show');
    el.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');
    const b = document.getElementById('manualBackdrop');
    if (b) b.remove();
    delete el.dataset.manual;
}

function showModal(id) {
    const el = document.getElementById(id);

    if (window.bootstrap && typeof bootstrap.Modal === 'function') {
        try {
            if (typeof bootstrap.Modal.getOrCreateInstance === 'function') {
                bootstrap.Modal.getOrCreateInstance(el).show();
            } else {
                const inst = (typeof bootstrap.Modal.getInstance === 'function' && bootstrap.Modal.getInstance(el))
                          || new bootstrap.Modal(el);
                inst.show();
            }
            return;
        } catch (e) { /* fall through */ }
    }

    if (window.jQuery && jQuery.fn && typeof jQuery.fn.modal === 'function') {
        jQuery(el).modal('show');
        return;
    }

    manualShow(el);
}

// close buttons / backdrop click / Esc - only active for the manual fallback
document.addEventListener('click', function (e) {
    const open = document.querySelector('.modal[data-manual="1"]');
    if (!open) return;
    if (e.target.closest('[data-dismiss="modal"], [data-bs-dismiss="modal"]') || e.target === open) {
        manualHide(open);
    }
});
document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    const open = document.querySelector('.modal[data-manual="1"]');
    if (open) manualHide(open);
});

/* ---------- category / faq modals ---------- */
function openCategory(item) {
    const f = document.getElementById('categoryForm');
    document.getElementById('categoryTitle').textContent = item ? 'Edit Category' : 'Add Category';
    document.getElementById('categoryMethod').value = item ? 'PUT' : 'POST';
    f.action = item ? CAT_BASE + '/' + item.id : CAT_STORE;

    document.getElementById('cat_name').value   = item ? item.name : '';
    document.getElementById('cat_icon').value   = item ? (item.icon || '') : '';
    document.getElementById('cat_color').value  = item ? item.color : 'blue';
    document.getElementById('cat_sort').value   = item ? item.sort_order : 0;
    document.getElementById('cat_status').checked = item ? !!item.status : true;
    showModal('categoryModal');
}

function openFaq(item) {
    const f = document.getElementById('faqForm');
    document.getElementById('faqTitle').textContent = item ? 'Edit Question' : 'Add Question';
    document.getElementById('faqMethod').value = item ? 'PUT' : 'POST';
    f.action = item ? FAQ_BASE + '/' + item.id : FAQ_STORE;

    if (item) document.getElementById('faq_cat').value = item.faq_category_id;
    document.getElementById('faq_q').value    = item ? item.question : '';
    document.getElementById('faq_a').value    = item ? item.answer : '';
    document.getElementById('faq_sort').value = item ? item.sort_order : 0;
    document.getElementById('faq_status').checked = item ? !!item.status : true;
    showModal('faqModal');
}

/* ---------- delete (no jQuery needed) ---------- */
function doDelete(url, rowId) {
    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => { if (!r.ok) throw new Error(); return r.json().catch(() => ({})); })
    .then(res => {
        const msg = (res && res.message) ? res.message : 'Deleted.';
        if (rowId.startsWith('cat')) {
            // category delete also removes its questions, so reload
            if (window.Swal) Swal.fire('Deleted!', msg, 'success').then(() => location.reload());
            else location.reload();
        } else {
            const row = document.getElementById(rowId);
            if (row) row.remove();
            if (window.Swal) Swal.fire('Deleted!', msg, 'success');
        }
    })
    .catch(() => {
        if (window.Swal) Swal.fire('Error', 'Could not delete this item.', 'error');
        else alert('Could not delete this item.');
    });
}

function removeItem(url, rowId, title, text) {
    if (window.Swal) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
        }).then(result => { if (result.isConfirmed) doDelete(url, rowId); });
    } else if (confirm(title + '\n' + text)) {
        doDelete(url, rowId);
    }
}
</script>