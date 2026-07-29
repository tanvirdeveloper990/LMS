@extends('layouts.app')

@section('title', 'All Sellers')

@section('css')
<!-- Extra CSS -->
@push('css')
<style>
    .seller-card {
        transition: 0.3s;
        border-radius: 10px;
    }

    .seller-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }

    .seller-logo {
        width: 110px;
        height: 110px;
        object-fit: cover;
        border: 4px solid #eee;
    }
</style>
@endsection

@section('content')

<div class="container py-5">

    <h2 class="mb-4 text-center font-weight-bold">All Sellers</h2>

    <div class="text-center mb-4">
        <a href="{{ route('seller.register') }}" class="btn btn-primary btn-lg font-weight-bold">
            <i class="fa fa-store"></i> Become a Seller
        </a>
        <p class="mt-2 text-muted small">
            Want to sell on our marketplace? Join now!
        </p>
    </div>

    <div class="row">

        @forelse ($sellers as $seller)
        <div class="col-md-4 mb-4">

            <div class="card shadow-lg border-0 seller-card h-100">

                <!-- Shop Logo -->
                <div class="text-center p-3">
                    <img src="{{ Storage::url($seller->logo) }}" alt="Shop Logo" class="img-fluid rounded-circle seller-logo">
                </div>

                <div class="card-body text-center">

                    <h5 class="card-title font-weight-bold mb-2">
                        {{ $seller->shop_name }}
                    </h5>

                    <p class="mb-1">
                        <i class="fa fa-phone text-success"></i>
                        {{ $seller->phone }}
                    </p>

                    <p class="text-muted mb-3">
                        <i class="fa fa-map-marker-alt text-danger"></i>
                        {{ $seller->address }}
                    </p>

                    <a href="{{ route('seller.show', $seller->shop_slug) }}" class="btn btn-primary btn-sm px-4">
                        View Details
                    </a>

                </div>
            </div>
        </div>
        @empty

        <div class="col-12 text-center py-5">
            <h5 class="text-muted">No sellers found.</h5>
        </div>

        @endforelse

    </div>
</div>

@endsection