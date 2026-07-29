@extends('affiliate.layouts.app')
@section('title', 'My Withdrawal History')

@section('content')
<div class="container py-2 min-vh-100">

    <div class="card shadow-lg rounded-3">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center text-success">
            <h5 class="mb-0">My Withdrawal History</h5>
            <a href="{{ route('affiliate.level-withdraw') }}" class="btn btn-success"><i class="fas fa-credit-card me-2"></i> Add Withdrawal</a>
        </div>

        <!-- Card Body -->
        <div class="card-body">

            <!-- Earnings Summary -->
            <div class="d-flex justify-content mb-4">
               
                <div class="">
                    <h6 class="fw-semibold">Total Withdrawal</h6>
                    <p class="text-success">{{ currency() }} {{ number_format($data->sum('amount'),2) }}</p>
                </div>
               
            </div>

            <!-- Orders Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Payment Method</th>
                            <th>Payment Info</th>
                            <th>Amount ({{ currency() }})</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                          
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->payment_method }}</td>
                                <td>{{ $item->payment_info }}</td>
                                <td>{{ currency() }}{{  number_format($item->amount,2) }}</td>
                                <td>
                                    {{ $item->created_at->format('m-d-Y') }}
                                </td>
                                <td>
                                    @if($item->status=='pending')
                                    <span class="badge bg-danger">Pending</span>
                                    @else
                                    <span class="badge bg-success">Completed</span>
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
