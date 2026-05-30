<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile — Document Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6fb; margin: 0; padding: 0; }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; padding: 12px 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.15); }
        .navbar-brand, .nav-link { color: white !important; }
        .card { border: none !important; border-radius: 15px !important; box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important; }
    </style>
    <style>
        .profile-avatar {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #667eea;
            box-shadow: 0 4px 15px rgba(102,126,234,0.4);
        }
        .profile-avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            color: white;
            border: 4px solid #667eea;
            box-shadow: 0 4px 15px rgba(102,126,234,0.4);
        }
        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #888;
            font-weight: 600;
        }
        .info-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #333;
        }
        .stat-pill {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50px;
            padding: 6px 20px;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #444;
            border-left: 4px solid #667eea;
            padding-left: 10px;
            margin-bottom: 1.2rem;
        }
        .photo-upload-area {
            position: relative;
            display: inline-block;
        }
        .photo-upload-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #667eea;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            font-size: 14px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold">📄 Document Tracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item active" href="{{ route('profile') }}">
                                <i class="fas fa-user"></i> Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 pb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">

                <!-- Profile Header Card -->
                <div class="card p-4 mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">

                        <!-- Avatar + Upload -->
                        <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" id="photoForm">
                            @csrf
                            <div class="photo-upload-area">
                                @if($user->profile_photo)
                                    <img src="{{ asset('uploads/profiles/' . $user->profile_photo) }}"
                                        class="profile-avatar" alt="Profile Photo" id="avatarPreview">
                                @else
                                    <div class="profile-avatar-placeholder" id="avatarPlaceholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <img src="" class="profile-avatar d-none" id="avatarPreview">
                                @endif
                                <label class="photo-upload-overlay" for="photoInput" title="Change photo">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" name="photo" id="photoInput" accept="image/*" class="d-none">
                            </div>
                        </form>

                        <!-- Basic Info -->
                        <div class="flex-grow-1">
                            <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-2">{{ $user->email }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-primary fs-6 px-3 py-2">
                                    <i class="fas fa-user-tag me-1"></i>{{ ucfirst($user->role) }}
                                </span>
                                <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }} fs-6 px-3 py-2">
                                    <i class="fas fa-circle me-1" style="font-size:8px;vertical-align:middle"></i>{{ ucfirst($user->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="text-center d-flex flex-md-column gap-3">
                            <div>
                                <div class="fw-bold fs-3 text-primary">{{ $docCount }}</div>
                                <div class="info-label">Total Docs</div>
                            </div>
                            <div>
                                <div class="fw-bold fs-3 text-success">{{ $approvedCount }}</div>
                                <div class="info-label">Approved</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Account Details Card -->
                    <div class="col-12 col-md-5">
                        <div class="card p-4 h-100">
                            <p class="section-title"><i class="fas fa-id-card me-1"></i> Account Details</p>
                            <div class="d-flex flex-column gap-3">
                                <div>
                                    <div class="info-label">User ID</div>
                                    <div class="info-value">#{{ $user->id }}</div>
                                </div>
                                <div>
                                    <div class="info-label">Full Name</div>
                                    <div class="info-value">{{ $user->name }}</div>
                                </div>
                                <div>
                                    <div class="info-label">Email Address</div>
                                    <div class="info-value">{{ $user->email }}</div>
                                </div>
                                <div>
                                    <div class="info-label">Role</div>
                                    <div class="info-value">
                                        <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="info-label">Account Status</div>
                                    <div class="info-value">
                                        <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="info-label">Member Since</div>
                                    <div class="info-value">{{ $user->created_at->format('F d, Y') }}</div>
                                </div>
                                <div>
                                    <div class="info-label">Documents Progress</div>
                                    <div class="info-value mb-1">{{ $approvedCount }} / {{ $docCount }} approved</div>
                                    @if($docCount > 0)
                                        <div class="progress" style="height:6px;border-radius:10px;">
                                            <div class="progress-bar bg-success" style="width:{{ round(($approvedCount / $docCount) * 100) }}%"></div>
                                        </div>
                                    @else
                                        <div class="progress" style="height:6px;border-radius:10px;">
                                            <div class="progress-bar bg-secondary" style="width:0%"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Profile Card -->
                    <div class="col-12 col-md-7">
                        <div class="card p-4 h-100">
                            <p class="section-title"><i class="fas fa-edit me-1"></i> Edit Profile</p>
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr class="my-3">

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        New Password
                                        <small class="text-muted fw-normal">(leave blank to keep current)</small>
                                    </label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter new password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Confirm New Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control" placeholder="Confirm new password">
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold flex-grow-1">
                                        <i class="fas fa-save me-1"></i> Save Changes
                                    </button>
                                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary fw-bold">
                                        <i class="fas fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Preview and auto-submit photo on file select
        document.getElementById('photoInput').addEventListener('change', function () {
            if (!this.files.length) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('avatarPreview');
                const placeholder = document.getElementById('avatarPlaceholder');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(this.files[0]);
            document.getElementById('photoForm').submit();
        });
    </script>

    @if(session('toast_success'))
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" }
        toastr.success("{{ session('toast_success') }}");
    </script>
    @endif

    @if(session('toast_error'))
    <script>
        toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": "3000" }
        toastr.error("{{ session('toast_error') }}");
    </script>
    @endif

</body>
</html>
