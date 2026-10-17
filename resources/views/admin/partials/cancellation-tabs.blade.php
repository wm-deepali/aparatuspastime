@php $current = request()->route()->getName(); @endphp
<style>
    .cx-tabs{display:flex;gap:4px;flex-wrap:wrap;margin-bottom:16px;border-bottom:1px solid #e3e5e8}
    .cx-tab{padding:10px 16px;font-size:13px;font-weight:600;color:#6d7175;text-decoration:none;border-bottom:2px solid transparent;margin-bottom:-1px}
    .cx-tab:hover{color:#303d89}
    .cx-tab.active{color:#303d89;border-bottom-color:#303d89}
</style>
<div class="cx-tabs">
    <a class="cx-tab {{ $current === 'admin.orders.index' && request('tab') === 'cancelled' ? 'active' : '' }}"
       href="{{ route('admin.orders.index', ['tab' => 'cancelled']) }}">Cancelled Orders</a>
    <a class="cx-tab {{ $current === 'admin.cancelled-refunds.index' ? 'active' : '' }}"
       href="{{ route('admin.cancelled-refunds.index') }}">Pending Refunds</a>
    <a class="cx-tab {{ $current === 'admin.cancelled-invoices.index' ? 'active' : '' }}"
       href="{{ route('admin.cancelled-invoices.index') }}">Cancelled Invoices</a>
    <a class="cx-tab {{ $current === 'admin.refunds.index' ? 'active' : '' }}"
       href="{{ route('admin.refunds.index') }}">Refund History</a>
</div>