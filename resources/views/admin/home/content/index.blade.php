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
                        {{ $cfg['title'] }}
                    </div>
                </div>
                <a href="{{ route('admin.home.content.create', $type) }}" class="btn-primary-dash">
                    <i class="fa fa-plus"></i> Add {{ $cfg['singular'] }}
                </a>
            </div>

            @if (session('success'))
                <div class="flash-ok">{{ session('success') }}</div>
            @endif

            <div class="cat-card">
                <div class="cat-table-wrap">
                    <table class="cat-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                @foreach ($cfg['columns'] as $col)
                                    <th>{{ $col['label'] }}</th>
                                @endforeach
                                <th>Order</th>
                                <th>Status</th>
                                <th style="width:110px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                                <tr id="row{{ $item->id }}">
                                    <td><span class="id-chip">{{ $item->id }}</span></td>

                                    @foreach ($cfg['columns'] as $col)
                                        <td>
                                            @if (($col['type'] ?? 'text') === 'image')
                                                <img src="{{ asset('storage/' . $item->{$col['field']}) }}" class="thumb" alt="">
                                            @else
                                                {{ \Illuminate\Support\Str::limit((string) $item->{$col['field']}, 60) }}
                                            @endif
                                        </td>
                                    @endforeach

                                    <td><strong>{{ $item->sort_order }}</strong></td>
                                    <td>
                                        @if ($item->status)
                                            <span class="pill pill-active">Active</span>
                                        @else
                                            <span class="pill pill-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:6px">
                                            <a href="{{ route('admin.home.content.edit', [$type, $item->id]) }}" class="action-btn" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button class="action-btn action-btn-danger" onclick="deleteItem({{ $item->id }})" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($cfg['columns']) + 4 }}">
                                        <div class="empty-state">
                                            <strong style="font-size:14px">No {{ strtolower($cfg['title']) }} yet</strong>
                                            <p>Add your first {{ strtolower($cfg['singular']) }} to show it on the home page.</p>
                                            <a href="{{ route('admin.home.content.create', $type) }}" class="btn-primary-dash">
                                                <i class="fa fa-plus"></i> Add {{ $cfg['singular'] }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="cat-pagination">
                    {{ $items->links('pagination::bootstrap-4') }}
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')

<script>
const destroyUrl = "{{ route('admin.home.content.destroy', ['type' => $type, 'id' => '__ID__']) }}";

function deleteItem(id) {
    Swal.fire({
        title: 'Delete {{ $cfg['singular'] }}?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b22222',
        cancelButtonColor: '#6d7175',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (!result.isConfirmed) return;

        $.ajax({
            url: destroyUrl.replace('__ID__', id),
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            beforeSend: function () { Swal.showLoading(); },
            success: function (res) {
                Swal.fire('Deleted!', res.message, 'success');
                $('#row' + id).fadeOut(300, function () { $(this).remove(); });
            },
            error: function (xhr) {
                Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
            }
        });
    });
}
</script>