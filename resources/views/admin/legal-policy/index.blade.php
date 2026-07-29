@extends('admin.layouts.app')
@section('title', 'Legal & Policy Update')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-12">
                <div class="card shadow-lg rounded-3 overflow-hidden">
                    <!-- Header -->
                    <div class="card-header text-white d-flex justify-content-between align-items-center bg-gradient-purple">
                        <h5 class="mb-0"><i class="fa fa-file-alt me-2"></i>Legal & Policy Update</h5>
                    </div>

                    <!-- Form Body -->
                    <div class="card-body">
                        <form action="{{ route('admin.legal-policy.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Policy Fields -->
                            <div class="row px-3 g-4">

                                <!-- Delivery Policy -->
                                <div class="col-12">
                                    <label for="delivery_policy" class="form-label fw-semibold fs-6">
                                        <i class="fa fa-truck me-1 text-primary"></i> Delivery Policy
                                    </label>
                                    <textarea id="delivery_policy" name="delivery_policy"
                                        class="form-control summernote @error('delivery_policy') is-invalid @enderror"
                                        rows="5">{{ old('delivery_policy', $data->delivery_policy) }}</textarea>
                                    @error('delivery_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Return Policy -->
                                <div class="col-12">
                                    <label for="return_policy" class="form-label fw-semibold fs-6">
                                        <i class="fa fa-undo me-1 text-warning"></i> Return Policy
                                    </label>
                                    <textarea id="return_policy" name="return_policy"
                                        class="form-control summernote @error('return_policy') is-invalid @enderror"
                                        rows="5">{{ old('return_policy', $data->return_policy) }}</textarea>
                                    @error('return_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Refund Policy -->
                                <div class="col-12">
                                    <label for="refund_policy" class="form-label fw-semibold fs-6">
                                        <i class="fa fa-dollar-sign me-1 text-success"></i> Refund Policy
                                    </label>
                                    <textarea id="refund_policy" name="refund_policy"
                                        class="form-control summernote @error('refund_policy') is-invalid @enderror"
                                        rows="5">{{ old('refund_policy', $data->refund_policy) }}</textarea>
                                    @error('refund_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Warranty Policy -->
                                <div class="col-12">
                                    <label for="warranty_policy" class="form-label fw-semibold fs-6">
                                        <i class="fa fa-shield-alt me-1 text-info"></i> Warranty Policy
                                    </label>
                                    <textarea id="warranty_policy" name="warranty_policy"
                                        class="form-control summernote @error('warranty_policy') is-invalid @enderror"
                                        rows="5">{{ old('warranty_policy', $data->warranty_policy) }}</textarea>
                                    @error('warranty_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Privacy Policy -->
                                <div class="col-12">
                                    <label for="privacy_policy" class="form-label fw-semibold fs-6">
                                        <i class="fa fa-lock me-1 text-danger"></i> Privacy Policy
                                    </label>
                                    <textarea id="privacy_policy" name="privacy_policy"
                                        class="form-control summernote @error('privacy_policy') is-invalid @enderror"
                                        rows="5">{{ old('privacy_policy', $data->privacy_policy) }}</textarea>
                                    @error('privacy_policy')
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
