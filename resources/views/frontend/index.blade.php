@extends('layouts.app')

@section('title', 'Home')

@section('content')

<main>





    <!-- ===================== BANNER SLIDER (custom, no external plugin) ===================== -->
    <section class="banner-section">
        <div class="container">
            <div class="banner-slider" id="bannerSlider">
                <div class="banner-track" id="bannerTrack">

                 @foreach($banner as $item)
                    <div class="banner-slide"
                        style="background-image:url('{{ Storage::url($item->image) }}')">
                        
                    </div>
                 @endforeach   

                </div>
                <div class="banner-dots" id="bannerDots">
                    <button class="active" data-index="0"></button>
                    <button data-index="1"></button>
                    <button data-index="2"></button>
                </div>
            </div>
        </div>
    </section>

   @php
    $marqueeTexts = array_filter([
        $setting->scrolling_text_1 ?? null,
        $setting->scrolling_text_2 ?? null,
        $setting->scrolling_text_3 ?? null,
    ]);

    if (empty($marqueeTexts)) {
        $marqueeTexts = [
            'Free Delivery on Orders Over ৳2000',
            'Cash on Delivery Available',
            '7 Days Easy Return & Exchange',
        ];
    }

    $marqueeSpeed    = $setting->marquee_speed ?? '40s';
    $marqueeTextColor = $setting->marquee_text_color ?? '#ffffff';
    $marqueeSepColor  = $setting->marquee_separator_color ?? '#D4AF37';
    $marqueeBgColor   = $setting->marquee_bg_color ?? '#1c1c1c';
@endphp

<style>
    .notice-marquee {
        background: {{ $marqueeBgColor }} !important;
    }
    .marquee-track {
        animation-duration: {{ $marqueeSpeed }} !important;
    }
    .notice-marquee .marquee-item {
        color: {{ $marqueeTextColor }} !important;
    }
    .notice-marquee .marquee-item i {
        color: {{ $marqueeSepColor }} !important;
    }
    .notice-marquee .marquee-item::after {
        background: {{ $marqueeSepColor }} !important;
    }
</style>

<!-- ===================== NOTICE MARQUEE BAR ===================== -->
<section class="notice-marquee">
    <div class="marquee-track">
        <div class="marquee-group">
            @foreach($marqueeTexts as $text)
            <span class="marquee-item">
                <i class="bi bi-star-fill"></i> {{ $text }}
            </span>
            @endforeach
        </div>
        <div class="marquee-group" aria-hidden="true">
            @foreach($marqueeTexts as $text)
            <span class="marquee-item">
                <i class="bi bi-star-fill"></i> {{ $text }}
            </span>
            @endforeach
        </div>
    </div>
</section>

<!-- ===================== new arrivals ===================== -->
@php
  $is_new = \App\Models\Product::where('is_new', 1)->where('status', 1)->latest()->get();
@endphp

  @if($is_new->count())
    <section class="deals-section new-arrivals">
        <div class="container">

            <!-- Header -->
            <div class="deals-header d-flex align-items-center justify-content-between">
                <h2 class="deals-title">নতুন <span>পণ্য</span></h2>
                <a href="{{ route('products', ['new' => 1]) }}" class="btn-see-all">আরও দেখুন</a>
            </div>

            <!-- Product Slider -->
            <div class="products-slider-wrap">

                <button class="slider-nav slider-prev" aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="products-slider">

                    <!-- Product Card 1 -->
                    @foreach($is_new as $item)
                    <div class="product-card">
                        <a href="{{ route('product.single', $item->slug) }}">
                            {{-- Discount Badge --}}

                           @php
                                $discount_amount = $item->regular_price - $item->sale_price;
                                $discount_percentage = $item->regular_price > 0 
                                    ? round(($discount_amount / $item->regular_price) * 100) 
                                    : 0;

                                // ✅ Wishlist status check
                                $isWishlisted = auth()->check()
                                    ? auth()->user()->wishlists()->where('product_id', $item->id)->exists()
                                    : false;
                            @endphp
                            <div class="product-img-wrap">
                                @if($item->regular_price > $item->sale_price)
                                <span class="discount-tag">-{{$discount_percentage}}%</span>
                                @endif

                               <button class="wishlist-btn add-to-wishlist {{ $isWishlisted ? 'active-wish' : '' }}"
                                    data-id="{{ $item->id }}"
                                    onclick="event.preventDefault();">
                                    <i class="bi {{ $isWishlisted ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                </button>

                                <img src="{{ Storage::url($item->featured_image_1) }}" alt="{{ $item->name }}" class="img-default">
                                 @if($item->featured_image_2)
                                <img src="{{ Storage::url($item->featured_image_2) }}" alt="{{ $item->name }}" class="img-hover">
                                @else
                                <img src="{{ Storage::url($item->featured_image_1) }}" alt="{{ $item->name }}" class="img-hover">
                                @endif
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">{{ $item->name }}</h3>
                                <div class="product-price">
                                    <span class="price-old">{{ currency() }}{{ number_format($item->regular_price, 2) }}</span>
                                    <span class="price-new">{{ currency() }}{{ number_format($item->sale_price, 2) }}</span>
                                </div>
                                <div class="product-btn-group">
                                    <button type="button" class="btn-order-now"
                                        onclick="trackProductClick('{{ $item->id }}', '{{ addslashes($item->name) }}', {{ $item->sale_price }}, 'new_arrival'); window.location.href='{{ route('product.single', $item->slug) }}';">
                                          Order Now  
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <!-- Card 1 End -->

                </div>

                <button class="slider-nav slider-next" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>

            </div>
            <!-- Product Slider End -->

        </div>
    </section>
  @endif



  <style>
    /* ✅ Mobile-এ Categories section 3 per row */
    @media (max-width: 767px) {
        .category-scroll {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 10px !important;
            overflow-x: visible !important;
        }
        .category-card {
            width: 100% !important;
            flex-shrink: unset !important;
        }
        .category-img-wrap {
            width: 100% !important;
            aspect-ratio: 1 / 1;
        }
        .category-card span {
            font-size: .72rem;
            padding: 6px 4px !important;
        }
    }
</style>


  <!-- ===================== POPULAR CATEGORIES ===================== -->
<section class="categories-section">
    <div class="container">
        <div class="section-title text-center">
            <h2>ক্যাটাগরি <span>সমূহ</span></h2>
        </div>

        <div class="category-scroll">
            @forelse($allPopularItems as $item)
            <a href="javascript:void(0)" class="category-card"
                data-type="{{ $item['type'] }}"
                data-id="{{ $item['id'] }}"
                data-name="{{ addslashes($item['name']) }}"
                onclick="openSizeMenu(this)">
                <div class="category-img-wrap">
                    @if(!empty($item['image']))
                    <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}">
                    @else
                    <img src="https://via.placeholder.com/200x150/f5f5f5/999999?text={{ urlencode($item['name']) }}" alt="{{ $item['name'] }}">
                    @endif
                </div>
                <span>{{ $item['name'] }}</span>
            </a>
            @empty
            <p class="text-muted">No popular categories found.</p>
            @endforelse
        </div>
    </div>
</section>

    <!-- popular category sidebar  -->
   <!-- ===================== CATEGORY SIZE OFFCANVAS MENU ===================== -->
    <div class="size-menu-overlay" id="sizeMenuOverlay"></div>
    <div class="size-menu-panel" id="sizeMenuPanel">

        <div class="size-menu-header">
            <span class="size-menu-title" id="sizeMenuCategoryName">MENU</span>
            <button class="size-menu-close" id="sizeMenuClose">
                <i class="bi bi-x"></i> CLOSE
            </button>
        </div>

        <div class="size-menu-toolbar">
            <span class="size-menu-hint">
                CHOOSE YOUR SIZE FOR BETTER AVAILABILITY <i class="bi bi-fire"></i>
            </span>

            <div class="size-btn-group" id="sizeBtnGroup">
                <span class="text-white-50 small">Loading sizes...</span>
            </div>
        </div>

        <div class="size-menu-body" id="sizeMenuBody">
            <p class="size-menu-placeholder">আপনার প্রয়োজনীয় পণ্য দেখতে সাইজ সিলেক্ট করুন</p>
        </div>

    </div>


<!-- ===================== all products ===================== -->
@if($allProducts->count())
<section class="deals-section new-arrivals">
    <div class="container">

        <!-- Header -->
        <div class="deals-header d-flex align-items-center justify-content-between">
            <h2 class="deals-title">সকল <span>পণ্য</span></h2>
            <a href="{{ route('products') }}" class="btn-see-all">আরও দেখুন</a>
        </div>

        <!-- Product Slider -->
        <div class="products-slider-wrap">

            <button class="slider-nav slider-prev" aria-label="Previous">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div class="products-slider">

                @foreach($allProducts as $item)
                @php
                    $discount_amount = $item->regular_price - $item->sale_price;
                    $discount_percentage = $item->regular_price > 0
                        ? round(($discount_amount / $item->regular_price) * 100)
                        : 0;

                    // ✅ Wishlist status check
                    $isWishlisted = auth()->check()
                        ? auth()->user()->wishlists()->where('product_id', $item->id)->exists()
                        : false;
                @endphp
                <div class="product-card">
                    <a href="{{ route('product.single', $item->slug) }}">
                        <div class="product-img-wrap">
                            @if($item->regular_price > $item->sale_price)
                            <span class="discount-tag">-{{ $discount_percentage }}%</span>
                            @endif

                            {{-- ✅ Wishlist button — dynamic filled/outline heart --}}
                            <button class="wishlist-btn add-to-wishlist {{ $isWishlisted ? 'active-wish' : '' }}"
                                data-id="{{ $item->id }}"
                                onclick="event.preventDefault();">
                                <i class="bi {{ $isWishlisted ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                            </button>

                            <img src="{{ Storage::url($item->featured_image_1) }}" alt="{{ $item->name }}" class="img-default">
                            @if($item->featured_image_2)
                            <img src="{{ Storage::url($item->featured_image_2) }}" alt="{{ $item->name }}" class="img-hover">
                            @else
                            <img src="{{ Storage::url($item->featured_image_1) }}" alt="{{ $item->name }}" class="img-hover">
                            @endif
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">{{ $item->name }}</h3>
                            <div class="product-price">
                                <span class="price-old">{{ currency() }}{{ number_format($item->regular_price, 2) }}</span>
                                <span class="price-new">{{ currency() }}{{ number_format($item->sale_price, 2) }}</span>
                            </div>
                            <div class="product-btn-group">
                                <button type="button" class="btn-order-now"
                                    onclick="trackProductClick('{{ $item->id }}', '{{ addslashes($item->name) }}', {{ $item->sale_price }}, 'all_products'); window.location.href='{{ route('product.single', $item->slug) }}';">
                                    Order Now
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>

            <button class="slider-nav slider-next" aria-label="Next">
                <i class="bi bi-chevron-right"></i>
            </button>

        </div>
        <!-- Product Slider End -->

    </div>
</section>
@endif
    

    <!-- ===================== popular brand ===================== -->
<section class="brands-section">
    <div class="container px-0">

        <!-- Header -->
        <div class="deals-header d-flex align-items-center justify-content-between">
            <h2 class="deals-title ms-2">জনপ্রিয় <span>ব্র্যান্ডসমূহ</span></h2>
            <a href="{{ route('brands') }}" class="btn-see-all me-2">আরও দেখুন</a>
        </div>

        @php
            $popularBrands = \App\Models\Brand::where('status', 1)->get();
        @endphp

        @if($popularBrands->count() > 0)
        <!-- Circle Marquee -->
        <div class="brands-marquee-outer">
            <div class="brands-marquee-track" id="brandsTrack">

                {{-- Original set --}}
                @foreach($popularBrands as $brand)
                <a href="{{ route('products', ['brand' => $brand->id]) }}" class="brand-item" aria-label="{{ $brand->name }}">
                    <div class="brand-circle">
                        @if($brand->logo)
                            <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}" loading="lazy">
                        @else
                            <img src="https://placehold.co/300x300/1c1c1c/ffffff?text={{ urlencode($brand->name) }}&font=poppins" alt="{{ $brand->name }}" loading="lazy">
                        @endif
                    </div>
                </a>
                @endforeach

                {{-- Duplicate set for seamless infinite loop (aria-hidden, no click needed but harmless if clicked) --}}
                @foreach($popularBrands as $brand)
                <a href="{{ route('products', ['brand' => $brand->id]) }}" class="brand-item" aria-hidden="true" tabindex="-1">
                    <div class="brand-circle">
                        @if($brand->logo)
                            <img src="{{ Storage::url($brand->logo) }}" alt="" loading="lazy">
                        @else
                            <img src="https://placehold.co/300x300/1c1c1c/ffffff?text={{ urlencode($brand->name) }}&font=poppins" alt="" loading="lazy">
                        @endif
                        
                    </div>
                </a>
                @endforeach

            </div>
        </div>
        @else
        <p class="text-muted text-center">No brands found.</p>
        @endif

    </div>
</section>


    <!-- ===================== our showroom ===================== -->
    <section class="deals-section showroom-section">
        <div class="container">

            <!-- Header -->
            <div class="deals-header d-flex align-items-center justify-content-between">
                <h2 class="deals-title">আমাদের <span>শোরুম সমূহ</span></h2>
                <a href="{{route('showrooms')}}" class="btn-see-all">আরও দেখুন</a>
            </div>

          <!-- Showroom Marquee -->
            <div class="showroom-marquee-wrap">
                <div class="showroom-marquee-track" id="showroomMarqueeTrack">

                    <!-- Set 1 -->
                    @foreach($showroom as $item)
                    <div class="showroom-card">
                        <a href="{{ route('showroom.detail', $item->id) }}">
                            <div class="showroom-img-wrap">
                                <img src="{{Storage::url($item->image)}}"
                                    alt="{{$item->name}}">
                            </div>
                            <span class="showroom-name">{{$item->name}}</span>
                        </a>
                    </div>
                    @endforeach

                </div>
            </div>

        </div>
    </section>



    <!-- ===== REVIEW SECTION ===== -->
    <section class="review-section">
        <div class="container">
            <div class="section-title-wrap mb-4">
                <h2>কাস্টমার রিভিউ</h2>
            </div>

            <div class="slides-wrapper">
                <div class="slides-track" id="slidesTrack">

                   <!-- Review Card -->
                    @foreach($review as $item)
                    <div class="slide-item">
                        <div class="review-card d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ $item->image ? Storage::url($item->image) : 'https://via.placeholder.com/56x56/e5e7eb/6b7280?text=U' }}"
                                    alt="{{ $item->name }}"
                                    class="reviewer-img">
                                <div>
                                    <h6 class="mb-1 fw-bold" style="font-size:.9rem;">{{ $item->name }}</h6>
                                    <div class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star {{ $i <= $item->star ? 'star-on' : 'star-off' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="review-body flex-grow-1">
                                <p>{{ $item->review_text }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div><!-- /slides-track -->
            </div><!-- /slides-wrapper -->

            <!-- Dots -->
            <div class="" id="sliderDots"></div>

        </div>
    </section>
    <!-- ===================== PERKS STRIP ===================== -->
    <section class="perks-strip">
        <div class="container">
            <div class="row text-center g-3">
                <div class="col-6 col-md-3">
                    <i class="bi bi-truck"></i>
                    <p>{{$setting->list_1}}<span>{{$setting->list_2}}</span></p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-patch-check"></i>
                    <p>{{$setting->list_3}}<span>{{$setting->list_4}}</span></p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-arrow-repeat"></i>
                    <p>{{$setting->list_5}}<span>{{$setting->list_6}}</span></p>
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-headset"></i>
                    <p>{{$setting->list_7}}<span>{{$setting->list_8}}</span></p>
                </div>
            </div>
        </div>
    </section>

</main>

@endsection

@section('script')
<script>
    function trackProductClick(productId, productName, price, listName) {
        // GTM — select_item
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            ecommerce: null
        });
        window.dataLayer.push({
            event: 'select_item',
            page_type: 'listing',
            ecommerce: {
                item_list_name: listName,
                currency: 'BDT',
                items: [{
                    item_id: String(productId),
                    item_name: productName,
                    item_list_name: listName,
                    price: price,
                    quantity: 1
                }]
            }
        });

        // Facebook Pixel — ViewContent (listing থেকে click)
        fbq('trackCustom', 'ProductClick', {
            content_ids: [String(productId)],
            content_name: productName,
            content_type: 'product',
            value: price,
            currency: 'BDT',
            list_name: listName
        });
    }


    function trackCategoryView(categoryId, categoryName) {
        // GTM — view_item_list
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            ecommerce: null
        });
        window.dataLayer.push({
            event: 'view_item_list',
            page_type: 'listing',
            ecommerce: {
                item_list_name: categoryName,
                item_list_id: String(categoryId)
            }
        });

        // Facebook Pixel
        fbq('trackCustom', 'CategoryView', {
            content_category: categoryName,
            content_ids: [String(categoryId)]
        });
    }
</script>
@endsection