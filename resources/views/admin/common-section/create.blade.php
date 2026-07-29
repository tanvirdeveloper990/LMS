@extends('admin.layouts.app')

@section('title', 'Add Common Section')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        
        {{-- Header --}}
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Common Section</h5>
                <a href="{{ route('admin.common-section.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <form action="{{ route('admin.common-section.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Type --}}
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type</label>
                         <select name="type" id="type" class="form-select">
                            <option value="">Select Type</option>
                            <option value="Approved & Certified">Approved & Certified</option>
                            <option value="Seller Program" >Seller Program</option>
                            <option value="New entrepreneurs" >New entrepreneurs</option>
                        </select>
                    </div>

                   {{-- Title --}}
                    <div class="col-md-6 mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" placeholder="Enter title">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                  
                    {{-- Status --}}
                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 'deactive' ? 'selected' : '' }}>Deactive</option>
                        </select>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn text-white bg-gradient-purple">
                        <i class="fa fa-save me-1"></i> Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection


@section('script')

@endsection
