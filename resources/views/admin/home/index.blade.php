@include('admin.top-header')

<div class="main-section">
    @include('admin.header')
    @include('admin.home._styles')

    <style>
    .info-banner{background:var(--accent-light);border:1px solid #c7cdf5;border-radius:var(--radius-md);padding:12px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:13px;color:var(--accent);font-weight:500}
    .widget-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
    @media(max-width:960px){.widget-grid{grid-template-columns:repeat(2,1fr)}}
    @media(max-width:580px){.widget-grid{grid-template-columns:1fr}}
    .widget-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-md);box-shadow:var(--shadow-card);padding:20px;display:flex;flex-direction:column;gap:14px;transition:box-shadow .15s,transform .15s}
    .widget-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.1),0 0 0 1px var(--border);transform:translateY(-2px)}
    .widget-icon{width:44px;height:44px;border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
    .wi-blue{background:var(--blue-bg);color:var(--blue)}.wi-green{background:var(--green-bg);color:var(--green)}
    .wi-purple{background:var(--purple-bg);color:var(--purple)}.wi-amber{background:var(--amber-bg);color:var(--amber)}
    .wi-accent{background:var(--accent-light);color:var(--accent)}
    .widget-head{display:flex;align-items:flex-start;gap:12px}
    .widget-num{width:22px;height:22px;border-radius:50%;background:var(--bg);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:var(--text-hint);flex-shrink:0}
    .widget-title{font-size:13.5px;font-weight:650;line-height:1.3}
    .type-badge{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;padding:2px 8px;border-radius:20px;margin-top:4px}
    .tb-multiple{background:var(--blue-bg);color:var(--blue)}.tb-fixed{background:var(--accent-light);color:var(--accent)}
    .widget-actions{display:flex;gap:7px;flex-wrap:wrap;margin-top:auto}
    .widget-actions a{flex:1;justify-content:center;padding:7px 13px;font-size:12.5px}
    </style>

    <div class="app-content content container-fluid">
        <div class="home-page">

            <div class="page-header">
                <div>
                    <h1>Home Page Widgets</h1>
                    <div class="crumb">
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a><span>›</span>Manage Home Page
                    </div>
                </div>
            </div>

            <div class="info-banner">
                <i class="fa fa-info-circle"></i>
                Manage all homepage sections from here — click <strong>Manage</strong> on any widget to edit its content.
            </div>

            <div class="widget-grid">

                @foreach ($widgets as $w)
                    <div class="widget-card">
                        <div class="widget-head">
                            <div class="widget-icon {{ $w['tone'] }}"><i class="fa {{ $w['icon'] }}"></i></div>
                            <div>
                                <div style="display:flex;align-items:center;gap:8px">
                                    <span class="widget-num">{{ $loop->iteration }}</span>
                                    <span class="widget-title">{{ $w['title'] }}</span>
                                </div>
                                <span class="type-badge tb-multiple">
                                    <i class="fa fa-th-large"></i> Multiple · {{ $w['count'] }}
                                </span>
                            </div>
                        </div>
                        <div style="font-size:12px;color:var(--text-hint)">{{ $w['description'] }}</div>
                        <div class="widget-actions">
                            <a href="{{ $w['manage'] }}" class="btn-primary-dash"><i class="fa fa-pencil"></i> Manage</a>
                            <a href="{{ $w['create'] }}" class="btn-secondary-dash"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                    </div>
                @endforeach

                <div class="widget-card">
                    <div class="widget-head">
                        <div class="widget-icon wi-purple"><i class="fa fa-header"></i></div>
                        <div>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="widget-num">{{ $widgets->count() + 1 }}</span>
                                <span class="widget-title">Section Headings & Promo Banner</span>
                            </div>
                            <span class="type-badge tb-fixed"><i class="fa fa-lock"></i> Fixed</span>
                        </div>
                    </div>
                    <div style="font-size:12px;color:var(--text-hint)">Heading, sub text and buttons of each section, plus the promotional banner.</div>
                    <div class="widget-actions">
                        <a href="{{ route('admin.home.sections.index') }}" class="btn-primary-dash"><i class="fa fa-pencil"></i> Manage</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('admin.footer')