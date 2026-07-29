@extends('admin.layouts.app')

@section('title', 'Contact List')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="card shadow-lg rounded-3 overflow-hidden">

            <!-- Header -->
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center text-white bg-gradient-purple">
                <h5 class="mb-2 mb-md-0">Contact List</h5>
                <a href="{{ route('admin.contacts.create') }}" class="btn btn-light text-black btn-sm">
                    <i class="fa fa-plus me-1"></i> Add
                </a> 
            </div>

            <div class="card-body p-0">
                <!-- Table -->
                <div class=" table-responsive">
                    <table class="table  table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase text-muted small">
                            <tr>
                                <th>Sl</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>
                                    @if ($item->status == 1)
                                    <span class="badge text-bg-success">Active</span>
                                    @else
                                    <span class="badge text-bg-danger">Deactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.contacts.edit',$item->id) }}" class="btn btn-sm btn-primary p-2 rounded-circle">
                                            <i class="fa fa-edit text-xs"></i>
                                        </a>
                                       
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.contacts.destroy', $item->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" data-id="{{ $item->id }}" class="btn btn-danger btn-sm delete-btn">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-2">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if(confirm('Are you sure you want to delete this category?')) {
                document.getElementById('delete-form-' + id)?.submit();
            }
        });
    });
</script>
@endsection