@extends('admin.layouts.app')

@section('title', 'Stock Report')

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

.sr-page { background: #f3f4f6; min-height: 100vh; padding: 28px 0; }
.sr-wrap { max-width: 1200px; margin: 0 auto; padding: 0 16px; }

/* Header */
.sr-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 12px; }
.sr-title { font-size: 21px; font-weight: 800; color: var(--ink); display: flex; align-items: center; gap: 10px; }
.sr-title-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--p1); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 15px; }
.sr-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.sr-btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 8px; font-size: 13px; font-weight: 700; border: none; cursor: pointer; text-decoration: none; transition: .15s; }
.sr-btn-print { background: var(--p1); color: #fff; }
.sr-btn-print:hover { opacity: .9; color: #fff; }
.sr-btn-export { background: var(--green); color: #fff; }
.sr-btn-export:hover { opacity: .9; color: #fff; }

/* KPI Cards */
.sr-kpis { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
@media (max-width: 900px) { .sr-kpis { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 500px) { .sr-kpis { grid-template-columns: 1fr; } }
.sr-kpi { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 18px; display: flex; align-items: center; gap: 14px; box-shadow: 0 1px 6px rgba(0,0,0,.04); }
.sr-kpi-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #fff; flex-shrink: 0; }
.sr-kpi-icon.blue { background: linear-gradient(135deg, #2563eb, #1B3A6B); }
.sr-kpi-icon.green { background: linear-gradient(135deg, #10b981, #059669); }
.sr-kpi-icon.amber { background: linear-gradient(135deg, #f59e0b, #d97706); }
.sr-kpi-icon.purple { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
.sr-kpi-label { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 3px; }
.sr-kpi-val { font-size: 19px; font-weight: 800; color: var(--ink); }

/* Filter card */
.sr-filter-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 6px rgba(0,0,0,.04); }
.sr-filter-title { font-size: 12px; font-weight: 700; color: var(--p1); text-transform: uppercase; letter-spacing: .04em; margin-bottom: 14px; display: flex; align-items: center; gap: 7px; }
.sr-flabel { display: block; font-size: 11px; font-weight: 700; color: var(--muted); margin-bottom: 5px; text-transform: uppercase; letter-spacing: .03em; }
.sr-finput { width: 100%; border: 1.5px solid var(--border); border-radius: 8px; padding: 9px 12px; font-size: 13.5px; outline: none; transition: .15s; }
.sr-finput:focus { border-color: var(--p2); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
.sr-fbtn-apply { background: var(--p1); color: #fff; border: none; border-radius: 8px; padding: 10px 22px; font-size: 13px; font-weight: 700; cursor: pointer; }
.sr-fbtn-reset { background: #f3f4f6; color: var(--ink); border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 22px; font-size: 13px; font-weight: 700; text-decoration: none; }

/* Table card */
.sr-table-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,.04); }
.sr-table-head-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border); }
.sr-table-head-title { font-size: 13.5px; font-weight: 700; color: var(--ink); }
.sr-count-badge { background: var(--p3); color: var(--p1); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

table.sr-table { width: 100%; border-collapse: collapse; }
table.sr-table thead th { background: #f9fafb; color: var(--muted); font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; padding: 12px 18px; text-align: left; border-bottom: 1px solid var(--border); }
table.sr-table thead th.num { text-align: right; }
table.sr-table tbody tr { border-top: 1px solid #f3f4f6; transition: background .1s; }
table.sr-table tbody tr:hover { background: #fafbfc; }
table.sr-table tbody td { padding: 13px 18px; font-size: 13.5px; color: var(--ink); }
table.sr-table tbody td.num { text-align: right; font-family: 'Courier New', monospace; }
.sr-sl { color: var(--muted); font-weight: 600; font-size: 12px; }
.sr-pname { font-weight: 600; }
.sr-stock-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; }
.sr-stock-badge.ok { background: #ecfdf5; color: var(--green); }
.sr-stock-badge.low { background: #fffbeb; color: var(--amber); }
.sr-stock-badge.out { background: #fef2f2; color: var(--red); }
.sr-total-val { font-weight: 700; color: var(--p1); }

table.sr-table tfoot td { padding: 14px 18px; font-size: 13px; font-weight: 700; background: #f9fafb; border-top: 2px solid var(--border); }

/* ✅ FIX — .sr-summary-row-এর td-কে সরাসরি টার্গেট করে gradient বসানো হলো,
   যাতে উপরের generic "tfoot td { background:#f9fafb }" rule একে ঢেকে না দেয়।
   td-এর নিজের background সবসময় parent tr-এর background-এর উপরে বসে (DOM layering),
   তাই .sr-summary-row (tr) এ gradient দিলেও কাজ করত না — td-কেই দিতে হবে। */
table.sr-table tfoot tr.sr-summary-row td {
    background: linear-gradient(135deg, var(--p1), #0f2547) !important;
    padding: 20px !important;
    border-top: none !important;
}

.sr-summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; text-align: center; }
@media (max-width: 700px) { .sr-summary-grid { grid-template-columns: 1fr; } }
.sr-summary-item .lbl { color: rgba(255,255,255,.65); font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 6px; }
.sr-summary-item .val { color: #fff; font-size: 20px; font-weight: 800; }

.sr-pagination-wrap { padding: 16px 20px; }
.sr-empty { text-align: center; padding: 60px 20px; color: #d1d5db; }
.sr-empty i { font-size: 42px; margin-bottom: 12px; display: block; }

/* Print styles */
@media print {
    body * { visibility: hidden; }
    .sr-print-area, .sr-print-area * { visibility: visible; }
    .sr-print-area { position: absolute; top: 0; left: 0; width: 100%; }
    .no-print { display: none !important; }
}
</style>

<div class="sr-page">
<div class="sr-wrap">

    {{-- Header --}}
    <div class="sr-header">
        <div class="sr-title">
            <span class="sr-title-icon"><i class="fas fa-boxes"></i></span>
            Stock Report
        </div>
        <div class="sr-actions">
            <button onclick="openPrintWindow()" class="sr-btn sr-btn-print">
                <i class="fas fa-print"></i> Print Report
            </button>
            <button id="export-excel-button" class="sr-btn sr-btn-export">
                <i class="fas fa-file-export"></i> Export Excel
            </button>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="sr-kpis">
        <div class="sr-kpi">
            <div class="sr-kpi-icon blue"><i class="fas fa-box"></i></div>
            <div>
                <div class="sr-kpi-label">Total Products</div>
                <div class="sr-kpi-val">{{ number_format($total_products ?? $products->total()) }}</div>
            </div>
        </div>
        <div class="sr-kpi">
            <div class="sr-kpi-icon green"><i class="fas fa-cubes"></i></div>
            <div>
                <div class="sr-kpi-label">Total Stock</div>
                <div class="sr-kpi-val">{{ number_format($total_stock ?? 0) }} pcs</div>
            </div>
        </div>
        <div class="sr-kpi">
            <div class="sr-kpi-icon amber"><i class="fas fa-money-bill-wave"></i></div>
            <div>
                <div class="sr-kpi-label">Purchase Value</div>
                <div class="sr-kpi-val">{{ currency() }}{{ number_format($total_purchase ?? 0, 2) }}</div>
            </div>
        </div>
        <div class="sr-kpi">
            <div class="sr-kpi-icon purple"><i class="fas fa-sack-dollar"></i></div>
            <div>
                <div class="sr-kpi-label">Sale Value</div>
                <div class="sr-kpi-val">{{ currency() }}{{ number_format($total_price ?? 0, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="sr-filter-card no-print">
        <div class="sr-filter-title"><i class="fas fa-filter"></i> Filter Report</div>
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="sr-flabel">Keyword</label>
                <input type="text" name="keyword" value="{{ request('keyword') }}" class="sr-finput" placeholder="Search product...">
            </div>
            <div class="col-md-3">
                <label class="sr-flabel">Category</label>
                <select name="category_id" class="sr-finput">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(request('category_id') == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="sr-flabel">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="sr-finput">
            </div>
            <div class="col-md-3">
                <label class="sr-flabel">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="sr-finput">
            </div>
            <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                <a href="{{ route('admin.stock_report') }}" class="sr-fbtn-reset">Reset</a>
                <button type="submit" class="sr-fbtn-apply"><i class="fas fa-search me-1"></i> Apply Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="sr-table-card">
        <div class="sr-table-head-row">
            <span class="sr-table-head-title">Product Stock List</span>
            <span class="sr-count-badge">{{ $products->total() }} products</span>
        </div>

        @if($products->isEmpty())
        <div class="sr-empty">
            <i class="fas fa-box-open"></i>
            <p class="mb-0">No products found for this filter.</p>
        </div>
        @else
        <div class="table-responsive" id="content-to-export">
            <table class="sr-table">
                <thead>
                    <tr>
                        <th style="width:50px;">SL</th>
                        <th>Product Name</th>
                        <th class="num">Unit Price</th>
                        <th class="num">Stock</th>
                        <th class="num">Total Value</th>
                    </tr>
                </thead>
                <tbody>
                    @php $pageStock = 0; $pageTotal = 0; @endphp
                    @foreach($products as $key => $value)
                    @php
                        $rowTotal   = $value->stock * $value->sale_price;
                        $pageStock += $value->stock;
                        $pageTotal += $rowTotal;
                        $stockClass = $value->stock <= 0 ? 'out' : ($value->stock <= 10 ? 'low' : 'ok');
                        $stockLabel = $value->stock <= 0 ? 'Out of Stock' : $value->stock;
                    @endphp
                    <tr>
                        <td class="sr-sl">{{ $products->firstItem() + $key }}</td>
                        <td class="sr-pname">{{ $value->name }}</td>
                        <td class="num">{{ currency() }}{{ number_format($value->sale_price, 2) }}</td>
                        <td class="num"><span class="sr-stock-badge {{ $stockClass }}">{{ $stockLabel }}</span></td>
                        <td class="num sr-total-val">{{ currency() }}{{ number_format($rowTotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;">Page Subtotal:</td>
                        <td class="num">{{ number_format($pageStock) }} pcs</td>
                        <td class="num">{{ currency() }}{{ number_format($pageTotal, 2) }}</td>
                    </tr>
                    <tr class="sr-summary-row">
                        <td colspan="5">
                            <div class="sr-summary-grid">
                                <div class="sr-summary-item">
                                    <div class="lbl">Total Purchase Value</div>
                                    <div class="val">{{ currency() }}{{ number_format($total_purchase ?? 0, 2) }}</div>
                                </div>
                                <div class="sr-summary-item">
                                    <div class="lbl">Total Stock (All Pages)</div>
                                    <div class="val">{{ number_format($total_stock ?? 0) }} pcs</div>
                                </div>
                                <div class="sr-summary-item">
                                    <div class="lbl">Total Sale Value</div>
                                    <div class="val">{{ currency() }}{{ number_format($total_price ?? 0, 2) }}</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="sr-pagination-wrap no-print">
            {{ $products->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
        </div>
        @endif
    </div>

</div>{{-- /sr-wrap --}}
</div>{{-- /sr-page --}}

{{-- ✅ Print template — আলাদা নতুন window-এ খোলা হবে, admin sidebar/navbar একদমই থাকবে না --}}
<template id="printTemplate">
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Stock Report</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
            body { padding: 30px; color: #111; }
            .p-header { text-align: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #1B3A6B; }
            .p-header h1 { font-size: 20px; color: #1B3A6B; margin-bottom: 4px; }
            .p-header p { font-size: 11px; color: #666; }
            .p-summary { display: flex; justify-content: space-around; margin-bottom: 20px; background: #f9fafb; border: 1px solid #ddd; border-radius: 8px; padding: 14px; }
            .p-summary div { text-align: center; }
            .p-summary .lbl { font-size: 10px; color: #666; text-transform: uppercase; margin-bottom: 4px; }
            .p-summary .val { font-size: 15px; font-weight: 700; color: #1B3A6B; }
            table { width: 100%; border-collapse: collapse; font-size: 11.5px; }
            th { background: #1B3A6B; color: #fff; padding: 8px 10px; text-align: left; }
            th.num, td.num { text-align: right; }
            td { padding: 7px 10px; border-bottom: 1px solid #e5e5e5; }
            tbody tr:nth-child(even) { background: #f7f9fc; }
            tfoot td { font-weight: 700; background: #eef2f7; padding: 9px 10px; border-top: 2px solid #1B3A6B; }
            .p-footer { margin-top: 20px; text-align: right; font-size: 10px; color: #999; }
        </style>
    </head>
    <body>
        <div class="p-header">
            <h1>Stock Report</h1>
            <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
        </div>

        <div class="p-summary">
            <div>
                <div class="lbl">Total Products</div>
                <div class="val">{{ number_format($total_products ?? $products->total()) }}</div>
            </div>
            <div>
                <div class="lbl">Total Stock</div>
                <div class="val">{{ number_format($total_stock ?? 0) }} pcs</div>
            </div>
            <div>
                <div class="lbl">Purchase Value</div>
                <div class="val">{{ currency() }}{{ number_format($total_purchase ?? 0, 2) }}</div>
            </div>
            <div>
                <div class="lbl">Sale Value</div>
                <div class="val">{{ currency() }}{{ number_format($total_price ?? 0, 2) }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:40px;">SL</th>
                    <th>Product Name</th>
                    <th class="num">Unit Price</th>
                    <th class="num">Stock</th>
                    <th class="num">Total Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $value)
                <tr>
                    <td>{{ $products->firstItem() + $key }}</td>
                    <td>{{ $value->name }}</td>
                    <td class="num">{{ currency() }}{{ number_format($value->sale_price, 2) }}</td>
                    <td class="num">{{ $value->stock }}</td>
                    <td class="num">{{ currency() }}{{ number_format($value->stock * $value->sale_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;">Grand Total:</td>
                    <td class="num">{{ number_format($total_stock ?? 0) }} pcs</td>
                    <td class="num">{{ currency() }}{{ number_format($total_price ?? 0, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="p-footer">{{ config('app.name', 'Admin Panel') }} — Stock Report</div>
    </body>
    </html>
</template>

@endsection

@section('script')
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script>
    // ✅ Print — নতুন আলাদা window খোলে, শুধু report content, admin UI একদমই আসবে না
    function openPrintWindow() {
        const printContent = document.getElementById('printTemplate').innerHTML;
        const printWindow = window.open('', '_blank', 'width=900,height=700');
        printWindow.document.open();
        printWindow.document.write(printContent);
        printWindow.document.close();

        // Content load হওয়ার পর প্রিন্ট ডায়ালগ খুলবে
        printWindow.onload = function () {
            printWindow.focus();
            printWindow.print();
        };
    }

    $(document).ready(function() {
        $('#export-excel-button').on('click', function() {
            $('#content-to-export table').table2excel({
                exclude: ".no-export",
                name: "Stock Report"
            });
        });
    });
</script>
@endsection