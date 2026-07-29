@extends('layouts.app')

@section('title', 'Register')

@section('content')
<style>
    .auth-section {
        background: var(--bg-light);
        padding: 60px 0;
        min-height: 80vh;
        display: flex;
        align-items: center;
    }

    .auth-card {
        background: #fff;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 40px;
        border-top: 4px solid var(--primary);
    }

    .auth-title {
        font-family: var(--font-heading);
        font-weight: 800;
        font-size: 1.7rem;
        color: var(--dark);
        text-align: center;
        margin-bottom: 6px;
    }

    .auth-subtitle {
        text-align: center;
        color: var(--text-muted);
        font-size: .9rem;
        margin-bottom: 28px;
    }

    .auth-title-bar {
        width: 50px;
        height: 3px;
        background: var(--primary);
        border-radius: 3px;
        margin: 0 auto 24px;
    }

    .form-label {
        font-weight: 600;
        font-size: .88rem;
        color: var(--dark);
    }

    .form-control {
        border: 1.5px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 11px 14px;
        font-size: .92rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
    }

    .input-group-icon {
        position: relative;
    }

    .input-group-icon .form-control {
        padding-left: 42px;
    }

    .input-group-icon i.field-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        z-index: 5;
    }

    .toggle-eye {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: var(--text-muted);
        z-index: 5;
    }

    .toggle-eye:hover {
        color: var(--primary);
    }

    .btn-auth {
        background: var(--primary);
        color: #fff;
        font-weight: 700;
        border-radius: 50px;
        padding: 12px;
        border: none;
        transition: var(--transition);
    }

    .btn-auth:hover {
        background: var(--primary-dark);
        color: #fff;
    }

    .auth-link {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
    }

    .auth-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .form-check-input:checked {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .alert-custom-success {
        background: var(--primary-light);
        border-left: 4px solid #28a745;
        color: #1c1c1c;
        border-radius: var(--radius-sm);
    }

    .alert-custom-error {
        background: #fdeceb;
        border-left: 4px solid var(--primary);
        color: var(--dark);
        border-radius: var(--radius-sm);
    }
</style>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="auth-card">

                    <h2 class="auth-title">Create Your Account</h2>
                    <p class="auth-subtitle">Join us and start shopping today</p>
                    <div class="auth-title-bar"></div>

                    @if(session('success'))
                    <div class="alert alert-custom-success alert-dismissible fade show mb-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-custom-error alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" id="registerForm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group-icon">
                                <i class="fas fa-user field-icon"></i>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name" placeholder="John Doe" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group-icon">
                                <i class="fas fa-envelope field-icon"></i>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email" placeholder="john@example.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group-icon position-relative">
                                <i class="fas fa-lock field-icon"></i>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="Enter your password" required style="padding-right:42px;">
                                <i class="fas fa-eye toggle-eye" id="togglePassword"></i>
                            </div>
                            @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="input-group-icon position-relative">
                                <i class="fas fa-lock field-icon"></i>
                                <input type="password" name="password_confirmation"
                                    class="form-control"
                                    id="password_confirmation" placeholder="Confirm your password" required style="padding-right:42px;">
                                <i class="fas fa-eye toggle-eye" id="toggleConfirmPassword"></i>
                            </div>
                            <div id="passwordMatchMsg" class="text-danger small mt-1 d-none">Passwords do not match!</div>
                            @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label small" for="terms">
                                I agree to the <a href="#" class="auth-link">Terms & Conditions</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-auth w-100">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </button>

                        <p class="text-center mt-4 text-muted small mb-0">
                            Already have an account?
                            <a href="{{ route('login') }}" class="auth-link">Login Now</a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const eyeIcon = document.getElementById('togglePassword');
    const confirmEyeIcon = document.getElementById('toggleConfirmPassword');
    const passwordMsg = document.getElementById('passwordMatchMsg');

    document.getElementById('togglePassword').addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });

    confirmInput.addEventListener('input', function() {
        if (confirmInput.value !== passwordInput.value) {
            passwordMsg.classList.remove('d-none');
        } else {
            passwordMsg.classList.add('d-none');
        }
    });
</script>
@endsection