<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="text-white mb-0">Welcome Back 👋</h3>
                        <p class="text-white-50 mt-1">Login to your account</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email') }}" placeholder="Enter your email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Enter your password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>
                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold">Login</button>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p class="mb-0">Don't have an account?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #667eea">Register here</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>