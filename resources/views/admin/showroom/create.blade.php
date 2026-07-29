@extends('admin.layouts.app')

@section('title', 'Add Showroom')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add Showroom</h5>
                <a href="{{ route('admin.showroom.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.showroom.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Showroom Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Dhanmondi Branch" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="showroom@example.com">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="01XXXXXXXXX">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                        class="form-control @error('address') is-invalid @enderror" placeholder="Full address">
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Opening Hours -->
                    <div class="col-md-6 mb-3">
                        <label for="opening_hours" class="form-label">Opening Hours (Days)</label>
                        <input type="text" name="opening_hours" id="opening_hours" value="{{ old('opening_hours') }}"
                            class="form-control @error('opening_hours') is-invalid @enderror" placeholder="e.g. Sat - Thu">
                        @error('opening_hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Opening Time -->
                    <div class="col-md-6 mb-3">
                        <label for="opening_time" class="form-label">Opening Time</label>
                        <input type="text" name="opening_time" id="opening_time" value="{{ old('opening_time') }}"
                            class="form-control @error('opening_time') is-invalid @enderror" placeholder="e.g. 10:00 AM - 8:00 PM">
                        @error('opening_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="summernote form-control @error('description') is-invalid @enderror" placeholder="Showroom description">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Maps -->
                <div class="mb-3">
                    <label for="maps" class="form-label">Google Maps (embed URL/iframe)</label>
                    <textarea name="maps" id="maps" rows="2"
                        class="form-control @error('maps') is-invalid @enderror" placeholder="https://www.google.com/maps/embed?...">{{ old('maps') }}</textarea>
                    @error('maps')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Showroom Video -->
                <div class="mb-3">
                    <label for="showroom_video" class="form-label">Showroom Video (URL/embed)</label>
                    <textarea name="showroom_video" id="showroom_video" rows="2"
                        class="form-control @error('showroom_video') is-invalid @enderror" placeholder="https://www.youtube.com/embed/...">{{ old('showroom_video') }}</textarea>
                    @error('showroom_video')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Showroom Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="form-control @error('image') is-invalid @enderror" onchange="previewShowroomImage(this)">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-2" id="imagePreviewWrap" style="display:none;">
                        <img id="imagePreview" src="" alt="Preview"
                            style="width:120px;height:90px;object-fit:cover;border-radius:8px;border:1px solid #ddd;">
                    </div>
                </div>

                <!-- Gallery Images (add more) -->
                <div class="mb-4">
                    <label class="form-label">Gallery Images</label>

                    <div id="gallery-wrapper">
                        <div class="d-flex gap-2 align-items-center mb-2 gallery-row">
                            <input type="file" name="gallery_images[]" class="form-control" accept="image/*">
                            <button type="button" class="btn btn-sm btn-danger remove-gallery-row"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <button type="button" id="add-gallery" class="btn btn-sm btn-secondary mt-1">
                        <i class="fa fa-plus"></i> Add More
                    </button>
                    @error('gallery_images.*')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

<script>
    function previewShowroomImage(input) {
        const wrap = document.getElementById('imagePreviewWrap');
        const img  = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                wrap.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            wrap.style.display = 'none';
        }
    }

    // Gallery add more / remove
    (function () {
        const wrapper = document.getElementById('gallery-wrapper');
        const addBtn  = document.getElementById('add-gallery');

        addBtn.addEventListener('click', function () {
            const row = document.createElement('div');
            row.className = 'd-flex gap-2 align-items-center mb-2 gallery-row';
            row.innerHTML = `
                <input type="file" name="gallery_images[]" class="form-control" accept="image/*">
                <button type="button" class="btn btn-sm btn-danger remove-gallery-row"><i class="fa fa-times"></i></button>
            `;
            wrapper.appendChild(row);
        });

        wrapper.addEventListener('click', function (e) {
            if (e.target.closest('.remove-gallery-row')) {
                const rows = wrapper.querySelectorAll('.gallery-row');
                if (rows.length > 1) {
                    e.target.closest('.gallery-row').remove();
                }
            }
        });
    })();
</script>
@endsection