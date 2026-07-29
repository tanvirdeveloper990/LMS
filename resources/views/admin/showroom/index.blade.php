@extends('admin.layouts.app')

@section('title', 'Showroom List')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-purple text-white">
            <h5 class="mb-0">Showroom List</h5>
            <a href="{{ route('admin.showroom.create') }}" class="btn btn-light btn-sm">
                <i class="fa fa-plus me-1"></i> Add Showroom
            </a>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small">
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($showrooms as $showroom)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($showroom->image)
                                    <img src="{{ Storage::url($showroom->image) }}" alt="{{ $showroom->name }}"
                                        style="width:56px;height:56px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                                @else
                                    <span class="text-muted small">No image</span>
                                @endif
                            </td>
                            <td>{{ $showroom->name }}</td>
                            <td>
                                <span class="badge {{ $showroom->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $showroom->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.showroom.edit', $showroom->id) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form id="delete-form-{{ $showroom->id }}"
                                          action="{{ route('admin.showroom.destroy', $showroom->id) }}"
                                          method="POST"
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <button type="button"
                                            data-id="{{ $showroom->id }}"
                                            class="btn btn-danger btn-sm delete-btn">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No showrooms found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-0">
            <div class="d-flex justify-content-center">
                {{ $showrooms->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if (confirm('Are you sure you want to delete this showroom?')) {
                document.getElementById('delete-form-' + id)?.submit();
            }
        });
    });
</script>
@endsection