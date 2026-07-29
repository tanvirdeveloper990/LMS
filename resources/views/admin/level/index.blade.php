@extends('admin.layouts.app')

@section('title', 'Level List')

@section('content')
<div class="container-fluid py-4">
    {{-- Card Wrapper --}}

    <div>
        <h5>Total Sales : <b>{{ currency() }}{{ number_format($data->sum('total_sales'),2) }}</b></h5>
        <h5>Commission Sales : <b>{{ currency() }}{{ number_format($data->sum('amount'),2) }}</b></h5>
    </div>

    <div class="card shadow-lg rounded-3">
        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-purple text-white">
            <h5 class="mb-0">Level List</h5>
        </div>

        {{-- Card Body --}}
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small">
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Affiliate</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Level</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Total Sales</th>
                            <th scope="col">Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->affiliate_id }}</td>
                                <td>
                                    {{ Str::startsWith($item->affiliate_id, 'AUFF') 
                                        ? ($item->user->name ?? 'N/A') 
                                        : ($item->affiliate->fname . $item->affiliate->lname ?? 'N/A') }}
                                </td>   
                                <td>{{ $item->level->level }}</td>
                                <td>{{ currency() }}{{ $item->amount }}</td>
                                <td>{{ currency() }}{{ $item->total_sales }}</td>
                                <td>{{ $item->percentage }} %</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection