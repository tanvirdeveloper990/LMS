@extends('layouts.app')
@section('title', $showroom->name)
@section('content')

<style>
    /* ===== Showroom Detail Page ===== */
    .showroom-detail-section {
        padding: 24px 0 60px;
    }

    /* Breadcrumb */
    .showroom-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .82rem;
        color: #888;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .showroom-breadcrumb a {
        color: #888;
        text-decoration: none;
        transition: color .2s ease;
    }

    .showroom-breadcrumb a:hover {
        color: var(--primary);
    }

    .showroom-breadcrumb i {
        font-size: .65rem;
        color: #ccc;
    }

    .showroom-breadcrumb span {
        color: var(--primary);
        font-weight: 600;
    }

    /* Hero */
    .showroom-hero-img {
        width: 100%;
        height: 100%;
        min-height: 260px;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .showroom-hero-img img {
        width: 100%;
        height: 100%;
        min-height: 260px;
        object-fit: cover;
        display: block;
    }

    .showroom-info-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 14px;
        padding: 24px;
        height: 100%;
        box-shadow: var(--shadow-sm);
    }

    .showroom-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 12px;
    }

    .showroom-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 46px;
        height: 3px;
        background: var(--primary);
        border-radius: 2px;
    }

    .showroom-info-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 18px;
    }

    .showroom-info-item:last-child {
        margin-bottom: 0;
    }

    .showroom-info-item i {
        width: 36px;
        height: 36px;
        min-width: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: color-mix(in srgb, var(--primary) 10%, #fff);
        color: var(--primary);
        border-radius: 50%;
        font-size: .95rem;
    }

    .showroom-info-item .info-label {
        display: block;
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: var(--primary);
        margin-bottom: 3px;
    }

    .showroom-info-item p {
        margin: 0;
        font-size: .88rem;
        color: #444;
        line-height: 1.5;
    }

    /* Divider */
    .showroom-divider {
        border: none;
        border-top: 1px solid #eee;
        margin: 40px 0;
    }

    /* About + Map */
    .showroom-section-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 16px;
    }

    .showroom-about-text {
        font-size: .92rem;
        line-height: 1.75;
        color: #555;
        white-space: pre-line;
    }

    .showroom-map-frame {
        width: 100%;
        height: 260px;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .showroom-map-frame iframe {
        width: 100%;
        height: 100%;
        display: block;
    }

    /* ===== Video (16:9 aspect ratio) ===== */
    .showroom-video-frame {
        width: 100%;
        aspect-ratio: 16 / 9;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        background: #000;
        position: relative;
    }

    .showroom-video-frame video,
    .showroom-video-frame iframe {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        border: 0;
    }

    /* ===== Photo Gallery (matches video height) ===== */
    .showroom-gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 8px;
        aspect-ratio: 16 / 9;
    }

    .gallery-item {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        background: #f2f2f2;
        position: relative;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .35s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-item.gallery-more::after {
        content: attr(data-more);
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, .55);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 700;
    }

    /* ===== Responsive ===== */
    @media (max-width: 767.98px) {

        .showroom-hero-img,
        .showroom-hero-img img {
            min-height: 200px;
        }

        .showroom-title {
            font-size: 1.25rem;
        }

        .showroom-info-card {
            padding: 18px;
        }

        .showroom-map-frame {
            height: 200px;
        }

        .showroom-gallery-grid {
            gap: 6px;
            margin-top: 16px;
        }

        .gallery-item {
            border-radius: 6px;
        }
    }

    @media (min-width: 768px) {

        .showroom-hero-img,
        .showroom-hero-img img {
            min-height: 320px;
        }
    }

    @media (min-width: 1600px) {

        .showroom-hero-img,
        .showroom-hero-img img {
            min-height: 400px;
        }

        .showroom-map-frame {
            height: 320px;
        }

        .showroom-title {
            font-size: 1.75rem;
        }

        .showroom-gallery-grid {
            gap: 10px;
        }
    }

    /* ===== Gallery Lightbox ===== */
    .gallery-lightbox {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .92);
        z-index: 2000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .gallery-lightbox.active {
        display: flex;
    }

    .gallery-lightbox-stage {
        position: relative;
        width: 100%;
        max-width: 1000px;
        max-height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-lightbox-stage img {
        max-width: 100%;
        max-height: 82vh;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, .5);
        user-select: none;
    }

    .gallery-lightbox-close {
        position: absolute;
        top: -6px;
        right: 0;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .12);
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background .2s ease;
    }

    .gallery-lightbox-close:hover {
        background: rgba(255, 255, 255, .25);
    }

    .gallery-lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .12);
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        cursor: pointer;
        transition: background .2s ease;
    }

    .gallery-lightbox-nav:hover {
        background: rgba(255, 255, 255, .25);
    }

    .gallery-lightbox-prev {
        left: -60px;
    }

    .gallery-lightbox-next {
        right: -60px;
    }

    .gallery-lightbox-counter {
        position: absolute;
        bottom: -34px;
        left: 50%;
        transform: translateX(-50%);
        color: #ccc;
        font-size: .85rem;
        letter-spacing: .3px;
    }

    @media (max-width: 991.98px) {
        .gallery-lightbox-prev {
            left: 6px;
        }

        .gallery-lightbox-next {
            right: 6px;
        }

        .gallery-lightbox-close {
            top: 6px;
            right: 6px;
        }

        .gallery-lightbox-counter {
            bottom: -28px;
        }
    }
</style>

@php
    // gallery: max 6 tiles shown, last one becomes "+N More" overlay if there are extras
    // (the lightbox itself always has access to the FULL gallery, not just the 6 shown)
    $gallery      = $showroom->gallery_images ?? [];
    $galleryCount = count($gallery);
    $galleryShown = array_slice($gallery, 0, 6);
    $extraCount   = $galleryCount - 6;

    $placeholderImg = 'https://placehold.co/900x600/1c1c1c/ffffff?text=' . urlencode($showroom->name);
@endphp

<section class="showroom-detail-section">
    <div class="container">

        <!-- Breadcrumb -->
        <nav class="showroom-breadcrumb">
            <a href="/">Home</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('showrooms') }}">Showrooms</a>
            <i class="bi bi-chevron-right"></i>
            <span>{{ $showroom->name }}</span>
        </nav>

        <!-- Hero: Image + Info Card -->
        <div class="row g-4 showroom-hero-row">
            <div class="col-12 col-lg-7">
                <div class="showroom-hero-img">
                    <img src="{{ $showroom->image ? Storage::url($showroom->image) : $placeholderImg }}"
                        alt="{{ $showroom->name }}">
                </div>
            </div>
            <div class="col-12 col-lg-5">
                <div class="showroom-info-card">
                    <h1 class="showroom-title">{{ $showroom->name }}</h1>

                    @if($showroom->address)
                    <div class="showroom-info-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>
                            <span class="info-label">Address</span>
                            <p>{{ $showroom->address }}</p>
                        </div>
                    </div>
                    @endif

                    @if($showroom->phone)
                    <div class="showroom-info-item">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <span class="info-label">Phone</span>
                            <p><a href="tel:{{ $showroom->phone }}" class="text-decoration-none text-dark">{{ $showroom->phone }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($showroom->email)
                    <div class="showroom-info-item">
                        <i class="bi bi-envelope-fill"></i>
                        <div>
                            <span class="info-label">Email</span>
                            <p><a href="mailto:{{ $showroom->email }}" class="text-decoration-none text-dark">{{ $showroom->email }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($showroom->opening_hours || $showroom->opening_time)
                    <div class="showroom-info-item">
                        <i class="bi bi-clock-fill"></i>
                        <div>
                            <span class="info-label">Opening Hours</span>
                            <p>
                                @if($showroom->opening_hours){{ $showroom->opening_hours }}@endif
                                @if($showroom->opening_hours && $showroom->opening_time)<br>@endif
                                @if($showroom->opening_time){{ $showroom->opening_time }}@endif
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

       

        @if($showroom->showroom_video || $galleryCount)
        <hr class="showroom-divider">

        <!-- Video + Photo Gallery -->
        <div class="row g-4 showroom-media-row">
            @if($showroom->showroom_video)
            <div class="col-12 {{ $galleryCount ? 'col-lg-6' : '' }}">
                <h2 class="showroom-section-title">Showroom Video</h2>
                <div class="showroom-video-frame">
                    @if(str_contains($showroom->showroom_video, '<iframe'))
                        {!! $showroom->showroom_video !!}
                    @elseif(str_ends_with(strtolower($showroom->showroom_video), '.mp4'))
                        <video controls
                            poster="{{ $showroom->image ? Storage::url($showroom->image) : $placeholderImg }}">
                            <source src="{{ $showroom->showroom_video }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <iframe src="{{ $showroom->showroom_video }}" allowfullscreen loading="lazy"></iframe>
                    @endif
                </div>
            </div>
            @endif

            @if($galleryCount)
            <div class="col-12 {{ $showroom->showroom_video ? 'col-lg-6' : '' }}">
                <h2 class="showroom-section-title">Photo Gallery</h2>
                <div class="showroom-gallery-grid" id="showroomGalleryGrid">
                    @foreach($galleryShown as $index => $path)
                    <div class="gallery-item @if($index === 5 && $extraCount > 0) gallery-more @endif"
                        data-index="{{ $index }}"
                        @if($index === 5 && $extraCount > 0) data-more="+{{ $extraCount }} More" @endif>
                        <img src="{{ Storage::url($path) }}" alt="{{ $showroom->name }} - {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

         @if($showroom->description || $showroom->maps)
        <hr class="showroom-divider">

        <!-- About + Map -->
        <div class="row g-4 showroom-about-row">
            @if($showroom->description)
            <div class="col-12 col-lg-6">
                <h2 class="showroom-section-title">About This Showroom</h2>
                <p class="showroom-about-text">{!! $showroom->description !!}</p>
            </div>
            @endif

            @if($showroom->maps)
            <div class="col-12 col-lg-6">
                <h2 class="showroom-section-title">Location</h2>
                <div class="showroom-map-frame">
                    @if(str_contains($showroom->maps, '<iframe'))
                        {!! $showroom->maps !!}
                    @else
                        <iframe src="{{ $showroom->maps }}" width="100%" height="100%" style="border:0;"
                            allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endif

    </div>
</section>

@if($galleryCount)
<!-- ===================== Photo Gallery Lightbox ===================== -->
<div class="gallery-lightbox" id="galleryLightbox">
    <div class="gallery-lightbox-stage">
        <button type="button" class="gallery-lightbox-close" id="galleryLightboxClose" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>

        @if($galleryCount > 1)
        <button type="button" class="gallery-lightbox-nav gallery-lightbox-prev" id="galleryLightboxPrev" aria-label="Previous">
            <i class="bi bi-chevron-left"></i>
        </button>
        @endif

        <img src="" alt="{{ $showroom->name }}" id="galleryLightboxImg">

        @if($galleryCount > 1)
        <button type="button" class="gallery-lightbox-nav gallery-lightbox-next" id="galleryLightboxNext" aria-label="Next">
            <i class="bi bi-chevron-right"></i>
        </button>
        @endif

        <div class="gallery-lightbox-counter" id="galleryLightboxCounter"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        (function initGalleryLightbox() {
            try {
                var images = @json(array_map(fn($path) => Storage::url($path), $gallery));
                if (!images.length) return;

                var grid      = document.getElementById('showroomGalleryGrid');
                var lightbox  = document.getElementById('galleryLightbox');
                var lightImg  = document.getElementById('galleryLightboxImg');
                var counter   = document.getElementById('galleryLightboxCounter');
                var closeBtn  = document.getElementById('galleryLightboxClose');
                var prevBtn   = document.getElementById('galleryLightboxPrev');
                var nextBtn   = document.getElementById('galleryLightboxNext');
                if (!grid || !lightbox || !lightImg) return;

                var current = 0;

                function show(index) {
                    current = (index + images.length) % images.length;
                    lightImg.src = images[current];
                    if (counter) counter.textContent = (current + 1) + ' / ' + images.length;
                }

                function open(index) {
                    show(index);
                    lightbox.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }

                function close() {
                    lightbox.classList.remove('active');
                    document.body.style.overflow = '';
                }

                grid.addEventListener('click', function (e) {
                    var item = e.target.closest('.gallery-item');
                    if (!item) return;
                    var index = parseInt(item.getAttribute('data-index'), 10) || 0;
                    open(index);
                });

                if (closeBtn) closeBtn.addEventListener('click', close);
                if (prevBtn) prevBtn.addEventListener('click', function () { show(current - 1); });
                if (nextBtn) nextBtn.addEventListener('click', function () { show(current + 1); });

                lightbox.addEventListener('click', function (e) {
                    if (e.target === lightbox) close();
                });

                document.addEventListener('keydown', function (e) {
                    if (!lightbox.classList.contains('active')) return;
                    if (e.key === 'Escape') close();
                    if (e.key === 'ArrowLeft') show(current - 1);
                    if (e.key === 'ArrowRight') show(current + 1);
                });
            } catch (err) {
                console.error('Gallery lightbox error:', err);
            }
        })();
    });
</script>
@endif

@endsection