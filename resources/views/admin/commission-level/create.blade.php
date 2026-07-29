@extends('admin.layouts.app')

@section('title', 'Add Commission Level')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">

        {{-- Header --}}
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Commission</h5>
                <a href="{{ route('admin.commission-level.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <form action="{{ route('admin.commission-level.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">


                    <div class="col-md-6 mb-3">
                        <label for="level" class="form-label">Level</label>
                        <input type="text" name="level" id="level" value="{{ old('level') }}" class="form-control" placeholder="Enter level">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="start" class="form-label">Order Volume(start)</label>
                        <input type="text" name="start" id="start" value="{{ old('start') }}" class="form-control" placeholder="Enter Order Volume">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end" class="form-label">Order Volume(end)</label>
                        <input type="text" name="end" id="end" value="{{ old('end') }}" class="form-control" placeholder="Enter Order Volume">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="persentage" class="form-label">Persentage</label>
                        <input type="text" name="persentage" id="persentage" value="{{ old('persentage') }}" class="form-control" placeholder="Enter persentage">
                    </div>


                    <div class="col-md-6 mb-4">
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