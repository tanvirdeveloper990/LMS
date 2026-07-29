@extends('affiliate.layouts.app')
@section('title', 'My Sales Products')

@section('content')
<div class="container py-2 min-vh-100">

    <div class="card shadow-lg rounded-3">
        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center text-success">
            <h5 class="mb-0">My Sales Products List</h5>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price ({{ currency() }})</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-medium">{{ $product->name }}</td>
                        <td>
                            <img src="{{ Storage::url($product->featured_image_1) }}" alt="Product Image" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>
                            <del>{{ currency() }}{{ number_format($product->regular_price, 2) }}</del>
                            <span class="ms-2">{{ currency() }}{{ number_format($product->sale_price, 2) }}</span>
                        </td>
                        
                       <td>
                        <button onclick="copyToClipboard('{{ route('referal.product', ['slug' => $product->slug,'referal_code' => optional(auth()->guard('affiliate')->user())->referal_code]) }}')" class="btn btn-success btn-sm">
                            Copy Link
                        </button>
                         <!-- Share Dropdown -->
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Share
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('referal.product', ['slug' => $product->slug,'referal_code' => optional(auth()->guard('affiliate')->user())->referal_code])) }}" target="_blank">
                                    Facebook
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{ urlencode(route('referal.product', ['slug' => $product->slug,'referal_code' => optional(auth()->guard('affiliate')->user())->referal_code])) }}&text={{ urlencode($product->name) }}" target="_blank">
                                    Twitter
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="https://wa.me/?text={{ urlencode(route('referal.product', ['slug' => $product->slug,'referal_code' => optional(auth()->guard('affiliate')->user())->referal_code])) }}" target="_blank">
                                    WhatsApp
                                </a>
                            </li>
                        </ul>
                    </td>



                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-2">No Products Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Product link copied!');
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
    }

</script>
@endsection
