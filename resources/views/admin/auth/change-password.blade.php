@extends('admin.layouts.app')
@section('title', 'Password Update')

@section('content')
<div class="min-vh-100 bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                    <!-- Header -->
                    <div class="card-header bg-gradient-purple text-white p-4">
                        <h2 class="h5 mb-0 fw-semibold">Update Password</h2>
                    </div>

                    <!-- Form -->
                    <div class="card-body p-4">
                        <form action="{{ route('admin.change.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Error Messages --}}
                            @if ($errors->any())
                            <div class="alert alert-danger border-danger mb-4">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- Current Password -->
                            <div class="mb-4 position-relative">
                                <label for="current_password" class="form-label fw-medium text-dark">Current Password</label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password" required
                                        class="form-control rounded-3 border-secondary @error('current_password') is-invalid @enderror"
                                        style="padding-right: 45px;">
                                    <span onclick="togglePassword('current_password', this)"
                                        class="position-absolute end-0 top-25 translate-middle-y me-3 cursor-pointer text-muted"
                                        style="z-index: 10; margin-top: 14px; cursor: pointer;">👁️</span>
                                </div>
                                @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-4 position-relative">
                                <label for="new_password" class="form-label fw-medium text-dark">New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password" required
                                        class="form-control rounded-3 border-secondary @error('new_password') is-invalid @enderror"
                                        style="padding-right: 45px;">
                                    <span onclick="togglePassword('new_password', this)"
                                        class="position-absolute end-0 top-25 translate-middle-y me-3 cursor-pointer text-muted"
                                        style="z-index: 10; margin-top: 14px; cursor: pointer;">👁️</span>
                                </div>
                                @error('new_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="mb-4 position-relative">
                                <label for="new_password_confirmation" class="form-label fw-medium text-dark">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                        class="form-control rounded-3 border-secondary @error('new_password_confirmation') is-invalid @enderror"
                                        style="padding-right: 45px;">
                                    <span onclick="togglePassword('new_password_confirmation', this)"
                                        class="position-absolute end-0 top-25 translate-middle-y me-3 cursor-pointer text-muted"
                                        style="z-index: 10; margin-top: 14px; cursor: pointer;">👁️</span>
                                </div>
                                @error('new_password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end pt-4 border-top">
                                <button type="submit" class="btn text-white px-4 py-2  bg-gradient-purple rounded-3 d-flex align-items-center gap-2">
                                    <i class="fa fa-edit"></i>
                                    <span>Update</span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId, el) {
        const input = document.getElementById(fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            el.textContent = '🙈';
        } else {
            input.type = 'password';
            el.textContent = '👁️';
        }
    }
</script>

@endsection