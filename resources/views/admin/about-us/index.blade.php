@extends('admin.layouts.app')

@section('title', 'Update About US')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 1200px; overflow: hidden;">

            <div class="card-header bg-gradient-purple">
                <div class="d-flex justify-content-between align-items-center text-white">
                    <h5 class="mb-0 fw-semibold">Update About US</h5>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.about-us.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-4">

                        {{-- Main Section --}}
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="{{ old('title',$data->title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="2" class="form-control">{{ old('description',$data->description) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Button Text</label>
                            <input type="text" name="contact_button_text" value="{{ old('contact_button_text',$data->contact_button_text) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Contact Button Link</label>
                            <input type="text" name="contact_button_link" value="{{ old('contact_button_link',$data->contact_button_link) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Service Button Text</label>
                            <input type="text" name="service_button_text" value="{{ old('service_button_text',$data->service_button_text) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Service Button Link</label>
                            <input type="text" name="service_button_link" value="{{ old('service_button_link',$data->service_button_link) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                            @if($data->image)
                                <img src="{{ Storage::url($data->image) }}" class="img-thumbnail mt-2" style="height:80px;width:80px;object-fit:cover;">
                            @endif
                        </div>

                        {{-- Counts Section --}}
                        <div class="col-md-3">
                            <label class="form-label">Client Count</label>
                            <input type="text" name="client_count" value="{{ old('client_count',$data->client_count) }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Client Title</label>
                            <input type="text" name="client_title" value="{{ old('client_title',$data->client_title) }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monthly Transaction Count</label>
                            <input type="text" name="monthly_transaction_count" value="{{ old('monthly_transaction_count',$data->monthly_transaction_count) }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Monthly Transaction Title</label>
                            <input type="text" name="monthly_transaction_title" value="{{ old('monthly_transaction_title',$data->monthly_transaction_title) }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Member Count</label>
                            <input type="text" name="member_count" value="{{ old('member_count',$data->member_count) }}" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Member Title</label>
                            <input type="text" name="member_title" value="{{ old('member_title',$data->member_title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Experience Count</label>
                            <input type="text" name="experience_count" value="{{ old('experience_count',$data->experience_count) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Experience Title</label>
                            <input type="text" name="experience_title" value="{{ old('experience_title',$data->experience_title) }}" class="form-control">
                        </div>

                        {{-- Mission Section --}}
                        <div class="col-md-6">
                            <label class="form-label">Mission Title</label>
                            <input type="text" name="mission_title" value="{{ old('mission_title',$data->mission_title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mission Secound Title</label>
                            <input type="text" name="mission_title_2" value="{{ old('mission_title_2',$data->mission_title_2) }}" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Mission Description</label>
                            <textarea name="mission_description" rows="2" class="form-control">{{ old('mission_description',$data->mission_description) }}</textarea>
                        </div>

                       {{-- List Fields --}}
                        <div class="col-md-4">
                            <label class="form-label">List One</label>
                            <input type="text" name="list_1" value="{{ old('list_1', $data->list_1) }}" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">List Two</label>
                            <input type="text" name="list_2" value="{{ old('list_2', $data->list_2) }}" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">List Three</label>
                            <input type="text" name="list_3" value="{{ old('list_3', $data->list_3) }}" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">List Four</label>
                            <input type="text" name="list_4" value="{{ old('list_4', $data->list_4) }}" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">List Five</label>
                            <input type="text" name="list_5" value="{{ old('list_5', $data->list_5) }}" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">List Six</label>
                            <input type="text" name="list_6" value="{{ old('list_6', $data->list_6) }}" class="form-control">
                        </div>

                         {{-- Our Work Section --}}
                        <div class="col-md-6">
                            <label class="form-label">Our Work Title</label>
                            <input type="text" name="ourwork_title" value="{{ old('ourwork_title', $data->ourwork_title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List One Title</label>
                            <input type="text" name="list_1_title" value="{{ old('list_1_title', $data->list_1_title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List One Subtitle</label>
                            <input type="text" name="list_1_subtitle" value="{{ old('list_1_subtitle', $data->list_1_subtitle) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Two Title</label>
                            <input type="text" name="list_2_title" value="{{ old('list_2_title', $data->list_2_title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Two Subtitle</label>
                            <input type="text" name="list_2_subtitle" value="{{ old('list_2_subtitle', $data->list_2_subtitle) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Three Title</label>
                            <input type="text" name="list_3_title" value="{{ old('list_3_title', $data->list_3_title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Three Subtitle</label>
                            <input type="text" name="list_3_subtitle" value="{{ old('list_3_subtitle', $data->list_3_subtitle) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Four Title</label>
                            <input type="text" name="list_4_title" value="{{ old('list_4_title', $data->list_4_title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Four Subtitle</label>
                            <input type="text" name="list_4_subtitle" value="{{ old('list_4_subtitle', $data->list_4_subtitle) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Five Title</label>
                            <input type="text" name="list_5_title" value="{{ old('list_5_title', $data->list_5_title) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">List Five Subtitle</label>
                            <input type="text" name="list_5_subtitle" value="{{ old('list_5_subtitle', $data->list_5_subtitle) }}" class="form-control">
                        </div>

                        {{-- How to Work Section --}}
                        <div class="col-md-6">
                            <label class="form-label">How to Work Title</label>
                            <input type="text" name="how_to_work_title" value="{{ old('how_to_work_title', $data->how_to_work_title) }}" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">How to Work Subtitle</label>
                            <textarea name="how_to_work_subtitle" rows="2" class="form-control">{{ old('how_to_work_subtitle', $data->how_to_work_subtitle) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Button Text</label>
                            <input type="text" name="how_to_work_button_text" value="{{ old('how_to_work_button_text', $data->how_to_work_button_text) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="text" name="how_to_work_button_link" value="{{ old('how_to_work_button_link', $data->how_to_work_button_link) }}" class="form-control">
                        </div>
                    </div>

                    <div class="border-top pt-3 text-end">
                        <button type="submit" class="btn text-white bg-gradient-purple">
                            <i class="fa fa-edit me-1"></i> Update
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>
@endsection
