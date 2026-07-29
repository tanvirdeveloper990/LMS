@extends('admin.layouts.app')

@section('title', 'Add Shipping')

@section('content')
<section class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 700px; overflow: hidden;">

            {{-- Header --}}
            <div class="card-header bg-gradient-purple">
                <div class="d-flex justify-content-between align-items-center text-white">
                    <h5 class="mb-0 fw-semibold">Add Shipping</h5>
                    <a href="{{ route('admin.shiping.index') }}" class="btn btn-light btn-sm">
                        <i class="fa fa-angle-left"></i> Back
                    </a>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body p-4">
                <form action="{{ route('admin.shiping.store') }}" method="POST">
                    @csrf

                    {{-- Text --}}
                    <div class="mb-3">
                        <label for="text" class="form-label fw-medium">
                            Shipping Text <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="text" id="text" value="{{ old('text') }}"
                            class="form-control @error('text') is-invalid @enderror"
                            placeholder="e.g. Inside Dhaka" required>
                        @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="mb-3">
                        <label for="amount" class="form-label fw-medium">
                            Amount <span class="text-danger">*</span>
                        </label>
                        <input type="tel" name="amount" id="amount" value="{{ old('amount') }}"
                            class="form-control @error('amount') is-invalid @enderror"
                            placeholder="e.g. 60" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="form-label fw-medium">Status</label>
                        <select name="status" id="status"
                            class="form-select @error('status') is-invalid @enderror">
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="border-top pt-3 text-end">
                        <button type="submit" class="btn text-white bg-gradient-purple">
                            <i class="fa fa-save me-1"></i> Save
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection