@include('admin.top-header')

<div class="main-section">
    @include('admin.header')

    @include('admin.blogs._styles')

    <div class="app-content content container-fluid">
        <div class="create-page">

            <div class="create-page-header">
                <div>
                    <h1>Edit Blog</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <span>›</span>
                        <a href="{{ route('admin.blogs.index') }}">Manage Blogs</a>
                        <span>›</span>
                        Edit Blog
                    </div>
                </div>

                <div class="blog-identity">
                    @if ($blog->image_url)
                        <img src="{{ $blog->image_url }}" class="blog-identity-thumb" alt="{{ $blog->title }}">
                    @else
                        <div class="blog-identity-icon"><i class="fa fa-pen-to-square"></i></div>
                    @endif
                    <div>
                        <div class="blog-identity-title">{{ $blog->title }}</div>
                        <div class="blog-identity-id">
                            ID #{{ $blog->id }} &middot;
                            @if ($blog->status)
                                <span class="pill pill-active">Active</span>
                            @else
                                <span class="pill pill-inactive">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert-err">
                    <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form id="blogForm" method="POST" enctype="multipart/form-data"
                  action="{{ route('admin.blogs.update', $blog->id) }}">
                @csrf
                @method('PUT')

                @include('admin.blogs._form')

                <div class="action-bar">
                    <a href="{{ route('admin.blogs.index') }}" class="btn-secondary-dash">Cancel</a>
                    <button type="submit" id="saveBtn" class="btn-primary-dash">
                        <i class="fa fa-save"></i> Update Blog
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
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
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Updating...';
});
</script>