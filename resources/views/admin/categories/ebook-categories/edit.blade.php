@extends('admin.layouts.app')

@section('title', 'Edit Ebook Category')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Ebook Category</h5>
                <a href="{{ route('admin.ebook-categories.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.ebook-categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="image" class="form-label">Category Image</label>
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror">
                        @if($category->image)
                        <img src="{{ Storage::url($category->image) }}" class="mt-2 rounded" style="width:80px;height:80px;object-fit:cover;">
                        @endif
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn text-white bg-gradient-purple px-4 py-2">
                        <i class="fa fa-save me-1"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection