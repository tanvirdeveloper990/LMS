@extends('admin.layouts.app')

@section('title', 'Edit Team')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">

        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Team</h5>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.teams.update', $data->id) }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row px-3 py-3">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" 
                               value="{{ $data->name }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control" 
                               value="{{ $data->designation }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ $data->email }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" 
                               value="{{ $data->phone }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" 
                               value="{{ $data->address }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control">

                        @if($data->image)
                            <img src="{{Storage::url($data->image) }}" 
                                 class="mt-2 rounded" width="120">
                        @endif
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label">Short Description</label>
                        <textarea name="short_description" class="form-control">{{ $data->short_description }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="long_description" class="form-control" cols="5">{{ $data->long_description }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook</label>
                        <input type="text" name="facebook_link" class="form-control"
                               value="{{ $data->facebook_link }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Twitter</label>
                        <input type="text" name="twitter_link" class="form-control"
                               value="{{ $data->twitter_link }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">LinkedIn</label>
                        <input type="text" name="linkedin_link" class="form-control"
                               value="{{ $data->linkedin_link }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="text" name="instagram_link" class="form-control"
                               value="{{ $data->instagram_link }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">YouTube</label>
                        <input type="text" name="youtube_link" class="form-control"
                               value="{{ $data->youtube_link }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Experience Years</label>
                        <input type="text" name="experience_years" class="form-control"
                               value="{{ $data->experience_years }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Skills</label>
                        <textarea name="skills" class="form-control">{{ $data->skills }}</textarea>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Deactive</option>
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
