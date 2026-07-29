@extends('user.layouts.app')

@section('title', 'My Levels')

@section('content')
<section class="py-6 px-3 bg-gray-100 min-h-screen">

    <div class="max-w-6xl mx-auto">

        <!-- TOP SUMMARY CARD -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Earning Summary</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                <div class="p-4 bg-green-50 rounded-lg border">
                    <p class="font-semibold text-gray-600">Total Quantity</p>
                    <h3 class="text-xl font-bold text-green-600">{{ $totalQuantity }}</h3>
                </div>

                <div class="p-4 bg-blue-50 rounded-lg border">
                    <p class="font-semibold text-gray-600">Total Sales</p>
                    <h3 class="text-xl font-bold text-blue-600">
                        {{ currency() }}{{ number_format($totalSales,2) }}
                    </h3>
                </div>

                <div class="p-4 bg-purple-50 rounded-lg border">
                    <p class="font-semibold text-gray-600">My Earning</p>
                    <h3 class="text-xl font-bold text-purple-600">
                        {{ currency() }}{{ number_format($commission_earning,2) }}
                    </h3>
                </div>

                <div class="p-4 bg-red-50 rounded-lg border">
                    <p class="font-semibold text-gray-600">Total Withdrawal</p>
                    <h3 class="text-xl font-bold text-red-600">
                        {{ currency() }}{{ number_format($commission_earning_withdrawal,2) }}
                    </h3>
                </div>

                <div class="p-4 bg-yellow-50 rounded-lg border">
                    <p class="font-semibold text-gray-600">Current Balance</p>
                    <h3 class="text-xl font-bold text-yellow-600">
                        {{ currency() }}{{ number_format($commission_earning - $commission_earning_withdrawal,2) }}
                    </h3>
                </div>

            </div>
        </div>


        <!-- LEVEL PROGRESS CARD -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Your Level Progress</h3>

            <!-- LEVEL PROGRESS CIRCLES -->
            <div class="flex items-center justify-between mb-6 relative">
                @foreach($levels as $i => $level)
                <div class="flex-1 flex flex-col items-center relative">

                    <!-- Step Circle -->
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold
                @if($totalQuantity >= $level->end) bg-green-500 text-white
                @elseif($currentLevel && $currentLevel->id == $level->id) bg-blue-500 text-white
                @else bg-gray-300 text-white
                @endif
                z-10
            ">
                        {{ $i + 1 }}
                    </div>
                    <p class="text-xs mt-1">{{ $level->level }}</p>

                    <!-- Connecting Line (except last) -->
                    @if(!$loop->last)
                    <div class="absolute top-1/2 left-1/2 right-[-50%] h-1 -z-0">
                        <!-- Full gray line -->
                        <div class="w-full h-1 bg-gray-300 absolute top-1/2 transform -translate-y-1/2"></div>

                        <!-- Completed portion -->
                        <div class="h-1 bg-green-500 absolute top-1/0 transform -translate-y-1/2"
                            style="width: {{ $totalQuantity >= $levels[$i]->end ? '100%' : ($currentLevel && $currentLevel->id == $level->id ? '50%' : '0%') }};">
                        </div>
                    </div>
                    @endif

                </div>
                @endforeach
            </div>


            <!-- CURRENT LEVEL & PROGRESS BAR -->
            @if($currentLevel)
            <p class="text-lg font-semibold">
                Current Level: <span class="text-blue-600">{{ $currentLevel->level }}</span>
            </p>

            <p class="text-gray-600 mb-3">
                Need: <strong>{{ $currentLevel->start }} - {{ $currentLevel->end }}</strong> items
            </p>

            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div class="bg-green-500 h-4 rounded-full" style="width: {{ $progress }}%"></div>
            </div>

            <p class="text-sm text-gray-600 mt-1">
                {{ number_format($progress,2) }}% Completed
            </p>

            @if($completed)
            <div class="mt-3 bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded">
                🎉 Level <strong>{{ $currentLevel->level }}</strong> Completed!
            </div>
            @endif

            @endif


            <!-- NEXT LEVEL -->
            <hr class="my-4">

            @if($nextLevel)
            <p class="text-blue-600 font-semibold">Next Level: {{ $nextLevel->level }}</p>
            <p>You need <strong>{{ $nextLevel->start - $totalQuantity }}</strong> more items to reach next level.</p>
            @else
            <p class="text-green-600 font-semibold">You have completed all levels!</p>
            @endif


            <div class="mt-4">
                <a href="{{ route('sales-products') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    Sales Products
                </a>
                <a href="{{ route('sales-earning') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 mx-4">
                    View Earning
                </a>
                <a href="{{ route('sales-withdrawal-history') }}"
                    class="bg-black text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    Withdrawal History
                </a>
            </div>

        </div>



        <!-- LEVEL LIST -->
        <div class="bg-white shadow-md rounded-xl overflow-hidden">

            <div class="flex items-center justify-between px-6 py-4 bg-blue-600 text-white">
                <h3 class="text-lg font-semibold">Levels List</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-5 py-3 text-left">Level</th>
                            <th class="px-5 py-3 text-left">Order Range</th>
                            <th class="px-5 py-3 text-left">Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($levels as $item)
                        <tr
                            class="{{ $currentLevel && $currentLevel->id == $item->id ? 'bg-green-50' : '' }} hover:bg-gray-50">
                            <td class="px-5 py-3">{{ $item->level }}</td>
                            <td class="px-5 py-3">{{ $item->start }} - {{ $item->end }}</td>
                            <td class="px-5 py-3">{{ $item->persentage }} %</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">No Levels Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

</section>
@endsection