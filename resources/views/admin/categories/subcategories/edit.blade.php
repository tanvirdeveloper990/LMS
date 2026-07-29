@extends('admin.layouts.app')

@section('title', 'Edit SubCategory')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        {{-- Card Header --}}
        <div class="card-header d-flex justify-content-between align-items-center bg-gradient-purple text-white">
            <h5 class="mb-0">Edit SubCategory</h5>
            <a href="{{ route('admin.subcategories.index') }}" class="btn btn-light btn-sm">
                <i class="fa fa-angle-left me-1"></i> Back
            </a>
        </div>

        {{-- Card Body --}}
        <div class="card-body">
            <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Parent Category --}}
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Parent Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                     <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">SubCategory Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        @if($subcategory->image)
                            <div class="mt-2">
                                <img src="{{ Storage::url($subcategory->image) }}" alt="SubCategory Image" class="img-thumbnail" style="width:120px; height:120px; object-fit:cover;">
                            </div>
                        @endif
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     <!-- Category serial -->
                    {{--<div class="col-md-6 mb-3">
                        <label for="serial" class="form-label">Serial<span class="text-danger">*</span></label>
                        <input type="text" name="serial" id="serial" value="{{ old('serial', $subcategory->serial) }}"
                            class="form-control @error('serial') is-invalid @enderror" placeholder="Enter serial" required>
                        @error('serial')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>--}}
                    
                     
                   

                    {{-- SubCategory Name --}}
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">SubCategory Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $subcategory->name) }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter subcategory name" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                   

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status', $subcategory->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $subcategory->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                   <!-- Show In Header -->
                    <div class="col-md-4 mb-4">
                        <div class="form-check form-switch">
                            <input 
                                class="form-check-input @error('show_in_header') is-invalid @enderror"
                                type="checkbox"
                                name="show_in_header"
                                id="show_in_header"
                                value="1"
                                {{ old('show_in_header', $subcategory->show_in_header) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="show_in_header">
                                <i class="fas fa-bars me-1"></i> Show in Header Menu
                            </label>
                            <small class="d-block text-muted mt-1">Display this category in the header navigation menu</small>
                            @error('show_in_header')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                   
                    <!-- Show In Home Page -->
                    <div class="col-md-4 mb-4">
                        <div class="form-check form-switch">
                            <input 
                                class="form-check-input @error('show_home_page') is-invalid @enderror" 
                                type="checkbox" 
                                name="show_home_page" 
                                id="show_home_page"
                                value="1"
                                {{ old('show_home_page', $subcategory->show_home_page) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="show_home_page">
                                <i class="fas fa-home me-1"></i> Show on Home Page
                            </label>
                            <small class="d-block text-muted mt-1">Display this category in the home page category section</small>
                            @error('show_home_page')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Popular Category -->
                    <div class="col-md-4 mb-4">
                        <div class="form-check form-switch">
                            <input 
                                class="form-check-input @error('popular_category') is-invalid @enderror" 
                                type="checkbox" 
                                name="popular_category" 
                                id="popular_category"
                                value="1"
                                {{ old('popular_category', $subcategory->popular_category) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="popular_category">
                                <i class="fas fa-star me-1"></i> Popular Category
                            </label>
                            <small class="d-block text-muted mt-1">Mark this category as popular to feature on homepage</small>
                            @error('popular_category')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                   
                </div>

                {{-- Submit Button --}}
                <div class="text-end mt-3">
                    <button type="submit" class="btn text-white bg-gradient-purple px-4 py-2">
                        <i class="fa fa-save me-1"></i> Update SubCategory
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection