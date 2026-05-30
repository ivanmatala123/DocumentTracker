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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="text-white mb-0">Create Account ✨</h3>
                        <p class="text-white-50 mt-1">Register a new account</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                    value="{{ old('name') }}" placeholder="Enter your full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                    value="{{ old('email') }}" placeholder="Enter your email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Create a password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" 
                                    placeholder="Confirm your password" required>
                            </div>
                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold">Create Account</button>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p class="mb-0">Already have an account? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #667eea">Login here</a>
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