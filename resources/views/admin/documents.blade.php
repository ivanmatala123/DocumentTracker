<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Management — Document Tracker</title>
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
        .card { border: none !important; border-radius: 20px !important; box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important; }
        .btn-primary { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%); border: none; font-weight: 600; }
        .btn-primary:hover { background: linear-gradient(135deg, #d97200 0%, #d9a500 100%); }
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
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.users') }}" class="nav-link">
                                <i class="fas fa-users"></i> Users
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.documents') }}" class="nav-link active">
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
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="fas fa-file-alt"></i> Documents Management</h5>
                        <span class="badge bg-secondary fs-6">{{ $documents->count() }} total</span>
                    </div>

                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr>
                                <td>{{ $doc->id }}</td>
                                <td>{{ $doc->user->name ?? 'N/A' }}</td>
                                <td class="fw-semibold">{{ $doc->title }}</td>
                                <td>
                                    @php
                                        $typeIcons = [
                                            'PDF'   => ['icon' => 'fa-file-pdf',   'color' => 'text-danger'],
                                            'Word'  => ['icon' => 'fa-file-word',  'color' => 'text-primary'],
                                            'Excel' => ['icon' => 'fa-file-excel', 'color' => 'text-success'],
                                            'Image' => ['icon' => 'fa-file-image', 'color' => 'text-info'],
                                            'Other' => ['icon' => 'fa-file',       'color' => 'text-secondary'],
                                        ];
                                        $ti = $typeIcons[$doc->type] ?? $typeIcons['Other'];
                                    @endphp
                                    <i class="fas {{ $ti['icon'] }} {{ $ti['color'] }} me-1"></i>{{ $doc->type }}
                                </td>
                                <td>{{ $doc->description ?? '—' }}</td>
                                <td>
                                    @php
                                        $badges = [
                                            'pending'   => 'bg-warning text-dark',
                                            'in-review' => 'bg-info',
                                            'approved'  => 'bg-success',
                                            'rejected'  => 'bg-danger',
                                        ];
                                        $badge = $badges[$doc->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ ucfirst($doc->status) }}</span>
                                </td>
                                <td>{{ $doc->due_date ? $doc->due_date->format('M d, Y') : '—' }}</td>
                                <td>{{ $doc->created_at->format('M d, Y') }}</td>
                                <td>
                                    <!-- Update Status -->
                                    <button class="btn btn-sm btn-info status-btn"
                                        data-id="{{ $doc->id }}"
                                        data-title="{{ $doc->title }}"
                                        data-status="{{ $doc->status }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#statusModal">
                                        <i class="fas fa-sync-alt"></i> Status
                                    </button>
                                    <!-- Delete -->
                                    <button class="btn btn-sm btn-danger delete-btn"
                                        data-id="{{ $doc->id }}"
                                        data-title="{{ $doc->title }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteDocumentModal">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="fas fa-folder-open fa-3x d-block mb-3" style="color:#ddd"></i>
                                    No documents submitted yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:linear-gradient(135deg,#F48200 0%,#F6BB0A 100%)">
                    <h5 class="modal-title text-white"><i class="fas fa-sync-alt"></i> Update Document Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="statusForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p class="fw-semibold mb-3" id="status_doc_title"></p>
                        <div class="mb-3">
                            <label class="form-label fw-bold">New Status</label>
                            <select name="status" id="status_select" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="in-review">In Review</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Document Modal -->
    <div class="modal fade" id="deleteDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white"><i class="fas fa-trash"></i> Delete Document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p class="fs-5">Are you sure you want to delete</p>
                    <p class="fw-bold fs-4" id="delete_title"></p>
                    <p class="text-muted">This action cannot be undone!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" id="deleteDocumentForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.querySelectorAll('.status-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('status_doc_title').textContent = this.dataset.title;
                document.getElementById('status_select').value = this.dataset.status;
                document.getElementById('statusForm').action = '/admin/documents/' + this.dataset.id + '/status';
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('delete_title').textContent = this.dataset.title;
                document.getElementById('deleteDocumentForm').action = '/admin/documents/' + this.dataset.id;
            });
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
