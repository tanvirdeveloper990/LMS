@extends('layouts.app')
@section('title', 'Checkout')

@section('content')

<style>
:root {
    --brand-red:   #E30613;
    --brand-black: #111111;
    --brand-white: #ffffff;
}

body { background: #f7f7f8; }

.checkout-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    background: #fafafa;
}
.checkout-input:focus {
    border-color: var(--brand-red);
    box-shadow: 0 0 0 3px rgba(227,6,19,0.15);
    background: #fff;
}
.checkout-input::placeholder {
    color: #9ca3af;
}
.section-card {
    background: #fff;
    border-radius: 0.75rem;
    box-shadow: 0 1px 6px rgba(0,0,0,0.07);
    margin-bottom: 1.25rem;
    overflow: hidden;
    border: 1px solid #f1f1f1;
}
.section-header {
    padding: 0.75rem 1.25rem;
    background: #f9fafb;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.section-header span {
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: #111827;
}
.section-header i { color: var(--brand-red); font-size: 0.75rem; }
.section-body { padding: 1.25rem; }

.cart-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    background: #f3f4f6;
    border-radius: 999px;
    padding: 0.15rem 0.6rem;
    font-size: 0.7rem;
    font-weight: 600;
    color: #374151;
}

.pay-card {
    flex: 1;
    min-width: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 14px 10px;
    border-radius: 14px;
    border: 2px solid #e5e7eb;
    cursor: pointer;
    transition: border-color .18s, background .18s;
    background: #fff;
    position: relative;
    user-select: none;
}
.pay-card.active-cod   { border-color: #22c55e; background: #f0fdf4; }
.pay-card.active-bkash { border-color: #E2136E; background: #fff0f6; }
.pay-card.active-nagad { border-color: #F6821F; background: #fff7ed; }
.pay-icon {
    width: 44px; height: 44px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 8px;
    font-weight: 700; color: #fff; font-size: 15px;
}
.pay-check {
    position: absolute; top: 8px; right: 8px;
    width: 18px; height: 18px;
    border-radius: 50%;
    display: none;
    align-items: center; justify-content: center;
}
.pay-check svg { width: 10px; height: 10px; }
.pay-info-box {
    border-radius: 12px;
    padding: 14px;
    margin-top: 14px;
    border: 1.5px solid;
    display: none;
}
.pay-number-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    border-radius: 8px;
    padding: 10px 12px;
    margin-bottom: 10px;
    border: 1px solid;
}
.trx-input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1.5px solid;
    font-size: 13px;
    outline: none;
    background: #fff;
    box-sizing: border-box;
}

.checkout-title-bar { width: 4px; height: 28px; border-radius: 999px; background: var(--brand-red); }

.co-summary-head {
    background: linear-gradient(135deg, var(--brand-black) 0%, #000 100%);
}
.co-badge-white {
    background: rgba(255,255,255,0.15);
    color: #fff;
}
.co-icon-gold { color: var(--brand-red); }
.co-grand-total { color: var(--brand-red); }
.co-shipping-info { background: #fdecea; }
.co-shipping-charge { color: var(--brand-red); }
.co-btn-apply { background: var(--brand-black); color: #fff; border: none; }
.co-confirm-btn {
    background: linear-gradient(135deg, var(--brand-red) 0%, #b8050f 100%);
    border: 1px solid var(--brand-red);
    color: #fff;
}
.co-confirm-btn:hover {
    background: linear-gradient(135deg, #b8050f 0%, var(--brand-red) 100%);
}
.co-confirm-btn i { color: #fff; }
.co-link { color: var(--brand-red); text-decoration: none; }
.co-link:hover { text-decoration: underline; }

/* ✅ Grid layout — controls order of sections per breakpoint */
.checkout-grid {
    display: grid;
    gap: 1.25rem;
    grid-template-columns: 1fr;
    grid-template-areas:
        "contact"
        "delivery"
        "summary"
        "payment"
        "points"
        "terms"
        "button";
}
.checkout-grid .section-card { margin-bottom: 0; }
.ga-contact  { grid-area: contact; }
.ga-delivery { grid-area: delivery; }
.ga-payment  { grid-area: payment; }
.ga-points   { grid-area: points; }
.ga-terms    { grid-area: terms; }
.ga-button   { grid-area: button; }
.ga-summary  { grid-area: summary; }

@media (min-width: 992px) {
    .checkout-grid {
        grid-template-columns: 7fr 5fr;
        column-gap: 1.5rem;
        row-gap: 1.25rem;
        align-items: start;
        grid-template-areas:
            "contact  summary"
            "delivery summary"
            "payment  summary"
            "points   summary"
            "terms    summary"
            "button   summary";
    }
}

@media (max-width: 576px) {
    .container { padding-left: 12px; padding-right: 12px; }

    h1.fs-3 { font-size: 1.3rem !important; line-height: 1.35; }

    .checkout-input {
        font-size: 0.85rem;
        padding: 0.65rem 0.75rem 0.65rem 2.15rem;
    }
    /* ✅ placeholder only — smaller so long placeholders don't get cut off */
    .checkout-input::placeholder {
        font-size: 0.7rem;
    }

    .section-header { padding: 0.6rem 1rem; }
    .section-header span { font-size: 0.7rem; }
    .section-body { padding: 1rem; }

    /* ✅ Payment card size ~1/3 komano holo */
    .pay-card { min-width: 0; padding: 7px 4px; border-radius: 10px; }
    .pay-icon { width: 24px; height: 24px; margin-bottom: 4px; }
    .pay-icon i { font-size: 10px !important; }
    .pay-card p { font-size: 8px !important; line-height: 1.15 !important; }
    .pay-card p + p { font-size: 7px !important; margin-top: 2px !important; }
    .pay-check { width: 14px; height: 14px; top: 5px; right: 5px; }
    .pay-check svg { width: 7px; height: 7px; }

    .pay-info-box { padding: 10px; }
    .pay-number-row { padding: 8px 10px; flex-wrap: wrap; gap: 6px; }
    .trx-input { font-size: 12px; }

    /* order summary should not float/stick on small screens */
    .ga-summary .position-sticky { position: static !important; top: auto !important; }

    .co-summary-head { padding: 0.65rem 1rem !important; }
    .co-summary-head h2 { font-size: 0.85rem !important; }

    #place-order { font-size: 0.9rem; padding: 0.8rem !important; }
}
</style>

<main class="bg-light min-vh-100">
<section class="container my-4 my-md-5 px-3 px-md-4 py-3">

    <div class="mb-4 d-flex align-items-center gap-3">
        <div class="checkout-title-bar"></div>
        <h1 class="fs-3 fw-bold text-dark mb-0">অর্ডার করতে নিচের তথ্য গুলো দিন</h1>
    </div>

    <div class="checkout-grid">

        {{-- Contact Info --}}
        <div class="ga-contact">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-user"></i>
                <span>যোগাযোগের তথ্য</span>
            </div>
            <div class="section-body d-flex flex-column gap-3">
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y text-muted small ms-3">
                        <i class="fas fa-user"></i>
                    </span>
                    <input id="name" type="text" placeholder="আপনার নাম " class="checkout-input" />
                </div>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y text-muted small ms-3">
                        <i class="fas fa-phone"></i>
                    </span>
                    <input id="phone" type="tel" placeholder="১১ ডিজিট মোবাইল নাম্বার " class="checkout-input" />
                </div>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y text-muted small ms-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <input id="address" type="text" placeholder="বাসা নম্বর, রোড নাম্বার, গ্রাম/মহল্লা, উপজেলা, জেলা " class="checkout-input" />
                </div>
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y text-muted small ms-3">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <input id="notes" type="text" placeholder="স্পেশাল  কিছু বলতে চাইলে লিখুন (অপশনাল)" class="checkout-input" />
                </div>
            </div>
        </div>
        </div>

        {{-- Shipping Area --}}
        <div class="ga-delivery">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-truck"></i>
                <span>ডেলিভার এলাকা </span>
            </div>
            <div class="section-body">
                <div class="position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y text-muted small ms-3" style="pointer-events:none;">
                        <i class="fas fa-location-dot"></i>
                    </span>
                    <select id="delivery_area"
                        onchange="onShippingChange(this)"
                        class="checkout-input"
                        style="padding-left:2.5rem; padding-right:2rem; appearance:none;">
                        <option value="" disabled selected>-- নির্বাচন করুন --</option>
                        @foreach($shipingAreas as $area)
                            <option value="{{ $area->text }}|{{ $area->amount }}">
                                {{ $area->text }} — {{ $area->amount > 0 ? '৳' . number_format($area->amount, 0) : 'ফ্রি' }}
                            </option>
                        @endforeach
                    </select>
                    <span class="position-absolute top-50 end-0 translate-middle-y text-muted small me-3" style="pointer-events:none;">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </div>
                <div id="shippingInfoBox" class="d-none mt-3 px-4 py-3 rounded-3 small co-shipping-info">
                    <span class="text-muted">ডেলিভারি চার্জ:</span>
                    <span id="shippingChargeText" class="fw-bold ms-1 co-shipping-charge"></span>
                </div>
            </div>
        </div>
        </div>

        {{-- RIGHT — Order Summary (appears above payment method on mobile) --}}
        <div class="ga-summary">
            <div class="bg-white rounded-3 shadow-sm overflow-hidden position-sticky" style="top:90px;">

                <div class="d-flex justify-content-between align-items-center px-4 py-3 co-summary-head">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-shopping-bag small co-icon-gold"></i>
                        <h2 class="fw-bold text-white mb-0" style="font-size:.9rem;">অর্ডার সারাংশ</h2>
                    </div>
                    <span id="cart-count-badge" class="small fw-semibold px-3 py-1 rounded-pill text-white co-badge-white">০ টি পণ্য</span>
                </div>

                <div id="cartItems1" class="overflow-auto p-3 d-flex flex-column gap-3 bg-light" style="max-height:380px;"></div>

                {{-- ✅ COUPON SECTION --}}
                <div class="px-4 pt-3">
                    <label class="small fw-semibold text-dark mb-2 d-block">কুপন কোড</label>
                    <div class="d-flex gap-2">
                        <input id="coupon-code" type="text" placeholder="কুপন কোড লিখুন" class="checkout-input" style="padding-left:1rem;">
                        <button id="apply-coupon" type="button" class="px-4 py-2 rounded-3 fw-bold co-btn-apply" style="white-space:nowrap;">প্রয়োগ করুন</button>
                    </div>
                    <p id="coupon-message" class="small mt-2 mb-0"></p>
                </div>

                <div class="px-4 py-3 border-top d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between small text-muted">
                        <span>সাবটোটাল</span>
                        <span id="cart-total" class="fw-semibold text-dark">৳ ০</span>
                    </div>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>ডেলিভারি চার্জ</span>
                        <span id="delivery-charge" class="fw-semibold text-dark">৳ ০</span>
                    </div>
                    {{-- ✅ COUPON DISCOUNT LINE --}}
                    <div class="d-flex justify-content-between small text-muted">
                        <span>কুপন ছাড়</span>
                        <span id="coupon-charge" class="fw-semibold text-dark">৳ ০</span>
                    </div>
                    <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">মোট পরিশোধযোগ্য</span>
                        <span id="grand-total" class="fw-bold co-grand-total" style="font-size:1.35rem;">৳ ০</span>
                    </div>
                </div>

            </div>
        </div>

        {{-- Payment Method --}}
        <div class="ga-payment">
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-credit-card"></i>
                <span>পেমেন্ট পদ্ধতি</span>
            </div>
            <div class="section-body">

                <div class="d-flex flex-wrap gap-2">

                    {{-- COD --}}
                    <div class="pay-card active-cod" onclick="selectCheckoutPayment('cod', this)">
                        <div class="pay-check" id="chk-cod" style="background:#22c55e; display:flex;">
                            <svg viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="pay-icon" style="background:#22c55e;">
                            <i class="fas fa-money-bill-wave" style="font-size:18px;"></i>
                        </div>
                        <p class="fw-bold mb-0" style="font-size:12px; color:#111827; line-height:1.2;">ক্যাশ অন ডেলিভারি</p>
                        <p class="mb-0 mt-1" style="font-size:10px; color:#9ca3af;">ডেলিভারির সময় পরিশোধ করুন</p>
                    </div>

                    {{-- bKash --}}
                    <div class="pay-card" onclick="selectCheckoutPayment('bkash', this)">
                        <div class="pay-check" id="chk-bkash" style="background:#E2136E;">
                            <svg viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="pay-icon" style="background:#E2136E;">B</div>
                        <p class="fw-bold mb-0" style="font-size:12px; color:#111827; line-height:1.2;">bKash</p>
                        <p class="mb-0 mt-1" style="font-size:10px; color:#9ca3af;">মোবাইল ব্যাংকিং</p>
                    </div>

                    {{-- Nagad --}}
                    <div class="pay-card" onclick="selectCheckoutPayment('nagad', this)">
                        <div class="pay-check" id="chk-nagad" style="background:#F6821F;">
                            <svg viewBox="0 0 10 10" fill="none"><polyline points="1.5,5 4,7.5 8.5,2.5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="pay-icon" style="background:#F6821F;">N</div>
                        <p class="fw-bold mb-0" style="font-size:12px; color:#111827; line-height:1.2;">Nagad</p>
                        <p class="mb-0 mt-1" style="font-size:10px; color:#9ca3af;">মোবাইল ব্যাংকিং</p>
                    </div>

                </div>

                {{-- bKash Info Box --}}
                <div id="bkash-info-box" class="pay-info-box" style="background:#fff0f6; border-color:#f9a8d4;">
                    <div style="background:#ffe4f0; border:1px solid #f9a8d4; border-radius:10px; padding:12px 14px; margin-bottom:12px;">
                        <div class="d-flex align-items-start gap-2">
                            <div style="width:28px; height:28px; border-radius:50%; background:#E2136E; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-comment-dots" style="color:#fff; font-size:11px;"></i>
                            </div>
                            <div>
                                <p style="font-size:12px; font-weight:700; color:#E2136E; margin-bottom:4px;">bKash-এ যেভাবে পেমেন্ট করবেন</p>
                                <p style="font-size:12px; color:#4b5563; line-height:1.6;">
                                    আপনার bKash অ্যাপ থেকে
                                    <strong style="color:#111827;">{{ $item->bkash_number ?? 'N/A' }}</strong>
                                    নম্বরে
                                    <strong style="color:#E2136E;" id="bkash-amount-hint-co">মোট টাকা</strong>
                                    Send Money করুন, তারপর নিচে তথ্য দিন।
                                </p>
                            </div>
                        </div>
                    </div>
                    <p style="font-size:11px; font-weight:700; color:#E2136E; margin-bottom:8px;">
                        <i class="fas fa-mobile-alt" style="margin-right:4px;"></i>bKash নম্বর:
                    </p>
                    <div class="pay-number-row" style="border-color:#f9a8d4;">
                        <span style="font-weight:700; font-size:14px; color:#111827; letter-spacing:.04em;">{{ $item->bkash_number ?? 'N/A' }}</span>
                        <button type="button" onclick="copyNum('{{ $item->bkash_number ?? '' }}')"
                            style="font-size:11px; font-weight:700; color:#E2136E; background:transparent; border:none; cursor:pointer; display:flex; align-items:center; gap:4px;">
                            <i class="fas fa-copy"></i> কপি করুন
                        </button>
                    </div>

                    <label class="d-block mb-2" style="font-size:11px; font-weight:700; color:#4b5563;">
                        আপনার bKash নম্বর <span style="color:#ef4444;">*</span>
                        <span class="fw-normal ms-1" style="color:#9ca3af;">(যে নম্বর থেকে টাকা পাঠিয়েছেন)</span>
                    </label>
                    <div class="position-relative mb-3">
                        <span class="position-absolute top-50 start-0 translate-middle-y ms-2" style="color:#9ca3af; font-size:12px;">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input type="tel" id="co-bkash-payment-number" placeholder="01XXXXXXXXX"
                            class="trx-input" style="border-color:#f9a8d4; padding-left:30px;"
                            onfocus="this.style.borderColor='#E2136E'"
                            onblur="this.style.borderColor='#f9a8d4'" />
                    </div>

                    <label class="d-block mb-2" style="font-size:11px; font-weight:700; color:#4b5563;">
                        ট্রানজেকশন আইডি <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" id="co-bkash-trx" placeholder="bKash ট্রানজেকশন আইডি লিখুন"
                        class="trx-input" style="border-color:#f9a8d4;"
                        onfocus="this.style.borderColor='#E2136E'"
                        onblur="this.style.borderColor='#f9a8d4'" />
                    <p class="mt-2 mb-0" style="font-size:10px; color:#9ca3af;">
                        <i class="fas fa-shield-alt me-1"></i>
                        Send Money complete হলে TrxID কপি করে এখানে দিন
                    </p>
                </div>

                {{-- Nagad Info Box --}}
                <div id="nagad-info-box" class="pay-info-box" style="background:#fff7ed; border-color:#fed7aa;">
                    <div style="background:#ffe8d0; border:1px solid #fed7aa; border-radius:10px; padding:12px 14px; margin-bottom:12px;">
                        <div class="d-flex align-items-start gap-2">
                            <div style="width:28px; height:28px; border-radius:50%; background:#F6821F; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-comment-dots" style="color:#fff; font-size:11px;"></i>
                            </div>
                            <div>
                                <p style="font-size:12px; font-weight:700; color:#F6821F; margin-bottom:4px;">Nagad-এ যেভাবে পেমেন্ট করবেন</p>
                                <p style="font-size:12px; color:#4b5563; line-height:1.6;">
                                    আপনার Nagad অ্যাপ থেকে
                                    <strong style="color:#111827;">{{ $item->nagad_number ?? 'N/A' }}</strong>
                                    নম্বরে
                                    <strong style="color:#F6821F;" id="nagad-amount-hint-co">মোট টাকা</strong>
                                    Send Money করুন, তারপর নিচে তথ্য দিন।
                                </p>
                            </div>
                        </div>
                    </div>
                    <p style="font-size:11px; font-weight:700; color:#F6821F; margin-bottom:8px;">
                        <i class="fas fa-mobile-alt" style="margin-right:4px;"></i>Nagad নম্বর:
                    </p>
                    <div class="pay-number-row" style="border-color:#fed7aa;">
                        <span style="font-weight:700; font-size:14px; color:#111827; letter-spacing:.04em;">{{ $item->nagad_number ?? 'N/A' }}</span>
                        <button type="button" onclick="copyNum('{{ $item->nagad_number ?? '' }}')"
                            style="font-size:11px; font-weight:700; color:#F6821F; background:transparent; border:none; cursor:pointer; display:flex; align-items:center; gap:4px;">
                            <i class="fas fa-copy"></i> কপি করুন
                        </button>
                    </div>

                    <label class="d-block mb-2" style="font-size:11px; font-weight:700; color:#4b5563;">
                        আপনার Nagad নম্বর <span style="color:#ef4444;">*</span>
                        <span class="fw-normal ms-1" style="color:#9ca3af;">(যে নম্বর থেকে টাকা পাঠিয়েছেন)</span>
                    </label>
                    <div class="position-relative mb-3">
                        <span class="position-absolute top-50 start-0 translate-middle-y ms-2" style="color:#9ca3af; font-size:12px;">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input type="tel" id="co-nagad-payment-number" placeholder="01XXXXXXXXX"
                            class="trx-input" style="border-color:#fed7aa; padding-left:30px;"
                            onfocus="this.style.borderColor='#F6821F'"
                            onblur="this.style.borderColor='#fed7aa'" />
                    </div>

                    <label class="d-block mb-2" style="font-size:11px; font-weight:700; color:#4b5563;">
                        ট্রানজেকশন আইডি <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="text" id="co-nagad-trx" placeholder="Nagad ট্রানজেকশন আইডি লিখুন"
                        class="trx-input" style="border-color:#fed7aa;"
                        onfocus="this.style.borderColor='#F6821F'"
                        onblur="this.style.borderColor='#fed7aa'" />
                    <p class="mt-2 mb-0" style="font-size:10px; color:#9ca3af;">
                        <i class="fas fa-shield-alt me-1"></i>
                        Send Money complete হলে TrxID কপি করে এখানে দিন
                    </p>
                </div>

            </div>
        </div>
        </div>

        {{-- Use Points --}}
        @auth
        <div class="ga-points">
        <div class="section-card">
            <div class="section-body">
                <p class="small mb-2">আপনার পয়েন্ট ব্যালেন্স: <strong id="pointsBalanceText">{{ $availablePoints ?? 0 }}</strong> (১ পয়েন্ট = {{ currency() }}১)</p>
                <div class="d-flex gap-2">
                    <input type="number" id="usePointsInput" min="0" max="{{ $availablePoints ?? 0 }}" placeholder="ব্যবহারের জন্য পয়েন্ট লিখুন" class="checkout-input" style="padding-left:1rem;">
                    <button type="button" id="applyPointsBtn" class="px-4 py-2 rounded-3 fw-bold co-btn-apply">প্রয়োগ করুন</button>
                </div>
                <p class="small text-muted mt-2 mb-0" id="pointsAppliedText"></p>
            </div>
        </div>
        </div>
        @endauth

        {{-- Terms --}}
        <div class="ga-terms">
        <div class="section-card">
            <div class="section-body py-3">
                <div class="d-flex align-items-start gap-3">
                   <input type="checkbox" id="co-terms" class="mt-1" style="accent-color:var(--brand-red); width:16px; height:16px;" />
                    <label class="small text-muted mb-0" for="co-terms" style="cursor:pointer; line-height:1.6;">
                        আমি
                        <a href="{{ route('delivery-policy') }}" class="fw-medium co-link">শর্তাবলী</a>,
                        <a href="{{ route('refund-policy') }}" class="fw-medium co-link">রিফান্ড নীতি</a> এবং
                        <a href="{{ route('privacy-policy') }}" class="fw-medium co-link">গোপনীয়তা নীতি</a>-তে সম্মত।
                    </label>
                </div>
            </div>
        </div>
        </div>

        {{-- Confirm Button --}}
        <div class="ga-button">
        <button id="place-order"
            class="w-100 fw-bold py-3 rounded-3 fs-6 shadow-sm d-flex align-items-center justify-content-center gap-2 co-confirm-btn">
            <i class="fas fa-check-circle"></i> অর্ডার নিশ্চিত করুন
        </button>
        </div>

    </div>
</section>
</main>

@endsection

@section('script')
{{-- JS অংশ — id/logic অপরিবর্তিত, শুধু ইউজারকে দেখানো টেক্সট বাংলায় করা হয়েছে --}}
<script>
const BD_PHONE_REGEX = /^(?:\+?880|0)1[3-9]\d{8}$/;

function isBdPhone(val) {
    return BD_PHONE_REGEX.test(val.trim());
}

function setFieldState(inputEl, valid, msg) {
    if (!inputEl) return;
    const wrap  = inputEl.parentElement;
    let   errEl = wrap.querySelector('.phone-err');
    if (errEl) errEl.remove();

    if (valid === null) {
        inputEl.style.borderColor = '';
        inputEl.style.boxShadow   = '';
        return;
    }
    if (valid) {
        inputEl.style.borderColor = '#22c55e';
        inputEl.style.boxShadow   = '0 0 0 2px rgba(34,197,94,0.15)';
    } else {
        inputEl.style.borderColor = '#ef4444';
        inputEl.style.boxShadow   = '0 0 0 2px rgba(239,68,68,0.15)';
        errEl = document.createElement('p');
        errEl.className = 'phone-err';
        errEl.style.cssText = 'font-size:11px;color:#ef4444;margin-top:4px;font-weight:600;';
        errEl.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>' +
            (msg || 'সঠিক ফোন নম্বর দিন (যেমন: 01XXXXXXXXX)');
        wrap.appendChild(errEl);
    }
}

function attachPhoneValidation(inputId) {
    const el = document.getElementById(inputId);
    if (!el) return;
    el.addEventListener('input', function () {
        const val = this.value.trim();
        if (!val) { setFieldState(this, null); return; }
        setFieldState(this, isBdPhone(val));
    });
    el.addEventListener('blur', function () {
        const val = this.value.trim();
        if (!val) { setFieldState(this, null); return; }
        setFieldState(this, isBdPhone(val), 'সঠিক ফোন নম্বর দিন নয়। ফরম্যাট: 01XXXXXXXXX');
    });
}
</script>

<script>
$(document).ready(function () {

    let currency              = '৳ ';
    let cart                  = JSON.parse(localStorage.getItem('cart')) || [];
    let deliveryCharge        = 0;
    let deliveryArea          = '';
    let couponAmount          = 0;
    let couponPercent         = 0;
    let couponCode            = '';
    let selectedPaymentMethod = 'cod';
    let usedPoint              = 0;
    const availablePoints      = {{ (int) ($availablePoints ?? 0) }};

    attachPhoneValidation('phone');
    attachPhoneValidation('co-bkash-payment-number');
    attachPhoneValidation('co-nagad-payment-number');

    function fireViewCart() {
        if (!cart || cart.length === 0) return;
        const total = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        const items = cart.map(item => ({
            item_id       : String(item.productId || item.id || ''),
            item_name     : item.name || '',
            price         : parseFloat(item.price) || 0,
            quantity      : item.quantity || 1,
            item_variant  : (item.color || '') + (item.size ? ' / ' + item.size : ''),
        }));
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ ecommerce: null });
        window.dataLayer.push({
            event: 'view_cart', page_type: 'checkout',
            ecommerce: { currency: 'BDT', value: total, items: items }
        });
        if (typeof fbq !== 'undefined') {
            fbq('track', 'ViewContent', {
                content_ids  : cart.map(i => String(i.productId || i.id || '')),
                content_type : 'product',
                value        : total,
                currency     : 'BDT',
                num_items    : cart.reduce((s, i) => s + i.quantity, 0),
            });
        }
    }

    function fireBeginCheckout() {
        if (!cart || cart.length === 0) return;
        const total = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        const payable = Math.max(0, total + deliveryCharge - couponAmount);
        const items = cart.map(item => ({
            item_id       : String(item.productId || item.id || ''),
            item_name     : item.name || '',
            price         : parseFloat(item.price) || 0,
            quantity      : item.quantity || 1,
            item_variant  : (item.color || '') + (item.size ? ' / ' + item.size : ''),
        }));
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ ecommerce: null });
        window.dataLayer.push({
            event: 'begin_checkout', page_type: 'checkout',
            ecommerce: { currency: 'BDT', value: payable, shipping: deliveryCharge, items: items }
        });
        if (typeof fbq !== 'undefined') {
            fbq('track', 'InitiateCheckout', {
                content_ids  : cart.map(i => String(i.productId || i.id || '')),
                content_type : 'product',
                value        : payable,
                currency     : 'BDT',
                num_items    : cart.reduce((s, i) => s + i.quantity, 0),
            });
        }
    }

    function firePurchase(orderId, payable) {
        const items = cart.map(item => ({
            item_id       : String(item.productId || item.id || ''),
            item_name     : item.name || '',
            price         : parseFloat(item.price) || 0,
            quantity      : item.quantity || 1,
            item_variant  : (item.color || '') + (item.size ? ' / ' + item.size : ''),
        }));
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ ecommerce: null });
        window.dataLayer.push({
            event: 'purchase', page_type: 'checkout',
            ecommerce: {
                transaction_id: String(orderId), currency: 'BDT',
                value: payable, shipping: deliveryCharge, items: items
            }
        });
        if (typeof fbq !== 'undefined') {
            fbq('track', 'Purchase', {
                content_ids  : cart.map(i => String(i.productId || i.id || '')),
                content_type : 'product',
                value        : payable,
                currency     : 'BDT',
                num_items    : cart.reduce((s, i) => s + i.quantity, 0),
            });
        }
    }

    window.onShippingChange = function(select) {
        const val = select.value;
        if (!val) return;
        const parts    = val.split('|');
        deliveryArea   = parts[0];
        deliveryCharge = parseFloat(parts[1]);
        document.getElementById('shippingInfoBox').classList.remove('d-none');
        document.getElementById('shippingChargeText').textContent = '৳' + parts[1];
        updateTotals();
    };

    window.selectCheckoutPayment = function(method, el) {
        selectedPaymentMethod = method;
        document.querySelectorAll('.pay-card').forEach(c => {
            c.classList.remove('active-cod', 'active-bkash', 'active-nagad');
            c.style.borderColor = '#e5e7eb';
            c.style.background  = '#fff';
        });
        document.getElementById('chk-cod').style.display    = 'none';
        document.getElementById('chk-bkash').style.display  = 'none';
        document.getElementById('chk-nagad').style.display  = 'none';
        document.getElementById('bkash-info-box').style.display = 'none';
        document.getElementById('nagad-info-box').style.display = 'none';

        if (method === 'cod') {
            el.classList.add('active-cod');
            document.getElementById('chk-cod').style.display = 'flex';
        } else if (method === 'bkash') {
            el.classList.add('active-bkash');
            document.getElementById('chk-bkash').style.display  = 'flex';
            document.getElementById('bkash-info-box').style.display = 'block';
        } else if (method === 'nagad') {
            el.classList.add('active-nagad');
            document.getElementById('chk-nagad').style.display  = 'flex';
            document.getElementById('nagad-info-box').style.display = 'block';
        }
    };

    window.copyNum = function(number) {
        if (!number) return;
        navigator.clipboard.writeText(number)
            .then(() => toastr.success('নম্বর কপি হয়েছে: ' + number))
            .catch(() => toastr.error('কপি করা যায়নি'));
    };

    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(); updateTotals();
    };
    window.decreaseQty = function(index) {
        if (cart[index].quantity > 1) { cart[index].quantity--; }
        else { cart.splice(index, 1); }
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(); updateTotals();
    };
    window.increaseQty = function(index) {
        cart[index].quantity++;
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(); updateTotals();
    };

    function renderCart() {
        $('#cart-count-badge').text(cart.length + ' টি পণ্য');
        let html = '';
        if (cart.length === 0) {
            html = `<div class="text-center py-5 text-muted">
                        <i class="fas fa-shopping-cart fs-2 mb-3 d-block"></i>
                        <p class="small mb-0">আপনার কার্ট খালি</p>
                    </div>`;
        } else {
            cart.forEach((item, i) => {
                let badges = '';
                if (item.color) badges += `<span class="cart-badge">${item.color}</span>`;
                if (item.size)  badges += `<span class="cart-badge">${item.size}</span>`;
                html += `
                <div class="bg-white rounded-3 border p-3 shadow-sm">
                    <div class="d-flex gap-3">
                        <div class="rounded-2 overflow-hidden border bg-light flex-shrink-0" style="width:64px;height:64px;">
                            <img src="${item.image || ''}" alt="${item.name}" class="w-100 h-100" style="object-fit:cover;"/>
                        </div>
                        <div class="flex-grow-1" style="min-width:0;">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <h4 class="fw-semibold small text-dark mb-0 flex-grow-1" style="line-height:1.3;">${item.name}</h4>
                                <button onclick="removeFromCart(${i})"
                                    class="flex-shrink-0 rounded-circle border-0 d-flex align-items-center justify-content-center"
                                    style="width:24px;height:24px;background:#fee2e2;color:#ef4444;font-size:11px;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            ${badges ? `<div class="d-flex flex-wrap gap-1 mt-1">${badges}</div>` : ''}
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex align-items-center gap-1 bg-light rounded-2 border overflow-hidden">
                                    <button onclick="decreaseQty(${i})" class="border-0 bg-transparent fw-bold small" style="width:28px;height:28px;">&minus;</button>
                                    <span class="text-center fw-bold small" style="width:28px;">${item.quantity}</span>
                                    <button onclick="increaseQty(${i})" class="border-0 bg-transparent fw-bold small" style="width:28px;height:28px;">&#43;</button>
                                </div>
                                <span class="fw-bold small co-grand-total">${currency}${(item.price * item.quantity).toFixed(2)}</span>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        }
        $('#cartItems1').html(html);
    }

    function updateTotals() {
        let total = cart.reduce((s, i) => s + (i.price * i.quantity), 0);

        // ✅ coupon amount percent থেকে calculate
        couponAmount = (couponPercent / 100) * total;

        let payable = Math.max(0, total + deliveryCharge - couponAmount - usedPoint);

        $('#cart-total').text(currency + total.toFixed(2));
        $('#delivery-charge').text(currency + deliveryCharge.toFixed(2));
        $('#coupon-charge').text(couponPercent > 0 ? '-' + currency + couponAmount.toFixed(2) + ' (' + couponPercent + '%)' : currency + '0.00');
        $('#grand-total').text(currency + payable.toFixed(2));

        const hint = '৳' + Math.round(payable);
        const bEl  = document.getElementById('bkash-amount-hint-co');
        const nEl  = document.getElementById('nagad-amount-hint-co');
        if (bEl) bEl.textContent = hint;
        if (nEl) nEl.textContent = hint;
    }

    // ✅ Apply Coupon
    $('#apply-coupon').click(function (e) {
        e.preventDefault();
        let code = $('#coupon-code').val().trim();
        let msg  = $('#coupon-message');

        if (!code) {
            msg.text('কুপন কোড লিখুন').css('color', '#ef4444');
            return;
        }

        $.post("{{ route('coupon.validate') }}", {
            _token: '{{ csrf_token() }}',
            coupon_code: code
        }, function (res) {
            if (res.valid) {
                couponPercent = parseFloat(res.amount);
                couponCode    = code;
                msg.text('কুপন প্রয়োগ হয়েছে (' + couponPercent + '%)').css('color', '#22c55e');
            } else {
                couponPercent = 0;
                couponCode    = '';
                msg.text(res.message || 'সঠিক কুপন নয়').css('color', '#ef4444');
            }
            updateTotals();
        }).fail(function () {
            msg.text('কিছু একটা সমস্যা হয়েছে').css('color', '#ef4444');
        });
    });

    $('#applyPointsBtn').click(function () {
        let total     = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        let requested = parseInt($('#usePointsInput').val()) || 0;

        if (requested < 0) requested = 0;
        if (requested > availablePoints) requested = availablePoints;
        if (requested > Math.floor(total)) requested = Math.floor(total);

        usedPoint = requested;
        $('#usePointsInput').val(usedPoint);
        $('#pointsAppliedText').text(usedPoint > 0 ? (usedPoint + ' পয়েন্ট প্রয়োগ হয়েছে (-' + currency + usedPoint + ')') : '');
        updateTotals();
    });

    setInterval(function () {
        let updated = JSON.parse(localStorage.getItem('cart')) || [];
        if (JSON.stringify(updated) !== JSON.stringify(cart)) {
            cart = updated; renderCart(); updateTotals();
        }
    }, 1000);

    renderCart();
    updateTotals();
    fireViewCart();

    const shippingSelect = document.getElementById('delivery_area');
    if (shippingSelect) {
        const options = shippingSelect.querySelectorAll('option[value]:not([value=""])');
        if (options.length === 1) {
            shippingSelect.value = options[0].value;
            onShippingChange(shippingSelect);
        }
    }

    $('#place-order').click(function () {
        if (cart.length === 0) { toastr.error('আপনার কার্ট খালি!'); return; }

        const name    = $('#name').val().trim();
        const phone   = $('#phone').val().trim();
        const address = $('#address').val().trim();
        const notes = $('#notes').val().trim();
        const terms   = document.getElementById('co-terms').checked;

        if (!name)    { toastr.warning('আপনার নাম লিখুন');            return; }
        if (!phone)   { toastr.warning('মোবাইল নাম্বার লিখুন');          return; }
        if (!isBdPhone(phone)) {
            toastr.warning('সঠিক মোবাইল নাম্বার দিন (যেমন: 01XXXXXXXXX)।');
            setFieldState(document.getElementById('phone'), false);
            document.getElementById('phone').focus();
            return;
        }
        if (!address)      { toastr.warning('আপনার ঠিকানা লিখুন');          return; }
        if (!deliveryArea) { toastr.warning('ডেলিভারি এলাকা নির্বাচন করুন');      return; }
        if (!terms)        { toastr.warning('অনুগ্রহ করে শর্তাবলীতে সম্মত হোন'); return; }

        let transactionId = '';
        let paymentNumber = '';

        if (selectedPaymentMethod === 'bkash') {
            paymentNumber = document.getElementById('co-bkash-payment-number').value.trim();
            transactionId = document.getElementById('co-bkash-trx').value.trim();
            if (!paymentNumber) { toastr.warning('আপনার bKash নম্বর দিন');    return; }
            if (!isBdPhone(paymentNumber)) {
                toastr.warning('সঠিক bKash নম্বর দিন (যেমন: 01XXXXXXXXX)।');
                setFieldState(document.getElementById('co-bkash-payment-number'), false);
                return;
            }
            if (!transactionId) { toastr.warning('bKash Transaction ID দিন'); return; }
        }
        if (selectedPaymentMethod === 'nagad') {
            paymentNumber = document.getElementById('co-nagad-payment-number').value.trim();
            transactionId = document.getElementById('co-nagad-trx').value.trim();
            if (!paymentNumber) { toastr.warning('আপনার Nagad নম্বর দিন');    return; }
            if (!isBdPhone(paymentNumber)) {
                toastr.warning('সঠিক Nagad নম্বর দিন (যেমন: 01XXXXXXXXX)।');
                setFieldState(document.getElementById('co-nagad-payment-number'), false);
                return;
            }
            if (!transactionId) { toastr.warning('Nagad Transaction ID দিন'); return; }
        }

        fireBeginCheckout();

        let total   = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        let payable = Math.max(0, total + deliveryCharge - couponAmount);

        let orderItems = cart.map(item => ({
            productId  : item.productId || item.id || item.product_id,
            id         : item.productId || item.id || item.product_id,
            variant_id : item.variantId || item.variant_id || null,
            quantity   : item.quantity,
            price      : item.price,
            name       : item.name,
            image      : item.image,
            color      : item.color  || '',
            size       : item.size   || '',
            brand      : item.brand  || '',
        }));

        let orderData = {
            _token          : '{{ csrf_token() }}',
            customer_name   : name,
            phone           : phone,
            address         : address,
            delivery_area   : deliveryArea,
            delivery_charge : deliveryCharge,
            payment_method  : selectedPaymentMethod,
            transaction_id  : transactionId,
            payment_number  : paymentNumber,
            coupon_code     : couponCode,
            coupon_amount   : couponAmount.toFixed(2),
            coupon_point    : 0,
            used_point      : usedPoint,
            items           : orderItems,
            total           : payable.toFixed(2),
        };

        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>প্রসেসিং হচ্ছে...');

        $.post('{{ route("order.store") }}', orderData, function (res) {
            if (res.success) {
                firePurchase(res.id, payable);
                localStorage.removeItem('cart');
                toastr.success('অর্ডার সফলভাবে সম্পন্ন হয়েছে!');
                window.location.href = '/success/' + res.id;
            }
        }).fail(function (xhr) {
            toastr.error('অর্ডার ব্যর্থ হয়েছে: ' + (xhr.responseJSON?.message || 'অজানা সমস্যা'));
            $('#place-order').prop('disabled', false).html('<i class="fas fa-check-circle"></i> অর্ডার নিশ্চিত করুন');
        });
    });

});
</script>
@endsection