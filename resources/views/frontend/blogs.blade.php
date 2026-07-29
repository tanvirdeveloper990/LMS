@extends('layouts.app')

@section('content')

  <main>
         <!-- Our Awards Section -->
<section class="my-12 py-6 px-4">
    <div class="container mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-8">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 uppercase">
               {{$setting->blogs_title}}
            </h2>
            <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto">
               {{$setting->blogs_description}}
            </p>
        </div>

        <!-- Awards Grid - 2 Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            <!-- Award Card -->
            @foreach($blogs as $item)
            <div
                class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100 hover:border-primary/20">
                <div class="flex flex-col md:flex-row h-full">

                    <!-- Left Side: Text Content -->
                    <div class="flex-1 p-6 lg:p-8 flex flex-col justify-between">
                        <!-- Location & Date Badge -->
                        <!--<div class="flex items-center gap-2 mb-4">-->
                        <!--    <div class="flex items-center gap-2 text-sm">-->
                        <!--        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
                        <!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
                        <!--                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />-->
                        <!--            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
                        <!--                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />-->
                        <!--        </svg>-->
                        <!--        <span class="font-semibold text-gray-700">{{$item->category?->name}}</span>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <!-- Date Badge -->
                        @if($item->story_date)
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-600"> {{ \Carbon\Carbon::parse($item->story_date)->format('d F Y') }}</span>
                        </div>
                        @endif

                        <!-- Title -->
                   <a href="{{ route('blogs-single',$item->slug) }}">
                        <h3
                            class="text-xl lg:text-2xl font-bold text-gray-900 mb-4 leading-tight line-clamp-3 group-hover:text-secondary transition-colors duration-300">
                            {{$item->title}}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm lg:text-base leading-relaxed mb-6 line-clamp-3 flex-grow">
                            {{ Str::limit(strip_tags($item->description), 180, '...') }}
                        </p>
                    </a>
                    </div>

                    <!-- Right Side: Image Area -->
                    <div
                        class="relative w-full md:w-2/5  rounded-bl-3xl md:rounded-bl-none md:rounded-tr-3xl md:rounded-br-3xl overflow-hidden min-h-[280px] md:min-h-0 flex items-end justify-center ">
                        <!-- Red Accent Background (Behind Image) -->


                        <!-- Main Image (Award/Certificate) -->
                        <div class="relative z-20 w-full h-full  mb-0">
                            <img src="{{Storage::url($item->image)}}" alt=" {{$item->title}}"
                                class="w-full h-full object-cover rounded-r-2xl shadow-2xl transition-transform duration-700 group-hover:scale-105" />
                        </div>

                        <!-- Red Accent Background (Behind Image) -->

                    </div>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
    </main>
@endsection