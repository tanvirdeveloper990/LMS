@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <main>


        <!-- ================= BANNER SLIDER ================= -->
        <section class="banner-slider" id="bannerSlider">
            <div class="banner-track">
                @foreach ($banner as $item)
                <div class="banner-slide active">
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}">
                </div>
                @endforeach

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

                    <div class="cs-card cs-card--c1">
                        <div class="cs-illustration">
                            <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?w=400&h=400&fit=crop&auto=format&q=80"
                                alt="৫ম শ্রেণি">
                        </div>
                        <h3 class="cs-card-title">৫ম শ্রেণি</h3>
                        <a href="#" class="cs-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="cs-card cs-card--c2">
                        <div class="cs-illustration">
                            <img src="https://images.unsplash.com/photo-1560785496-3c9d27877182?w=400&h=400&fit=crop&auto=format&q=80"
                                alt="৬ষ্ঠ শ্রেণি">
                        </div>
                        <h3 class="cs-card-title">৬ষ্ঠ শ্রেণি</h3>
                        <a href="#" class="cs-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="cs-card cs-card--c3">
                        <div class="cs-illustration">
                            <img src="https://images.unsplash.com/photo-1554721299-e0b8aa7666ce?w=400&h=400&fit=crop&auto=format&q=80"
                                alt="৭ম শ্রেণি">
                        </div>
                        <h3 class="cs-card-title">৭ম শ্রেণি</h3>
                        <a href="#" class="cs-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="cs-card cs-card--c4">
                        <div class="cs-illustration">
                            <img src="https://images.unsplash.com/photo-1610500796385-3ffc1ae2f046?w=400&h=400&fit=crop&auto=format&q=80"
                                alt="৮ম শ্রেণি">
                        </div>
                        <h3 class="cs-card-title">৮ম শ্রেণি</h3>
                        <a href="#" class="cs-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="cs-card cs-card--c5">
                        <div class="cs-illustration">
                            <img src="https://images.unsplash.com/photo-1540151812223-c30b3fab58e6?w=400&h=400&fit=crop&auto=format&q=80"
                                alt="৯ম শ্রেণি">
                        </div>
                        <h3 class="cs-card-title">৯ম শ্রেণি</h3>
                        <a href="#" class="cs-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="cs-card cs-card--c6">
                        <div class="cs-illustration">
                            <img src="https://images.unsplash.com/photo-1585432959445-662c9bbcd91d?w=400&h=400&fit=crop&auto=format&q=80"
                                alt="১০ম শ্রেণি">
                        </div>
                        <h3 class="cs-card-title">১০ম শ্রেণি</h3>
                        <a href="#" class="cs-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

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

                    <div class="pc-card pc-card--c1">
                        <div class="pc-icon-badge">🏆</div>
                        <h3 class="pc-card-title">প্রাথমিক বৃত্তি পরীক্ষা</h3>
                        <p class="pc-card-desc">৫ম শ্রেণির জন্য বিশেষ প্রস্তুতি</p>
                        <a href="#" class="pc-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="pc-card pc-card--c2">
                        <div class="pc-icon-badge">🥇</div>
                        <h3 class="pc-card-title">জুনিয়র বৃত্তি পরীক্ষা</h3>
                        <p class="pc-card-desc">৮ম শ্রেণির জন্য বিশেষ প্রস্তুতি</p>
                        <a href="#" class="pc-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="pc-card pc-card--c3">
                        <div class="pc-icon-badge">🎯</div>
                        <h3 class="pc-card-title">SSC প্রস্তুতি কোর্স</h3>
                        <p class="pc-card-desc">৯ম ও ১০ম শ্রেণির জন্য বিশেষ প্রস্তুতি</p>
                        <a href="#" class="pc-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="pc-card pc-card--c4">
                        <div class="pc-icon-badge">📋</div>
                        <h3 class="pc-card-title">মডেল টেস্ট সিরিজ</h3>
                        <p class="pc-card-desc">নিয়মিত অনুশীলনে নিশ্চিত সাফল্য</p>
                        <a href="#" class="pc-card-btn">কোর্স দেখুন <i class="bi bi-arrow-right"></i></a>
                    </div>

                </div>
            </div>
        </section>

        <!-- ================= WHY CHOOSE US SECTION ================= -->
        @php
            $about = \App\Models\About::first();
        @endphp

        <section class="why-us-section">
            <div class="container">
                <div class="why-us-grid">

                    <!-- Left: Image + floating stat card -->
                    <div class="why-us-media">
                        <div class="why-us-img-wrap">
                            <img src="{{ !empty($about->image) ? asset('storage/' . $about->image) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=700&h=780&fit=crop&auto=format&q=80' }}"
                                alt="শিক্ষার্থী পড়াশোনা করছে">
                        </div>

                        <div class="why-us-stat-card">
                            <div class="why-us-stat-icon">
                                @if (!empty($about->badge_image))
                                    <img src="{{ asset('storage/' . $about->badge_image) }}" alt="badge"
                                        style="width:24px;height:24px;object-fit:contain;">
                                @else
                                    <i class="bi bi-mortarboard-fill"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="why-us-stat-number">{{ $about->badge_title ?? '৫০,০০০+' }}</h4>
                                <p class="why-us-stat-label">{{ $about->badge_subtitle ?? 'সন্তুষ্ট শিক্ষার্থী' }}</p>
                            </div>
                        </div>

                        <span class="why-us-blob why-us-blob--1"></span>
                        <span class="why-us-blob why-us-blob--2"></span>
                    </div>

                    <!-- Right: Content -->
                    <div class="why-us-content">
                        <span class="why-us-tag">{{ $about->badge_text ?? 'কেন আমাদের বেছে নেবে' }}</span>
                        <h2 class="why-us-title">
                            {{ $about->title_1 ?? 'তোমার সাফল্যের পথে' }}
                            <span class="why-us-accent">{{ $about->title_2 ?? 'বিশ্বস্ত সঙ্গী' }}</span>
                        </h2>
                        <p class="why-us-desc">
                            {{ $about->description ?? 'অভিজ্ঞ শিক্ষক, মানসম্মত কনটেন্ট আর নিয়মিত পরীক্ষার মাধ্যমে আমরা প্রতিটি শিক্ষার্থীর শেখার যাত্রাকে সহজ ও কার্যকর করে তুলি।' }}
                        </p>

                        <div class="why-us-features">

                            @php
                                $defaultIcons = [
                                    1 => 'bi-camera-video-fill',
                                    2 => 'bi-person-video3',
                                    3 => 'bi-clipboard2-check-fill',
                                    4 => 'bi-headset',
                                ];
                                $defaultTitles = [
                                    1 => 'লাইভ ও রেকর্ডেড ক্লাস',
                                    2 => 'অভিজ্ঞ শিক্ষকমণ্ডলী',
                                    3 => 'নিয়মিত মডেল টেস্ট',
                                    4 => '২৪/৭ সাপোর্ট',
                                ];
                                $defaultSubtitles = [
                                    1 => 'যেকোনো সময় নিজের সুবিধামতো ক্লাস দেখার সুযোগ।',
                                    2 => 'দেশসেরা শিক্ষকদের কাছ থেকে সরাসরি শেখার সুযোগ।',
                                    3 => 'পরীক্ষার প্রস্তুতি যাচাইয়ে নিয়মিত মূল্যায়ন ব্যবস্থা।',
                                    4 => 'যেকোনো সমস্যায় সার্বক্ষণিক সহায়তা পাবে।',
                                ];
                            @endphp

                            @for ($i = 1; $i <= 4; $i++)
                                <div class="why-us-feature">
                                    <div class="why-us-feature-icon why-us-icon--c{{ $i }}">
                                        @if (!empty($about->{"card{$i}_image"}))
                                            <img src="{{ asset('storage/' . $about->{"card{$i}_image"}) }}"
                                                alt="card{{ $i }}"
                                                style="width:22px;height:22px;object-fit:contain;">
                                        @else
                                            <i class="bi {{ $defaultIcons[$i] }}"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4>{{ $about->{"card{$i}_title"} ?? $defaultTitles[$i] }}</h4>
                                        <p>{{ $about->{"card{$i}_subtitle"} ?? $defaultSubtitles[$i] }}</p>
                                    </div>
                                </div>
                            @endfor

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
                            <rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor"
                                stroke-width="2" />
                            <rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor"
                                stroke-width="2" />
                            <rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor"
                                stroke-width="2" />
                            <rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor"
                                stroke-width="2" />
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
                                <p class="c7-card-desc">বাংলা, ইংরেজি, গণিত, বিজ্ঞান, সাধারণ জ্ঞান ও আইসিটি - সকল বিষয়ের
                                    সম্পূর্ণ
                                    প্রস্তুতি</p>
                                <a href="course-details.html" class="c7-card-btn purple">বিস্তারিত দেখুন
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
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
                                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
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
                                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
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
                                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
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
        @php
            $ebookLibrary = \App\Models\EbookLibrary::first();
        @endphp

        <section class="ebook-section">
            <div class="dot-grid"></div>
            <div class="container position-relative">
                <div class="row align-items-center ebook-row">

                    <div class="col-lg-6">
                        <div class="ebook-content">
                            <span class="ebook-badge">
                                <i class="bi bi-bookmark-fill"></i>
                                {{ $ebookLibrary->badge_text ?? 'ই-বুক লাইব্রেরি' }}
                            </span>

                            <h3 class="ebook-heading">{{ $ebookLibrary->title_1 ?? 'শেখার সেরা সঙ্গী' }}</h3>
                            <h1 class="ebook-heading-main">{{ $ebookLibrary->title_2 ?? 'আমাদের ই-বুক' }}</h1>

                            <p class="ebook-desc">
                                {{ $ebookLibrary->description ?? 'পাঠ্যবই, গাইড, নোটস ও রেফারেন্স বই এখন এক জায়গায়। যে কোনো সময়, যে কোনো ডিভাইসে পড়ুন সহজেই।' }}
                            </p>

                            <ul class="ebook-features">

                                @for ($i = 1; $i <= 3; $i++)
                                    <li>
                                        <div class="feature-icon">
                                            @if (!empty($ebookLibrary->{"card{$i}_image"}))
                                                <img src="{{ asset('storage/' . $ebookLibrary->{"card{$i}_image"}) }}"
                                                    alt="feature{{ $i }}"
                                                    style="width:20px;height:20px;object-fit:contain;">
                                            @else
                                                <i class="bi {{ $defaultIcons[$i] }}"></i>
                                            @endif
                                        </div>
                                        <div class="feature-text">
                                            <h6>{{ $ebookLibrary->{"card{$i}_title"} ?? $defaultTitles[$i] }}</h6>
                                            <p>{{ $ebookLibrary->{"card{$i}_subtitle"} ?? $defaultSubtitles[$i] }}</p>
                                        </div>
                                    </li>
                                @endfor
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
                                <img src="{{ !empty($ebookLibrary->image) ? asset('storage/' . $ebookLibrary->image) : asset('assets/img/ebook/ebook.png') }}"
                                    alt="ই-বুক লাইব্রেরি" class="ebook-img">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!--faq section   -->
        <!--faq section   -->
       @php
    $faqs = \App\Models\Faq::where('status', 1)->latest()->get();
@endphp

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

        @forelse($faqs as $faq)
            <div class="faq-item">
                <button class="faq-item-header" type="button">
                    <span class="faq-icon">
                        @if($faq->image)
                            <img src="{{ asset('storage/'.$faq->image) }}" alt="icon" style="width:20px;height:20px;object-fit:contain;">
                        @else
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="6" y="4" width="12" height="16" rx="2" />
                                <path d="M9 4V3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1" />
                                <line x1="9" y1="11" x2="15" y2="11" />
                                <line x1="9" y1="15" x2="13" y2="15" />
                            </svg>
                        @endif
                    </span>
                    <span class="faq-item-body">
                        <p class="faq-item-title">{{ $faq->title }}</p>
                        <span class="faq-item-answer"><span class="faq-item-answer-inner">
                            <p class="faq-item-desc">{{ $faq->description }}</p>
                        </span></span>
                    </span>
                    <span class="faq-chevron">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </span>
                </button>
            </div>
        @empty
            <p class="text-center text-muted">কোনো প্রশ্ন পাওয়া যায়নি।</p>
        @endforelse

    </div>

    <div class="faq-cta">
        <div class="faq-cta-left">
            <span class="faq-cta-illustration">
                <svg viewBox="0 0 56 56" fill="none">
                    <rect x="6" y="30" width="30" height="7" rx="1.5" fill="var(--c7-blue)" />
                    <rect x="9" y="24" width="27" height="7" rx="1.5" fill="var(--c7-green)" />
                    <rect x="6" y="18" width="30" height="7" rx="1.5" fill="var(--c7-orange)" />
                    <path d="M14 18c0-6 5-9 9-9 4 0 9 3 9 9" stroke="var(--c7-purple)" stroke-width="2" fill="none" stroke-linecap="round" />
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
     @php
    $reviews = \App\Models\CustomerReview::where('status', 1)->latest()->get();
@endphp

<section class="review-section">
    <div class="container">

        <div class="review-header">
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

                @forelse($reviews as $review)
                    <div class="slide-item">
                        <div class="review-card d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ $review->image ? asset('storage/'.$review->image) : asset('assets/img/customer/default-avatar.jpg') }}"
                                    alt="{{ $review->name }}" class="reviewer-img">
                                <div>
                                    <h6 class="mb-1 fw-bold" style="font-size:.9rem;">{{ $review->name }}</h6>
                                    {{-- <div class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star {{ $i <= ($review->rating ?? 5) ? 'star-on' : 'star-off' }}"></i>
                                        @endfor
                                    </div> --}}
                                </div>
                            </div>
                            <div class="review-body flex-grow-1">
                                <p>{{ $review->review_text }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="slide-item">
                        <div class="review-card d-flex flex-column">
                            <p class="text-center text-muted">এখনো কোনো রিভিউ যোগ করা হয়নি।</p>
                        </div>
                    </div>
                @endforelse

            </div><!-- /slides-track -->
        </div><!-- /slides-wrapper -->

        <!-- Dots -->
        <div class="slider-dots" id="sliderDots"></div>

    </div>
</section>

    </main>

@endsection

@section('script')

@endsection
