@extends('layouts.app')
@section('title','Contact')
@section('content')

<style>
    :root {
        --brand-red:   #FF0000;
        --brand-black: #000000;
        --brand-white: #ffffff;
    }

    body { background: #f7f7f8; }

    .contact-title-bar {
        width: 70px;
        height: 4px;
        background: var(--brand-red);
        margin: 0 auto;
        border-radius: 999px;
    }

    .contact-card {
        background: var(--brand-white);
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #f0f0f0;
        padding: 1.75rem;
        height: 100%;
    }
    @media (min-width: 768px) {
        .contact-card { padding: 2.25rem; }
    }

    .contact-form-input {
        width: 100%;
        padding: 0.65rem 1rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.5rem;
        transition: border-color .2s ease, box-shadow .2s ease;
        outline: none;
    }
    .contact-form-input:focus {
        border-color: var(--brand-red);
        box-shadow: 0 0 0 3px rgba(255,0,0,0.12);
    }

    .contact-submit-btn {
        width: 100%;
        background: var(--brand-red);
        color: #fff;
        font-weight: 700;
        padding: 12px;
        border: none;
        border-radius: 0.5rem;
        transition: background .2s ease;
    }
    .contact-submit-btn:hover {
        background: var(--brand-black);
        color: #fff;
    }

    .contact-info-icon {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255,0,0,0.08);
        color: var(--brand-red);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .contact-info-row a {
        color: #374151;
        text-decoration: none;
        transition: color .2s ease;
    }
    .contact-info-row a:hover { color: var(--brand-red); }

    .contact-map-wrap {
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
    }
    .contact-map-wrap iframe {
        width: 100%;
        height: 250px;
        border: 0;
        display: block;
    }
</style>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">

        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6 display-md-4 text-dark mb-3">Get in Touch</h2>
            <p class="text-muted mx-auto mb-3" style="max-width:600px;">
                We would love to hear from you! Send us a message or find us at our office.
            </p>
            <div class="contact-title-bar"></div>
        </div>

        <div class="row g-4 mx-auto" style="max-width:1100px;">

            <!-- Contact Form -->
            <div class="col-lg-6">
                <div class="contact-card">
                    <h4 class="fs-5 fw-semibold text-dark mb-4">Send Us a Message</h4>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="post" class="d-flex flex-column gap-3">
                        @csrf

                        <div>
                            <label for="name" class="form-label fw-semibold text-dark small">Full Name</label>
                            <input name="name" type="text" id="name"
                                class="contact-form-input" placeholder="John Doe" required>
                        </div>

                        <div>
                            <label for="phone" class="form-label fw-semibold text-dark small">Phone Number</label>
                            <input name="phone" type="tel" id="phone"
                                class="contact-form-input" placeholder="+880 1234-567890" required>
                        </div>

                        <div>
                            <label for="subject" class="form-label fw-semibold text-dark small">Subject</label>
                            <input name="subject" type="text" id="subject"
                                class="contact-form-input" placeholder="Subject" required>
                        </div>

                        <div>
                            <label for="message" class="form-label fw-semibold text-dark small">Message</label>
                            <textarea name="message" id="message" rows="5"
                                class="contact-form-input" style="resize:none;"
                                placeholder="Your message..." required></textarea>
                        </div>

                        <button type="submit" class="contact-submit-btn d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            <span>Send Message</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-6">
                <div class="contact-card">
                    <h4 class="fs-5 fw-semibold text-dark mb-4">Contact Information</h4>

                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex align-items-start gap-3 contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="text-secondary pt-1">{{ $setting->address }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-3 contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <a href="tel:{{ $setting->phone_one }}">
                                {{ $setting->phone_one }}
                            </a>
                        </div>

                        <div class="d-flex align-items-center gap-3 contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <a href="mailto:{{ $setting->email_one }}">
                                {{ $setting->email_one }}
                            </a>
                        </div>

                        <div class="d-flex align-items-center gap-3 contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <span class="text-secondary">{{ $setting->working_day ?? 'Mon – Fri' }}: {{ $setting->working_hours ?? '9:00 AM – 6:00 PM' }}</span>
                        </div>
                    </div>

                    @if($setting->google_maps)
                    <div class="mt-4">
                        <h5 class="fs-6 fw-semibold text-dark mb-3">Find Us on Map</h5>
                        <div class="contact-map-wrap">
                            {!! $setting->google_maps !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@endsection