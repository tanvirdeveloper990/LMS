@extends('admin.layouts.app')
@section('title', 'Order #{{ $order->order_id }}')

@section('content')
<style>
:root {
    --ink:#1a1a2e; --muted:#6b7280; --light:#f8f9ff; --border:#e5e7eb;
    --p1:#1B3A6B; --p2:#2563eb; --p3:#eff6ff;
    --green:#059669; --red:#dc2626; --amber:#d97706;
}
* { font-family:'Segoe UI',system-ui,sans-serif; box-sizing:border-box; }
.mono { font-family:'Courier New',monospace; }

.inv-page { background:#f3f4f6; min-height:100vh; padding:28px 16px; }
.inv-wrap  { max-width:960px; margin:0 auto; display:flex; flex-direction:column; gap:18px; }

/* Action bar */
.action-bar { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
.page-title  { font-size:20px; font-weight:700; color:var(--ink); display:flex; align-items:center; gap:8px; }
.page-title .oid { font-size:12px; font-weight:600; color:var(--muted); background:#fff; border:1px solid var(--border); padding:3px 10px; border-radius:20px; }
.btn-bar   { display:flex; gap:8px; flex-wrap:wrap; }
.btn-ghost { background:#fff; border:1px solid var(--border); color:var(--ink); border-radius:8px; padding:7px 14px; font-size:13px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all .15s; cursor:pointer; }
.btn-ghost:hover { border-color:var(--p2); color:var(--p2); }
.btn-print { background:var(--p1); color:#fff; border:none; border-radius:8px; padding:7px 18px; font-size:13px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:opacity .15s; }
.btn-print:hover { opacity:.88; }

/* Card */
.inv-card { background:#fff; border:1px solid var(--border); border-radius:14px; overflow:hidden; }

/* Header */
.inv-head { background:var(--p1); padding:24px 28px; display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px; }
.company-block img { height:44px; margin-bottom:10px; display:block; }
.company-block h2  { color:#fff; font-size:17px; font-weight:700; margin:0 0 4px; }
.company-block p   { color:rgba(255,255,255,.65); font-size:12px; margin:0; line-height:1.8; }
.invoice-meta      { text-align:right; }
.inv-label { color:rgba(255,255,255,.5); font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.7px; }
.inv-id    { color:#fff; font-size:22px; font-weight:700; font-family:'Courier New',monospace; margin:3px 0 10px; }
.inv-date-row { color:rgba(255,255,255,.7); font-size:12px; }

/* Status strip */
.status-strip { display:flex; border-bottom:1px solid var(--border); background:#fafafa; flex-wrap:wrap; }
.ss-item  { flex:1; min-width:110px; padding:12px 18px; border-right:1px solid var(--border); }
.ss-item:last-child { border-right:none; }
.ss-label { font-size:10px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.5px; margin-bottom:5px; }
.ss-val   { font-size:13px; font-weight:700; color:var(--ink); }
.status-select { border:1px solid var(--border); border-radius:7px; padding:4px 8px; font-size:12px; font-weight:600; color:var(--ink); background:#fff; cursor:pointer; outline:none; }
.status-select:focus { border-color:var(--p2); }

/* Body */
.inv-body { padding:24px 28px; }

/* Info grid */
.info-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px; }
@media(max-width:580px){ .info-grid{ grid-template-columns:1fr; } }
.info-box { background:var(--light); border:1px solid var(--border); border-radius:10px; padding:16px; }
.info-box-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:var(--p1); margin-bottom:12px; display:flex; align-items:center; gap:6px; }
.info-row-item  { display:flex; gap:8px; margin-bottom:7px; font-size:13px; }
.info-row-item:last-child { margin-bottom:0; }
.ir-label { color:var(--muted); font-weight:600; min-width:72px; flex-shrink:0; font-size:12px; }
.ir-val   { color:var(--ink); font-weight:500; word-break:break-word; }

/* Payment box */
.pay-box { border-radius:10px; padding:16px; margin-bottom:20px; border:1px solid; }
.pay-box-title { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; margin-bottom:12px; display:flex; align-items:center; gap:8px; }
.pay-badge { display:inline-flex; align-items:center; justify-content:center; width:20px; height:20px; border-radius:50%; color:#fff; font-size:11px; font-weight:700; flex-shrink:0; }
.method-pill { display:inline-block; padding:2px 10px; border-radius:20px; color:#fff; font-size:11px; font-weight:700; }
.trx-val { font-family:'Courier New',monospace; font-weight:700; font-size:14px; letter-spacing:.04em; }

/* Items table */
.items-table-wrap { border:1px solid var(--border); border-radius:10px; overflow:hidden; margin-bottom:20px; }
table.items { width:100%; border-collapse:collapse; }
table.items thead th { background:#f3f4f6; color:var(--ink); font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; padding:10px 14px; text-align:left; border-bottom:1px solid var(--border); }
table.items thead th:last-child,
table.items thead th:nth-child(3),
table.items thead th:nth-child(4) { text-align:right; }
table.items tbody tr { border-top:1px solid var(--border); }
table.items tbody tr:hover { background:#f9fafb; }
table.items tbody td { padding:12px 14px; font-size:13px; color:var(--ink); }
table.items tbody td:last-child,
table.items tbody td:nth-child(3),
table.items tbody td:nth-child(4) { text-align:right; }
.product-name { font-weight:600; }
.qty-badge { background:#e0e7ff; color:#3730a3; border-radius:5px; padding:2px 8px; font-size:12px; font-weight:700; }

/* Variant badges (color / size / hijab) */
.variant-wrap  { display:flex; flex-wrap:wrap; gap:5px; margin-top:5px; }
.variant-badge { display:inline-flex; align-items:center; gap:4px; background:var(--p3); color:var(--p1); border:1px solid #c7d9f5; border-radius:20px; padding:2px 9px; font-size:11px; font-weight:600; }
.variant-badge .swatch { width:9px; height:9px; border-radius:50%; border:1px solid rgba(0,0,0,.15); flex-shrink:0; }
.variant-badge.hijab-badge { background:#fdf2e9; color:var(--amber); border-color:#f6d9b8; }

/* Summary */
.summary-wrap { display:flex; justify-content:flex-end; }
.summary-box  { width:100%; max-width:300px; border:1px solid var(--border); border-radius:10px; overflow:hidden; }
.sum-row      { display:flex; justify-content:space-between; align-items:center; padding:10px 16px; border-bottom:1px solid var(--border); font-size:13px; }
.sum-row:last-child { border-bottom:none; }
.sum-row .s-label { color:var(--muted); font-weight:600; }
.sum-row .s-val   { font-weight:700; font-family:'Courier New',monospace; color:var(--ink); }
.sum-row.total-row { background:var(--p1); }
.sum-row.total-row .s-label,
.sum-row.total-row .s-val { color:#fff; font-size:14px; }
.sum-row.due-row  .s-val { color:var(--red); }
.sum-row.paid-row .s-val { color:var(--green); }
.sum-row.coupon-row .s-val { color:var(--amber); }

/* Toast */
#invToast { position:fixed; bottom:20px; right:20px; z-index:9999; padding:11px 18px; border-radius:10px; font-size:13px; font-weight:600; color:#fff; display:flex; align-items:center; gap:8px; box-shadow:0 4px 20px rgba(0,0,0,.12); opacity:0; transform:translateY(10px); transition:opacity .2s,transform .2s; pointer-events:none; min-width:200px; }
#invToast.show { opacity:1; transform:translateY(0); }

/* Print */
@page { size:A4 portrait; margin:0 !important; }
@media print {
    html,body { margin:0!important; padding:0!important; }
    body { visibility:hidden!important; background:#fff!important; }
    #printOverlay {
        visibility:visible!important; position:fixed!important;
        top:0!important; left:0!important; width:100%!important;
        padding:12mm 14mm!important; background:#fff!important;
        font-family:'Segoe UI',Arial,sans-serif!important;
        font-size:12px!important; color:#111!important; z-index:999999!important;
    }
    #printOverlay * { visibility:visible!important; }
    #printOverlay .p-company-header { text-align:center; margin-bottom:12px; }
    #printOverlay .p-company-name   { font-size:18px; font-weight:700; margin-bottom:4px; }
    #printOverlay .p-company-info   { font-size:11px; color:#444; margin-bottom:2px; }
    #printOverlay .p-divider { border:none; border-top:1px solid #aaa; margin:10px 0; }
    #printOverlay .p-info-row { display:flex!important; width:100%; }
    #printOverlay .p-col { flex:1; }
    #printOverlay .p-col-right { text-align:right; }
    #printOverlay .p-section-title { font-size:13px; font-weight:700; margin-bottom:7px; }
    #printOverlay .p-lbl  { font-weight:700; }
    #printOverlay .p-line { font-size:12px; margin-bottom:4px; }
    #printOverlay .p-variant { font-size:11px; color:#555; margin-top:2px; }
    #printOverlay .p-table { width:100%!important; border-collapse:collapse!important; font-size:12px; margin-bottom:12px; }
    #printOverlay .p-table th { background:#f0f0f0!important; print-color-adjust:exact; font-weight:700; padding:7px 9px; border:1px solid #bbb!important; text-align:left; }
    #printOverlay .p-table td { padding:6px 9px; border:1px solid #ccc!important; }
    #printOverlay .p-table tbody tr:nth-child(even) td { background:#fafafa!important; print-color-adjust:exact; }
    #printOverlay .p-center { text-align:center; }
    #printOverlay .p-right  { text-align:right; }
    #printOverlay .p-summary-wrap  { display:flex!important; justify-content:flex-end!important; }
    #printOverlay .p-summary-table { width:40%!important; }
    #printOverlay .p-summary-table th { background:#f5f5f5!important; print-color-adjust:exact; text-align:left; }
}
</style>

<div class="inv-page">
<div class="inv-wrap">

    {{-- Action bar --}}
    <div class="action-bar">
        <div class="page-title">
            <i class="fa fa-receipt" style="color:var(--p1);"></i>
            Order Details
            <span class="oid">#{{ $order->order_id }}</span>
        </div>
        <div class="btn-bar">
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn-ghost">
                <i class="fa fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.all-orders') }}" class="btn-ghost">
                <i class="fa fa-arrow-left"></i> Back
            </a>
            <button class="btn-print" id="printBtn">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>

    {{-- Card --}}
    <div class="inv-card">

        {{-- Header --}}
        <div class="inv-head">
            <div class="company-block">
                <img src="{{ Storage::url($setting->header_logo) }}" alt="Logo">
                <h2>{{ $setting->company_name }}</h2>
                <p>
                    <i class="fa fa-phone me-1"></i>{{ $setting->phone_one }}<br>
                    <i class="fa fa-envelope me-1"></i>{{ $setting->email_one }}<br>
                    <i class="fa fa-map-marker-alt me-1"></i>{{ $setting->address }}
                </p>
            </div>
            <div class="invoice-meta">
                <div class="inv-label">Invoice</div>
                <div class="inv-id">#{{ $order->order_id }}</div>
                <div class="inv-date-row">
                    <i class="fa fa-calendar-alt me-1"></i>{{ $order->created_at->format('d M Y') }}
                </div>
                @if($order->delivery_date)
                <div class="inv-date-row mt-1">
                    <i class="fa fa-truck me-1"></i>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                </div>
                @endif
            </div>
        </div>

        {{-- Status strip --}}
        <div class="status-strip">
           <div class="ss-item">
                <div class="ss-label">Payment Status</div>
                <select id="payment_status" class="status-select">
                    <option value="pending" {{ $order->payment_status=='pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="paid"    {{ $order->payment_status=='paid'    ? 'selected' : '' }}>✅ Paid</option>
                    <option value="unpaid"  {{ $order->payment_status=='unpaid'  ? 'selected' : '' }}>❌ Unpaid</option>
                </select>
            </div>
            <div class="ss-item">
                <div class="ss-label">Order Status</div>
                <select id="order_status" class="status-select">
                    <option value="pending"    {{ $order->status=='pending'    ? 'selected' : '' }}>🕐 Pending</option>
                    <option value="processing" {{ $order->status=='processing' ? 'selected' : '' }}>⚙️ Processing</option>
                    <option value="on the way" {{ $order->status=='on the way' ? 'selected' : '' }}>🚚 On The Way</option>
                    <option value="on hold"    {{ $order->status=='on hold'    ? 'selected' : '' }}>⏸️ On Hold</option>
                    <option value="courier"    {{ $order->status=='courier'    ? 'selected' : '' }}>📦 Courier</option>
                    <option value="completed"  {{ $order->status=='completed'  ? 'selected' : '' }}>✅ Completed</option>
                    <option value="cancelled"  {{ $order->status=='cancelled'  ? 'selected' : '' }}>❌ Cancelled</option>
                </select>
            </div>
            <div class="ss-item">
                <div class="ss-label">Payment Method</div>
                <div class="ss-val">{{ ucfirst($order->payment_method ?? 'N/A') }}</div>
            </div>
            <div class="ss-item">
                <div class="ss-label">Total Items</div>
                <div class="ss-val mono">{{ $order->orderItems->sum('quantity') }} pcs</div>
            </div>
            @if($order->transaction_id)
            <div class="ss-item">
                <div class="ss-label">Transaction ID</div>
                <div class="ss-val mono" style="font-size:12px; color:{{ $order->payment_method === 'bkash' ? '#E2136E' : '#F6821F' }};">
                    {{ $order->transaction_id }}
                </div>
            </div>
            @endif
        </div>

        {{-- Body --}}
        <div class="inv-body">

            {{-- Info grid --}}
            <div class="info-grid">
                <div class="info-box">
                    <div class="info-box-title">
                        <i class="fa fa-user"></i> Customer Info
                    </div>
                    <div class="info-row-item">
                        <span class="ir-label">Name</span>
                        <span class="ir-val">{{ $order->user->name ?? 'Guest' }}</span>
                    </div>
                    <div class="info-row-item">
                        <span class="ir-label">Phone</span>
                        <span class="ir-val mono">{{ $order->user->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row-item">
                        <span class="ir-label">Email</span>
                        <span class="ir-val">{{ $order->user->email ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row-item">
                        <span class="ir-label">Address</span>
                        <span class="ir-val">{{ $order->user->address ?? 'N/A' }}</span>
                    </div>
                    @if($order->delivery_area)
                    <div class="info-row-item">
                        <span class="ir-label">Area</span>
                        <span class="ir-val">{{ $order->delivery_area }}</span>
                    </div>
                    @endif
                </div>

                <div class="info-box">
                    <div class="info-box-title">
                        <i class="fa fa-shopping-bag"></i> Order Info
                    </div>
                    <div class="info-row-item">
                        <span class="ir-label">Invoice</span>
                        <span class="ir-val mono">#{{ $order->order_id }}</span>
                    </div>
                    <div class="info-row-item">
                        <span class="ir-label">Date</span>
                        <span class="ir-val">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <div class="info-row-item">
                        <span class="ir-label">Total</span>
                        <span class="ir-val mono" style="color:var(--p1); font-weight:700;">
                            {{ currency() }}{{ number_format($order->total, 2) }}
                        </span>
                    </div>
                    <div class="info-row-item">
                        <span class="ir-label">Paid</span>
                        <span class="ir-val mono" style="color:var(--green); font-weight:700;">
                            {{ currency() }}{{ number_format($order->paid ?? 0, 2) }}
                        </span>
                    </div>
                    @if($order->note)
                    <div class="info-row-item">
                        <span class="ir-label">Note</span>
                        <span class="ir-val" style="color:var(--muted);">{{ $order->note }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Payment Info Box (bKash / Nagad only) --}}
            @if($order->transaction_id)
            @php
                $isBkash = $order->payment_method === 'bkash';
                $payColor = $isBkash ? '#E2136E' : '#F6821F';
                $payBg    = $isBkash ? '#fff0f6' : '#fff7ed';
                $payBorder= $isBkash ? '#f9a8d4' : '#fed7aa';
            @endphp
            <div class="pay-box" style="background:{{ $payBg }}; border-color:{{ $payBorder }}; margin-bottom:20px;">
                <div class="pay-box-title" style="color:{{ $payColor }};">
                    <span class="pay-badge" style="background:{{ $payColor }};">
                        {{ strtoupper(substr($order->payment_method, 0, 1)) }}
                    </span>
                    {{ ucfirst($order->payment_method) }} Payment Details
                </div>
                <div class="info-row-item">
                    <span class="ir-label">Method</span>
                    <span class="ir-val">
                        <span class="method-pill" style="background:{{ $payColor }};">
                            {{ ucfirst($order->payment_method) }}
                        </span>
                    </span>
                </div>
                <div class="info-row-item">
                    <span class="ir-label">TrxID</span>
                    <span class="ir-val trx-val" style="color:{{ $payColor }};">
                        {{ $order->transaction_id }}
                    </span>
                </div>
                <div class="info-row-item">
                    <span class="ir-label">Number</span>
                    <span class="ir-val trx-val" style="color:{{ $payColor }};">
                        {{ $order->payment_number }}
                    </span>
                </div>
                <div class="info-row-item">
                    <span class="ir-label">Amount</span>
                    <span class="ir-val mono" style="font-weight:700;">
                        {{ currency() }}{{ number_format($order->total, 2) }}
                    </span>
                </div>
                
            </div>
            @endif

            {{-- Items table --}}
            <div class="items-table-wrap">
                <table class="items">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        @php
                            $variantInfo = is_array($item->product_variant_id)
                                            ? $item->product_variant_id
                                            : json_decode($item->product_variant_id, true);
                            $vColor = $variantInfo['color'] ?? null;
                            $vSize  = $variantInfo['size']  ?? null;
                        @endphp
                        <tr>
                            <td style="color:var(--muted); font-size:12px; font-weight:600;">{{ $loop->iteration }}</td>
                            <td>
                                <div class="product-name">{{ $item->product->name ?? 'Product' }}</div>
                                @if($vColor || $vSize || $item->hijab)
                                <div class="variant-wrap">
                                    @if($vColor)
                                    <span class="variant-badge">
                                        <span class="swatch" style="background:{{ $vColor }};"></span>
                                        {{ $vColor }}
                                    </span>
                                    @endif
                                    @if($vSize)
                                    <span class="variant-badge">Size: {{ $vSize }}</span>
                                    @endif
                                    @if($item->hijab)
                                    <span class="variant-badge hijab-badge">
                                        হিজাব: {{ $item->hijab }}
                                        @if($item->hijab === 'সহ' && $item->hijab_price > 0)
                                            (+{{ currency() }}{{ number_format($item->hijab_price, 2) }})
                                        @endif
                                    </span>
                                    @endif
                                </div>
                                @endif
                            </td>
                            <td><span class="qty-badge">{{ $item->quantity }}</span></td>
                            <td class="mono">{{ currency() }}{{ number_format($item->price, 2) }}</td>
                            <td class="mono" style="font-weight:700; color:var(--p1);">
                                {{ currency() }}{{ number_format($item->quantity * $item->price, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Summary --}}
            <div class="summary-wrap">
                <div class="summary-box">
                    <div class="sum-row">
                        <span class="s-label">Subtotal</span>
                        <span class="s-val">{{ currency() }}{{ number_format($order->total + ($order->used_point ?? 0), 2) }}</span>
                    </div>
                    <div class="sum-row">
                        <span class="s-label">Delivery</span>
                        <span class="s-val">{{ currency() }}{{ number_format($order->delivery_charge ?? 0, 2) }}</span>
                    </div>
                    @if(($order->coupon ?? 0) > 0)
                    <div class="sum-row coupon-row">
                        <span class="s-label">Discount</span>
                        <span class="s-val">-{{ currency() }}{{ number_format($order->coupon, 2) }}</span>
                    </div>
                    @endif
                    @if(($order->used_point ?? 0) > 0)
                    <div class="sum-row" style="background:#fef3c7;">
                        <span class="s-label" style="color:#92400e;">
                            <i class="fa fa-coins me-1"></i> Points Redeemed ({{ $order->used_point }} pts)
                        </span>
                        <span class="s-val" style="color:#92400e;">-{{ currency() }}{{ number_format($order->used_point, 2) }}</span>
                    </div>
                    @endif
                    <div class="sum-row total-row">
                        <span class="s-label">Grand Total</span>
                        <span class="s-val">{{ currency() }}{{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="sum-row paid-row">
                        <span class="s-label">Paid</span>
                        <span class="s-val">{{ currency() }}{{ number_format($order->paid ?? 0, 2) }}</span>
                    </div>
                    @if(($order->total - ($order->paid ?? 0)) > 0)
                    <div class="sum-row due-row">
                        <span class="s-label">Due</span>
                        <span class="s-val">{{ currency() }}{{ number_format($order->total - ($order->paid ?? 0), 2) }}</span>
                    </div>
                    @endif
                    @if(($order->total_point ?? 0) > 0)
                    <div class="sum-row" style="background:{{ $order->points_credited ? '#d1fae5' : '#f3f4f6' }};">
                        <span class="s-label" style="color:{{ $order->points_credited ? '#065f46' : '#6b7280' }};">
                            <i class="fa fa-gift me-1"></i> Points to Earn
                        </span>
                        <span class="s-val" style="color:{{ $order->points_credited ? '#065f46' : '#6b7280' }};">
                            +{{ $order->total_point }} {{ $order->points_credited ? '✓ Credited' : '(pending)' }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>

        </div>{{-- /inv-body --}}
    </div>{{-- /inv-card --}}


    {{-- Print template (hidden) --}}
    <div id="printInvoice" style="display:none;">
        <div class="p-company-header">
            <div class="p-company-name">{{ $setting->company_name }}</div>
            <div class="p-company-info">Phone: {{ $setting->phone_one }}</div>
            <div class="p-company-info">Email: {{ $setting->email_one }}</div>
            <div class="p-company-info">Address: {{ $setting->address }}</div>
        </div>
        <div class="p-divider"></div>
        <div class="p-info-row">
            <div class="p-col">
                <div class="p-section-title">Customer Info</div>
                <div class="p-line"><span class="p-lbl">Name:</span> {{ $order->user->name ?? 'Guest' }}</div>
                <div class="p-line"><span class="p-lbl">Phone:</span> {{ $order->user->phone ?? 'N/A' }}</div>
                <div class="p-line"><span class="p-lbl">Address:</span> {{ $order->user->address ?? 'N/A' }}</div>
                @if($order->delivery_area)
                <div class="p-line"><span class="p-lbl">Area:</span> {{ $order->delivery_area }}</div>
                @endif
            </div>
            <div class="p-col p-col-right">
                <div class="p-section-title">Order Info</div>
                <div class="p-line"><span class="p-lbl">Invoice:</span> #{{ $order->order_id }}</div>
                <div class="p-line"><span class="p-lbl">Date:</span> {{ $order->created_at->format('d M Y') }}</div>
                <div class="p-line"><span class="p-lbl">Payment:</span> {{ ucfirst($order->payment_method ?? 'N/A') }}</div>
                @if($order->transaction_id)
                <div class="p-line"><span class="p-lbl">TrxID:</span> {{ $order->transaction_id }}</div>
                @endif
                <div class="p-line"><span class="p-lbl">Total:</span> {{ currency() }}{{ number_format($order->total, 2) }}</div>
            </div>
        </div>
        <div class="p-divider"></div>
        <table class="p-table">
            <thead>
                <tr>
                    <th style="width:36px;">#</th>
                    <th>Product</th>
                    <th style="width:55px;">Qty</th>
                    <th style="width:95px;">Price</th>
                    <th style="width:105px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                @php
                    $pVariantInfo = is_array($item->product_variant_id)
                                    ? $item->product_variant_id
                                    : json_decode($item->product_variant_id, true);
                    $pColor = $pVariantInfo['color'] ?? null;
                    $pSize  = $pVariantInfo['size']  ?? null;
                @endphp
                <tr>
                    <td class="p-center">{{ $loop->iteration }}</td>
                    <td>
                        {{ $item->product->name ?? 'Product' }}
                        @if($pColor || $pSize || $item->hijab)
                        <div class="p-variant">
                            @if($pColor) Color: {{ $pColor }} @endif
                            @if($pColor && $pSize) &nbsp;|&nbsp; @endif
                            @if($pSize) Size: {{ $pSize }} @endif
                            @if($item->hijab)
                                @if($pColor || $pSize) &nbsp;|&nbsp; @endif
                                হিজাব: {{ $item->hijab }}
                            @endif
                        </div>
                        @endif
                    </td>
                    <td class="p-center">{{ $item->quantity }}</td>
                    <td class="p-right">{{ currency() }}{{ number_format($item->price, 2) }}</td>
                    <td class="p-right">{{ currency() }}{{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-summary-wrap">
            <table class="p-table p-summary-table">
                <tbody>
                    <tr><th>Subtotal</th><td class="p-right">{{ currency() }}{{ number_format($order->total, 2) }}</td></tr>
                    <tr><th>Delivery</th><td class="p-right">{{ currency() }}{{ number_format($order->delivery_charge ?? 0, 2) }}</td></tr>
                    @if(($order->coupon ?? 0) > 0)
                    <tr><th>Coupon</th><td class="p-right">-{{ currency() }}{{ number_format($order->coupon, 2) }}</td></tr>
                    @endif
                    <tr><th>Paid</th><td class="p-right">{{ currency() }}{{ number_format($order->paid ?? 0, 2) }}</td></tr>
                    <tr><th>Due</th><td class="p-right">{{ currency() }}{{ number_format($order->total - ($order->paid ?? 0), 2) }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</div>{{-- /inv-wrap --}}
</div>{{-- /inv-page --}}

{{-- Toast --}}
<div id="invToast">
    <i id="invToastIcon" class="fa fa-check-circle"></i>
    <span id="invToastMsg"></span>
</div>

<script>
function showToast(msg, type='success') {
    const t = document.getElementById('invToast');
    document.getElementById('invToastMsg').textContent = msg;
    document.getElementById('invToastIcon').className  = type === 'success' ? 'fa fa-check-circle' : 'fa fa-times-circle';
    t.style.background = type === 'success' ? '#1B3A6B' : '#dc2626';
    t.classList.add('show');
    clearTimeout(t._t);
    t._t = setTimeout(() => t.classList.remove('show'), 3000);
}

function updateStatus(field, value) {
    fetch("{{ route('admin.orders.updateStatus', $order->id) }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ field, value })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) showToast(field === 'payment_status' ? 'Payment status updated!' : 'Order status updated!');
        else showToast('Failed to update!', 'error');
    })
    .catch(() => showToast('Something went wrong!', 'error'));
}

document.getElementById('payment_status').addEventListener('change', function () { updateStatus('payment_status', this.value); });
document.getElementById('order_status').addEventListener('change',   function () { updateStatus('status', this.value); });

document.getElementById('printBtn').addEventListener('click', function () {
    const overlay = document.createElement('div');
    overlay.id = 'printOverlay';
    overlay.innerHTML = document.getElementById('printInvoice').innerHTML;
    document.body.appendChild(overlay);
    document.body.style.visibility = 'hidden';
    setTimeout(function () {
        window.print();
        setTimeout(function () {
            document.body.style.visibility = '';
            document.body.removeChild(overlay);
        }, 500);
    }, 150);
});
</script>
@endsection