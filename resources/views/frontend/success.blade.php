@extends('layouts.app')
@section('title', 'Order Success')
@section('content')

<style>
    :root {
        --brand-red: #FF0000;
        --brand-black: #000000;
        --brand-white: #ffffff;
    }

    body { background: #f5f5f5; }

    /* ── Single Main Card ── */
    .main-order-card {
        background: var(--brand-white);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,.08);
        border: 1px solid #eee;
    }

    /* ── Top Success Banner (inside main card) ── */
    .success-banner {
        background: var(--brand-black);
        padding: 2rem 1.5rem 1.75rem;
        text-align: center;
        position: relative;
    }
    .success-banner::after {
        content: "";
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 4px;
        background: var(--brand-red);
    }
    .success-icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--brand-red);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        box-shadow: 0 0 0 6px rgba(255,0,0,.15);
    }
    .success-icon-wrap i { color: var(--brand-white); font-size: 1.6rem; }
    .success-banner h2 {
        color: var(--brand-white);
        font-size: .92rem;
        font-weight: 600;
        line-height: 1.8;
        margin: 0 auto;
        max-width: 480px;
    }

    /* ── Section divider style ── */
    .order-section {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .order-section:last-child { border-bottom: none; }

    .section-title-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.1rem;
    }
    .section-title-row .icon-box {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: var(--brand-red);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .section-title-row .icon-box i { color: var(--brand-white); font-size: .8rem; }
    .section-title-row span {
        font-size: .82rem;
        font-weight: 800;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: var(--brand-black);
    }

    /* ── Info Grid (Invoice/Date/Phone/Total) ── */
    .info-grid {
        background: #fafafa;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eee;
    }
    .info-grid > div {
        padding: .9rem;
        border-right: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }
    .info-grid > div:nth-child(even) { border-right: none; }
    @media (min-width: 768px) {
        .info-grid > div:nth-child(even) { border-right: 1px solid #eee; }
        .info-grid > div:nth-child(4n) { border-right: none; }
    }
    .info-label { font-size: .68rem; color: #6b7280; margin-bottom: 3px; text-transform: uppercase; letter-spacing: .03em; }
    .info-value { font-weight: 800; font-size: .92rem; color: var(--brand-black); margin-bottom: 0; }
    .info-value.highlight { color: var(--brand-red); font-size: 1rem; }

    /* ── Payment Method row ── */
    .payment-method-row {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff5f5;
        border: 1.5px solid #ffcccc;
        border-radius: 12px;
        padding: .9rem 1rem;
        margin-top: 1rem;
    }
    .pay-icon-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: var(--brand-black);
        color: var(--brand-white);
        font-weight: 800;
        font-size: .8rem;
    }
    .payment-method-row.has-trx {
        flex-wrap: wrap;
    }
    .trx-details {
        width: 100%;
        display: flex;
        gap: 1.5rem;
        margin-top: .75rem;
        padding-top: .75rem;
        border-top: 1px dashed #ffb3b3;
    }

    /* ── Order Items ── */
    .item-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: .85rem 0;
        border-bottom: 1px solid #f3f3f3;
    }
    .item-row:last-of-type { border-bottom: none; }
    .item-thumb {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1.5px solid #ffe0e0;
        background: #fff5f5;
    }
    .item-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .variant-badge {
        border-radius: 999px;
        padding: 3px 10px;
        font-size: .68rem;
        font-weight: 600;
        background: var(--brand-black);
        color: var(--brand-white);
    }

    /* ── Totals box ── */
    .totals-box {
        background: var(--brand-black);
        border-radius: 12px;
        padding: 1rem 1.1rem;
        margin-top: 1rem;
    }
    .totals-row { display: flex; justify-content: space-between; font-size: .85rem; color: #ccc; margin-bottom: .5rem; }
    .totals-row span:last-child { color: var(--brand-white); font-weight: 600; }
    .grand-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: .75rem;
        margin-top: .25rem;
        border-top: 1.5px dashed #555;
    }
    .grand-total-row span:first-child { color: var(--brand-white); font-weight: 700; font-size: .9rem; }
    .grand-total-amount { font-weight: 900; color: var(--brand-red); font-size: 1.3rem; }

    /* ── Billing Address ── */
    .addr-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: .6rem 0;
    }
    .addr-row .icon-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #fff5f5;
        border: 1px solid #ffcccc;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .addr-row .icon-circle i { color: var(--brand-red); font-size: .72rem; }
    .addr-label { font-size: .68rem; color: #6b7280; margin-bottom: 1px; text-transform: uppercase; letter-spacing: .03em; }
    .addr-value { font-size: .875rem; font-weight: 700; color: var(--brand-black); margin-bottom: 0; }

    /* ── Go Home Button (inside card, bottom section) ── */
    .btn-go-home {
        display: block;
        width: 100%;
        text-align: center;
        font-weight: 800;
        padding: 14px;
        border-radius: 12px;
        font-size: .9rem;
        letter-spacing: .02em;
        background: var(--brand-red);
        color: var(--brand-white);
        border: none;
        transition: background .2s ease;
        text-decoration: none;
    }
    .btn-go-home:hover {
        background: var(--brand-black);
        color: var(--brand-white);
    }
</style>

<main style="min-height:100vh;padding:2rem 0 3rem;">
<div class="container px-3 px-md-4">
<div class="row justify-content-center">
<div class="col-12 col-md-8 col-lg-7">

    <div class="main-order-card">

        {{-- ═══ Success Banner ═══ --}}
        <div class="success-banner">
            <div class="success-icon-wrap">
                <i class="fas fa-check"></i>
            </div>
            <h2>
                আপনার অর্ডারটি আমাদের কাছে সফলভাবে পৌঁছেছে, কিছুক্ষনের মধ্যে আমাদের একজন প্রতিনিধি আপনার নাম্বারে কল করবেন
            </h2>
        </div>

        {{-- ═══ SECTION 1: Order Details ═══ --}}
        <div class="order-section">
            <div class="section-title-row">
                <span class="icon-box"><i class="fas fa-receipt"></i></span>
                <span>Your Order Details</span>
            </div>

            <div class="row g-0 info-grid">
                <div class="col-6 col-md-3">
                    <p class="info-label">Invoice ID</p>
                    <p class="info-value">{{ $data->order_id }}</p>
                </div>
                <div class="col-6 col-md-3">
                    <p class="info-label">Date</p>
                    <p class="info-value">{{ $data->payment_date }}</p>
                </div>
                <div class="col-6 col-md-3">
                    <p class="info-label">Phone</p>
                    <p class="info-value">{{ $data->user->phone }}</p>
                </div>
                <div class="col-6 col-md-3">
                    <p class="info-label">Total</p>
                    <p class="info-value highlight">{{ currency() }}{{ number_format($data->total,2) }}</p>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="payment-method-row {{ in_array($data->payment_method, ['bkash','nagad']) ? 'has-trx' : '' }}">
                @if($data->payment_method === 'cod')
                    <span class="pay-icon-badge"><i class="fas fa-money-bill-wave"></i></span>
                    <div>
                        <p class="info-label mb-0">Payment Method</p>
                        <p class="addr-value">Cash on Delivery</p>
                    </div>
                @elseif($data->payment_method === 'bkash')
                    <span class="pay-icon-badge">B</span>
                    <div>
                        <p class="info-label mb-0">Payment Method</p>
                        <p class="addr-value">bKash</p>
                    </div>
                @elseif($data->payment_method === 'nagad')
                    <span class="pay-icon-badge">N</span>
                    <div>
                        <p class="info-label mb-0">Payment Method</p>
                        <p class="addr-value">Nagad</p>
                    </div>
                @else
                    <span class="pay-icon-badge"><i class="fas fa-credit-card"></i></span>
                    <div>
                        <p class="info-label mb-0">Payment Method</p>
                        <p class="addr-value">{{ $data->payment_method }}</p>
                    </div>
                @endif

                {{-- Payment number + Transaction ID — only for bKash / Nagad --}}
                @if(in_array($data->payment_method, ['bkash', 'nagad']))
                <div class="trx-details">
                    <div>
                        <p class="info-label mb-0">Sender Number</p>
                        <p class="addr-value">{{ $data->payment_number ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="info-label mb-0">Transaction ID</p>
                        <p class="addr-value">{{ $data->transaction_id ?? '—' }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ═══ SECTION 2: Order Items ═══ --}}
        <div class="order-section">
            <div class="section-title-row">
                <span class="icon-box"><i class="fas fa-box-open"></i></span>
                <span>Order Delivery</span>
            </div>

           @php $net_total = 0; @endphp
@foreach($data->orderItems as $item)
@php
    $net_total  += $item->quantity * $item->price;
    $variantInfo = is_array($item->product_variant_id)
                    ? $item->product_variant_id
                    : json_decode($item->product_variant_id, true);
    $vColor      = $variantInfo['color'] ?? null;
    $vSize       = $variantInfo['size']  ?? null;

    // ✅ এই প্রোডাক্টের জন্য কত point পাওয়া গেল
    $itemPoint = ($item->product ? (int) $item->product->point : 0) * $item->quantity;
@endphp
<div class="item-row">
    <div class="d-flex align-items-start gap-3">
        @if($item->product && $item->product->featured_image_1)
        <div class="item-thumb">
            <img src="{{ Storage::url($item->product->featured_image_1) }}" alt="{{ $item->product->name }}" />
        </div>
        @endif
        <div>
            <p class="fw-semibold mb-1" style="font-size:.875rem;color:#000;">
                {{ $item->product->name ?? 'Product' }}
            </p>

            @if($vColor || $vSize || $item->hijab)
            <div class="d-flex flex-wrap gap-1 mb-1">
                @if($vColor)<span class="variant-badge">{{ $vColor }}</span>@endif
                @if($vSize)<span class="variant-badge">{{ $vSize }}</span>@endif
                @if($item->hijab)
                <span class="variant-badge">
                    হিজাব: {{ $item->hijab }}
                    @if($item->hijab === 'সহ' && $item->hijab_price > 0)
                        (+{{ currency() }}{{ number_format($item->hijab_price, 2) }})
                    @endif
                </span>
                @endif
            </div>
            @endif

            <p class="mb-0 text-muted" style="font-size:.75rem;">
                Qty: {{ $item->quantity }} × {{ currency() }}{{ number_format($item->price, 2) }}
            </p>

            {{-- ✅ Per-item reward point --}}
            @if($itemPoint > 0)
            <p class="mb-0 mt-1" style="font-size:.72rem; color:var(--brand-red); font-weight:700;">
                <i class="fas fa-coins me-1"></i> +{{ $itemPoint }} pts earned
            </p>
            @endif
        </div>
    </div>
    <span class="fw-bold flex-shrink-0 ms-2 text-nowrap" style="color:var(--brand-red);font-size:.875rem;">
        {{ currency() }}{{ number_format($item->price * $item->quantity, 2) }}
    </span>
</div>
@endforeach

           {{-- Totals --}}
            <div class="totals-box">
                <div class="totals-row">
                    <span>Net Total</span>
                    <span>{{ currency() }}{{ number_format($net_total, 2) }}</span>
                </div>

                <div class="totals-row">
                    <span>Shipping Cost ({{ $data->delivery_area ?? 'N/A' }})</span>
                    <span>{{ currency() }}{{ number_format($data->delivery_charge, 2) }}</span>
                </div>

                @if($data->used_point > 0)
                <div class="totals-row mb-0" style="color:#4ade80;">
                    <span><i class="fas fa-coins me-1"></i> Points Used ({{ $data->used_point }} pts)</span>
                    <span style="color:#4ade80;">− {{ currency() }}{{ number_format($data->used_point, 2) }}</span>
                </div>
                @endif

                <div class="grand-total-row">
                    <span>Grand Total</span>
                    <span class="grand-total-amount">{{ currency() }}{{ number_format($data->total, 2) }}</span>
                </div>
            </div>

        {{-- ✅ Reward Points Summary Box --}}
        @if($data->total_point > 0 || $data->used_point > 0)
        <div class="mt-3 p-3 rounded-3" style="background:#fff5f5; border:1.5px solid #ffcccc;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-coins" style="color:var(--brand-red);"></i>
                <span class="fw-bold" style="font-size:.8rem; color:var(--brand-black); text-transform:uppercase; letter-spacing:.03em;">
                    Reward Points Summary
                </span>
            </div>

            <div class="d-flex flex-column gap-1">
                @if($data->used_point > 0)
                <div class="d-flex justify-content-between" style="font-size:.85rem;">
                    <span class="text-muted">Points Redeemed</span>
                    <span class="fw-bold" style="color:var(--brand-black);">
                        {{ $data->used_point }} pts (− {{ currency() }}{{ number_format($data->used_point, 2) }})
                    </span>
                </div>
                @endif

                @if($data->total_point > 0)
                <div class="d-flex justify-content-between" style="font-size:.85rem;">
                    <span class="text-muted">Points to Earn</span>
                    <span class="fw-bold" style="color:var(--brand-red);">
                        +{{ $data->total_point }} pts
                    </span>
                </div>
                <p class="mb-0 mt-1" style="font-size:.7rem; color:#9ca3af;">
                    <i class="fas fa-info-circle me-1"></i>
                    অর্ডার সম্পন্ন (complete) হলে এই পয়েন্ট আপনার অ্যাকাউন্টে যোগ হবে
                </p>
                @endif
            </div>
        </div>
        @endif
        </div>

        {{-- ═══ SECTION 3: Billing Address ═══ --}}
        <div class="order-section">
            <div class="section-title-row">
                <span class="icon-box"><i class="fas fa-map-marker-alt"></i></span>
                <span>Billing Address</span>
            </div>

            <div class="addr-row">
                <span class="icon-circle"><i class="fas fa-user"></i></span>
                <div>
                    <p class="addr-label">Name</p>
                    <p class="addr-value">{{ $data->user->name }}</p>
                </div>
            </div>
            <div class="addr-row">
                <span class="icon-circle"><i class="fas fa-phone"></i></span>
                <div>
                    <p class="addr-label">Phone</p>
                    <p class="addr-value">{{ $data->user->phone }}</p>
                </div>
            </div>

            @if($data->district)
            <div class="addr-row">
                <span class="icon-circle"><i class="fas fa-city"></i></span>
                <div>
                    <p class="addr-label">District</p>
                    <p class="addr-value">{{ $data->district->name }}</p>
                </div>
            </div>
            @endif

            @if($data->thana)
            <div class="addr-row">
                <span class="icon-circle"><i class="fas fa-location-dot"></i></span>
                <div>
                    <p class="addr-label">Thana / Upazila</p>
                    <p class="addr-value">{{ $data->thana->name }}</p>
                </div>
            </div>
            @endif

            @if($data->address)
            <div class="addr-row">
                <span class="icon-circle"><i class="fas fa-home"></i></span>
                <div>
                    <p class="addr-label">House / Road / Area</p>
                    <p class="addr-value">{{ $data->address }}</p>
                </div>
            </div>
            @endif

            @if($data->delivery_area)
            <div class="addr-row">
                <span class="icon-circle"><i class="fas fa-truck"></i></span>
                <div>
                    <p class="addr-label">Delivery Area</p>
                    <p class="addr-value">{{ $data->delivery_area }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- ═══ SECTION 4: Go Home Button ═══ --}}
        <div class="order-section">
            <a href="/" class="btn-go-home">
                <i class="fas fa-home me-2"></i> Go To Home
            </a>
        </div>

    </div>

</div>
</div>
</div>
</main>

@endsection


@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // GTM — purchase
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ ecommerce: null });
    window.dataLayer.push({
        event     : 'purchase',
        page_type : 'order_success',
        ecommerce : {
            transaction_id : '{{ $data->order_id }}',
            currency       : 'BDT',
            value          : {{ $data->total }},
            shipping       : {{ $data->delivery_charge }},
            items          : [
                @foreach($data->orderItems as $item)
                @php
                    $variantInfo = is_array($item->product_variant_id)
                        ? $item->product_variant_id
                        : json_decode($item->product_variant_id, true);
                    $vColor = $variantInfo['color'] ?? '';
                    $vSize  = $variantInfo['size']  ?? '';
                @endphp
                {
                    item_id      : '{{ $item->product_id }}',
                    item_name    : '{{ addslashes($item->product->name ?? "") }}',
                    price        : {{ $item->price }},
                    quantity     : {{ $item->quantity }},
                    item_variant : '{{ $vColor }}{{ $vSize ? " / ".$vSize : "" }}'
                }{{ !$loop->last ? ',' : '' }}
                @endforeach
            ]
        }
    });

    // Facebook Pixel — Purchase
    fbq('track', 'Purchase', {
        content_type : 'product',
        currency     : 'BDT',
        value        : {{ $data->total }},
        content_ids  : [
            @foreach($data->orderItems as $item)
            '{{ $item->product_id }}'{{ !$loop->last ? ',' : '' }}
            @endforeach
        ]
    });
});
</script>
@endsection