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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #fffbf0; margin: 0; padding: 0; }
        .navbar { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%) !important; padding: 12px 20px; box-shadow: 0 2px 15px rgba(244,130,0,0.35); }
        .navbar-brand, .navbar .nav-link { color: #fff !important; font-weight: 600; }
        .sidebar { background: white; border-radius: 20px; box-shadow: 0 2px 15px rgba(0,0,0,0.08); min-height: 85vh; position: sticky; top: 20px; border-top: 4px solid #F48200; }
        .sidebar .nav-link { color: #555 !important; border-radius: 10px; padding: 10px 15px; margin-bottom: 5px; font-weight: 500; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%); color: white !important; }
        .welcome-card { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%); border-radius: 20px; color: white; box-shadow: 0 5px 20px rgba(244,130,0,0.4); }
        .stat-card { border: none !important; border-radius: 20px !important; box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important; transition: transform 0.2s; border-top: 4px solid #F6BB0A !important; }
        .stat-card:hover { transform: translateY(-6px); box-shadow: 0 8px 25px rgba(244,130,0,0.2) !important; }
        .card { border: none !important; border-radius: 20px !important; box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important; }
        .btn-primary { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%); border: none; font-weight: 600; }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">📄 Document Tracker</a>
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
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
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

    <div class="container-fluid mt-4">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2">
                <div class="sidebar p-3">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('dashboard') }}" class="nav-link active">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.users') }}" class="nav-link">
                                <i class="fas fa-users"></i> Users
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.documents') }}" class="nav-link">
                                <i class="fas fa-file-alt"></i> Documents
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.profile') }}" class="nav-link">
                                <i class="fas fa-user"></i> Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-10">

                <!-- Welcome -->
                <div class="welcome-card p-4 mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">Welcome back, <strong>{{ auth()->user()->name }}</strong>!</h4>
                        <p class="mb-0 mt-1 text-white-50">Here's an overview of the Document Tracker.</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-light fw-bold">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card p-3 text-center">
                            <i class="fas fa-users fa-2x mb-2" style="color:#667eea"></i>
                            <h3 class="fw-bold">{{ $totalUsers }}</h3>
                            <p class="text-muted mb-0">Total Users</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 text-center">
                            <i class="fas fa-folder-open fa-2x mb-2" style="color:#667eea"></i>
                            <h3 class="fw-bold">{{ $totalDocs }}</h3>
                            <p class="text-muted mb-0">Total Documents</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 text-center">
                            <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                            <h3 class="fw-bold">{{ $approvedDocs }}</h3>
                            <p class="text-muted mb-0">Approved</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 text-center">
                            <i class="fas fa-clock fa-2x mb-2 text-warning"></i>
                            <h3 class="fw-bold">{{ $pendingDocs }}</h3>
                            <p class="text-muted mb-0">Pending Review</p>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="card p-4">
                    <h5 class="fw-bold mb-3">📊 Document Overview</h5>
                    <canvas id="myChart"></canvas>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Users', 'Total Documents', 'Approved', 'Pending', 'Rejected'],
                datasets: [{
                    label: 'Count',
                    data: [
                        {{ intval($totalUsers) }},
                        {{ intval($totalDocs) }},
                        {{ intval($approvedDocs) }},
                        {{ intval($pendingDocs) }},
                        {{ intval($rejectedDocs) }}
                    ],
                    backgroundColor: [
                        'rgba(102,126,234,0.7)',
                        'rgba(118,75,162,0.7)',
                        'rgba(40,167,69,0.7)',
                        'rgba(255,193,7,0.7)',
                        'rgba(220,53,69,0.7)',
                    ],
                    borderRadius: 10,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
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
