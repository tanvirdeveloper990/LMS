@extends('admin.layouts.app')

@section('title', 'Update Offers')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 1200px; overflow: hidden;">

            <div class="card-header bg-gradient-purple">
                <div class="d-flex justify-content-between align-items-center text-white">
                    <h5 class="mb-0 fw-semibold">Update Offers</h5>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                <form action="{{ route('admin.offers.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="offer_title" class="form-label">Offer Title</label>
                            <input type="text" id="offer_title" name="offer_title"
                                value="{{ old('offer_title',$data->offer_title) }}"
                                class="form-control @error('offer_title') is-invalid @enderror"
                                placeholder="Enter offer title">
                            @error('offer_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        <div class="col-md-6">
                            <label for="offer_image" class="form-label">Offer Image</label>
                            <input type="file" id="offer_image" name="offer_image"
                                class="form-control @error('offer_image') is-invalid @enderror">
                            @error('offer_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="mt-2">
                                @if($data->offer_image)
                                <img id="preview-offer_image" src="{{ Storage::url($data->offer_image) }}" class="img-thumbnail" style="width:96px; height:96px; object-fit:cover;">
                                @else
                                <img id="preview-offer_image" class="d-none img-thumbnail" style="width:96px; height:96px; object-fit:cover;">
                                @endif
                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="offer_description_1" class="form-label">Description One</label>
                            <textarea id="offer_description_1" name="offer_description_1" rows="2"
                                class="form-control @error('offer_description_1') is-invalid @enderror"
                                placeholder="Enter offer description 1">{{ old('offer_description_1',$data->offer_description_1) }}</textarea>
                            @error('offer_description_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        <div class="col-md-6">
                            <label for="offer_description_2" class="form-label">Description Two</label>
                            <textarea id="offer_description_2" name="offer_description_2" rows="2"
                                class="form-control @error('offer_description_2') is-invalid @enderror"
                                placeholder="Enter offer description 2">{{ old('offer_description_2',$data->offer_description_2) }}</textarea>
                            @error('offer_description_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        <div class="col-md-6">
                            <label for="offer_button_text" class="form-label">Button Text</label>
                            <input type="text" id="offer_button_text" name="offer_button_text"
                                value="{{ old('offer_button_text',$data->offer_button_text) }}"
                                class="form-control @error('offer_button_text') is-invalid @enderror"
                                placeholder="Enter button text">
                            @error('offer_button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        <div class="col-md-6">
                            <label for="offer_button_link" class="form-label">Button Link</label>
                            <input type="text" id="offer_button_link" name="offer_button_link"
                                value="{{ old('offer_button_link',$data->offer_button_link) }}"
                                class="form-control @error('offer_button_link') is-invalid @enderror"
                                placeholder="Enter button link">
                            @error('offer_button_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

@section('script')
<script>
    // Offer Image Preview
    const offerImageInput = document.getElementById('offer_image');
    if (offerImageInput) {
        offerImageInput.addEventListener('change', function(event) {
            const preview = document.getElementById('preview-offer_image');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('d-none');
            }
        });
    }
</script>
@endsection