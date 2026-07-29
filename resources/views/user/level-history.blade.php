@extends('user.layouts.app')
@section('title', 'My Levels Earnings')

@section('content')
<div class="py-6 px-3 min-h-screen bg-gray-100">

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-3xl overflow-hidden">

        <!-- Header -->
        <div class="flex justify-between items-center bg-green-50 p-4 border-b border-green-200">
            <h5 class="text-lg font-semibold text-green-700">My Earnings</h5>
            <a href="{{ route('level-withdraw') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                <i class="fas fa-credit-card me-2"></i> Add Withdrawal
            </a>
        </div>

        <!-- Card Body -->
        <div class="p-6">

            <!-- Earnings Summary -->
            <div class="flex flex-col md:flex-row md:space-x-6 mb-6">
                <div class="mb-4 md:mb-0">
                    <h6 class="font-semibold text-gray-700">Total Earning</h6>
                    <p class="text-green-600 text-lg font-bold">{{ currency() }} {{ number_format($data->sum('amount'),2) }}</p>
                </div>
                <div class="mb-4 md:mb-0">
                    <h6 class="font-semibold text-gray-700">Total Withdrawal</h6>
                    <p class="text-blue-600 text-lg font-bold">{{ currency() }} {{ number_format($withdrawal,2) }}</p>
                </div>
                <div>
                    <h6 class="font-semibold text-gray-700">Current Balance</h6>
                    <p class="text-red-600 text-lg font-bold">{{ currency() }} {{ number_format($data->sum('amount') - $withdrawal,2) }}</p>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200 divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-700">ID</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Level</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Amount ({{ currency() }})</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Total Sales ({{ currency() }})</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Percentage (%)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $item->level->level }}</td>
                            <td class="px-4 py-3">{{ currency() }}{{ number_format($item->amount,2) }}</td>
                            <td class="px-4 py-3">{{ currency() }}{{ number_format($item->total_sales,2) }}</td>
                            <td class="px-4 py-3">{{ $item->percentage }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
