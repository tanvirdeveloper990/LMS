@extends('admin.layouts.app')

@section('title', 'Add Teams')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Teams</h5>
                <a href="{{ route('admin.teams.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row px-3 py-3">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Enter name">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" name="designation" id="designation" value="{{ old('designation') }}" class="form-control" placeholder="Enter designation">
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Enter email">
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control" placeholder="Enter phone number">
                    </div>

                
                    <div class="col-12 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}" class="form-control" placeholder="Enter address">
                    </div>

                    
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                   
                    <div class="col-6 mb-3">
                        <label for="short_description" class="form-label">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control">{{ old('short_description') }}</textarea>
                    </div>

                    
                    <div class="col-12 mb-3">
                        <label for="long_description" class="form-label">Description</label>
                        <textarea name="long_description" id="long_description" class="form-control" cols="5">{{ old('long_description') }}</textarea>
                    </div>

                  
                    <div class="col-md-6 mb-3">
                        <label for="facebook_link" class="form-label">Facebook Link</label>
                        <input type="text" name="facebook_link" id="facebook_link" value="{{ old('facebook_link') }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="twitter_link" class="form-label">Twitter Link</label>
                        <input type="text" name="twitter_link" id="twitter_link" value="{{ old('twitter_link') }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="linkedin_link" class="form-label">LinkedIn Link</label>
                        <input type="text" name="linkedin_link" id="linkedin_link" value="{{ old('linkedin_link') }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="instagram_link" class="form-label">Instagram Link</label>
                        <input type="text" name="instagram_link" id="instagram_link" value="{{ old('instagram_link') }}" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="youtube_link" class="form-label">YouTube Link</label>
                        <input type="text" name="youtube_link" id="youtube_link" value="{{ old('youtube_link') }}" class="form-control">
                    </div>

                  
                    <div class="col-md-6 mb-3">
                        <label for="experience_years" class="form-label">Experience Years</label>
                        <input type="text" name="experience_years" id="experience_years" value="{{ old('experience_years') }}" class="form-control" placeholder="Enter years of experience">
                    </div>

                  
                    <div class="col-12 mb-3">
                        <label for="skills" class="form-label">Skills</label>
                        <textarea name="skills" id="skills" class="form-control">{{ old('skills') }}</textarea>
                    </div>


                    <div class="col-md-6 mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Deactive</option>
                        </select>
                    </div>

                </div>

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
