@extends('affiliate.layouts.app')
@section('title', 'My Levels')

@section('style')

<!-- Styles -->
<style>
    .step.upcoming .circle {
        background-color: #cccccc;
    }
</style>

@endsection

@section('content')

<div class="container">

    <!-- Current Level Card -->
    <div class="card shadow-lg mb-4 rounded">
        <div class="card-header text-success d-flex justify-content-between">
            <h5 class="mb-0">Commission Progress</h5>
            <div>
                <a href="{{ route('affiliate.sales-products-withdrawal-hostory') }}" class="btn btn-success btn-sm">Withdrawal History</a>
                <a href="{{ route('affiliate.sales-products-earning') }}" class="btn btn-success btn-sm">View Earning</a>
                <a href="{{ route('affiliate.sales-products') }}" class="btn btn-success btn-sm">Sales Products</a>
            </div>
        </div>

        <div class="card-body">

            <h6><strong>Total Quantity:</strong> {{ $totalQuantity }}</h6>
            <h6><strong>Total Sales:</strong> {{ currency() }}{{ number_format($totalSales, 2) }}</h6>
            <h6><strong>My Earning:</strong> {{ currency() }}{{ number_format($commission_earning, 2) }}</h6>
            <h6><strong>Total Withdrawal:</strong> {{ currency() }}{{ number_format($commission_earning_withdrawal, 2) }}</h6>
            <h6><strong>Current Balance:</strong> {{ currency() }}{{ number_format($commission_earning - $commission_earning_withdrawal, 2) }}</h6>

            @if($currentLevel)
            <hr>
            <h5>Current Level: <span class="text-primary">{{ $currentLevel->level }}</span></h5>
            <p>Need: <strong>{{ $currentLevel->start }} - {{ $currentLevel->end }}</strong> items</p>

            <!-- Progress Bar -->
            @php
            $percent = ($totalQuantity / $currentLevel->end) * 100;
            if ($percent > 100) $percent = 100;
            @endphp

            <div class="progress" style="height: 20px;">
                <div class="progress-bar bg-success" style="width: {{ $progress }}%;">
                    {{ number_format($progress, 2) }}%
                </div>
            </div>


            @if($completed)
            <div class="alert alert-success mt-3">
                🎉 Level <strong>{{ $currentLevel->level }}</strong> Completed!
            </div>
            @endif
            @endif

            <hr>

            @if($nextLevel)
            <h6 class="text-info">Next Level: {{ $nextLevel->level }}</h6>
            <p>You need <strong>{{ $nextLevel->start - $totalQuantity }}</strong> more items to reach next level.</p>
            @else
            <p class="text-success">You have completed all levels!</p>
            @endif
        </div>
    </div>

    <!-- All Levels Table -->
    <div class="card shadow-lg rounded">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Commission Levels</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Level</th>
                        <th>Order Range</th>
                        <th>Commission (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($levels as $item)
                    <tr @if($currentLevel && $currentLevel->id == $item->id) class="table-primary" @endif>
                        <td>{{ $item->level }}</td>
                        <td>{{ $item->start }} - {{ $item->end }}</td>
                        <td>{{ $item->persentage }}%</td>
                    </tr>
                    @endforeach

                    @if($levels->count() == 0)
                    <tr>
                        <td colspan="3" class="text-center text-muted">No level found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection