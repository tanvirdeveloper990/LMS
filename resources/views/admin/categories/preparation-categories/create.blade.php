@extends('admin.layouts.app')

@section('title', 'Add Preparation Categories')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-3">
                <!-- Card Header -->
                <div class="card-header text-white bg-gradient-purple">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add Preparation Categories</h5>
                        <a href="{{ route('admin.preparation-categories.index') }}" class="btn btn-light btn-sm">
                            <i class="fa fa-angle-left me-1"></i> Back
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{ route('admin.preparation-categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Category Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Preparation Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter Preparation name" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="text" class="form-label">Preparation Text </label>
                                <input type="text" name="text" id="text" value="{{ old('text') }}"
                                    class="form-control @error('text') is-invalid @enderror" placeholder="Enter Preparation text" required>
                                @error('text')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category Image -->
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Category Image <small class="text-muted">(260px × 380px)</small></label>
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end mt-3">
                            <button type="submit" class="btn text-white bg-gradient-purple px-4 py-2">
                                <i class="fa fa-save me-1"></i> Save Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection