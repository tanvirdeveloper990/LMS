@extends('admin.layouts.app')

@section('title', 'Update How To Buy')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Update How To Buy</h5>
                <a href="{{ route('admin.how-to-buy.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <form action="{{ route('admin.how-to-buy.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row px-3 py-3">
                    <div class="col-md-6 mb-3">
                        <label for="serial" class="form-label">Serial</label>
                        <input type="text" name="serial" id="serial" value="{{ old('serial', $data->serial) }}" class="form-control" placeholder="Enter Serial Number">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="text" class="form-label">Text</label>
                        <input type="text" name="text" id="text" value="{{ old('text', $data->text) }}" class="form-control" placeholder="write something here...">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        
                        @if($data->image)
                        <div class="mt-2">
                            <img src="{{ Storage::url($data->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 150px;">
                            <p class="text-muted small mt-1">Current Image</p>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" {{ old('status', $data->status) == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $data->status) == '0' ? 'selected' : '' }}>Deactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-end">
                    <button type="submit" class="btn text-white bg-gradient-purple">
                        <i class="fa fa-save me-1"></i> Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection