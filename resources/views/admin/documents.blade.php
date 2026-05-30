<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents — Document Tracker</title>
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
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="icon">📄</div>
            <span>DocTracker</span>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Admin Panel</div>
            <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-home"></i> Dashboard</a>
            <a href="{{ route('admin.users') }}" class="nav-link"><i class="fas fa-users"></i> Users</a>
            <a href="{{ route('admin.documents') }}" class="nav-link active"><i class="fas fa-file-alt"></i> Documents</a>
            <a href="{{ route('admin.profile') }}" class="nav-link"><i class="fas fa-user-cog"></i> Profile</a>
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
            <div>
                <p class="page-title">Documents</p>
                <p class="breadcrumb-text">All submitted documents</p>
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
            <div class="table-card">
                <div class="table-card-header">
                    <h6><i class="fas fa-file-alt me-2" style="color:#F48200;"></i>Documents Management</h6>
                    <span class="badge bg-secondary">{{ $documents->count() }} total</span>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th><th>User</th><th>Title</th><th>Type</th>
                                <th>Description</th><th>Status</th><th>Due Date</th><th>Submitted</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                            <tr>
                                <td style="color:#94a3b8;font-size:0.8rem;">#{{ $doc->id }}</td>
                                <td>{{ $doc->user->name ?? 'N/A' }}</td>
                                <td class="fw-semibold">{{ $doc->title }}</td>
                                <td>
                                    @php $typeIcons = ['PDF'=>['fa-file-pdf','text-danger'],'Word'=>['fa-file-word','text-primary'],'Excel'=>['fa-file-excel','text-success'],'Image'=>['fa-file-image','text-info'],'Other'=>['fa-file','text-secondary']]; $ti = $typeIcons[$doc->type] ?? $typeIcons['Other']; @endphp
                                    <i class="fas {{ $ti[0] }} {{ $ti[1] }} me-1"></i>{{ $doc->type }}
                                </td>
                                <td style="max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $doc->description ?? '—' }}</td>
                                <td>
                                    @php $sc = ['pending'=>'badge-pending','in-review'=>'badge-review','approved'=>'badge-approved','rejected'=>'badge-rejected']; @endphp
                                    <span class="badge-status {{ $sc[$doc->status] ?? 'badge-pending' }}">{{ ucfirst($doc->status) }}</span>
                                </td>
                                <td>{{ $doc->due_date ? $doc->due_date->format('M d, Y') : '—' }}</td>
                                <td>{{ $doc->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info status-btn" style="border-radius:7px;font-size:0.78rem;"
                                        data-id="{{ $doc->id }}" data-title="{{ $doc->title }}" data-status="{{ $doc->status }}"
                                        data-bs-toggle="modal" data-bs-target="#statusModal">
                                        <i class="fas fa-sync-alt"></i> Status
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" style="border-radius:7px;font-size:0.78rem;"
                                        data-id="{{ $doc->id }}" data-title="{{ $doc->title }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteDocumentModal">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="9"><div class="empty-state"><i class="fas fa-folder-open"></i><p>No documents submitted yet.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:linear-gradient(135deg,#F48200,#F6BB0A);">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-sync-alt me-2"></i>Update Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="statusForm">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <p class="fw-semibold mb-3 text-muted" id="status_doc_title"></p>
                        <div class="mb-1"><label class="form-label">New Status</label>
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
                        <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white fw-bold"><i class="fas fa-trash me-2"></i>Delete Document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p class="mb-1">Are you sure you want to delete</p>
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
    <script>toastr.options={closeButton:true,progressBar:true,positionClass:"toast-top-right",timeOut:"3000"};toastr.success("{{ session('toast_success') }}");</script>
    @endif
    @if(session('toast_error'))
    <script>toastr.options={closeButton:true,progressBar:true,positionClass:"toast-top-right",timeOut:"3000"};toastr.error("{{ session('toast_error') }}");</script>
    @endif
</body>
</html>
