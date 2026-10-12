@include('admin.top-header')

<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <style>
        .rep-item { border:1px solid #e3e5e8; border-radius:10px; padding:14px 14px 4px; margin-bottom:12px; background:#fafbfc; }
        .rep-grid { display:grid; gap:12px; align-items:end; }
        .rep-grid-stat   { grid-template-columns: 1fr 1.4fr 120px 90px 90px 40px; }
        .rep-grid-belief { grid-template-columns: 1.2fr 1fr 120px 90px 90px 40px; }
        .rep-desc { margin-top:2px; }
        .rep-check { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:500; height:38px; }
        .btn-rep-remove { width:36px; height:36px; border-radius:8px; border:1px solid #e3e5e8; background:#fff; color:#b22222; cursor:pointer; margin-bottom:14px; }
        .btn-rep-remove:hover { background:#fce8e8; }
        .btn-rep-add { display:inline-flex; align-items:center; gap:6px; border:1px dashed #303d89; background:#f0f1fc; color:#303d89; border-radius:8px; padding:8px 14px; font-size:13px; font-weight:600; cursor:pointer; }
        .btn-rep-add:hover { background:#e4e6fa; }
        .sub-title { font-size:12px; font-weight:700; color:#303d89; text-transform:uppercase; letter-spacing:.06em; margin:4px 0 14px; padding-bottom:6px; border-bottom:1px dashed #e3e5e8; }
        .img-prev { max-width:100%; max-height:160px; border-radius:8px; border:1px solid #e3e5e8; margin-top:10px; display:block; }
        .alert-ok  { background:#e3f1ec; color:#007a5e; border:1px solid #b9dccf; border-radius:8px; padding:10px 14px; font-size:13px; margin-bottom:16px; }
        .alert-err { background:#fce8e8; color:#b22222; border:1px solid #f5c0c0; border-radius:8px; padding:10px 14px; font-size:13px; margin-bottom:16px; }
        .alert-err ul { margin:0; padding-left:18px; }
        @media(max-width:992px) {
            .rep-grid-stat, .rep-grid-belief { grid-template-columns: 1fr 1fr; }
        }
    </style>

    @php
        // rows come from old input after a failed validation, otherwise from the database
        $statRows = old('stats', $stats->map->only(['id','value','label','color','sort_order','status'])->values()->all());
        $beliefRows = old('beliefs', $beliefs->map->only(['id','title','description','icon','color','sort_order','status'])->values()->all());
    @endphp

    <div class="app-content content container-fluid">
        <div class="home-page">

            <div class="page-header">
                <div>
                    <h1>About Us Page</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        About Us
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert-ok">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert-err"><ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form id="aboutForm" method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="edit-layout">

                    <!-- ================= LEFT: CONTENT ================= -->
                    <div>

                        <!-- HERO -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Hero</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Badge Text</label>
                                    <input type="text" name="hero_badge" class="field-input" value="{{ old('hero_badge', $about->hero_badge) }}">
                                    @error('hero_badge')<div class="field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Title (white line)</label>
                                    <input type="text" name="hero_title" class="field-input" value="{{ old('hero_title', $about->hero_title) }}">
                                    @error('hero_title')<div class="field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Title Highlight (yellow line)</label>
                                    <input type="text" name="hero_title_highlight" class="field-input" value="{{ old('hero_title_highlight', $about->hero_title_highlight) }}">
                                    @error('hero_title_highlight')<div class="field-error">{{ $message }}</div>@enderror
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="hero_description" rows="3" class="field-textarea">{{ old('hero_description', $about->hero_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- STORY -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Our Story</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Badge Text</label>
                                    <input type="text" name="story_badge" class="field-input" value="{{ old('story_badge', $about->story_badge) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Heading</label>
                                    <input type="text" name="story_heading" class="field-input" value="{{ old('story_heading', $about->story_heading) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Paragraph 1</label>
                                    <textarea name="story_paragraph_1" rows="3" class="field-textarea">{{ old('story_paragraph_1', $about->story_paragraph_1) }}</textarea>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Paragraph 2</label>
                                    <textarea name="story_paragraph_2" rows="3" class="field-textarea">{{ old('story_paragraph_2', $about->story_paragraph_2) }}</textarea>
                                </div>

                                <div class="sub-title" style="margin-top:20px">Story Stats</div>
                                <div id="statList">
                                    @foreach ($statRows as $i => $row)
                                        <div class="rep-item" data-row>
                                            <input type="hidden" name="stats[{{ $i }}][id]" value="{{ $row['id'] ?? '' }}">
                                            <div class="rep-grid rep-grid-stat">
                                                <div class="field-group">
                                                    <label class="field-label">Value *</label>
                                                    <input type="text" name="stats[{{ $i }}][value]" class="field-input" placeholder="100%" value="{{ $row['value'] ?? '' }}" required>
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Label *</label>
                                                    <input type="text" name="stats[{{ $i }}][label]" class="field-input" placeholder="Child-Safe Materials" value="{{ $row['label'] ?? '' }}" required>
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Color</label>
                                                    <select name="stats[{{ $i }}][color]" class="field-select">
                                                        @foreach (['navy','orange'] as $col)
                                                            <option value="{{ $col }}" {{ ($row['color'] ?? 'navy') === $col ? 'selected' : '' }}>{{ ucfirst($col) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Order</label>
                                                    <input type="number" min="0" name="stats[{{ $i }}][sort_order]" class="field-input" value="{{ $row['sort_order'] ?? ($i + 1) }}">
                                                </div>
                                                <div class="field-group">
                                                    <input type="hidden" name="stats[{{ $i }}][status]" value="0">
                                                    <label class="rep-check"><input type="checkbox" name="stats[{{ $i }}][status]" value="1" {{ (int) ($row['status'] ?? 1) ? 'checked' : '' }}> Active</label>
                                                </div>
                                                <button type="button" class="btn-rep-remove" title="Remove" data-remove><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn-rep-add" id="addStat"><i class="fa fa-plus"></i> Add Stat</button>
                            </div>
                        </div>

                        <!-- BELIEFS -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>What We Believe</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Badge Text</label>
                                    <input type="text" name="beliefs_badge" class="field-input" value="{{ old('beliefs_badge', $about->beliefs_badge) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Heading</label>
                                    <input type="text" name="beliefs_heading" class="field-input" value="{{ old('beliefs_heading', $about->beliefs_heading) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="beliefs_description" rows="2" class="field-textarea">{{ old('beliefs_description', $about->beliefs_description) }}</textarea>
                                </div>

                                <div class="sub-title" style="margin-top:20px">Cards</div>
                                <div id="beliefList">
                                    @foreach ($beliefRows as $i => $row)
                                        <div class="rep-item" data-row>
                                            <input type="hidden" name="beliefs[{{ $i }}][id]" value="{{ $row['id'] ?? '' }}">
                                            <div class="rep-grid rep-grid-belief">
                                                <div class="field-group">
                                                    <label class="field-label">Title *</label>
                                                    <input type="text" name="beliefs[{{ $i }}][title]" class="field-input" value="{{ $row['title'] ?? '' }}" required>
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Icon</label>
                                                    <input type="text" name="beliefs[{{ $i }}][icon]" class="field-input" placeholder="fa-shapes" value="{{ $row['icon'] ?? '' }}">
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Color</label>
                                                    <select name="beliefs[{{ $i }}][color]" class="field-select">
                                                        @foreach (['blue','orange','mint','yellow'] as $col)
                                                            <option value="{{ $col }}" {{ ($row['color'] ?? 'blue') === $col ? 'selected' : '' }}>{{ ucfirst($col) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="field-group">
                                                    <label class="field-label">Order</label>
                                                    <input type="number" min="0" name="beliefs[{{ $i }}][sort_order]" class="field-input" value="{{ $row['sort_order'] ?? ($i + 1) }}">
                                                </div>
                                                <div class="field-group">
                                                    <input type="hidden" name="beliefs[{{ $i }}][status]" value="0">
                                                    <label class="rep-check"><input type="checkbox" name="beliefs[{{ $i }}][status]" value="1" {{ (int) ($row['status'] ?? 1) ? 'checked' : '' }}> Active</label>
                                                </div>
                                                <button type="button" class="btn-rep-remove" title="Remove" data-remove><i class="fa fa-trash"></i></button>
                                            </div>
                                            <div class="field-group rep-desc">
                                                <label class="field-label">Description</label>
                                                <textarea name="beliefs[{{ $i }}][description]" rows="2" class="field-textarea">{{ $row['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn-rep-add" id="addBelief"><i class="fa fa-plus"></i> Add Card</button>
                                <div class="field-hint" style="margin-top:8px">Icon is a Font Awesome class, e.g. fa-atom. Removed rows are deleted when you click Update.</div>
                            </div>
                        </div>

                        <!-- PROMISE -->
                        <div class="section-card">
                            <div class="section-card-header"><h5>Our Promise</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Badge Text</label>
                                    <input type="text" name="promise_badge" class="field-input" value="{{ old('promise_badge', $about->promise_badge) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Heading</label>
                                    <input type="text" name="promise_heading" class="field-input" value="{{ old('promise_heading', $about->promise_heading) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Description</label>
                                    <textarea name="promise_description" rows="3" class="field-textarea">{{ old('promise_description', $about->promise_description) }}</textarea>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Button 1 Text</label>
                                    <input type="text" name="promise_btn1_text" class="field-input" value="{{ old('promise_btn1_text', $about->promise_btn1_text) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Button 1 URL</label>
                                    <input type="text" name="promise_btn1_url" class="field-input" placeholder="/shop" value="{{ old('promise_btn1_url', $about->promise_btn1_url) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Button 2 Text</label>
                                    <input type="text" name="promise_btn2_text" class="field-input" value="{{ old('promise_btn2_text', $about->promise_btn2_text) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Button 2 URL</label>
                                    <input type="text" name="promise_btn2_url" class="field-input" placeholder="/contact" value="{{ old('promise_btn2_url', $about->promise_btn2_url) }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ================= RIGHT: IMAGE + SEO ================= -->
                    <div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>Story Image</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Upload Image</label>
                                    <input type="file" name="story_image" id="story_image" class="field-input" accept="image/*">
                                    @error('story_image')<div class="field-error">{{ $message }}</div>@enderror
                                    <div class="field-hint">JPG / PNG / WEBP, max 3 MB. Leave empty to keep the current image.</div>
                                    <img id="storyPreview" src="{{ $about->story_image_url }}" class="img-prev" alt="" style="{{ $about->story_image_url ? '' : 'display:none' }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Image Alt Text</label>
                                    <input type="text" name="story_image_alt" class="field-input" value="{{ old('story_image_alt', $about->story_image_alt) }}">
                                </div>
                            </div>
                        </div>

                        <div class="section-card">
                            <div class="section-card-header"><h5>SEO</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Meta Title</label>
                                    <input type="text" name="meta_title" class="field-input" value="{{ old('meta_title', $about->meta_title) }}">
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Meta Description</label>
                                    <textarea name="meta_description" rows="4" class="field-textarea">{{ old('meta_description', $about->meta_description) }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- ============ ROW TEMPLATES (used by Add buttons) ============ -->
<template id="statTpl">
    <div class="rep-item" data-row>
        <input type="hidden" name="stats[__INDEX__][id]" value="">
        <div class="rep-grid rep-grid-stat">
            <div class="field-group">
                <label class="field-label">Value *</label>
                <input type="text" name="stats[__INDEX__][value]" class="field-input" placeholder="100%" required>
            </div>
            <div class="field-group">
                <label class="field-label">Label *</label>
                <input type="text" name="stats[__INDEX__][label]" class="field-input" placeholder="Child-Safe Materials" required>
            </div>
            <div class="field-group">
                <label class="field-label">Color</label>
                <select name="stats[__INDEX__][color]" class="field-select">
                    <option value="navy">Navy</option>
                    <option value="orange">Orange</option>
                </select>
            </div>
            <div class="field-group">
                <label class="field-label">Order</label>
                <input type="number" min="0" name="stats[__INDEX__][sort_order]" class="field-input" value="__ORDER__">
            </div>
            <div class="field-group">
                <input type="hidden" name="stats[__INDEX__][status]" value="0">
                <label class="rep-check"><input type="checkbox" name="stats[__INDEX__][status]" value="1" checked> Active</label>
            </div>
            <button type="button" class="btn-rep-remove" title="Remove" data-remove><i class="fa fa-trash"></i></button>
        </div>
    </div>
</template>

<template id="beliefTpl">
    <div class="rep-item" data-row>
        <input type="hidden" name="beliefs[__INDEX__][id]" value="">
        <div class="rep-grid rep-grid-belief">
            <div class="field-group">
                <label class="field-label">Title *</label>
                <input type="text" name="beliefs[__INDEX__][title]" class="field-input" required>
            </div>
            <div class="field-group">
                <label class="field-label">Icon</label>
                <input type="text" name="beliefs[__INDEX__][icon]" class="field-input" placeholder="fa-shapes">
            </div>
            <div class="field-group">
                <label class="field-label">Color</label>
                <select name="beliefs[__INDEX__][color]" class="field-select">
                    <option value="blue">Blue</option>
                    <option value="orange">Orange</option>
                    <option value="mint">Mint</option>
                    <option value="yellow">Yellow</option>
                </select>
            </div>
            <div class="field-group">
                <label class="field-label">Order</label>
                <input type="number" min="0" name="beliefs[__INDEX__][sort_order]" class="field-input" value="__ORDER__">
            </div>
            <div class="field-group">
                <input type="hidden" name="beliefs[__INDEX__][status]" value="0">
                <label class="rep-check"><input type="checkbox" name="beliefs[__INDEX__][status]" value="1" checked> Active</label>
            </div>
            <button type="button" class="btn-rep-remove" title="Remove" data-remove><i class="fa fa-trash"></i></button>
        </div>
        <div class="field-group rep-desc">
            <label class="field-label">Description</label>
            <textarea name="beliefs[__INDEX__][description]" rows="2" class="field-textarea"></textarea>
        </div>
    </div>
</template>

@include('admin.footer')

<script>
(function () {
    // next free index per list (so new rows never collide with existing ones)
    const counters = {
        statList:   {{ count($statRows) }},
        beliefList: {{ count($beliefRows) }}
    };

    function addRow(listId, tplId) {
        const list = document.getElementById(listId);
        const html = document.getElementById(tplId).innerHTML
            .replace(/__INDEX__/g, counters[listId]++)
            .replace(/__ORDER__/g, list.querySelectorAll('[data-row]').length + 1);
        list.insertAdjacentHTML('beforeend', html);
    }

    document.getElementById('addStat').addEventListener('click',   () => addRow('statList',   'statTpl'));
    document.getElementById('addBelief').addEventListener('click', () => addRow('beliefList', 'beliefTpl'));

    // remove row (deleted from DB when the form is saved)
    document.getElementById('aboutForm').addEventListener('click', function (e) {
        const btn = e.target.closest('[data-remove]');
        if (!btn) return;
        const row = btn.closest('[data-row]');
        if (row) row.remove();
    });

    // image preview
    document.getElementById('story_image').addEventListener('change', function () {
        const img = document.getElementById('storyPreview');
        if (this.files && this.files[0]) {
            img.src = URL.createObjectURL(this.files[0]);
            img.style.display = 'block';
        }
    });

    // disable the button while saving
    document.getElementById('aboutForm').addEventListener('submit', function () {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    });
})();
</script>