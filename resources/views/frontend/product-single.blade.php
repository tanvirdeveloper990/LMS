@extends('layouts.app')
@section('title', $item->slug)


    <style>
        html,
        body {
            overflow-x: hidden;


        }

        /* ===== Sticky Header Fix ===== */
        .site-header {
            position: fixed;
            left: 0;
            width: 100%;
            z-index: 1050;
            background: #fff;
            transition: top 0.3s ease;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1052;
            background: var(--dark);
            transition: transform 0.3s ease;
        }

        .top-bar.hide {
            transform: translateY(-100%);
        }

        .product-section {
            padding: 70px 0 0;
        }

       
        .product-wrapper {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 20px;
        }

        @media (min-width: 992px) {
            .product-wrapper {
                padding: 40px;
            }
        }

        .gallery-col {
            position: relative;
        }

        @media (min-width: 992px) {
            .gallery-col {
                position: sticky;
                top: 24px;
                align-self: flex-start;
            }
        }



        /* ---- Overflow fix: gallery column ke boundary te lock kora ---- */
        .gallery-col {
            min-width: 0;
            max-width: 100%;
            overflow: hidden;
        }

        .main-image-frame {
            position: relative;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            background: var(--white);
            overflow: hidden;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-image-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            padding: 0;
            opacity: 1;
            transition: opacity .25s ease, transform .5s ease;
        }

        .main-image-frame:hover img {
            transform: scale(1.06);
        }

        .main-image-frame img.fading {
            opacity: 0;
        }

        .discount-tag {
            position: absolute;
            top: 14px;
            left: 14px;
            background: var(--primary);
            color: var(--white);
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 13px;
            padding: 6px 12px;
            border-radius: 30px;
            box-shadow: var(--shadow-sm);
            z-index: 2;
        }

        /* ---- Thumbnail slider: boro box + slide (scrollbar dekha jabe na) ---- */
        .thumb-slider-wrap {
            margin-top: 12px;
            max-width: 100%;
            overflow: hidden;
        }

        .thumb-slider {
            display: flex;
            gap: 10px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            padding: 4px 2px;
            -ms-overflow-style: none;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }

        .thumb-slider::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .thumb-item {
            flex: 0 0 auto;
            width: 78px;
            height: 78px;
            border-radius: 8px;
            border: 2px solid transparent;
            overflow: hidden;
            cursor: pointer;
            background: var(--white);
            scroll-snap-align: start;
            transition: var(--transition);
            position: relative;
        }

        @media (min-width: 576px) {
            .thumb-item {
                width: 88px;
                height: 88px;
            }
        }

        @media (min-width: 992px) {
            .thumb-item {
                width: 92px;
                height: 92px;
            }
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: filter .25s ease, opacity .25s ease, transform .25s ease;
            filter: grayscale(60%);
            opacity: .55;
        }

        .thumb-item.active {
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
        }

        .thumb-item.active img {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.02);
        }

        .thumb-item:not(.active):hover img {
            filter: grayscale(20%);
            opacity: .8;
        }

        .product-title {
            font-family: var(--font-heading);
            font-weight: 700;
            /* font-size: 22px; */
            color: var(--dark);
            margin-bottom: 6px;
        }

        .product-title1 {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 22px;
            color: var(--dark);
            margin-bottom: 6px;
        }




        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: #000;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 30px;
            margin-bottom: 14px;
        }

        .price-row {
            display: flex;
            align-items: baseline;
            gap: 12px;
            padding: 16px 0;
            border-top: 1px dashed var(--border-color);
            border-bottom: 1px dashed var(--border-color);
            margin-bottom: 20px;
        }

        .old-price {
            font-family: var(--font-heading);
            font-size: 16px;
            color: var(--text-muted);
            text-decoration: line-through;
            font-weight: 500;
        }

        .new-price {
            font-family: var(--font-heading);
            font-size: 30px;
            color: var(--primary);
            font-weight: 800;
        }

        .save-note {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: -12px;
            margin-bottom: 20px;
        }

        .qty-cart-row {
            display: flex;
            align-items: stretch;
            gap: 12px;
            margin-bottom: 16px;
        }

.qty-box {
    display: flex;
    align-items: center;
    border: 1.5px solid var(--primary);
    border-radius: 8px;
    overflow: hidden;
    flex: 1 1 0;
    height: 44px;
}

.qty-box button {
    flex: 1;
    width: auto;
    height: 100%;
    background: var(--white);
    border: none;
    font-weight: 700;
    font-size: 17px;
    color: var(--dark);
    transition: var(--transition);
}

.qty-box button:hover {
    background: var(--primary-light);
    color: var(--primary);
}

.qty-box input {
    flex: 1;
    width: auto;
    min-width: 0;
    height: 100%;
    border: none;
    border-left: 1.5px solid var(--primary);
    border-right: 1.5px solid var(--primary);
    text-align: center;
    font-weight: 700;
    font-size: 14px;
    font-family: var(--font-heading);
}

.qty-box input:focus {
    outline: none;
}





.btn-buy-now {
    width: 100%;
    background: var(--primary);
    color: var(--white);
    border: none;
    margin-bottom: 5px;
    border-radius: var(--radius-sm);
    font-family: var(--font-heading);
    font-weight: 900;
    font-size: 16px;
    padding: 15px;
    transition: var(--transition);
    box-shadow: 0 6px 20px rgba(255, 0, 0, 0.35);
    position: relative;
    animation: buyNowPulse 1.8s ease-in-out infinite;
}

.btn-buy-now:hover {
    background: var(--primary-dark);
    box-shadow: 0 8px 26px rgba(255, 0, 0, 0.45);
    animation-play-state: paused;
}

.btn-buy-now:active {
    transform: scale(0.98);
}

/* ✅ Button stays still most of the cycle, then suddenly jumps (like a quick hop) every ~1.8s */
@keyframes buyNowPulse {
    0%, 78%, 100% {
        transform: scale(1) translateY(0);
        box-shadow: 0 6px 20px rgba(255, 0, 0, 0.35);
    }
    85% {
        transform: scale(1.08) translateY(-4px);
        box-shadow: 0 12px 28px rgba(255, 0, 0, 0.55);
    }
    92% {
        transform: scale(0.97) translateY(0);
        box-shadow: 0 6px 16px rgba(255, 0, 0, 0.4);
    }
}

        .feature-list {
            list-style: none;
            padding: 16px;
            margin: 22px 0 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            border: 1.5px dashed var(--primary);
            border-radius: 10px;
            background: rgba(var(--primary-rgb, 255, 0, 0), 0.03);
        }

        .feature-list li {
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .feature-list i {
            color: var(--primary);
            font-size: 15px;
            flex-shrink: 0;
        }

        /*  */
        .product-meta-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-color);
        }

        .product-meta-line .meta-sku,
        .product-meta-line .meta-points {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        .product-meta-line strong {
            color: var(--dark);
            font-weight: 600;
        }

        /* mobile: if space is tight, allow wrap without breaking layout */
        @media (max-width: 380px) {
            .product-meta-line {
                flex-wrap: wrap;
                row-gap: 6px;
            }
        }

        /*  */
        .selector-block {
            margin-bottom: 20px;
        }

        .selector-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 13px;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .selector-label .selected-value {
            color: #000;
            font-weight: 700;
        }

        .color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--primary);
        }

        .color-swatch {
            width: 64px;
            height: 64px;
            border-radius: 8px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border: 2px solid #e5e5e5;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
            transition: var(--transition);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .color-swatch img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .color-swatch:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: 0 6px 14px rgba(0, 0, 0, .15);
        }

        .color-swatch.active {
            border-color: var(--primary);
            border-width: 2px;
        }

        .color-swatch.active::after {
            content: '';
            position: absolute;
            inset: 0;
            border: 2px solid var(--primary);
            border-radius: 8px;
            pointer-events: none;
        }

        /* প্রথম swatch এর মতো নাম-ট্যাগ overlay (optional, image না থাকলে বা image-এর উপর নাম দেখাতে) */
        .color-swatch .swatch-label {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, .55);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            text-transform: capitalize;
            opacity: 0;
            visibility: hidden;
            transition: opacity .25s ease;
        }


        .color-swatch:hover .swatch-label {
            opacity: 1;
            visibility: visible;
        }

        /*  */

        .size-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .size-box {
            min-width: 46px;
            height: 42px;
            padding: 0 10px;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border-color);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 14px;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .size-box:hover {
            border-color: #000;
            color: #000;
        }

        .size-box.active {
            background: #292827;
            border-color: #292827;
            color: var(--white);
        }

        .order-quick-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 22px 0 16px;
        }

        .order-quick-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 10px;
            border-radius: var(--radius-sm);
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .order-quick-btn i {
            font-size: 16px;
        }

        .order-quick-btn.whatsapp-btn {
            background: #25D366;
            color: var(--white);
        }

        .order-quick-btn.whatsapp-btn:hover {
            background: #1eb856;
            color: var(--white);
        }

        .order-quick-btn.messenger-btn {
            background: #0084FF;
            color: var(--white);
        }

        .order-quick-btn.messenger-btn:hover {
            background: #006fd6;
            color: var(--white);
        }

        .call-cta-line {
            text-align: center;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 15px;
            color: var(--dark);
            background: var(--primary-light);
            border-radius: var(--radius-sm);
            padding: 10px 12px;
            margin-bottom: 18px;
        }

        .call-cta-line a {
            color: #25D366;
            text-decoration: none;
        }

        .call-cta-line i {
            color: #25D366;
            font-size: 1.3rem;
            margin-right: 6px;
            vertical-align: middle;
        }

        .share-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .share-label {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 12px;
            letter-spacing: .5px;
            color: var(--text-muted);
        }

        .share-icons {
            display: flex;
            gap: 8px;
        }

        .share-icon-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 13px;
            text-decoration: none;
            transition: var(--transition);
        }

        .share-icon-btn:hover {
            transform: translateY(-2px);
            opacity: .9;
        }

        .share-icon-btn.fb {
            background: #1877F2;
        }

        .share-icon-btn.wa {
            background: #25D366;
        }

        .share-icon-btn.copy {
            background: var(--text-muted);
            border: none;
            cursor: pointer;
        }

        .share-icon-btn.copy.copied {
            background: var(--primary);
        }

        /*  */



        .video-section {
            padding: 10px 0 60px;
        }

        .video-section-inner {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 22px;
            box-shadow: var(--shadow-sm);
        }

        /* ---- Desktop e video section soto/centered kora ---- */
        @media (min-width: 992px) {
            .video-section-inner {
                max-width: 650px;
                padding: 20px;
            }
        }

        .video-heading-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .video-heading-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .video-heading {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 17px;
            color: var(--dark);
            margin: 0;
        }

        .yt-card {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            border-radius: var(--radius-md);
            overflow: hidden;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            background: var(--dark);
        }

        .yt-card img.yt-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .85;
            transition: transform .5s ease;
        }

        .yt-card:hover img.yt-bg {
            transform: scale(1.04);
        }

        .yt-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, .55) 0%, rgba(0, 0, 0, .15) 35%, rgba(0, 0, 0, .15) 65%, rgba(0, 0, 0, .7) 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 16px 18px;
        }

        .yt-title-block {
            color: var(--white);
            max-width: 85%;
        }

        .yt-title-block h4 {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 15px;
            line-height: 1.3;
            margin: 0 0 4px;
            text-shadow: 0 2px 6px rgba(0, 0, 0, .4);
        }

        @media (min-width: 768px) {
            .yt-title-block h4 {
                font-size: 17px;
            }
        }

        .yt-title-block span {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            opacity: .9;
        }

        .yt-play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 56px;
            height: 40px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .35);
            transition: var(--transition);
        }

        @media (min-width: 768px) {
            .yt-play-btn {
                width: 62px;
                height: 44px;
            }
        }

        .yt-card:hover .yt-play-btn {
            background: var(--primary-dark);
            transform: translate(-50%, -50%) scale(1.08);
        }

        .yt-play-btn i {
            color: var(--white);
            font-size: 16px;
            margin-left: 3px;
        }

        @media (min-width: 768px) {
            .yt-play-btn i {
                font-size: 18px;
            }
        }

        .yt-bottom-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .yt-icon-group {
            display: flex;
            gap: 8px;
        }

        .yt-icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .18);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 12px;
        }

        .yt-watch-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, .95);
            color: var(--dark);
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 11px;
            padding: 6px 12px;
            border-radius: 30px;
        }

        .yt-watch-badge i {
            color: #ff0000;
            font-size: 15px;
        }

        .yt-card iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /*  */
        .video-info-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: stretch;
        }

        .video-info-row>.video-col,
        .video-info-row>.info-side-col {
            flex: 1 1 100%;
            min-width: 0;
        }

        @media (min-width: 992px) {

            .video-info-row>.video-col,
            .video-info-row>.info-side-col {
                flex: 1 1 0;
            }
        }

        .video-section-inner {
            height: 100%;
        }

        /* start */
        .showroom-block {
            min-width: 0;
            max-width: 100%;
        }

        .showroom-marquee-wrap {
            overflow: hidden;
            position: relative;
            max-width: 100%;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 6%, #000 94%, transparent 100%);
            mask-image: linear-gradient(90deg, transparent 0%, #000 6%, #000 94%, transparent 100%);
        }

        .showroom-track {
            display: flex;
            gap: 10px;
            width: max-content;
            will-change: transform;
            cursor: grab;
        }

        .showroom-item {
            text-align: center;
            flex: 0 0 auto;
            width: 140px;
        }

        @media (min-width: 768px) {
            .showroom-item {
                width: 160px;
            }
        }

        .showroom-item .showroom-img-frame {
            border-radius: var(--radius-sm);
            overflow: hidden;
            aspect-ratio: 4 / 3;
            border: 1px solid var(--border-color);
        }

        .showroom-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
            pointer-events: none;
            user-select: none;
        }

        .showroom-item:hover img {
            transform: scale(1.08);
        }

        .showroom-item .showroom-caption {
            font-size: 10px;
            color: #000;
            margin-top: 6px;
            line-height: 1.3;
            font-weight: 800;
        }

        @media (min-width: 768px) {
            .showroom-item .showroom-caption {
                font-size: 11px;
            }
        }

        /* start description */
        /* ===== Description Card ===== */
        .desc-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            width: 100%;
            box-sizing: border-box;
        }

        .desc-card-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 20px;
            background: var(--bg-light);
            border-bottom: 3px solid var(--primary);
        }

        .desc-card-header i {
            font-size: 15px;
            color: var(--primary);
        }

        .desc-card-header h3 {
            margin: 0;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 15px;
            color: var(--dark);
        }

        .desc-card-body {
            padding: 18px 20px 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .desc-feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .desc-feature-list li {
            display: flex !important;
            flex-wrap: wrap;
            align-items: flex-start;
            gap: 8px;
            font-size: 13px;
            line-height: 1.6;
            color: var(--dark);
            padding: 8px 0;
            border-bottom: 1px dashed var(--border-color);
            width: 100%;
            box-sizing: border-box;
            white-space: normal !important;
        }

        .desc-feature-list li:last-child {
            border-bottom: none;
        }

        .desc-feature-list li i {
            color: var(--primary);
            font-size: 13px;
            margin-top: 3px;
            flex-shrink: 0;
        }

        /* মূল fix — এখানেই আগের বার সমস্যা ছিল */
        .desc-feature-list li span {
            flex: 1 1 0%;
            min-width: 0;
            max-width: 100%;
            white-space: normal !important;
            word-break: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .desc-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            margin-top: 12px;
            padding: 10px;
            background: var(--bg-light);
            border: none;
            border-radius: 8px;
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 13px;
            color: var(--primary);
            cursor: pointer;
            transition: var(--transition);
            box-sizing: border-box;
        }

        .desc-toggle-btn:hover {
            background: var(--border-color);
        }

        .desc-toggle-btn i {
            font-size: 11px;
            transition: transform .3s ease;
        }

        .desc-toggle-btn.open i {
            transform: rotate(180deg);
        }

        .desc-feature-list li.desc-extra {
            display: none !important;
        }

        .desc-feature-list.expanded li.desc-extra {
            display: flex !important;
        }

        /* ===== Mobile Responsive ===== */
        @media (max-width: 480px) {
            .desc-card-header {
                padding: 12px 16px;
                gap: 8px;
            }

            .desc-card-header i {
                font-size: 13px;
            }

            .desc-card-header h3 {
                font-size: 13.5px;
            }

            .desc-card-body {
                padding: 14px 16px 16px;
            }

            .desc-feature-list li {
                font-size: 12px;
                line-height: 1.5;
                padding: 7px 0;
                gap: 6px;
            }

            .desc-feature-list li span {
                font-size: 12px;
            }

            .desc-feature-list li i {
                font-size: 12px;
                margin-top: 2px;
            }

            .desc-toggle-btn {
                font-size: 12px;
                padding: 9px;
            }
        }

        @media (max-width: 360px) {
            .desc-card-header h3 {
                font-size: 12.5px;
            }

            .desc-feature-list li,
            .desc-feature-list li span {
                font-size: 11.5px;
            }
        }


      .btn-add-carts {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 1 1 0;
    height: 44px;
    padding: 0 14px;
    background-color: #292827;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.2px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.btn-add-carts:active {
    transform: translateY(1px);
}

.btn-add-carts i {
    font-size: 13px;
}

        /*  */


       .desc-content-wrap {
    max-height: 90px;
    overflow: hidden;
    transition: max-height .35s ease;
    position: relative;
}
.desc-content-wrap::after {
    content: '';
    position: absolute;
    left: 0; right: 0; bottom: 0;
    height: 30px;
    background: linear-gradient(180deg, rgba(255,255,255,0) 0%, #fff 90%);
    pointer-events: none;
}
.desc-content-wrap.expanded {
    max-height: 3000px;
}
.desc-content-wrap.expanded::after {
    display: none;
}
.desc-content {
    font-size: 13px;
    line-height: 1.7;
    color: var(--dark);
}
.desc-content p { margin: 0 0 8px; }
.desc-content ul, .desc-content ol { margin: 0 0 8px; padding-left: 18px; }


/* ✅ Review video placeholder — না থাকলে এই box দেখাবে */
.yt-card-empty {
    cursor: default;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-light);
}
.yt-empty-inner {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: #9ca3af;
    text-align: center;
    padding: 20px;
}
.yt-empty-inner i {
    font-size: 34px;
    color: #d1d5db;
}
.yt-empty-inner p {
    font-size: 13px;
    font-weight: 600;
    margin: 0;
    color: #9ca3af;
}

@keyframes showroomScroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.showroom-track {
    display: flex;
    gap: 10px;
    width: max-content;
    animation: showroomScroll 40s linear infinite;
}
.showroom-marquee-wrap:hover .showroom-track {
    animation-play-state: paused;
}


.thumb-slider-wrap {
    margin-top: 12px;
    max-width: 100%;
    position: relative;
    display: flex;
    align-items: center;
    gap: 6px;
}

.thumb-slider {
    flex: 1;
    min-width: 0;
}

.thumb-nav-btn {
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid var(--border-color);
    background: var(--white);
    color: var(--dark);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 13px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
    transition: var(--transition);
    z-index: 2;
}

.thumb-nav-btn:hover {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

.thumb-nav-btn:disabled {
    opacity: .3;
    cursor: not-allowed;
    background: var(--white);
    color: var(--dark);
    border-color: var(--border-color);
}

@media (max-width: 480px) {
    .thumb-nav-btn {
        width: 28px;
        height: 28px;
        font-size: 11px;
    }
}

@media (max-width: 991px) {
    .product-section {
        padding-top: 20px; /* fixed header er actual height ja, oita bosao — 56 theke ektu kome dekho */
    }

    .product-wrapper {
        padding: 10px; /* left-right-top-bottom shob same rakho, eta already thik */
        border-radius: 10px;
    }

    .gallery-col {
        margin-bottom: 4px;
        margin-top: 0; /* extra top margin ba space thakle remove */
    }

    .thumb-slider-wrap {
        margin-top: 8px;
    }

    .info-col {
        margin-top: 10px;
    }
}
}
    </style>


@php
    $regularPrice = $item->regular_price;
    $salePrice    = $item->sale_price;
    $discountAmt  = $regularPrice > $salePrice ? round($regularPrice - $salePrice) : 0;
    $discountPct  = ($regularPrice > 0 && $salePrice < $regularPrice)
        ? round((($regularPrice - $salePrice) / $regularPrice) * 100) : 0;
    $totalStock   = $item->variants->sum('stock');
    $hasVariants  = $item->variants->count() > 0;

    $phone = preg_replace('/[^0-9]/', '', $setting->phone_one ?? '');
    $phone = preg_replace('/^880/', '', $phone);
    $phone = ltrim($phone, '0');
    $whatsappNumber = '880' . $phone;
@endphp

@php
    $reviewVideo = $item->review_video ?? null;
    $ytId = null;
    $isYoutube = false;
    $isFacebook = false;

    if ($reviewVideo) {
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $reviewVideo, $m)) {
            $isYoutube = true;
            $ytId = $m[1];
        } elseif (str_contains($reviewVideo, 'facebook.com') || str_contains($reviewVideo, 'fb.watch')) {
            $isFacebook = true;
        }
    }
@endphp

@php
    // ✅ Variant JSON — color, size, price, stock, image — সব JS selectColor/selectSize এর জন্য
    $variantData = $item->variants->map(function ($v) {
        return [
            'id'        => $v->id,
            'color_id'  => $v->color_id,
            'color'     => $v->color?->name,
            'size_id'   => $v->size_id,
            'size'      => $v->size?->name,
            'price'     => $v->price,
            'stock'     => $v->stock,
            'image'     => $v->image ? \Illuminate\Support\Facades\Storage::url($v->image) : null,
        ];
    });
@endphp

@section('content')

<main>

    <section class="product-section">
        <div class="container">
            <div class="product-wrapper">
                <div class="row g-0 g-lg-4">

                    {{-- ══ GALLERY ══ --}}
                    <div class="col-lg-6 gallery-col">
                        <div class="main-image-frame">
                            @if($discountPct > 0)
                            <span class="discount-tag">{{ $discountPct }}% ছাড়</span>
                            @endif
                            <img id="mainImage"
                                src="{{ Storage::url($item->featured_image_1) }}"
                                alt="{{ $item->name }}">
                        </div>

                        <div class="thumb-slider-wrap">
                            {{-- ✅ Prev/Next বাটন --}}
                            <button type="button" class="thumb-nav-btn thumb-prev" id="thumbPrev" aria-label="Previous">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>

                            <div class="thumb-slider" id="thumbSlider">

                                {{-- Featured images first (সবসময় static থাকবে) --}}
                                <div class="thumb-item active" data-img="{{ Storage::url($item->featured_image_1) }}">
                                    <img src="{{ Storage::url($item->featured_image_1) }}" alt="{{ $item->name }}">
                                </div>
                                @if($item->featured_image_2)
                                <div class="thumb-item" data-img="{{ Storage::url($item->featured_image_2) }}">
                                    <img src="{{ Storage::url($item->featured_image_2) }}" alt="{{ $item->name }}">
                                </div>
                                @endif

                                {{-- ✅ Color select করলে এই জায়গায় সেই color এর variant images যোগ হবে (JS দিয়ে) --}}
                                <div id="variantThumbs" style="display:contents;"></div>

                            </div>

                            <button type="button" class="thumb-nav-btn thumb-next" id="thumbNext" aria-label="Next">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ══ PRODUCT INFO ══ --}}
                    <div class="col-lg-6 info-col">

                        @if($hasVariants)
                            @if($totalStock > 0)
                            <span class="stock-badge"><i class="fa-solid fa-circle-check"></i> স্টকে আছে</span>
                            @else
                            <span class="stock-badge stock-out"><i class="fa-solid fa-circle-xmark"></i> স্টক নেই</span>
                            @endif
                        @endif

                        <h1 class="product-title1">{{ \App\Helpers\TranslateHelper::translate($item->name) }}</h1>

                        <div class="price-row">
                            @if($regularPrice > $salePrice)
                            <span class="old-price">{{ currency() }}{{ number_format($regularPrice, 2) }}</span>
                            @endif
                            <span class="new-price current-price">{{ currency() }}{{ number_format($salePrice, 2) }}</span>
                        </div>

                        <div class="product-meta-line">
                            <span class="meta-sku">ARTICLE: <strong>{{ $item->sku ?? 'N/A' }}</strong></span>
                            <span class="meta-points">এই পণ্যের পয়েন্ট: <strong>{{ $item->point ?? 0 }}</strong></span>
                        </div>

                        {{-- ── Color ── --}}
                        @if($item->variants->whereNotNull('color_id')->count() > 0)
                        <div class="selector-block">
                            <div class="selector-label">
                                কালার সিলেক্ট করুন: <span class="selected-value" id="selectedColor"></span>
                            </div>
                            <div class="color-options" id="colorOptions">
                                @foreach($item->variants->whereNotNull('color_id')->unique('color_id') as $variant)
                                <span class="color-swatch" onclick="selectColor(this)"
                                    data-color="{{ $variant->color->name }}"
                                    data-color-id="{{ $variant->color_id }}"
                                    data-price="{{ $variant->price }}">
                                    @if($variant->color->image)
                                        <img src="{{ Storage::url($variant->color->image) }}"
                                            alt="{{ $variant->color->name }}"
                                            style="display:block;width:100%;height:100%;object-fit:cover;border-radius:6px;">
                                    @else
                                        <span class="swatch-dot" style="display:inline-block;width:100%;height:100%;border-radius:6px;background:{{ $variant->color->code ?? '#000' }};"></span>
                                    @endif
                                    <span class="swatch-label">{{ $variant->color->name }}</span>
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- ── Size ── --}}
                        @if($item->variants->whereNotNull('size_id')->count() > 0)
                        <div class="selector-block" id="sizeSection" style="display:none;">
                            <div class="selector-label">
                                সাইজ সিলেক্ট করুন: <span class="selected-value" id="selectedSize"></span>
                            </div>
                            <div class="size-options" id="sizeOptions"></div>
                            <p id="variantStockInfo" class="mt-2"></p>
                        </div>
                        @endif

                        {{-- ── Qty + Cart ── --}}
                        <div class="qty-cart-row">
                            <div class="qty-box">
                                <button type="button" onclick="changeQty(-1)">−</button>
                                <input type="text" id="qtyInput" value="1" readonly>
                                <button type="button" onclick="changeQty(1)">+</button>
                            </div>
                            <button type="button" class="btn-add-carts orders-now"
                                data-id="{{ $item->id }}"
                                data-name="{{ $item->name }}"
                                data-slug="{{ $item->slug }}"
                                data-image="{{ Storage::url($item->featured_image_1) }}"
                                data-price="{{ $item->sale_price }}"
                                data-has-variant="{{ $hasVariants ? '1' : '0' }}">
                                <i class="fa-solid fa-cart-shopping me-2"></i>অ্যাড টু কার্ট
                            </button>
                        </div>

                        <button type="button" class="btn-buy-now" onclick="buyNow()">এখনই অর্ডার করুন</button>

                        <p class="call-cta-line">
                            <i class="fa-brands fa-whatsapp"></i>
                            যে কোন প্রয়োজনে হোয়াটসঅ্যাপ করুন:
                            <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank">{{ $setting->phone_one ?? '' }}</a>
                        </p>

                        <div class="share-row">
                            <span class="share-label">SHARE:</span>
                            <div class="share-icons">
                                @php $shareUrl = urlencode(request()->url()); @endphp
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                    onclick="window.open(this.href,'_blank');return false;" target="_blank"
                                    class="share-icon-btn fb" title="Share on Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="whatsapp://send?text={{ urlencode('Check out this product: ' . request()->url()) }}"
                                    onclick="if(!navigator.userAgent.match(/Mobile/)){window.open('https://wa.me/?text={{ urlencode('Check out this product: ' . request()->url()) }}','_blank');return false;}"
                                    class="share-icon-btn wa" title="Share on WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <button type="button" class="share-icon-btn copy" id="copyLinkBtn" onclick="copyProductLink()" title="Copy link">
                                    <i class="fa-solid fa-link"></i>
                                </button>
                            </div>
                        </div>

                        <p>
                        {!!$item->short_description!!}
                        </p>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="video-section">
        <div class="container">
            <div class="video-info-row">

                {{-- LEFT: Video (থাকলে video, না থাকলে placeholder) --}}
                <div class="video-col">
                    <div class="video-section-inner">
                        <div class="video-heading-row">
                            <span class="video-heading-icon"><i class="fa-solid fa-play"></i></span>
                            <h3 class="video-heading">প্রোডাক্ট ভিডিও</h3>
                        </div>

                        @if($isYoutube)
                        <div class="yt-card" id="ytCard" data-platform="youtube" data-video="{{ $ytId }}">
                            <img class="yt-bg" src="https://img.youtube.com/vi/{{ $ytId }}/maxresdefault.jpg" alt="{{ $item->name }}">

                            <div class="yt-overlay">
                                <div class="yt-title-block">
                                    <h4>{{ \Illuminate\Support\Str::limit($item->name, 60) }}</h4>
                                    <span>PRODUCT REVIEW</span>
                                </div>

                                <div class="yt-bottom-row">
                                    <div class="yt-icon-group">
                                        <span class="yt-icon-btn"><i class="fa-solid fa-share"></i></span>
                                        <span class="yt-icon-btn"><i class="fa-regular fa-clock"></i></span>
                                    </div>
                                    <span class="yt-watch-badge"><i class="fa-brands fa-youtube"></i> Watch on YouTube</span>
                                </div>
                            </div>

                            <span class="yt-play-btn"><i class="fa-solid fa-play"></i></span>
                        </div>

                        @elseif($isFacebook)
                        <div class="yt-card" id="ytCard" data-platform="facebook" data-video="{{ urlencode($reviewVideo) }}">
                            <div class="yt-overlay" style="background:linear-gradient(180deg, rgba(0,0,0,.55) 0%, rgba(0,0,0,.15) 35%, rgba(0,0,0,.15) 65%, rgba(0,0,0,.7) 100%);">
                                <div class="yt-title-block">
                                    <h4>{{ \Illuminate\Support\Str::limit($item->name, 60) }}</h4>
                                    <span>PRODUCT REVIEW</span>
                                </div>

                                <div class="yt-bottom-row">
                                    <div class="yt-icon-group">
                                        <span class="yt-icon-btn"><i class="fa-solid fa-share"></i></span>
                                        <span class="yt-icon-btn"><i class="fa-regular fa-clock"></i></span>
                                    </div>
                                    <span class="yt-watch-badge"><i class="fa-brands fa-facebook"></i> Watch on Facebook</span>
                                </div>
                            </div>

                            <span class="yt-play-btn"><i class="fa-solid fa-play"></i></span>
                        </div>

                        @else
                        {{-- ✅ Video না থাকলে placeholder box, layout ভাঙবে না --}}
                        <div class="yt-card yt-card-empty">
                            <div class="yt-empty-inner">
                                <i class="fa-solid fa-video-slash"></i>
                                <p>এই মুহূর্তে কোনো রিভিউ ভিডিও নেই</p>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

                {{-- RIGHT: Showroom + Description --}}
                <div class="info-side-col">

                    <div class="showroom-block">
                        <h4 class="showroom-heading">আমাদের শোরুম সমূহ:</h4>

                        @if($showrooms->isNotEmpty())
                        <div class="showroom-marquee-wrap" id="showroomMarquee">
                            <div class="showroom-track" id="showroomTrack">

                                @foreach($showrooms as $showroom)
                                <a href="{{ route('showroom.detail', $showroom->id) }}">
                                <div class="showroom-item">
                                    <div class="showroom-img-frame">
                                        <img src="{{ Storage::url($showroom->image) }}" alt="{{ $showroom->name }}">
                                    </div>
                                    <p class="showroom-caption">{{ $showroom->name }}</p>
                                </div>
                                </a>
                                @endforeach

                                @foreach($showrooms as $showroom)
                                <a href="{{ route('showroom.detail', $showroom->id) }}">
                                <div class="showroom-item" aria-hidden="true">
                                    <div class="showroom-img-frame">
                                        <img src="{{ Storage::url($showroom->image) }}" alt="">
                                    </div>
                                    <p class="showroom-caption">{{ $showroom->name }}</p>
                                </div>
                                </a>
                                @endforeach

                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="desc-card">
                        <div class="desc-card-header">
                            <i class="fa-solid fa-align-left"></i>
                            <h3>ডেসক্রিপশন</h3>
                        </div>

                        <div class="desc-card-body">
                            <div class="desc-content-wrap" id="descContentWrap">
                                <div class="desc-content" id="descContent">
                                    {!! $item->description ?? '<p>এই পণ্যের কোনো বিবরণ যোগ করা হয়নি।</p>' !!}
                                </div>
                            </div>

                            <button type="button" class="desc-toggle-btn" id="descToggleBtn" style="display:none;">
                                <span>আরও দেখুন</span> <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- ===================== RELATED PRODUCTS ===================== --}}
    @if($relatedProducts->isNotEmpty())
    <section class="deals-section">
        <div class="container">

            {{-- Header --}}
            <div class="deals-header d-flex align-items-center justify-content-between">
                <h2 class="deals-title">রিলেটেড <span>পণ্য</span></h2>
                @if($item->category)
                <a href="{{ route('products', ['category' => $item->category->id]) }}" class="btn-see-all">See All</a>
                @endif
            </div>

            {{-- Product Grid --}}
            <div class="row g-3 g-md-4">

                @foreach($relatedProducts->take(10) as $rp)
                @php
                    $rpDiscountAmt = $rp->regular_price - $rp->sale_price;
                    $rpDiscountPct = $rp->regular_price > 0
                        ? round(($rpDiscountAmt / $rp->regular_price) * 100)
                        : 0;

                    // ✅ Wishlist status check
                    $rpIsWishlisted = auth()->check()
                        ? auth()->user()->wishlists()->where('product_id', $rp->id)->exists()
                        : false;
                @endphp

                <div class="col-6 col-md-4 col-lg">
                    <div class="product-card">
                        <div class="product-img-wrap">
                            @if($rp->regular_price > $rp->sale_price)
                            <span class="discount-tag">-{{ $rpDiscountPct }}%</span>
                            @endif

                            {{-- ✅ Wishlist button — dynamic filled/outline heart --}}
                            <button class="wishlist-btn add-to-wishlist {{ $rpIsWishlisted ? 'active-wish' : '' }}"
                                data-id="{{ $rp->id }}">
                                <i class="bi {{ $rpIsWishlisted ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                            </button>

                            <a href="{{ route('product.single', $rp->slug) }}"
                            onclick="trackProductClick('{{ $rp->id }}', '{{ addslashes($rp->name) }}', {{ $rp->sale_price }}, 'related_products')">
                                <img src="{{ Storage::url($rp->featured_image_1) }}"
                                    alt="{{ $rp->name }}" class="img-default"
                                    onerror="this.src='https://via.placeholder.com/300x300/e5e7eb/6b7280?text=Product'">
                                @if($rp->featured_image_2)
                                <img src="{{ Storage::url($rp->featured_image_2) }}"
                                    alt="{{ $rp->name }}" class="img-hover"
                                    onerror="this.src='https://via.placeholder.com/300x300/e5e7eb/6b7280?text=Product'">
                                @else
                                <img src="{{ Storage::url($rp->featured_image_1) }}"
                                    alt="{{ $rp->name }}" class="img-hover"
                                    onerror="this.src='https://via.placeholder.com/300x300/e5e7eb/6b7280?text=Product'">
                                @endif
                            </a>
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">{{ \App\Helpers\TranslateHelper::translate($rp->name) }}</h3>
                            <div class="product-price">
                                @if($rp->regular_price > $rp->sale_price)
                                <span class="price-old">{{ currency() }}{{ number_format($rp->regular_price, 0) }}</span>
                                @endif
                                <span class="price-new">{{ currency() }}{{ number_format($rp->sale_price, 0) }}</span>
                            </div>
                            <div class="product-btn-group">
                            <button type="button" class="btn-order-now related-buy-now"
                                    data-id="{{ $rp->id }}"
                                    data-name="{{ $rp->name }}"
                                    data-slug="{{ $rp->slug }}"
                                    data-image="{{ Storage::url($rp->featured_image_1) }}"
                                    data-price="{{ $rp->sale_price }}">
                                    Order Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    @endif
</main>


@endsection

@section('script')

{{-- ── view_item Tracking ── --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // GTM — view_item
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ ecommerce: null });
        window.dataLayer.push({
            event     : 'view_item',
            page_type : 'product_detail',
            ecommerce : {
                currency : 'BDT',
                value    : {{ $item->sale_price }},
                items    : [{
                    item_id       : '{{ $item->id }}',
                    item_name     : '{{ addslashes($item->name) }}',
                    item_category : '{{ optional($item->category)->name }}',
                    price         : {{ $item->sale_price }},
                    quantity      : 1
                }]
            }
        });

    // Facebook Pixel — ViewContent
    fbq('track', 'ViewContent', {
        content_ids  : ['{{ $item->id }}'],
        content_name : '{{ addslashes($item->name) }}',
        content_type : 'product',
        value        : {{ $item->sale_price }},
        currency     : 'BDT'
    });
    });
</script>

<script>
    // ── ✅ trackProductClick — এই page-এ ব্যবহারের জন্য local define ──
    function trackProductClick(productId, productName, price, listName) {
        // GTM — select_item
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({ ecommerce: null });
        window.dataLayer.push({
            event     : 'select_item',
            page_type : 'listing',
            ecommerce : {
                item_list_name : listName,
                currency       : 'BDT',
                items          : [{
                    item_id        : String(productId),
                    item_name      : productName,
                    item_list_name : listName,
                    price          : price,
                    quantity       : 1
                }]
            }
        });

        // Facebook Pixel — ProductClick
        fbq('trackCustom', 'ProductClick', {
            content_ids  : [String(productId)],
            content_name : productName,
            content_type : 'product',
            value        : price,
            currency     : 'BDT',
            list_name    : listName
        });
    }
</script>


<script>
    // ✅ Variant data + default main image — selectColor/selectSize এখানে ব্যবহার করবে
    const allVariants        = @json($variantData);
    const defaultMainImage   = document.getElementById('mainImage').src;

    const regularPrice       = {{ $item->regular_price }};
    let selectedColorValue   = '';
    let selectedSizeValue    = '';
    let selectedColorId      = null;
    let selectedVariantPrice = {{ $item->sale_price }};
    let selectedVariantStock = null;

    // ── ✅ Thumbnail switch (event delegation — dynamically add হওয়া variant thumbs এর জন্যও কাজ করবে) ──
    document.getElementById('thumbSlider').addEventListener('click', function (e) {
        const thumb = e.target.closest('.thumb-item');
        if (!thumb) return;
        document.getElementById('mainImage').src = thumb.dataset.img;
        document.querySelectorAll('#thumbSlider .thumb-item').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    });

   // ── ✅ সব variant এর images (যেকোনো color) একসাথে বের করা, duplicate বাদ দিয়ে ──
    function getAllVariantImages() {
        const imgs = [];
        allVariants.forEach(function (v) {
            if (v.image && imgs.indexOf(v.image) === -1) {
                imgs.push(v.image);
            }
        });
        return imgs;
    }

    // ── ✅ Featured images এর পরে সব variant images বসানো (color/size select এর সাথে কোনো সম্পর্ক নেই, একবারই render হবে) ──
    function renderThumbnails() {
        const images    = getAllVariantImages();
        const container = document.getElementById('variantThumbs');
        container.innerHTML = '';

        images.forEach(function (img) {
            const div = document.createElement('div');
            div.className = 'thumb-item';
            div.dataset.img = img;
            div.innerHTML = '<img src="' + img + '" alt="{{ addslashes($item->name) }}">';
            container.appendChild(div);
        });

        if (typeof updateThumbNavButtons === 'function') updateThumbNavButtons();
    }

    // ── Price display update ──
    function updatePriceUI(newPrice) {
        selectedVariantPrice = parseFloat(newPrice);
        document.querySelector('.current-price').textContent = '{{ currency() }}' + selectedVariantPrice.toFixed(2);
    }

    // ── Color select ──
    function selectColor(el) {
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
        el.classList.add('active');

        selectedColorValue   = el.dataset.color;
        selectedColorId      = parseInt(el.dataset.colorId);
        selectedSizeValue    = '';
        selectedVariantStock = null;

        document.getElementById('selectedColor').textContent = selectedColorValue;
        if (el.dataset.price) updatePriceUI(el.dataset.price);

        const sizes     = allVariants.filter(v => Number(v.color_id) === selectedColorId && v.size_id !== null);
        const sizeBlock = document.getElementById('sizeSection');
        const sizeCont  = document.getElementById('sizeOptions');

        if (!sizeBlock || !sizeCont) {
            const cv = allVariants.find(v => Number(v.color_id) === selectedColorId);
            selectedVariantStock = cv ? cv.stock : 0;
            updateStockInfo();
            return;
        }

   if (sizes.length > 0) {
        sizeBlock.style.display = 'block';
        sizeCont.innerHTML = '';

        sizes.forEach(v => {
            const inStock = v.stock > 0;
            const span = document.createElement('span');
            span.className = 'size-box' + (inStock ? '' : ' size-disabled');
            span.dataset.size   = v.size;
            span.dataset.sizeId = v.size_id;
            span.dataset.price  = v.price;
            span.dataset.stock  = v.stock;
            span.dataset.image  = v.image || '';
            span.textContent    = v.size;
            if (inStock) {
                span.onclick = function () { selectSize(this); };
            }
            sizeCont.appendChild(span);
        });

        // ❌ auto-select first size বাদ দেওয়া হলো — ইউজার নিজে ক্লিক করলেই size select হবে
        document.getElementById('selectedSize').textContent = '';

    } else {
        sizeBlock.style.display = 'none';
        const cv = allVariants.find(v => Number(v.color_id) === selectedColorId);
        selectedVariantStock = cv ? cv.stock : 0;
    }

    updateStockInfo();
    }

   // ── Size select ──
    function selectSize(el) {
        document.querySelectorAll('.size-box').forEach(s => s.classList.remove('active'));
        el.classList.add('active');

        selectedSizeValue    = el.dataset.size;
        selectedVariantStock = parseInt(el.dataset.stock);
        document.getElementById('selectedSize').textContent = selectedSizeValue;
        if (el.dataset.price) updatePriceUI(el.dataset.price);

        // ✅ exact (color + size) variant-এর ছবি main image-এ বসাও + thumbnail slider এ ওই ছবিটা active করো
        if (el.dataset.image) {
            document.getElementById('mainImage').src = el.dataset.image;

            document.querySelectorAll('#thumbSlider .thumb-item').forEach(function (t) {
                t.classList.toggle('active', t.dataset.img === el.dataset.image);
            });

            // ✅ যে color সিলেক্টেড আছে, সেই color-swatch box-এর ছবিও
            // এই size-এর image দিয়ে update করে দাও (main image-এর মতোই)
            const activeSwatchImg = document.querySelector('.color-swatch.active img');
            if (activeSwatchImg) {
                activeSwatchImg.src = el.dataset.image;
            }
        }

        updateStockInfo();
    }

    function updateStockInfo() {
        const stockEl = document.getElementById('variantStockInfo');
        if (!stockEl) return;
        if (selectedVariantStock === null) { stockEl.innerHTML = ''; return; }
        stockEl.innerHTML = selectedVariantStock > 0
            ? '<span style="color:#22c55e;font-weight:600;">✓ In Stock</span>'
            : '<span style="color:#ef4444;font-weight:600;">✗ Out of Stock</span>';
    }

    // ── Qty ──
    function changeQty(diff) {
        const input = document.getElementById('qtyInput');
        let val = parseInt(input.value) + diff;
        if (val < 1) val = 1;
        input.value = val;
    }

    // ── ✅ Validate before add-to-cart / buy ──
    // color/size শুধুমাত্র তখনই require করবে যখন প্রোডাক্টে আসলেই সেই option থাকে।
    // আগে ভুলভাবে "কোনো variant থাকলেই" color চাওয়া হতো — যেসব প্রোডাক্টে শুধু size (color নাই)
    // বা কোনোটাই নাই, সেগুলোতেও ভুলভাবে কালার সিলেক্ট করতে বলতো। এখন ঠিক করা হলো।
    function validateBeforeOrder() {
        const hasColors = allVariants.some(v => v.color_id !== null && v.color_id !== undefined);
        const hasSizes  = allVariants.some(v => v.size_id !== null && v.size_id !== undefined);

        if (hasColors && !selectedColorValue) { toastr.warning('অনুগ্রহ করে কালার সিলেক্ট করুন।'); return false; }
        if (hasSizes && !selectedSizeValue)   { toastr.warning('অনুগ্রহ করে সাইজ সিলেক্ট করুন।');    return false; }
        if (selectedVariantStock !== null && selectedVariantStock <= 0) {
            toastr.error('দুঃখিত! এই পণ্যটি বর্তমানে স্টকে নেই।');
            return false;
        }
        return true;
    }

    // ── Buy Now → cart এ যোগ করে সরাসরি checkout page এ পাঠাবে ──
    function buyNow() {
        if (!validateBeforeOrder()) return;

        const qty = parseInt(document.getElementById('qtyInput').value) || 1;
        const item = {
            productId : {{ $item->id }},
            name      : '{{ addslashes($item->name) }}' + (selectedColorValue ? ' - ' + selectedColorValue : '') + (selectedSizeValue ? ' / ' + selectedSizeValue : ''),
            price     : selectedVariantPrice,
            image     : '{{ Storage::url($item->featured_image_1) }}',
            slug      : '{{ $item->slug }}',
            quantity  : qty,
            color     : selectedColorValue,
            size      : selectedSizeValue
        };

        let cart  = JSON.parse(localStorage.getItem('cart')) || [];
        let exist = cart.find(p => p.productId === item.productId && p.color === item.color && p.size === item.size);
        if (exist) { exist.quantity += qty; } else { cart.push(item); }
        localStorage.setItem('cart', JSON.stringify(cart));

        window.location.href = "{{ route('checkout') }}";
    }

    function copyProductLink() {
        navigator.clipboard.writeText(window.location.href)
            .then(() => toastr.success('লিংক কপি হয়েছে!'))
            .catch(() => toastr.error('কপি করা যায়নি'));
    }

  // ── ✅ Page load এ একবার সব variant images thumbnail এ বসিয়ে দেওয়া (color/size select নির্বিশেষে সবসময় থাকবে) ──
    document.addEventListener('DOMContentLoaded', function () {
        renderThumbnails();

        // ✅ প্রথম color auto-select (শুধু color, size না — size ইউজার নিজে ক্লিক করবে)
        const firstColorSwatch = document.querySelector('.color-swatch');
        if (firstColorSwatch) {
            selectColor(firstColorSwatch);
        }
    });
</script>


<script>
    // ── ✅ Review Video: YouTube/Facebook click-to-embed ──
    document.addEventListener('DOMContentLoaded', function () {
        const ytCard = document.getElementById('ytCard');
        if (ytCard) {
            ytCard.addEventListener('click', function () {
                const platform = this.dataset.platform;
                const videoId  = this.dataset.video;
                let embedHtml  = '';

                if (platform === 'youtube') {
                    embedHtml = '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1"'
                        + ' allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"'
                        + ' allowfullscreen></iframe>';
                } else if (platform === 'facebook') {
                    embedHtml = '<iframe src="https://www.facebook.com/plugins/video.php?href=' + videoId + '&show_text=0&autoplay=true"'
                        + ' style="border:none;overflow:hidden" scrolling="no" frameborder="0"'
                        + ' allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>';
                }

                if (embedHtml) {
                    this.innerHTML = embedHtml;
                }
            });
        }

    // ── ✅ Description: 2-line clamp + show more/less ──
    const descContent    = document.getElementById('descContent');
    const descToggleBtn  = document.getElementById('descToggleBtn');

    if (descContent && descToggleBtn) {
        // যদি content আসলেই ২ লাইনের বেশি হয়, তবেই বাটন দেখাবে
        if (descContent.scrollHeight > descContent.clientHeight + 2) {
            descToggleBtn.style.display = 'flex';
        }

        descToggleBtn.addEventListener('click', function () {
            const isExpanded = descContent.classList.toggle('expanded');
            this.classList.toggle('open');
            this.querySelector('span').textContent = isExpanded ? 'কম দেখুন' : 'আরও দেখুন';
        });
    }
    });
</script>

<script>
    // ── ✅ Related Products "Order Now" → cart এ add করে checkout এ পাঠাবে ──
    $(document).on('click', '.related-buy-now', function (e) {
        e.preventDefault();
        const btn = $(this);

        trackProductClick(
            btn.data('id'),
            btn.data('name'),
            parseFloat(btn.data('price')),
            'related_products'
        );

        const item = {
            productId : btn.data('id'),
            name      : btn.data('name'),
            price     : parseFloat(btn.data('price')),
            image     : btn.data('image'),
            slug      : btn.data('slug'),
            quantity  : 1,
            color     : '',
            size      : ''
        };

        let cart  = JSON.parse(localStorage.getItem('cart')) || [];
        let exist = cart.find(p => p.productId === item.productId && p.color === item.color && p.size === item.size);
        if (exist) { exist.quantity += 1; } else { cart.push(item); }
        localStorage.setItem('cart', JSON.stringify(cart));

        window.location.href = "{{ route('checkout') }}";
    });
</script>

<script>

// ── ✅ Description: pixel-based clamp + show more/less ──
const descWrap       = document.getElementById('descContentWrap');
const descContentEl  = document.getElementById('descContent');
const descToggleBtn2 = document.getElementById('descToggleBtn');

if (descWrap && descContentEl && descToggleBtn2) {
    if (descContentEl.scrollHeight > descWrap.clientHeight + 2) {
        descToggleBtn2.style.display = 'flex';
    }

    descToggleBtn2.addEventListener('click', function () {
        const isExpanded = descWrap.classList.toggle('expanded');
        this.classList.toggle('open');
        this.querySelector('span').textContent = isExpanded ? 'কম দেখুন' : 'আরও দেখুন';
    });
}
</script>


<script>
    // ── ✅ Thumbnail Slider Prev/Next Navigation ──
    (function () {
        const slider   = document.getElementById('thumbSlider');
        const prevBtn  = document.getElementById('thumbPrev');
        const nextBtn  = document.getElementById('thumbNext');
        if (!slider || !prevBtn || !nextBtn) return;

        const scrollAmount = 200; // এক ক্লিকে কতটুকু scroll হবে

        function updateNavButtons() {
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            prevBtn.disabled = slider.scrollLeft <= 5;
            nextBtn.disabled = slider.scrollLeft >= maxScroll - 5;
        }

        prevBtn.addEventListener('click', function () {
            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', function () {
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        slider.addEventListener('scroll', updateNavButtons);
        window.addEventListener('resize', updateNavButtons);

        // ✅ renderThumbnails() থেকে dynamically thumbs add হওয়ার পরও call করার জন্য global করা হলো
        window.updateThumbNavButtons = updateNavButtons;

        // Initial state
        updateNavButtons();
    })();
</script>

@endsection