@extends('admin.layouts.app')
@section('title', 'Sales Report')

@section('content')
<style>
:root {
    --p1: #1B3A6B;
    --p2: #2563eb;
    --p3: #eff6ff;
    --ink: #1a1a2e;
    --muted: #6b7280;
    --border: #e5e7eb;
    --green: #059669;
    --red: #dc2626;
    --amber: #d97706;
}

.rp-page { background: #f3f4f6; min-height: 100vh; padding: 28px 0; }
.rp-wrap { max-width: 1280px; margin: 0 auto; padding: 0 16px; }

/* Header */
.rp-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 12px; }
.rp-title { font-size: 21px; font-weight: 800; color: var(--ink); display: flex; align-items: center; gap: 10px; }
.rp-title-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--p1); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 15px; }
.rp-subtitle { font-size: 12.5px; color: var(--muted); margin-top: 2px; }
.rp-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.rp-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; border: none; cursor: pointer; text-decoration: none; transition: .15s; }
.rp-btn-print { background: var(--p1); color: #fff; }
.rp-btn-print:hover { opacity: .9; color: #fff; }
.rp-btn-export { background: var(--green); color: #fff; }
.rp-btn-export:hover { opacity: .9; color: #fff; }

/* KPI Cards */
.rp-kpis { display: grid; grid-template-columns: repeat(5, 1fr); gap: 14px; margin-bottom: 22px; }
@media (max-width: 1100px) { .rp-kpis { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 650px) { .rp-kpis { grid-template-columns: repeat(2, 1fr); } }
.rp-kpi { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 16px; display: flex; flex-direction: column; gap: 10px; box-shadow: 0 1px 6px rgba(0,0,0,.04); }
.rp-kpi-top { display: flex; align-items: center; gap: 10px; }
.rp-kpi-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 15px; color: #fff; flex-shrink: 0; }
.rp-kpi-icon.blue { background: linear-gradient(135deg, #2563eb, #1B3A6B); }
.rp-kpi-icon.green { background: linear-gradient(135deg, #10b981, #059669); }
.rp-kpi-icon.red { background: linear-gradient(135deg, #f87171, #dc2626); }
.rp-kpi-icon.purple { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
.rp-kpi-icon.amber { background: linear-gradient(135deg, #f59e0b, #d97706); }
.rp-kpi-label { font-size: 10.5px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
.rp-kpi-val { font-size: 18px; font-weight: 800; color: var(--ink); }
.rp-kpi-sub { font-size: 11px; color: var(--muted); }

/* Top Product Banner */
.rp-top-product { background: linear-gradient(135deg, var(--p1), #0f2547); border-radius: 14px; padding: 18px 22px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; }
.rp-top-product-left { display: flex; align-items: center; gap: 14px; }
.rp-top-product-icon { width: 44px; height: 44px; border-radius: 12px; background: rgba(255,255,255,.15); display: flex; align-items: center; justify-content: center; color: #fbbf24; font-size: 20px; }
.rp-top-product-label { color: rgba(255,255,255,.6); font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 3px; }
.rp-top-product-name { color: #fff; font-size: 15.5px; font-weight: 700; }
.rp-top-product-stats { display: flex; gap: 26px; }
.rp-top-product-stats div { text-align: center; }
.rp-top-product-stats .lbl { color: rgba(255,255,255,.55); font-size: 10px; text-transform: uppercase; margin-bottom: 3px; }
.rp-top-product-stats .val { color: #fff; font-size: 16px; font-weight: 800; }

/* Filter card */
.rp-filter-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 6px rgba(0,0,0,.04); }
.rp-filter-title { font-size: 12px; font-weight: 700; color: var(--p1); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 14px; display: flex; align-items: center; gap: 7px; }
.rp-flabel { display: block; font-size: 11px; font-weight: 700; color: var(--muted); margin-bottom: 5px; text-transform: uppercase; letter-spacing: .03em; }
.rp-finput { width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 9px 12px; font-size: 13.5px; outline: none; transition: .15s; }
.rp-finput:focus { border-color: var(--p2); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
.rp-fbtn-apply { background: var(--p1); color: #fff; border: none; border-radius: 8px; padding: 10px 22px; font-size: 13px; font-weight: 700; cursor: pointer; }
.rp-fbtn-reset { background: #f3f4f6; color: var(--ink); border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 22px; font-size: 13px; font-weight: 700; text-decoration: none; }

/* Card generic */
.rp-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,.04); margin-bottom: 20px; }
.rp-card-head { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
.rp-card-title { font-size: 13.5px; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 8px; }
.rp-count-badge { background: var(--p3); color: var(--p1); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

/* Tables */
table.rp-table { width: 100%; border-collapse: collapse; }
table.rp-table thead th { background: #f9fafb; color: var(--muted); font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; padding: 11px 16px; text-align: left; border-bottom: 1px solid var(--border); }
table.rp-table thead th.num { text-align: right; }
table.rp-table thead th.center { text-align: center; }
table.rp-table tbody tr { border-top: 1px solid #f3f4f6; transition: background .1s; }
table.rp-table tbody tr:hover { background: #fafbfc; }
table.rp-table tbody td { padding: 12px 16px; font-size: 13px; color: var(--ink); }
table.rp-table tbody td.num { text-align: right; font-family: 'Courier New', monospace; }
table.rp-table tbody td.center { text-align: center; }
.rp-invoice-link { color: var(--p1); font-weight: 700; text-decoration: none; font-size: 12.5px; }
.rp-invoice-link:hover { text-decoration: underline; color: var(--p1); }
.rp-cust-name { font-weight: 600; font-size: 13px; }
.rp-cust-phone { color: var(--muted); font-size: 11px; }
.rp-qty-badge { background: #f3f4f6; border: 1px solid var(--border); padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; }
.rp-profit { color: var(--p1); font-weight: 700; }
.rp-cost { color: var(--red); }
.rp-rev { color: var(--green); font-weight: 600; }
.rp-orders-badge { background: #eef2f7; color: var(--p1); border: 1px solid #dbe4f0; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; }

table.rp-table tfoot td { padding: 12px 16px; font-size: 12.5px; font-weight: 700; background: #f9fafb; border-top: 1px solid var(--border); }
table.rp-table tfoot tr.rp-grand-row td {
    background: linear-gradient(135deg, var(--p1), #0f2547) !important;
    color: #fff !important;
    padding: 16px !important;
    border-top: none !important;
    font-size: 13.5px;
}
table.rp-table tfoot tr.rp-grand-row td.num { font-family: 'Courier New', monospace; }

.rp-empty { text-align: center; padding: 60px 20px; color: #d1d5db; }
.rp-empty i { font-size: 42px; margin-bottom: 12px; display: block; }
.rp-pagination-wrap { padding: 14px 20px; }

@media print {
    .no-print { display: none !important; }
}
</style>

<div class="rp-page">
<div class="rp-wrap">

    {{-- Header --}}
    <div class="rp-header no-print">
        <div>
            <div class="rp-title">
                <span class="rp-title-icon"><i class="fas fa-chart-line"></i></span>
                Sales Report
            </div>
            <div class="rp-subtitle">Completed orders — full sales & profit breakdown</div>
        </div>
        <div class="rp-actions">
            <button onclick="openPrintWindow()" class="rp-btn rp-btn-print">
                <i class="fas fa-print"></i> Print Report
            </button>
            <button id="export-excel-button" class="rp-btn rp-btn-export">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="rp-kpis">
        <div class="rp-kpi">
            <div class="rp-kpi-top">
                <div class="rp-kpi-icon blue"><i class="fas fa-receipt"></i></div>
                <div class="rp-kpi-label">Total Orders</div>
            </div>
            <div class="rp-kpi-val">{{ number_format($total_orders ?? 0) }}</div>
        </div>
        <div class="rp-kpi">
            <div class="rp-kpi-top">
                <div class="rp-kpi-icon purple"><i class="fas fa-cubes"></i></div>
                <div class="rp-kpi-label">Items Sold</div>
            </div>
            <div class="rp-kpi-val">{{ number_format($total_item) }}</div>
        </div>
        <div class="rp-kpi">
            <div class="rp-kpi-top">
                <div class="rp-kpi-icon green"><i class="fas fa-sack-dollar"></i></div>
                <div class="rp-kpi-label">Total Revenue</div>
            </div>
            <div class="rp-kpi-val">৳{{ number_format($total_sales, 2) }}</div>
        </div>
        <div class="rp-kpi">
            <div class="rp-kpi-top">
                <div class="rp-kpi-icon red"><i class="fas fa-money-bill-wave"></i></div>
                <div class="rp-kpi-label">Total Cost</div>
            </div>
            <div class="rp-kpi-val">৳{{ number_format($total_purchase, 2) }}</div>
        </div>
        <div class="rp-kpi">
            <div class="rp-kpi-top">
                <div class="rp-kpi-icon amber"><i class="fas fa-chart-pie"></i></div>
                <div class="rp-kpi-label">Net Profit</div>
            </div>
            <div class="rp-kpi-val">৳{{ number_format($total_sales - $total_purchase, 2) }}</div>
            <div class="rp-kpi-sub">Avg order: ৳{{ number_format($avg_order_value ?? 0, 2) }}</div>
        </div>
    </div>

    {{-- Top Product Banner --}}
    @if(!empty($topProduct))
    <div class="rp-top-product">
        <div class="rp-top-product-left">
            <div class="rp-top-product-icon"><i class="fas fa-trophy"></i></div>
            <div>
                <div class="rp-top-product-label">Best Selling Product</div>
                <div class="rp-top-product-name">{{ $topProduct['name'] }}</div>
            </div>
        </div>
        <div class="rp-top-product-stats">
            <div>
                <div class="lbl">Units Sold</div>
                <div class="val">{{ number_format($topProduct['qty']) }}</div>
            </div>
            <div>
                <div class="lbl">Revenue</div>
                <div class="val">৳{{ number_format($topProduct['revenue'], 2) }}</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Filter --}}
    <div class="rp-filter-card no-print">
        <div class="rp-filter-title"><i class="fas fa-filter"></i> Filter Report</div>
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="rp-flabel">Order / Invoice</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="rp-finput" placeholder="Search invoice...">
                </div>
                <div class="col-md-3">
                    <label class="rp-flabel">Product</label>
                    <select name="product_id" class="rp-finput">
                        <option value="">All Products</option>
                        @foreach($products as $p)
                        <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="rp-flabel">Customer</label>
                    <select name="user_id" class="rp-finput">
                        <option value="">All Customers</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1_5" style="flex:1;">
                    <label class="rp-flabel">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="rp-finput">
                </div>
                <div class="col-md-1_5" style="flex:1;">
                    <label class="rp-flabel">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="rp-finput">
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('admin.order_report') }}" class="rp-fbtn-reset">Reset</a>
                <button class="rp-fbtn-apply"><i class="fas fa-search me-1"></i> Apply Filter</button>
            </div>
        </form>
    </div>

    {{-- Daily Summary --}}
    @if($dailySummary->count() > 0)
    <div class="rp-card no-print">
        <div class="rp-card-head">
            <span class="rp-card-title"><i class="fas fa-calendar-alt" style="color:var(--p1);"></i> Daily Breakdown</span>
            <span class="rp-count-badge">{{ $dailySummary->count() }} days</span>
        </div>
        <div class="table-responsive">
            <table class="rp-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="center">Orders</th>
                        <th class="center">Qty Sold</th>
                        <th class="num">Revenue</th>
                        <th class="num">Cost</th>
                        <th class="num">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailySummary as $day)
                    <tr>
                        <td style="font-weight:600;">{{ \Carbon\Carbon::parse($day['date'])->format('d M Y') }}</td>
                        <td class="center"><span class="rp-orders-badge">{{ $day['orders'] }}</span></td>
                        <td class="center">{{ number_format($day['qty']) }}</td>
                        <td class="num rp-rev">৳{{ number_format($day['revenue'], 2) }}</td>
                        <td class="num rp-cost">৳{{ number_format($day['purchase'], 2) }}</td>
                        <td class="num rp-profit">৳{{ number_format($day['revenue'] - $day['purchase'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Order Items Table --}}
    <div class="rp-card">
        <div class="rp-card-head">
            <span class="rp-card-title"><i class="fas fa-list-ul" style="color:var(--p1);"></i> Order Details</span>
            <div class="d-flex align-items-center gap-2">
                <span class="rp-count-badge">{{ $orders->total() }} items</span>
                <div class="no-print">
                    {{ $orders->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
                </div>
            </div>
        </div>

        @if($orders->isEmpty())
        <div class="rp-empty">
            <i class="fas fa-inbox"></i>
            <p class="mb-0">No records found for this filter.</p>
        </div>
        @else
        <div id="content-to-export" class="table-responsive">
            <table class="rp-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th class="center">Qty</th>
                        <th class="num">Unit Price</th>
                        <th class="num">Purchase</th>
                        <th class="num">Total Sale</th>
                        <th class="num">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    @php
                        $unitSale     = $order->price ?? 0;
                        $unitPurchase = $order->product->purchase_price ?? 0;
                        $rowSale      = $unitSale     * $order->quantity;
                        $rowPurchase  = $unitPurchase * $order->quantity;
                        $rowProfit    = $rowSale - $rowPurchase;
                    @endphp
                    <tr>
                        <td class="text-muted" style="font-size:12px;">
                            {{ optional($order->order?->created_at)->format('d M Y') ?? '—' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->order_id) }}" class="rp-invoice-link">
                                #{{ $order->order->order_id ?? '—' }}
                            </a>
                        </td>
                        <td>
                            <div class="rp-cust-name">{{ $order->order->user->name ?? '—' }}</div>
                            <div class="rp-cust-phone">{{ $order->order->user->phone ?? '' }}</div>
                        </td>
                        <td style="font-weight:600; font-size:12.5px;">{{ $order->product->name ?? '—' }}</td>
                        <td class="center"><span class="rp-qty-badge">{{ $order->quantity }}</span></td>
                        <td class="num">৳{{ number_format($unitSale, 2) }}</td>
                        <td class="num rp-cost">৳{{ number_format($unitPurchase, 2) }}</td>
                        <td class="num rp-rev">৳{{ number_format($rowSale, 2) }}</td>
                        <td class="num rp-profit">৳{{ number_format($rowProfit, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;">Page Total:</td>
                        <td class="center">{{ $orders->sum('quantity') }}</td>
                        <td></td>
                        <td class="num rp-cost">
                            ৳{{ number_format($orders->sum(fn($i) => ($i->product->purchase_price ?? 0) * $i->quantity), 2) }}
                        </td>
                        <td class="num rp-rev">
                            ৳{{ number_format($orders->sum(fn($i) => ($i->price ?? 0) * $i->quantity), 2) }}
                        </td>
                        <td class="num rp-profit">
                            ৳{{ number_format(
                                $orders->sum(fn($i) => ($i->price ?? 0) * $i->quantity) -
                                $orders->sum(fn($i) => ($i->product->purchase_price ?? 0) * $i->quantity), 2) }}
                        </td>
                    </tr>
                    <tr class="rp-grand-row">
                        <td colspan="6" style="text-align:right;">Grand Total (All Pages):</td>
                        <td class="num">৳{{ number_format($total_purchase, 2) }}</td>
                        <td class="num">৳{{ number_format($total_sales, 2) }}</td>
                        <td class="num">৳{{ number_format($total_sales - $total_purchase, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="rp-pagination-wrap no-print">
            {{ $orders->appends(request()->query())->links('vendor.pagination.custom-tailwind') }}
        </div>
        @endif
    </div>

</div>{{-- /rp-wrap --}}
</div>{{-- /rp-page --}}

{{-- ✅ Print template — নতুন window-এ খোলে, admin UI একদমই আসবে না --}}
<template id="printTemplate">
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Sales Report</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
            body { padding: 30px; color: #111; }
            .p-header { text-align: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #1B3A6B; }
            .p-header h1 { font-size: 20px; color: #1B3A6B; margin-bottom: 4px; }
            .p-header p { font-size: 11px; color: #666; }
            .p-filters { font-size: 10.5px; color: #888; text-align: center; margin-bottom: 16px; }
            .p-summary { display: flex; justify-content: space-around; margin-bottom: 18px; background: #f9fafb; border: 1px solid #ddd; border-radius: 8px; padding: 14px; flex-wrap: wrap; gap: 10px; }
            .p-summary div { text-align: center; min-width: 90px; }
            .p-summary .lbl { font-size: 9.5px; color: #666; text-transform: uppercase; margin-bottom: 4px; }
            .p-summary .val { font-size: 14px; font-weight: 700; color: #1B3A6B; }
            .p-top { background: #1B3A6B; color: #fff; border-radius: 8px; padding: 10px 16px; margin-bottom: 18px; font-size: 12px; display: flex; justify-content: space-between; align-items: center; }
            table { width: 100%; border-collapse: collapse; font-size: 10.5px; margin-bottom: 20px; }
            th { background: #1B3A6B; color: #fff; padding: 7px 8px; text-align: left; }
            th.num, td.num { text-align: right; }
            th.center, td.center { text-align: center; }
            td { padding: 6px 8px; border-bottom: 1px solid #e5e5e5; }
            tbody tr:nth-child(even) { background: #f7f9fc; }
            tfoot td { font-weight: 700; background: #eef2f7; padding: 8px; border-top: 2px solid #1B3A6B; }
            .p-section-title { font-size: 13px; font-weight: 700; color: #1B3A6B; margin: 18px 0 8px; }
            .p-footer { margin-top: 16px; text-align: right; font-size: 10px; color: #999; }
        </style>
    </head>
    <body>
        <div class="p-header">
            <h1>Sales Report</h1>
            <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
        </div>

        @if(request('start_date') || request('end_date') || request('product_id') || request('keyword'))
        <div class="p-filters">
            @if(request('start_date') && request('end_date'))
                Period: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M Y') }} — {{ \Carbon\Carbon::parse(request('end_date'))->format('d M Y') }} &nbsp;|&nbsp;
            @endif
            @if(request('keyword')) Invoice: "{{ request('keyword') }}" &nbsp;|&nbsp; @endif
            @if(request('product_id')) Filtered by selected product @endif
        </div>
        @endif

        <div class="p-summary">
            <div>
                <div class="lbl">Total Orders</div>
                <div class="val">{{ number_format($total_orders ?? 0) }}</div>
            </div>
            <div>
                <div class="lbl">Items Sold</div>
                <div class="val">{{ number_format($total_item) }}</div>
            </div>
            <div>
                <div class="lbl">Revenue</div>
                <div class="val">৳{{ number_format($total_sales, 2) }}</div>
            </div>
            <div>
                <div class="lbl">Cost</div>
                <div class="val">৳{{ number_format($total_purchase, 2) }}</div>
            </div>
            <div>
                <div class="lbl">Net Profit</div>
                <div class="val">৳{{ number_format($total_sales - $total_purchase, 2) }}</div>
            </div>
        </div>

        @if(!empty($topProduct))
        <div class="p-top">
            <span>🏆 Best Seller: <strong>{{ $topProduct['name'] }}</strong></span>
            <span>{{ number_format($topProduct['qty']) }} units — ৳{{ number_format($topProduct['revenue'], 2) }}</span>
        </div>
        @endif

        @if($dailySummary->count() > 0)
        <div class="p-section-title">Daily Breakdown</div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th class="center">Orders</th>
                    <th class="center">Qty</th>
                    <th class="num">Revenue</th>
                    <th class="num">Cost</th>
                    <th class="num">Profit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailySummary as $day)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($day['date'])->format('d M Y') }}</td>
                    <td class="center">{{ $day['orders'] }}</td>
                    <td class="center">{{ number_format($day['qty']) }}</td>
                    <td class="num">৳{{ number_format($day['revenue'], 2) }}</td>
                    <td class="num">৳{{ number_format($day['purchase'], 2) }}</td>
                    <td class="num">৳{{ number_format($day['revenue'] - $day['purchase'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <div class="p-section-title">Order Details</div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th class="center">Qty</th>
                    <th class="num">Unit Price</th>
                    <th class="num">Purchase</th>
                    <th class="num">Total Sale</th>
                    <th class="num">Profit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                @php
                    $unitSale     = $order->price ?? 0;
                    $unitPurchase = $order->product->purchase_price ?? 0;
                    $rowSale      = $unitSale     * $order->quantity;
                    $rowPurchase  = $unitPurchase * $order->quantity;
                @endphp
                <tr>
                    <td>{{ optional($order->order?->created_at)->format('d M Y') ?? '—' }}</td>
                    <td>#{{ $order->order->order_id ?? '—' }}</td>
                    <td>{{ $order->order->user->name ?? '—' }}</td>
                    <td>{{ $order->product->name ?? '—' }}</td>
                    <td class="center">{{ $order->quantity }}</td>
                    <td class="num">৳{{ number_format($unitSale, 2) }}</td>
                    <td class="num">৳{{ number_format($unitPurchase, 2) }}</td>
                    <td class="num">৳{{ number_format($rowSale, 2) }}</td>
                    <td class="num">৳{{ number_format($rowSale - $rowPurchase, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align:right;">Grand Total:</td>
                    <td class="num">৳{{ number_format($total_sales, 2) }}</td>
                    <td class="num">৳{{ number_format($total_sales - $total_purchase, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="p-footer">{{ config('app.name', 'Admin Panel') }} — Sales Report (This page shows the current filtered page only, not all pages)</div>
    </body>
    </html>
</template>

@endsection

@section('script')
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script>
    function openPrintWindow() {
        const printContent = document.getElementById('printTemplate').innerHTML;
        const printWindow = window.open('', '_blank', 'width=1000,height=750');
        printWindow.document.open();
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.onload = function () {
            printWindow.focus();
            printWindow.print();
        };
    }

    $(document).ready(function () {
        $('#export-excel-button').on('click', function () {
            $('#content-to-export table').table2excel({
                exclude: '.no-export',
                name: 'Sales Report',
                filename: 'sales_report_{{ now()->format("Y_m_d") }}'
            });
        });
    });
</script>
@endsection