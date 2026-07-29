@extends('layouts.app')

@section('title', $sellers->shop_name . ' | Shop')

@section('content')

<!-- Seller Hero Banner -->
<div class="relative w-full h-80 bg-cover bg-center" style="background-image: url('{{ Storage::url($sellers->banner) }}');">
    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/50"></div>
    
    <!-- Content -->
    <div class="container mx-auto px-4 relative z-10 h-full flex items-end pb-20">
        <div class="w-full max-w-5xl mx-auto">
            
            <!-- Floating Seller Info Card -->
            <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl p-6 md:p-8 border border-gray-100">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    
                    <!-- Seller Logo -->
                    <div class="flex-shrink-0">
                        <img src="{{ Storage::url($sellers->logo) }}"
                            class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white shadow-xl"
                            alt="{{ $sellers->shop_name }}">
                    </div>

                    <!-- Seller Details -->
                    <div class="flex-1 text-center md:text-left">
                        <!-- Shop Name -->
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">
                            {{ $sellers->shop_name }}
                        </h2>

                        <!-- Contact Info -->
                        <div class="space-y-2 mb-4">
                            <!-- Phone -->
                            <p class="flex items-center justify-center md:justify-start gap-2 text-gray-700">
                                <i class="fas fa-phone text-green-500"></i>
                                <span>{{ $sellers->phone }}</span>
                            </p>

                            <!-- Address -->
                            @if($sellers->address)
                            <p class="flex items-center justify-center md:justify-start gap-2 text-gray-700">
                                <i class="fas fa-map-marker-alt text-red-500"></i>
                                <span>{{ $sellers->address }}</span>
                            </p>
                            @endif

                            <!-- Description -->
                            @if($sellers->description)
                            <p class="flex items-start justify-center md:justify-start gap-2 text-gray-600 text-sm">
                                <i class="fas fa-info-circle text-primary mt-1"></i>
                                <span class="line-clamp-2">{{ $sellers->description }}</span>
                            </p>
                            @endif
                        </div>

                        <!-- WhatsApp Button -->
                        <a href="https://wa.me/{{ $sellers->phone }}" target="_blank"
                            class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-6 py-2.5 rounded-lg font-semibold transition-all shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                            <i class="fab fa-whatsapp text-lg"></i>
                            <span>Chat on WhatsApp</span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Products Section -->
<div class="container mx-auto px-4 py-12">
    
    <!-- Section Header -->
    <div class="mb-8">
        <h4 class="text-2xl md:text-3xl font-bold text-gray-800 pb-4 border-b-2 border-primary inline-block">
            Products from this Seller
        </h4>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
        @foreach ($sellers->products as $product)
        <div class="group">
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                
                <!-- Product Image -->
                <a href="{{ route('product.single', $product->slug) }}" class="block relative overflow-hidden">
                    <img src="{{ Storage::url($product->featured_image_1) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-48 md:h-64 object-cover transition-transform duration-300 group-hover:scale-110">
                    
                    @if($product->featured_image_2)
                    <img src="{{ Storage::url($product->featured_image_2) }}" 
                         alt="{{ $product->name }}"
                         class="absolute inset-0 w-full h-48 md:h-64 object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    @endif

                    <!-- Discount Badge -->
                    @php
                    if($product->regular_price > 0 && $product->sale_price < $product->regular_price) {
                        $discount = round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100);
                    } else {
                        $discount = 0;
                    }
                    @endphp

                    @if($discount > 0)
                    <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-lg text-xs font-bold">
                        {{ $discount }}% OFF
                    </div>
                    @endif
                </a>

                <!-- Product Info -->
                <div class="p-3 md:p-4">
                    <!-- Product Name -->
                    <h5 class="text-sm md:text-base font-semibold text-gray-800 mb-1 line-clamp-2 hover:text-primary transition-colors">
                        <a href="{{ route('product.single', $product->slug) }}">
                            {{ $product->name }}
                        </a>
                    </h5>

                    <!-- Unit -->
                    @if($product->unit)
                    <p class="text-xs text-gray-500 mb-2">{{ $product->unit }}</p>
                    @endif

                    <!-- Rating (Desktop) -->
                    <div class="hidden md:flex items-center justify-between mb-3">
                        <span class="text-lg font-bold text-gray-900">
                            {{ currency() }} {{ number_format($product->sale_price, 2) }}
                        </span>
                        <div class="flex items-center gap-1">
                            <div class="flex text-yellow-400 text-xs">
                                @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500">({{ $product->reviews_count }})</span>
                        </div>
                    </div>

                    <!-- Rating & Price (Mobile) -->
                    <div class="block md:hidden space-y-1 mb-3">
                        <div class="flex items-center gap-1">
                            <div class="flex text-yellow-400 text-xs">
                                @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500">({{ $product->reviews_count }})</span>
                        </div>
                        <span class="block text-base font-bold text-gray-900">
                            {{ currency() }} {{ number_format($product->sale_price, 2) }}
                        </span>
                    </div>

                    <!-- Add to Cart Button -->
                    <button type="button"
                        class="order-now w-full bg-primary hover:bg-red-700 text-white py-2 md:py-2.5 rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:scale-[1.02]"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-slug="{{ $product->slug }}"
                        data-image="{{ Storage::url($product->featured_image_1) }}"
                        data-price="{{ $product->sale_price }}"
                        data-has-variant="{{ $product->variants->count() > 0 ? '1' : '0' }}">
                        <i class="fas fa-shopping-cart text-sm"></i>
                        <span class="text-xs md:text-sm">Add to Cart</span>
                    </button>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($sellers->products->count() === 0)
    <div class="text-center py-16">
        <div class="inline-block p-6 bg-gray-100 rounded-full mb-4">
            <i class="fas fa-box-open text-6xl text-gray-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">No Products Yet</h3>
        <p class="text-gray-600">This seller hasn't added any products yet. Check back later!</p>
    </div>
    @endif

</div>

@endsection