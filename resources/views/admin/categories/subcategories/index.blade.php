@extends('admin.layouts.app')

@section('title', 'SubCategories List')

@section('content')
<div class="container-fluid py-4">
    {{-- Card Wrapper --}}
    <div class="card shadow-lg rounded-3">
        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-purple text-white">
            <h5 class="mb-0">SubCategories List</h5>
            <a href="{{ route('admin.subcategories.create') }}" class="btn btn-light btn-sm">
                <i class="fa fa-plus me-1"></i> Add SubCategory
            </a>
        </div>

        {{-- Card Body --}}
        <div class="card-body p-0">
            {{-- Responsive Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small">
                        <tr>
                            <th scope="col" style="width:40px;"></th>
                            <th scope="col">Sl</th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-subcategories">
                        @forelse($subCategories as $subCategory)
                        <tr data-id="{{ $subCategory->id }}">
                            <td class="text-center drag-handle" style="cursor:grab;">
                                <i class="fa fa-grip-vertical text-muted"></i>
                            </td>
                            <td class="serial-no">{{ $loop->iteration }}</td>
                            <td>{{ $subCategory->name }}</td>
                            <td>{{ $subCategory->category?->name ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $subCategory->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $subCategory->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.subcategories.edit', $subCategory->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form id="delete-form-{{ $subCategory->id }}" action="{{ route('admin.subcategories.destroy', $subCategory->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" data-id="{{ $subCategory->id }}" class="btn btn-danger btn-sm delete-btn">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No subcategories found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($subCategories->hasPages())
            <div class="p-3">
                <div class="d-flex justify-content-end">
                    {{ $subCategories->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if(confirm('Are you sure you want to delete this subcategory?')) {
                document.getElementById('delete-form-' + id)?.submit();
            }
        });
    });

    const sortableBody = document.getElementById('sortable-subcategories');
    if (sortableBody) {
        Sortable.create(sortableBody, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function () {
                const order = Array.from(sortableBody.querySelectorAll('tr[data-id]')).map(tr => tr.dataset.id);

                sortableBody.querySelectorAll('tr[data-id] .serial-no').forEach((cell, index) => {
                    cell.textContent = index + 1;
                });

                fetch('{{ route("admin.subcategories.updateOrder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                }).catch(() => {
                    alert('Failed to update order. Please refresh and try again.');
                });
            }
        });
    }
</script>
@endsection