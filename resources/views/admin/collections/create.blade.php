@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        :root {
            --bg: #f1f2f4;
            --surface: #ffffff;
            --border: #e3e5e8;
            --text-primary: #202223;
            --text-secondary: #6d7175;
            --text-hint: #8c9196;
            --accent: #303d89;
            --accent-light: #f0f1fc;
            --red: #b22222;
            --red-bg: #fce8e8;
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .create-page {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .create-page * {
            box-sizing: border-box;
        }

        /* ── Page header ── */
        .create-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .create-page-header h1 {
            font-size: 20px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
        }

        .crumb {
            font-size: 12.5px;
            color: var(--text-hint);
            margin-top: 3px;
        }

        .crumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .crumb a:hover {
            text-decoration: underline;
        }

        .crumb span {
            margin: 0 5px;
        }

        /* ── Buttons ── */
        .btn-primary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent);
            color: #fff !important;
            border: none;
            border-radius: var(--radius-sm);
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
            box-shadow: 0 1px 3px rgba(48, 61, 137, .25);
        }

        .btn-primary-dash:hover:not(:disabled) {
            background: #252f70;
        }

        .btn-primary-dash:disabled {
            opacity: .65;
            cursor: not-allowed;
        }

        .btn-secondary-dash {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface);
            color: var(--text-primary) !important;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
            cursor: pointer;
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
        }

        /* ── Two-column layout ── */
        .create-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:900px) {
            .create-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ── Section card ── */
        .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .section-card:last-child {
            margin-bottom: 0;
        }

        .section-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            background: #fafafa;
        }

        .section-card-header h5 {
            font-size: 13px;
            font-weight: 650;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: .01em;
        }

        .section-card-body {
            padding: 20px;
        }

        /* ── Form fields ── */
        .field-group {
            margin-bottom: 16px;
        }

        .field-group:last-child {
            margin-bottom: 0;
        }

        .field-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: .03em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .field-label .req {
            color: var(--red);
            margin-left: 2px;
        }

        .field-input,
        .field-select,
        .field-textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            font-family: var(--font);
        }

        .field-input,
        .field-select {
            height: 38px;
            padding: 0 12px;
        }

        .field-textarea {
            padding: 10px 12px;
            resize: vertical;
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        .field-hint {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        /* ── Slug prefix ── */
        .slug-wrap {
            display: flex;
        }

        .slug-prefix {
            display: inline-flex;
            align-items: center;
            padding: 0 10px;
            background: var(--bg);
            border: 1px solid var(--border);
            border-right: none;
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            font-size: 12px;
            color: var(--text-hint);
            white-space: nowrap;
        }

        .slug-wrap .field-input {
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        }

        /* ── Toggle rows (right column) ── */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--bg);
        }

        .toggle-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .toggle-row:first-child {
            padding-top: 0;
        }

        .toggle-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .toggle-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 2px;
        }

        .field-select-sm {
            height: 32px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 28px 0 10px;
            font-size: 12.5px;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            font-family: var(--font);
            transition: border-color .15s, box-shadow .15s;
            min-width: 100px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
        }

        .field-select-sm:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        /* ── Action bar ── */
        .action-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-card);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        @media(max-width:768px) {
            .create-page {
                padding: 16px;
            }
        }
    </style>

    <div class="app-content content container-fluid">
        <div class="create-page">

            <!-- Page header -->
            <div class="create-page-header">
                <div>
                    <h1>Add Collection</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.collections.index') }}">Manage Collections</a>
                        <span>›</span>
                        Add Collection
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div
                    style="background:var(--red-bg);color:var(--red);border:1px solid var(--red);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:16px;font-size:13px">
                    <ul style="margin:0;padding-left:18px">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.collections.store') }}" id="collectionForm">
                @csrf

                <div class="create-layout">

                    <!-- ── LEFT column ── -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Collection Details</h5>
                            </div>
                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Name <span class="req">*</span></label>
                                    <input type="text" name="name" id="name" class="field-input"
                                        value="{{ old('name') }}" required>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Slug</label>
                                    <div class="slug-wrap">
                                        <span class="slug-prefix">collection/</span>
                                        <input type="text" name="slug" id="slug" class="field-input"
                                            value="{{ old('slug') }}">
                                    </div>
                                    <div class="field-hint">Auto-generated from name. You can edit manually.</div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Sort Order</label>
                                    <input type="number" name="sort_order" class="field-input"
                                        value="{{ old('sort_order', 0) }}" style="max-width:120px">
                                    <div class="field-hint">Lower numbers appear first.</div>
                                </div>

                            </div>
                        </div>

                          <div class="section-card">
                            <div class="section-card-header">
                                <h5>Header Navigation</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Show in header</div>
                                        <div class="toggle-sub">Adds a link in the main menu</div>
                                    </div>
                                    <select name="show_in_header" class="field-select-sm">
                                        <option value="1" {{ old('show_in_header', 0) == 1 ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ old('show_in_header', 0) == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>

                                <div class="field-group" style="margin-top:14px">
                                    <label class="field-label">Header Order</label>
                                    <input type="number" name="header_order" class="field-input" style="max-width:120px"
                                        value="{{ old('header_order', 0) }}">
                                    <div class="field-hint">Lower numbers appear first.</div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Icon</label>
                                    <input type="text" name="header_icon" class="field-input"
                                        value="{{ old('header_icon') }}" placeholder="fa-solid fa-star">
                                    <div class="field-hint">Font Awesome classes.</div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Color</label>
                                    <input type="text" name="header_color" class="field-input" list="headerColors"
                                        value="{{ old('header_color') }}" placeholder="mint">
                                    <datalist id="headerColors">
                                        <option value="mint">
                                        <option value="soft-coral">
                                    </datalist>
                                    <div class="field-hint">Use a color name that exists in your Tailwind config.</div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Badge Text</label>
                                    <input type="text" name="header_badge" class="field-input" maxlength="20"
                                        value="{{ old('header_badge') }}" placeholder="NEW">
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <!-- ── RIGHT column ── -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>SEO Settings</h5>
                            </div>

                            <div class="section-card-body">

                                <div class="field-group">
                                    <label class="field-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="field-input"
                                        value="{{ old('meta_title') }}" placeholder="Enter meta title">
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description" class="field-textarea" rows="4"
                                        placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                </div>

                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header">
                                <h5>Settings</h5>
                            </div>
                            <div class="section-card-body" style="padding:16px 20px">
                                <div class="toggle-row">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visibility on storefront</div>
                                    </div>
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Action bar -->
                <div class="action-bar">
                    <a href="{{ route('admin.collections.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Save Collection
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
    let manualSlug = false;

    $('#slug').on('keyup', function () {
        manualSlug = true;
    });

    $('#name').on('keyup', function () {
        if (!manualSlug) {
            let slug = $(this).val()
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
            $('#slug').val(slug);
        }
    });

    $('#collectionForm').on('submit', function () {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    });
</script>