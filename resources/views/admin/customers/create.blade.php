@extends('admin.layouts.app')
@section('title', 'Add Customer')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap');
:root{ --p1:#5b21b6;--p2:#7c3aed;--p3:#ede9fe;--p4:#4c1d95;--ink:#0f0e17;--muted:#6b6b8a;--border:#e4e1f5;--surf:#f4f2ff;--red:#dc2626; }
*{ font-family:'Sora',sans-serif;box-sizing:border-box; }
.pg{ background:var(--surf);min-height:100vh;padding:28px 16px; }
.wrap{ max-width:720px;margin:0 auto;display:flex;flex-direction:column;gap:20px; }

/* top bar */
.tbar{ display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px; }
.tbar-title{ font-size:21px;font-weight:700;color:var(--ink);display:flex;align-items:center;gap:10px; }
.btn-back{ background:#fff;border:1.5px solid var(--border);color:var(--ink);border-radius:10px;padding:8px 16px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .15s; }
.btn-back:hover{ border-color:var(--p2);color:var(--p2); }

/* card */
.card{ background:#fff;border:1px solid var(--border);border-radius:18px;overflow:hidden;box-shadow:0 2px 20px rgba(91,33,182,.06); }
.card-head{ background:linear-gradient(120deg,#f5f3ff,#ede9fe);padding:16px 24px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px; }
.card-head-title{ font-size:14px;font-weight:700;color:var(--p4); }
.card-head-icon{ width:30px;height:30px;border-radius:8px;background:var(--p2);display:flex;align-items:center;justify-content:center;font-size:13px;color:#fff; }
.card-body{ padding:24px; }

/* form */
.flabel{ display:block;font-size:11.5px;font-weight:700;color:var(--muted);margin-bottom:5px;text-transform:uppercase;letter-spacing:.4px; }
.finput{ width:100%;border:1.5px solid var(--border);border-radius:10px;padding:10px 14px;font-size:13.5px;color:var(--ink);outline:none;transition:border .15s;font-family:'Sora',sans-serif;background:#fff; }
.finput:focus{ border-color:var(--p2);box-shadow:0 0 0 3px rgba(124,58,237,.1); }
.finput::placeholder{ color:#c4b5fd; }
.ferr{ font-size:11.5px;color:var(--red);margin-top:4px;font-weight:600; }

/* image upload */
.img-upload-area{ border:2px dashed var(--border);border-radius:14px;padding:28px;text-align:center;cursor:pointer;transition:all .2s;position:relative;background:#faf8ff; }
.img-upload-area:hover{ border-color:var(--p2);background:var(--p3); }
.img-upload-area input{ position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
.img-preview{ width:100px;height:100px;border-radius:16px;object-fit:cover;border:3px solid var(--p3);margin:0 auto 12px;display:none; }
.img-placeholder{ width:72px;height:72px;border-radius:50%;background:var(--p3);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:24px;color:var(--p2); }
.img-upload-text{ font-size:13px;color:var(--muted);font-weight:600; }
.img-upload-sub{ font-size:11px;color:#c4b5fd;margin-top:4px; }

/* submit */
.btn-submit{ width:100%;background:linear-gradient(135deg,var(--p2),var(--p4));color:#fff;border:none;border-radius:12px;padding:13px;font-size:15px;font-weight:700;cursor:pointer;box-shadow:0 4px 16px rgba(124,58,237,.35);transition:all .15s;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:8px; }
.btn-submit:hover{ transform:translateY(-1px);box-shadow:0 6px 22px rgba(124,58,237,.4); }
</style>

<div class="pg">
<div class="wrap">

    <div class="tbar">
        <div class="tbar-title"><i class="fa fa-user-plus" style="color:var(--p2);"></i> Add Customer</div>
        <a href="{{ route('admin.customers.index') }}" class="btn-back"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    <div class="card">
        <div class="card-head">
            <span class="card-head-icon"><i class="fa fa-user"></i></span>
            <span class="card-head-title">Customer Information</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.customers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Image Upload --}}
            <div class="mb-4">
                <label class="flabel">Profile Photo</label>
                <div class="img-upload-area" id="uploadArea">
                    <input type="file" name="image" id="imageInput" accept="image/*">
                    <img id="imgPreview" class="img-preview" src="" alt="Preview">
                    <div class="img-placeholder" id="imgPlaceholder">
                        <i class="fa fa-camera"></i>
                    </div>
                    <div class="img-upload-text">Click to upload photo</div>
                    <div class="img-upload-sub">JPG, PNG, WEBP — max 2MB</div>
                </div>
                @error('image')<div class="ferr"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="flabel">Full Name <span style="color:var(--red);">*</span></label>
                    <input type="text" name="name" class="finput" placeholder="Customer full name" value="{{ old('name') }}" required>
                    @error('name')<div class="ferr"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="flabel">Phone <span style="color:var(--red);">*</span></label>
                    <input type="text" name="phone" class="finput" placeholder="01XXXXXXXXX" value="{{ old('phone') }}" required>
                    @error('phone')<div class="ferr"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="flabel">Email</label>
                <input type="email" name="email" class="finput" placeholder="email@example.com" value="{{ old('email') }}">
                @error('email')<div class="ferr"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="flabel">Address</label>
                <textarea name="address" class="finput" rows="3" placeholder="Full delivery address...">{{ old('address') }}</textarea>
                @error('address')<div class="ferr"><i class="fa fa-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa fa-check-circle"></i> Save Customer
            </button>

            </form>
        </div>
    </div>

</div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('imgPreview');
        const placeholder = document.getElementById('imgPlaceholder');
        preview.src = e.target.result;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>
@endsection