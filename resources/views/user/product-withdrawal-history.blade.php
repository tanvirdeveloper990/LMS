@extends('user.layouts.app')
@section('title', 'My Withdrawal History')

@section('content')
<div class="py-6 px-3 min-h-screen bg-gray-100">

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-3xl overflow-hidden">

        <!-- Header -->
        <div class="flex justify-between items-center bg-green-50 p-4 border-b border-green-200">
            <h5 class="text-lg font-semibold text-green-700">My Withdrawal History</h5>
            <a href="{{ route('level-withdraw') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                <i class="fas fa-credit-card me-2"></i> Add Withdrawal
            </a>
        </div>

        <!-- Card Body -->
        <div class="p-6">

            <!-- Earnings Summary -->
            <div class="flex flex-col md:flex-row md:space-x-6 mb-6">
                <div>
                    <h6 class="font-semibold text-gray-700">Total Withdrawal</h6>
                    <p class="text-green-600 text-lg font-bold">{{ currency() }} {{ number_format($data->sum('amount'),2) }}</p>
                </div>
            </div>

            <!-- Withdrawals Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200 divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 font-medium text-gray-700">ID</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Payment Method</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Payment Info</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Amount ({{ currency() }})</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Date</th>
                            <th class="px-4 py-3 font-medium text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $item->payment_method }}</td>
                            <td class="px-4 py-3">{{ $item->payment_info }}</td>
                            <td class="px-4 py-3">{{ currency() }}{{ number_format($item->amount,2) }}</td>
                            <td class="px-4 py-3">{{ $item->created_at->format('m-d-Y') }}</td>
                            <td class="px-4 py-3">
                                @if($item->status=='pending')
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">Pending</span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">Completed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
