@extends('admin.layouts.app')

@section('title', 'Add FAQ')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Add New FAQ</h4>
            <p class="text-muted mb-0 small">Create a new frequently asked question.</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-light border d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.faqs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Question (Title)</label>
                            <input type="text" name="title"
                                   class="form-control form-control-lg @error('title') is-invalid @enderror"
                                   placeholder="e.g. কীভাবে কোর্সে ভর্তি হব?"
                                   value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Answer (Description)</label>
                            <textarea name="description" rows="5"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Write a clear and simple answer...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Icon / Image <span class="text-muted fw-normal">(optional)</span></label>
                            <div class="d-flex align-items-center gap-3">
                                <div id="imagePreviewWrap" class="rounded-circle bg-light border d-flex align-items-center justify-content-center overflow-hidden" style="width:64px;height:64px;flex-shrink:0;">
                                    <i class="fas fa-image text-muted" id="previewIcon"></i>
                                    <img id="imagePreview" src="" alt="" class="w-100 h-100 object-fit-cover d-none">
                                </div>
                                <input type="file" name="image" id="imageInput" accept="image/*"
                                       class="form-control @error('image') is-invalid @enderror">
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 d-flex align-items-center justify-content-between border rounded-3 p-3">
                            <div>
                                <label class="form-check-label fw-semibold mb-0" for="statusCheck">Active Status</label>
                                <p class="text-muted small mb-0">Enable to show this FAQ on the website.</p>
                            </div>
                            <div class="form-check form-switch">
                                <input type="checkbox" name="status" value="1" class="form-check-input" id="statusCheck" role="switch" style="width:3em;height:1.5em;" checked>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.faqs.index') }}" class="btn btn-light border px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Save FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .object-fit-cover { object-fit: cover; }
</style>

<script>
    document.getElementById('imageInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const icon = document.getElementById('previewIcon');
        if (file) {
            const reader = new FileReader();
            reader.onload = function (ev) {
                preview.src = ev.target.result;
                preview.classList.remove('d-none');
                icon.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
