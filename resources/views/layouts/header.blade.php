 @php
     use App\Models\Wishlist;
     $wishlistCount = 0;
     if (auth()->check()) {
         $wishlistCount = Wishlist::where('user_id', auth()->id())->count();
     }
 @endphp

 @php
     $courses = \App\Models\Category::where('status', 1)->where('type', 'course')->orderBy('serial')->get();
     $preparations = \App\Models\Category::where('status', 1)->where('type', 'preparation')->orderBy('serial')->get();
 @endphp



 <!-- ================= NOTICE MARQUEE BAR ================= -->
 <div class="notice-bar" style="background: {{ $setting->marquee_bg_color ?? '#ffffff' }};">
     <div class="notice-icon"><i class="bi bi-megaphone-fill"></i></div>
     <div class="marquee-wrap">
         <div class="marquee-track"
             style="animation-duration: {{ $setting->marquee_speed ?? '40s' }};
                  color: {{ $setting->marquee_text_color ?? '#111827' }};">

             <span>{{ $setting->scrolling_text_1 ?? '' }}</span>
             <span class="notice-sep" style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>

             <span>{{ $setting->scrolling_text_2 ?? '' }}</span>
             <span class="notice-sep" style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>

             <span>{{ $setting->scrolling_text_3 ?? '' }}</span>
             <span class="notice-sep" style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>

             <!-- duplicate for seamless loop -->
             <span aria-hidden="true">{{ $setting->scrolling_text_1 ?? '' }}</span>
             <span class="notice-sep" aria-hidden="true"
                 style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>

             <span aria-hidden="true">{{ $setting->scrolling_text_2 ?? '' }}</span>
             <span class="notice-sep" aria-hidden="true"
                 style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>

             <span aria-hidden="true">{{ $setting->scrolling_text_3 ?? '' }}</span>
             <span class="notice-sep" aria-hidden="true"
                 style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>
         </div>
     </div>
 </div>

 <!-- ================= HEADER ================= -->
 <header class="site-header">
     <div class="container">
         <div class="header-inner">

             <!-- mobile hamburger -->
             <button class="menu-toggle d-lg-none" type="button" data-bs-toggle="offcanvas"
                 data-bs-target="#mobileSidebar" aria-label="মেনু খুলুন">
                 <i class="bi bi-list"></i>
             </button>

             <!-- logo -->
             <a href="/" class="logo">
                 <img src="{{ Storage::url($setting->header_logo) }}" alt="{{ $setting->company_name }}">
             </a>

             <!-- desktop nav -->
             <nav class="main-nav d-none d-lg-flex">
                 <ul>
                     <li><a href="/">হোম</a></li>
                     <li><a href="#">আমাদের সম্পর্কে</a></li>
                     <li><a href="free-course.html">ফ্রি কোর্স</a></li>

                     <li><a href="all-course.html">সকল কোর্স</a></li>
                     <li class="has-dropdown">
                         <a href="#">ক্যাটাগরিসমূহ<i class="bi bi-chevron-down"></i></a>
                         <ul class="dropdown-panel">



                             <li class="has-submenu">
                                 <a href="#">শ্রেণিভিত্তিক কোর্স <i
                                         class="bi bi-chevron-right submenu-arrow"></i></a>
                                 <ul class="submenu-panel">
                                     @foreach ($courses as $course)
                                         <li><a href="#">{{ $course->name }}</a></li>
                                     @endforeach
                                 </ul>
                             </li>

                             <li class="has-submenu">
                                 <a href="#">পরীক্ষা প্রস্তুতি <i
                                         class="bi bi-chevron-right submenu-arrow"></i></a>
                                 <ul class="submenu-panel">
                                     @foreach ($preparations as $preparation)
                                         <li><a href="#">{{ $preparation->name }}</a></li>
                                     @endforeach
                                 </ul>
                             </li>

                         </ul>
                     </li>
                     <li><a href="{{ route('ebook') }}">ই-বুক</a></li>
                     <li><a href="#">শপ</a></li>
                 </ul>
             </nav>

             <!-- login/register (desktop) -->
             <div class="header-actions d-none d-lg-flex">
                 <a href="{{ route('login') }}" class="btn-auth"><i class="bi bi-person-circle"></i> লগ ইন /
                     রেজিস্ট্রেশন</a>
             </div>

             <!-- spacer to keep logo centered on mobile -->
             <div class="header-spacer d-lg-none" aria-hidden="true"></div>

         </div>
     </div>
 </header>

 <!-- ================= MOBILE OFFCANVAS SIDEBAR ================= -->
 <div class="offcanvas offcanvas-start mobile-sidebar" tabindex="-1" id="mobileSidebar">
     <div class="offcanvas-header">
         <a href="/"><img src="{{ Storage::url($setting->header_logo) }}" alt="{{ $setting->company_name }}"
                 class="sidebar-logo"></a>
         <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="বন্ধ করুন"></button>
     </div>
     <div class="offcanvas-body">
         <ul class="sidebar-nav">
             <li><a href="index.html">হোম</a></li>
             <li><a href="#">আমাদের সম্পর্কে</a></li>
             <li><a href="free-course.html">ফ্রি কোর্স</a></li>

             <li><a href="all-course.html">সকল কোর্স</a></li>

             <li class="has-dropdown">
                 <button type="button" class="dropdown-trigger">ক্যাটাগরিসমূহ <i
                         class="bi bi-chevron-down"></i></button>
                 <ul class="dropdown-panel-mobile">

                     <li class="has-submenu-mobile">
                         <button type="button" class="submenu-trigger">শ্রেণিভিত্তিক কোর্স <i
                                 class="bi bi-chevron-down submenu-arrow-mobile"></i></button>
                         <ul class="submenu-panel-mobile">
                             @foreach ($courses as $course)
                                 <li><a href="#">{{ $course->name }}</a></li>
                             @endforeach
                         </ul>
                     </li>

                     <li class="has-submenu-mobile">
                         <button type="button" class="submenu-trigger">পরীক্ষা প্রস্তুতি <i
                                 class="bi bi-chevron-down submenu-arrow-mobile"></i></button>
                         <ul class="submenu-panel-mobile">
                             @foreach ($courses as $course)
                                 <li><a href="#">{{ $course->name }}</a></li>
                             @endforeach
                         </ul>
                     </li>

                 </ul>
             </li>

             <li><a href="{{ route('ebook') }}">ই-বুক</a></li>
             <li><a href="#">শপ</a></li>
         </ul>
         <a href="{{ route('login') }}" class="btn-auth btn-auth-mobile"><i class="bi bi-person-circle"></i> লগ ইন /
             রেজিস্ট্রেশন</a>
     </div>
 </div>
