@extends('affiliate.layouts.app')
@section('title', 'My Levels Earnings')

@section('content')
<div class="container py-2 min-vh-100">

    <div class="card shadow-lg rounded-3">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center text-success">
            <h5 class="mb-0">My Earnings</h5>
            <a href="{{ route('affiliate.level-withdraw') }}" class="btn btn-success"><i class="fas fa-credit-card me-2"></i> Add Withdrawal</a>
        </div>

        <!-- Card Body -->
        <div class="card-body">

            <!-- Earnings Summary -->
            <div class="d-flex justify-content mb-4">
                <div>
                    <h6 class="fw-semibold">Total Earning</h6>
                    <p class="text-success">{{ currency() }} {{ number_format($data->sum('amount'),2) }}</p>
                </div>
                <div class="ms-4">
                    <h6 class="fw-semibold">Total Withdrawal</h6>
                    <p class="text-primary">{{ currency() }} {{ number_format($withdrawal,2) }}</p>
                </div>
                <div class="ms-4">
                    <h6 class="fw-semibold">Current Balance</h6>
                    <p class="text-danger">{{ currency() }} {{ number_format($data->sum('amount') - $withdrawal,2) }}</p>
                </div>
                
            </div>

            <!-- Orders Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Level</th>
                            <th>Amount ({{ currency() }})</th>
                            <th>Total Sales ({{ currency() }})</th>
                            <th>Percentage (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                          
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->level->level }}</td>
                                <td>{{ currency() }}{{ number_format($item->amount,2) }}</td>
                                <td>{{ currency() }}{{  number_format($item->total_sales,2) }}</td>
                                <td>{{ $item->percentage }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
