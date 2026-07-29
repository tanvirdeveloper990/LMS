@extends('admin.layouts.app')
@section('title','Edit Product')

@section('content')

<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        <!-- Header -->
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Product</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-angle-left me-1"></i> Back
                </a>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">
            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"" value="{{ $product->name }}" required>
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
                                        <input type="text" name="unit" class="form-control" value="{{ $product->unit }}" placeholder="pcs, kg etc">
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
                                        <label class="form-label">
                                            Reward Point
                                        </label>
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

                        {{-- Product Images --}}
                        {{--<div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold text-secondary">Product Images <small class="text-muted">(800px × 900px)</small></h6>
                            </div>
                            <div class="card-body">
                                <div id="images-wrapper">
                                    @foreach($product->images as $img)
                                        <div class="d-flex mb-2 align-items-center existing-image">
                                            <img src="{{ Storage::url($img->image) }}" class="rounded me-2" width="70" height="70" style="object-fit:cover;">
                                            <input type="file" name="images[]" class="form-control me-2">
                                            <button type="button"
                                                    data-id="{{ $img->id }}"
                                                    class="btn btn-danger btn-sm remove-existing-image">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" id="add-image" class="btn btn-sm btn-primary mt-2">
                                    <i class="fa fa-plus me-1"></i> Add More
                                </button>
                            </div>
                        </div>--}}

                        {{-- Variants --}}
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-white"><strong>Variants (Stock & Price)</strong></div>
                            <div class="card-body">
                                <div id="variants-wrapper">
                                    @foreach($product->variants as $index => $variant)
                                    <div class="row g-2 mb-2 align-items-center variant-row">
                                        <div class="col">
                                            <select name="variants[{{ $index }}][color_id]" class="form-select form-select-sm">
                                                <option value="">Select Color</option>
                                                @foreach($colors as $color)
                                                <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                                    {{ $color->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <select name="variants[{{ $index }}][size_id]" class="form-select form-select-sm">
                                                <option value="">Select Size</option>
                                                @foreach($sizes as $size)
                                                <option value="{{ $size->id }}" {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                                    {{ $size->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="number" name="variants[{{ $index }}][price]" value="{{ $variant->price }}" placeholder="Price" class="form-control form-control-sm">
                                        </div>
                                        <div class="col">
                                            <input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant->stock }}" placeholder="Stock" class="form-control form-control-sm">
                                        </div>
                                        <div class="col">
                                            {{-- ✅ বিদ্যমান ছবি থাকলে ছোট প্রিভিউ দেখাও --}}
                                            @if($variant->image)
                                            <img src="{{ Storage::url($variant->image) }}" alt="variant image" style="width:32px;height:32px;object-fit:cover;border-radius:4px;margin-bottom:4px;">
                                            <input type="hidden" name="variants[{{ $index }}][existing_image]" value="{{ $variant->image }}">
                                            @endif
                                            <input type="file" name="variants[{{ $index }}][image]" accept="image/*" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-variant" class="btn btn-primary mt-2">Add Variant</button>
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
                                    <label class="form-label">Child Category</label>
                                    <select name="sub_category_id" id="sub_category_id" class="form-select">
                                        <option value="">Select ChildCategory</option>
                                        @foreach($subcategories as $sub)
                                        <option value="{{ $sub->id }}" {{ $product->sub_category_id==$sub->id?'selected':'' }}>{{ $sub->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--<div class="mb-3">
                                    <label class="form-label">Sub-SubCategory</label>
                                    <select name="sub_sub_category_id" id="sub_sub_category_id" class="form-select">
                                        <option value="">Select Sub-SubCategory</option>
                                        @foreach($subsubcategories as $subsub)
                                        <option value="{{ $subsub->id }}" {{ $product->sub_sub_category_id==$subsub->id?'selected':'' }}>{{ $subsub->name }}</option>
                                        @endforeach
                                    </select>
                                </div>--}}
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
                                {{--<div class="form-check mb-2">
                                    <input type="checkbox" name="is_popular" value="1" class="form-check-input" {{ $product->is_popular?'checked':'' }}>
                                    <label class="form-check-label">Most Popular</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" {{ $product->is_featured?'checked':'' }}>
                                    <label class="form-check-label">Hot Deal</label>
                                </div>--}}
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
                            
                                {{-- Preview box --}}
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
                            
                                // Handles: watch?v=, youtu.be/, embed/, shorts/, with extra query params after
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
                                    // Only show the error once the user has actually typed something
                                    if (url.trim().length > 0) {
                                        errorBox.classList.remove('d-none');
                                    } else {
                                        errorBox.classList.add('d-none');
                                    }
                                }
                            }
                            
                            // Edit page: field already has a value loaded from DB, show preview immediately
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
                                <i class="fa fa-save me-1"></i> Update Product
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let variantIndex = {{ count($product->variants) }};

    // Add Variant
    $('#add-variant').click(function(){
        let html = `<div class="row g-2 mb-2 align-items-center variant-row">
            <div class="col">
                <select name="variants[${variantIndex}][color_id]" class="form-select form-select-sm">
                    <option value="">Select Color</option>
                    @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select name="variants[${variantIndex}][size_id]" class="form-select form-select-sm">
                    <option value="">Select Size</option>
                    @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col"><input type="number" name="variants[${variantIndex}][price]" placeholder="Price" class="form-control form-control-sm"></div>
            <div class="col"><input type="number" name="variants[${variantIndex}][stock]" placeholder="Stock" class="form-control form-control-sm"></div>
            <div class="col">
                <input type="file" name="variants[${variantIndex}][image]" accept="image/*" class="form-control form-control-sm">
            </div>
            <div class="col-auto"><button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-times"></i></button></div>
        </div>`;
        $('#variants-wrapper').append(html);
        variantIndex++;
    });

    // Remove Variant
    $(document).on('click', '.remove-variant', function(){
        $(this).closest('.variant-row').remove();
    });

    // Add Image
    $('#add-image').click(function(){
        let html = `<div class="input-group mb-2 image-row">
            <input type="file" name="images[]" class="form-control">
            <button type="button" class="btn btn-danger remove-image">X</button>
        </div>`;
        $('#images-wrapper').append(html);
    });

    $(document).on('click', '.remove-image', function(){
        $(this).closest('.image-row').remove();
    });

    $(document).on('click', '.remove-existing-image', function() {
    let id     = $(this).data('id');
    let parent = $(this).closest('.existing-image');

    $.ajax({
        url: '/admin/products/remove-image/' + id, // route-er sathe match kore
        type: 'DELETE',
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(res) {
            console.log(res); // check korte
            if (res.status === 'success') {
                parent.remove();
                alert(res.message);
            } else {
                alert('Delete failed');
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            alert('Something went wrong');
        }
    });
});



    // AJAX for Subcategory
    $('#category_id').on('change', function(){
        let id = $(this).val();
        if(id){
            $.get('/admin/ajax/subcategories/' + id, function(data){
                let options = '<option value="">Select SubCategory</option>';
                data.forEach(d => options += `<option value="${d.id}">${d.name}</option>`);
                $('#sub_category_id').html(options);
                $('#sub_sub_category_id').html('<option value="">Select Sub-SubCategory</option>');
            });
        } else {
            $('#sub_category_id').html('<option value="">Select SubCategory</option>');
            $('#sub_sub_category_id').html('<option value="">Select Sub-SubCategory</option>');
        }
    });

    $('#sub_category_id').on('change', function(){
        let id = $(this).val();
        if(id){
            $.get('/admin/ajax/subsubcategories/' + id, function(data){
                let options = '<option value="">Select Sub-SubCategory</option>';
                data.forEach(d => options += `<option value="${d.id}">${d.name}</option>`);
                $('#sub_sub_category_id').html(options);
            });
        } else {
            $('#sub_sub_category_id').html('<option value="">Select Sub-SubCategory</option>');
        }
    });
</script>
@endsection