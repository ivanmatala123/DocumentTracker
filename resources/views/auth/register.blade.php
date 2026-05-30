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
        .left-panel {
            width: 45%;
            min-height: 100vh;
            background: #1e293b;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
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
        .left-inner { position: relative; z-index: 2; text-align: center; }
        .brand-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #F48200, #F6BB0A);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        .left-inner h1 { color: #fff; font-weight: 800; font-size: 1.9rem; margin-bottom: 0.75rem; }
        .left-inner p { color: rgba(255,255,255,0.55); font-size: 0.92rem; line-height: 1.8; max-width: 300px; }
        .steps { margin-top: 2.5rem; text-align: left; }
        .step { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 1.2rem; }
        .step-num { width: 28px; height: 28px; background: #F48200; border-radius: 50%; color: #fff; font-size: 0.78rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
        .step-text { color: rgba(255,255,255,0.65); font-size: 0.84rem; line-height: 1.5; }
        .step-text strong { color: rgba(255,255,255,0.9); display: block; font-size: 0.88rem; }
        .right-panel {
            width: 55%;
            min-height: 100vh;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }
        .form-wrap { width: 100%; max-width: 420px; }
        .form-wrap h2 { font-weight: 700; color: #1e293b; font-size: 1.7rem; margin-bottom: 0.3rem; }
        .form-wrap .sub { color: #94a3b8; font-size: 0.88rem; margin-bottom: 2rem; }
        .field-label { font-size: 0.82rem; font-weight: 600; color: #475569; margin-bottom: 6px; display: block; }
        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #cbd5e1; font-size: 0.85rem; }
        .input-wrap input {
            width: 100%;
            padding: 11px 14px 11px 38px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #1e293b;
            outline: none;
            transition: border-color 0.2s;
        }
        .input-wrap input:focus { border-color: #F48200; box-shadow: 0 0 0 3px rgba(244,130,0,0.1); }
        .input-wrap input.is-invalid { border-color: #ef4444; }
        .invalid-feedback { color: #ef4444; font-size: 0.78rem; margin-top: 4px; }
        .btn-sign { width: 100%; background: #F48200; color: #fff; border: none; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 0.95rem; cursor: pointer; transition: background 0.2s; margin-top: 0.5rem; }
        .btn-sign:hover { background: #d97200; }
        .login-link { text-align: center; font-size: 0.87rem; color: #64748b; margin-top: 1.5rem; }
        .login-link a { color: #F48200; font-weight: 600; text-decoration: none; }
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
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
                <div class="mb-3">
                    <label class="field-label">Full Name</label>
                    <div class="input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" class="@error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Juan dela Cruz" required>
                    </div>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="field-label">Email Address</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" class="@error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="you@example.com" required>
                    </div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="field-label">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" class="@error('password') is-invalid @enderror"
                            placeholder="Create a strong password" required>
                    </div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
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
