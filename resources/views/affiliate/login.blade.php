@extends('layouts.app')

@section('title', 'Affiliate Login')

@section('css')
<style>
    .seller-bg {
        min-height: 100vh;
        display: flex;
        align-items: center;
        background-image: url('{{ asset("assets/img/seller-register.png") }}');
        background-size: cover;
        background-position: center;
    }

    .seller-card {
        background: rgba(255, 255, 255, 0.93);
        backdrop-filter: blur(10px);
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
    }

    .seller-title {
        font-weight: 700;
        font-size: 28px;
        color: #1e3c72;
    }


    .input-group-text {
        background: #f8f9fa;
        border-left: none;
        cursor: pointer;
    }

    .form-control {
        border-radius: 8px;
    }

    .error-text {
        font-size: 13px;
        color: #d93025;
    }
</style>
@endsection

@section('content')

<div class="seller-bg py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">

                <div class="seller-card">

                    <div class="text-center mb-4">
                        <h2 class="seller-title">Affiliate Login</h2>
                        <p class="text-muted">Login to manage your shop and products</p>
                    </div>

                    <form action="{{ route('affiliate.login.submit') }}" method="POST">
                        @csrf

                        {{-- Email --}}
                        <div class="form-group">
                            <label>Email Address <span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required>

                            @error('email')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password"
                                       required>

                                <div class="input-group-append">
                                    <span class="input-group-text" id="togglePassword">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>

                            @error('password')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember Me + Terms --}}
                        <div class="form-group">
                            <div class="d-flex justify-content-between">

                                {{-- Remember Me --}}
                                <div class="form-check">
                                    <input type="checkbox"
                                           name="remember"
                                           class="form-check-input"
                                           id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>

                               

                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <small class="text-muted">
                                Don't have an account?
                                <a href="{{ route('affiliate.register') }}">Register Now</a>
                            </small>

                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    // Password toggle
    document.getElementById('togglePassword').addEventListener('click', function () {
        let pass = document.getElementById('password');
        pass.type = pass.type === "password" ? "text" : "password";
        this.innerHTML = pass.type === "password"
            ? '<i class="fa fa-eye"></i>'
            : '<i class="fa fa-eye-slash"></i>';
    });
</script>
@endsection
