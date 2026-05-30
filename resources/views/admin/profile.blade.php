<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile — Document Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { background: #f1f5f9; margin: 0; }
        .sidebar { width: 240px; min-height: 100vh; background: #1e293b; position: fixed; left: 0; top: 0; z-index: 100; display: flex; flex-direction: column; }
        .sidebar-brand { padding: 22px 20px; border-bottom: 1px solid rgba(255,255,255,0.07); display: flex; align-items: center; gap: 10px; }
        .sidebar-brand .icon { width: 36px; height: 36px; background: linear-gradient(135deg, #F48200, #F6BB0A); border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .sidebar-brand span { color: #fff; font-weight: 700; font-size: 0.95rem; }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-label { color: rgba(255,255,255,0.25); font-size: 0.68rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; padding: 0 10px; margin: 10px 0 6px; }
        .sidebar-nav .nav-link { color: rgba(255,255,255,0.55); border-radius: 10px; padding: 10px 14px; margin-bottom: 2px; font-size: 0.87rem; font-weight: 500; display: flex; align-items: center; gap: 10px; transition: all 0.2s; text-decoration: none; }
        .sidebar-nav .nav-link i { width: 17px; text-align: center; font-size: 0.88rem; }
        .sidebar-nav .nav-link:hover { background: rgba(255,255,255,0.07); color: #fff; }
        .sidebar-nav .nav-link.active { background: #F48200; color: #fff !important; }
        .sidebar-footer { padding: 14px 12px; border-top: 1px solid rgba(255,255,255,0.07); }
        .sidebar-footer form button { width: 100%; background: rgba(255,255,255,0.06); border: none; border-radius: 10px; padding: 10px 14px; color: rgba(255,255,255,0.55); font-size: 0.87rem; font-weight: 500; text-align: left; display: flex; align-items: center; gap: 10px; cursor: pointer; transition: all 0.2s; }
        .sidebar-footer form button:hover { background: rgba(239,68,68,0.15); color: #ef4444; }
        .main { margin-left: 240px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; padding: 14px 28px; border-bottom: 1px solid #e8edf2; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 50; }
        .topbar .page-title { font-weight: 700; font-size: 1.05rem; color: #1e293b; margin: 0; }
        .topbar .breadcrumb-text { font-size: 0.78rem; color: #94a3b8; margin: 0; }
        .user-chip { display: flex; align-items: center; gap: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 50px; padding: 6px 14px 6px 6px; }
        .user-avatar-sm { width: 30px; height: 30px; background: linear-gradient(135deg, #F48200, #F6BB0A); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.78rem; }
        .user-name { font-size: 0.82rem; font-weight: 600; color: #1e293b; }
        .content { padding: 26px 28px; flex: 1; }
        .profile-card { background: #fff; border-radius: 16px; box-shadow: 0 1px 6px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 24px; }
        .profile-banner { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%); height: 100px; position: relative; }
        .profile-body { padding: 0 28px 28px; }
        .avatar-wrap { position: relative; display: inline-block; margin-top: -45px; margin-bottom: 12px; }
        .avatar-img { width: 90px; height: 90px; border-radius: 50%; border: 4px solid #fff; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
        .avatar-placeholder { width: 90px; height: 90px; border-radius: 50%; border: 4px solid #fff; background: #1e293b; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
        .avatar-upload-btn { position: absolute; bottom: 2px; right: 2px; width: 26px; height: 26px; background: #F48200; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.7rem; cursor: pointer; border: 2px solid #fff; }
        .profile-name { font-size: 1.2rem; font-weight: 700; color: #1e293b; margin: 0; }
        .profile-email { font-size: 0.85rem; color: #94a3b8; margin: 2px 0 10px; }
        .info-card { background: #fff; border-radius: 16px; box-shadow: 0 1px 6px rgba(0,0,0,0.05); padding: 24px; height: 100%; }
        .section-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: #94a3b8; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .section-label::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }
        .info-row { margin-bottom: 14px; }
        .info-row-label { font-size: 0.72rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .info-row-value { font-size: 0.9rem; font-weight: 600; color: #1e293b; }
        .form-label { font-size: 0.82rem; font-weight: 600; color: #475569; }
        .form-control { border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.88rem; padding: 10px 14px; }
        .form-control:focus { border-color: #F48200; box-shadow: 0 0 0 3px rgba(244,130,0,0.1); }
        .btn-save { background: #F48200; color: #fff; border: none; border-radius: 10px; padding: 10px 24px; font-weight: 600; font-size: 0.88rem; cursor: pointer; }
        .btn-save:hover { background: #d97200; }
        .btn-back { background: #f1f5f9; color: #64748b; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 600; font-size: 0.88rem; cursor: pointer; text-decoration: none; }
        .btn-back:hover { background: #e2e8f0; color: #475569; }
        .overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 99; }
        .overlay.show { display: block; }
        .burger-btn { display: none; background: none; border: none; cursor: pointer; padding: 7px 9px; border-radius: 8px; color: #1e293b; line-height: 1; }
        .burger-btn:hover { background: #f1f5f9; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-240px); transition: transform 0.28s cubic-bezier(.4,0,.2,1); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .burger-btn { display: inline-flex; }
        }
    </style>
</head>
<body>
    <div class="overlay" id="overlay"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="icon">📄</div>
            <span>DocTracker</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Admin Panel</div>
            <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('admin.users') }}" class="nav-link"><i class="fas fa-users"></i> Users</a>
            <a href="{{ route('admin.documents') }}" class="nav-link"><i class="fas fa-file-alt"></i> Documents</a>
            <a href="{{ route('admin.profile') }}" class="nav-link active"><i class="fas fa-user-cog"></i> Profile</a>
            <div class="nav-label">Switch</div>
            <a href="{{ route('user.dashboard') }}" class="nav-link"><i class="fas fa-user"></i> User View</a>
        </nav>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <button class="burger-btn" id="burgerBtn"><i class="fas fa-bars" style="font-size:1.15rem;"></i></button>
            <div>
                <p class="page-title">Admin Profile</p>
                <p class="breadcrumb-text">Account settings & information</p>
            </div>
            <div class="user-chip">
                <div class="user-avatar-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>
        </div>

        <div class="content">
            <!-- Profile Header -->
            <div class="profile-card">
                <div class="profile-banner"></div>
                <div class="profile-body">
                    <div class="d-flex align-items-end justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-end gap-3">
                            <form method="POST" action="{{ route('admin.profile.photo') }}" enctype="multipart/form-data" id="photoForm">
                                @csrf
                                <div class="avatar-wrap">
                                    @if($user->profile_photo)
                                        <img src="{{ asset('uploads/profiles/' . $user->profile_photo) }}" class="avatar-img" id="avatarPreview" alt="Avatar">
                                    @else
                                        <div class="avatar-placeholder" id="avatarPlaceholder"><i class="fas fa-user"></i></div>
                                        <img src="" class="avatar-img d-none" id="avatarPreview" alt="Avatar">
                                    @endif
                                    <label class="avatar-upload-btn" for="photoInput" title="Change photo"><i class="fas fa-camera"></i></label>
                                    <input type="file" name="photo" id="photoInput" accept="image/*" class="d-none">
                                </div>
                            </form>
                            <div class="pb-1">
                                <p class="profile-name">{{ $user->name }}</p>
                                <p class="profile-email">{{ $user->email }}</p>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-danger">{{ ucfirst($user->role) }}</span>
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($user->status) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-4 pb-2">
                            <div class="text-center">
                                <div style="font-size:1.6rem;font-weight:800;color:#F48200;">{{ $docCount }}</div>
                                <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;">TOTAL DOCS</div>
                            </div>
                            <div class="text-center">
                                <div style="font-size:1.6rem;font-weight:800;color:#22c55e;">{{ $approvedCount }}</div>
                                <div style="font-size:0.72rem;color:#94a3b8;font-weight:600;">APPROVED</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Account Details -->
                <div class="col-12 col-md-4">
                    <div class="info-card">
                        <div class="section-label"><i class="fas fa-id-card" style="color:#F48200;"></i> Account Details</div>
                        <div class="info-row">
                            <div class="info-row-label">User ID</div>
                            <div class="info-row-value">#{{ $user->id }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-row-label">Full Name</div>
                            <div class="info-row-value">{{ $user->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-row-label">Email</div>
                            <div class="info-row-value" style="word-break:break-all;">{{ $user->email }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-row-label">Role</div>
                            <div class="info-row-value"><span class="badge bg-danger">{{ ucfirst($user->role) }}</span></div>
                        </div>
                        <div class="info-row">
                            <div class="info-row-label">Status</div>
                            <div class="info-row-value"><span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($user->status) }}</span></div>
                        </div>
                        <div class="info-row">
                            <div class="info-row-label">Member Since</div>
                            <div class="info-row-value">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                        @if($docCount > 0)
                        <div class="info-row mb-0">
                            <div class="info-row-label mb-1">Approval Rate</div>
                            <div class="progress" style="height:6px;border-radius:10px;">
                                <div class="progress-bar bg-success" style="width:{{ round(($approvedCount / $docCount) * 100) }}%"></div>
                            </div>
                            <div style="font-size:0.72rem;color:#94a3b8;margin-top:4px;">{{ $approvedCount }}/{{ $docCount }} approved</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Edit Profile -->
                <div class="col-12 col-md-8">
                    <div class="info-card">
                        <div class="section-label"><i class="fas fa-edit" style="color:#F48200;"></i> Edit Profile</div>
                        <form method="POST" action="{{ route('admin.profile.update') }}">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <hr class="my-4" style="border-color:#f1f5f9;">
                            <div class="mb-3">
                                <label class="form-label">New Password <span class="text-muted fw-normal">(leave blank to keep current)</span></label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-save"><i class="fas fa-save me-1"></i> Save Changes</button>
                                <a href="{{ route('dashboard') }}" class="btn-back"><i class="fas fa-arrow-left me-1"></i> Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
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
    <script>toastr.options={closeButton:true,progressBar:true,positionClass:"toast-top-right",timeOut:"3000"};toastr.success("{{ session('toast_success') }}");</script>
    @endif
    @if(session('toast_error'))
    <script>toastr.options={closeButton:true,progressBar:true,positionClass:"toast-top-right",timeOut:"3000"};toastr.error("{{ session('toast_error') }}");</script>
    @endif
    <script>
        const burger = document.getElementById('burgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        burger.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('show'); });
        overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('show'); });
    </script>
</body>
</html>
