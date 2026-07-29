@extends('vendor.layouts.app')
@section('title', 'Profile Setting')

@section('content')

<div class="container py-5 min-vh-100 d-flex justify-content-center">
    <div class="card shadow-lg rounded-3 w-100" style="max-width: 900px;">

        <div class="card-header bg-gradient-purple text-white">
            <h5 class="mb-0">Profile Settings</h5>
        </div>

        <form action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data" class="card-body">
            @csrf
            @method('PUT')

            <!-- Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="row">

                <!-- Name -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ auth('vendor')->user()->name }}"
                        class="form-control">
                </div>

                <!-- Email -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ auth('vendor')->user()->email }}"
                        class="form-control">
                </div>

                <!-- Phone -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ auth('vendor')->user()->phone }}"
                        class="form-control">
                </div>
                
                <!-- NID Number -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">NID Number</label>
                    <input type="text" name="nid" value="{{ auth('vendor')->user()->nid }}"
                        class="form-control fw-bold" style="background-color: #f0f4ff; color: #3b4a6b; border: 1.5px solid #c7d2fe; cursor: not-allowed; letter-spacing: 0.35em; font-family: 'Courier New', monospace;" readonly>
                </div>

                <!-- Shop Name -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Shop Name</label>
                    <input type="text" name="shop_name" value="{{ auth('vendor')->user()->shop_name }}"
                        class="form-control" readonly>
                </div>


                <!-- Address -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" value="{{ auth('vendor')->user()->address }}"
                        class="form-control">
                </div>

                <!-- City -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" value="{{ auth('vendor')->user()->city }}"
                        class="form-control">
                </div>

                <!-- Country -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" value="{{ auth('vendor')->user()->country }}"
                        class="form-control">
                </div>

                <!-- Description (full width) -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">Shop Description</label>
                    <textarea name="description" rows="4" class="form-control">{{ auth('vendor')->user()->description }}</textarea>
                </div>

                <!-- Logo -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Shop Logo</label>
                    <input type="file" name="logo" class="form-control" accept="image/*" value="{{ auth('vendor')->user()->logo }}">
                    @if(auth('vendor')->user()->logo)
                        <img src="{{ Storage::url(auth('vendor')->user()->logo) }}"
                             class="img-thumbnail mt-2" width="120" height="120" style="object-fit:cover;">
                    @endif
                </div>

                <!-- Banner -->
                <div class="col-md-6 mb-3">
                    <label class="form-label">Shop Banner</label>
                    <input type="file" name="banner" class="form-control" accept="image/*" value="{{ auth('vendor')->user()->banner }}">
                    @if(auth('vendor')->user()->banner)
                        <img src="{{ Storage::url(auth('vendor')->user()->banner) }}"
                             class="img-thumbnail mt-2" width="200" style="object-fit:cover;">
                    @endif
                </div>



            </div>

            <div class="d-flex justify-content-end">
                <button class="btn bg-gradient-purple text-light">
                    <i class="fa fa-edit"></i> Update
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const preview = document.getElementById('preview-image');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
