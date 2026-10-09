@include('admin.top-header')

<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="home-page">

            <div class="page-header">
                <div>
                    <h1>{{ $cfg['title'] }}</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Home Page</a><span>›</span>
                        <a href="{{ route('admin.home.sections.index') }}">Section Headings</a><span>›</span>
                        Edit
                    </div>
                </div>
            </div>

            <form id="sectionForm" method="POST" action="{{ route('admin.home.sections.update', $key) }}">
                @csrf
                @method('PUT')

                <div class="edit-layout">

                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Content</h5></div>
                            <div class="section-card-body">

                                @foreach ($cfg['fields'] as $fieldKey)
                                    @php
                                        $f   = config("home_content.section_fields.$fieldKey");
                                        $val = str_starts_with($fieldKey, 'extra_')
                                            ? ($section->extra[substr($fieldKey, 6)] ?? '')
                                            : $section->{$fieldKey};
                                        $val = old($fieldKey, $val);
                                    @endphp

                                    <div class="field-group">
                                        <label class="field-label" for="{{ $fieldKey }}">
                                            {{ $f['label'] }}
                                            @if (str_contains($f['rules'], 'required'))<span class="req">*</span>@endif
                                        </label>

                                        @if ($f['type'] === 'textarea')
                                            <textarea name="{{ $fieldKey }}" id="{{ $fieldKey }}" rows="4" class="field-textarea">{{ $val }}</textarea>
                                        @else
                                            <input type="text" name="{{ $fieldKey }}" id="{{ $fieldKey }}" value="{{ $val }}" class="field-input">
                                        @endif

                                        @error($fieldKey)<div class="field-error">{{ $message }}</div>@enderror
                                        @if (!empty($f['hint']))<div class="field-hint">{{ $f['hint'] }}</div>@endif
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Visibility</label>
                                    <select name="status" class="field-select">
                                        <option value="1" {{ (string) old('status', (int) $section->status) === '1' ? 'selected' : '' }}>Visible</option>
                                        <option value="0" {{ (string) old('status', (int) $section->status) === '0' ? 'selected' : '' }}>Hidden</option>
                                    </select>
                                    <div class="field-hint">Hidden sections are not shown on the home page.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home.sections.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
document.getElementById('sectionForm').addEventListener('submit', function () {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
});
</script>