@extends('admin.layouts.app')
@section('title','Edit Ebook Product')

@section('content')

<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        <!-- Header -->
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Ebook Product</h5>
                <a href="{{ route('admin.ebook-products.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.ebook-products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- LEFT COLUMN -->
                    <div class="col-lg-8">

                        {{-- Basic Info --}}
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold text-secondary">Basic Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}" required>
                                    @error('name')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Purchase Price ({{currency()}}) <span class="text-danger">*</span></label>
                                        <input type="number" name="purchase_price" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ $product->purchase_price }}">
                                     @error('purchase_price')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Regular Price ({{currency()}}) <span class="text-danger">*</span></label>
                                        <input type="number" name="regular_price" step="0.01" class="form-control  @error('regular_price') is-invalid @enderror" value="{{ $product->regular_price }}" required>
                                    @error('regular_price')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Sale Price ({{currency()}}) <span class="text-danger">*</span></label>
                                        <input type="number" name="sale_price" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" value="{{ $product->sale_price }}" required>
                                    @error('sale_price')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Units</label>
                                        <input type="text" name="unit" class="form-control" value="{{ $product->unit }}" placeholder="pcs, copy etc">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Stock</label>
                                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="sku" class="form-control" value="{{ $product->sku }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Reward Point</label>
                                        <input type="number" min="0" name="point" class="form-control @error('point') is-invalid @enderror" value="{{ old('point', $product->point) }}">
                                        @error('point')
                                          <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" rows="3" class="form-control summernote">{{ $product->short_description }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="4" class="form-control summernote">{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="col-lg-4">

                        {{-- Category & Brand --}}
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold text-secondary">Category & Brand</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id==$category->id?'selected':'' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                     @error('category_id')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <select name="brand_id" class="form-select">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id==$brand->id?'selected':'' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Flags --}}
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold text-secondary">Product Flags</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input type="checkbox" name="is_new" value="1" class="form-check-input" {{ $product->is_new?'checked':'' }}>
                                    <label class="form-check-label">New Arrival</label>
                                </div>
                            </div>
                        </div>

                        {{-- Featured Images --}}
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold text-secondary">Featured Images</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                     <label class="form-label">Featured Image One <small class="text-muted">(280px × 320px)</small></label>
                                    <input type="file" name="featured_image_1" class="form-control">
                                    @if($product->featured_image_1)
                                    <img src="{{ Storage::url($product->featured_image_1) }}" class="img-thumbnail mt-2" width="100">
                                    @endif
                                </div>
                           <div>
                                      <label class="form-label">Featured Image Two <small class="text-muted">(280px × 320px)</small></label>
                                    <input type="file" name="featured_image_2" class="form-control">
                                    @if($product->featured_image_2)
                                    <img src="{{ Storage::url($product->featured_image_2) }}" class="img-thumbnail mt-2" width="100">
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Youtube Video Review</label>
                                <input type="text" name="review_video" id="review_video"
                                    class="form-control"
                                    placeholder="https://example.com"
                                    value="{{ old('review_video', $product->review_video ?? '') }}"
                                    oninput="previewYoutubeVideo(this.value)">

                                <div id="youtube-preview-wrap" class="mt-3 d-none">
                                    <div class="ratio ratio-16x9" style="max-width: 480px;">
                                        <iframe id="youtube-preview-frame"
                                            src=""
                                            title="YouTube video preview"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>

                                <div id="youtube-preview-error" class="text-danger small mt-2 d-none">
                                    লিংকটি সঠিক YouTube ভিডিও লিংক মনে হচ্ছে না।
                                </div>
                            </div>

                            <script>
                            function extractYoutubeId(url) {
                                if (!url) return null;
                                const patterns = [
                                    /(?:youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/,
                                    /(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/,
                                    /(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/,
                                    /(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/,
                                ];
                                for (const pattern of patterns) {
                                    const match = url.match(pattern);
                                    if (match && match[1]) return match[1];
                                }
                                return null;
                            }

                            function previewYoutubeVideo(url) {
                                const wrap     = document.getElementById('youtube-preview-wrap');
                                const frame    = document.getElementById('youtube-preview-frame');
                                const errorBox = document.getElementById('youtube-preview-error');
                                const videoId = extractYoutubeId(url.trim());

                                if (videoId) {
                                    frame.src = 'https://www.youtube.com/embed/' + videoId;
                                    wrap.classList.remove('d-none');
                                    errorBox.classList.add('d-none');
                                } else {
                                    wrap.classList.add('d-none');
                                    frame.src = '';
                                    if (url.trim().length > 0) {
                                        errorBox.classList.remove('d-none');
                                    } else {
                                        errorBox.classList.add('d-none');
                                    }
                                }
                            }

                            document.addEventListener('DOMContentLoaded', function () {
                                const input = document.getElementById('review_video');
                                if (input && input.value.trim() !== '') {
                                    previewYoutubeVideo(input.value);
                                }
                            });
                            </script>
                        </div>

                        {{-- Status --}}
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold text-secondary">Status</h6>
                            </div>
                            <div class="card-body">
                                <select name="status" class="form-select">
                                    <option value="1" {{ $product->status==1?'selected':'' }}>Active</option>
                                    <option value="0" {{ $product->status==0?'selected':'' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn text-white bg-gradient-purple px-4">
                                <i class="fa fa-save me-1"></i> Update Ebook Product
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection