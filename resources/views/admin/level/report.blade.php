@php
use Illuminate\Support\Str;
@endphp

@extends('admin.layouts.app')

@section('title', 'Level Reports')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Level Commission Report</h4>

        {{-- Date Filter Form --}}
        <form action="{{ route('admin.level.report') }}" method="GET" class="d-flex gap-2">
            <input type="date" name="start_date" 
                   class="form-control" 
                   value="{{ request('start_date') }}" required>

            <input type="date" name="end_date" 
                   class="form-control" 
                   value="{{ request('end_date') }}" required>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-search"></i> Filter
            </button>

            <a href="{{ route('admin.level.report') }}" class="btn btn-secondary">
                Reset
            </a>
        </form>
    </div>

    <div class="card-body">

        {{-- Summary --}}
        <div class="mb-3">
            <strong>Total Commission: </strong> {{ currency() }}{{ $totalAmount }} <br>
            <strong>Total Sales: </strong> {{ currency() }}{{ $totalSales }}
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Affiliate / User</th>
                    <th>Level</th>
                    <th>Commission</th>
                    <th>Total Sales</th>
                    <th>Percentage</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    {{-- Dynamic Name / Prefix Check --}}
                    <td>
                        @if(Str::startsWith($item->affiliate_id, 'AUFF'))
                            {{ $item->user->name ?? 'N/A' }}
                        @elseif(Str::startsWith($item->affiliate_id, 'AFF'))
                            {{ $item->affiliate->fname . $item->affiliate->lname ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                        <br>
                        <small class="text-muted">{{ $item->affiliate_id }}</small>
                    </td>

                    <td>{{ $item->level->level }}</td>
                    <td>{{ currency() }}{{ $item->amount }}</td>
                    <td>{{ currency() }}{{ $item->total_sales }}</td>
                    <td>{{ $item->percentage }}%</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        No data found for selected date range
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
