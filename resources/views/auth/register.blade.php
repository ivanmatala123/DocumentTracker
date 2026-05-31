<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Document Tracker</title>
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
        .steps { margin-top: 2.5rem; text-align: left; width: 100%; max-width: 280px; margin-left: auto; margin-right: auto; }
        .step { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 1.3rem; }
        .step:last-child { margin-bottom: 0; }
        .step-num {
            width: 28px; height: 28px;
            background: #F48200;
            border-radius: 50%;
            color: #fff;
            font-size: 0.78rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 2px;
            box-shadow: 0 2px 8px rgba(244,130,0,0.4);
        }
        .step-text { color: rgba(255,255,255,0.65); font-size: 0.84rem; line-height: 1.5; }
        .step-text strong { color: rgba(255,255,255,0.9); display: block; font-size: 0.87rem; margin-bottom: 1px; }

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
        .form-wrap { width: 100%; max-width: 420px; }

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
            margin-top: 0.4rem;
        }
        .btn-sign:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-sign:active { transform: translateY(0); }

        .login-link { text-align: center; font-size: 0.85rem; color: #64748b; margin-top: 1.5rem; }
        .login-link a { color: #F48200; font-weight: 600; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }

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
            <h1>Get Started Today</h1>
            <p>Create your account and start managing your documents in minutes.</p>
            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text"><strong>Create your account</strong>Fill in your details below</div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text"><strong>Submit documents</strong>Upload and track your files</div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text"><strong>Get approved</strong>Receive real-time status updates</div>
                </div>
            </div>
        </div>
    </div>

    <div class="right-panel">
        <div class="form-wrap">
            <h2>Create an account ✨</h2>
            <p class="sub">Join us and start tracking your documents</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="field-group">
                    <label class="field-label">Full Name</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" class="@error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Juan dela Cruz" required>
                    </div>
                    @error('name')<div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>

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
                            placeholder="Create a strong password" required>
                    </div>
                    @error('password')<div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                </div>

                <div class="field-group" style="margin-bottom: 1.4rem;">
                    <label class="field-label">Confirm Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Repeat your password" required>
                    </div>
                </div>

                <button type="submit" class="btn-sign">Create Account</button>
            </form>

            <p class="login-link">Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
