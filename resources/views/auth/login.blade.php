@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('Login'))

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
        background: none;
        border: none;
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

    .alert-custom-error {
        background: #fdeceb;
        border-left: 4px solid var(--primary);
        color: var(--dark);
        border-radius: var(--radius-sm);
    }

    .footer-note a {
        color: var(--primary);
        text-decoration: none;
    }

    .footer-note a:hover {
        text-decoration: underline;
    }
</style>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="auth-card">

                    <h2 class="auth-title">{{ \App\Helpers\TranslateHelper::translate('Welcome Back') }}</h2>
                    <p class="auth-subtitle">{{ \App\Helpers\TranslateHelper::translate('Login to your account to continue') }}</p>
                    <div class="auth-title-bar"></div>

                    @if($errors->any())
                    <div class="alert alert-custom-error alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ \App\Helpers\TranslateHelper::translate('Email Address') }}</label>
                            <div class="input-group-icon">
                                <i class="fas fa-envelope field-icon"></i>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email"
                                    placeholder="john@example.com"
                                    value="{{ old('email') }}"
                                    required>
                            </div>
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ \App\Helpers\TranslateHelper::translate('Password') }}</label>
                            <div class="input-group-icon position-relative">
                                <i class="fas fa-lock field-icon"></i>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password"
                                    placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter your password') }}"
                                    required style="padding-right:42px;">
                                <button type="button" class="toggle-eye" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">
                                    {{ \App\Helpers\TranslateHelper::translate('Remember Me') }}
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}" class="auth-link small">
                                {{ \App\Helpers\TranslateHelper::translate('Forgot Password?') }}
                            </a>
                        </div>

                        <button type="submit" class="btn btn-auth w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            {{ \App\Helpers\TranslateHelper::translate('Login to Account') }}
                        </button>

                        <p class="text-center mt-4 text-muted small mb-0">
                            {{ \App\Helpers\TranslateHelper::translate("Don't have an account?") }}
                            <a href="{{ route('register') }}" class="auth-link">
                                {{ \App\Helpers\TranslateHelper::translate('Register Now') }}
                            </a>
                        </p>
                    </form>

                </div>

                <div class="text-center mt-4 footer-note">
                    <p class="small text-muted">
                        {{ \App\Helpers\TranslateHelper::translate('By continuing, you agree to our') }}
                        <a href="#">{{ \App\Helpers\TranslateHelper::translate('Terms of Service') }}</a>
                        {{ \App\Helpers\TranslateHelper::translate('and') }}
                        <a href="#">{{ \App\Helpers\TranslateHelper::translate('Privacy Policy') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');

    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function(e) {
            e.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    }

    setTimeout(function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(alert => {
            alert.classList.remove('show');
        });
    }, 5000);
</script>
@endsection