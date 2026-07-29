@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('Products'))
@section('content')

@php
    $allCategories = \App\Models\Category::where('status', 1)
        ->with(['subCategories' => fn($q) => $q->where('status', 1)])
        ->get();

    $maxPrice  = \App\Models\Product::where('status', 1)->max('regular_price') ?? 1000;
    $filterMin = request('price_min', 0);
    $filterMax = request('price_max', $maxPrice);
@endphp

<style>
    :root {
        --brand-red: #FF0000;
        --brand-black: #000000;
        --brand-white: #ffffff;
    }

    body { background: #f7f7f8; }

    /* ── Sidebar ─────────────────────────────────────── */
    .sidebar-section {
        background: var(--brand-white);
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        padding: 16px;
        margin-bottom: 16px;
        border: 1px solid #eee;
    }
    .sidebar-section__title {
        font-size: .8125rem;
        font-weight: 800;
        color: var(--brand-black);
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        margin-bottom: 12px;
        user-select: none;
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .sidebar-section__title i {
        color: #9ca3af;
        font-size: .75rem;
        transition: transform .2s ease;
    }
    .sidebar-section__title i.rotate-180 { transform: rotate(180deg); }

    .form-check-input:checked {
        background-color: var(--brand-red);
        border-color: var(--brand-red);
    }
    .form-check-input:focus {
        box-shadow: 0 0 0 .2rem rgba(255,0,0,.15);
        border-color: var(--brand-red);
    }
    .form-check-label { font-size: .875rem; color: #4b5563; cursor: pointer; }
    .form-check:hover .form-check-label { color: var(--brand-red); }

    .btn-brand {
        background: var(--brand-red);
        color: var(--brand-white);
        border: none;
        font-weight: 700;
        font-size: .78rem;
        transition: background .2s ease;
    }
    .btn-brand:hover {
        background: var(--brand-black);
        color: var(--brand-white);
    }

    .price-box {
        background: #f9fafb;
        border: 1px solid #eee;
        font-size: .75rem;
        color: #6b7280;
        padding: 3px 9px;
        border-radius: 6px;
        font-weight: 600;
    }

    #sliderTrack { position: relative; height: 6px; background: #eee; border-radius: 50px; margin: 10px 0 18px; }
    #sliderRange { position: absolute; height: 6px; background: var(--brand-red); border-radius: 50px; }
    #sliderTrack input[type="range"] { position: absolute; width: 100%; height: 6px; top: 0; opacity: 0; cursor: pointer; }

    .cat-link {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 4px;
        font-size: .875rem;
        color: #4b5563;
        text-decoration: none;
        flex: 1;
        border-radius: 8px;
        transition: color .2s ease;
    }
    .cat-link:hover { color: var(--brand-red); background: #fff5f5; }
    .cat-link.active { color: var(--brand-red); font-weight: 700; }

    .cat-icon-wrap {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: rgba(255,0,0,.08);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .cat-icon-wrap i { font-size: 9px; color: var(--brand-red); }

    .subcat-toggle-btn {
        border: none;
        background: transparent;
        color: #9ca3af;
        padding: 6px;
        transition: color .2s ease, transform .2s ease;
    }
    .subcat-toggle-btn:hover { color: var(--brand-red); }
    .subcat-toggle-btn i.rotate-90 { transform: rotate(90deg); }

    .subcat-list {
        margin-left: 24px;
        padding-left: 12px;
        border-left: 2px solid #eee;
    }
    .subcat-list a {
        display: block;
        padding: 6px 6px;
        font-size: .78rem;
        color: #6b7280;
        text-decoration: none;
        border-radius: 6px;
        transition: color .2s ease;
    }
    .subcat-list a:hover { color: var(--brand-red); }
    .subcat-list a.active { color: var(--brand-red); font-weight: 700; }

    /* ── Breadcrumb ──────────────────────────────────── */
    .breadcrumb-box {
        background: var(--brand-white);
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #f1f1f1;
    }
    .breadcrumb-box a { color: #6b7280; text-decoration: none; font-weight: 500; font-size: .78rem; }
    .breadcrumb-box a:hover { color: var(--brand-red); }
    .breadcrumb-box .current { color: var(--brand-red); font-weight: 700; font-size: .78rem; }
    .breadcrumb-box .sep { font-size: 9px; color: #d1d5db; }
    .item-count-badge {
        background: rgba(255,0,0,.08);
        color: var(--brand-red);
        font-size: .68rem;
        font-weight: 700;
        padding: 2px 9px;
        border-radius: 50px;
    }

    /* ── Product Grid ────────────────────────────────── */
    .product-card-bs {
        background: var(--brand-white);
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f1f1;
        overflow: hidden;
        transition: box-shadow .4s ease, transform .4s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .product-card-bs:hover {
        box-shadow: 0 14px 30px rgba(0,0,0,0.12);
        transform: translateY(-4px);
    }
    .product-card-bs .img-wrap {
        position: relative;
        width: 100%;
        overflow: hidden;
        background: #f3f4f6;
        aspect-ratio: 1/1;
    }
    .product-card-bs .img-wrap img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity .5s ease, transform .5s ease;
    }
    .product-card-bs .img-hover { opacity: 0; transform: scale(1.08); }
    .product-card-bs:hover .img-default { opacity: 0; }
    .product-card-bs:hover .img-hover { opacity: 1; transform: scale(1); }

    .discount-tag {
        position: absolute;
        top: 0;
        left: 10px;
        z-index: 5;
        background: var(--brand-red);
        color: #fff;
        font-weight: 800;
        text-align: center;
        width: 46px;
        padding: 7px 4px 16px;
        clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 82%, 0 100%);
        line-height: 1.3;
    }
    .discount-tag .amt { font-size: 12px; font-weight: 900; }
    .discount-tag .lbl { font-size: 8px; font-weight: 700; letter-spacing: 1.2px; opacity: .9; }

    .product-card-bs .p-body { padding: 14px; display: flex; flex-direction: column; flex: 1; }
    .product-card-bs .p-title {
        font-size: .88rem;
        color: var(--brand-black);
        margin-bottom: 8px;
        min-height: 38px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
        transition: color .2s ease;
    }
    .product-card-bs:hover .p-title { color: var(--brand-red); }

    .p-price-new { font-size: 1rem; font-weight: 800; color: var(--brand-black); }
    .p-price-old { font-size: .8rem; color: var(--brand-red); text-decoration: line-through; opacity: .65; }

    .btn-order {
        margin-top: auto;
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
        transition: background .25s ease;
    }
    .btn-order:hover { background: var(--brand-black); color: #fff; }

    .empty-state {
        background: var(--brand-white);
        border-radius: 12px;
        padding: 70px 20px;
        text-align: center;
        border: 1px solid #f1f1f1;
    }
    .empty-state i { font-size: 3.2rem; color: #e5e7eb; margin-bottom: 14px; }
    .empty-state a { color: var(--brand-red); font-weight: 700; text-decoration: none; }
    .empty-state a:hover { text-decoration: underline; }

    .products-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}
@media (min-width: 768px) {
    .products-grid { grid-template-columns: repeat(3, 1fr); }
}
</style>

<section>
  <div class="container py-4">

    {{-- ── Breadcrumb ──────────────────────────────── --}}
    <nav class="breadcrumb-box">
      <ol class="d-flex align-items-center flex-wrap gap-2 mb-0" style="list-style:none;padding:0;">
        <li>
          <a href="/" class="d-flex align-items-center gap-1">
            <i class="fas fa-home" style="font-size:10px;"></i>
            {{ \App\Helpers\TranslateHelper::translate('Home') }}
          </a>
        </li>
        <li><i class="fas fa-chevron-right sep"></i></li>
        <li>
          <a href="{{ route('products') }}">
            {{ \App\Helpers\TranslateHelper::translate('Products') }}
          </a>
        </li>
        @if(!empty($breadcrumbs))
          @foreach($breadcrumbs as $crumb)
            <li><i class="fas fa-chevron-right sep"></i></li>
            @if(!$loop->last)
              <li>
                <a href="{{ route('products', [$crumb['type'] === 'category' ? 'category' : 'sub_category' => $crumb['id']]) }}">
                  {{ \App\Helpers\TranslateHelper::translate($crumb['name']) }}
                </a>
              </li>
            @else
              <li class="d-flex align-items-center gap-2">
                <span class="current">{{ \App\Helpers\TranslateHelper::translate($crumb['name']) }}</span>
                <span class="item-count-badge">{{ $products->count() }} {{ \App\Helpers\TranslateHelper::translate('items') }}</span>
              </li>
            @endif
          @endforeach
        @elseif($categoryName != 'All Products')
          <li><i class="fas fa-chevron-right sep"></i></li>
          <li class="d-flex align-items-center gap-2">
            <span class="current">{{ \App\Helpers\TranslateHelper::translate($categoryName) }}</span>
            <span class="item-count-badge">{{ $products->count() }} {{ \App\Helpers\TranslateHelper::translate('items') }}</span>
          </li>
        @endif
      </ol>
    </nav>

    <div class="row g-4">

      {{-- ══ LEFT SIDEBAR ════════════════════════════ --}}
      <aside class="col-lg-3 d-none d-lg-block">
        <form method="GET" action="{{ route('products') }}" id="filterForm">

          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif
          @if(request('sub_category'))
            <input type="hidden" name="sub_category" value="{{ request('sub_category') }}">
          @endif

          {{-- Availability --}}
          <div class="sidebar-section">
            <h3 class="sidebar-section__title" onclick="toggleSection('availSection')">
              Availability
              <i class="fas fa-chevron-up" id="availSectionIcon"></i>
            </h3>
            <div id="availSection">
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="availability[]" value="in_stock"
                  id="inStockCheck"
                  {{ in_array('in_stock', request('availability', [])) ? 'checked' : '' }}
                  onchange="document.getElementById('filterForm').submit()">
                <label class="form-check-label" for="inStockCheck">In Stock</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="availability[]" value="out_of_stock"
                  id="outStockCheck"
                  {{ in_array('out_of_stock', request('availability', [])) ? 'checked' : '' }}
                  onchange="document.getElementById('filterForm').submit()">
                <label class="form-check-label" for="outStockCheck">Out of Stock</label>
              </div>
            </div>
          </div>

          {{-- Price Filter --}}
          <div class="sidebar-section">
            <h3 class="sidebar-section__title" onclick="toggleSection('priceSection')">
              Filter By Price
              <i class="fas fa-chevron-up" id="priceSectionIcon"></i>
            </h3>
            <div id="priceSection">
              <div id="sliderTrack">
                <div id="sliderRange"></div>
                <input type="range" id="priceMinSlider" name="price_min"
                  min="0" max="{{ $maxPrice }}" value="{{ $filterMin }}" step="1" style="z-index:3">
                <input type="range" id="priceMaxSlider" name="price_max"
                  min="0" max="{{ $maxPrice }}" value="{{ $filterMax }}" step="1" style="z-index:4">
              </div>
              <div class="d-flex align-items-center justify-content-between mb-3">
                <span class="price-box">{{ currency() }}<span id="minPriceDisplay">{{ $filterMin }}</span></span>
                <span class="text-muted">—</span>
                <span class="price-box">{{ currency() }}<span id="maxPriceDisplay">{{ $filterMax }}</span></span>
              </div>
              <button type="submit" class="btn btn-brand w-100 py-2 rounded-pill d-flex align-items-center justify-content-center gap-2">
                Apply Filter <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>

          {{-- Categories --}}
          <div class="sidebar-section">
            <h3 class="sidebar-section__title" onclick="toggleSection('catSection')">
              Categories
              <i class="fas fa-chevron-up" id="catSectionIcon"></i>
            </h3>
            <div id="catSection">
              @foreach($allCategories as $cat)
              <div>
                <div class="d-flex align-items-center justify-content-between">
                  <a href="{{ route('products', ['category' => $cat->id]) }}"
                    class="cat-link {{ request('category') == $cat->id ? 'active' : '' }}"
                    onclick="trackCategoryView('{{ $cat->id }}', '{{ addslashes($cat->name) }}')">
                    @if($cat->image)
                      <img src="{{ Storage::url($cat->image) }}" style="width:22px;height:22px;border-radius:50%;object-fit:cover;flex-shrink:0;">
                    @else
                      <span class="cat-icon-wrap"><i class="fas fa-tag"></i></span>
                    @endif
                    <span class="text-truncate">{{ \App\Helpers\TranslateHelper::translate($cat->name) }}</span>
                  </a>
                  @if($cat->subCategories->count() > 0)
                    <button type="button" class="subcat-toggle-btn" onclick="toggleSubCat('sub-{{ $cat->id }}')">
                      <i class="fas fa-chevron-right sub-icon-{{ $cat->id }} {{ request('category') == $cat->id ? 'rotate-90' : '' }}"></i>
                    </button>
                  @endif
                </div>

               @if($cat->subCategories->count() > 0)
                <div id="sub-{{ $cat->id }}"
                  class="subcat-list {{ request('category') == $cat->id || (request()->sub_category && $cat->subCategories->pluck('id')->contains(request('sub_category'))) ? 'd-block' : 'd-none' }}">
                  @foreach($cat->subCategories as $sub)
                    <a href="{{ route('products', ['sub_category' => $sub->id]) }}"
                      class="text-truncate {{ request('sub_category') == $sub->id ? 'active' : '' }}"
                      onclick="trackCategoryView('{{ $sub->id }}', '{{ addslashes($sub->name) }}')">
                      {{ \App\Helpers\TranslateHelper::translate($sub->name) }}
                    </a>
                  @endforeach
                </div>
                @endif
              </div>
              @endforeach
            </div>
          </div>

        </form>
      </aside>

      {{-- ══ MOBILE FILTER PANEL (শুধু mobile/tablet-এ দেখাবে) ══ --}}
  <div class="d-lg-none mb-4">
      <p class="text-muted small mb-2">Find Your Favorite Products Here..</p>

      <button type="button" class="btn w-100 d-flex align-items-center justify-content-center gap-2 fw-bold"
          id="mobileFilterToggle"
          style="background:var(--brand-black); color:#fff; border-radius:8px; padding:12px;">
          <span id="mobileFilterToggleText">Show Filters</span>
          <i class="fas fa-chevron-down" id="mobileFilterToggleIcon" style="transition:transform .2s ease;"></i>
      </button>

      <div id="mobileFilterPanel" class="d-none mt-3">
          <form method="GET" action="{{ route('products') }}" id="mobileFilterForm" class="sidebar-section">

              {{-- Search --}}
              <div class="mb-3">
                  <label class="form-label fw-bold small">Search</label>
                  <input type="text" name="search" class="form-control" placeholder="Search products..."
                      value="{{ request('search') }}">
              </div>

              {{-- Price --}}
              <div class="mb-3">
                  <label class="form-label fw-bold small">Price</label>
                  <div class="d-flex gap-2">
                      <input type="number" name="price_min" class="form-control" placeholder="Min"
                          value="{{ request('price_min') }}">
                      <input type="number" name="price_max" class="form-control" placeholder="Max"
                          value="{{ request('price_max') }}">
                  </div>
              </div>

              {{-- Main Category --}}
              <div class="mb-3">
                  <label class="form-label fw-bold small">Main Category</label>
                  <select name="category" id="mobileCategorySelect" class="form-select">
                      <option value="">All main categories</option>
                      @foreach($allCategories as $cat)
                      <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                          {{ \App\Helpers\TranslateHelper::translate($cat->name) }}
                      </option>
                      @endforeach
                  </select>
              </div>

              {{-- Sub Category --}}
              <div class="mb-3">
                  <label class="form-label fw-bold small">Sub Category</label>
                  <select name="sub_category" id="mobileSubCategorySelect" class="form-select">
                      <option value="">All sub categories</option>
                      @foreach($allCategories as $cat)
                          @foreach($cat->subCategories as $sub)
                          <option value="{{ $sub->id }}"
                              data-parent="{{ $cat->id }}"
                              {{ request('sub_category') == $sub->id ? 'selected' : '' }}
                              style="{{ request('category') && request('category') != $cat->id ? 'display:none;' : '' }}">
                              {{ $sub->name }}
                          </option>
                          @endforeach
                      @endforeach
                  </select>
              </div>

              {{-- Sort --}}
              <div class="mb-3">
                  <label class="form-label fw-bold small">Sort</label>
                  <select name="sort" class="form-select">
                      <option value="relevance" {{ request('sort', 'relevance') == 'relevance' ? 'selected' : '' }}>Relevance</option>
                      <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                      <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                      <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                  </select>
              </div>

              {{-- Apply / Clear --}}
              <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-brand flex-fill py-2 rounded-pill fw-bold">Apply</button>
                  <a href="{{ route('products') }}" class="btn btn-outline-secondary flex-fill py-2 rounded-pill fw-bold text-center">Clear</a>
              </div>

          </form>
      </div>
  </div>

        {{-- ══ PRODUCTS GRID ════════════════════════════ --}}
        <div class="col-lg-9">

            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="fw-black h4 mb-1" style="color:var(--brand-black);font-weight:800;">
                        {{ \App\Helpers\TranslateHelper::translate($categoryName) }}
                    </h1>
                    <p class="text-muted small mb-0">
                        {{ $products->count() }} {{ $products->count() == 1 ? \App\Helpers\TranslateHelper::translate('product') : \App\Helpers\TranslateHelper::translate('products') }} found
                    </p>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <p class="text-muted fw-medium small mb-0">No products found.</p>
                    <a href="{{ route('products') }}" class="d-inline-block mt-3">Clear filters</a>
                </div>
            @else
                <div class="products-grid">
                    @foreach ($products as $item)
                    @php
                        $discount_amount     = $item->regular_price - $item->sale_price;
                        $discount_percentage = $item->regular_price > 0
                            ? round(($discount_amount / $item->regular_price) * 100)
                            : 0;

                        // ✅ Wishlist status check
                        $isWishlisted = auth()->check()
                            ? auth()->user()->wishlists()->where('product_id', $item->id)->exists()
                            : false;
                    @endphp

                    <div class="product-card">
                        <a href="{{ route('product.single', $item->slug) }}"
                          onclick="trackProductClick('{{ $item->id }}', '{{ addslashes($item->name) }}', {{ $item->sale_price }}, '{{ addslashes($categoryName) }}')">

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

                                <img src="{{ Storage::url($item->featured_image_1) }}" alt="{{ $item->name }}" class="img-default"
                                    onerror="this.src='https://via.placeholder.com/500x500/e5e7eb/6b7280?text=Product'">
                                @if($item->featured_image_2)
                                <img src="{{ Storage::url($item->featured_image_2) }}" alt="{{ $item->name }}" class="img-hover"
                                    onerror="this.src='https://via.placeholder.com/500x500/e5e7eb/6b7280?text=Product'">
                                @else
                                <img src="{{ Storage::url($item->featured_image_1) }}" alt="{{ $item->name }}" class="img-hover"
                                    onerror="this.src='https://via.placeholder.com/500x500/e5e7eb/6b7280?text=Product'">
                                @endif
                            </div>

                            <div class="product-body">
                                <h3 class="product-title">{{ \App\Helpers\TranslateHelper::translate($item->name) }}</h3>
                                <div class="product-price">
                                    @if($item->regular_price > $item->sale_price)
                                    <span class="price-old">{{ currency() }}{{ number_format($item->regular_price, 2) }}</span>
                                    @endif
                                    <span class="price-new">{{ currency() }}{{ number_format($item->sale_price, 2) }}</span>
                                </div>
                                <div class="product-btn-group">
                                    <button type="button" class="btn-order-now"
                                        onclick="trackProductClick('{{ $item->id }}', '{{ addslashes($item->name) }}', {{ $item->sale_price }}, '{{ addslashes($categoryName) }}'); window.location.href='{{ route('product.single', $item->slug) }}';">
                                        Order Now
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
  </div>
</section>

<script>
// ── Price Range Slider ──────────────────────────────
(function () {
    const minSlider  = document.getElementById('priceMinSlider');
    const maxSlider  = document.getElementById('priceMaxSlider');
    const minDisplay = document.getElementById('minPriceDisplay');
    const maxDisplay = document.getElementById('maxPriceDisplay');
    const range      = document.getElementById('sliderRange');
    if (!minSlider) return;

    function updateSlider() {
        const min   = parseInt(minSlider.value);
        const max   = parseInt(maxSlider.value);
        const total = parseInt(minSlider.max);
        if (min > max) { minSlider.value = max; return; }
        minDisplay.textContent = min;
        maxDisplay.textContent = max;
        const l = (min / total) * 100;
        const r = (max / total) * 100;
        range.style.left  = l + '%';
        range.style.width = (r - l) + '%';
    }

    minSlider.addEventListener('input', updateSlider);
    maxSlider.addEventListener('input', updateSlider);
    updateSlider();
})();


function trackProductClick(productId, productName, price, listName) {
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
    fbq('trackCustom', 'ProductClick', {
        content_ids  : [String(productId)],
        content_name : productName,
        content_type : 'product',
        value        : price,
        currency     : 'BDT',
        list_name    : listName
    });
}

function trackCategoryView(categoryId, categoryName) {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ ecommerce: null });
    window.dataLayer.push({
        event     : 'view_item_list',
        page_type : 'listing',
        ecommerce : {
            item_list_name : categoryName,
            item_list_id   : String(categoryId)
        }
    });
    fbq('trackCustom', 'CategoryView', {
        content_category : categoryName,
        content_ids      : [String(categoryId)]
    });
}

// ── Toggle Sidebar Sections ─────────────────────────
function toggleSection(id) {
    const el   = document.getElementById(id);
    const icon = document.getElementById(id + 'Icon');
    if (!el) return;
    el.classList.toggle('d-none');
    if (icon) icon.classList.toggle('rotate-180');
}

// ── Toggle Subcategory List ─────────────────────────
function toggleSubCat(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.toggle('d-none');
    el.classList.toggle('d-block');
    const catId = id.replace('sub-', '');
    document.querySelectorAll('.sub-icon-' + catId).forEach(i => i.classList.toggle('rotate-90'));
}
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ ecommerce: null });
    window.dataLayer.push({
        event     : 'view_item_list',
        page_type : 'listing',
        ecommerce : {
            item_list_name : '{{ addslashes($categoryName) }}',
            currency       : 'BDT',
            items          : [
                @foreach($products as $item)
                {
                    item_id       : '{{ $item->id }}',
                    item_name     : '{{ addslashes($item->name) }}',
                    item_category : '{{ optional($item->category)->name }}',
                    price         : {{ $item->sale_price }},
                    quantity      : 1
                }{{ !$loop->last ? ',' : '' }}
                @endforeach
            ]
        }
    });

    fbq('trackCustom', 'ViewCategory', {
        content_category : '{{ addslashes($categoryName) }}',
        currency         : 'BDT'
    });
});
</script>

<script>
// ── Mobile Filter Panel Toggle ──────────────────────
(function () {
    const toggleBtn  = document.getElementById('mobileFilterToggle');
    const panel      = document.getElementById('mobileFilterPanel');
    const toggleText = document.getElementById('mobileFilterToggleText');
    const toggleIcon = document.getElementById('mobileFilterToggleIcon');
    if (!toggleBtn) return;

    // ✅ auto-open লজিক সরিয়ে দেওয়া হলো — panel সবসময় বন্ধ থাকবে, শুধু বাটনে ক্লিক করলেই খুলবে
    toggleBtn.addEventListener('click', function () {
        const isHidden = panel.classList.contains('d-none');
        if (isHidden) {
            panel.classList.remove('d-none');
            toggleText.textContent = 'Hide Filters';
            toggleIcon.style.transform = 'rotate(180deg)';
        } else {
            panel.classList.add('d-none');
            toggleText.textContent = 'Show Filters';
            toggleIcon.style.transform = 'rotate(0deg)';
        }
    });
})();

// ── Mobile: Category বদলালে Sub Category options filter হবে ──
(function () {
    const catSelect    = document.getElementById('mobileCategorySelect');
    const subSelect    = document.getElementById('mobileSubCategorySelect');
    if (!catSelect || !subSelect) return;

    const allSubOptions = Array.from(subSelect.querySelectorAll('option[data-parent]'));

    function filterSubOptions() {
        const selectedCat = catSelect.value;
        allSubOptions.forEach(opt => {
            if (!selectedCat || opt.dataset.parent === selectedCat) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
                if (opt.selected) opt.selected = false;
            }
        });
        if (!selectedCat) subSelect.value = '';
    }

    catSelect.addEventListener('change', filterSubOptions);
})();
</script>

@endsection