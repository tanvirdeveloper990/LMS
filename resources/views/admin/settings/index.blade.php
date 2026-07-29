@extends('admin.layouts.app')

@section('title', 'Settings Update')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="mx-auto">
            <div class="card shadow-lg rounded-3 overflow-hidden col-12">

                <!-- Header -->
                <div class="card-header text-white d-flex justify-content-between align-items-center bg-gradient-purple">
                    <h5 class="mb-0"><i class="fa fa-cog me-2"></i> Settings Update</h5>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- ===== Basic Info ===== -->
                        <div class="border rounded-3 p-4 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa fa-info-circle me-2"></i>Basic Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Website Name <span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" value="{{ $data->company_name }}"
                                        class="form-control @error('company_name') is-invalid @enderror" required>
                                    @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Address <span class="text-muted">(optional)</span></label>
                                    <input type="text" name="address" value="{{ $data->address }}"
                                        class="form-control @error('address') is-invalid @enderror">
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number (One)</label>
                                    <input type="text" name="phone_one" value="{{ $data->phone_one }}"
                                        class="form-control @error('phone_one') is-invalid @enderror" required>
                                    @error('phone_one') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number (Two)</label>
                                    <input type="text" name="phone_two" value="{{ $data->phone_two }}"
                                        class="form-control @error('phone_two') is-invalid @enderror">
                                    @error('phone_two') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email (One)</label>
                                    <input type="email" name="email_one" value="{{ $data->email_one }}"
                                        class="form-control @error('email_one') is-invalid @enderror" required>
                                    @error('email_one') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email (Two)</label>
                                    <input type="email" name="email_two" value="{{ $data->email_two }}"
                                        class="form-control @error('email_two') is-invalid @enderror">
                                    @error('email_two') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Copyright</label>
                                    <input type="text" name="copyright" value="{{ $data->copyright }}"
                                        class="form-control" placeholder="© 2025 Your Company">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Topbar Text</label>
                                    <input type="text" name="topbar_text" value="{{ $data->topbar_text }}"
                                        class="form-control" placeholder="write something here....">
                                </div>
                            </div>
                        </div>

                       <!-- ===== Social Media ===== -->
                        <div class="border rounded-3 p-4 mb-4">
                            <h6 class="fw-bold text-purple mb-3">
                                <i class="fa fa-share-alt me-2"></i>Social Media Links
                            </h6>

                            <div class="row g-3">
                                @foreach([
                                    'facebook' => 'fab fa-facebook',
                                    'instagram' => 'fab fa-instagram',
                                    'twitter' => 'fab fa-twitter',
                                    'youtube' => 'fab fa-youtube',
                                ] as $social => $icon)

                                <div class="col-md-4">
                                    <label class="form-label">
                                        <i class="{{ $icon }} me-1"></i> {{ ucfirst($social) }}
                                    </label>

                                    <input type="text"
                                        name="{{ $social }}"
                                        value="{{ $data->$social ?? '' }}"
                                        class="form-control @error($social) is-invalid @enderror"
                                        placeholder="Enter {{ $social }} link">

                                    @error($social)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @endforeach
                            </div>
                        </div>

                        <!-- ===== Logos & Favicon ===== -->
                        <div class="border rounded-3 p-4 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa fa-image me-2"></i>Logos & Favicon</h6>
                            <div class="row g-3">
                                @foreach(['header_logo' => 'Header Logo', 'footer_logo' => 'Footer Logo', 'favicon' => 'Favicon',] as $field => $label)
                                <div class="col-md-4 col-sm-6">
                                    <label class="form-label">{{ $label }}</label>
                                    <input type="file" name="{{ $field }}" id="{{ $field }}"
                                        class="form-control @error($field) is-invalid @enderror">
                                    @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="mt-2">
                                        @if($data->$field)
                                        <img id="preview-{{ $field }}" src="{{ Storage::url($data->$field) }}"
                                            class="img-thumbnail" style="width:96px; height:96px; object-fit:cover;">
                                        @else
                                        <img id="preview-{{ $field }}" class="d-none img-thumbnail"
                                            style="width:96px; height:96px; object-fit:cover;">
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                         <!-- ===== Payment Numbers ===== -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-header bg-white border-bottom py-3">
                                <h6 class="mb-0 fw-bold text-purple">
                                    <i class="fas fa-mobile-alt me-2"></i>Payment Numbers
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                        
                                    {{-- bKash --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                            <span class="d-inline-flex align-items-center justify-content-center text-white fw-bold rounded"
                                                style="background:#E2136E; width:22px; height:22px; font-size:10px;">B</span>
                                            BKash Number
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text fw-bold text-white"
                                                style="background:#E2136E; border-color:#E2136E;">Bkash</span>
                                            <input type="text" name="bkash_number"
                                                value="{{ $data->bkash_number ?? '' }}"
                                                class="form-control @error('bkash_number') is-invalid @enderror"
                                                placeholder="e.g. 01XXXXXXXXX">
                                            @error('bkash_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <small class="text-muted">Personal / Agent / Merchant number</small>
                                    </div>
                        
                                    {{-- Nagad --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                            <span class="d-inline-flex align-items-center justify-content-center text-white fw-bold rounded"
                                                style="background:#F6821F; width:22px; height:22px; font-size:10px;">N</span>
                                            Nagad Number
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text fw-bold text-white"
                                                style="background:#F6821F; border-color:#F6821F;">Nagad</span>
                                            <input type="text" name="nagad_number"
                                                value="{{ $data->nagad_number ?? '' }}"
                                                class="form-control @error('nagad_number') is-invalid @enderror"
                                                placeholder="e.g. 01XXXXXXXXX">
                                            @error('nagad_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <small class="text-muted">Personal / Agent / Merchant number</small>
                                    </div>
                        
                                </div>
                            </div>
                        </div>

                        <!-- ===== Google Maps ===== -->
                        <div class="border rounded-3 p-4 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa fa-map-marker-alt me-2"></i>Google Maps</h6>
                            <textarea name="google_maps" rows="3" class="form-control @error('google_maps') is-invalid @enderror">{!! $data->google_maps !!}</textarea>
                            @error('google_maps') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- ===== SEO Metadata ===== -->
                        <div class="border rounded-3 p-4 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa fa-search me-2"></i>SEO Metadata</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" value="{{ $data->meta_title }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Meta Image</label>
                                    <input type="file" name="meta_image" id="meta_image" class="form-control">
                                    <div class="mt-2">
                                        @if($data->meta_image)
                                        <img id="preview-meta_image" src="{{ Storage::url($data->meta_image) }}"
                                            class="img-thumbnail" style="width:96px; height:96px; object-fit:cover;">
                                        @else
                                        <img id="preview-meta_image" class="d-none img-thumbnail"
                                            style="width:96px; height:96px; object-fit:cover;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Meta Description</label>
                                    <textarea name="meta_description" rows="3" class="form-control">{!! $data->meta_description !!}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Meta Keywords</label>
                                    <textarea name="meta_keyword" rows="3" class="form-control">{!! $data->meta_keyword !!}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- ===== Business Settings ===== -->
                        {{--<div class="border rounded-3 p-4 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa fa-briefcase me-2"></i>Business Settings</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Vendor Commission (%)</label>
                                    <input type="text" name="vendor_commission" value="{{ $data->vendor_commission }}"
                        class="form-control @error('vendor_commission') is-invalid @enderror" placeholder="e.g. 10">
                        @error('vendor_commission') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Seller Status</label>
                    <select name="seller_status" class="form-select @error('seller_status') is-invalid @enderror">
                        <option value="yes" {{ $data->seller_status=='yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ $data->seller_status=='no'  ? 'selected' : '' }}>No</option>
                    </select>
                    @error('seller_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Affiliate Status</label>
                    <select name="affilate_status" class="form-select @error('affilate_status') is-invalid @enderror">
                        <option value="yes" {{ $data->affilate_status=='yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ $data->affilate_status=='no'  ? 'selected' : '' }}>No</option>
                    </select>
                    @error('affilate_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Landing Page Status</label>
                    <select name="landing_status" class="form-select @error('landing_status') is-invalid @enderror">
                        <option value="yes" {{ $data->landing_status=='yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ $data->landing_status=='no'  ? 'selected' : '' }}>No</option>
                    </select>
                    @error('landing_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>--}}


        <!-- ===== Customer Complaint Page ===== -->
        {{--<div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="mb-0 fw-bold text-purple"><i class="fa fa-headset me-2"></i>Customer Complaint Page</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Complaint Title</label>
                                    <input type="text" name="complain_title" value="{{ $data->complain_title }}"
        class="form-control" placeholder="Enter complaint page title">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Working Day</label>
        <input type="text" name="working_day" value="{{ $data->working_day }}"
            class="form-control" placeholder="e.g. Saturday - Thursday">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Working Hours</label>
        <input type="text" name="working_hours" value="{{ $data->working_hours }}"
            class="form-control" placeholder="e.g. 9:00 AM - 6:00 PM">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Complaint Description</label>
        <textarea name="complain_description" rows="3"
            class="form-control" placeholder="Enter complaint page description">{{ $data->complain_description }}</textarea>
    </div>
    </div>
    </div>
    </div>--}}



    <!-- ===== Discover Our Latest Collection ===== -->
    {{--<div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 fw-bold text-black">
                <i class="fas fa-layer-group me-2"></i>Discover Our Latest Collection
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3">

               
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Title</label>
                    <input type="text" name="blogs_title"
                        value="{{ $data->blogs_title ?? '' }}"
                        class="form-control"
                        placeholder="e.g. Discover Our Latest Collection">
                </div>

               
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="blogs_description"
                        class="form-control"
                        rows="3"
                        placeholder="Write a short description...">{{ $data->blogs_description ?? '' }}</textarea>
                </div>

               
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Promo Image <small class="text-muted">(764px × 630px)</small></label>

                    <div class="d-flex align-items-center gap-3">

                       
                        <div style="width:80px; height:80px; border-radius:10px; overflow:hidden; background:#f3f4f6; flex-shrink:0; border:1px solid #e5e7eb;">
                            @if(isset($data->certificate) && $data->certificate)
                            <img id="preview-certificate"
                                src="{{ Storage::url($data->certificate) }}"
                                style="width:100%; height:100%; object-fit:cover;">
                            @else
                            <img id="preview-certificate"
                                class="d-none"
                                style="width:100%; height:100%; object-fit:cover;">
                            <div id="preview-placeholder" class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-image text-secondary" style="font-size:24px; opacity:0.4;"></i>
                            </div>
                            @endif
                        </div>

                       
                        <div class="flex-grow-1">
                            <input type="file" id="certificate" name="certificate"
                                class="form-control @error('certificate') is-invalid @enderror"
                                accept="image/*"
                                onchange="previewPromoImage(event)">
                            <p class="mb-0 mt-1 text-muted" style="font-size:11px;">
                                Recommended: 800×600px, JPG/PNG/WEBP
                            </p>
                            @error('certificate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>--}}


      <!-- ===== Footer Section ===== -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="mb-0 fw-bold text-purple"><i class="fa fa-headset me-2"></i>Footer Section</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">

                {{-- 1. Delivery --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Delivery Title</label>
                    <input type="text" name="list_1" value="{{ $data->list_1 }}"
                        class="form-control" placeholder="e.g. 60 Mins Delivery">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Delivery SubTitle</label>
                    <input type="text" name="list_2" value="{{ $data->list_2 }}"
                        class="form-control" placeholder="e.g. Free shipping over 1500Tk">
                </div>

                {{-- 2. Authorized Products --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Authorized Products Title</label>
                    <input type="text" name="list_3" value="{{ $data->list_3 }}"
                        class="form-control" placeholder="e.g. Authorized Products">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Authorized Products SubTitle</label>
                    <input type="text" name="list_4" value="{{ $data->list_4 }}"
                        class="form-control" placeholder="e.g. within 30 days for an exchange">
                </div>

                {{-- 3. Customer Service Support --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Customer Service Title</label>
                    <input type="text" name="list_5" value="{{ $data->list_5 }}"
                        class="form-control" placeholder="e.g. Customer Service Support">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Customer Service SubTitle</label>
                    <input type="text" name="list_6" value="{{ $data->list_6 }}"
                        class="form-control" placeholder="e.g. 8am to 10pm">
                </div>

                {{-- 4. Flexible Payments --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Flexible Payments Title</label>
                    <input type="text" name="list_7" value="{{ $data->list_7 }}"
                        class="form-control" placeholder="e.g. Flexible Payments">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Flexible Payments SubTitle</label>
                    <input type="text" name="list_8" value="{{ $data->list_8 }}"
                        class="form-control" placeholder="e.g. Pay with multiple credit cards">
                </div>

            </div>
        </div>
    </div>

     <!-- ===== Marquee Scrolling Section ===== -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold text-purple">
            <i class="fas fa-scroll me-2"></i>Marquee Scrolling Section
        </h6>
    </div>
    <div class="card-body">

        {{-- Live Preview --}}
        <div class="mb-4 p-3 rounded-3" style="background: #f8f9fa; border: 1px dashed #dee2e6;">
            <p class="text-muted mb-2" style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                <i class="fas fa-eye me-1"></i> Live Preview
            </p>
            <div id="marquee-preview-wrapper"
                style="overflow: hidden; white-space: nowrap; border-radius: 8px; padding: 14px 0; background: {{ $setting->marquee_bg_color ?? '#ffffff' }}; border: 1px solid #e5e7eb;">
                <span id="marquee-preview" style="
                    display: inline-block;
                    animation: marqueeAdminScroll {{ $setting->marquee_speed ?? '14s' }} linear infinite;
                    font-size: 20px;
                    font-weight: 700;
                    color: {{ $setting->marquee_text_color ?? '#111827' }};
                    padding-left: 100%;
                ">
                    {{ $setting->scrolling_text_1 ?? 'Unlock Your Perfect Look With' }}
                    <span id="sep1" style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>
                    {{ $setting->scrolling_text_2 ?? 'Kashaf Exclusive Collection!' }}
                    <span id="sep2" style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>
                    {{ $setting->scrolling_text_3 ?? 'Get Yours Now' }}
                    <span id="sep3" style="color: {{ $setting->marquee_separator_color ?? '#f97316' }};">✦</span>
                </span>
            </div>
        </div>

        <div class="row g-3">

            {{-- Scrolling Text 1 --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-font me-1 text-warning"></i> Scrolling Text 1
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <span class="fw-bold text-warning" style="font-size:11px;">①</span>
                    </span>
                    <input type="text" name="scrolling_text_1"
                        value="{{ $setting->scrolling_text_1 ?? '' }}"
                        class="form-control border-start-0"
                        placeholder="e.g. Unlock Your Perfect Look With"
                        oninput="refreshMarqueePreview()">
                </div>
            </div>

            {{-- Scrolling Text 2 --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-font me-1 text-warning"></i> Scrolling Text 2
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <span class="fw-bold text-warning" style="font-size:11px;">②</span>
                    </span>
                    <input type="text" name="scrolling_text_2"
                        value="{{ $setting->scrolling_text_2 ?? '' }}"
                        class="form-control border-start-0"
                        placeholder="e.g. Kashaf Exclusive Collection!"
                        oninput="refreshMarqueePreview()">
                </div>
            </div>

            {{-- Scrolling Text 3 --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-font me-1 text-warning"></i> Scrolling Text 3
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <span class="fw-bold text-warning" style="font-size:11px;">③</span>
                    </span>
                    <input type="text" name="scrolling_text_3"
                        value="{{ $setting->scrolling_text_3 ?? '' }}"
                        class="form-control border-start-0"
                        placeholder="e.g. Get Yours Now"
                        oninput="refreshMarqueePreview()">
                </div>
            </div>

            {{-- Scroll Speed --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-tachometer-alt me-1 text-warning"></i> Scroll Speed
                </label>
                <select name="marquee_speed" class="form-select" onchange="updateMarqueeSpeed(this.value)">
                    <option value="10s"  {{ ($setting->marquee_speed ?? '') == '10s'  ? 'selected' : '' }}>Very Fast</option>
                    <option value="20s" {{ ($setting->marquee_speed ?? '') == '20s' ? 'selected' : '' }}>Fast</option>
                    <option value="40s" {{ ($setting->marquee_speed ?? '40s') == '40s' ? 'selected' : '' }}>Normal (Default)</option>
                    <option value="55s" {{ ($setting->marquee_speed ?? '') == '55s' ? 'selected' : '' }}>Slow</option>
                    <option value="70s" {{ ($setting->marquee_speed ?? '') == '70s' ? 'selected' : '' }}>Very Slow</option>
                </select>
            </div>

            {{-- Text Color --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-palette me-1 text-warning"></i> Text Color
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white" style="cursor:pointer;">
                        <input type="color" name="marquee_text_color"
                            id="marquee_text_color_picker"
                            value="{{ $setting->marquee_text_color ?? '#111827' }}"
                            style="width:28px; height:28px; border:none; padding:0; background:none; cursor:pointer;"
                            oninput="updateMarqueeTextColor(this.value)">
                    </span>
                    <input type="text" class="form-control" id="marquee_text_color_hex"
                        value="{{ $setting->marquee_text_color ?? '#111827' }}"
                        placeholder="#111827" readonly>
                </div>
            </div>

            {{-- Separator Color --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-star me-1 text-warning"></i> Separator (✦) Color
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white" style="cursor:pointer;">
                        <input type="color" name="marquee_separator_color"
                            id="marquee_sep_color_picker"
                            value="{{ $setting->marquee_separator_color ?? '#f97316' }}"
                            style="width:28px; height:28px; border:none; padding:0; background:none; cursor:pointer;"
                            oninput="updateMarqueeSepColor(this.value)">
                    </span>
                    <input type="text" class="form-control" id="marquee_sep_color_hex"
                        value="{{ $setting->marquee_separator_color ?? '#f97316' }}"
                        placeholder="#f97316" readonly>
                </div>
            </div>

            {{-- Background Color --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-fill-drip me-1 text-warning"></i> Background Color
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white" style="cursor:pointer;">
                        <input type="color" name="marquee_bg_color"
                            id="marquee_bg_color_picker"
                            value="{{ $setting->marquee_bg_color ?? '#ffffff' }}"
                            style="width:28px; height:28px; border:none; padding:0; background:none; cursor:pointer;"
                            oninput="updateMarqueeBgColor(this.value)">
                    </span>
                    <input type="text" class="form-control" id="marquee_bg_color_hex"
                        value="{{ $setting->marquee_bg_color ?? '#ffffff' }}"
                        placeholder="#ffffff" readonly>
                </div>
            </div>

            <div class="col-12">
                <p class="text-muted mb-0" style="font-size: 11px;">
                    <i class="fas fa-info-circle me-1"></i>
                    তিনটি টেক্সট loop হয়ে scroll করবে। প্রতিটির মাঝে
                    <span id="sep-demo" style="color: {{ $setting->marquee_separator_color ?? '#f97316' }}; font-weight: bold;">✦</span>
                    separator থাকবে।
                </p>
            </div>

        </div>
    </div>
</div>

<style>
@keyframes marqueeAdminScroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-100%); }
}
</style>

<script>
function refreshMarqueePreview() {
    const t1 = document.querySelector('[name="scrolling_text_1"]')?.value || 'Unlock Your Perfect Look With';
    const t2 = document.querySelector('[name="scrolling_text_2"]')?.value || 'Kashaf Exclusive Collection!';
    const t3 = document.querySelector('[name="scrolling_text_3"]')?.value || 'Get Yours Now';
    const sepColor = document.getElementById('marquee_sep_color_picker')?.value || '#f97316';

    const preview = document.getElementById('marquee-preview');
    if (preview) {
        preview.innerHTML = `
            ${t1}
            <span style="color:${sepColor};">✦</span>
            ${t2}
            <span style="color:${sepColor};">✦</span>
            ${t3}
            <span style="color:${sepColor};">✦</span>
            ${t1}
            <span style="color:${sepColor};">✦</span>
            ${t2}
            <span style="color:${sepColor};">✦</span>
            ${t3}
        `;
    }
}

function updateMarqueeSpeed(val) {
    const preview = document.getElementById('marquee-preview');
    if (preview) preview.style.animationDuration = val;
}

function updateMarqueeTextColor(val) {
    const preview = document.getElementById('marquee-preview');
    if (preview) preview.style.color = val;
    const hex = document.getElementById('marquee_text_color_hex');
    if (hex) hex.value = val;
}

function updateMarqueeSepColor(val) {
    document.querySelectorAll('#sep1, #sep2, #sep3, #sep-demo').forEach(el => {
        if (el) el.style.color = val;
    });
    const hex = document.getElementById('marquee_sep_color_hex');
    if (hex) hex.value = val;
    refreshMarqueePreview();
}

function updateMarqueeBgColor(val) {
    const wrapper = document.getElementById('marquee-preview-wrapper');
    if (wrapper) wrapper.style.backgroundColor = val;
    const hex = document.getElementById('marquee_bg_color_hex');
    if (hex) hex.value = val;
}
</script>


    <script>
        function previewPromoImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview-certificate');
                const placeholder = document.getElementById('preview-placeholder');
                img.src = e.target.result;
                img.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    </script>

    <!-- ===== BSTI Certification ===== -->
    {{--<div class="border rounded-3 p-4 mb-4">
                            <h6 class="fw-bold text-purple mb-3"><i class="fa fa-certificate me-2"></i>BSTI Certification</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Certificate Image</label>
                                    <input type="file" id="certificate" name="certificate"
                                        class="form-control @error('certificate') is-invalid @enderror">
                                    @error('certificate') <div class="invalid-feedback">{{ $message }}</div> @enderror
    <div class="mt-2">
        @if($data->certificate)
        <img id="preview-certificate" src="{{ Storage::url($data->certificate) }}"
            class="img-thumbnail" style="width:96px; height:96px; object-fit:cover;">
        @else
        <img id="preview-certificate" class="d-none img-thumbnail"
            style="width:96px; height:96px; object-fit:cover;">
        @endif
    </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Certificate Title</label>
        <input type="text" name="title" value="{{ $data->title }}"
            class="form-control @error('title') is-invalid @enderror"
            placeholder="Enter certificate title">
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3"
            class="form-control @error('description') is-invalid @enderror"
            placeholder="Enter certificate description">{{ $data->description }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    @foreach(range(1, 6) as $i)
    <div class="col-md-6">
        <label class="form-label">List {{ $i }}</label>
        <input type="text" name="list_{{ $i }}" value="{{ $data->{'list_'.$i} }}"
            class="form-control @error('list_'.$i) is-invalid @enderror"
            placeholder="List item {{ $i }}">
        @error('list_'.$i) <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    @endforeach

    <div class="col-md-6">
        <label class="form-label">Button Text</label>
        <input type="text" name="button_text" value="{{ $data->button_text }}"
            class="form-control @error('button_text') is-invalid @enderror"
            placeholder="e.g. Learn More">
        @error('button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Button Link</label>
        <input type="text" name="button_link" value="{{ $data->button_link }}"
            class="form-control @error('button_link') is-invalid @enderror"
            placeholder="https://...">
        @error('button_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    </div>
    </div>

    <!-- ===== Checkout Settings ===== -->
    <div class="border rounded-3 p-4 mb-4">
        <h6 class="fw-bold text-purple mb-3"><i class="fa fa-shopping-cart me-2"></i>Checkout Settings</h6>
        <div class="row g-3">
            <div class="col-md-9">
                <label class="form-label">Checkout Offer Message</label>
                <input type="text" name="checkout_offer_text" value="{{ $data->checkout_offer_text }}"
                    class="form-control @error('checkout_offer_text') is-invalid @enderror"
                    placeholder="e.g. Free delivery on orders above ৳500!">
                @error('checkout_offer_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3">
                <label class="form-label">Checkout Offer Status</label>
                <select name="checkout_offer_status" class="form-select @error('checkout_offer_status') is-invalid @enderror">
                    <option value="yes" {{ $data->checkout_offer_status=='yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ $data->checkout_offer_status=='no'  ? 'selected' : '' }}>No</option>
                </select>
                @error('checkout_offer_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-12">
                <label class="form-label">Checkout Review Video (YouTube URL)</label>
                <input type="text" name="checkout_review_video" value="{{ $data->checkout_review_video }}"
                    class="form-control" placeholder="https://youtube.com/watch?v=...">
                @if($data->checkout_review_video)
                @php
                preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([\w-]+)/',
                $data->checkout_review_video, $matches);
                $videoId = $matches[1] ?? null;
                @endphp
                @if($videoId)
                <div class="mt-2">
                    <iframe width="300" height="180"
                        src="https://www.youtube.com/embed/{{ $videoId }}"
                        frameborder="0" allowfullscreen style="border-radius:8px;">
                    </iframe>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>--}}

    <!-- Submit -->
    <div class="d-flex justify-content-end border-top pt-3">
        <button type="submit" class="btn text-white bg-gradient-purple px-4">
            <i class="fa fa-save me-1"></i> Update Settings
        </button>
    </div>

    </form>
    </div>
    </div>
    </div>
    </div>
</section>
@endsection

@section('script')
<script>
    ['header_logo', 'footer_logo', 'favicon', 'mobile_logo', 'meta_image', 'certificate'].forEach(id => {
        const input = document.getElementById(id);
        if (!input) return;
        input.addEventListener('change', function(event) {
            const preview = document.getElementById(`preview-${id}`);
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
    });
</script>
@endsection