<!DOCTYPE html>
<html lang="en">

@php
    $totalUsers   = $totalUsers   ?? 0;
    $totalDocs    = $totalDocs    ?? 0;
    $approvedDocs = $approvedDocs ?? 0;
    $pendingDocs  = $pendingDocs  ?? 0;
    $rejectedDocs = $rejectedDocs ?? 0;
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Document Tracker</title>
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
        .user-chip { display: flex; align-items: center; gap: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 50px; padding: 6px 14px 6px 6px; cursor: pointer; }
        .user-avatar { width: 30px; height: 30px; background: linear-gradient(135deg, #F48200, #F6BB0A); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.78rem; }
        .user-name { font-size: 0.82rem; font-weight: 600; color: #1e293b; }
        .content { padding: 26px 28px; flex: 1; }
        .welcome-banner { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%); border-radius: 16px; padding: 24px 28px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; }
        .welcome-banner h4 { color: #fff; font-weight: 700; margin: 0 0 4px; font-size: 1.1rem; }
        .welcome-banner p { color: rgba(255,255,255,0.75); margin: 0; font-size: 0.85rem; }
        .stat-card { background: #fff; border-radius: 14px; padding: 20px; border-left: 4px solid #e2e8f0; box-shadow: 0 1px 6px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card.orange { border-left-color: #F48200; }
        .stat-card.amber { border-left-color: #F6BB0A; }
        .stat-card.green { border-left-color: #22c55e; }
        .stat-card.red { border-left-color: #ef4444; }
        .stat-card.blue { border-left-color: #3b82f6; }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 1rem; }
        .stat-icon.orange { background: #fff7ed; color: #F48200; }
        .stat-icon.amber { background: #fffbeb; color: #d97706; }
        .stat-icon.green { background: #f0fdf4; color: #22c55e; }
        .stat-icon.red { background: #fef2f2; color: #ef4444; }
        .stat-icon.blue { background: #eff6ff; color: #3b82f6; }
        .stat-num { font-size: 1.9rem; font-weight: 800; color: #1e293b; line-height: 1; }
        .stat-label { font-size: 0.78rem; color: #94a3b8; font-weight: 500; margin-top: 4px; }
        .table-card { background: #fff; border-radius: 14px; box-shadow: 0 1px 6px rgba(0,0,0,0.05); overflow: hidden; }
        .table-card-header { padding: 18px 22px; border-bottom: 1px solid #f1f5f9; }
        .table-card-header h6 { font-weight: 700; color: #1e293b; margin: 0; font-size: 0.95rem; }
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
            <a href="{{ route('dashboard') }}" class="nav-link active"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('admin.users') }}" class="nav-link"><i class="fas fa-users"></i> Users</a>
            <a href="{{ route('admin.documents') }}" class="nav-link"><i class="fas fa-file-alt"></i> Documents</a>
            <a href="{{ route('admin.profile') }}" class="nav-link"><i class="fas fa-user-cog"></i> Profile</a>
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
                <p class="page-title">Admin Dashboard</p>
                <p class="breadcrumb-text">Overview & Analytics</p>
            </div>
            <div class="user-chip dropdown" data-bs-toggle="dropdown">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down" style="font-size:0.65rem;color:#94a3b8;"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:12px;font-size:0.85rem;">
                <li><a class="dropdown-item py-2" href="{{ route('admin.profile') }}"><i class="fas fa-user-cog me-2 text-muted"></i>Profile</a></li>
                <li><hr class="dropdown-divider my-1"></li>
                <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button></form></li>
            </ul>
        </div>

        <div class="content">
            <div class="welcome-banner">
                <div>
                    <h4>Welcome back, {{ auth()->user()->name }}! 👋</h4>
                    <p>Here's what's happening with your platform today.</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6 col-md">
                    <div class="stat-card blue">
                        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                        <div class="stat-num">{{ $totalUsers }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                </div>
                <div class="col-6 col-md">
                    <div class="stat-card orange">
                        <div class="stat-icon orange"><i class="fas fa-folder-open"></i></div>
                        <div class="stat-num">{{ $totalDocs }}</div>
                        <div class="stat-label">Total Documents</div>
                    </div>
                </div>
                <div class="col-6 col-md">
                    <div class="stat-card green">
                        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-num">{{ $approvedDocs }}</div>
                        <div class="stat-label">Approved</div>
                    </div>
                </div>
                <div class="col-6 col-md">
                    <div class="stat-card amber">
                        <div class="stat-icon amber"><i class="fas fa-clock"></i></div>
                        <div class="stat-num">{{ $pendingDocs }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
                <div class="col-6 col-md">
                    <div class="stat-card red">
                        <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
                        <div class="stat-num">{{ $rejectedDocs }}</div>
                        <div class="stat-label">Rejected</div>
                    </div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-card-header">
                    <h6><i class="fas fa-chart-bar me-2" style="color:#F48200;"></i>Document Overview</h6>
                </div>
                <div class="p-4">
                    <canvas id="myChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Users', 'Total Documents', 'Approved', 'Pending', 'Rejected'],
                datasets: [{
                    label: 'Count',
                    data: [{{ intval($totalUsers) }},{{ intval($totalDocs) }},{{ intval($approvedDocs) }},{{ intval($pendingDocs) }},{{ intval($rejectedDocs) }}],
                    backgroundColor: ['rgba(59,130,246,0.8)','rgba(244,130,0,0.8)','rgba(34,197,94,0.8)','rgba(246,187,10,0.8)','rgba(239,68,68,0.8)'],
                    borderRadius: 8, borderSkipped: false,
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } } }
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
