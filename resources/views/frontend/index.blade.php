@extends('layouts.app')

@section('title', 'Home')

@section('content')

<main>


 <!-- ================= BANNER SLIDER ================= -->
  <section class="banner-slider" id="bannerSlider">
    <div class="banner-track">
      <div class="banner-slide active">
        <img src="assets/img/banner/banner2.png" alt="Banner">
      </div>
      <div class="banner-slide active">
        <img src="assets/img/banner/banner3.png" alt="Banner">
      </div>
      <div class="banner-slide active">
        <img src="assets/img/banner/banner1.png" alt="Banner">
      </div>
    </div>

    <button class="banner-arrow banner-prev" aria-label="আগের ব্যানার"><i class="bi bi-chevron-left"></i></button>
    <button class="banner-arrow banner-next" aria-label="পরের ব্যানার"><i class="bi bi-chevron-right"></i></button>

    <div class="banner-dots"></div>
  </section>

  <!-- ================= CLASS SELECT SECTION ================= -->
  <section class="class-select-section">
    <div class="container">

      <div class="cs-header">
        <span class="cs-icon">🎓</span>
        <h2 class="cs-title">তোমার <span class="cs-accent cs-accent-blue">শ্রেণি</span> ও <span
            class="cs-accent cs-accent-orange">কোর্স</span> নির্বাচন করো</h2>
        <p class="cs-subtitle">তোমার জন্য উপযুক্ত ক্লাস ও কোর্স বেছে নাও এবং শেখা শুরু করো আজই।</p>
      </div>

      <div class="cs-grid">

          @foreach($courses as $course)
          <div class="cs-card cs-card--c{{ ($loop->index % 6) + 1 }}">
              <div class="cs-illustration">
                  <img
                      src="{{ Storage::url($course->image) }}"
                      alt="{{ $course->name }}">
              </div>
              <h3 class="cs-card-title">{{ $course->name }}</h3>
              <a href="#" class="cs-card-btn">
                  কোর্স দেখুন <i class="bi bi-arrow-right"></i>
              </a>
          </div>
          @endforeach

      </div>
    </div>
  </section>
  <!--  -->
  <!-- ================= SPECIAL PREP COURSES SECTION ================= -->
  <section class="prep-courses-section">
    <div class="container">

      <div class="pc-header">
        <div class="pc-title-row">
          <span class="pc-line"></span>
          <span class="pc-icon">🎓</span>
          <h2 class="pc-title"><span class="pc-accent-teal">বিশেষ প্রস্তুতি</span> <span
              class="pc-accent-blue">কোর্সসমূহ</span></h2>
          <span class="pc-line"></span>
        </div>
        <p class="pc-subtitle">বিভিন্ন পরীক্ষা ও প্রয়োজন অনুযায়ী সাজানো বিশেষ প্রস্তুতি কোর্স।</p>
      </div>

      <div class="pc-grid">


        @foreach($preparations as $preparation)
        <div class="pc-card pc-card--c{{ ($loop->index % 4) + 1 }}">
          <div class="pc-icon-badge">
              <img src="{{ Storage::url($preparation->image) }}" alt="{{ $preparation->name }}">
          </div>
          <h3 class="pc-card-title">{{ $preparation->name }}</h3>
          <p class="pc-card-desc">{{ $preparation->text }}</p>
          <a href="#" class="pc-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
        </div>
        @endforeach

       

      </div>
    </div>
  </section>

  <!-- ================= WHY CHOOSE US SECTION ================= -->
  <section class="why-us-section">
    <div class="container">
      <div class="why-us-grid">

        <!-- Left: Image + floating stat card -->
        <div class="why-us-media">
          <div class="why-us-img-wrap">
            <img
              src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=700&h=780&fit=crop&auto=format&q=80"
              alt="শিক্ষার্থী পড়াশোনা করছে">
          </div>

          <div class="why-us-stat-card">
            <div class="why-us-stat-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div>
              <h4 class="why-us-stat-number">৫০,০০০+</h4>
              <p class="why-us-stat-label">সন্তুষ্ট শিক্ষার্থী</p>
            </div>
          </div>

          <span class="why-us-blob why-us-blob--1"></span>
          <span class="why-us-blob why-us-blob--2"></span>
        </div>

        <!-- Right: Content -->
        <div class="why-us-content">
          <span class="why-us-tag">কেন আমাদের বেছে নেবে</span>
          <h2 class="why-us-title">তোমার সাফল্যের পথে <span class="why-us-accent">বিশ্বস্ত সঙ্গী</span></h2>
          <p class="why-us-desc">
            অভিজ্ঞ শিক্ষক, মানসম্মত কনটেন্ট আর নিয়মিত পরীক্ষার মাধ্যমে আমরা প্রতিটি শিক্ষার্থীর শেখার যাত্রাকে সহজ ও
            কার্যকর করে তুলি।
          </p>

          <div class="why-us-features">

            <div class="why-us-feature">
              <div class="why-us-feature-icon why-us-icon--c1"><i class="bi bi-camera-video-fill"></i></div>
              <div>
                <h4>লাইভ ও রেকর্ডেড ক্লাস</h4>
                <p>যেকোনো সময় নিজের সুবিধামতো ক্লাস দেখার সুযোগ।</p>
              </div>
            </div>

            <div class="why-us-feature">
              <div class="why-us-feature-icon why-us-icon--c2"><i class="bi bi-person-video3"></i></div>
              <div>
                <h4>অভিজ্ঞ শিক্ষকমণ্ডলী</h4>
                <p>দেশসেরা শিক্ষকদের কাছ থেকে সরাসরি শেখার সুযোগ।</p>
              </div>
            </div>

            <div class="why-us-feature">
              <div class="why-us-feature-icon why-us-icon--c3"><i class="bi bi-clipboard2-check-fill"></i></div>
              <div>
                <h4>নিয়মিত মডেল টেস্ট</h4>
                <p>পরীক্ষার প্রস্তুতি যাচাইয়ে নিয়মিত মূল্যায়ন ব্যবস্থা।</p>
              </div>
            </div>

            <div class="why-us-feature">
              <div class="why-us-feature-icon why-us-icon--c4"><i class="bi bi-headset"></i></div>
              <div>
                <h4>২৪/৭ সাপোর্ট</h4>
                <p>যেকোনো সমস্যায় সার্বক্ষণিক সহায়তা পাবে।</p>
              </div>
            </div>

          </div>

          <a href="#" class="why-us-btn">সকল কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
        </div>

      </div>
    </div>
  </section>

  <!-- c7 -->
  <section class="c7-section">
    <div class="c7-wrap">

      <!-- Header -->
      <div class="c7-header">
        <h2 class="c7-title">Class 7</h2>
        <a href="course.html" class="c7-viewall-btn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2" />
            <rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2" />
            <rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2" />
            <rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2" />
          </svg>
          সবগুলো দেখুন
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </a>
      </div>

      <!-- Tabs -->
      <div class="c7-tabs" id="c7Tabs">
        <button class="c7-tab-btn active" data-year="all">All</button>
        <button class="c7-tab-btn" data-year="2026">2026</button>
        <button class="c7-tab-btn" data-year="2028">2028</button>
        <button class="c7-tab-btn" data-year="2027">2027</button>
      </div>

      <!-- Carousel -->
      <div class="c7-carousel-outer">
        <button class="c7-arrow c7-arrow-left" id="c7ArrowLeft" aria-label="আগের কোর্স">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>

        <div class="c7-track" id="c7Track">

          <!-- Card 1 -->
          <div class="c7-card" data-year="2026">
            <div class="c7-card-banner purple">
              <img class="c7-banner-img" src="assets/img/banner/1.jpg" alt="">
            </div>
            <div class="c7-card-body">
              <h4 class="c7-card-heading">৭ম শ্রেণি সম্পূর্ণ ব্যাচ</h4>
              <p class="c7-card-desc">বাংলা, ইংরেজি, গণিত, বিজ্ঞান, সাধারণ জ্ঞান ও আইসিটি - সকল বিষয়ের সম্পূর্ণ
                প্রস্তুতি</p>
              <a href="course-details.html" class="c7-card-btn purple">বিস্তারিত দেখুন
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                  <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="c7-card" data-year="2026">
            <div class="c7-card-banner blue">
              <img class="c7-banner-img" src="assets/img/banner/2.jpg" alt="">
            </div>
            <div class="c7-card-body">
              <h4 class="c7-card-heading">গণিত সম্পূর্ণ কোর্স</h4>
              <p class="c7-card-desc">অধ্যায় ভিত্তিক ক্লাস, অনুশীলনী ও সমাধানসহ সম্পূর্ণ প্রস্তুতি</p>
              <a href="course-details.html" class="c7-card-btn blue">বিস্তারিত দেখুন
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                  <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="c7-card" data-year="2027">
            <div class="c7-card-banner green">
              <img class="c7-banner-img" src="assets/img/banner/1.jpg" alt="">
            </div>
            <div class="c7-card-body">
              <h4 class="c7-card-heading">বাংলা সম্পূর্ণ কোর্স</h4>
              <p class="c7-card-desc">ব্যাকরণ, রচনা, কবিতা, গল্প ও সাহিত্য জানার সম্পূর্ণ প্রস্তুতি</p>
              <a href="course-details.html" class="c7-card-btn green">বিস্তারিত দেখুন
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                  <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="c7-card" data-year="2028">
            <div class="c7-card-banner orange">
              <img class="c7-banner-img" src="assets/img/banner/2.jpg" alt="">
            </div>
            <div class="c7-card-body">
              <h4 class="c7-card-heading">বিজ্ঞান সম্পূর্ণ কোর্স</h4>
              <p class="c7-card-desc">পদার্থ, রসায়ন, জীববিজ্ঞান সকল অধ্যায়ে সহজ ও প্রাঞ্জল ব্যাখ্যা</p>
              <a href="#" class="c7-card-btn orange">বিস্তারিত দেখুন
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                  <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
            </div>
          </div>

        </div>

        <button class="c7-arrow c7-arrow-right" id="c7ArrowRight" aria-label="পরের কোর্স">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
            <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
      </div>

    </div>
  </section>




  <!-- ebook-section -->
  <section class="ebook-section">
    <div class="dot-grid"></div>
    <div class="container position-relative">
      <div class="row align-items-center ebook-row">


        <div class="col-lg-6">
          <div class="ebook-content">
            <span class="ebook-badge">
              <i class="bi bi-bookmark-fill"></i>
              ই-বুক লাইব্রেরি
            </span>

            <h3 class="ebook-heading">শেখার সেরা সঙ্গী</h3>
            <h1 class="ebook-heading-main">আমাদের ই-বুক</h1>

            <p class="ebook-desc">
              পাঠ্যবই, গাইড, নোটস ও রেফারেন্স বই এখন এক জায়গায়। যে কোনো সময়, যে কোনো ডিভাইসে পড়ুন সহজেই।
            </p>

            <ul class="ebook-features">
              <li>
                <div class="feature-icon"><i class="bi bi-collection"></i></div>
                <div class="feature-text">
                  <h6>বিপুল কালেকশন</h6>
                  <p>স্কুল, কলেজ ও ভর্তি পরীক্ষার জন্য সব বই</p>
                </div>
              </li>
              <li>
                <div class="feature-icon"><i class="bi bi-phone"></i></div>
                <div class="feature-text">
                  <h6>যে কোনো ডিভাইসে পড়ুন</h6>
                  <p>মোবাইল, ট্যাব ও কম্পিউটারে সহজে পড়া যায়</p>
                </div>
              </li>
              <li>
                <div class="feature-icon"><i class="bi bi-download"></i></div>
                <div class="feature-text">
                  <h6>ডাউনলোড করে পড়ুন</h6>
                  <p>অফলাইনে পড়ার জন্য ডাউনলোডের সুবিধা</p>
                </div>
              </li>
            </ul>

            <a href="e-book.html" class="btn-ebook">
              ই-বুক দেখুন
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>


        <div class="col-lg-6">
          <div class="ebook-visual">
            <div class="ebook-img-wrap">
              <img src="assets/img/ebook/ebook.png" alt="ই-বুক লাইব্রেরি" class="ebook-img">
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!--faq section   -->
  <!--faq section   -->
  <section class="faq-section">

    <div class="faq-header">
      <div class="faq-eyebrow">
        <span class="dots"><span></span><span></span><span></span></span>
        <span class="line"></span>
        <span class="faq-icon-badge">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9.5 9a2.5 2.5 0 0 1 5 0c0 1.5-2.5 2-2.5 4" />
            <line x1="12" y1="17" x2="12" y2="17.5" />
          </svg>
        </span>
        <span class="line"></span>
        <span class="dots"><span></span><span></span><span></span></span>
      </div>
      <h2 class="faq-title">সাধারণ প্রশ্ন</h2>
      <p class="faq-subtitle">আমাদের শিক্ষার্থীরা যেসব প্রশ্ন বেশি করেন, তার সহজ ও পরিষ্কার উত্তর এখানে দেওয়া হলো।</p>
    </div>

    <div class="faq-list">

      <div class="faq-item">
        <button class="faq-item-header" type="button">
          <span class="faq-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="6" y="4" width="12" height="16" rx="2" />
              <path d="M9 4V3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1" />
              <line x1="9" y1="11" x2="15" y2="11" />
              <line x1="9" y1="15" x2="13" y2="15" />
            </svg>
          </span>
          <span class="faq-item-body">
            <p class="faq-item-title">কীভাবে কোর্সে ভর্তি হব?</p>
            <span class="faq-item-answer"><span class="faq-item-answer-inner">
                <p class="faq-item-desc">ওয়েবসাইটে বা অ্যাপ থেকে আপনার পছন্দের কোর্স সিলেক্ট করুন। এরপর পেমেন্ট সম্পন্ন
                  করুন আপনার একাউন্টে কোর্সটি যুক্ত হয়ে যাবে এবং আপনি ক্লাস শুরু করতে পারবেন।</p>
              </span></span>
          </span>
          <span class="faq-chevron">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </span>
        </button>
      </div>

      <div class="faq-item">
        <button class="faq-item-header" type="button">
          <span class="faq-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="5" y="2" width="14" height="20" rx="2" />
              <line x1="12" y1="18" x2="12.01" y2="18" />
            </svg>
          </span>
          <span class="faq-item-body">
            <p class="faq-item-title">মোবাইল থেকে ক্লাস দেখা যাবে?</p>
            <span class="faq-item-answer"><span class="faq-item-answer-inner">
                <p class="faq-item-desc">হ্যাঁ, আমাদের ওয়েবসাইট ও মোবাইল অ্যাপ সম্পূর্ণ মোবাইল-ফ্রেন্ডলি। আপনি
                  স্মার্টফোন, ট্যাব বা কম্পিউটার — যে কোনো ডিভাইস থেকে ক্লাস দেখতে পারবেন।</p>
              </span></span>
          </span>
          <span class="faq-chevron">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </span>
        </button>
      </div>

      <div class="faq-item">
        <button class="faq-item-header" type="button">
          <span class="faq-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="17" rx="2" />
              <line x1="3" y1="9" x2="21" y2="9" />
              <line x1="8" y1="2" x2="8" y2="5" />
              <line x1="16" y1="2" x2="16" y2="5" />
            </svg>
          </span>
          <span class="faq-item-body">
            <p class="faq-item-title">একটি কোর্স কতদিন ব্যবহার করা যাবে?</p>
            <span class="faq-item-answer"><span class="faq-item-answer-inner">
                <p class="faq-item-desc">প্রতিটি কোর্সের মেয়াদ কোর্স অনুযায়ী নির্ধারিত থাকে। সাধারণত ৩ মাস থেকে ১২ মাস
                  পর্যন্ত ব্যবহার করা যায়। কোর্স পেজেই মেয়াদ উল্লেখ থাকে।</p>
              </span></span>
          </span>
          <span class="faq-chevron">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </span>
        </button>
      </div>

      <div class="faq-item">
        <button class="faq-item-header" type="button">
          <span class="faq-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="8" width="18" height="13" rx="2" />
              <path d="M12 8v13" />
              <path d="M12 8c-1.5-4-6-4-6-1.5S9 8 12 8Z" />
              <path d="M12 8c1.5-4 6-4 6-1.5S15 8 12 8Z" />
            </svg>
          </span>
          <span class="faq-item-body">
            <p class="faq-item-title">ফ্রি কোর্স কীভাবে পাওয়া যাবে?</p>
            <span class="faq-item-answer"><span class="faq-item-answer-inner">
                <p class="faq-item-desc">আমরা নিয়মিত ফ্রি কোর্স, লেকচার ও মডেল টেস্ট দিয়ে থাকি। হোমপেজের কোর্স সেকশন
                  থেকে আপনি সহজেই ফ্রি কোর্স খুঁজে পাবেন।</p>
              </span></span>
          </span>
          <span class="faq-chevron">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </span>
        </button>
      </div>

      <div class="faq-item">
        <button class="faq-item-header" type="button">
          <span class="faq-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="6" width="20" height="14" rx="2" />
              <line x1="2" y1="10" x2="22" y2="10" />
              <line x1="6" y1="15" x2="10" y2="15" />
            </svg>
          </span>
          <span class="faq-item-body">
            <p class="faq-item-title">পেমেন্ট কীভাবে করতে হবে?</p>
            <span class="faq-item-answer"><span class="faq-item-answer-inner">
                <p class="faq-item-desc">আপনি বিকাশ, নগদ, রকেট, কার্ড বা ব্যাংক লেনদেন — যেকোনো সাধারণ পদ্ধতিতে পেমেন্ট
                  করতে পারবেন। সব মাধ্যমই আপনার একাউন্টে তাৎক্ষণিক যুক্ত হয়।</p>
              </span></span>
          </span>
          <span class="faq-chevron">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6 9 12 15 18 9" />
            </svg>
          </span>
        </button>
      </div>

    </div>

    <div class="faq-cta">
      <div class="faq-cta-left">
        <span class="faq-cta-illustration">
          <svg viewBox="0 0 56 56" fill="none">
            <rect x="6" y="30" width="30" height="7" rx="1.5" fill="var(--c7-blue)" />
            <rect x="9" y="24" width="27" height="7" rx="1.5" fill="var(--c7-green)" />
            <rect x="6" y="18" width="30" height="7" rx="1.5" fill="var(--c7-orange)" />
            <path d="M14 18c0-6 5-9 9-9 4 0 9 3 9 9" stroke="var(--c7-purple)" stroke-width="2" fill="none"
              stroke-linecap="round" />
            <circle cx="42" cy="16" r="5" fill="#dcefe0" />
            <path d="M42 20c-3 0-4-3-4-6 3 0 4 2 4 6Z" fill="var(--c7-green)" />
          </svg>
        </span>
        <div>
          <p class="faq-cta-heading">আপনার আরও কোনো প্রশ্ন আছে?</p>
          <p class="faq-cta-text">আমাদের সাপোর্ট টিম সবসময় আপনার পাশে আছে।</p>
        </div>
      </div>
      <button class="faq-cta-btn" type="button">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
        </svg>
        আমাদের সাথে যোগাযোগ করুন
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
          <line x1="5" y1="12" x2="19" y2="12" />
          <polyline points="12 5 19 12 12 19" />
        </svg>
      </button>
    </div>

  </section>

  <!-- ===== REVIEW SECTION ===== -->
  <section class="review-section">
    <div class="container">

      <div class="review-header">
        <!-- <span class="review-badge"><i class="fa-solid fa-comment-dots"></i> শিক্ষার্থী ও অভিভাবকদের সহায়তা</span> -->

        <div class="review-heading-row">
          <i class="fa-solid fa-paper-plane"></i>
          <h2>শিক্ষার্থী ও <span>অভিভাবকদের রিভিউ</span></h2>
        </div>

        <p class="review-subtitle">
          আমাদের সাথে শেখার অভিজ্ঞতা কেমন, জানাচ্ছেন আমাদের শিক্ষার্থী ও তাদের অভিভাবকরা।
        </p>
        <i class="fa-solid fa-quote-right review-quote-icon"></i>
        <span class="review-underline"></span>
      </div>

      <div class="slides-wrapper">
        <div class="slides-track" id="slidesTrack">

          <!-- Review Card 1 -->
          <div class="slide-item">
            <div class="review-card d-flex flex-column">
              <div class="d-flex align-items-center gap-3 mb-3">
                <img src="./assets/img/customer/download.jpg" alt="Saiful Islam" class="reviewer-img">
                <div>
                  <h6 class="mb-1 fw-bold" style="font-size:.9rem;">Saiful Islam</h6>
                  <div class="star-rating">
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                  </div>
                </div>
              </div>
              <div class="review-body flex-grow-1">
                <p>দারুণ প্ল্যাটফর্ম! ক্লাসের মান অসাধারণ, শিক্ষকরা খুব যত্ন নিয়ে পড়ান। সন্তানের রেজাল্টে স্পষ্ট
                  পরিবর্তন দেখতে পাচ্ছি।</p>
              </div>
            </div>
          </div>

          <!-- Review Card 2 -->
          <div class="slide-item">
            <div class="review-card d-flex flex-column">
              <div class="d-flex align-items-center gap-3 mb-3">
                <img src="./assets/img/customer/man.jpg" alt="Tanvir Khan" class="reviewer-img">
                <div>
                  <h6 class="mb-1 fw-bold" style="font-size:.9rem;">Tanvir Khan</h6>
                  <div class="star-rating">
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                  </div>
                </div>
              </div>
              <div class="review-body flex-grow-1">
                <p>দারুণ প্ল্যাটফর্ম! ক্লাসের মান অসাধারণ, শিক্ষকরা খুব যত্ন নিয়ে পড়ান। সন্তানের রেজাল্টে স্পষ্ট
                  পরিবর্তন দেখতে পাচ্ছি।</p>
              </div>
            </div>
          </div>

          <!-- Review Card 3 -->
          <div class="slide-item">
            <div class="review-card d-flex flex-column">
              <div class="d-flex align-items-center gap-3 mb-3">
                <img src="./assets/img/customer/images.jpg" alt="Mawardi Khan" class="reviewer-img">
                <div>
                  <h6 class="mb-1 fw-bold" style="font-size:.9rem;">Mawardi Khan</h6>
                  <div class="star-rating">
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                  </div>
                </div>
              </div>
              <div class="review-body flex-grow-1">
                <p>দারুণ প্ল্যাটফর্ম! ক্লাসের মান অসাধারণ, শিক্ষকরা খুব যত্ন নিয়ে পড়ান। সন্তানের রেজাল্টে স্পষ্ট
                  পরিবর্তন দেখতে পাচ্ছি।</p>
              </div>
            </div>
          </div>

          <!-- Review Card 4 -->
          <div class="slide-item">
            <div class="review-card d-flex flex-column">
              <div class="d-flex align-items-center gap-3 mb-3">
                <img src="./assets/img/customer/images.jpg" alt="Tanvir Khan" class="reviewer-img">
                <div>
                  <h6 class="mb-1 fw-bold" style="font-size:.9rem;">Tanvir Khan</h6>
                  <div class="star-rating">
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                  </div>
                </div>
              </div>
              <div class="review-body flex-grow-1">
                <p>দারুণ প্ল্যাটফর্ম! ক্লাসের মান অসাধারণ, শিক্ষকরা খুব যত্ন নিয়ে পড়ান। সন্তানের রেজাল্টে স্পষ্ট
                  পরিবর্তন দেখতে পাচ্ছি।</p>
              </div>
            </div>
          </div>

          <!-- Review Card 5 -->
          <div class="slide-item">
            <div class="review-card d-flex flex-column">
              <div class="d-flex align-items-center gap-3 mb-3">
                <img src="./assets/img/customer/man.jpg" alt="Mawardi Khan" class="reviewer-img">
                <div>
                  <h6 class="mb-1 fw-bold" style="font-size:.9rem;">Mawardi Khan</h6>
                  <div class="star-rating">
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                    <i class="fa-solid fa-star star-off"></i>
                  </div>
                </div>
              </div>
              <div class="review-body flex-grow-1">
                <p>দারুণ প্ল্যাটফর্ম! ক্লাসের মান অসাধারণ, শিক্ষকরা খুব যত্ন নিয়ে পড়ান। সন্তানের রেজাল্টে স্পষ্ট
                  পরিবর্তন দেখতে পাচ্ছি।</p>
              </div>
            </div>
          </div>

          <!-- Review Card 6 -->
          <div class="slide-item">
            <div class="review-card d-flex flex-column">
              <div class="d-flex align-items-center gap-3 mb-3">
                <img src="./assets/img/customer/download.jpg" alt="Mawardi Khan" class="reviewer-img">
                <div>
                  <h6 class="mb-1 fw-bold" style="font-size:.9rem;">Mawardi Khan</h6>
                  <div class="star-rating">
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-on"></i>
                    <i class="fa-solid fa-star star-off"></i>
                  </div>
                </div>
              </div>
              <div class="review-body flex-grow-1">
                <p>দারুণ প্ল্যাটফর্ম! ক্লাসের মান অসাধারণ, শিক্ষকরা খুব যত্ন নিয়ে পড়ান। সন্তানের রেজাল্টে স্পষ্ট
                  পরিবর্তন দেখতে পাচ্ছি।</p>
              </div>
            </div>
          </div>

        </div><!-- /slides-track -->
      </div><!-- /slides-wrapper -->

      <!-- Dots -->
      <div class="slider-dots" id="sliderDots"></div>

      <!-- Prev / Next -->
      <!-- <div class="slider-nav">
            <button id="prevBtn" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>
            <button id="nextBtn" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>
        </div> -->

    </div>
  </section>


</main>

@endsection

@section('script')

@endsection