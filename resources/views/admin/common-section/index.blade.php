@extends('admin.layouts.app')

@section('title', 'Common Section List')

@section('content')
<div class="container-fluid py-4">
    {{-- Card Wrapper --}}
    <div class="card shadow-lg rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-purple text-white">
            <h5 class="mb-0">Certificated/Programe/New Entrepreneur Section List</h5>
            <a href="{{ route('admin.common-section.create') }}" class="btn btn-light btn-sm">
                <i class="fa fa-plus me-1"></i> Add 
            </a>
        </div>

        {{-- Card Body --}}
        <div class="card-body p-0">
            {{-- Responsive Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small">
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Type</th>
                            <th scope="col">Title</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                             
                         <td>
                            @if($item->type == "Approved & Certified")
                                <span class="badge bg-primary">Approved & Certified</span>

                            @elseif($item->type == "Seller Program")
                                <span class="badge bg-success">Seller Program</span>

                            @elseif($item->type == "New entrepreneurs")
                                <span class="badge bg-info">New entrepreneurs</span>

                            @else
                                <span class="badge bg-secondary">Unknown</span>
                            @endif
                        </td>


                            <td>{{$item->title}}</td>
                            <td>
                                @if($item->image)
                                <img src="{{Storage::url($item->image)}}" alt="empty" width="100px">
                                @endif
                            </td>
                        
                            
                           <td>
                                @if($item->status==1)
                                <span class="badge bg-primary">Active</span>
                                @else
                                <span class="badge bg-danger">Deactive</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href="{{ route('admin.common-section.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.common-section.destroy', $item->id) }}" method="POST" class="d-none">
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
                            <td colspan="5" class="text-center text-muted">No campings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
            if(confirm('Are you sure you want to delete this category?')) {
                document.getElementById('delete-form-' + id)?.submit();
            }
        });
    });
</script>
@endsection
