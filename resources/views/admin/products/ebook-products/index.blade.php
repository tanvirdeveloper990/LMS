@extends('admin.layouts.app')

@section('title', 'Ebook Products')

@section('content')
<div class="container-fluid py-2 py-md-4">
    {{-- Card Wrapper --}}
    <div class="card shadow-lg rounded-3">
        {{-- Card Header --}}
        <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2 bg-gradient-purple text-white">
            <h5 class="mb-0">Ebook Products List</h5>
            <div>
            <a href="{{ route('admin.ebook-products.create') }}" class="btn btn-light btn-sm text-end">
                <i class="fa fa-plus me-1"></i> Add Ebook Product
            </a></div>
        </div>

        {{-- Filter Section --}}
        <div class="card-body border-bottom bg-light p-2 p-md-3">
            <form action="{{ route('admin.ebook-products.index') }}" method="GET">
                <div class="row g-2 g-md-3">
                    {{-- Product Name --}}
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="name" class="form-label small fw-semibold mb-1">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm" 
                               placeholder="Search by name..." value="{{ request('name') }}">
                    </div>

                    {{-- Category --}}
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="category_id" class="form-label small fw-semibold mb-1">Category</label>
                        <select name="category_id" id="category_id" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Start Date --}}
                    <div class="col-6 col-md-6 col-lg-2">
                        <label for="start_date" class="form-label small fw-semibold mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" 
                               value="{{ request('start_date') }}">
                    </div>

                    {{-- End Date --}}
                    <div class="col-6 col-md-6 col-lg-2">
                        <label for="end_date" class="form-label small fw-semibold mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" 
                               value="{{ request('end_date') }}">
                    </div>

                    {{-- Buttons --}}
                    <div class="col-12 col-lg-2">
                        <label class="form-label small fw-semibold mb-1 d-none d-lg-block">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                <i class="fa fa-search me-1"></i> <span class="d-none d-sm-inline">Filter</span>
                            </button>
                            <a href="{{ route('admin.ebook-products.index') }}" class="btn btn-secondary btn-sm flex-fill">
                                <i class="fa fa-redo me-1"></i> <span class="d-none d-sm-inline">Reset</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Card Body --}}
        <div class="card-body p-0">
            {{-- Desktop Table View --}}
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small">
                        <tr>
                            <th class="px-3 py-2 border">#</th>
                            <th class="px-3 py-2 border">Name</th>
                            <th class="px-3 py-2 border">Category</th>
                            <th class="px-3 py-2 border">Brand</th>
                            <th class="px-3 py-2 border">Price</th>
                            <th class="px-3 py-2 border">Status</th>
                            <th class="px-3 py-2 border text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="px-3 py-2">{{ $loop->iteration + ($products->currentPage()-1) * $products->perPage() }}</td>
                            <td class="px-3 py-2">{{ $product->name }}</td>
                            <td class="px-3 py-2">{{ $product->category->name ?? 'N/A' }}</td>
                            <td class="px-3 py-2">{{ $product->brand->name ?? 'N/A' }}</td>
                            <td class="px-3 py-2">{{currency()}}{{ number_format($product->regular_price,2) }}</td>
                            <td class="px-3 py-2">
                                <span class="badge {{ $product->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->status == 1 ? 'Active' : 'Deactive' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.ebook-products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.ebook-products.destroy', $product->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" data-id="{{ $product->id }}" class="btn btn-danger btn-sm delete-btn">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fa fa-inbox fa-2x mb-2 d-block"></i>
                                No ebook products found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile/Tablet Card View --}}
            <div class="d-lg-none">
                @forelse($products as $product)
                <div class="border-bottom p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">{{ $product->name }}</h6>
                            <div class="text-muted small">
                                <span class="badge bg-secondary me-1">{{ $product->category->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <span class="badge {{ $product->status == 1 ? 'bg-success' : 'bg-danger' }} ms-2">
                            {{ $product->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="row g-2 small mb-2">
                        <div class="col-6">
                            <div class="text-muted">Brand</div>
                            <div class="fw-semibold">{{ $product->brand->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Price</div>
                            <div class="fw-semibold text-primary">{{currency()}}{{ number_format($product->regular_price,2) }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Created</div>
                            <div class="fw-semibold">{{ $product->created_at->format('d M, Y') }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Serial</div>
                            <div class="fw-semibold">#{{ $loop->iteration + ($products->currentPage()-1) * $products->perPage() }}</div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                        <a href="{{ route('admin.ebook-products.edit', $product->id) }}" class="btn btn-primary btn-sm flex-fill">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>

                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.ebook-products.destroy', $product->id) }}" method="POST" class="flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="button" data-id="{{ $product->id }}" class="btn btn-danger btn-sm w-100 delete-btn">
                                <i class="fa fa-trash me-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <i class="fa fa-inbox fa-3x mb-3 d-block"></i>
                    <p class="mb-0">No ebook products found.</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <div class="text-muted small">
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                </div>
                <nav aria-label="Page navigation">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if(confirm('Are you sure you want to delete this ebook product?')) {
                document.getElementById('delete-form-' + id)?.submit();
            }
        });
    });
</script>
@endsection