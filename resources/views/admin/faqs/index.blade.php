@extends('admin.layouts.app')

@section('title', 'FAQs')

@section('content')
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h4 class="mb-1 fw-bold">FAQ Management</h4>
                <p class="text-muted mb-0 small">Manage your frequently asked questions shown on the website.</p>
            </div>
            @can('create faq')
                <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i> Add New FAQ
                </a>
            @endcan
        </div>


        <!-- Stats Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;">
                            <i class="fas fa-question-circle fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $faqs->count() }}</h5>
                            <small class="text-muted">Total FAQs</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $faqs->where('status', 1)->count() }}</h5>
                            <small class="text-muted">Active</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-secondary bg-opacity-10 text-secondary d-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;">
                            <i class="fas fa-eye-slash fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">{{ $faqs->where('status', 0)->count() }}</h5>
                            <small class="text-muted">Inactive</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h6 class="fw-bold mb-0">All FAQs</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-muted small text-uppercase border-bottom">
                                <th style="width:50px;">#</th>
                                <th style="width:80px;">Image</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th style="width:100px;">Status</th>
                                <th style="width:120px;" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                                <tr>
                                    <td class="text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($faq->image)
                                            <img src="{{ asset('storage/' . $faq->image) }}" width="44" height="44"
                                                class="rounded-circle object-fit-cover border">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-muted"
                                                style="width:44px;height:44px;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $faq->title }}</span>
                                    </td>
                                    <td class="text-muted">
                                        {{ \Illuminate\Support\Str::limit($faq->description, 70) }}
                                    </td>
                                    <td>
                                        @if ($faq->status)
                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                                <i class="fas fa-circle fa-xs me-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">
                                                <i class="fas fa-circle fa-xs me-1"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @can('edit faq')
                                                <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                                                    class="btn btn-sm btn-light border" title="Edit">
                                                    <i class="fas fa-pen text-warning"></i>
                                                </a>
                                            @endcan
                                            @can('delete faq')
                                                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light border" title="Delete">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                        <span class="text-muted">No FAQs found. Click "Add New FAQ" to create one.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <style>
        .object-fit-cover {
            object-fit: cover;
        }
    </style>
@endsection
