@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('Seller Registration'))

@section('content')

<div class="min-h-screen flex items-center py-12 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-center">
            <div class="w-full max-w-4xl">

                <div class="bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl p-8 md:p-10 border border-gray-100">

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-block p-3 bg-primary/10 rounded-full mb-4">
                            <i class="fas fa-store text-4xl text-primary"></i>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                            {{ \App\Helpers\TranslateHelper::translate('Become a Seller') }}
                        </h2>
                        <p class="text-gray-600">
                            {{ \App\Helpers\TranslateHelper::translate('Join our platform and start selling your products today') }} ðŸš€
                        </p>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex items-start" role="alert">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    @endif

                    <form action="{{ route('seller.register.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Name & Shop Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('Full Name') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" name="name"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('name') border-red-500 ring-2 ring-red-200 @enderror"
                                        value="{{ old('name') }}"
                                        placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter your full name') }}"
                                        required>
                                </div>
                                @error('name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('Shop Name') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-store text-gray-400"></i>
                                    </div>
                                    <input type="text" name="shop_name"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('shop_name') border-red-500 ring-2 ring-red-200 @enderror"
                                        value="{{ old('shop_name') }}"
                                        placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter your shop name') }}"
                                        required>
                                </div>
                                @error('shop_name')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('Email') }} <span class="text-red-500">*</span>
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

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('Phone') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="text" name="phone"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all @error('phone') border-red-500 ring-2 ring-red-200 @enderror"
                                        value="{{ old('phone') }}"
                                        placeholder="+880 1XXX-XXXXXX"
                                        required>
                                </div>
                                @error('phone')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password & Confirm Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                        placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter password') }}"
                                        required>
                                    <button type="button" onclick="togglePassword('password', 'togglePasswordIcon1')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i id="togglePasswordIcon1" class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors"></i>
                                    </button>
                                </div>
                                @error('password')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('Confirm Password') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="{{ \App\Helpers\TranslateHelper::translate('Confirm password') }}"
                                        required>
                                    <button type="button" onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i id="togglePasswordIcon2" class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        
                        <!-- City, Country, Postal Code -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('NID Number') }} <span class="text-red-500">*</span>
                                </label>
                               <input type="tel" name="nid"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all 
                                    @error('nid') border-red-500 ring-2 ring-red-200 @enderror"
                                    value="{{ old('nid') }}"
                                    placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter NID Number') }}"
                                    required>
                                
                                @error('nid')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('City') }}
                                </label>
                                <input type="text" name="city"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                    value="{{ old('city') }}"
                                    placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter city') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('Country') }}
                                </label>
                                <input type="text" name="country"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                    value="{{ old('country') }}"
                                    placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter country') }}">
                            </div>

                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ \App\Helpers\TranslateHelper::translate('Address') }}
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                                <textarea name="address" rows="3"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none"
                                    placeholder="{{ \App\Helpers\TranslateHelper::translate('Enter your complete address') }}">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        

                        <!-- Shop Description -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ \App\Helpers\TranslateHelper::translate('Shop Description') }}
                            </label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none"
                                placeholder="{{ \App\Helpers\TranslateHelper::translate('Tell us about your shop and what you sell...') }}">{{ old('description') }}</textarea>
                        </div>

                        <!-- Logo & Banner Upload -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ \App\Helpers\TranslateHelper::translate('Upload Logo') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="file" name="logo" id="logo" class="hidden" accept="image/*"
                                        onchange="previewImage(this, 'logoPreview')">
                                    <label for="logo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:bg-gray-50 transition-colors @error('logo') border-red-500 @enderror">
                                        <div id="logoPreview" class="flex flex-col items-center justify-center">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                            <p class="text-sm text-gray-500">{{ \App\Helpers\TranslateHelper::translate('Click to upload logo') }}</p>
                                            <p class="text-xs text-gray-400">PNG, JPG (MAX. 2MB)</p>
                                        </div>
                                    </label>
                                </div>
                                @error('logo')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror
                            </div>

                           
                        </div>

                        <!-- Terms & Register Button -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pt-6 border-t border-gray-200">
                            <div class="space-y-2">
                                <label class="flex items-start cursor-pointer group">
                                    <input type="checkbox" name="terms"
                                        class="mt-1 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 @error('terms') border-red-500 @enderror"
                                        id="terms" required>
                                    <span class="ml-2 text-sm text-gray-700">
                                        {{ \App\Helpers\TranslateHelper::translate('I agree to the') }}
                                        <a href="#" class="text-primary hover:text-red-700 font-semibold transition-colors">{{ \App\Helpers\TranslateHelper::translate('Terms & Conditions') }}</a>
                                    </span>
                                </label>
                                @error('terms')
                                <p class="text-red-500 text-xs flex items-center ml-6">
                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                </p>
                                @enderror

                                <p class="text-sm text-gray-600 ml-6">
                                    {{ \App\Helpers\TranslateHelper::translate('Already have an account?') }}
                                    <a href="{{ route('seller.login') }}" class="text-primary hover:text-red-700 font-semibold transition-colors">
                                        {{ \App\Helpers\TranslateHelper::translate('Login here') }}
                                    </a>
                                </p>
                            </div>

                            <button type="submit" class="bg-primary hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] flex items-center justify-center gap-2">
                                <i class="fas fa-user-plus"></i>
                                <span>{{ \App\Helpers\TranslateHelper::translate('Register as Seller') }}</span>
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
    function togglePassword(fieldId, iconId) {
        let field = document.getElementById(fieldId);
        let icon = document.getElementById(iconId);
        if (field.type === "password") {
            field.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            field.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg" alt="Preview">`;
            }
            reader.readAsDataURL(input.files[0]);

            // Remove error state when file is selected
            const label = document.querySelector('label[for="' + input.id + '"]');
            if (label) {
                label.classList.remove('border-red-500', 'bg-red-50');
                label.classList.add('border-dashed', 'border-gray-300');
            }
            // Remove error message — go up to the field wrapper (parent of .relative div)
            const fieldWrapper = input.closest('.relative').parentElement;
            const oldError = fieldWrapper.querySelector('.file-error');
            if (oldError) oldError.remove();
        }
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        let firstErrorEl = null;

        // 1. Check required text/email/password/tel/textarea fields
        const requiredInputs = this.querySelectorAll('input[required]:not([type="checkbox"]):not([type="file"]), textarea[required]');
        requiredInputs.forEach(function(input) {
            if (!input.value.trim()) {
                input.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                if (!firstErrorEl) firstErrorEl = input;
            } else {
                input.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
            }
        });

        // 2. Check required file inputs
        const requiredFiles = this.querySelectorAll('input[type="file"][required]');
        requiredFiles.forEach(function(input) {
            const label = document.querySelector('label[for="' + input.id + '"]');
            // fieldWrapper = the <div> that contains both <div class="relative"> and any error messages
            const fieldWrapper = input.closest('.relative').parentElement;

            // Remove old file error if exists
            const oldError = fieldWrapper.querySelector('.file-error');
            if (oldError) oldError.remove();

            if (!input.files || input.files.length === 0) {
                // Red border on the upload label box
                if (label) {
                    label.classList.remove('border-gray-300');
                    label.classList.add('border-red-500', 'bg-red-50');
                }
                // Append error message inside fieldWrapper (after the .relative div)
                const errorMsg = document.createElement('p');
                errorMsg.className = 'text-red-500 text-xs mt-1 flex items-center file-error';
                errorMsg.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i> Logo is required.';
                fieldWrapper.appendChild(errorMsg);

                if (!firstErrorEl) firstErrorEl = label;
            } else {
                if (label) {
                    label.classList.remove('border-red-500', 'bg-red-50');
                    label.classList.add('border-gray-300');
                }
            }
        });

        // 3. Check terms checkbox
        const termsCheckbox = this.querySelector('#terms');
        if (termsCheckbox && !termsCheckbox.checked) {
            termsCheckbox.classList.add('ring-2', 'ring-red-400');
            if (!firstErrorEl) firstErrorEl = termsCheckbox;
        } else if (termsCheckbox) {
            termsCheckbox.classList.remove('ring-2', 'ring-red-400');
        }

        // 4. Scroll + focus to first error
        if (firstErrorEl) {
            e.preventDefault();
            firstErrorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(function() {
                if (typeof firstErrorEl.focus === 'function') {
                    firstErrorEl.focus();
                }
            }, 400);
        }
    });

    // Live validation: remove red border on typing
    document.querySelectorAll('input[required]:not([type="file"]):not([type="checkbox"]), textarea[required]').forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
            }
        });
    });

    // Live: remove terms error on check
    const terms = document.getElementById('terms');
    if (terms) {
        terms.addEventListener('change', function() {
            if (this.checked) {
                this.classList.remove('ring-2', 'ring-red-400');
            }
        });
    }
</script>
@endsection