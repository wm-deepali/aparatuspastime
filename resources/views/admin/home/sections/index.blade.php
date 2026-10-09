@include('admin.top-header')

<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <div class="app-content content container-fluid">
        <div class="home-page">

            <div class="page-header">
                <div>
                    <h1>Section Headings & Promo Banner</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>
                        <a href="{{ route('admin.home-page.index') }}">Home Page</a><span>›</span>
                        Section Headings
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="flash-ok">{{ session('success') }}</div>
            @endif

            <div class="cat-card">
                <div class="cat-table-wrap">
                    <table class="cat-table">
                        <thead>
                            <tr>
                                <th>Section</th>
                                <th>Current Heading</th>
                                <th>Status</th>
                                <th style="width:80px">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sections as $key => $cfg)
                                @php
                                    $row     = $rows[$key] ?? null;
                                    $heading = $row?->title ?? ($cfg['defaults']['title'] ?? '—');
                                    $active  = $row ? $row->status : true;
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $cfg['title'] }}</strong>
                                        <div style="font-size:12px;color:var(--text-hint)">{{ $cfg['description'] }}</div>
                                    </td>
                                    <td>{{ $heading }}</td>
                                    <td>
                                        <span class="pill {{ $active ? 'pill-active' : 'pill-inactive' }}">
                                            {{ $active ? 'Visible' : 'Hidden' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.home.sections.edit', $key) }}" class="action-btn" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.footer')