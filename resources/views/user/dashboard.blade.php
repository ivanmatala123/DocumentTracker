<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Document Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; box-sizing: border-box; }
        body { background: #f1f5f9; margin: 0; }

        /* Sidebar */
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

        /* Main */
        .main { margin-left: 240px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: #fff; padding: 14px 28px; border-bottom: 1px solid #e8edf2; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 50; }
        .topbar-left .page-title { font-weight: 700; font-size: 1.05rem; color: #1e293b; margin: 0; }
        .topbar-left .breadcrumb-text { font-size: 0.78rem; color: #94a3b8; margin: 0; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .user-chip { display: flex; align-items: center; gap: 10px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 50px; padding: 6px 14px 6px 6px; cursor: pointer; }
        .user-avatar { width: 30px; height: 30px; background: linear-gradient(135deg, #F48200, #F6BB0A); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.78rem; }
        .user-name { font-size: 0.82rem; font-weight: 600; color: #1e293b; }
        .content { padding: 26px 28px; flex: 1; }

        /* Banner */
        .welcome-banner { background: linear-gradient(135deg, #1e293b 0%, #334155 100%); border-radius: 16px; padding: 24px 28px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; }
        .welcome-banner h4 { color: #fff; font-weight: 700; margin: 0 0 4px; font-size: 1.1rem; }
        .welcome-banner p { color: rgba(255,255,255,0.5); margin: 0; font-size: 0.85rem; }
        .btn-add { background: #F48200; color: #fff; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 600; font-size: 0.87rem; cursor: pointer; display: flex; align-items: center; gap: 7px; white-space: nowrap; }
        .btn-add:hover { background: #d97200; }

        /* Stats */
        .stat-card { background: #fff; border-radius: 14px; padding: 20px; border-top: 3px solid #e2e8f0; box-shadow: 0 1px 6px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card.orange { border-top-color: #F48200; }
        .stat-card.amber { border-top-color: #F6BB0A; }
        .stat-card.green { border-top-color: #22c55e; }
        .stat-card.red { border-top-color: #ef4444; }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 1rem; }
        .stat-icon.orange { background: #fff7ed; color: #F48200; }
        .stat-icon.amber { background: #fffbeb; color: #F6BB0A; }
        .stat-icon.green { background: #f0fdf4; color: #22c55e; }
        .stat-icon.red { background: #fef2f2; color: #ef4444; }
        .stat-num { font-size: 1.9rem; font-weight: 800; color: #1e293b; line-height: 1; }
        .stat-label { font-size: 0.78rem; color: #94a3b8; font-weight: 500; margin-top: 4px; }

        /* Table card */
        .table-card { background: #fff; border-radius: 14px; box-shadow: 0 1px 6px rgba(0,0,0,0.05); overflow: hidden; }
        .table-card-header { padding: 18px 22px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
        .table-card-header h6 { font-weight: 700; color: #1e293b; margin: 0; font-size: 0.95rem; }
        .table { margin: 0; }
        .table thead th { background: #f8fafc; color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border: none; padding: 12px 16px; }
        .table tbody td { padding: 13px 16px; border-color: #f1f5f9; font-size: 0.87rem; color: #334155; vertical-align: middle; }
        .table tbody tr:hover { background: #fafbfc; }
        .badge-status { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.73rem; font-weight: 600; }
        .badge-pending { background: #fffbeb; color: #d97706; }
        .badge-approved { background: #f0fdf4; color: #16a34a; }
        .badge-rejected { background: #fef2f2; color: #dc2626; }
        .badge-review { background: #eff6ff; color: #2563eb; }
        .empty-state { text-align: center; padding: 50px 20px; color: #94a3b8; }
        .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 12px; color: #e2e8f0; }
        .empty-state p { margin: 0; font-size: 0.88rem; }

        /* Modals */
        .modal-header-orange { background: linear-gradient(135deg, #F48200, #F6BB0A); }
        .modal-content { border: none; border-radius: 16px; overflow: hidden; }
        .modal-header { border: none; padding: 18px 22px; }
        .modal-body { padding: 22px; }
        .modal-footer { border: none; padding: 14px 22px 18px; }
        .form-label { font-size: 0.82rem; font-weight: 600; color: #475569; }
        .form-control, .form-select { border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.88rem; padding: 10px 14px; }
        .form-control:focus, .form-select:focus { border-color: #F48200; box-shadow: 0 0 0 3px rgba(244,130,0,0.1); }
        .btn-orange { background: #F48200; color: #fff; border: none; border-radius: 8px; padding: 9px 18px; font-weight: 600; font-size: 0.87rem; }
        .btn-orange:hover { background: #d97200; color: #fff; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="icon">📄</div>
            <span>DocTracker</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Menu</div>
            <a href="{{ route('user.dashboard') }}" class="nav-link active">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('profile') }}" class="nav-link">
                <i class="fas fa-user"></i> My Profile
            </a>
        </nav>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="topbar">
            <div class="topbar-left">
                <p class="page-title">Dashboard</p>
                <p class="breadcrumb-text">My Documents</p>
            </div>
            <div class="topbar-right">
                <div class="user-chip dropdown" data-bs-toggle="dropdown">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down" style="font-size:0.65rem;color:#94a3b8;"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:12px;font-size:0.85rem;min-width:160px;">
                    <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fas fa-user me-2 text-muted"></i>Profile</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content">
            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div>
                    <h4>Hello, {{ auth()->user()->name }}! 👋</h4>
                    <p>Here's an overview of your submitted documents.</p>
                </div>
                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                    <i class="fas fa-plus"></i> Add Document
                </button>
            </div>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card orange">
                        <div class="stat-icon orange"><i class="fas fa-folder-open"></i></div>
                        <div class="stat-num">{{ $documents->count() }}</div>
                        <div class="stat-label">Total Documents</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card amber">
                        <div class="stat-icon amber"><i class="fas fa-clock"></i></div>
                        <div class="stat-num">{{ $documents->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card green">
                        <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-num">{{ $documents->where('status', 'approved')->count() }}</div>
                        <div class="stat-label">Approved</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card red">
                        <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
                        <div class="stat-num">{{ $documents->where('status', 'rejected')->count() }}</div>
                        <div class="stat-label">Rejected</div>
                    </div>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="table-card">
                <div class="table-card-header">
                    <h6><i class="fas fa-file-alt me-2" style="color:#F48200;"></i>My Documents</h6>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th><th>Title</th><th>Type</th><th>Description</th>
                                <th>Status</th><th>Due Date</th><th>Submitted</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr>
                                <td style="color:#94a3b8;font-size:0.8rem;">#{{ $doc->id }}</td>
                                <td class="fw-semibold">{{ $doc->title }}</td>
                                <td>
                                    @php
                                        $typeIcons = ['PDF'=>['fa-file-pdf','text-danger'],'Word'=>['fa-file-word','text-primary'],'Excel'=>['fa-file-excel','text-success'],'Image'=>['fa-file-image','text-info'],'Other'=>['fa-file','text-secondary']];
                                        $ti = $typeIcons[$doc->type] ?? $typeIcons['Other'];
                                    @endphp
                                    <i class="fas {{ $ti[0] }} {{ $ti[1] }} me-1"></i>{{ $doc->type }}
                                </td>
                                <td style="max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $doc->description ?? '—' }}</td>
                                <td>
                                    @php $sc = ['pending'=>'badge-pending','in-review'=>'badge-review','approved'=>'badge-approved','rejected'=>'badge-rejected']; @endphp
                                    <span class="badge-status {{ $sc[$doc->status] ?? 'badge-pending' }}">{{ ucfirst($doc->status) }}</span>
                                </td>
                                <td>{{ $doc->due_date ? $doc->due_date->format('M d, Y') : '—' }}</td>
                                <td>{{ $doc->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn" style="border-radius:7px;font-size:0.78rem;"
                                        data-id="{{ $doc->id }}" data-title="{{ $doc->title }}"
                                        data-description="{{ $doc->description }}" data-type="{{ $doc->type }}"
                                        data-due="{{ $doc->due_date ? $doc->due_date->format('Y-m-d') : '' }}"
                                        data-bs-toggle="modal" data-bs-target="#editDocumentModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" style="border-radius:7px;font-size:0.78rem;"
                                        data-id="{{ $doc->id }}" data-title="{{ $doc->title }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteDocumentModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-folder-open"></i>
                                        <p>No documents yet. Click <strong>Add Document</strong> to get started.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Document Modal -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-orange">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-plus me-2"></i>Add Document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('documents.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Document Title</label><input type="text" name="title" class="form-control" placeholder="Enter document title" required></div>
                        <div class="mb-3"><label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="PDF">PDF</option><option value="Word">Word</option>
                                <option value="Excel">Excel</option><option value="Image">Image</option>
                                <option value="Other" selected>Other</option>
                            </select>
                        </div>
                        <div class="mb-3"><label class="form-label">Description <span class="text-muted fw-normal">(optional)</span></label><textarea name="description" class="form-control" rows="3" placeholder="Add notes or description"></textarea></div>
                        <div class="mb-1"><label class="form-label">Due Date <span class="text-muted fw-normal">(optional)</span></label><input type="date" name="due_date" class="form-control"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Document Modal -->
    <div class="modal fade" id="editDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-orange">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="editDocumentForm">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">Document Title</label><input type="text" name="title" id="edit_title" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">Type</label>
                            <select name="type" id="edit_type" class="form-select" required>
                                <option value="PDF">PDF</option><option value="Word">Word</option>
                                <option value="Excel">Excel</option><option value="Image">Image</option><option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3"><label class="form-label">Description</label><textarea name="description" id="edit_description" class="form-control" rows="3"></textarea></div>
                        <div class="mb-1"><label class="form-label">Due Date</label><input type="date" name="due_date" id="edit_due" class="form-control"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning fw-bold"><i class="fas fa-save me-1"></i>Update</button>
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
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete Document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p class="fs-6 mb-1">Are you sure you want to delete</p>
                    <p class="fw-bold fs-5 mb-1" id="delete_title"></p>
                    <p class="text-muted small">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" id="deleteDocumentForm">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger fw-bold"><i class="fas fa-trash me-1"></i>Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('edit_title').value = this.dataset.title;
                document.getElementById('edit_description').value = this.dataset.description;
                document.getElementById('edit_type').value = this.dataset.type;
                document.getElementById('edit_due').value = this.dataset.due;
                document.getElementById('editDocumentForm').action = '/documents/' + this.dataset.id;
            });
        });
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('delete_title').textContent = this.dataset.title;
                document.getElementById('deleteDocumentForm').action = '/documents/' + this.dataset.id;
            });
        });
    </script>
    @if(session('toast_success'))
    <script>toastr.options={closeButton:true,progressBar:true,positionClass:"toast-top-right",timeOut:"3000"};toastr.success("{{ session('toast_success') }}");</script>
    @endif
    @if(session('toast_error'))
    <script>toastr.options={closeButton:true,progressBar:true,positionClass:"toast-top-right",timeOut:"3000"};toastr.error("{{ session('toast_error') }}");</script>
    @endif
</body>
</html>
