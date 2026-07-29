@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('All Brands'))
@section('content')

<style>
    .all-brands-section {
        padding: 32px 0 60px;
        background: linear-gradient(180deg, #fff5f5 0%, #f7f7f8 180px);
    }

    /* ===== Header ===== */
    .all-brands-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .all-brands-eyebrow {
        display: inline-block;
        background: var(--primary, #FF0000);
        color: #fff;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 5px 16px;
        border-radius: 30px;
        margin-bottom: 10px;
    }

    .all-brands-title {
        font-weight: 900;
        font-size: 1.9rem;
        margin-bottom: 6px;
        color: #1c1c1c !important;
        letter-spacing: .3px;
    }

    .all-brands-title span {
        color: var(--primary, #FF0000);
    }

    .all-brands-subtitle {
        font-size: .88rem;
        color: #6b6b6b;
        margin: 0;
    }

    /* ===== Grid ===== */
    .brand-card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 18px;
    }

    /* ===== Card ===== */
    .brand-card {
        position: relative;
        background: #fff;
        border: 2px solid #ececec;
        border-radius: 18px;
        padding: 22px 14px 18px;
        text-align: center;
        text-decoration: none;
        transition: border-color .25s ease, box-shadow .25s ease, transform .25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        overflow: hidden;
    }

    .brand-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary, #FF0000), #ff6b6b);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .3s ease;
    }

    .brand-card:hover {
        border-color: var(--primary, #FF0000);
        box-shadow: 0 14px 30px rgba(255, 0, 0, 0.15);
        transform: translateY(-6px);
    }

    .brand-card:hover::before {
        transform: scaleX(1);
    }

    .brand-logo-wrap {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: #f7f7f8;
        border: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: transform .3s ease;
    }

    .brand-card:hover .brand-logo-wrap {
        transform: scale(1.08);
    }

    .brand-logo-wrap img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 10px;
    }

    .brand-card span {
        font-size: .88rem;
        font-weight: 800;
        color: #1c1c1c;
        line-height: 1.3;
    }

    .brand-card small {
        font-size: .7rem;
        color: #9ca3af;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ===== Empty state ===== */
    .all-brands-empty {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .all-brands-empty i {
        font-size: 2.4rem;
        margin-bottom: 12px;
        display: block;
        color: #d1d5db;
    }

    /* ===== Responsive ===== */
    @media (max-width: 576px) {
        .all-brands-section { padding: 20px 0 40px; }
        .all-brands-title { font-size: 1.35rem; }
        .all-brands-subtitle { font-size: .8rem; }

        .brand-card-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .brand-card { padding: 16px 8px 14px; border-radius: 14px; gap: 8px; }
        .brand-logo-wrap { width: 68px; height: 68px; }
        .brand-card span { font-size: .78rem; }
        .brand-card small { font-size: .62rem; }
    }
</style>

<section class="all-brands-section">
    <div class="container">

        <div class="all-brands-header">
           
            <h1 class="all-brands-title">{{ \App\Helpers\TranslateHelper::translate('সকল') }} <span>{{ \App\Helpers\TranslateHelper::translate('ব্র্যান্ড') }}</span></h1>
            <p class="all-brands-subtitle">{{ \App\Helpers\TranslateHelper::translate('আপনার পছন্দের ব্র্যান্ড বেছে নিন') }}</p>
        </div>

        @if($brands->isEmpty())
            <div class="all-brands-empty">
                <i class="fa-solid fa-tags"></i>
                <p class="mb-0">No brands found.</p>
            </div>
        @else
            <div class="brand-card-grid">
                @foreach($brands as $brand)
                <a href="{{ route('products', ['brand' => $brand->id]) }}" class="brand-card">
                    <div class="brand-logo-wrap">
                        @if($brand->logo)
                            <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}">
                        @else
                            <img src="https://placehold.co/150x150/1c1c1c/ffffff?text={{ urlencode($brand->name) }}&font=poppins" alt="{{ $brand->name }}">
                        @endif
                    </div>
                    <span>{{ $brand->name }}</span>
                </a>
                @endforeach
            </div>
        @endif

    </div>
</section>

@endsection