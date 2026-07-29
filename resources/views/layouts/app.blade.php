@php
$setting = \App\Models\Setting::first();
$categories = \App\Models\Category::where('status', 1)->orderBy('serial')->get();
$facebook = \App\Models\Facebook::first();
$google = \App\Models\Google::first();
$tagmanager = \App\Models\TagManager::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="facebook-domain-verification" content="z1g3cr2y60vwb6c1kro98m9qp0gjqf" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ $setting->favicon ? Storage::url($setting->favicon) : asset('/assets/img/null.png') }}">

        
   


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- ✅ Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ filemtime(public_path('assets/css/main.css')) }}">



    <style>
        .search-results-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1050;
        }
        .search-results-dropdown.show {
            display: block !important;
        }

       /* ===== Mobile Tabbar (Bootstrap 5 version) — FIXED ===== */
    .mobile-tabbar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        border-top: 1px solid #e5e7eb;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.08);
        z-index: 1040;
        /* ✅ iPhone home-indicator area-র জন্য safe padding */
        padding-bottom: env(safe-area-inset-bottom, 0);
    }
    .mobile-tabbar .tabbar-inner {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 .5rem;
        /* ✅ height fix — flex shrink আটকানো */
        height: 64px;
    }
    .mobile-tabbar-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        height: 64px;
        text-decoration: none;
        transition: background-color .2s ease;
        cursor: pointer;
        /* ✅ shrink হওয়া বন্ধ */
        flex-shrink: 0;
    }

    /* ✅ সবচেয়ে গুরুত্বপূর্ণ ফিক্স — body/main-এর নিচে tabbar এর সমান জায়গা রাখা,
    যাতে content tabbar-এর নিচে চাপা না পড়ে এবং tabbar squished না দেখায় */
    body {
        padding-bottom: 76px;
    }
    @media (min-width: 992px) {
        body {
            padding-bottom: 0;
        }
    }
</style>


<style>
    .mobile-tabbar .tabbar-inner {
    padding: 0 4px;
}

.mobile-tabbar-link {
    flex: 1;
    min-width: 0;
}

.mobile-tabbar-link i {
    font-size: 1.05rem;
}

.mobile-tabbar-link span {
    font-size: .62rem;
    white-space: nowrap;
}

@media (max-width: 360px) {
    .mobile-tabbar-link span {
        font-size: .58rem;
    }
}
</style>

    {{-- ✅ Google Tag Manager (Head) --}}
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{$google->google_id}}');
    </script>

    {{-- ✅ Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$google->google_id}}"></script>

    {{-- ✅ Facebook Pixel --}}
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{$facebook->facebook_id}}');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
            src="https://www.facebook.com/tr?id={{$facebook->facebook_id}}&ev=PageView&noscript=1" />
    </noscript>

    {{-- ✅ Google Tag Manager (for Data Layer events) --}}
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{$tagmanager->tag_id}}');
    </script>

</head>

<body>

    {{-- ✅ Google Tag Manager (Body) --}}
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{$tagmanager->tag_id}}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

   <!-- ===== Mobile Tabbar (Bootstrap 5) ===== -->
<nav class="mobile-tabbar d-lg-none">
    <div class="tabbar-inner d-flex justify-content-around align-items-center">

        <!-- Home Tab -->
        <a href="/" class="mobile-tabbar-link">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>

        <!-- Categories Tab -->
        <a href="javascript:void(0)" onclick="document.getElementById('hamburgerBtn').click()" class="mobile-tabbar-link">
            <i class="fas fa-list"></i>
            <span>Categories</span>
        </a>

        <!-- All Product Tab -->
        <a href="{{ route('products') }}" class="mobile-tabbar-link">
            <i class="fas fa-shopping-bag"></i>
            <span>All Product</span>
        </a>

        <!-- Phone Tab -->
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $setting->phone_one ?? '') }}" class="mobile-tabbar-link">
            <i class="fas fa-phone"></i>
            <span>Phone</span>
        </a>

    </div>
</nav>

    <!-- ✅ jQuery CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- ✅ Slick Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <!-- ===================== LOCATION JAVASCRIPT ===================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>

    <script>
        // Thumbnail click
        const mainImage = document.getElementById('currentImage');
        const thumbnails = document.querySelectorAll('.image-thumbnails .thumb');

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                mainImage.src = this.src;
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>

    <script>
        function updateVariantInfo(variantId) {
            let variantOption = document.querySelector(`option[value='${variantId}']`);
            if (variantOption) {
                let price = variantOption.dataset.price;
                let stock = variantOption.dataset.stock;
                document.getElementById('variant-price').innerText = price;
                document.getElementById('variant-stock').innerText = stock;
            }
        }

        const colorSelect = document.getElementById('variant-color');
        const sizeSelect = document.getElementById('variant-size');

        if (colorSelect) {
            colorSelect.addEventListener('change', function() {
                updateVariantInfo(this.value);
            });
        }

        if (sizeSelect) {
            sizeSelect.addEventListener('change', function() {
                updateVariantInfo(this.value);
            });
        }
    </script>

    <script>
        $(document).ready(function() {

            var $qty = $('#qty');
            var stock = parseInt($('#variant-stock').text()) || 100;

            function updateVariant() {
                var colorOpt = $('#variant-color option:selected');
                var sizeOpt = $('#variant-size option:selected');

                var price = (sizeOpt.data('price') || colorOpt.data('price')) || parseFloat($('#variant-price').text());
                var stockVal = (sizeOpt.data('stock') || colorOpt.data('stock')) || stock;

                $('#variant-price').text(price);
                $('#variant-stock').text(stockVal);
                stock = stockVal;
                if (parseInt($qty.val()) > stock) $qty.val(stock);
            }

            $('#increment').click(function() {
                var val = parseInt($qty.val()) || 1;
                if (val < stock) $qty.val(val + 1);
            });
            $('#decrement').click(function() {
                var val = parseInt($qty.val()) || 1;
                if (val > 1) $qty.val(val - 1);
            });
            $qty.on('input', function() {
                var val = parseInt($qty.val()) || 1;
                if (val < 1) $qty.val(1);
                if (val > stock) $qty.val(stock);
            });

            $('#variant-color, #variant-size').change(updateVariant);

            // ===================================================
            // #add-to-cart — Product Single/Detail Page
            // GTM event: add_to_cart | page_type: product_detail
            // ===================================================
            $('#add-to-cart').click(function() {
                var productId   = $(this).data('product-id');
                var productName = $(this).data('name');
                var productSlug = $(this).data('slug');
                var image       = $(this).data('image');
                var quantity    = parseInt($('#qty').val()) || 1;
                var affiliateId = $(this).data('affiliate-id');

                var colorOpt = $('#variant-color option:selected');
                var sizeOpt  = $('#variant-size option:selected');
                var price = 0, color = '', size = '',
                    stock = parseInt($('#variant-stock').text()) || 100;

                if (colorOpt.length || sizeOpt.length) {
                    price = parseFloat(sizeOpt.data('price') || colorOpt.data('price') || $('#variant-price').text()) || 0;
                    stock = parseInt(sizeOpt.data('stock') || colorOpt.data('stock') || stock);
                    color = colorOpt.text() || '';
                    size  = sizeOpt.text()  || '';
                } else {
                    price = parseFloat($(this).data('price')) || 0;
                }

                if (quantity > stock) {
                    alert('Quantity exceeds stock!');
                    return;
                }

                // ✅ GTM DataLayer — add_to_cart (Product Detail Page)
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({ ecommerce: null }); // clear previous ecommerce object
                window.dataLayer.push({
                    event     : 'add_to_cart',
                    page_type : 'product_detail',
                    ecommerce : {
                        currency : 'BDT',
                        value    : price * quantity,
                        items    : [{
                            item_id      : String(productId),
                            item_name    : productName,
                            price        : price,
                            quantity     : quantity,
                            item_variant : color + (size ? ' / ' + size : '')
                        }]
                    }
                });

                // ✅ Facebook Pixel — AddToCart (Product Detail Page)
                fbq('track', 'AddToCart', {
                    content_ids  : [String(productId)],
                    content_name : productName,
                    content_type : 'product',
                    value        : price * quantity,
                    currency     : 'BDT'
                });

                var cart     = JSON.parse(localStorage.getItem('cart')) || [];
                var existing = cart.find(item => item.productId == productId && item.color == color && item.size == size);

                if (existing) {
                    existing.quantity += quantity;
                    if (existing.quantity > stock) existing.quantity = stock;
                } else {
                    cart.push({
                        productId   : String(productId),
                        name        : productName,
                        slug        : productSlug,
                        image       : image,
                        color       : color,
                        size        : size,
                        price       : price,
                        quantity    : quantity,
                        affiliateId : affiliateId
                    });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                toastr.success(productName + " added to cart successfully!");
                window.location.href = "{{ route('checkout') }}";
            });

        });
    </script>

    <!-- Desktop search -->
    <script>
        $(document).ready(function() {
            let $searchInput   = $('#searchInput');
            let $searchResults = $('#searchResults');
            let typingTimer;
            const doneTypingInterval = 300;

            $searchInput.on('keyup', function() {
                clearTimeout(typingTimer);
                let query = $(this).val().trim();
                if (query.length > 1) {
                    typingTimer = setTimeout(() => performSearch(query), doneTypingInterval);
                } else {
                    $searchResults.removeClass('show').addClass('d-none').empty();
                }
            });

            function performSearch(query) {
                $.ajax({
                    url    : "{{ route('product.liveSearch') }}",
                    method : "GET",
                    data   : { q: query },
                    success: res => renderResults(res, $searchResults),
                    error  : ()  => $searchResults.removeClass('show').addClass('d-none').empty()
                });
            }

            function renderResults(products, $container) {
                $container.empty();

                if (!products.length) {
                    $container.removeClass('d-none').addClass('show').html(
                        '<p class="p-4 text-muted small text-center mb-0">No products found.</p>'
                    );
                    return;
                }

                products.forEach(function(product) {
                    const salePrice    = parseFloat(product.sale_price).toFixed(2);
                    const regularPrice = parseFloat(product.regular_price).toFixed(2);
                    const url          = "{{ url('product') }}/" + product.slug;
                    const imgSrc       = product.featured_image_1
                        ? "/storage/" + product.featured_image_1
                        : 'https://via.placeholder.com/56x56/f3f4f6/9ca3af?text=?';
                    const brandName    = product.brand ? product.brand.name : '';
                    const hasSale      = parseFloat(product.sale_price) < parseFloat(product.regular_price);

                    const html = `
                    <a href="${url}" class="search-result-item d-flex align-items-center gap-2 px-3 py-2 border-bottom text-decoration-none">
                        <div class="search-result-thumb">
                            <img src="${imgSrc}" alt="${product.name}">
                        </div>
                        <div class="flex-grow-1" style="min-width:0;">
                            ${brandName ? `<p class="sr-brand mb-0">${brandName}</p>` : ''}
                            <p class="sr-name mb-0">${product.name}</p>
                        </div>
                        <div class="text-end flex-shrink-0">
                            ${hasSale ? `<p class="sr-regular-price mb-0">৳${regularPrice}</p>` : ''}
                            <p class="sr-sale-price mb-0">৳${salePrice}</p>
                        </div>
                    </a>`;

                    $container.append(html);
                });

                $container.removeClass('d-none').addClass('show');
            }

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#desktopSearchForm').length) {
                    $searchResults.removeClass('show').addClass('d-none');
                }
            });
        });
    </script>

    <!-- Mobile search -->
    <script>
        $(document).ready(function() {
            let $searchInputMobile   = $('#searchInputMobile');
            let $searchResultsMobile = $('#searchResultsMobile');
            let typingTimer;
            const doneTypingInterval = 300;

            $searchInputMobile.on('keyup', function() {
                clearTimeout(typingTimer);
                let query = $(this).val().trim();
                if (query.length > 1) {
                    typingTimer = setTimeout(() => performSearchMobile(query), doneTypingInterval);
                } else {
                    $searchResultsMobile.removeClass('show').addClass('d-none').empty();
                }
            });

            function performSearchMobile(query) {
                $.ajax({
                    url    : "{{ route('product.liveSearch') }}",
                    method : "GET",
                    data   : { q: query },
                    success: res => renderResultsMobile(res),
                    error  : ()  => $searchResultsMobile.removeClass('show').addClass('d-none').empty()
                });
            }

            function renderResultsMobile(products) {
                $searchResultsMobile.empty();

                if (!products.length) {
                    $searchResultsMobile.removeClass('d-none').addClass('show').html(
                        '<p class="p-4 text-muted small text-center mb-0">No products found.</p>'
                    );
                    return;
                }

                products.forEach(function(product) {
                    const salePrice    = parseFloat(product.sale_price).toFixed(2);
                    const regularPrice = parseFloat(product.regular_price).toFixed(2);
                    const url          = "{{ url('product') }}/" + product.slug;
                    const imgSrc       = product.featured_image_1
                        ? "/storage/" + product.featured_image_1
                        : 'https://via.placeholder.com/56x56/f3f4f6/9ca3af?text=?';
                    const brandName    = product.brand ? product.brand.name : '';
                    const hasSale      = parseFloat(product.sale_price) < parseFloat(product.regular_price);

                    const html = `
                    <a href="${url}" class="search-result-item d-flex align-items-center gap-2 px-3 py-2 border-bottom text-decoration-none">
                        <div class="search-result-thumb">
                            <img src="${imgSrc}" alt="${product.name}">
                        </div>
                        <div class="flex-grow-1" style="min-width:0;">
                            ${brandName ? `<p class="sr-brand mb-0">${brandName}</p>` : ''}
                            <p class="sr-name mb-0">${product.name}</p>
                        </div>
                        <div class="text-end flex-shrink-0">
                            ${hasSale ? `<p class="sr-regular-price mb-0">৳${regularPrice}</p>` : ''}
                            <p class="sr-sale-price mb-0">৳${salePrice}</p>
                        </div>
                    </a>`;

                    $searchResultsMobile.append(html);
                });

                $searchResultsMobile.removeClass('d-none').addClass('show');
            }

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#mobileSearchBar').length) {
                    $searchResultsMobile.removeClass('show').addClass('d-none');
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.add-to-wishlist', function(e) {
            e.preventDefault();

            let icon      = $(this);
            let productId = icon.data('id');

            $.ajax({
                url    : "{{ route('wishlist.store') }}",
                method : "POST",
                data   : {
                    product_id : productId,
                    _token     : "{{ csrf_token() }}"
                },
                success: function(res) {
                    if (res.status === 'error') {
                        toastr.warning(res.message);
                        return;
                    }
                    if (res.status === 'added') {
                        toastr.success(res.message);
                    } else if (res.status === 'removed') {
                        toastr.info(res.message);
                    }
                    setTimeout(() => location.reload(), 800);
                },
                error: function() {
                    toastr.error('Please login to add to wishlist.');
                }
            });
        });

        toastr.options = {
            "closeButton"   : true,
            "progressBar"   : true,
            "positionClass" : "toast-top-right",
            "timeOut"       : "3000"
        };
    </script>

    <script>
        function goToWishlist() {
            @if(auth()->guard('web')->check())
            window.location.href = "{{ route('wishlist.index') }}";
            @else
            toastr.warning('Please login to view your wishlist.');
            @endif
        }

        toastr.options = {
            "closeButton"   : true,
            "progressBar"   : true,
            "positionClass" : "toast-top-right",
            "timeOut"       : "3000"
        }
    </script>

    <script>
        $(document).on('click', '#accountLink', function() {
            @if(auth()->check())
            window.location.href = "{{ route('dashboard') }}";
            @else
            toastr.info('Please login to access your account.');
            setTimeout(function() {
                window.location.href = "{{ route('login') }}";
            }, 1500);
            @endif
        });
    </script>

    <script>
        @if(Session::has('success'))
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" };
        toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" };
        toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('warning'))
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" };
        toastr.warning("{{ Session::get('warning') }}");
        @endif

        @if(Session::has('info'))
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" };
        toastr.info("{{ Session::get('info') }}");
        @endif
    </script>

    {{-- ✅ trackProductView — Product Detail Page এ call করতে হবে --}}
    {{-- Usage (product show blade এ):                              --}}
    {{--   <script>                                                 --}}
    {{--     trackProductView('{{ $product->name }}',               --}}
    {{--                      '{{ $product->id }}',                 --}}
    {{--                      {{ $product->sale_price }});          --}}
    {{--   </script>                                                --}}
    <script>
        function trackProductView(productName, productId, price) {
            // ✅ GTM DataLayer — view_item (Product Detail Page)
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({ ecommerce: null }); // clear previous
            window.dataLayer.push({
                event     : 'view_item',
                page_type : 'product_detail',
                ecommerce : {
                    currency : 'BDT',
                    value    : price,
                    items    : [{
                        item_id   : String(productId),
                        item_name : productName,
                        price     : price,
                        quantity  : 1
                    }]
                }
            });

            // ✅ Facebook Pixel — ViewContent (Product Detail Page)
            fbq('track', 'ViewContent', {
                content_ids  : [String(productId)],
                content_name : productName,
                content_type : 'product',
                value        : price,
                currency     : 'BDT'
            });
        }
    </script>



    <!-- =================== MAIN CART SYSTEM =================== -->
    <script>
        let currency = "{{ currency() }}";

        // ================= PRODUCT QTY =================
        function incrementQuantity(btn) {
            let input = btn.parentElement.querySelector('.product-qty');
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity(btn) {
            let input = btn.parentElement.querySelector('.product-qty');
            let val = parseInt(input.value);
            if (val > 1) input.value = val - 1;
        }

        // ===================================================
        // .orders-now — Home / Category / Listing Pages
        // GTM event: add_to_cart | page_type: listing
        // ===================================================
        $(document).on('click', '.orders-now', function(e) {
            e.preventDefault();
            let btn = $(this);

            // ✅ Product single page এ color/size selected থাকলে সেটা use করো
            let colorVal = (typeof selectedColorValue   !== 'undefined' && selectedColorValue)   ? selectedColorValue   : (btn.data('color') || '');
            let sizeVal  = (typeof selectedSizeValue    !== 'undefined' && selectedSizeValue)    ? selectedSizeValue    : (btn.data('size')  || '');
            let priceVal = (typeof selectedVariantPrice !== 'undefined' && selectedVariantPrice) ? selectedVariantPrice : parseFloat(btn.data('price'));

            // ✅ Validation — product single page এ
            if (typeof validateBeforeOrder === 'function') {
                if (!validateBeforeOrder()) return;
            }

            let qtyInput = btn.closest('.p-4, .mb-4').find('.product-qty, #quantity');
            let qty      = qtyInput.length ? parseInt(qtyInput.val()) || 1 : 1;

            let productName = btn.data('name');
            if (colorVal) productName += ' - ' + colorVal;
            if (sizeVal)  productName += ' / ' + sizeVal;

            let item = {
                productId : btn.data('id'),
                name      : productName,
                price     : priceVal,
                image     : btn.data('image'),
                slug      : btn.data('slug'),
                quantity  : qty,
                color     : colorVal,
                size      : sizeVal
            };

            // ✅ GTM DataLayer — add_to_cart (Listing / Home Page)
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({ ecommerce: null }); // clear previous ecommerce object
            window.dataLayer.push({
                event     : 'add_to_cart',
                page_type : 'listing',              // GTM এ page_type দিয়ে filter করা যাবে
                ecommerce : {
                    currency : 'BDT',
                    value    : item.price * item.quantity,
                    items    : [{
                        item_id      : String(item.productId),
                        item_name    : item.name,
                        price        : item.price,
                        quantity     : item.quantity,
                        item_variant : (item.color ? item.color : '') + (item.size ? ' / ' + item.size : '')
                    }]
                }
            });

            // ✅ Facebook Pixel — AddToCart (Listing / Home Page)
            fbq('track', 'AddToCart', {
                content_ids  : [String(item.productId)],
                content_name : item.name,
                content_type : 'product',
                value        : item.price * item.quantity,
                currency     : 'BDT'
            });

            let cart  = JSON.parse(localStorage.getItem('cart')) || [];
            let exist = cart.find(p => p.productId === item.productId && p.color === item.color && p.size === item.size);

            if (exist) {
                exist.quantity += qty;
            } else {
                cart.push(item);
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            toastr.success(item.name + ' added to cart!');
            renderCart();
            toggleCart();
        });

       // ================= RENDER CART =================
        function renderCart() {
            let cart  = JSON.parse(localStorage.getItem('cart')) || [];
            let html  = '';
            let total = 0;
            let count = 0;

            if (cart.length === 0) {
                html = `
                <div class="text-center text-muted py-5" id="emptyCartMessage">
                    <i class="bi bi-bag-x" style="font-size:2.2rem;"></i>
                    <p class="mb-0 mt-2">Your cart is empty</p>
                </div>`;
            } else {
                cart.forEach((item, index) => {
                    total += item.price * item.quantity;
                    count += item.quantity;

                    html += `
                    <div class="cart-item" data-cart-index="${index}">
                        <img src="${item.image}" alt="${item.name}">
                        <div class="cart-item-info">
                            <p class="cart-item-title">${item.name}</p>
                            ${(item.color || item.size) ? `<span class="cart-item-variant">${item.color || ''}${item.size ? ' | ' + item.size : ''}</span>` : ''}
                            <div class="cart-item-bottom">
                                <div class="qty-box">
                                    <button class="cart-qty-decrease" data-index="${index}">-</button>
                                    <span>${item.quantity}</span>
                                    <button class="cart-qty-increase" data-index="${index}">+</button>
                                </div>
                                <span class="cart-item-price">${currency}${item.price.toFixed(2)}</span>
                            </div>
                        </div>
                        <button type="button" class="cart-item-remove remove-cart-item" data-index="${index}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>`;
                });
            }

            $('#cartItems').html(html);
            $('#subtotal').text(currency + total.toFixed(2));
            $('#cartTotal').text(currency + total.toFixed(2));
            $('#cartItemCount').text('(' + count + ')');
            $('#shopingcart').text(count);
            $('#sidebarcartTotal').text(count + ' items');
            $('#footerCartTotal').text(count);
            $('#sidebarcartTotalAmount').text(currency + ' ' + total.toFixed(2));
            $('.cart-count').text(count); // header top er cart icon count
        }

        // ================= REMOVE =================
        $(document).on('click', '.remove-cart-item', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let index = parseInt($(this).data('index'));
            let cart  = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart[index]) {
                let removedItem = cart[index];
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                toastr.info(removedItem.name + " removed from cart!");
                renderCart();
            }
        });

        // ================= QTY DECREASE =================
        $(document).on('click', '.cart-qty-decrease', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let index = parseInt($(this).data('index'));
            let cart  = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart[index]) {
                cart[index].quantity -= 1;
                if (cart[index].quantity <= 0) {
                    let removedItem = cart[index];
                    cart.splice(index, 1);
                    toastr.info(removedItem.name + " removed from cart!");
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }
        });

        // ================= QTY INCREASE =================
        $(document).on('click', '.cart-qty-increase', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let index = parseInt($(this).data('index'));
            let cart  = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart[index]) {
                cart[index].quantity += 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                renderCart();
            }
        });

        // ================= TOGGLE =================
        function toggleCart() {
            const sidebar = document.getElementById('cartSidebar');
            if (sidebar) sidebar.classList.toggle('translate-x-full');
        }

        // ================= INIT =================
        $(document).ready(function() {
            renderCart();
        });
    </script>

    <script>
        // Review Slider
        $('.reviewSlider').slick({
            dots           : false,
            arrows         : false,
            infinite       : true,
            speed          : 500,
            autoplay       : true,
            autoplaySpeed  : 4000,
            slidesToShow   : 3,
            slidesToScroll : 1,
            responsive: [
                { breakpoint: 1024, settings: { slidesToShow: 2, slidesToScroll: 1 } },
                { breakpoint: 768,  settings: { slidesToShow: 1, slidesToScroll: 1 } }
            ]
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ── Cart Sidebar এর Checkout বাটন ── */
            const cartSidebar = document.getElementById('cartSidebar');
            if (cartSidebar) {
                const checkoutBtn = cartSidebar.querySelector('a[href*="checkout"] button, a[href*="checkout"]');
                if (checkoutBtn) {
                    checkoutBtn.addEventListener('click', function (e) {
                        const cart = JSON.parse(localStorage.getItem('cart')) || [];
                        if (!cart.length) return;

                        const total = cart.reduce((s, i) => s + (parseFloat(i.price) * i.quantity), 0);
                        const items = cart.map(function (item) {
                            return {
                                item_id      : String(item.productId || item.id || ''),
                                item_name    : item.name || '',
                                price        : parseFloat(item.price) || 0,
                                quantity     : item.quantity || 1,
                                item_variant : (item.color || '') + (item.size ? ' / ' + item.size : ''),
                            };
                        });

                        // GTM — begin_checkout
                        window.dataLayer = window.dataLayer || [];
                        window.dataLayer.push({ ecommerce: null });
                        window.dataLayer.push({
                            event     : 'begin_checkout',
                            page_type : 'cart_sidebar',
                            ecommerce : {
                                currency : 'BDT',
                                value    : total,
                                items    : items,
                            }
                        });

                        // Facebook Pixel — InitiateCheckout
                        if (typeof fbq !== 'undefined') {
                            fbq('track', 'InitiateCheckout', {
                                content_ids  : cart.map(function (i) { return String(i.productId || i.id || ''); }),
                                content_type : 'product',
                                value        : total,
                                currency     : 'BDT',
                                num_items    : cart.reduce(function (s, i) { return s + i.quantity; }, 0),
                            });
                        }
                    });
                }
            }
        });
    </script>


    <!-- ===================== MAIN INIT SCRIPT (Banner Slider, Cart Sidebar, Mobile Sidebar, Mobile Search, Wishlist) ===================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

         (function initBannerSlider() {
            try {
                var track = document.getElementById('bannerTrack');
                if (!track) return;   // ✅ শুধু track লাগবে, dotsWrap optional

                var slides = track.querySelectorAll('.banner-slide');
                var total = slides.length;
                if (total === 0) return;

                // ✅ Dynamic width — dots থাকুক বা না থাকুক, এটা সবসময় চলবে
                track.style.width = (total * 100) + '%';
                slides.forEach(function (slide) {
                    slide.style.width = (100 / total) + '%';
                });

                var dotsWrap = document.getElementById('bannerDots');
                var dots = dotsWrap ? dotsWrap.querySelectorAll('button') : [];
                var current = 0;
                var autoTimer = null;

                function goTo(index) {
                    current = (index + total) % total;
                    track.style.transform = 'translateX(-' + (current * (100 / total)) + '%)';
                    dots.forEach(function (d, i) {
                        d.classList.toggle('active', i === current);
                    });
                }

                function next() { goTo(current + 1); }
                function prev() { goTo(current - 1); }

                function startAuto() {
                    stopAuto();
                    if (total > 1) {
                        autoTimer = setInterval(next, 4500);
                    }
                }
                function stopAuto() {
                    if (autoTimer) clearInterval(autoTimer);
                }

                var prevBtn = document.getElementById('bannerPrev');
                var nextBtn = document.getElementById('bannerNext');
                if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAuto(); });
                if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAuto(); });

                dots.forEach(function (dot) {
                    dot.addEventListener('click', function () {
                        goTo(parseInt(dot.getAttribute('data-index'), 10));
                        startAuto();
                    });
                });

                var sliderWrap = document.getElementById('bannerSlider');
                if (sliderWrap) {
                    sliderWrap.addEventListener('mouseenter', stopAuto);
                    sliderWrap.addEventListener('mouseleave', startAuto);
                }

                goTo(0);
                startAuto();
            } catch (err) {
                console.error('Banner slider error:', err);
            }
            })();

            /* =========================================================
               2) CART SIDEBAR TOGGLE (works for both desktop-right
                  and mobile-bottom, CSS handles the positioning)
            ========================================================= */
            (function initCartSidebar() {
                try {
                    var cartToggle = document.getElementById('cartToggle');
                    var cartSidebar = document.getElementById('cartSidebar');
                    var cartOverlay = document.getElementById('cartOverlay');
                    var cartClose = document.getElementById('cartClose');
                    if (!cartToggle || !cartSidebar || !cartOverlay) return;

                    function openCart() {
                        cartSidebar.classList.add('active');
                        cartOverlay.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                    function closeCart() {
                        cartSidebar.classList.remove('active');
                        cartOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }

                    cartToggle.addEventListener('click', function (e) {
                        e.preventDefault();
                        openCart();
                    });
                    if (cartClose) cartClose.addEventListener('click', closeCart);
                    cartOverlay.addEventListener('click', closeCart);

                    cartSidebar.addEventListener('click', function (e) {
                        if (e.target.classList.contains('qty-plus')) {
                            var span = e.target.previousElementSibling;
                            span.textContent = parseInt(span.textContent, 10) + 1;
                        }
                        if (e.target.classList.contains('qty-minus')) {
                            var span2 = e.target.nextElementSibling;
                            var val = parseInt(span2.textContent, 10);
                            if (val > 1) span2.textContent = val - 1;
                        }
                        if (e.target.closest('.cart-item-remove')) {
                            var item = e.target.closest('.cart-item');
                            item.style.transition = 'opacity .2s ease';
                            item.style.opacity = '0';
                            setTimeout(function () { item.remove(); }, 200);
                        }
                    });
                } catch (err) {
                    console.error('Cart sidebar error:', err);
                }
            })();

            /* =========================================================
                3) MOBILE LEFT SIDEBAR (hamburger menu)
            ========================================================= */
            (function initMobileSidebar() {
                try {
                    var hamburgerBtn = document.getElementById('hamburgerBtn');
                    var mobileSidebar = document.getElementById('mobileSidebar');
                    var mobileOverlay = document.getElementById('mobileOverlay');
                    var mobileClose = document.getElementById('mobileSidebarClose');

                    if (!hamburgerBtn || !mobileSidebar || !mobileOverlay) {
                        console.warn('Mobile sidebar: missing elements', {
                            hamburgerBtn: !!hamburgerBtn,
                            mobileSidebar: !!mobileSidebar,
                            mobileOverlay: !!mobileOverlay
                        });
                        return;
                    }

                    function openMenu() {
                        mobileSidebar.classList.add('active');
                        mobileOverlay.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                    function closeMenu() {
                        mobileSidebar.classList.remove('active');
                        mobileOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }

                    hamburgerBtn.addEventListener('click', openMenu);
                    if (mobileClose) mobileClose.addEventListener('click', closeMenu);
                    mobileOverlay.addEventListener('click', closeMenu);

                    var submenuToggles = mobileSidebar.querySelectorAll('[data-toggle="submenu"]');

                    submenuToggles.forEach(function (toggle) {
                        toggle.addEventListener('click', function (e) {
                            e.preventDefault();
                            e.stopPropagation();

                            var parentItem = toggle.closest('.mobile-nav-item');
                            if (!parentItem) return;

                            var isOpen = parentItem.classList.contains('open');

                            mobileSidebar.querySelectorAll('.mobile-nav-item.open').forEach(function (item) {
                                if (item !== parentItem) item.classList.remove('open');
                            });

                            if (isOpen) {
                                parentItem.classList.remove('open');
                            } else {
                                parentItem.classList.add('open');
                            }
                        });
                    });
                } catch (err) {
                    console.error('Mobile sidebar error:', err);
                }
            })();

            /* =========================================================
               4) MOBILE SEARCH BAR TOGGLE
            ========================================================= */
            (function initMobileSearch() {
                try {
                    var searchToggle = document.getElementById('mobileSearchToggle');
                    var searchBar = document.getElementById('mobileSearchBar');
                    var searchClose = document.getElementById('mobileSearchClose');
                    if (!searchToggle || !searchBar) return;

                    function openSearch() {
                        searchBar.classList.add('active');
                        searchToggle.classList.add('active');
                        var input = searchBar.querySelector('input');
                        if (input) setTimeout(function () { input.focus(); }, 300);
                    }
                    function closeSearch() {
                        searchBar.classList.remove('active');
                        searchToggle.classList.remove('active');
                    }

                    searchToggle.addEventListener('click', function () {
                        if (searchBar.classList.contains('active')) {
                            closeSearch();
                        } else {
                            openSearch();
                        }
                    });

                    if (searchClose) {
                        searchClose.addEventListener('click', closeSearch);
                    }
                } catch (err) {
                    console.error('Mobile search error:', err);
                }
            })();

            /* =========================================================
               5) WISHLIST BUTTON TOGGLE
            ========================================================= */
            (function initWishlist() {
                try {
                    document.querySelectorAll('.wishlist-btn').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            var icon = btn.querySelector('i');
                            icon.classList.toggle('bi-heart');
                            icon.classList.toggle('bi-heart-fill');
                            btn.classList.toggle('active-wish');
                        });
                    });
                } catch (err) {
                    console.error('Wishlist error:', err);
                }
            })();

        });
    </script>

    <!-- REVIEW SLIDER js -->
    <script>
        (function () {
            const track = document.getElementById('slidesTrack');
            const dotsEl = document.getElementById('sliderDots');
            if (!track || !dotsEl) return;
            const items = track.querySelectorAll('.slide-item');
            let current = 0;
            let perView = 3;
            let autoTimer = null;

            function getPerView() {
                const w = window.innerWidth;
                if (w <= 768) return 1;
                if (w <= 992) return 2;
                return 3;
            }

            function totalSlides() {
                return Math.ceil(items.length / perView);
            }

            function buildDots() {
                dotsEl.innerHTML = '';
                for (let i = 0; i < totalSlides(); i++) {
                    const s = document.createElement('span');
                    if (i === current) s.classList.add('active');
                    s.addEventListener('click', () => goTo(i));
                    dotsEl.appendChild(s);
                }
            }

            function goTo(idx) {
                const total = totalSlides();
                current = (idx + total) % total;
                const itemWidthPercent = 100 / items.length;
                const offset = current * perView * itemWidthPercent;
                track.style.transform = `translateX(-${offset}%)`;
                buildDots();
            }

            function init() {
                perView = getPerView();
                track.style.width = `${(items.length / perView) * 100}%`;
                items.forEach(item => {
                    item.style.flex = `0 0 ${100 / items.length}%`;
                });
                current = 0;
                track.style.transform = 'translateX(0)';
                buildDots();
                startAuto();
            }

            function startAuto() {
                clearInterval(autoTimer);
                autoTimer = setInterval(() => goTo(current + 1), 4000);
            }

            window.addEventListener('resize', init);
            init();
        })();
    </script>


<script>

    let currentCategoryType = null;
    let currentCategoryId = null;
    let selectedSizes = [];

    function openSizeMenu(el) {
        currentCategoryType = el.dataset.type;
        currentCategoryId   = el.dataset.id;
        selectedSizes = [];

        document.getElementById('sizeMenuCategoryName').textContent = el.dataset.name.toUpperCase();
        document.getElementById('sizeMenuOverlay').classList.add('active');
        document.getElementById('sizeMenuPanel').classList.add('active');
        document.body.style.overflow = 'hidden';

        document.getElementById('sizeMenuBody').innerHTML =
            '<p class="size-menu-placeholder">আপনার প্রয়োজনীয় পণ্য দেখতে সাইজ সিলেক্ট করুন</p>';

        loadCategorySizes();
    }

    document.getElementById('sizeMenuClose').addEventListener('click', closeSizeMenu);
    document.getElementById('sizeMenuOverlay').addEventListener('click', closeSizeMenu);

    function closeSizeMenu() {
        document.getElementById('sizeMenuOverlay').classList.remove('active');
        document.getElementById('sizeMenuPanel').classList.remove('active');
        document.body.style.overflow = '';
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function loadCategorySizes() {
        document.getElementById('sizeBtnGroup').innerHTML = '<span class="text-white-50 small">Loading sizes...</span>';

        $.ajax({
            url: "/category-sizes",
            method: 'POST',
            data: {
                _token: csrfToken,
                type: currentCategoryType,
                id: currentCategoryId
            },
            success: function (sizes) {
                renderSizeButtons(sizes);
            },
            error: function (xhr) {
                console.error('Size load error:', xhr.status, xhr.responseText);
                document.getElementById('sizeBtnGroup').innerHTML = '<span class="text-white-50 small">Could not load sizes.</span>';
            }
        });
    }

    function renderSizeButtons(sizes) {
        const wrap = document.getElementById('sizeBtnGroup');

        if (!sizes.length) {
            wrap.innerHTML = '<span class="text-white-50 small">No sized products in this category.</span>';
            return;
        }

        let html = '';
        sizes.forEach(s => {
            html += `<button type="button" class="size-btn" data-size-id="${s.id}" onclick="toggleSize(this)">${s.name}</button>`;
        });
        html += `<button type="button" class="btn-view-products" id="viewProductsBtn" onclick="loadProductsBySelectedSizes()" disabled>
                    <i class="bi bi-search"></i> View Products
                </button>`;

        wrap.innerHTML = html;
    }

    function toggleSize(btn) {
        const sizeId = btn.dataset.sizeId;
        btn.classList.toggle('active');

        if (selectedSizes.includes(sizeId)) {
            selectedSizes = selectedSizes.filter(id => id !== sizeId);
        } else {
            selectedSizes.push(sizeId);
        }

        const viewBtn = document.getElementById('viewProductsBtn');
        if (viewBtn) viewBtn.disabled = selectedSizes.length === 0;
    }

    // ✅ Selected size(s) সহ সরাসরি products page এ নিয়ে যাবে
    function loadProductsBySelectedSizes() {
        const params = new URLSearchParams();

        if (currentCategoryType === 'sub_category') {
            params.append('sub_category', currentCategoryId);
        } else {
            params.append('category', currentCategoryId);
        }

        selectedSizes.forEach(sizeId => {
            params.append('sizes[]', sizeId);
        });

        window.location.href = "{{ route('products') }}?" + params.toString();
    }

</script>


<script>
// ── ✅ Marquee-কে সত্যিকারের infinite বানানো — item কম থাকলেও track যথেষ্ট চওড়া না হওয়া পর্যন্ত clone করে ──
function ensureInfiniteMarquee(trackId, wrapSelector) {
    const track = document.getElementById(trackId);
    if (!track) return;

    const wrap = track.closest(wrapSelector);
    if (!wrap) return;

    const originalHTML = track.innerHTML;

    function fillTrack() {
        track.innerHTML = originalHTML;
        let safety = 0;
        while (track.scrollWidth < wrap.clientWidth * 2 && safety < 20) {
            track.innerHTML += originalHTML;
            safety++;
        }
    }

    fillTrack();

    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(fillTrack, 250);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    ensureInfiniteMarquee('brandsTrack', '.brands-marquee-outer');
    ensureInfiniteMarquee('showroomMarqueeTrack', '.showroom-marquee-wrap');
});
</script>



    @yield('script')

</body>

</html>