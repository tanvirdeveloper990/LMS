@extends('admin.layouts.app')

@section('title', 'Add Color')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Color</h5>
                <a href="{{ route('admin.colors.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.colors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Color Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Color Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Enter color name" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Color Code -->
                <div class="mb-3">
                    <label for="code" class="form-label">Color Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                        class="form-control @error('code') is-invalid @enderror" placeholder="#ffffff">
                    @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Color Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Color Image <span class="text-muted small">(optional — swatch এর বদলে actual fabric/material image দেখাতে)</span></label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="form-control @error('image') is-invalid @enderror" onchange="previewColorImage(this)">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-2" id="imagePreviewWrap" style="display:none;">
                        <img id="imagePreview" src="" alt="Preview"
                            style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-end">
                    <button type="submit" class="btn text-white bg-gradient-purple">
                        <i class="fa fa-save me-1"></i> Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewColorImage(input) {
        const wrap = document.getElementById('imagePreviewWrap');
        const img  = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                wrap.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.style.display = 'none';
        }
    }
</script>
@endsection