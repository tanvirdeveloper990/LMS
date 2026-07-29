@extends('layouts.app')
@section('title','Affiliate Register Form')

@section('content')
<section class="affiliate-registration py-5" style="background: #f1f1f1;">
    <div class="container">
        <div class="row justify-content-center text-left">
            <div class="col-lg-7 col-md-10">
                <div class="affiliate-form px-5 py-5 shadow-sm rounded-4 bg-white">
                    
                    <h2 class="affiliate-title mb-4 text-center border-bottom pb-3 font-weight-bold text-success">
                        Affiliate Program Registration
                    </h2>

                    {{-- Global Validation Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('affiliate.register.store') }}" method="POST" id="affiliateForm">
                        @csrf

                        <!-- Personal Information -->
                        <h4 class="mb-3 mt-4">Personal Information</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>First Name</label>
                                <input name="fname" type="text" class="form-control @error('fname') is-invalid @enderror"
                                       value="{{ old('fname') }}" required>
                                @error('fname') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Last Name</label>
                                <input name="lname" type="text" class="form-control @error('lname') is-invalid @enderror"
                                       value="{{ old('lname') }}" required>
                                @error('lname') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label>Email</label>
                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label>Phone</label>
                                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" required>
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <!-- Account Information -->
                        <h4 class="mb-3 mt-4">Account Information</h4>
                        <div class="row">

                            <div class="col-12 mb-3">
                                <label>Username</label>
                                <input name="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username') }}" required>
                                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3 position-relative">
                                <label>Password</label>
                                <div class="input-group">
                                    <input name="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="password" required>
                                    <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 mb-3 position-relative">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" required>
                                    <span class="input-group-text" id="toggleConfirmPassword" style="cursor:pointer;">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <!-- Affiliate Details -->
                        <h4 class="mb-3 mt-4">Affiliate Details</h4>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label>Website / Blog URL</label>
                                <input name="website_url" type="url"
                                       class="form-control @error('website_url') is-invalid @enderror"
                                       value="{{ old('website_url') }}" required>
                                @error('website_url') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label>Social Media Links</label>
                                <input name="social_media_link" type="text" class="form-control"
                                       value="{{ old('social_media_link') }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label>Promotion Method</label>
                                <select name="promotion_method" class="form-select form-control @error('promotion_method') is-invalid @enderror" required>
                                    <option value="">Select method</option>
                                    <option value="blog" {{ old('promotion_method') == 'blog' ? 'selected' : '' }}>Blog/Website</option>
                                    <option value="youtube" {{ old('promotion_method') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                    <option value="social" {{ old('promotion_method') == 'social' ? 'selected' : '' }}>Social Media</option>
                                    <option value="email" {{ old('promotion_method') == 'email' ? 'selected' : '' }}>Email Marketing</option>
                                </select>
                                @error('promotion_method') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label>Referrer (Optional)</label>
                                <input name="referal_name_id" type="text" class="form-control"
                                       value="{{ old('referal_name_id') }}">
                            </div>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="form-check mb-4">
                            <input class="form-check-input @error('terms') is-invalid @enderror"
                                   type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#">Terms & Conditions</a> of the Affiliate Program.
                            </label>
                            @error('terms') 
                                <br><small class="text-danger">{{ $message }}</small> 
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-user-plus me-2"></i> Register as Affiliate
                        </button>

                        <!-- Already Registered -->
                        <div class="text-center mt-3">
                            <p class="text-dark">
                                Already registered?
                                <a href="{{ route('affiliate.login') }}" class="text-decoration-none fw-semibold">
                                    Login here
                                </a>
                            </p>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // ===== Password Show/Hide =====
    document.getElementById('togglePassword').onclick = function() {
        const pass = document.getElementById('password');
        pass.type = pass.type === "password" ? "text" : "password";
        this.innerHTML = pass.type === "password"
            ? '<i class="fa fa-eye"></i>' 
            : '<i class="fa fa-eye-slash"></i>';
    };

    document.getElementById('toggleConfirmPassword').onclick = function() {
        const pass = document.getElementById('password_confirmation');
        pass.type = pass.type === "password" ? "text" : "password";
        this.innerHTML = pass.type === "password"
            ? '<i class="fa fa-eye"></i>' 
            : '<i class="fa fa-eye-slash"></i>';
    };

    // ===== Password Match Validation =====
    document.getElementById('affiliateForm').addEventListener('submit', function(e) {
        const pass = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        if (pass !== confirm) {
            e.preventDefault();
            alert('Password and Confirm Password do not match!');
        }
    });
</script>
@endsection
