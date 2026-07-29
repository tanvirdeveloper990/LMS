@extends('admin.layouts.app')

@section('title', 'Details Update')

@section('content')
<div class="container py-5">

    <div class="card shadow-lg border-0 rounded-4 col-lg-12 mx-auto">

        <!-- Header -->
        <div class="card-header bg-gradient-purple text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Details Update</h5>
        </div>

        <!-- Form -->
        <div class="card-body p-4">
            <form action="{{ route('admin.details.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <!-- Section 1: 60 Mins Delivery -->
                    <div class="col-md-12">
                        <h6 class="fw-bold text-dark mb-3 mt-4 pb-2 border-bottom">60 Mins Delivery</h6>
                    </div>

                    <div class="col-md-4">
                        <label for="icon1" class="form-label">Icon Image</label>
                        <input type="file" id="icon1" name="icon1" 
                            class="form-control @error('icon1') is-invalid @enderror">
                        @error('icon1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        
                        <div class="mt-3">
                            @if($data->icon1)
                                <img id="preview-icon1" src="{{ Storage::url($data->icon1) }}"
                                    class="rounded border shadow-sm" style="max-width:80px; height:auto;" alt="Icon 1">
                            @else
                                <img id="preview-icon1" class="d-none rounded border shadow-sm" style="max-width:80px; height:auto;" alt="Preview">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="title1" class="form-label">Title</label>
                        <input type="text" id="title1" name="title1" value="{{ old('title1', $data->title1) }}"
                            placeholder="60 Mins Delivery"
                            class="form-control @error('title1') is-invalid @enderror">
                        @error('title1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label for="subtitle1" class="form-label">Subtitle</label>
                        <input type="text" id="subtitle1" name="subtitle1" value="{{ old('subtitle1', $data->subtitle1) }}"
                            placeholder="Fast delivery within 60 minutes"
                            class="form-control @error('subtitle1') is-invalid @enderror">
                        @error('subtitle1')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Section 2: Authorized Products -->
                    <div class="col-md-12">
                        <h6 class="fw-bold text-dark mb-3 mt-4 pb-2 border-bottom">Authorized Products</h6>
                    </div>

                    <div class="col-md-4">
                        <label for="icon2" class="form-label">Icon Image</label>
                        <input type="file" id="icon2" name="icon2" 
                            class="form-control @error('icon2') is-invalid @enderror">
                        @error('icon2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        
                        <div class="mt-3">
                            @if($data->icon2)
                                <img id="preview-icon2" src="{{ Storage::url($data->icon2) }}"
                                    class="rounded border shadow-sm" style="max-width:80px; height:auto;" alt="Icon 2">
                            @else
                                <img id="preview-icon2" class="d-none rounded border shadow-sm" style="max-width:80px; height:auto;" alt="Preview">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="title2" class="form-label">Title</label>
                        <input type="text" id="title2" name="title2" value="{{ old('title2', $data->title2) }}"
                            placeholder="Authorized Products"
                            class="form-control @error('title2') is-invalid @enderror">
                        @error('title2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label for="subtitle2" class="form-label">Subtitle</label>
                        <input type="text" id="subtitle2" name="subtitle2" value="{{ old('subtitle2', $data->subtitle2) }}"
                            placeholder="100% authentic products"
                            class="form-control @error('subtitle2') is-invalid @enderror">
                        @error('subtitle2')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Section 3: Customer Service Support -->
                    <div class="col-md-12">
                        <h6 class="fw-bold text-dark mb-3 mt-4 pb-2 border-bottom">Customer Service Support</h6>
                    </div>

                    <div class="col-md-4">
                        <label for="icon3" class="form-label">Icon Image</label>
                        <input type="file" id="icon3" name="icon3" 
                            class="form-control @error('icon3') is-invalid @enderror">
                        @error('icon3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        
                        <div class="mt-3">
                            @if($data->icon3)
                                <img id="preview-icon3" src="{{ Storage::url($data->icon3) }}"
                                    class="rounded border shadow-sm" style="max-width:80px; height:auto;" alt="Icon 3">
                            @else
                                <img id="preview-icon3" class="d-none rounded border shadow-sm" style="max-width:80px; height:auto;" alt="Preview">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="title3" class="form-label">Title</label>
                        <input type="text" id="title3" name="title3" value="{{ old('title3', $data->title3) }}"
                            placeholder="Customer Service Support"
                            class="form-control @error('title3') is-invalid @enderror">
                        @error('title3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label for="subtitle3" class="form-label">Subtitle</label>
                        <input type="text" id="subtitle3" name="subtitle3" value="{{ old('subtitle3', $data->subtitle3) }}"
                            placeholder="24/7 customer support"
                            class="form-control @error('subtitle3') is-invalid @enderror">
                        @error('subtitle3')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <!-- Section 4: Flexible Payments -->
                    <div class="col-md-12">
                        <h6 class="fw-bold text-dark mb-3 mt-4 pb-2 border-bottom">Flexible Payments</h6>
                    </div>

                    <div class="col-md-4">
                        <label for="icon4" class="form-label">Icon Image</label>
                        <input type="file" id="icon4" name="icon4" 
                            class="form-control @error('icon4') is-invalid @enderror">
                        @error('icon4')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        
                        <div class="mt-3">
                            @if($data->icon4)
                                <img id="preview-icon4" src="{{ Storage::url($data->icon4) }}"
                                    class="rounded border shadow-sm" style="max-width:80px; height:auto;" alt="Icon 4">
                            @else
                                <img id="preview-icon4" class="d-none rounded border shadow-sm" style="max-width:80px; height:auto;" alt="Preview">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="title4" class="form-label">Title</label>
                        <input type="text" id="title4" name="title4" value="{{ old('title4', $data->title4) }}"
                            placeholder="Flexible Payments"
                            class="form-control @error('title4') is-invalid @enderror">
                        @error('title4')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label for="subtitle4" class="form-label">Subtitle</label>
                        <input type="text" id="subtitle4" name="subtitle4" value="{{ old('subtitle4', $data->subtitle4) }}"
                            placeholder="Multiple payment options"
                            class="form-control @error('subtitle4') is-invalid @enderror">
                        @error('subtitle4')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn bg-gradient-purple text-white">
                        <i class="fa fa-edit me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Icon 1 Preview
    const icon1Input = document.getElementById('icon1');
    const icon1Preview = document.getElementById('preview-icon1');

    icon1Input.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                icon1Preview.src = e.target.result;
                icon1Preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Icon 2 Preview
    const icon2Input = document.getElementById('icon2');
    const icon2Preview = document.getElementById('preview-icon2');

    icon2Input.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                icon2Preview.src = e.target.result;
                icon2Preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Icon 3 Preview
    const icon3Input = document.getElementById('icon3');
    const icon3Preview = document.getElementById('preview-icon3');

    icon3Input.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                icon3Preview.src = e.target.result;
                icon3Preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Icon 4 Preview
    const icon4Input = document.getElementById('icon4');
    const icon4Preview = document.getElementById('preview-icon4');

    icon4Input.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                icon4Preview.src = e.target.result;
                icon4Preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection