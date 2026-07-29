@extends('admin.layouts.app')

@section('title', 'Add Clients')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">

        {{-- Header --}}
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Clients</h5>
                <a href="{{ route('admin.clients.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">


                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Enter Name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" name="designation" id="designation" value="{{ old('designation') }}" class="form-control" placeholder="Enter Order Volume">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="review_text" class="form-label">Review Text</label>
                        <textarea name="review_text" id="review_text" class="form-control" cols="4" rows="4"></textarea>
                    </div>


                    <div class="col-md-12 mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Deactive</option>
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