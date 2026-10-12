@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    <style>
        .cke_notifications_area,
        .cke_notification,
        .cke_notification_warning {
            display: none !important;
        }

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
            --radius-sm: 8px;
            --radius-md: 12px;
            --shadow-card: 0 1px 3px rgba(0, 0, 0, .08), 0 0 0 1px var(--border);
            --font: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .page-create {
            background: var(--bg);
            padding: 24px 28px;
            min-height: 100vh;
            font-family: var(--font);
            color: var(--text-primary);
        }

        .page-create * {
            box-sizing: border-box;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .page-header h1 {
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

        /* Two-column layout */
        .create-layout {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 20px;
            align-items: start;
        }

        @media(max-width:960px) {
            .create-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Section card */
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
        }

        .section-card-body {
            padding: 20px;
        }

        /* Fields */
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

        .field-hint {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 4px;
        }

        .field-input,
        .field-select,
        .field-textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 0 12px;
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
        }

        .field-textarea {
            padding: 10px 12px;
            resize: vertical;
            min-height: 90px;
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        /* Two column grid inside card */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        @media(max-width:600px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }

        /* Status select small */
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
            min-width: 110px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%238c9196'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
            transition: border-color .15s;
        }

        .field-select-sm:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(48, 61, 137, .12);
        }

        /* Toggle row */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--bg);
        }

        .toggle-row:first-child {
            padding-top: 0;
        }

        .toggle-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .toggle-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .toggle-sub {
            font-size: 11.5px;
            color: var(--text-hint);
            margin-top: 1px;
        }

        /* CKEditor override */
        .cke {
            border-radius: var(--radius-sm) !important;
            border: 1px solid var(--border) !important;
            overflow: hidden;
        }

        .cke_top {
            background: #fafafa !important;
            border-bottom: 1px solid var(--border) !important;
        }

        /* Buttons */
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

        .btn-primary-dash:hover {
            background: #252f70;
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
            cursor: pointer;
            text-decoration: none !important;
            font-family: var(--font);
            transition: background .15s;
        }

        .btn-secondary-dash:hover {
            background: var(--bg);
        }

        /* Action bar */
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
            .page-create {
                padding: 16px;
            }
        }
                .field-error { color: var(--red); font-size: 11.5px; margin-top: 4px; }
        .alert-errors { background:#fdecea; border:1px solid #f5c2c0; color:var(--red);
            border-radius:var(--radius-sm); padding:10px 14px; font-size:13px; margin-bottom:16px; }
            
    </style>

    @php
        $isEdit = $page->exists;
        $effective = old('effective_date', $page->effective_date
            ? \Carbon\Carbon::parse($page->effective_date)->format('Y-m-d') : '');
    @endphp

    <div class="app-content content container-fluid">
        <div class="page-create">

            <div class="page-header">
                <div>
                    <h1>{{ $isEdit ? 'Edit' : 'Add' }} Dynamic Page</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.dynamic-pages.index') }}">Dynamic Pages</a><span>›</span>
                        {{ $isEdit ? 'Edit Page' : 'Add Page' }}
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert-errors">Please fix the errors below.</div>
            @endif

            <form method="POST"
                  action="{{ $isEdit ? route('admin.dynamic-pages.update', $page) : route('admin.dynamic-pages.store') }}">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="create-layout">

                    <!-- LEFT -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Page Details</h5></div>
                            <div class="section-card-body">

                                <div class="two-col" style="margin-bottom:16px">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Heading <span class="req">*</span></label>
                                        <input type="text" name="heading" class="field-input"
                                               value="{{ old('heading', $page->heading) }}" placeholder="e.g. About Us">
                                        @error('heading')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">URL Key (Slug)</label>
                                        <input type="text" name="slug" class="field-input"
                                               value="{{ old('slug', $page->slug) }}"
                                               placeholder="auto-generated from heading"
                                               {{ $isEdit && $page->is_system ? 'readonly' : '' }}>
                                        <div class="field-hint">
                                            @if ($isEdit && $page->is_system)
                                                Built-in page — URL key cannot be changed.
                                            @else
                                                Leave blank to generate from the heading.
                                            @endif
                                        </div>
                                        @error('slug')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="two-col" style="margin-bottom:16px">
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Badge Text</label>
                                        <input type="text" name="badge_text" class="field-input"
                                               value="{{ old('badge_text', $page->badge_text) }}" placeholder="e.g. Legal">
                                        @error('badge_text')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="field-group" style="margin:0">
                                        <label class="field-label">Date Label <span class="req">*</span></label>
                                        <select name="date_label" class="field-select">
                                            @foreach (\App\Models\DynamicPage::DATE_LABELS as $label)
                                                <option value="{{ $label }}"
                                                    {{ old('date_label', $page->date_label) === $label ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('date_label')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Effective Date</label>
                                    <input type="date" name="effective_date" class="field-input" value="{{ $effective }}">
                                    @error('effective_date')<div class="field-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="field-group">
                                    <label class="field-label">Page Content <span class="req">*</span></label>
                                    <textarea name="content" id="content" class="field-textarea editor"
                                              style="min-height:200px">{{ old('content', $page->content) }}</textarea>
                                    @error('content')<div class="field-error">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>SEO</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="field-input"
                                           value="{{ old('meta_title', $page->meta_title) }}"
                                           placeholder="Page title for search engines">
                                    @error('meta_title')<div class="field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description" class="field-textarea"
                                              placeholder="Brief description shown in search results (150–160 chars)">{{ old('meta_description', $page->meta_description) }}</textarea>
                                    @error('meta_description')<div class="field-error">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body" style="padding:14px 20px">
                                <div class="toggle-row" style="padding:0;border:none">
                                    <div>
                                        <div class="toggle-label">Status</div>
                                        <div class="toggle-sub">Visible to visitors</div>
                                    </div>
                                    {{-- 1 = active, 0 = hidden: controller uses $request->boolean('status') --}}
                                    <select name="status" class="field-select-sm">
                                        <option value="1" {{ old('status', $page->status ? '1' : '0') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $page->status ? '1' : '0') == '0' ? 'selected' : '' }}>Hidden</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.dynamic-pages.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" class="btn-primary-dash">
                        <i class="fa fa-save"></i> {{ $isEdit ? 'Update Page' : 'Save Page' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.config.versionCheck = false;
    CKEDITOR.replace('content');
</script>