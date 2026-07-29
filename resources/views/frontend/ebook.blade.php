@extends('layouts.app')

@section('title', 'Ebook')
@section('content')

<!-- ================= BANNER SLIDER ================= -->
  <section class="banner-slider" id="bannerSlider">
    <div class="banner-track">
    @foreach($banner as $item)
      <div class="banner-slide active">
        <img src="{{Storage::url($item->image)}}" alt="{{$item->title}}">
      </div>
      @endforeach
    </div>

    <button class="banner-arrow banner-prev" aria-label="আগের ব্যানার"><i class="bi bi-chevron-left"></i></button>
    <button class="banner-arrow banner-next" aria-label="পরের ব্যানার"><i class="bi bi-chevron-right"></i></button>

    <div class="banner-dots"></div>
  </section>


  <!-- e-book slider section -->
  <!-- e-book category slider section -->
  <section class="ebkcat-section">
    <div class="container">

      <div class="ebkcat-header">
        <div class="ebkcat-header-spacer" aria-hidden="true"></div>

        <div class="ebkcat-title-wrap">
          <div class="ebkcat-eyebrow">
            <span class="line"></span>
            <span class="ebkcat-icon-badge">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 5.5C4 4.7 4.7 4 5.5 4H11v16H5.5A1.5 1.5 0 0 1 4 18.5v-13Z" />
                <path d="M20 5.5c0-.8-.7-1.5-1.5-1.5H13v16h5.5a1.5 1.5 0 0 0 1.5-1.5v-13Z" />
              </svg>
            </span>
            <span class="line"></span>
          </div>
          <h2 class="ebkcat-title-main">ক্যাটাগরিসমূহ</h2>
        </div>

        <div class="ebkcat-nav">
          <button class="ebkcat-nav-btn" type="button" data-dir="prev" aria-label="আগের বই দেখুন">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="15 18 9 12 15 6" />
            </svg>
          </button>
          <button class="ebkcat-nav-btn" type="button" data-dir="next" aria-label="পরের বই দেখুন">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="9 18 15 12 9 6" />
            </svg>
          </button>
        </div>
      </div>

     <div class="ebkcat-track" id="ebookTrack" tabindex="0" aria-label="ই-বুক তালিকা, স্লাইড করে দেখুন">

        @php
            $ebkColors = ['#8b5cf6', '#0f7a4a', '#2563eb', '#e0389f', '#c2410c', '#0f9b8e'];
        @endphp

        @foreach($ebookcategories as $ebook)
        <article class="ebkcat-card ebkcat-card--navy">
            <div class="ebkcat-cover">
                    <a href="{{ route('products', ['category' => $ebook->id]) }}">
                    <img class="ebkcat-mockup"
                        src="{{ Storage::url($ebook->image) }}"
                        alt="{{ $ebook->name }}" loading="lazy">
                    </a>
                </div>
                <div class="ebkcat-bottom-bar" style="background: {{ $ebkColors[$loop->index % count($ebkColors)] }};">
                    <a href="{{ route('products', ['category' => $ebook->id]) }}">
                    <span>{{ $ebook->name }}</span>
                    </a>
                </div>
            </article>
        @endforeach

        </div>

    </div>
  </section>

  <!-- Special Deals Slider Section -->
  <section class="deals-section">
    <div class="container deals-container">

      <div class="deals-header d-flex align-items-center justify-content-between mb-4">
        <h2 class="deals-title mb-0">জনপ্রিয় বই</h2>
        <a href="https://shopiots.com/products" class="btn deals-btn-seeall">আরও দেখুন</a>
      </div>

      <div class="deals-slider">
        <div class="deals-track" id="dealsTrack">

          <!-- Slide 1 -->
          <div class="deals-slide">
            <div class="product-card h-100">
              <a href="https://shopiots.com/product/himu" class="product-media">
                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" alt="হিমু"
                  class="product-img product-img--main">
                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="হিমু"
                  class="product-img product-img--hover">
                <span class="discount-badge">
                  <strong>১৭%</strong>
                  <small>ছাড়</small>
                </span>
              </a>
              <div class="product-body">
                <h3 class="product-title">হিমু - হুমায়ূন আহমেদ</h3>
                <div class="product-price">
                  <span class="price-old">৳ ১,৬০০</span>
                  <span class="price-new">৳ ৯৫০</span>
                </div>
                <button class="btn add-to-bag-btn home-buy-now" data-id="87" data-name="হিমু" data-price="950.00"
                  data-image="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" data-slug="himu"
                  data-url="https://shopiots.com/product/himu">
                  <span>অর্ডার করুন</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="deals-slide">
            <div class="product-card h-100">
              <a href="https://shopiots.com/product/debdas" class="product-media">
                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="দেবদাস"
                  class="product-img product-img--main">
                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" alt="দেবদাস"
                  class="product-img product-img--hover">
                <span class="discount-badge">
                  <strong>১৭%</strong>
                  <small>ছাড়</small>
                </span>
              </a>
              <div class="product-body">
                <h3 class="product-title">দেবদাস - শরৎচন্দ্র চট্টোপাধ্যায়</h3>
                <div class="product-price">
                  <span class="price-old">৳ ১,৬০০</span>
                  <span class="price-new">৳ ১২০</span>
                </div>
                <button class="btn add-to-bag-btn home-buy-now" data-id="88" data-name="দেবদাস" data-price="120.00"
                  data-image="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80"
                  data-slug="debdas" data-url="https://shopiots.com/product/debdas">
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4.5v15m7.5-7.5h-15"></path>
                  </svg> -->
                  <span>অর্ডার করুন</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="deals-slide">
            <div class="product-card h-100">
              <a href="https://shopiots.com/product/gitanjali" class="product-media">
                <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80" alt="গীতাঞ্জলি"
                  class="product-img product-img--main">
                <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="গীতাঞ্জলি"
                  class="product-img product-img--hover">
                <span class="discount-badge">
                  <strong>১৭%</strong>
                  <small>ছাড়</small>
                </span>
              </a>
              <div class="product-body">
                <h3 class="product-title">গীতাঞ্জলি - রবীন্দ্রনাথ ঠাকুর</h3>
                <div class="product-price">
                  <span class="price-old">৳ ১,৬০০</span>
                  <span class="price-new">৳ ১,৫০০</span>
                </div>
                <button class="btn add-to-bag-btn home-buy-now" data-id="89" data-name="গীতাঞ্জলি" data-price="1500.00"
                  data-image="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80"
                  data-slug="gitanjali" data-url="https://shopiots.com/product/gitanjali">
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4.5v15m7.5-7.5h-15"></path>
                  </svg> -->
                  <span>অর্ডার করুন</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Slide 4 -->
          <div class="deals-slide">
            <div class="product-card h-100">
              <a href="https://shopiots.com/product/bidrohi" class="product-media">
                <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=500&q=80" alt="বিদ্রোহী"
                  class="product-img product-img--main">
                <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80" alt="বিদ্রোহী"
                  class="product-img product-img--hover">
                <span class="discount-badge">
                  <strong>১৭%</strong>
                  <small>ছাড়</small>
                </span>
              </a>
              <div class="product-body">
                <h3 class="product-title">বিদ্রোহী - কাজী নজরুল ইসলাম</h3>
                <div class="product-price">
                  <span class="price-old">৳ ৭০০</span>
                  <span class="price-new">৳ ৫০০</span>
                </div>
                <button class="btn add-to-bag-btn home-buy-now" data-id="90" data-name="বিদ্রোহী" data-price="500.00"
                  data-image="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=500&q=80" data-slug="bidrohi"
                  data-url="https://shopiots.com/product/bidrohi">
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4.5v15m7.5-7.5h-15"></path>
                  </svg> -->
                  <span>অর্ডার করুন</span>
                </button>
              </div>
            </div>
          </div>
          <!-- Slide End -->

        </div>
      </div>

    </div>
  </section>


  <!-- Special Deals section -->
  <section class="deals-section">
    <div class="container deals-container">

      <div class="deals-header d-flex align-items-center justify-content-between mb-4">
        <h2 class="deals-title mb-0">দেবদাস</h2>
        <a href="https://shopiots.com/products" class="btn deals-btn-seeall">আরও দেখুন</a>
      </div>

      <div class="row row-cols-2 row-cols-lg-4 g-2">

        <!-- Product Card 1 -->
        <div class="col">
          <div class="product-card h-100">
            <a href="https://shopiots.com/product/himu" class="product-media">
              <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" alt="হিমু"
                class="product-img product-img--main">
              <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="হিমু"
                class="product-img product-img--hover">
              <span class="discount-badge">
                <strong>১৭%</strong>
                <small>ছাড়</small>
              </span>
            </a>
            <div class="product-body">
              <h3 class="product-title">হিমু - হুমায়ূন আহমেদ</h3>
              <div class="product-price">
                <span class="price-old">৳ ১,৬০০</span>
                <span class="price-new">৳ ৯৫০.০০</span>
              </div>
              <button class="btn add-to-bag-btn home-buy-now" data-id="87" data-name="হিমু" data-price="950.00"
                data-image="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" data-slug="himu"
                data-url="https://shopiots.com/product/himu">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg> -->
                <span>অর্ডার করুন</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 2 -->
        <div class="col">
          <div class="product-card h-100">
            <a href="https://shopiots.com/product/debdas" class="product-media">
              <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="দেবদাস"
                class="product-img product-img--main">
              <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" alt="দেবদাস"
                class="product-img product-img--hover">
              <span class="discount-badge">
                <strong>১৭%</strong>
                <small>ছাড়</small>
              </span>
            </a>
            <div class="product-body">
              <h3 class="product-title">দেবদাস - শরৎচন্দ্র চট্টোপাধ্যায়</h3>
              <div class="product-price">
                <span class="price-old">৳ ১,৬০০</span>
                <span class="price-new">৳ ১২০.০০</span>
              </div>
              <button class="btn add-to-bag-btn home-buy-now" data-id="88" data-name="দেবদাস" data-price="120.00"
                data-image="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" data-slug="debdas"
                data-url="https://shopiots.com/product/debdas">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg> -->
                <span>অর্ডার করুন</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 3 -->
        <div class="col">
          <div class="product-card h-100">
            <a href="https://shopiots.com/product/gitanjali" class="product-media">
              <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80" alt="গীতাঞ্জলি"
                class="product-img product-img--main">
              <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="গীতাঞ্জলি"
                class="product-img product-img--hover">
              <span class="discount-badge">
                <strong>১৭%</strong>
                <small>ছাড়</small>
              </span>
            </a>
            <div class="product-body">
              <h3 class="product-title">গীতাঞ্জলি - রবীন্দ্রনাথ ঠাকুর</h3>
              <div class="product-price">
                <span class="price-old">৳ ১,৬০০.০০</span>
                <span class="price-new">৳ ১,৫০০.০০</span>
              </div>
              <button class="btn add-to-bag-btn home-buy-now" data-id="89" data-name="গীতাঞ্জলি" data-price="1500.00"
                data-image="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80"
                data-slug="gitanjali" data-url="https://shopiots.com/product/gitanjali">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg> -->
                <span>অর্ডার করুন</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 4 -->
        <div class="col">
          <div class="product-card h-100">
            <a href="https://shopiots.com/product/bidrohi" class="product-media">
              <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=500&q=80" alt="বিদ্রোহী"
                class="product-img product-img--main">
              <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80" alt="বিদ্রোহী"
                class="product-img product-img--hover">
              <span class="discount-badge">
                <strong>১৭%</strong>
                <small>ছাড়</small>
              </span>
            </a>
            <div class="product-body">
              <h3 class="product-title">বিদ্রোহী - কাজী নজরুল ইসলাম</h3>
              <div class="product-price">
                <span class="price-old">৳ ৭০০.০০</span>
                <span class="price-new">৳ ৫০০.০০</span>
              </div>
              <button class="btn add-to-bag-btn home-buy-now" data-id="90" data-name="বিদ্রোহী" data-price="500.00"
                data-image="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=500&q=80" data-slug="bidrohi"
                data-url="https://shopiots.com/product/bidrohi">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg> -->
                <span>অর্ডার করুন</span>
              </button>
            </div>
          </div>
        </div>
        <!-- Card End -->

      </div>
      <div class="row row-cols-2 row-cols-lg-4 g-2 py-5">

        <!-- Product Card 1 -->
        <div class="col">
          <div class="product-card h-100">
            <a href="https://shopiots.com/product/himu" class="product-media">
              <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" alt="হিমু"
                class="product-img product-img--main">
              <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="হিমু"
                class="product-img product-img--hover">
              <span class="discount-badge">
                <strong>১৭%</strong>
                <small>ছাড়</small>
              </span>
            </a>
            <div class="product-body">
              <h3 class="product-title">হিমু - হুমায়ূন আহমেদ</h3>
              <div class="product-price">
                <span class="price-old">৳ ১,৬০০</span>
                <span class="price-new">৳ ৯৫০.০০</span>
              </div>
              <button class="btn add-to-bag-btn home-buy-now" data-id="87" data-name="হিমু" data-price="950.00"
                data-image="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" data-slug="himu"
                data-url="https://shopiots.com/product/himu">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg> -->
                <span>অর্ডার করুন</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 2 -->
        <div class="col">
          <div class="product-card h-100">
            <a href="https://shopiots.com/product/debdas" class="product-media">
              <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="দেবদাস"
                class="product-img product-img--main">
              <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&q=80" alt="দেবদাস"
                class="product-img product-img--hover">
              <span class="discount-badge">
                <strong>১৭%</strong>
                <small>ছাড়</small>
              </span>
            </a>
            <div class="product-body">
              <h3 class="product-title">দেবদাস - শরৎচন্দ্র চট্টোপাধ্যায়</h3>
              <div class="product-price">
                <span class="price-old">৳ ১,৬০০</span>
                <span class="price-new">৳ ১২০.০০</span>
              </div>
              <button class="btn add-to-bag-btn home-buy-now" data-id="88" data-name="দেবদাস" data-price="120.00"
                data-image="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" data-slug="debdas"
                data-url="https://shopiots.com/product/debdas">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg> -->
                <span>অর্ডার করুন</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 3 -->
        <div class="col">
          <div class="product-card h-100">
            <a href="https://shopiots.com/product/gitanjali" class="product-media">
              <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80" alt="গীতাঞ্জলি"
                class="product-img product-img--main">
              <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80" alt="গীতাঞ্জলি"
                class="product-img product-img--hover">
              <span class="discount-badge">
                <strong>১৭%</strong>
                <small>ছাড়</small>
              </span>
            </a>
            <div class="product-body">
              <h3 class="product-title">গীতাঞ্জলি - রবীন্দ্রনাথ ঠাকুর</h3>
              <div class="product-price">
                <span class="price-old">৳ ১,৬০০.০০</span>
                <span class="price-new">৳ ১,৫০০.০০</span>
              </div>
              <button class="btn add-to-bag-btn home-buy-now" data-id="89" data-name="গীতাঞ্জলি" data-price="1500.00"
                data-image="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80"
                data-slug="gitanjali" data-url="https://shopiots.com/product/gitanjali">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg> -->
                <span>অর্ডার করুন</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Product Card 4 -->
        <div class="col">
          <div class="product-card h-100">
            <a href="https://shopiots.com/product/bidrohi" class="product-media">
              <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=500&q=80" alt="বিদ্রোহী"
                class="product-img product-img--main">
              <img src="https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=500&q=80" alt="বিদ্রোহী"
                class="product-img product-img--hover">
              <span class="discount-badge">
                <strong>১৭%</strong>
                <small>ছাড়</small>
              </span>
            </a>
            <div class="product-body">
              <h3 class="product-title">বিদ্রোহী - কাজী নজরুল ইসলাম</h3>
              <div class="product-price">
                <span class="price-old">৳ ৭০০.০০</span>
                <span class="price-new">৳ ৫০০.০০</span>
              </div>
              <button class="btn add-to-bag-btn home-buy-now" data-id="90" data-name="বিদ্রোহী" data-price="500.00"
                data-image="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=500&q=80" data-slug="bidrohi"
                data-url="https://shopiots.com/product/bidrohi">

                <span>অর্ডার করুন</span>
              </button>
            </div>
          </div>
        </div>
        <!-- Card End -->

      </div>
    </div>
  </section>

@endsection