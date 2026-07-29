@php
$setting = \App\Models\Setting::first();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png"
        href="{{ $setting->favicon ? Storage::url($setting->favicon) : asset('/assets/img/null.png') }}">

    <!-- Bootstrap 5 (layout/utilities only — visuals are custom below) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Fonts: Anton (condensed athletic display) + Manrope (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink:        #0a0a0c;
            --panel:      #141417;
            --panel-2:    #1b1b1f;
            --line:       #26262b;
            --red:        #e30613;
            --red-deep:   #8c0410;
            --white:      #f5f5f7;
            --muted:      #85858f;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--ink);
            color: var(--white);
            font-family: 'Manrope', sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* ===================== AMBIENT BACKGROUND ===================== */
        .stage {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            background: var(--ink);
        }

        /* slow-breathing red embers, off-center — quiet, not decorative confetti */
        .ember {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .35;
            animation: breathe 12s ease-in-out infinite;
        }
        .ember--a {
            width: 620px; height: 620px;
            left: -180px; top: -160px;
            background: radial-gradient(circle, var(--red) 0%, transparent 70%);
            animation-delay: 0s;
        }
        .ember--b {
            width: 520px; height: 520px;
            right: -160px; bottom: -180px;
            background: radial-gradient(circle, var(--red-deep) 0%, transparent 70%);
            animation-delay: -6s;
        }
        @keyframes breathe {
            0%, 100% { transform: scale(1);    opacity: .28; }
            50%      { transform: scale(1.15); opacity: .42; }
        }

        /* faint outsole-tread texture, rotating at a glacial pace in the corners */
        .tread {
            position: absolute;
            width: 900px; height: 900px;
            opacity: .05;
            background-image: repeating-linear-gradient(
                45deg,
                var(--white) 0px, var(--white) 2px,
                transparent 2px, transparent 26px
            );
            animation: spin 220s linear infinite;
        }
        .tread--tl { top: -420px; left: -420px; }
        .tread--br { bottom: -420px; right: -420px; animation-direction: reverse; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* single hairline sweep, athletic-tunnel feel — very slow, very quiet */
        .sweep {
            position: absolute;
            top: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, transparent, rgba(227,6,19,.5), transparent);
            left: 50%;
            animation: sweep 9s ease-in-out infinite;
        }
        @keyframes sweep {
            0%, 100% { transform: translateX(-38vw); opacity: 0; }
            50%      { transform: translateX(38vw);  opacity: 1; }
        }

        @media (prefers-reduced-motion: reduce) {
            .ember, .tread, .sweep { animation: none !important; }
        }

        /* ===================== CENTER STAGE ===================== */
        .center-wrap {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-col {
            width: 100%;
            max-width: 420px;
        }

        /* ---- Eyebrow highlight above the card ---- */
        .brand-tag-wrap {
            text-align: center;
            margin-bottom: 22px;
        }
        .brand-tag {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 7px 18px;
            border: 1px solid rgba(227,6,19,.4);
            border-radius: 999px;
            background: rgba(227,6,19,.08);
        }
        .brand-tag i { color: var(--red); font-size: 12px; }
        .brand-tag span {
            font-family: 'Anton', sans-serif;
            font-size: 13px;
            letter-spacing: .16em;
            color: var(--white);
            text-transform: uppercase;
        }

        /* signature: animated stitch seam under the tag, referencing shoe stitching */
        .stitch {
            width: 96px;
            height: 0;
            margin: 12px auto 0;
            border-top: 2px dashed rgba(227,6,19,.55);
            animation: stitch-march 1.4s linear infinite;
        }
        @keyframes stitch-march {
            to { border-image-source: none; background-position: 12px 0; }
        }
        /* dash-offset trick via background instead of border for smoother motion */
        .stitch {
            border-top: none;
            height: 2px;
            background-image: repeating-linear-gradient(90deg, var(--red) 0 6px, transparent 6px 12px);
            background-size: 12px 2px;
            animation: stitch-run 1s linear infinite;
            opacity: .8;
        }
        @keyframes stitch-run {
            to { background-position: 12px 0; }
        }

        /* ---- Card ---- */
        .login-card {
            position: relative;
            background: linear-gradient(180deg, var(--panel) 0%, var(--panel-2) 100%);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 38px 34px 30px;
            box-shadow: 0 30px 70px rgba(0,0,0,.55), 0 0 0 1px rgba(227,6,19,.04);
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 18px; right: 18px;
            height: 3px;
            border-radius: 0 0 4px 4px;
            background: linear-gradient(90deg, transparent, var(--red), transparent);
        }

        .login-head { text-align: center; margin-bottom: 26px; }
        .login-head h1 {
            font-family: 'Anton', sans-serif;
            font-size: 30px;
            letter-spacing: .04em;
            margin: 0 0 6px;
            color: var(--white);
            text-transform: uppercase;
        }
        .login-head p {
            margin: 0;
            font-size: 13px;
            color: var(--muted);
        }

        .field-label {
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 7px;
            display: block;
        }

        .field-wrap { position: relative; margin-bottom: 18px; }
        .field-wrap i.field-ico {
            position: absolute;
            left: 15px; top: 50%;
            transform: translateY(-50%);
            color: #55555d;
            font-size: 13px;
            pointer-events: none;
            transition: color .15s ease;
        }
        .field-wrap input {
            width: 100%;
            background: #0f0f12;
            border: 1.5px solid var(--line);
            color: var(--white);
            border-radius: 10px;
            padding: 12px 14px 12px 40px;
            font-size: 14px;
            font-family: 'Manrope', sans-serif;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .field-wrap input::placeholder { color: #4d4d55; }
        .field-wrap input:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(227,6,19,.15);
        }
        .field-wrap input:focus ~ i.field-ico { color: var(--red); }
        .field-wrap input.is-invalid { border-color: #ef4444; }

        .toggle-eye {
            position: absolute;
            right: 6px; top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #6b6b73;
            width: 34px; height: 34px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: color .15s ease, background .15s ease;
        }
        .toggle-eye:hover { color: var(--white); background: rgba(255,255,255,.06); }

        .field-error {
            font-size: 12px;
            color: #ef4444;
            margin-top: 6px;
            font-weight: 600;
        }

        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4px 0 22px;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            color: var(--muted);
        }
        .remember-check input {
            width: 15px; height: 15px;
            accent-color: var(--red);
            cursor: pointer;
        }
        .remember-check label { cursor: pointer; user-select: none; }

        .btn-signin {
            width: 100%;
            background: linear-gradient(135deg, var(--red) 0%, var(--red-deep) 100%);
            border: none;
            color: #fff;
            font-family: 'Anton', sans-serif;
            letter-spacing: .06em;
            font-size: 15px;
            text-transform: uppercase;
            padding: 13px;
            border-radius: 10px;
            cursor: pointer;
            transition: transform .12s ease, box-shadow .2s ease, filter .2s ease;
            box-shadow: 0 10px 24px rgba(227,6,19,.28);
        }
        .btn-signin:hover { filter: brightness(1.08); box-shadow: 0 12px 30px rgba(227,6,19,.4); }
        .btn-signin:active { transform: translateY(1px); }

        .foot-note {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            letter-spacing: .05em;
            color: #4d4d55;
            text-transform: uppercase;
        }

        @media (max-width: 420px) {
            .login-card { padding: 30px 22px 24px; border-radius: 14px; }
            .login-head h1 { font-size: 26px; }
        }
    </style>
</head>

<body>

    <div class="stage">
        <div class="ember ember--a"></div>
        <div class="ember ember--b"></div>
        <div class="tread tread--tl"></div>
        <div class="tread tread--br"></div>
        <div class="sweep"></div>
    </div>

    <div class="center-wrap">
        <div class="login-col">

            <div class="brand-tag-wrap">
                <div class="brand-tag">
                    <i class="fa-solid fa-shoe-prints"></i>
                    <span>Multi-Brand Footwear</span>
                </div>
                <div class="stitch"></div>
            </div>

            <div class="login-card">
                <div class="login-head">
                    <h1>Admin Sign In</h1>
                    <p>Enter your credentials to access the dashboard</p>
                </div>

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-1">
                        <label class="field-label">Email</label>
                        <div class="field-wrap">
                            <i class="fa-solid fa-envelope field-ico"></i>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="@error('email') is-invalid @enderror"
                                placeholder="you@company.com" autofocus autocomplete="username">
                        </div>
                        @error('email')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-1">
                        <label class="field-label">Password</label>
                        <div class="field-wrap">
                            <i class="fa-solid fa-lock field-ico"></i>
                            <input type="password" name="password" id="passwordField"
                                class="@error('password') is-invalid @enderror"
                                placeholder="••••••••" autocomplete="current-password">
                            <button type="button" class="toggle-eye" id="togglePassword" aria-label="Show password">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row-between">
                        <div class="remember-check">
                            <input type="checkbox" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="rememberMe">Remember me</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-signin">Sign In</button>
                </form>
            </div>

            <p class="foot-note">Secure Admin Access</p>

        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const field = document.getElementById('passwordField');
            const icon  = this.querySelector('i');
            const isPw  = field.type === 'password';
            field.type  = isPw ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
            this.setAttribute('aria-label', isPw ? 'Hide password' : 'Show password');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>