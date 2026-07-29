@extends('layouts.app')
@section('title','Blogs Details')

@section('content')

<div class="bg-gray-50 min-h-screen">
    
    <!-- Breadcrumb -->
    <section class="bg-white border-b border-gray-200 py-4 mt-6">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <a href="/" class="hover:text-primary transition-colors">
                    {{ \App\Helpers\TranslateHelper::translate('Home') }}
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('all-blogs') }}" class="hover:text-primary transition-colors">
                    {{ \App\Helpers\TranslateHelper::translate('Blogs') }}
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-900 font-medium">{{ \App\Helpers\TranslateHelper::translate('Details') }}</span>
            </div>
        </div>
    </section>
    
    
    <!-- Main Content -->
    <section class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <div class="container mx-auto">
                <!-- Left Side - Main Content -->
                <div class="lg:col-span-2">
                    <!-- Hero Section -->

                    <div class="blogDetialsSlider bg-white rounded-lg  overflow-hidden mb-8 -mx-4 sm:mx-0">
           
            <div class="slide-item mx-2">
                <div class="relative h-64 sm:h-80 lg:h-96">
                    <img src="{{ Storage::url($data->image) }}"
                         alt="{{ \App\Helpers\TranslateHelper::translate($data->title) }}"
                         class="w-full h-full object-cover" />
                    
                   
                   
                    <div class="absolute top-4 left-4">
                        <span class="bg-primary text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <i class="fas fa-star mr-1"></i> 
                            {{ \App\Helpers\TranslateHelper::translate('Featured News') }}
                        </span>
                    </div>
                   
                </div>
            </div>
</div>

                    <!-- Article Content -->
                    <article class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 lg:p-10 mb-12">
                        <!-- Title -->
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 lg:leading-[1.5]">
                            {{ \App\Helpers\TranslateHelper::translate($data->title) }}
                        </h1>

                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-4 mb-8 pb-6 border-b-2 border-primary/20">
                            <div class="flex items-center gap-2 text-gray-600">
                                <i class="far fa-calendar-alt text-primary"></i>
                                <span class="text-sm font-medium">
                                    {{ \Carbon\Carbon::parse($data->post_date)->format('F d, Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="prose prose-slate max-w-none 
                                    prose-headings:text-gray-900 
                                    prose-p:text-gray-700 
                                    prose-a:text-primary 
                                    prose-strong:text-gray-900
                                    prose-img:rounded-lg
                                    prose-img:shadow-md
                                    prose-ul:text-gray-700
                                    prose-ol:text-gray-700
                                    prose-li:text-gray-700">
                            {!! \App\Helpers\TranslateHelper::translate($data->description) !!}
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
</div> <!-- ✅ wrapper close -->

@endsection