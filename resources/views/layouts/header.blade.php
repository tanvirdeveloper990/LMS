 @php
 use App\Models\Wishlist;
 $wishlistCount = 0;
 if (auth()->check()) {
 $wishlistCount = Wishlist::where('user_id', auth()->id())->count();
 }
 @endphp

 <style>
     .search-form {
         position: relative;
         width: 100%;
         overflow: visible !important;
         /* dropdown ঠিকমতো দেখানোর জন্য override */
     }

     .search-input-wrap {
         display: flex;
         width: 100%;
         border: 1.5px solid var(--border-color);
         border-radius: 50px;
         overflow: hidden;
         /* pill shape এখন এই wrapper এ */
         transition: var(--transition);
     }

     .search-form:focus-within .search-input-wrap {
         border-color: var(--primary);
         box-shadow: 0 0 0 4px var(--primary-light);
     }

     .search-input-wrap input {
         border: none;
         outline: none;
         padding: 11px 20px;
         width: 100%;
         font-size: .92rem;
         font-family: var(--font-body);
     }

     .search-input-wrap button {
         border: none;
         background: var(--primary);
         color: #fff;
         padding: 0 20px;
         transition: var(--transition);
     }

     .search-input-wrap button:hover {
         background: var(--primary-dark);
     }

     .search-results-dropdown {
         display: none;
         position: absolute;
         top: 100%;
         left: 0;
         width: 100%;
         background: #fff;
         border: 1px solid #ddd;
         border-radius: 8px;
         box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
         z-index: 999;
         max-height: 380px;
         overflow-y: auto;
         margin-top: 6px;
     }

     .search-results-dropdown.show {
         display: block;
     }

     .search-results-dropdown .no-result {
         padding: 14px 16px;
         color: #777;
         text-align: center;
         font-size: 14px;
     }

     .search-results-dropdown .search-item {
         display: flex;
         align-items: center;
         gap: 10px;
         padding: 10px 14px;
         text-decoration: none;
         color: #222;
         border-bottom: 1px solid #f2f2f2;
     }

     .search-results-dropdown .search-item:hover {
         background: #f8f8f8;
     }

     .search-results-dropdown .search-item img {
         width: 40px;
         height: 40px;
         object-fit: cover;
         border-radius: 4px;
     }

     /* ===== Search Result Item Design ===== */
     .search-result-item {
         display: flex;
         align-items: center;
         gap: 12px;
         padding: 10px 14px;
         text-decoration: none;
         border-bottom: 1px solid #f2f2f2;
         transition: background .2s ease;
     }

     .search-result-item:last-child {
         border-bottom: none;
     }

     .search-result-item:hover {
         background: #fdeceb;
     }

     .search-result-thumb {
         width: 52px;
         height: 52px;
         flex-shrink: 0;
         border-radius: 8px;
         overflow: hidden;
         background: #f5f5f5;
     }

     .search-result-thumb img {
         width: 100%;
         height: 100%;
         object-fit: cover;
     }

     .sr-brand {
         font-size: .72rem;
         font-weight: 600;
         color: #FF0000;
         text-transform: uppercase;
         letter-spacing: .3px;
         margin-bottom: 2px;
     }

     .sr-name {
         font-size: .86rem;
         font-weight: 600;
         color: #1c1c1c;
         line-height: 1.3;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
     }

     .sr-regular-price {
         font-size: .76rem;
         color: #999;
         text-decoration: line-through;
         margin-bottom: 1px;
     }

     .sr-sale-price {
         font-size: .9rem;
         font-weight: 700;
         color: #FF0000;
         white-space: nowrap;
     }

     /* No products found message */
     .search-results-dropdown p.text-muted {
         padding: 24px 16px;
         text-align: center;
         color: #999;
         font-size: .88rem;
     }

     /* ===== Mobile Search Dropdown Fix ===== */
     .mobile-search-bar {
         position: relative;
         overflow: visible !important;
         /* dropdown clip হওয়া বন্ধ করতে */
         max-height: none !important;
     }

     .mobile-search-slide {
         max-height: 0;
         overflow: hidden;
         transition: max-height .35s ease, padding .35s ease;
     }

     .mobile-search-bar.active .mobile-search-slide {
         max-height: 70px;
         padding-bottom: 12px;
         margin-top: 3px;
     }

     .search-results-dropdown-mobile {
         display: none;
         position: absolute;
         top: 100%;
         left: 0;
         width: 100%;
         background: #fff;
         border: 1px solid #ddd;
         border-radius: 8px;
         box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
         z-index: 1050;
         max-height: 320px;
         overflow-y: auto;
         margin-top: 6px;
     }

     .search-results-dropdown-mobile.show {
         display: block;
     }


     /* ===== More Dropdown ===== */
     .more-mega-menu {
         min-width: 220px;
         padding: 8px;
     }

     .more-menu-item {
         position: relative;
     }

     .more-menu-item>a {
         display: flex;
         align-items: center;
         gap: 10px;
         padding: 9px 12px;
         border-radius: var(--radius-sm);
         font-size: .88rem;
         font-weight: 500;
         color: var(--dark);
         transition: var(--transition);
     }

     .more-menu-item>a:hover {
         background: var(--primary-light);
         color: var(--primary);
         padding-left: 16px;
     }

     .sub-arrow {
         margin-left: auto;
         font-size: .7rem !important;
     }

     /* Nested flyout (subcategory) - পাশে খোলে */
     .sub-flyout {
         position: absolute;
         top: 0;
         left: 100%;
         min-width: 190px;
         background: #fff;
         border-radius: var(--radius-sm);
         box-shadow: var(--shadow-md);
         padding: 10px;
         margin-left: 6px;
         opacity: 0;
         visibility: hidden;
         transform: translateX(8px);
         transition: var(--transition);
         z-index: 1150;
     }

     .more-menu-item.has-sub:hover .sub-flyout {
         opacity: 1;
         visibility: visible;
         transform: translateX(0);
     }

     .sub-flyout a {
         display: flex;
         align-items: center;
         gap: 10px;
         padding: 9px 12px;
         border-radius: var(--radius-sm);
         font-size: .86rem;
         font-weight: 500;
         color: var(--dark);
         transition: var(--transition);
     }

     .sub-flyout a:hover {
         background: var(--primary-light);
         color: var(--primary);
         padding-left: 16px;
     }

     /* Screen এর ডানপ্রান্তে চাপা পড়া থেকে বাঁচাতে - More menu সবসময় right-aligned রাখা ভালো */
     .more-nav-item .mega-menu {
         left: auto;
         right: 0;
         border-radius: var(--radius-sm) 0 var(--radius-sm) var(--radius-sm);
     }

     /* যদি sub-flyout ডানে গিয়ে screen এর বাইরে চলে যায়, তখন বামে খোলাও */
     @media (min-width: 992px) {
         .more-nav-item .sub-flyout {
             left: auto;
             right: 100%;
             margin-left: 0;
             margin-right: 6px;
             transform: translateX(-8px);
         }

         .more-nav-item .more-menu-item.has-sub:hover .sub-flyout {
             transform: translateX(0);
         }
     }
 </style>


 <!-- ===================== HEADER (STICKY) ===================== -->
 <header class="site-header" id="siteHeader">
     <div class="header-top">
         <div class="container">
             <div class="header-inner d-flex align-items-center justify-content-between">

                 <button class="hamburger-btn d-lg-none" id="hamburgerBtn" aria-label="Open menu">
                     <i class="bi bi-list"></i>
                 </button>

                 <a href="/" class="logo d-flex align-items-center">
                     <img src="{{Storage::url($setting->header_logo)}}" alt="{{ $setting->company_name }}" class="logo-img">
                 </a>

                 <form class="search-form d-none d-md-flex" id="desktopSearchForm" autocomplete="off">
                     <div class="search-input-wrap">
                         <input type="search" id="searchInput" placeholder="Search your products...">
                         <button type="submit"><i class="bi bi-search"></i></button>
                     </div>
                     <div id="searchResults" class="search-results-dropdown"></div>
                 </form>

                 <div class="header-actions d-flex align-items-center">

                     <!-- Mobile Search Toggle (mobile only) -->
                     <button class="action-link search-toggle-btn d-md-none" id="mobileSearchToggle"
                         aria-label="Search">
                         <i class="bi bi-search"></i>
                     </button>

                     <a href="javascript:void(0)" class="action-link cart-toggle" id="cartToggle">
                         <i class="fa-solid fa-cart-shopping"></i>
                         <span id="cartItemCount" class="cart-count">0</span>
                         <span class="d-none d-lg-inline ms-1">Cart</span>
                     </a>

                     @if(auth()->check())
                     <div class="account-hover">
                         <a href="{{ route('dashboard') }}" class="action-link">
                             <i class="bi bi-speedometer2"></i>
                             <span class="d-none d-lg-inline">Dashboard</span>
                         </a>
                     </div>
                     @else
                     <div class="account-hover">
                         <a href="{{ route('login') }}" class="action-link">
                             <i class="bi bi-person"></i>
                             <span class="d-none d-lg-inline">Login</span>
                         </a>
                     </div>
                     @endauth


                 </div>
             </div>
         </div>
     </div>

     <div class="container">

         <!-- ===================== MOBILE SEARCH BAR (slides below header, mobile only) ===================== -->
         <div class="mobile-search-bar d-md-none" id="mobileSearchBar">
             <div class="mobile-search-slide">
                 <div class="mobile-search-inner">
                     <i class="bi bi-search mobile-search-icon"></i>
                     <input type="text" id="searchInputMobile" placeholder="Search your products...">
                     <button type="button" id="mobileSearchClose" aria-label="Close search">
                         <i class="bi bi-x-lg"></i>
                     </button>
                 </div>
             </div>
             <div id="searchResultsMobile" class="search-results-dropdown-mobile"></div>
         </div>

         <!-- ===================== DESKTOP NAVBAR ===================== -->
         <nav class="main-nav d-none d-lg-block">
             <ul class="nav-list">

                 @foreach($categories->take(8) as $category)
                 <li class="nav-item @if($category->subCategories->count() > 0) has-mega @endif">

                     @if($category->subCategories->count() > 0)
                     <a href="#" class="nav-link-custom">
                         @if($category->image)
                         <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="nav-cat-icon">
                         @else
                         <i class="bi {{ $category->icon ?? 'bi-tag' }}"></i>
                         @endif
                         {{ \App\Helpers\TranslateHelper::translate($category->name) }}
                         <i class="bi bi-chevron-down"></i>
                     </a>

                     <div class="mega-menu">
                         @foreach($category->subCategories as $sub)
                         <a href="{{ route('products', ['sub_category' => $sub->id]) }}">
                             @if($sub->image)
                             <img src="{{ Storage::url($sub->image) }}" alt="{{ $sub->name }}" class="nav-cat-icon-sm">
                             @else
                             <i class="bi {{ $sub->icon ?? 'bi-dot' }}"></i>
                             @endif
                             {{ $sub->name }}
                         </a>
                         @endforeach
                     </div>

                     @else
                     <a href="{{ route('products', ['category' => $category->id]) }}" class="nav-link-custom">
                         @if($category->image)
                         <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="nav-cat-icon">
                         @else
                         <i class="bi {{ $category->icon ?? 'bi-tag' }}"></i>
                         @endif
                         {{ \App\Helpers\TranslateHelper::translate($category->name) }}
                     </a>
                     @endif

                 </li>
                 @endforeach

                 {{-- ===================== MORE DROPDOWN (8 এর বেশি category থাকলে) ===================== --}}
                 @if($categories->count() > 8)
                 <li class="nav-item has-mega more-nav-item">
                     <a href="#" class="nav-link-custom">
                         <i class="bi bi-grid-3x3-gap"></i>
                         More
                         <i class="bi bi-chevron-down"></i>
                     </a>

                     <div class="mega-menu more-mega-menu">
                         @foreach($categories->skip(8) as $category)
                         <div class="more-menu-item @if($category->subCategories->count() > 0) has-sub @endif">
                             <a href="{{ $category->subCategories->count() > 0 ? '#' : route('products', ['category' => $category->id]) }}">
                                 @if($category->image)
                                 <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="nav-cat-icon-sm">
                                 @else
                                 <i class="bi {{ $category->icon ?? 'bi-tag' }}"></i>
                                 @endif
                                 {{ \App\Helpers\TranslateHelper::translate($category->name) }}
                                 @if($category->subCategories->count() > 0)
                                 <i class="bi bi-chevron-right sub-arrow"></i>
                                 @endif
                             </a>

                             @if($category->subCategories->count() > 0)
                             <div class="sub-flyout">
                                 @foreach($category->subCategories as $sub)
                                 <a href="{{ route('products', ['sub_category' => $sub->id]) }}">
                                     @if($sub->image)
                                     <img src="{{ Storage::url($sub->image) }}" alt="{{ $sub->name }}" class="nav-cat-icon-sm">
                                     @else
                                     <i class="bi {{ $sub->icon ?? 'bi-dot' }}"></i>
                                     @endif
                                     {{ $sub->name }}
                                 </a>
                                 @endforeach
                             </div>
                             @endif
                         </div>
                         @endforeach
                     </div>
                 </li>
                 @endif

             </ul>
         </nav>
     </div>
     </div>
 </header>

<!-- ===================== MOBILE LEFT SIDEBAR ===================== -->
<div class="mobile-overlay" id="mobileOverlay"></div>
<aside class="mobile-sidebar" id="mobileSidebar">
    <div class="mobile-sidebar-head">
        @php
        $companyName = trim($setting->company_name ?? 'MultiBrand FOOTWEAR');
        $nameParts = explode(' ', $companyName, 2);
        $firstWord = $nameParts[0] ?? '';
        $restWords = $nameParts[1] ?? '';
        @endphp

        <span class="logo-text">
            {{ $firstWord }}
            @if($restWords)
            <span class="logo-accent">{{ strtoupper($restWords) }}</span>
            @endif
        </span>
        <button id="mobileSidebarClose"><i class="bi bi-x-lg"></i></button>
    </div>

    <div class="mobile-sidebar-scroll-area">
        <ul class="mobile-nav-list">

            @foreach($categories as $category)
            <li class="mobile-nav-item">

                @if($category->subCategories->count() > 0)
                <div class="mobile-nav-link" data-toggle="submenu">
                    <span>
                        @if($category->image)
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="mobile-nav-cat-img">
                        @else
                        <span class="mobile-nav-cat-icon-wrap"><i class="bi {{ $category->icon ?? 'bi-tag' }}"></i></span>
                        @endif
                        {{ \App\Helpers\TranslateHelper::translate($category->name) }}
                    </span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <ul class="mobile-submenu">
                    @foreach($category->subCategories as $sub)
                    <li>
                        <a href="{{ route('products', ['sub_category' => $sub->id]) }}">
                            @if($sub->image)
                            <img src="{{ Storage::url($sub->image) }}" alt="{{ $sub->name }}" class="mobile-nav-cat-img-sm">
                            @else
                            <i class="bi bi-dot"></i>
                            @endif
                            {{ $sub->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                @else
                <a href="{{ route('products', ['category' => $category->id]) }}" class="mobile-nav-link">
                    <span>
                        @if($category->image)
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="mobile-nav-cat-img">
                        @else
                        <span class="mobile-nav-cat-icon-wrap"><i class="bi {{ $category->icon ?? 'bi-tag' }}"></i></span>
                        @endif
                        {{ \App\Helpers\TranslateHelper::translate($category->name) }}
                    </span>
                </a>
                @endif

            </li>
            @endforeach

        </ul>
    </div>

    {{-- ✅ All Brands — sticky, সবসময় দেখা যাবে, scroll area-এর বাইরে --}}
    <div class="mobile-sidebar-brands-cta">
        <a href="{{ route('brands') }}" class="all-brands-btn">
            <span class="all-brands-icon"><i class="bi bi-tags-fill"></i></span>
            <span class="all-brands-text">
                <span class="all-brands-title">All Brands</span>
                <span class="all-brands-sub">Explore every brand we carry</span>
            </span>
            <i class="bi bi-chevron-right all-brands-arrow"></i>
        </a>
    </div>

    <div class="mobile-sidebar-footer">
        @auth
        <a href="{{ route('dashboard') }}" class="acc-btn acc-btn-primary">
            <span class="acc-btn-icon"><i class="bi bi-person-check-fill"></i></span>
            {{ Auth::user()->name }}
        </a>
        <form action="{{ route('logout') }}" method="POST" class="w-100">
            @csrf
            <button type="submit" class="acc-btn acc-btn-outline w-100">
                <span class="acc-btn-icon"><i class="bi bi-box-arrow-right"></i></span>
                Logout
            </button>
        </form>
        @else
        <a href="{{ route('login') }}" class="acc-btn acc-btn-primary">
            <span class="acc-btn-icon"><i class="bi bi-box-arrow-in-right"></i></span>
            Login
        </a>
        <a href="{{ route('register') }}" class="acc-btn acc-btn-outline">
            <span class="acc-btn-icon"><i class="bi bi-person-plus-fill"></i></span>
            Create Account
        </a>
        @endauth
    </div>
</aside>

<style>
    /* ✅ Sidebar-কে flex column বানিয়ে scroll area + fixed bottom section আলাদা করা হলো */
    .mobile-sidebar {
        display: flex;
        flex-direction: column;
    }

    .mobile-sidebar-scroll-area {
        flex: 1;
        overflow-y: auto;
        min-height: 0;
    }

    /* ── Category image (icon-এর জায়গায়) ── */
    .mobile-nav-cat-img {
        width: 26px;
        height: 26px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 8px;
        vertical-align: middle;
        flex-shrink: 0;
    }
    .mobile-nav-cat-img-sm {
        width: 20px;
        height: 20px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 8px;
        vertical-align: middle;
        flex-shrink: 0;
    }
    .mobile-nav-cat-icon-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 6px;
        background: rgba(255,0,0,.08);
        margin-right: 8px;
        flex-shrink: 0;
        vertical-align: middle;
    }
    .mobile-nav-cat-icon-wrap i {
        font-size: 13px;
        color: var(--primary, #FF0000);
    }
    .mobile-nav-link span {
        display: inline-flex;
        align-items: center;
    }

    /* ── All Brands CTA ── */
    .mobile-sidebar-brands-cta {
        flex-shrink: 0;
        padding: 14px 16px 0;
    }
    .all-brands-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 13px 16px;
        border-radius: 12px;
        background: linear-gradient(135deg, #FF0000, #b30000);
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(255,0,0,.22);
        transition: transform .15s ease, box-shadow .15s ease;
        box-sizing: border-box;
    }
    .all-brands-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(255,0,0,.3);
    }
    .all-brands-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255,255,255,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .all-brands-icon i {
        color: #fff;
        font-size: 15px;
    }
    .all-brands-text {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
    }
    .all-brands-title {
        color: #fff;
        font-weight: 700;
        font-size: .88rem;
        line-height: 1.3;
    }
    .all-brands-sub {
        color: rgba(255,255,255,.78);
        font-size: .7rem;
        line-height: 1.2;
        margin-top: 1px;
    }
    .all-brands-arrow {
        color: #fff;
        font-size: .8rem;
        flex-shrink: 0;
    }

    /* ── Login / Create Account — All Brands card-এর সাথে balanced (একবারই define করা) ── */
    .mobile-sidebar-footer {
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
        padding: 12px 16px 18px;
    }

    .acc-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        padding: 13px 16px;
        border-radius: 12px;
        font-size: .88rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: transform .15s ease, box-shadow .15s ease, background .2s ease;
        box-sizing: border-box;
        line-height: 1.2;
    }

    .acc-btn-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
    }

    /* Primary — filled, All Brands card-এর মতো একই shadow weight */
    .acc-btn-primary {
        background: linear-gradient(135deg, #FF0000, #b30000);
        color: #fff;
        box-shadow: 0 4px 14px rgba(255,0,0,.22);
    }
    .acc-btn-primary:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(255,0,0,.3);
    }
    .acc-btn-primary .acc-btn-icon {
        color: #fff;
    }

    /* Outline — secondary, border-width সমন্বয় করে height match */
    .acc-btn-outline {
        background: #fff;
        color: #1c1c1c;
        border: 1.5px solid #e5e5e5;
        padding: 11.5px 16px;
    }
    .acc-btn-outline:hover {
        color: #FF0000;
        border-color: #FF0000;
        background: #fff5f5;
        transform: translateY(-1px);
    }
    .acc-btn-outline .acc-btn-icon {
        color: #FF0000;
    }
</style>

 <!-- ===================== CART OFFCANVAS (desktop: right slide | mobile: bottom sheet) ===================== -->
 <div class="cart-overlay" id="cartOverlay"></div>
 <aside class="cart-sidebar" id="cartSidebar">
     <div class="cart-sidebar-drag-handle d-lg-none"></div>
     <div class="cart-sidebar-head">
         <h5 class="mb-0"><i class="bi bi-bag me-2"></i>Your Cart <span class="cart-item-count" id="shopingcart">(0)</span></h5>
         <button class="cart-close" id="cartClose"><i class="bi bi-x-lg"></i></button>
     </div>

     <div class="cart-sidebar-body" id="cartItems">

         <div class="text-center text-muted py-5" id="emptyCartMessage">
             <i class="bi bi-bag-x" style="font-size:2.2rem;"></i>
             <p class="mb-0 mt-2">Your cart is empty</p>
         </div>

     </div>

     <div class="cart-sidebar-footer">
         <div class="cart-subtotal" id="subtotal"><span>Subtotal</span><strong>{{ currency() }}0</strong></div>
         <a href="{{ route('checkout') }}" class="btn-checkout">Proceed to Checkout <i class="bi bi-arrow-right"></i></a>
     </div>
 </aside>



 <style>
     .nav-cat-icon {
         width: 16px;
         height: 16px;
         object-fit: cover;
         border-radius: 3px;
         margin-right: 4px;
         vertical-align: middle;
     }

     .nav-cat-icon-sm {
         width: 14px;
         height: 14px;
         object-fit: cover;
         border-radius: 3px;
         margin-right: 4px;
         vertical-align: middle;
     }
 </style>