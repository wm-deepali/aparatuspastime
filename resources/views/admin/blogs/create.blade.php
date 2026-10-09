@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    @include('admin.blogs._styles')

    <div class="app-content content container-fluid">
        <div class="create-page">

            <div class="create-page-header">
                <div>
                    <h1>Add Blog</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.blogs.index') }}">Manage Blogs</a>
                        <span>›</span>
                        Add Blog
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert-err">
                    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form id="blogForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.blogs.store') }}">
                @csrf

                @include('admin.blogs._form')

                <div class="action-bar">
                    <a href="{{ route('admin.blogs.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Save Blog
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
// Slug auto-generate from title (create only)
let slugTouched = false;
document.getElementById('slug').addEventListener('input', () => slugTouched = true);
document.getElementById('title').addEventListener('keyup', function () {
    if (slugTouched) return;
    document.getElementById('slug').value = this.value
        .toLowerCase().trim()
        .replace(/[^\w\s-]+/g, '')
        .replace(/[\s_]+/g, '-')
        .replace(/-+/g, '-');
});

// Image previews (all upload boxes)
document.querySelectorAll('.img-input').forEach(input => {
    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const body = this.closest('.section-card-body, .field-group');
        const box = body.querySelector('.new-preview');
        const reader = new FileReader();
        reader.onload = e => {
            box.querySelector('img').src = e.target.result;
            box.querySelector('span').textContent = file.name;
            box.style.display = 'flex';
            const cur = body.querySelector('[data-current]');
            if (cur) cur.style.opacity = '.4';
        };
        reader.readAsDataURL(file);
    });
});

// Submit spinner
document.getElementById('blogForm').addEventListener('submit', function () {
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
});
</script>