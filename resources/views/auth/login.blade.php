<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Document Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { min-height: 100vh; display: flex; }

        /* ── Left panel ── */
        .left-panel {
            width: 45%;
            min-height: 100vh;
            background: #1e293b;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 3.5rem;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            background: rgba(244,130,0,0.12);
            border-radius: 50%;
            top: -100px; right: -100px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 250px; height: 250px;
            background: rgba(246,187,10,0.08);
            border-radius: 50%;
            bottom: -80px; left: -80px;
        }
        .left-inner { position: relative; z-index: 2; text-align: center; width: 100%; }
        .brand-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #F48200, #F6BB0A);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 24px rgba(244,130,0,0.3);
        }
        .left-inner h1 {
            color: #fff;
            font-weight: 800;
            font-size: 1.9rem;
            margin-bottom: 0.75rem;
            letter-spacing: -0.3px;
        }
        .left-inner p {
            color: rgba(255,255,255,0.55);
            font-size: 0.92rem;
            line-height: 1.8;
            max-width: 300px;
            margin: 0 auto;
        }
        .feature-pills {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }
        .pill {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50px;
            padding: 7px 16px;
            color: rgba(255,255,255,0.7);
            font-size: 0.78rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .pill i { color: #F48200; }

        /* ── Right panel ── */
        .right-panel {
            width: 55%;
            min-height: 100vh;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 3.5rem;
        }
        .form-wrap { width: 100%; max-width: 400px; }

        /* Heading block */
        .form-wrap h2 {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.75rem;
            margin-bottom: 0.35rem;
            letter-spacing: -0.3px;
        }
        .form-wrap .sub {
            color: #94a3b8;
            font-size: 0.875rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Form fields */
        .field-group { margin-bottom: 1.1rem; }
        .field-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            display: block;
            letter-spacing: 0.2px;
        }
        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #cbd5e1;
            font-size: 0.82rem;
            pointer-events: none;
        }
        .input-wrap input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.88rem;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .input-wrap input::placeholder { color: #b0bec5; }
        .input-wrap input:focus {
            border-color: #F48200;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(244,130,0,0.1);
        }
        .input-wrap input.is-invalid { border-color: #ef4444; background: #fff5f5; }
        .invalid-feedback { color: #ef4444; font-size: 0.76rem; margin-top: 5px; display: flex; align-items: center; gap: 4px; }

        /* Remember me */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.4rem;
        }
        .remember-row input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: #F48200;
            cursor: pointer;
            flex-shrink: 0;
        }
        .remember-row label {
            font-size: 0.83rem;
            color: #64748b;
            cursor: pointer;
            line-height: 1;
        }

        /* Submit button */
        .btn-sign {
            width: 100%;
            background: linear-gradient(135deg, #F48200, #F6A623);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            font-size: 0.92rem;
            letter-spacing: 0.2px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }
        .btn-sign:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-sign:active { transform: translateY(0); }

        /* Divider + bottom link */
        .divider {
            text-align: center;
            color: #cbd5e1;
            font-size: 0.78rem;
            margin: 1.5rem 0;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 44%;
            height: 1px;
            background: #e2e8f0;
        }
        .divider::before { left: 0; }
        .divider::after { right: 0; }
        .register-link { text-align: center; font-size: 0.85rem; color: #64748b; }
        .register-link a { color: #F48200; font-weight: 600; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 2rem; }
        }
    </style>
</head>
<body>
    <div class="left-panel">
        <div class="left-inner">
            <div class="brand-icon">📄</div>
            <h1>Document Tracker</h1>
            <p>The smartest way to submit, track, and manage your documents — all in one place.</p>
            <div class="feature-pills">
                <span class="pill"><i class="fas fa-bolt"></i> Fast Approvals</span>
                <span class="pill"><i class="fas fa-shield-alt"></i> Secure</span>
                <span class="pill"><i class="fas fa-chart-line"></i> Real-time Tracking</span>
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="form-wrap">
            <h2>Welcome back 👋</h2>
            <p class="sub">Sign in to continue to your dashboard</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field-group">
                    <label class="field-label">Email Address</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="@error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="you@example.com" required>
                    </div>
                    @error('email')<div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>

                <div class="field-group">
                    <label class="field-label">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="@error('password') is-invalid @enderror"
                            placeholder="Enter your password" required>
                    </div>
                    @error('password')<div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn-sign">Sign In</button>
            </form>

            <div class="divider">or</div>
            <p class="register-link">Don't have an account? <a href="{{ route('register') }}">Create one here</a></p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
