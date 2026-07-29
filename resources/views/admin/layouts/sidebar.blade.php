<nav id="sidebar">

    @php
        $settings = \App\Models\Setting::first();
    @endphp

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap');

        #sidebar {
            background: #0f0a1e;
            min-height: 100vh;
            width: 255px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,.06);
            font-family: 'Sora', sans-serif;
        }

        /* ── Brand ── */
        #sidebar .sidebar-brand {
            padding: 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            display: flex;
            align-items: center;
            gap: 11px;
        }
        #sidebar .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #7c3aed, #5b21b6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(124,58,237,.4);
        }
        #sidebar .brand-icon i { color: #fff; font-size: 14px; }
        #sidebar .brand-name {
            font-size: 15px; font-weight: 700;
            color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        /* ── Nav wrapper ── */
        #sidebar .nav {
            padding: 6px 10px;
            display: flex; flex-direction: column;
            gap: 1px;
        }

        /* ── Section label ── */
        #sidebar .nav-section-label {
            font-size: 9.5px; font-weight: 700;
            color: rgba(255,255,255,.25);
            text-transform: uppercase; letter-spacing: 1.2px;
            padding: 14px 10px 4px;
        }

        /* ── Nav link ── */
        #sidebar .nav-link {
            color: rgba(255,255,255,.55);
            font-size: 13px; font-weight: 500;
            padding: 8px 10px;
            border-radius: 9px;
            display: flex; align-items: center;
            text-decoration: none;
            transition: background .15s, color .15s;
            border: none; background: transparent;
            line-height: 1.4;
            gap: 0;
        }
        #sidebar .nav-link i.menu-icon {
            width: 30px; font-size: 13px;
            color: rgba(255,255,255,.3);
            flex-shrink: 0;
            transition: color .15s;
        }
        #sidebar .nav-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
        }
        #sidebar .nav-link:hover i.menu-icon { color: rgba(255,255,255,.7); }

        /* ── Active ── */
        #sidebar .nav-link.active {
            background: linear-gradient(120deg, rgba(124,58,237,.35), rgba(91,33,182,.2));
            color: #c4b5fd;
            font-weight: 600;
            border: 1px solid rgba(124,58,237,.25);
        }
        #sidebar .nav-link.active i.menu-icon { color: #a78bfa; }

        /* ── Parent open ── */
        #sidebar .nav-link[aria-expanded="true"] {
            background: rgba(255,255,255,.06);
            color: #e2d9f3;
        }
        #sidebar .nav-link[aria-expanded="true"] i.menu-icon { color: rgba(255,255,255,.6); }

        /* ── Chevron ── */
        #sidebar .nav-link .rotate {
            margin-left: auto;
            font-size: 9px;
            color: rgba(255,255,255,.2);
            transition: transform .2s;
            flex-shrink: 0;
        }
        #sidebar .nav-link[aria-expanded="true"] .rotate {
            transform: rotate(90deg);
            color: rgba(255,255,255,.45);
        }

        /* ── Sub menu ── */
        #sidebar .collapse .nav {
            padding: 3px 0 5px 4px;
            margin-left: 15px;
            border-left: 1px solid rgba(255,255,255,.08);
            gap: 0;
        }
        #sidebar .collapse .nav-link {
            font-size: 12.5px; font-weight: 400;
            padding: 7px 10px;
            color: rgba(255,255,255,.45);
            border-radius: 7px;
            border: none;
        }
        #sidebar .collapse .nav-link:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }
        #sidebar .collapse .nav-link.active {
            background: rgba(124,58,237,.25);
            color: #c4b5fd;
            font-weight: 500;
            border: 1px solid rgba(124,58,237,.2);
        }
        #sidebar .collapse .nav-link i.menu-icon { width: 24px; font-size: 11.5px; }

        /* ── Scrollbar ── */
        #sidebar { overflow-y: auto; overflow-x: hidden; }
        #sidebar::-webkit-scrollbar { width: 3px; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 3px; }

        /* ── Bottom strip ── */
        #sidebar .sidebar-footer {
            margin-top: auto;
            padding: 12px 14px;
            border-top: 1px solid rgba(255,255,255,.07);
            display: flex; align-items: center; gap: 9px;
        }
        .sf-avatar {
            width: 32px; height: 32px; border-radius: 9px;
            background: linear-gradient(135deg, #7c3aed, #4c1d95);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sf-avatar i { font-size: 12px; color: #fff; }
        .sf-name { font-size: 13px; font-weight: 600; color: #e2d9f3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sf-role { font-size: 10.5px; color: rgba(255,255,255,.3); }
        .sf-logout { color: rgba(255,255,255,.25); font-size: 14px; transition: color .15s; margin-left: auto; }
        .sf-logout:hover { color: #f87171; }
    </style>

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-bolt"></i></div>
        <span class="brand-name">{{ $settings->app_name ?? 'Admin Panel' }}</span>
    </div>

    <ul class="nav flex-column mt-1">

        {{-- Dashboard --}}
        @canany(['create dashboard','edit dashboard','view dashboard','delete dashboard'])
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home menu-icon"></i> Dashboard
            </a>
        </li>
        @endcanany

   {{-- Products & Categories --}}
    @canany(['create category','edit category','view category','delete category','create subcategory','edit subcategory','view subcategory','delete subcategory','create product','edit product','view product','delete product'])
    @php
        $productCatActive = request()->is('admin/shop-categories*')
            || request()->is('admin/ebook-categories*')
            || request()->is('admin/course-categories*')
            || request()->is('admin/preparation-categories*')
            || request()->is('admin/subcategories*')
            || request()->is('admin/products*')
            || request()->is('admin/colors*')
            || request()->is('admin/sizes*')
            || request()->is('admin/brands*');
    @endphp
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center {{ $productCatActive ? '' : 'collapsed' }}"
        data-bs-toggle="collapse" href="#productCatMenu" role="button" aria-expanded="{{ $productCatActive ? 'true' : 'false' }}">
            <i class="fas fa-boxes-stacked menu-icon"></i>
            <span>Products & Categories</span>
            <i class="fas fa-chevron-right rotate"></i>
        </a>
        <div class="collapse {{ $productCatActive ? 'show' : '' }}" id="productCatMenu">
            <ul class="nav flex-column">

                {{-- ── Category options ── --}}
                @canany(['create category','edit category','view category','delete category'])
                <li><a class="nav-link {{ request()->is('admin/shop-categories*') ? 'active' : '' }}" href="{{ route('admin.shop-categories.index') }}">
                    <i class="fas fa-store menu-icon"></i> Shop Categories
                </a></li>

                <li><a class="nav-link {{ request()->is('admin/ebook-categories*') ? 'active' : '' }}" href="{{ route('admin.ebook-categories.index') }}">
                    <i class="fas fa-book menu-icon"></i> Ebook Categories
                </a></li>

                <li><a class="nav-link {{ request()->is('admin/course-categories*') ? 'active' : '' }}" href="{{ route('admin.course-categories.index') }}">
                    <i class="fas fa-graduation-cap menu-icon"></i> Course Categories
                </a></li>

                <li><a class="nav-link {{ request()->is('admin/preparation-categories*') ? 'active' : '' }}" href="{{ route('admin.preparation-categories.index') }}">
                    <i class="fas fa-book-reader menu-icon"></i> Preparation Categories
                </a></li>
                @endcanany

                @canany(['create subcategory','edit subcategory','view subcategory','delete subcategory'])
                <li><a class="nav-link {{ request()->is('admin/subcategories*') ? 'active' : '' }}" href="{{ route('admin.subcategories.index') }}">
                    <i class="fas fa-tags menu-icon"></i> Sub Categories
                </a></li>
                @endcanany

                {{-- ── Product options ── --}}
                @canany(['create product','edit product','view product','delete product'])
                <li><a class="nav-link {{ request()->is('admin/products*') && !request()->is('admin/products/create') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-th-large menu-icon"></i> All Products
                </a></li>
                <li><a class="nav-link {{ request()->is('admin/products/create') ? 'active' : '' }}" href="{{ route('admin.products.create') }}">
                    <i class="fas fa-plus menu-icon"></i> Add Product
                </a></li>
                <li><a class="nav-link {{ request()->is('admin/colors*') ? 'active' : '' }}" href="{{ route('admin.colors.index') }}">
                    <i class="fas fa-palette menu-icon"></i> Colors
                </a></li>
                <li><a class="nav-link {{ request()->is('admin/sizes*') ? 'active' : '' }}" href="{{ route('admin.sizes.index') }}">
                    <i class="fas fa-ruler menu-icon"></i> Sizes
                </a></li>
                <li><a class="nav-link {{ request()->is('admin/brands*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
                    <i class="fas fa-certificate menu-icon"></i> Brands
                </a></li>
                @endcanany

            </ul>
        </div>
    </li>
    @endcanany

      

        {{-- Customer Management --}}
        @php $customerActive = request()->is('admin/customers*'); @endphp
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ $customerActive ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#customerMenu" role="button" aria-expanded="{{ $customerActive ? 'true' : 'false' }}">
                <i class="fas fa-user-friends menu-icon"></i>
                <span>Customer Management</span>
                <i class="fas fa-chevron-right rotate"></i>
            </a>
            <div class="collapse {{ $customerActive ? 'show' : '' }}" id="customerMenu">
                <ul class="nav flex-column">
                    <li><a class="nav-link {{ request()->is('admin/customers') || request()->is('admin/customers?*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                        <i class="fas fa-users menu-icon"></i> All Customers
                    </a></li>
                    <li><a class="nav-link {{ request()->is('admin/customers/create') ? 'active' : '' }}" href="{{ route('admin.customers.create') }}">
                        <i class="fas fa-user-plus menu-icon"></i> Add Customer
                    </a></li>
                </ul>
            </div>
        </li>

        {{-- Orders --}}
        @canany(['create order','edit order','view order','delete order','create pending-order','view pending-order','create processing-order','view processing-order','create complete','view complete','create cancelled','view cancelled'])
        @php $orderActive = request()->is('admin/all-orders*') || request()->is('admin/pending-orders*') || request()->is('admin/processing-orders*') || request()->is('admin/on-the-way*') || request()->is('admin/hold-orders') || request()->is('admin/courier-orders*') || request()->is('admin/complete-orders*') || request()->is('admin/cancelled-orders*'); @endphp
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ $orderActive ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#orderMenu" role="button" aria-expanded="{{ $orderActive ? 'true' : 'false' }}">
                <i class="fas fa-shopping-cart menu-icon"></i>
                <span>Orders</span>
                <i class="fas fa-chevron-right rotate"></i>
            </a>
            <div class="collapse {{ $orderActive ? 'show' : '' }}" id="orderMenu">
                <ul class="nav flex-column">
                    @canany(['create order','edit order','view order','delete order'])
                    <li><a class="nav-link {{ request()->is('admin/all-orders*') ? 'active' : '' }}" href="{{ route('admin.all-orders') }}">
                        <i class="fas fa-list-alt menu-icon"></i> All Orders
                    </a></li>
                    @endcanany
                    @canany(['create pending-order','view pending-order'])
                    <li><a class="nav-link {{ request()->is('admin/pending-orders*') ? 'active' : '' }}" href="{{ route('admin.pending-orders') }}">
                        <i class="fas fa-clock menu-icon"></i> Pending
                    </a></li>
                    @endcanany
                    @canany(['create processing-order','view processing-order'])
                    <li><a class="nav-link {{ request()->is('admin/processing-orders*') ? 'active' : '' }}" href="{{ route('admin.processing-orders') }}">
                        <i class="fas fa-spinner menu-icon"></i> Processing
                    </a></li>
                    @endcanany
                    @canany(['create on-the-way','view on-the-way'])
                    <li><a class="nav-link {{ request()->is('admin/on-the-way*') ? 'active' : '' }}" href="{{ route('admin.on-the-way-orders') }}">
                        <i class="fas fa-truck menu-icon"></i> On The Way
                    </a></li>
                    @endcanany
                    @canany(['create hold','view hold'])
                    <li><a class="nav-link {{ request()->is('admin/hold-orders') ? 'active' : '' }}" href="{{ route('admin.hold-orders') }}">
                        <i class="fas fa-pause-circle menu-icon"></i> On Hold
                    </a></li>
                    @endcanany
                    @canany(['create couriers','view couriers'])
                    <li><a class="nav-link {{ request()->is('admin/courier-orders*') ? 'active' : '' }}" href="{{ route('admin.courier-orders') }}">
                        <i class="fas fa-box menu-icon"></i> Courier
                    </a></li>
                    @endcanany
                    @canany(['create complete','view complete'])
                    <li><a class="nav-link {{ request()->is('admin/complete-orders*') ? 'active' : '' }}" href="{{ route('admin.complete-orders') }}">
                        <i class="fas fa-check-circle menu-icon"></i> Completed
                    </a></li>
                    @endcanany
                    @canany(['create cancelled','view cancelled'])
                    <li><a class="nav-link {{ request()->is('admin/cancelled-orders*') ? 'active' : '' }}" href="{{ route('admin.cancelled-orders') }}">
                        <i class="fas fa-times-circle menu-icon"></i> Cancelled
                    </a></li>
                    @endcanany
                </ul>
            </div>
        </li>
        @endcanany

      

        @canany(['create banner','edit banner','view banner','delete banner','create setting','edit setting','view setting','delete setting','create smtp','view smtp'])
        @php $websiteActive = request()->is('admin/smtp*') || request()->is('admin/courier*') || request()->is('admin/marketing*') || request()->is('admin/bannars*') || request()->is('admin/settings*') || request()->is('admin/customer-review*')|| request()->is('admin/showroom*') || request()->is('admin/contacts*') || request()->is('admin/how-to-buy*'); @endphp
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ $websiteActive ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#websiteMenu" role="button" aria-expanded="{{ $websiteActive ? 'true' : 'false' }}">
                <i class="fas fa-globe menu-icon"></i>
                <span>Website</span>
                <i class="fas fa-chevron-right rotate"></i>
            </a>
            <div class="collapse {{ $websiteActive ? 'show' : '' }}" id="websiteMenu">
                <ul class="nav flex-column">
                    @canany(['create smtp','view smtp'])
                    {{--<li><a class="nav-link {{ request()->is('admin/smtp*') ? 'active' : '' }}" href="{{ route('admin.smtp.edit',1) }}">
                        <i class="fas fa-envelope menu-icon"></i> SMTP
                    </a></li>--}}
                    @endcanany
                    @canany(['create courier','view courier'])
                    <li><a class="nav-link {{ request()->is('admin/courier*') ? 'active' : '' }}" href="{{ route('admin.courier.setup') }}">
                        <i class="fas fa-shipping-fast menu-icon"></i> Courier Setup
                    </a></li>
                    @endcanany
                   <li><a class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">
                        <i class="fas fa-ticket-alt menu-icon"></i> Coupons
                    </a></li>
                    @canany(['create marketing','view marketing'])
                    <li><a class="nav-link {{ request()->is('admin/marketing*') ? 'active' : '' }}" href="{{ route('admin.marketing.setup') }}">
                        <i class="fas fa-bullhorn menu-icon"></i> Marketing
                    </a></li>
                    @endcanany
                    @canany(['create banner','view banner'])
                    <li><a class="nav-link {{ request()->is('admin/bannars*') ? 'active' : '' }}" href="{{ route('admin.bannars.index') }}">
                        <i class="fas fa-images menu-icon"></i> Banners
                    </a></li>
                    @endcanany
                    @canany(['create banner','view banner'])
                    <li><a class="nav-link {{ request()->is('admin/customer-review*') ? 'active' : '' }}" href="{{ route('admin.customer-review.index') }}">
                        <i class="fas fa-star menu-icon"></i> Customer Review
                    </a></li>
                    @endcanany
                    <li><a class="nav-link {{ request()->is('admin/contacts*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                        <i class="fas fa-address-book menu-icon"></i> Contact
                    </a></li>
                    <li><a class="nav-link {{ request()->is('admin/how-to-buy*') ? 'active' : '' }}" href="{{ route('admin.how-to-buy.index') }}">
                        <i class="fas fa-question-circle menu-icon"></i> How To Buy
                    </a></li>
                   @canany(['create setting','view setting'])
                    <li>
                        <a class="nav-link {{ request()->is('admin/shipping*') ? 'active' : '' }}" 
                           href="{{ route('admin.shiping.index') }}">
                            <i class="fas fa-shipping-fast menu-icon"></i> Shipping
                        </a>
                    </li>

                    <li>
                        <a class="nav-link {{ request()->is('admin/showroom*') ? 'active' : '' }}" 
                        href="{{ route('admin.showroom.index') }}">
                            <i class="fas fa-store menu-icon"></i> Showroom
                        </a>
                    </li>
                    
                    <li>
                        <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" 
                           href="{{ route('admin.settings.index') }}">
                            <i class="fas fa-cog menu-icon"></i> Settings
                        </a>
                    </li>
                    @endcanany
                </ul>
            </div>
        </li>
        @endcanany

        {{-- Footer --}}
        @php $landingActive = request()->is('admin/navigation*') || request()->is('admin/legal-policy*'); @endphp
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ $landingActive ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#landingPageMenu" role="button" aria-expanded="{{ $landingActive ? 'true' : 'false' }}">
                <i class="fas fa-shoe-prints menu-icon"></i>
                <span>Footer</span>
                <i class="fas fa-chevron-right rotate"></i>
            </a>
            <div class="collapse {{ $landingActive ? 'show' : '' }}" id="landingPageMenu">
                <ul class="nav flex-column">
                    <li><a class="nav-link {{ request()->is('admin/legal-policy*') ? 'active' : '' }}" href="{{ route('admin.legal-policy.index') }}">
                        <i class="fas fa-file-contract menu-icon"></i> Legal & Policy
                    </a></li>
                    <li><a class="nav-link {{ request()->is('admin/navigation*') ? 'active' : '' }}" href="{{ route('admin.navigation.index') }}">
                        <i class="fas fa-sitemap menu-icon"></i> Quick Navigation
                    </a></li>
                </ul>
            </div>
        </li>

       

        @canany(['create report','edit report','view report','delete report'])
        @php $reportsActive = request()->is('admin/stock-report*') || request()->is('admin/order-report*'); @endphp
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ $reportsActive ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#reportsMenu" role="button" aria-expanded="{{ $reportsActive ? 'true' : 'false' }}">
                <i class="fas fa-chart-bar menu-icon"></i>
                <span>Reports</span>
                <i class="fas fa-chevron-right rotate"></i>
            </a>
            <div class="collapse {{ $reportsActive ? 'show' : '' }}" id="reportsMenu">
                <ul class="nav flex-column">
                    <li><a class="nav-link {{ request()->is('admin/stock-report*') ? 'active' : '' }}" href="{{ route('admin.stock_report') }}">
                        <i class="fas fa-boxes menu-icon"></i> Stock Report
                    </a></li>
                    <li><a class="nav-link {{ request()->is('admin/order-report*') ? 'active' : '' }}" href="{{ route('admin.order_report') }}">
                        <i class="fas fa-file-invoice menu-icon"></i>Sales Report
                    </a></li>
                </ul>
            </div>
        </li>
        @endcanany

      

        @canany(['create user','edit user','view user','delete user','create role','edit role','view role','delete role'])
        @php $userActive = request()->is('admin/users*') || request()->is('admin/roles*'); @endphp
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center {{ $userActive ? '' : 'collapsed' }}"
               data-bs-toggle="collapse" href="#userManagementMenu" role="button" aria-expanded="{{ $userActive ? 'true' : 'false' }}">
                <i class="fas fa-users menu-icon"></i>
                <span>User Management</span>
                <i class="fas fa-chevron-right rotate"></i>
            </a>
            <div class="collapse {{ $userActive ? 'show' : '' }}" id="userManagementMenu">
                <ul class="nav flex-column">
                    @canany(['create user','view user'])
                    <li><a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-user menu-icon"></i> Users
                    </a></li>
                    @endcanany
                    @canany(['create role','view role'])
                    <li><a class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                        <i class="fas fa-shield-alt menu-icon"></i> Roles
                    </a></li>
                    @endcanany
                </ul>
            </div>
        </li>
        @endcanany

    </ul>

    {{-- Bottom profile strip --}}
    <div class="sidebar-footer">
        <div class="sf-avatar"><i class="fas fa-user"></i></div>
        <div style="flex:1;overflow:hidden;">
            <div class="sf-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="sf-role">Administrator</div>
        </div>
        <a href="{{ route('admin.logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="sf-logout" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

</nav>