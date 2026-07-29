@extends('layouts.app')
@section('title', \App\Helpers\TranslateHelper::translate('Register'))

@section('content')
<style>
    .auth-section {
        background: linear-gradient(160deg, #eaf1ff 0%, #f3ecff 45%, #fdf1f7 100%);
        padding: 60px 0;
        min-height: 85vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    /* ── Floating decorative blobs (cartoon feel) ────────── */
    .auth-blob {
        position: absolute;
        border-radius: 50%;
        opacity: .55;
        filter: blur(2px);
        animation: floatBlob 6s ease-in-out infinite;
        pointer-events: none;
        z-index: 0;
    }
    .auth-blob--1 { width: 90px; height: 90px; background: #bfdbfe; top: 8%; left: 8%; animation-delay: 0s; }
    .auth-blob--2 { width: 60px; height: 60px; background: #fbcfe8; top: 15%; right: 10%; animation-delay: 1s; }
    .auth-blob--3 { width: 70px; height: 70px; background: #ddd6fe; bottom: 12%; left: 12%; animation-delay: 2s; }
    .auth-blob--4 { width: 50px; height: 50px; background: #bbf7d0; bottom: 18%; right: 8%; animation-delay: 1.5s; }
    .auth-emoji {
        position: absolute;
        font-size: 1.8rem;
        opacity: .85;
        animation: floatBlob 5s ease-in-out infinite;
        pointer-events: none;
        z-index: 0;
    }
    .auth-emoji--1 { top: 10%; left: 18%; animation-delay: .3s; }
    .auth-emoji--2 { top: 20%; right: 18%; animation-delay: 1.2s; }
    .auth-emoji--3 { bottom: 22%; left: 20%; animation-delay: .8s; }
    .auth-emoji--4 { bottom: 10%; right: 20%; animation-delay: 1.8s; }

    @keyframes floatBlob {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-16px); }
    }

    /* ── Card ─────────────────────────────────────────────── */
    .auth-card {
        background: #fff;
        border-radius: 28px;
        box-shadow: 0 20px 50px rgba(79, 70, 229, .12);
        padding: 44px 40px;
        position: relative;
        z-index: 2;
    }

    .auth-icon-badge {
        width: 74px;
        height: 74px;
        margin: 0 auto 16px;
        border-radius: 22px;
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.1rem;
        box-shadow: 0 10px 24px rgba(37, 99, 235, .3);
    }

    .auth-title {
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
        font-weight: 800;
        font-size: 1.5rem;
        color: #1f2937;
        text-align: center;
        margin-bottom: 6px;
    }

    .auth-subtitle {
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
        text-align: center;
        color: #6b7280;
        font-size: .9rem;
        margin-bottom: 28px;
    }

    .form-label {
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
        font-weight: 700;
        font-size: .88rem;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-control {
        border: 2px solid #eef0f5;
        background: #f9fafc;
        border-radius: 14px;
        padding: 12px 14px;
        font-size: .92rem;
        transition: all .2s ease;
    }
    .form-control:focus {
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .1);
    }

    .input-group-icon { position: relative; }
    .input-group-icon .form-control { padding-left: 44px; }
    .input-group-icon i.field-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        z-index: 5;
        font-size: .92rem;
    }

    .toggle-eye {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #9ca3af;
        z-index: 5;
        background: none;
        border: none;
        padding: 4px;
    }
    .toggle-eye:hover { color: #2563eb; }

    .btn-auth {
        background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
        color: #fff;
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        border-radius: 50px;
        padding: 13px;
        border: none;
        box-shadow: 0 10px 24px rgba(37, 99, 235, .28);
        transition: transform .18s ease, box-shadow .18s ease;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-auth:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(37, 99, 235, .36);
    }
    .btn-auth:active { transform: translateY(0); }
    .btn-auth:disabled { opacity: .7; cursor: not-allowed; transform: none; }

    .auth-link {
        color: #2563eb;
        font-weight: 700;
        text-decoration: none;
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
    }
    .auth-link:hover { color: #7c3aed; text-decoration: underline; }

    .form-check-input:checked {
        background-color: #2563eb;
        border-color: #2563eb;
    }
    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        border-color: #2563eb;
    }
    .form-check-label {
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
        font-size: .84rem;
        color: #4b5563;
    }

    .alert-custom-success {
        background: #ecfdf5;
        border-left: 4px solid #22c55e;
        color: #14532d;
        border-radius: 12px;
        padding: 14px 16px;
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
    }

    .alert-custom-error {
        background: #fef2f2;
        border-left: 4px solid #ef4444;
        color: #7f1d1d;
        border-radius: 12px;
        padding: 14px 16px;
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
    }

    p.text-center.mt-4,
    p.text-center.mb-0 {
        font-family: 'Hind Siliguri', 'Noto Sans Bengali', sans-serif;
    }

    @media (max-width: 480px) {
        .auth-card { padding: 34px 24px; border-radius: 22px; }
        .auth-emoji, .auth-blob { display: none; }
    }
</style>

<section class="auth-section">

    {{-- Decorative floating shapes --}}
    <div class="auth-blob auth-blob--1"></div>
    <div class="auth-blob auth-blob--2"></div>
    <div class="auth-blob auth-blob--3"></div>
    <div class="auth-blob auth-blob--4"></div>
    <div class="auth-emoji auth-emoji--1">📚</div>
    <div class="auth-emoji auth-emoji--2">✨</div>
    <div class="auth-emoji auth-emoji--3">🎓</div>
    <div class="auth-emoji auth-emoji--4">🏆</div>

    <div class="container" style="position:relative; z-index:2;">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8 col-sm-9">
                <div class="auth-card">

                    <div class="auth-icon-badge">📝</div>

                    <h2 class="auth-title">অ্যাকাউন্ট তৈরি করো</h2>
                    <p class="auth-subtitle">আমাদের সাথে যুক্ত হয়ে আজই শুরু করো</p>

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
                            <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" id="registerForm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">পুরো নাম</label>
                            <div class="input-group-icon">
                                <i class="fas fa-user field-icon"></i>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name" placeholder="তোমার পুরো নাম লিখো" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">ইমেইল ঠিকানা</label>
                            <div class="input-group-icon">
                                <i class="fas fa-envelope field-icon"></i>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email" placeholder="example@email.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">পাসওয়ার্ড</label>
                            <div class="input-group-icon position-relative">
                                <i class="fas fa-lock field-icon"></i>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password" placeholder="একটি পাসওয়ার্ড দাও" required style="padding-right:42px;">
                                <button type="button" class="toggle-eye" id="togglePassword">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">পাসওয়ার্ড নিশ্চিত করো</label>
                            <div class="input-group-icon position-relative">
                                <i class="fas fa-lock field-icon"></i>
                                <input type="password" name="password_confirmation"
                                    class="form-control"
                                    id="password_confirmation" placeholder="আবার পাসওয়ার্ড লিখো" required style="padding-right:42px;">
                                <button type="button" class="toggle-eye" id="toggleConfirmPassword">
                                    <i class="fas fa-eye" id="confirmEyeIcon"></i>
                                </button>
                            </div>
                            <div id="passwordMatchMsg" class="text-danger small mt-1 d-none">পাসওয়ার্ড দুটি মিলছে না!</div>
                            @error('password_confirmation')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">
                                আমি <a href="#" class="auth-link">শর্তাবলী</a>-তে সম্মত
                            </label>
                        </div>

                        <button type="submit" class="btn btn-auth w-100" id="registerBtn">
                            <span id="registerBtnText">রেজিস্ট্রেশন করো</span>
                        </button>

                        <p class="text-center mt-4 text-muted small mb-0">
                            আগে থেকেই অ্যাকাউন্ট আছে?
                            <a href="{{ route('login') }}" class="auth-link">লগ ইন করো</a>
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
    const passwordMsg = document.getElementById('passwordMatchMsg');

    document.getElementById('togglePassword').addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        document.getElementById('eyeIcon').classList.toggle('fa-eye');
        document.getElementById('eyeIcon').classList.toggle('fa-eye-slash');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmInput.setAttribute('type', type);
        document.getElementById('confirmEyeIcon').classList.toggle('fa-eye');
        document.getElementById('confirmEyeIcon').classList.toggle('fa-eye-slash');
    });

    confirmInput.addEventListener('input', function() {
        if (confirmInput.value !== passwordInput.value) {
            passwordMsg.classList.remove('d-none');
        } else {
            passwordMsg.classList.add('d-none');
        }
    });

    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');
    const registerBtnText = document.getElementById('registerBtnText');

    if (registerForm && registerBtn) {
        registerForm.addEventListener('submit', function() {
            registerBtn.disabled = true;
            registerBtnText.textContent = "রেজিস্ট্রেশন হচ্ছে...";
        });
    }

    setTimeout(function() {
        document.querySelectorAll('[role="alert"]').forEach(a => a.classList.remove('show'));
    }, 5000);
</script>
@endsection