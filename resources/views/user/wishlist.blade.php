@extends('user.layouts.app')

@section('content')

<style>
    :root {
        --brand-red:   #FF0000;
        --brand-black: #000000;
        --brand-white: #ffffff;
    }

    .wl-wrapper {
        padding: 40px 0;
        background: #f7f7f8;
    }
    .wl-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 16px;
        box-sizing: border-box;
    }

    .wl-header {
        text-align: center;
        margin-bottom: 36px;
    }
    .wl-header h2 {
        font-weight: 800;
        font-size: 1.6rem;
        margin: 0;
    }
    .wl-title-bar {
        width: 60px;
        height: 4px;
        background: var(--brand-red);
        margin: 12px auto 0;
        border-radius: 999px;
    }

    /* ✅ Pure CSS Grid — কোনো framework-এর উপর নির্ভর করে না */
    .wl-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    @media (min-width: 768px) {
        .wl-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (min-width: 992px) {
        .wl-grid { grid-template-columns: repeat(4, 1fr); }
    }

    .wl-card {
        background: var(--brand-white);
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        border: 1px solid #f1f1f1;
        transition: box-shadow .25s ease, transform .25s ease;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }
    .wl-card:hover {
        box-shadow: 0 14px 30px rgba(0,0,0,0.12);
        transform: translateY(-4px);
    }

    .wl-img-wrap {
        position: relative;
        width: 100%;
        /* ✅ aspect-ratio fallback — padding-top trick, সব ব্রাউজারে কাজ করে */
        padding-top: 100%;
        overflow: hidden;
        background: #f3f4f6;
    }
    .wl-img-wrap img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }
    .wl-card:hover .wl-img-wrap img {
        transform: scale(1.08);
    }

    .wl-discount-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 5;
        background: var(--brand-red);
        color: #fff;
        font-weight: 800;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 999px;
    }

    .wl-heart-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255,255,255,0.95);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        cursor: pointer;
        transition: transform .2s ease, background .2s ease;
        border: none;
        padding: 0;
    }
    .wl-heart-btn:hover {
        transform: scale(1.1);
        background: #fff0f0;
    }
    .wl-heart-btn i {
        font-size: 15px;
        color: var(--brand-red);
    }

    .wl-body {
        padding: 14px 16px 16px;
        display: flex;
        flex-direction: column;
        flex: 1;
        box-sizing: border-box;
    }

    .wl-title {
        font-size: .9rem;
        font-weight: 700;
        color: var(--brand-black);
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 2.5em;
        line-height: 1.25;
        margin-bottom: 8px;
        transition: color .2s ease;
    }
    .wl-title:hover { color: var(--brand-red); }

    .wl-price-old {
        font-size: .76rem;
        color: #9ca3af;
        text-decoration: line-through;
        margin-right: 6px;
    }
    .wl-price-new {
        font-size: 1rem;
        font-weight: 800;
        color: var(--brand-black);
    }

    .wl-order-btn {
        margin-top: 12px;
        width: 100%;
        background: var(--brand-red);
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 50px;
        font-weight: 700;
        font-size: .8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        transition: background .25s ease;
        box-sizing: border-box;
    }
    .wl-order-btn:hover {
        background: var(--brand-black);
        color: #fff;
    }

    .wl-empty-state {
        text-align: center;
        padding: 80px 20px;
        background: #f7f7f8;
    }
    .wl-empty-state img {
        width: 110px;
        height: 110px;
        opacity: .6;
        margin-bottom: 20px;
    }
    .wl-empty-btn {
        margin-top: 16px;
        display: inline-block;
        background: var(--brand-red);
        color: #fff;
        padding: 10px 28px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        transition: background .2s ease;
    }
    .wl-empty-btn:hover {
        background: var(--brand-black);
        color: #fff;
    }

    @media (max-width: 480px) {
        .wl-grid { gap: 12px; }
        .wl-title { font-size: .8rem; }
        .wl-price-new { font-size: .9rem; }
    }
</style>

@if ($wishlists->count())
<section id="wishlist-products" class="wl-wrapper">
    <div class="wl-container">

        <div class="wl-header">
            <h2><i class="fas fa-heart" style="color:var(--brand-red);"></i> My Wishlist</h2>
            <div class="wl-title-bar"></div>
        </div>

        <div class="wl-grid">
            @foreach ($wishlists as $wishlist)
                @php
                    $item = $wishlist->product;
                    if (!$item) continue;

                    $discount = 0;
                    if ($item->regular_price > 0 && $item->sale_price < $item->regular_price) {
                        $discount = round((($item->regular_price - $item->sale_price) / $item->regular_price) * 100);
                    }
                @endphp

                <div class="wl-card">

                    <div class="wl-img-wrap">
                        @if($discount > 0)
                        <span class="wl-discount-tag">-{{ $discount }}%</span>
                        @endif

                        <button type="button" class="wl-heart-btn add-to-wishlist" data-id="{{ $item->id }}">
                            <i class="fas fa-heart"></i>
                        </button>

                        <a href="{{ route('product.single', $item->slug) }}">
                            <img src="{{ Storage::url($item->featured_image_1) }}"
                                 alt="{{ $item->name }}"
                                 onerror="this.src='https://via.placeholder.com/400x400/e5e7eb/6b7280?text=Product'">
                        </a>
                    </div>

                    <div class="wl-body">
                        <a href="{{ route('product.single', $item->slug) }}" class="wl-title">
                            {{ $item->name }}
                        </a>

                        <div class="mb-1">
                            @if($item->regular_price > $item->sale_price)
                            <span class="wl-price-old">{{ currency() }}{{ number_format($item->regular_price, 2) }}</span>
                            @endif
                            <span class="wl-price-new">{{ currency() }}{{ number_format($item->sale_price, 2) }}</span>
                        </div>

                        <a href="{{ route('product.single', $item->slug) }}" class="wl-order-btn">
                            <i class="fas fa-shopping-cart"></i> Order Now
                        </a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</section>
@else
<div class="wl-empty-state">
    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076504.png" alt="Empty Wishlist">
    <h4 class="fw-bold" style="color:var(--brand-black);">Your wishlist is empty ❤️</h4>
    <p style="color:#6b7280;">Save your favorite products here to shop them later.</p>
    <a href="{{ route('index') }}" class="wl-empty-btn">
        Continue Shopping
    </a>
</div>
@endif

@endsection