@extends('admin.layouts.app')

@section('title', 'Edit Common Section')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">

        {{-- Header --}}
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Common Section</h5>
                <a href="{{ route('admin.common-section.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <form action="{{ route('admin.common-section.update', $data->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Type --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select">
                            <option value="">Select Type</option>
                            <option value="Approved & Certified" {{ $data->type == "Approved & Certified" ? 'selected' : '' }}>Approved & Certified</option>
                            <option value="Seller Program" {{ $data->type == "Seller Program" ? 'selected' : '' }}>Seller Program</option>
                            <option value="New entrepreneurs" {{ $data->type == "New entrepreneurs" ? 'selected' : '' }}>New entrepreneurs</option>
                        </select>
                    </div>

                    {{-- Title --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ $data->title }}">
                    </div>

                    {{-- Description --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control">{{ $data->description }}</textarea>
                    </div>

                    {{-- Image --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">

                        @if($data->image)
                            <img src="{{Storage::url($data->image) }}" 
                                 width="120" class="mt-2 rounded shadow">
                        @endif
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $data->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $data->status == 'deactive' ? 'selected' : '' }}>Deactive</option>
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
