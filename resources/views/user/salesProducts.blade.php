@extends('user.layouts.app')
@section('title', 'My Sales Products')

@section('content')
<div class="container mx-auto py-8 min-h-screen px-3">

    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 text-white flex justify-between items-center">
            <h5 class="text-lg font-semibold">My Sales Products List</h5>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2 border-b">#</th>
                        <th class="px-4 py-2 border-b">Name</th>
                        <th class="px-4 py-2 border-b">Image</th>
                        <th class="px-4 py-2 border-b">Price ({{ currency() }})</th>
                        <th class="px-4 py-2 border-b">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>

                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $product->name }}
                        </td>

                        <td class="px-4 py-3">
                            <img src="{{ Storage::url($product->featured_image_1) }}"
                                 alt="Product Image"
                                 class="w-12 h-12 rounded object-cover">
                        </td>

                        <td class="px-4 py-3">
                            <del class="text-gray-400">{{ currency() }}{{ number_format($product->regular_price, 2) }}</del>
                            <span class="ml-2 font-semibold text-green-600">
                                {{ currency() }}{{ number_format($product->sale_price, 2) }}
                            </span>
                        </td>

                        <td class="px-4 py-3">

    @php
        $shareUrl = route('user.referal.product', [
            'slug' => $product->slug, 
            'referal_code' => optional(auth()->guard('web')->user())->referal_code
        ]);
    @endphp

    <!-- COPY BUTTON -->
    <button 
        onclick="copyToClipboard('{{ $shareUrl }}')" 
        class="px-4 py-2 bg-green-600 text-white text-sm rounded-md shadow hover:bg-green-700 transition">
        Copy Link
    </button>

    <!-- DROPDOWN SHARE -->
    <div x-data="{ open: false }" class="inline-block ml-2 relative">

        <button 
            @click="open = !open"
            class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md shadow hover:bg-blue-700 transition">
            Share
        </button>

        <!-- Dropdown Menu -->
        <div 
            x-show="open"
            @click.away="open = false"
            x-transition
            class="absolute mt-2 bg-white shadow-lg rounded-md w-40 border z-50"
        >

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
               target="_blank"
               class="block px-4 py-2 text-sm hover:bg-gray-100">
                Facebook
            </a>

            <a href="https://api.whatsapp.com/send?text={{ urlencode($shareUrl) }}"
               target="_blank"
               class="block px-4 py-2 text-sm hover:bg-gray-100">
                WhatsApp
            </a>

            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}"
               target="_blank"
               class="block px-4 py-2 text-sm hover:bg-gray-100">
                X / Twitter
            </a>

        </div>
    </div>

</td>


                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-4">
                            No Products Found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => alert('Product link copied!'))
            .catch(err => console.error('Failed to copy:', err));
    }
</script>
@endsection
