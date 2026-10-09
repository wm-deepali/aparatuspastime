@include('admin.top-header')

<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="home-page">

            <div class="page-header">
                <div>
                    <h1>{{ $item->exists ? 'Edit' : 'Add' }} {{ $cfg['singular'] }}</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Home Page</a><span>›</span>
                        <a href="{{ route('admin.home.content.index', $type) }}">{{ $cfg['title'] }}</a><span>›</span>
                        {{ $item->exists ? 'Edit' : 'Add' }}
                    </div>
                </div>
            </div>

            <form id="contentForm" method="POST" enctype="multipart/form-data"
                action="{{ $item->exists
                    ? route('admin.home.content.update', [$type, $item->id])
                    : route('admin.home.content.store', $type) }}">
                @csrf
                @if ($item->exists) @method('PUT') @endif

                <div class="edit-layout">

                    <!-- LEFT: content fields -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>{{ $cfg['singular'] }} Details</h5></div>
                            <div class="section-card-body">
                                <div class="field-flex">

                                    @foreach ($cfg['fields'] as $f)
                                        @php
                                            $name  = $f['name'];
                                            $val   = old($name, $item->exists ? $item->{$name} : ($f['default'] ?? null));
                                            $isReq = str_contains($f['rules'] ?? '', 'required')
                                                || ($f['type'] === 'image' && !empty($f['required']) && !$item->exists);
                                        @endphp

                                        <div class="field-group {{ !empty($f['half']) ? 'fg-half' : 'fg-full' }}">
                                            <label class="field-label" for="{{ $name }}">
                                                {{ $f['label'] }} @if ($isReq)<span class="req">*</span>@endif
                                            </label>

                                            @if ($f['type'] === 'textarea')
                                                <textarea name="{{ $name }}" id="{{ $name }}" rows="4" class="field-textarea">{{ $val }}</textarea>

                                            @elseif ($f['type'] === 'select')
                                                @php $opts = is_array($f['options']) ? $f['options'] : config('home_content.' . $f['options']); @endphp
                                                <select name="{{ $name }}" id="{{ $name }}" class="field-select">
                                                    @foreach ($opts as $k => $label)
                                                        <option value="{{ $k }}" {{ (string) $val === (string) $k ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>

                                            @elseif ($f['type'] === 'category')
                                                <select name="{{ $name }}" id="{{ $name }}" class="field-select">
                                                    <option value="">— None (use custom link) —</option>
                                                    @foreach ($categories as $c)
                                                        <option value="{{ $c->id }}" {{ (string) $val === (string) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                                    @endforeach
                                                </select>

                                            @elseif ($f['type'] === 'image')
                                                @if ($item->exists && $item->{$name})
                                                    <img src="{{ asset('storage/' . $item->{$name}) }}" class="img-preview" alt="">
                                                @endif
                                                <input type="file" name="{{ $name }}" id="{{ $name }}" accept="image/*" class="field-input" style="padding-top:7px">

                                            @elseif ($f['type'] === 'switch')
                                                <input type="hidden" name="{{ $name }}" value="0">
                                                <label class="switch-line">
                                                    <input type="checkbox" name="{{ $name }}" value="1" {{ $val ? 'checked' : '' }}> Yes
                                                </label>

                                            @else
                                                <input type="{{ $f['type'] === 'number' ? 'number' : 'text' }}"
                                                    name="{{ $name }}" id="{{ $name }}" value="{{ $val }}" class="field-input">
                                            @endif

                                            @error($name)<div class="field-error">{{ $message }}</div>@enderror
                                            @if (!empty($f['hint']))<div class="field-hint">{{ $f['hint'] }}</div>@endif
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: settings -->
                    <div>
                        <div class="section-card">
                            <div class="section-card-header"><h5>Settings</h5></div>
                            <div class="section-card-body">
                                <div class="field-group">
                                    <label class="field-label">Status</label>
                                    <select name="status" class="field-select">
                                        <option value="1" {{ (string) old('status', $item->exists ? (int) $item->status : 1) === '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (string) old('status', $item->exists ? (int) $item->status : 1) === '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <div class="field-hint">Inactive items are hidden on the storefront.</div>
                                </div>
                                <div class="field-group">
                                    <label class="field-label">Sort Order</label>
                                    <input type="number" name="sort_order" min="0" class="field-input" style="max-width:120px"
                                        value="{{ old('sort_order', $item->sort_order ?? 0) }}">
                                    <div class="field-hint">Lower numbers appear first.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="action-bar">
                    <a href="{{ route('admin.home.content.index', $type) }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> {{ $item->exists ? 'Update' : 'Save' }} {{ $cfg['singular'] }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
document.getElementById('contentForm').addEventListener('submit', function () {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
});
</script>