@extends('admin.layouts.app')
@section('title', 'Quick Navigation Update')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-lg rounded-3 overflow-hidden">
                    <!-- Header -->
                    <div class="card-header text-white d-flex justify-content-between align-items-center bg-gradient-purple">
                        <h5 class="mb-0"><i class="fa fa-compass me-2"></i>Quick Navigation Update</h5>
                    </div>

                    <!-- Form Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.navigation.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Policy Fields -->
                            <div class="row px-3 g-4">

                                <!-- About Us -->
                                <div class="col-12">
                                    <label for="about_us" class="form-label fw-semibold fs-6">
                                        <i class="fa fa-info-circle me-1 text-primary"></i> About Us
                                    </label>
                                    <textarea id="about_us" name="about_us"
                                        class="form-control summernote @error('about_us') is-invalid @enderror"
                                        rows="5">{{ old('about_us', $data->about_us) }}</textarea>
                                    @error('about_us')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- How to Buy -->
                                {{--<div class="col-12">
                                    <label for="how_to_buy" class="form-label fw-semibold fs-6">
                                        <i class="fa fa-shopping-cart me-1 text-success"></i> How to Buy
                                    </label>
                                    <textarea id="how_to_buy" name="how_to_buy"
                                        class="form-control summernote @error('how_to_buy') is-invalid @enderror"
                                        rows="5">{{ old('how_to_buy', $data->how_to_buy) }}</textarea>
                                    @error('how_to_buy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>--}}

                                <!-- Submit Complaint -->
                                <div class="col-12">
                                    <label for="submit_complaint" class="form-label fw-semibold fs-6">
                                        <i class="fa fa-exclamation-circle me-1 text-danger"></i> Submit Complaint Frequently Asked Questions
                                    </label>
                                    <textarea id="submit_complaint" name="submit_complaint"
                                        class="form-control summernote @error('submit_complaint') is-invalid @enderror"
                                        rows="5">{{ old('submit_complaint', $data->submit_complaint) }}</textarea>
                                    @error('submit_complaint')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Submit -->
                            <div class="d-flex justify-content-end border-top pt-3 mt-4 px-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa fa-save me-1"></i> Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
