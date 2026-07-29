@extends('admin.layouts.app')

@section('title', 'Add Blogs')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="card shadow-lg border-0 rounded-4">

                    {{-- Header --}}
                    <div class="card-header bg-gradient-purple">
                        <div class="d-flex justify-content-between align-items-center text-white">
                            <h5 class="mb-0 fw-semibold">Add Blogs</h5>
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-light btn-sm">
                                <i class="fa fa-angle-left"></i> Back
                            </a>
                        </div>
                    </div>

                   <div class="card-body p-4">
<form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row g-3">

    {{-- Title --}}
    <div class="col-md-6">
        <label for="title" class="form-label fw-medium">
            Title <span class="text-danger">*</span>
        </label>
        <input type="text" name="title" id="title" value="{{ old('title') }}"
            class="form-control @error('title') is-invalid @enderror"
            placeholder="Enter blog title" required>
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Slug --}}
    <div class="col-md-6">
        <label for="slug" class="form-label fw-medium">
            Slug <span class="text-danger">*</span>
        </label>
        <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
            class="form-control @error('slug') is-invalid @enderror"
            placeholder="Auto generated slug" readonly required>
        @error('slug')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Short Description --}}
    <div class="col-md-6">
        <label for="short_decription" class="form-label fw-medium">
            Short Description
        </label>
        <textarea name="short_decription" id="short_decription" rows="3"
            class="form-control @error('short_decription') is-invalid @enderror"
            placeholder="Write short description...">{{ old('short_decription') }}</textarea>
        @error('short_decription')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Post Date --}}
    <div class="col-md-6">
        <label for="post_date" class="form-label fw-medium">Post Date</label>
        <input type="date" name="post_date" id="post_date"
            value="{{ old('post_date') }}"
            class="form-control @error('post_date') is-invalid @enderror">
        @error('post_date')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- Description --}}
    <div class="col-md-12">
        <label for="description" class="form-label fw-medium">Description</label>
        <textarea name="description" id="description" rows="5"
            class="summernote form-control @error('description') is-invalid @enderror"
            placeholder="Write full description...">{{ old('description') }}</textarea>
        @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    
      {{-- Image --}}
    <div class="col-md-6">
        <label for="image" class="form-label fw-medium">Image</label>
        <input type="file" name="image" id="image"
            class="form-control @error('image') is-invalid @enderror">
        @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Status --}}
    <div class="col-md-6">
        <label for="status" class="form-label fw-medium">Status</label>
        <select name="status" id="status"
            class="form-select @error('status') is-invalid @enderror">
            <option value="1">Active</option>
            <option value="0">Deactive</option>
        </select>
        @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

{{-- Submit --}}
<div class="border-top pt-3 text-end mt-4">
    <button type="submit" class="btn text-white bg-gradient-purple px-4">
        <i class="fa fa-save me-1"></i> Save Blog
    </button>
</div>

</form>
</div>

                </div>

            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('title').addEventListener('keyup', function () {
    let title = this.value;

    // বাংলা + English + number + space allow
    let slug = title
        .toLowerCase()
        .replace(/[^a-z0-9\u0980-\u09FF\s-]/g, '')  // অক্ষর/সংখ্যা ছাড়া remove
        .replace(/\s+/g, '-')                       // space → hyphen
        .replace(/-+/g, '-');                       // multiple hyphen → single

    document.getElementById('slug').value = slug;
});
</script>


@endsection
