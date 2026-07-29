@extends('layouts.app')
@section('title', 'Submit Complain')

@section('content')

<style>
:root {
    --brand-red:   #E30613;
    --brand-black: #111111;
    --brand-white: #ffffff;
}

.complain-title-bar {
    width: 70px;
    height: 4px;
    background: var(--brand-red);
    margin: 16px auto 0;
    border-radius: 999px;
}

.complain-form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.5rem;
    transition: border-color .2s ease, box-shadow .2s ease;
    outline: none;
}
.complain-form-input:focus {
    border-color: var(--brand-red);
    box-shadow: 0 0 0 3px rgba(227,6,19,0.15);
}

.complain-submit-btn {
    background: var(--brand-red);
    color: #fff;
    font-weight: 700;
    padding: 14px;
    border: none;
    border-radius: 0.5rem;
    width: 100%;
    transition: background .2s ease;
}
.complain-submit-btn:hover {
    background: var(--brand-black);
    color: #fff;
}

.complain-info-panel {
    background: linear-gradient(135deg, var(--brand-black) 0%, #000000 100%);
    color: #fff;
}
.complain-info-icon { color: var(--brand-red); }
.complain-info-panel a { color: #d1d5db; text-decoration: none; transition: color .2s ease; }
.complain-info-panel a:hover { color: var(--brand-red); }

.complain-success-box {
    background: #f0fdf4;
    border-left: 4px solid #22c55e;
    border-radius: 0.75rem;
    padding: 1.25rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.complain-success-icon {
    width: 48px; height: 48px;
    background: #dcfce7;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.complain-social-btn {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    transition: opacity .2s ease;
}
.complain-social-btn:hover { opacity: .85; }
</style>

<!-- Customer Complaint Section -->
<section class="container py-5">

    <!-- Page Title -->
    <div class="text-center mb-5">
        <h1 class="fw-bold display-6 display-md-4 text-dark mb-3">{{ $setting->complain_title }}</h1>
        <p class="text-muted fs-5 mb-0">{{ $setting->complain_description }}</p>
        <div class="complain-title-bar"></div>
    </div>

    <div class="row g-0 bg-white rounded-4 shadow-lg overflow-hidden">

        <!-- Left Side - Complaint Form -->
        <div class="col-lg-6 p-4 p-md-5">
            <h2 class="fs-3 fs-md-2 fw-bold text-dark mb-4">SEND US YOUR COMPLAINT</h2>

            @if(session('success'))
            <div id="successMessage" class="complain-success-box d-flex align-items-start gap-3">
                <div class="complain-success-icon">
                    <i class="fas fa-check text-success fs-5"></i>
                </div>
                <div>
                    <p class="fw-bold text-success fs-6 mb-1">Complaint Submitted Successfully!</p>
                    <p class="text-success small mb-2">{{ session('success') }}</p>
                    <p class="text-success small mb-0">
                        <i class="fas fa-clock me-1"></i>
                        Our team will get back to you within 24 hours.
                    </p>
                </div>
            </div>
            @endif

            <form action="{{ route('complaint.store') }}" method="POST" class="d-flex flex-column gap-3">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="form-label fw-semibold text-dark">
                        Your Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name"
                        class="complain-form-input">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="form-label fw-semibold text-dark">
                        Your Email <span class="text-danger">*</span>
                    </label>
                    <input type="email" id="email" name="email" required placeholder="example@email.com"
                        class="complain-form-input">
                </div>

                <!-- Mobile Number -->
                <div>
                    <label for="phone" class="form-label fw-semibold text-dark">
                        Mobile Number <span class="text-danger">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone" required placeholder="017********"
                        class="complain-form-input">
                </div>

                <!-- Order Number (Optional) -->
                <div>
                    <label for="order_number" class="form-label fw-semibold text-dark">
                        Order Number <span class="text-muted small">(Optional)</span>
                    </label>
                    <input type="text" id="order_number" name="order_number" placeholder="e.g., #ORD12345"
                        class="complain-form-input">
                </div>

                <!-- Message -->
                <div>
                    <label for="complaint" class="form-label fw-semibold text-dark">
                        Your Complaint <span class="text-danger">*</span>
                    </label>
                    <textarea id="complaint" name="complaint" rows="5"
                        placeholder="Please describe your complaint in detail..."
                        class="complain-form-input" style="resize:none;"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="complain-submit-btn d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    SUBMIT COMPLAINT
                </button>
            </form>
        </div>

        <!-- Right Side - Contact Information -->
        <div class="col-lg-6 complain-info-panel p-4 p-md-5">
            <h2 class="fs-3 fs-md-2 fw-bold mb-4">CONTACT INFORMATION</h2>

            <!-- Address -->
            <div class="mb-4">
                <h3 class="fs-6 fw-bold mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-map-marker-alt complain-info-icon"></i>
                    Address
                </h3>
                <p class="text-white-50 mb-0" style="line-height:1.7;">
                    {{ $setting->address }}
                </p>
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <h3 class="fs-6 fw-bold mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-phone-alt complain-info-icon"></i>
                    Phone
                </h3>
                <a href="tel:{{ $setting->phone_one }}">
                    {{ $setting->phone_one }}
                </a>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <h3 class="fs-6 fw-bold mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-envelope complain-info-icon"></i>
                    Email
                </h3>
                <a href="mailto:{{ $setting->email_one }}">
                    {{ $setting->email_one }}
                </a>
            </div>

            <!-- Working Hours -->
            <div class="mb-4">
                <h3 class="fs-6 fw-bold mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-clock complain-info-icon"></i>
                    Working Hours
                </h3>
                <p class="text-white-50 mb-0">
                    {{ $setting->working_day }}<br>
                    {{ $setting->working_hours }}
                </p>
            </div>

        </div>

    </div>

    <!-- FAQ Section -->
    <div class="mx-auto mt-5" style="max-width:900px;">
        <h2 class="fs-2 fw-bold text-center text-dark mb-4">Frequently Asked Questions</h2>

        <div class="d-flex flex-column gap-3">
            {!! $data->submit_complaint !!}
        </div>

    </div>

</section>

@endsection

@section('script')
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('successMessage');
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endif
@endsection