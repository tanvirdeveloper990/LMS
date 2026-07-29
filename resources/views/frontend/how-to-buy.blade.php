@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('How To Buy'))
@section('content')

<main class="bg-gray-50">

    <!-- How to Order Section -->
    <section class="container mx-auto px-4 py-12 md:py-16">

        <!-- Page Title -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">{{ \App\Helpers\TranslateHelper::translate('How To Order') }}</h1>
            <p class="text-gray-600 mt-3">{{ \App\Helpers\TranslateHelper::translate('Follow these simple steps to place your order') }}</p>
        </div>

        <!-- Steps Visual Guide -->
        <div class="max-w-6xl mx-auto mb-16">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 md:gap-8">

                @foreach($how as $index => $step)
                <div class="text-center group">
                    <div class="mb-4 relative bg-white rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="absolute -top-3 -right-3 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-bold shadow-lg">
                            {{ $step->serial }}
                        </div>
                        <img src="{{ Storage::url($step->image) }}" alt="{{ \App\Helpers\TranslateHelper::translate($step->text) }}" class="w-full h-20 object-contain mx-auto">
                    </div>
                </div>

                @if($index < count($how) - 1)
                <div class="hidden lg:flex items-center justify-center -mx-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </div>
                @endif
                @endforeach

            </div>
        </div>

        <!-- Detailed Instructions -->
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8 md:p-12 border border-gray-100">
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ \App\Helpers\TranslateHelper::translate('Detailed Instructions') }}</h2>
                <div class="w-20 h-1 bg-gradient-to-r from-primary to-secondary rounded"></div>
            </div>

            <div class="space-y-6">
                @foreach($how as $item)
                <div class="flex gap-4 p-4 rounded-lg hover:bg-gray-50 transition-colors group">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-primary to-red-700 text-white font-bold shadow-md group-hover:scale-110 transition-transform">
                            {{ $item->serial }}
                        </span>
                    </div>
                    <p class="text-gray-700 leading-relaxed pt-2 text-base">
                        {{ \App\Helpers\TranslateHelper::translate($item->text) }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="max-w-2xl mx-auto mt-12">
            <div class="bg-gradient-to-br from-primary via-red-600 to-red-700 rounded-2xl shadow-xl p-8 md:p-10 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>

                <div class="relative z-10 text-center">
                    <h2 class="text-2xl md:text-3xl font-bold mb-3">{{ \App\Helpers\TranslateHelper::translate('Ready to Start Shopping?') }}</h2>
                    <p class="mb-6 text-white/95 text-base">
                        {{ \App\Helpers\TranslateHelper::translate('আপনার পছন্দের পণ্য এখনই অর্ডার করুন এবং দ্রুত ডেলিভারি পান!') }}
                    </p>
                    <a href="{{ route('products') }}">
                        <button class="bg-white text-primary hover:bg-gray-100 font-bold py-3 px-8 rounded-lg transition-all hover:scale-105 shadow-lg">
                            <i class="fas fa-shopping-bag mr-2"></i>
                            {{ \App\Helpers\TranslateHelper::translate('Start Shopping Now') }}
                        </button>
                    </a>
                </div>
            </div>
        </div>

    </section>

</main>

@endsection