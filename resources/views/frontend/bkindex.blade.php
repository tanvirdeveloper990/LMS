@extends('layouts.app')

@section('title', 'Home')

@section('content')

<style>
/* ── Product Card ─────────────────────────────────── */
.product-card {
    display: flex;
    flex-direction: column;
    background: #fff;
    border-radius: 0.75rem;
    border: 1px solid #f1f5f9;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    overflow: hidden;
    transition: box-shadow 0.25s, transform 0.25s;
    height: 100%;
}
.product-card:hover {
    box-shadow: 0 8px 28px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}
.product-card__img-wrap {
    position: relative;
    overflow: hidden;
    height: 220px;
    flex-shrink: 0;
    background: #fff;
}
@media (min-width: 768px) {
    .product-card__img-wrap { height: 280px; }
}
.product-card__img-wrap img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.product-card__img-primary   { transform: translateX(0); }
.product-card__img-secondary { transform: translateX(100%); }
.product-card:hover .product-card__img-primary   { transform: translateX(-100%); }
.product-card:hover .product-card__img-secondary { transform: translateX(0); }

.product-card__badge {
    position: absolute;
    top: 8px; left: 8px;
    background: #ef4444;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 99px;
    z-index: 10;
}
.product-card__body {
    padding: 12px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    border-top: 1px solid #f8fafc;
}
.product-card__title {
    font-size: 0.8125rem;
    font-weight: 600;
    color: #1f2937;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 36px;
    margin-bottom: 8px;
    transition: color 0.15s;
}
.product-card:hover .product-card__title { color: var(--color-primary, #EA4F0C); }
.product-card__price-row {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}
.product-card__price      { font-size: 1rem; font-weight: 800; color: #111827; }
.product-card__price-old  { font-size: 0.75rem; color: #9ca3af; text-decoration: line-through; }
.product-card__btn {
    width: 100%;
    background: var(--color-primary, #EA4F0C);
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    padding: 8px 12px;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    margin-top: auto;
}
.product-card__btn:hover {
    background: #111827;
    transform: scale(1.01);
}

/* ── Section Header ───────────────────────────────── */
.section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    position: relative;
}
.section-header::before {
    content: '';
    position: absolute;
    top: 50%; left: 0; right: 0;
    height: 1px;
    background: #e5e7eb;
    z-index: 0;
}
.section-header__title-wrap {
    position: relative;
    z-index: 1;
    clip-path: polygon(8px 0%, 100% 0%, calc(100% - 8px) 100%, 0% 100%);
    background: linear-gradient(135deg, #EA4F0C 0%, #F68E12 100%);
    padding: 10px 28px;
    box-shadow: 0 4px 14px rgba(234,79,12,0.3);
}
.section-header__title {
    font-size: clamp(0.875rem, 2vw, 1.25rem);
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-style: italic;
    white-space: nowrap;
}
.section-header__link {
    position: relative;
    z-index: 1;
    background: var(--color-primary, #EA4F0C);
    color: #fff;
    font-size: 0.8125rem;
    font-weight: 700;
    padding: 8px 18px;
    border-radius: 99px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background 0.2s;
    white-space: nowrap;
}
.section-header__link:hover { background: #111827; }

/* ── Category Marquee ─────────────────────────────── */
@keyframes marqueeScroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.marquee-track { animation: marqueeScroll 22s linear infinite; }
.marquee-track:hover { animation-play-state: paused; }

/* ── Marquee Text ─────────────────────────────────── */
@keyframes marqueeScrollText {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.marquee-text-track { animation: marqueeScrollText 18s linear infinite; }
.marquee-text-track:hover { animation-play-state: paused; }

/* ── Review Card ──────────────────────────────────── */
.review-card {
    background: #fff;
    border-radius: 1rem;
    padding: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    gap: 12px;
    height: 100%;
}
</style>

<main class="w-full bg-gray-50">

    {{-- ── Banner Slider ───────────────────────────── --}}
    <section class="w-full mb-6">
        <div class="banner-slider">
            @foreach($banner as $item)
            <div class="h-[160px] md:h-[420px] lg:h-[520px]">
                <img class="w-full h-full object-cover" src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" />
            </div>
            @endforeach
        </div>
    </section>

    {{-- ── Marquee Text Strip ──────────────────────── --}}
    @php
    $marqueeItems = array_filter([
        $setting->scrolling_text_1 ?? null,
        $setting->scrolling_text_2 ?? null,
        $setting->scrolling_text_3 ?? null,
    ]);
    if (empty($marqueeItems)) {
        $marqueeItems = ['New Arrivals Just Dropped', '100% Authentic Products', 'Free Shipping Over 1500Tk'];
    }
    $repeated       = array_merge($marqueeItems, $marqueeItems, $marqueeItems, $marqueeItems);
    $textColor      = $setting->marquee_text_color      ?? '#ffffff';
    $separatorColor = $setting->marquee_separator_color ?? '#f97316';
    $speed          = $setting->marquee_speed           ?? '18s';
    @endphp
    <section class="overflow-hidden mb-8 mx-4 rounded-xl"
        style="background-color: {{ $setting->marquee_bg_color ?? '#1e3a5f' }};">
        <div class="py-4 px-4 overflow-hidden">
            <div class="flex w-max marquee-text-track gap-8"
                style="animation-duration: {{ $speed }};">
                @foreach($repeated as $txt)
                <span class="text-xs font-bold whitespace-nowrap uppercase tracking-widest"
                    style="color: {{ $textColor }};">{{ $txt }}</span>
                <span class="text-xs font-bold whitespace-nowrap select-none"
                    style="color: {{ $separatorColor }};">✦</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Popular Categories ──────────────────────── --}}
    <section class="container mx-auto px-4 mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-1 h-7 bg-primary rounded-full"></div>
            <h2 class="text-xl md:text-2xl font-black text-gray-900 uppercase tracking-wide">
                Popular <span class="text-primary">Categories</span>
            </h2>
        </div>

        <div class="overflow-hidden relative">
            <div class="flex w-max marquee-track gap-3">
                @php $cats = array_merge($popularCategories->toArray(), $popularCategories->toArray()); @endphp
                @foreach($cats as $category)
                <a href="{{ route('products', ['category' => $category['id']]) }}"
                    class="group flex-shrink-0 w-[140px] md:w-[200px] lg:w-[220px] block">
                    <div class="relative overflow-hidden rounded-xl h-[160px] md:h-[220px] lg:h-[280px] w-full shadow-sm">
                        @if($category['image'])
                        <img src="{{ Storage::url($category['image']) }}" alt="{{ $category['name'] }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <span class="text-white font-bold text-xs md:text-sm uppercase tracking-wide line-clamp-1">{{ $category['name'] }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── New Arrivals ────────────────────────────── --}}
    @php $is_new = \App\Models\Product::where('is_new', 1)->where('status', 1)->latest()->get(); @endphp
    @if($is_new->count())
    <section class="container mx-auto px-4 mb-12">
        <div class="section-header">
            <div class="section-header__title-wrap">
                <span class="section-header__title">{{ \App\Helpers\TranslateHelper::translate('New Arrivals') }}</span>
            </div>
            <a href="{{ route('products') }}" class="section-header__link">
                {{ \App\Helpers\TranslateHelper::translate('See More') }}
                <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>

        <div class="vegetablesSlider">
            @foreach($is_new as $item)
            @php
            $discount = ($item->regular_price > 0 && $item->sale_price < $item->regular_price)
                ? round((($item->regular_price - $item->sale_price) / $item->regular_price) * 100) : 0;
            @endphp
            <div class="mx-1.5">
                <div class="product-card group">
                    <div class="product-card__img-wrap">
                        <img src="{{ Storage::url($item->featured_image_1) }}"
                            alt="{{ $item->name }}"
                            class="product-card__img-primary"
                            onerror="this.src='https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=No+Image'" />
                        @if($item->featured_image_2)
                        <img src="{{ Storage::url($item->featured_image_2) }}"
                            alt="{{ $item->name }}"
                            class="product-card__img-secondary"
                            onerror="this.src='https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=No+Image'" />
                        @else
                        <img src="{{ Storage::url($item->featured_image_1) }}"
                            alt="{{ $item->name }}"
                            class="product-card__img-secondary" />
                        @endif
                        <span class="product-card__badge" style="background:#111;">NEW</span>
                        @if($discount > 0)
                        <span class="product-card__badge" style="left:auto;right:8px;background:#ef4444;">{{ $discount }}% OFF</span>
                        @endif
                    </div>
                    <div class="product-card__body">
                        <a href="{{ route('product.single', $item->slug) }}">
                            <p class="product-card__title">{{ \App\Helpers\TranslateHelper::translate($item->name) }}</p>
                        </a>
                        <div class="product-card__price-row">
                            <span class="product-card__price">{{ currency() }} {{ number_format($item->sale_price, 2) }}</span>
                            @if($item->regular_price > $item->sale_price)
                            <span class="product-card__price-old">{{ currency() }} {{ number_format($item->regular_price, 2) }}</span>
                            @endif
                        </div>
                        <button type="button" class="product-card__btn orders-now"
                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                            data-slug="{{ $item->slug }}" data-image="{{ Storage::url($item->featured_image_1) }}"
                            data-price="{{ $item->sale_price }}"
                            data-has-variant="{{ $item->variants->count() > 0 ? '1' : '0' }}">
                            <i class="fas fa-shopping-cart text-xs"></i>
                            {{ \App\Helpers\TranslateHelper::translate('Buy Now') }}
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ── Hero Banner / Blog CTA ──────────────────── --}}
    <section class="container mx-auto px-4 mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex flex-col items-center lg:items-start text-center lg:text-left p-8 lg:p-12 gap-5 order-2 lg:order-1">
                <span class="text-xs font-bold uppercase tracking-widest text-primary bg-primary/10 px-3 py-1 rounded-full">Collection</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 leading-tight">
                    {{ $setting->blogs_title }}
                </h2>
                <p class="text-base text-gray-500 leading-relaxed max-w-md">
                    {{ $setting->blogs_description }}
                </p>
                <a href="{{ route('products') }}"
                    class="inline-flex items-center gap-2 bg-primary hover:bg-gray-900 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 shadow-md group">
                    Shop Now
                    <i class="fa-solid fa-arrow-right-long group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="w-full h-[280px] sm:h-[380px] lg:h-[500px] overflow-hidden order-1 lg:order-2">
                <img src="{{ Storage::url($setting->certificate) }}" alt="{{ $setting->blogs_title }}"
                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-700 ease-in-out" />
            </div>
        </div>
    </section>

    {{-- ── Category Product Sections ───────────────── --}}
    @foreach($categories as $category)
    @if($category->products->count() > 0)
    <section class="container mx-auto px-4 mb-12">
        <div class="section-header">
            <div class="section-header__title-wrap">
                <span class="section-header__title">{{ \App\Helpers\TranslateHelper::translate($category->name) }}</span>
            </div>
            <a href="{{ route('products', ['category' => $category->id]) }}" class="section-header__link">
                {{ \App\Helpers\TranslateHelper::translate('See More') }}
                <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
            @foreach($category->products->take(4) as $item)
            @php
            $discount = ($item->regular_price > 0 && $item->sale_price < $item->regular_price)
                ? round((($item->regular_price - $item->sale_price) / $item->regular_price) * 100) : 0;
            @endphp
            <div class="product-card group {{ $loop->index >= 2 ? 'hidden md:flex md:flex-col' : '' }}">
                <div class="product-card__img-wrap">
                    <img src="{{ Storage::url($item->featured_image_1) }}"
                        alt="{{ $item->name }}"
                        class="product-card__img-primary"
                        onerror="this.src='https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=No+Image'" />
                    @if($item->featured_image_2)
                    <img src="{{ Storage::url($item->featured_image_2) }}"
                        alt="{{ $item->name }}"
                        class="product-card__img-secondary"
                        onerror="this.src='https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=No+Image'" />
                    @else
                    <img src="{{ Storage::url($item->featured_image_1) }}"
                        alt="{{ $item->name }}"
                        class="product-card__img-secondary" />
                    @endif
                    @if($discount > 0)
                    <span class="product-card__badge">{{ $discount }}% OFF</span>
                    @endif
                </div>
                <div class="product-card__body">
                    <a href="{{ route('product.single', $item->slug) }}">
                        <p class="product-card__title">{{ \App\Helpers\TranslateHelper::translate($item->name) }}</p>
                    </a>
                    <div class="product-card__price-row">
                        <span class="product-card__price">{{ currency() }} {{ number_format($item->sale_price, 2) }}</span>
                        @if($item->regular_price > $item->sale_price)
                        <span class="product-card__price-old">{{ currency() }} {{ number_format($item->regular_price, 2) }}</span>
                        @endif
                    </div>
                    <button type="button" class="product-card__btn orders-now"
                        data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                        data-slug="{{ $item->slug }}" data-image="{{ Storage::url($item->featured_image_1) }}"
                        data-price="{{ $item->sale_price }}"
                        data-has-variant="{{ $item->variants->count() > 0 ? '1' : '0' }}">
                        <i class="fas fa-shopping-cart text-xs"></i>
                        {{ \App\Helpers\TranslateHelper::translate('Buy Now') }}
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
    @endforeach

    {{-- ── Customer Reviews ────────────────────────── --}}
    <section class="w-full py-10 bg-white border-t border-gray-100 mb-8">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1 h-7 bg-primary rounded-full"></div>
                <h2 class="text-xl md:text-2xl font-black text-gray-900">What Our Customers Say</h2>
            </div>
            <div class="reviewSlider">
                @foreach($review as $item)
                <div class="px-2">
                    <div class="review-card">
                        <div class="flex items-center gap-3">
                            <img src="{{ $item->image ? Storage::url($item->image) : 'https://via.placeholder.com/56x56/e5e7eb/6b7280?text=U' }}"
                                alt="{{ $item->name }}"
                                class="w-12 h-12 rounded-full object-cover ring-2 ring-gray-100 flex-shrink-0" />
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $item->name }}</p>
                                <div class="flex gap-0.5 mt-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star text-xs {{ $i <= $item->star ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-100">
                            <p class="text-xs text-gray-600 leading-relaxed">{{ $item->review_text }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Features Strip ──────────────────────────── --}}
    <section class="bg-white border-t border-gray-100 py-8 hidden lg:block">
        <div class="container mx-auto px-4">
            @php
            $features = [
                ['title' => $setting->list_1 ?? '60 Mins Delivery',         'subtitle' => $setting->list_2 ?? 'Free shipping over 1500Tk',         'icon' => 'fas fa-box'],
                ['title' => $setting->list_3 ?? 'Authorized Products',      'subtitle' => $setting->list_4 ?? 'Within 30 days for an exchange',     'icon' => 'fas fa-shield-alt'],
                ['title' => $setting->list_5 ?? 'Customer Service Support', 'subtitle' => $setting->list_6 ?? '8am to 10pm',                        'icon' => 'fas fa-headset'],
                ['title' => $setting->list_7 ?? 'Flexible Payments',        'subtitle' => $setting->list_8 ?? 'Pay with multiple credit cards',      'icon' => 'fas fa-wallet'],
            ];
            @endphp
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($features as $feature)
                <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-100 bg-gray-50 hover:border-primary/30 hover:bg-primary/5 transition-all">
                    <div class="w-12 h-12 rounded-full border-2 border-primary flex items-center justify-center flex-shrink-0 bg-white">
                        <i class="{{ $feature['icon'] }} text-xl text-primary"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ $feature['title'] }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $feature['subtitle'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</main>

@endsection