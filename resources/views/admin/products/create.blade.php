@extends('admin.layouts.app')
@section('title','Create Product')

@section('content')

<div class="container py-5">
    <div class="card shadow-lg rounded-3">
        <!-- Header -->
        <div class="card-header text-white bg-gradient-purple">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Create Product</h5>
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

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

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
                                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                               

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Purchase Price ({{currency()}}) <span class="text-danger">*</span></label>
                                        <input type="number" name="purchase_price" step="0.01" class="form-control  @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}">
                                    @error('purchase_price')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Regular Price ({{currency()}}) <span class="text-danger">*</span></label>
                                        <input type="number" name="regular_price" step="0.01" class="form-control  @error('regular_price') is-invalid @enderror" value="{{ old('regular_price') }}" required>
                                    @error('regular_price')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Sale Price ({{currency()}}) <span class="text-danger">*</span></label>
                                        <input type="number" name="sale_price" step="0.01" class="form-control  @error('sale_price') is-invalid @enderror" value="{{ old('sale_price') }}" required>
                                    @error('sale_price')
                                      <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Units</label>
                                        <input type="text" name="unit" class="form-control" value="{{ old('unit') }}" placeholder="pcs, kg etc">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Stock</label>
                                        <input type="number" name="stock" class="form-control" value="{{ old('stock') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            Reward Point
                                        </label>
                                        <input type="number" min="0" name="point" class="form-control @error('point') is-invalid @enderror" value="{{ old('point', 0) }}">
                                        @error('point')
                                          <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" rows="3" class="form-control summernote">{{ old('short_description') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="4" class="form-control summernote">{{ old('description') }}</textarea>
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
                                    <div class="d-flex mb-2 align-items-center">
                                        <input type="file" name="images[]" class="form-control me-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-image"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <button type="button" id="add-image" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus me-1"></i> Add More
                                </button>
                            </div>
                        </div>--}}

                       {{-- Variants --}}
                       <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-white"><strong>Variants (Stock & Price)</strong></div>
                            <div class="card-body">
                                <div id="variants-wrapper">
                                        <div class="row g-2 mb-2 align-items-center variant-row">
                                            <div class="col">
                                                <select name="variants[0][color_id]" class="form-select form-select-sm">
                                                    <option value="">Select Color</option>
                                                    @foreach($colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="variants[0][size_id]" class="form-select form-select-sm">
                                                    <option value="">Select Size</option>
                                                    @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="number" name="variants[0][price]" placeholder="Price" class="form-control form-control-sm">
                                            </div>
                                            <div class="col">
                                                <input type="number" name="variants[0][stock]" placeholder="Stock" class="form-control form-control-sm">
                                            </div>
                                            <div class="col">
                                                {{-- ✅ প্রতিটা variant-এর নিজস্ব ছবি --}}
                                                <input type="file" name="variants[0][image]" accept="image/*" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                        
                                <button type="button" id="add-variant" class="btn btn-primary">Add Variant</button>
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
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    </select>
                                </div>
                                {{--<div class="mb-3">
                                    <label class="form-label">Sub-SubCategory</label>
                                    <select name="sub_sub_category_id" id="sub_sub_category_id" class="form-select">
                                        <option value="">Select Sub-SubCategory</option>
                                    </select>
                                </div>--}}
                                <div class="mb-3">
                                    <label class="form-label">Brand</label>
                                    <select name="brand_id" class="form-select">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Product Flags --}}
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-semibold text-secondary">Product Flags</h6>
                            </div>
                            <div class="card-body">
                                
                                <div class="form-check">
                                    <input type="checkbox" name="is_new" value="1" class="form-check-input" {{ old('is_new') ? 'checked' : '' }}>
                                    <label class="form-check-label">New Arrivals</label>
                                </div>
                                {{--<div class="form-check mb-2">
                                    <input type="checkbox" name="is_popular" value="1" class="form-check-input" {{ old('is_popular') ? 'checked' : '' }}>
                                    <label class="form-check-label">Most Popular</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="is_featured" value="1" class="form-check-input" {{ old('is_featured') ? 'checked' : '' }}>
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
                                </div>
                            <div>
                                    <label class="form-label">Featured Image Two <small class="text-muted">(280px × 320px)</small></label>
                                    <input type="file" name="featured_image_2" class="form-control">
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Youtube Video Review</label>
                                <input type="text" name="review_video" id="review_video"
                                    class="form-control"
                                    placeholder="https://example.com"
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
                            
                            // If the field already has a value on page load (edit form), show preview immediately
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
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn text-white bg-gradient-purple px-4">
                                <i class="fa fa-save me-1"></i> Create Product
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
  let variantIndex = 1; // প্রথম row (0) আগে থেকেই আছে

    document.getElementById('add-variant').addEventListener('click', function () {
        const wrapper = document.getElementById('variants-wrapper');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 align-items-center variant-row';
        row.innerHTML = `
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
            <div class="col">
                <input type="number" name="variants[${variantIndex}][price]" placeholder="Price" class="form-control form-control-sm">
            </div>
            <div class="col">
                <input type="number" name="variants[${variantIndex}][stock]" placeholder="Stock" class="form-control form-control-sm">
            </div>
            <div class="col">
                <input type="file" name="variants[${variantIndex}][image]" accept="image/*" class="form-control form-control-sm">
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger btn-sm remove-variant"><i class="fa fa-times"></i></button>
            </div>
        `;
        wrapper.appendChild(row);
        variantIndex++;
    });

    document.getElementById('variants-wrapper').addEventListener('click', function (e) {
        if (e.target.closest('.remove-variant')) {
            e.target.closest('.variant-row').remove();
        }
    });
    
    // Remove variant
    $(document).on('click', '.remove-variant', function(){
        $(this).closest('.row').remove();
    });


    // Add images
    $('#add-image').click(function(){
        let html = `<div class="input-group mb-2">
            <input type="file" name="images[]" class="form-control">
            <button type="button" class="btn btn-danger remove-image">X</button>
        </div>`;
        $('#images-wrapper').append(html);
    });

    $(document).on('click', '.remove-image', function(){
        $(this).closest('.input-group').remove();
    });

    // AJAX for subcategories
    $('#category_id').on('change', function(){
        let id = $(this).val();
        if(id){
            $.get('/admin/ajax/subcategories/' + id, function(data){
                let options = '<option value="">Select SubCategory</option>';
                data.forEach(d => options += `<option value="${d.id}">${d.name}</option>`);
                $('#sub_category_id').html(options);
                $('#sub_sub_category_id').html('<option value="">Select Sub-SubCategory</option>');
                @if(old('sub_category_id'))
                    $('#sub_category_id').val("{{ old('sub_category_id') }}").trigger('change');
                @endif
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
                @if(old('sub_sub_category_id'))
                    $('#sub_sub_category_id').val("{{ old('sub_sub_category_id') }}");
                @endif
            });
        } else {
            $('#sub_sub_category_id').html('<option value="">Select Sub-SubCategory</option>');
        }
    });

    @if(old('category_id'))
        $('#category_id').trigger('change');
    @endif
</script>
@endsection