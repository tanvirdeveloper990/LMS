@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('Seller Login'))

@section('content')

<div class="min-h-screen flex items-center py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-md">

                <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl p-8 md:p-10 border border-gray-100">

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-block p-3 bg-primary/10 rounded-full mb-4">
                            <i class="fas fa-store text-4xl text-primary"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                            {{ \App\Helpers\TranslateHelper::translate('Seller Login') }}
                        </h2>
                        <p class="text-gray-600">
                            {{ \App\Helpers\TranslateHelper::translate('Login to manage your shop and products') }}
                        </p>
                    </div>

                    <form action="{{ route('vendor.login.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ \App\Helpers\TranslateHelper::translate('Email Address') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('email') border-red-500 ring-2 ring-red-200 @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="seller@example.com"
                                    required>
                            </div>
                            @error('email')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ \App\Helpers\TranslateHelper::translate('Password') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="password" id="password"
                                    class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('password') border-red-500 ring-2 ring-red-200 @enderror"
                                    placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter your password') }}"
                                    required>
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                            <p class="text-red-500 text-xs mt-1 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 cursor-pointer"
                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-gray-900">
                                    {{ \App\Helpers\TranslateHelper::translate('Remember Me') }}
                                </span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-primary hover:text-red-700 font-medium transition-colors">
                                {{ \App\Helpers\TranslateHelper::translate('Forgot Password?') }}
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full bg-primary hover:bg-red-700 text-white py-3 px-4 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ \App\Helpers\TranslateHelper::translate('Login to Dashboard') }}</span>
                        </button>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">{{ \App\Helpers\TranslateHelper::translate('New to selling?') }}</span>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                {{ \App\Helpers\TranslateHelper::translate("Don't have an account?") }}
                                <a href="{{ route('seller.register') }}" class="text-primary hover:text-red-700 font-semibold transition-colors">
                                    {{ \App\Helpers\TranslateHelper::translate('Register Now') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Additional Info -->
                <div class="text-center mt-6">
                    <p class="text-xs text-gray-500">
                        {{ \App\Helpers\TranslateHelper::translate('Having trouble logging in?') }}
                        <a href="#" class="text-primary hover:underline">{{ \App\Helpers\TranslateHelper::translate('Contact Support') }}</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function(e) {
            e.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    }

    setTimeout(function() {
        const errors = document.querySelectorAll('.text-red-500');
        errors.forEach(error => {
            if (error.parentElement.tagName !== 'LABEL') {
                error.style.transition = 'opacity 0.5s';
                error.style.opacity = '0';
                setTimeout(() => error.remove(), 500);
            }
        });
    }, 5000);
</script>
@endsection