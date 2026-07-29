@extends('layouts.app')
@section('title', 'Track Orders')
@section('content')

<section class="py-10 md:py-14 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-3xl">

        <!-- Instructions + Track Form Box -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-8">

            <!-- Instructions -->
            <div class="p-6 md:p-8">
                <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-3">অর্ডার ট্র্যাক করুন</h2>
                <p class="text-sm md:text-base text-gray-600 leading-relaxed mb-2">
                    ১। পণ্যের ডেলিভারি আপডেট পেতে আপনার Mobile Number অথবা Invoice ID দিয়ে অর্ডার ট্র্যাক করুন।
                </p>
                <p class="text-sm md:text-base text-gray-600 leading-relaxed">
                    ২। আপনার অর্ডার করা পণ্যের ডেলিভারির বর্তমান অবস্থা জানতে নিচের বক্সে
                    <span class="font-semibold text-gray-800">Mobile Number অথবা Invoice ID</span> টি প্রদান করুন এবং
                    <span class="font-semibold text-[#EA580C]">"Track Order"</span> বাটনে ক্লিক করুন।
                </p>
            </div>

            <!-- Search Row -->
            <div class="border-t border-gray-200 bg-gray-50 p-4 md:p-6">
                <form action="{{ route('track.order') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <div class="relative flex-1">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input
                            value="{{ request('invoice_id') }}"
                            type="search"
                            id="invoice_id"
                            name="invoice_id"
                            required
                            placeholder="Enter Phone Number / Invoice Number"
                            class="w-full pl-11 pr-4 py-3.5 bg-white border border-gray-300 rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#EA580C] focus:ring-1 focus:ring-[#EA580C] transition-all"
                        />
                    </div>
                    <button type="submit"
                        class="bg-[#EA580C] hover:opacity-90 active:scale-[0.98] text-white font-bold text-sm px-8 py-3.5 rounded-xl transition-all whitespace-nowrap">
                        Track Order
                    </button>
                </form>
            </div>
        </div>

        @if(request()->has('invoice_id'))

            @if(isset($order))
            <!-- Order Result -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

                <!-- Header -->
                <div class="p-6 md:p-8 border-b border-gray-100">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Customer Info</p>
                            <p class="text-sm text-gray-800 font-semibold">{{ $order->user->name ?? 'Guest' }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-phone-alt text-[11px] mr-1"></i>{{ $order->user->phone ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-location-dot text-[11px] mr-1"></i>{{ $order->user->address ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="text-left sm:text-right">
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Delivery Area</p>
                            <p class="text-sm text-gray-800 font-semibold mb-3">{{ $order->delivery_area ?? 'N/A' }}</p>

                            <div class="flex flex-wrap gap-2 sm:justify-end">
                                <span class="inline-block bg-orange-50 text-[#EA580C] text-xs font-bold px-3 py-1 rounded-full capitalize">
                                    {{ $order->status ?? 'N/A' }}
                                </span>
                                <span class="inline-block bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full capitalize">
                                    Payment: {{ $order->payment_status ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ordered Products -->
                <div class="p-6 md:p-8">
                    <h6 class="text-sm font-bold text-gray-800 uppercase tracking-wide mb-4">Ordered Products</h6>

                    <div class="overflow-x-auto rounded-xl border border-gray-200">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase">#</th>
                                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase">Product</th>
                                    <th class="text-center px-4 py-3 text-xs font-bold text-gray-500 uppercase">Qty</th>
                                    <th class="text-right px-4 py-3 text-xs font-bold text-gray-500 uppercase">Price</th>
                                    <th class="text-right px-4 py-3 text-xs font-bold text-gray-500 uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($order->orderItems as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-gray-800 font-medium">{{ $item->product->name ?? 'Product Name' }}</td>
                                    <td class="px-4 py-3 text-center text-gray-600">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right text-gray-600">{{ number_format($item->price, 2) }}</td>
                                    <td class="px-4 py-3 text-right text-gray-800 font-semibold">{{ number_format($item->quantity * $item->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="flex justify-end mt-6">
                        <div class="w-full sm:w-72 bg-gray-50 rounded-xl border border-gray-200 divide-y divide-gray-200 overflow-hidden">
                            <div class="flex justify-between px-4 py-2.5 text-sm">
                                <span class="text-gray-500">Total</span>
                                <span class="text-gray-800 font-semibold">{{ number_format($order->total, 2) }}</span>
                            </div>
                            <div class="flex justify-between px-4 py-2.5 text-sm">
                                <span class="text-gray-500">Paid</span>
                                <span class="text-gray-800 font-semibold">{{ number_format($order->paid ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between px-4 py-2.5 text-sm">
                                <span class="text-gray-500">Due</span>
                                <span class="text-[#EA580C] font-semibold">{{ number_format(($order->total - ($order->paid ?? 0)), 2) }}</span>
                            </div>
                            <div class="flex justify-between px-4 py-2.5 text-sm">
                                <span class="text-gray-500">Delivery Charge</span>
                                <span class="text-gray-800 font-semibold">{{ number_format($order->delivery_charge, 2) }}</span>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

            @else
            <!-- Not Found -->
            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-10 text-center">
                <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 font-semibold">কোনো অর্ডার খুঁজে পাওয়া যায়নি</p>
                <p class="text-gray-400 text-sm mt-1">আপনার Phone Number / Invoice ID টি আবার চেক করুন।</p>
            </div>
            @endif

        @endif

    </div>
</section>

@endsection