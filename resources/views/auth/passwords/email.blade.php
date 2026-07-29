@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            <!-- Header -->
            <div class="bg-primary px-6 py-4">
                <h2 class="text-white text-lg font-semibold">{{ __('Reset Password') }}</h2>
            </div>

            <!-- Body -->
            <div class="p-8">

                @if (session('status'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <span class="text-sm">{{ session('status') }}</span>
                    </div>
                </div>
                @endif

                <p class="text-gray-500 text-sm mb-6">
                    আপনার email address দিন। আমরা একটি password reset link পাঠাবো।
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('Email Address') }} <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            class="w-full px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors
                                {{ $errors->has('email') ? 'border-red-500 bg-red-50' : 'border-gray-300' }}"
                            placeholder="example@email.com"
                        />
                        @error('email')
                        <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-xs"></i>
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full bg-primary hover:opacity-90 text-white font-semibold py-3 px-4 rounded-lg transition-opacity text-sm">
                        {{ __('Send Password Reset Link') }}
                    </button>

                    <!-- Back to login -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('login') }}" class="text-sm text-primary hover:underline font-medium">
                            ← Back to Login
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection