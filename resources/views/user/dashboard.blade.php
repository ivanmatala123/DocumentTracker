<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #fffbf0; margin: 0; padding: 0; }
        .navbar { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%) !important; padding: 12px 20px; box-shadow: 0 2px 15px rgba(244,130,0,0.35); }
        .navbar-brand, .navbar .nav-link { color: #fff !important; font-weight: 600; }
        .welcome-card { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%); border-radius: 20px; color: white; box-shadow: 0 5px 20px rgba(244,130,0,0.4); }
        .stat-card { border: none !important; border-radius: 20px !important; box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important; transition: transform 0.2s; border-top: 4px solid #F6BB0A !important; }
        .stat-card:hover { transform: translateY(-6px); box-shadow: 0 8px 25px rgba(244,130,0,0.2) !important; }
        .card { border: none !important; border-radius: 20px !important; box-shadow: 0 2px 15px rgba(0,0,0,0.08) !important; }
        .btn-primary { background: linear-gradient(135deg, #F48200 0%, #F6BB0A 100%); border: none; font-weight: 600; }
        .btn-primary:hover { background: linear-gradient(135deg, #d97200 0%, #d9a500 100%); }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold">📄 Document Tracker</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
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

    <div class="container mt-4">

        <!-- Welcome -->
        <div class="welcome-card p-4 mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Welcome, <strong>{{ auth()->user()->name }}</strong>!</h4>
                <p class="mb-0 mt-1 text-white-50">Track and manage your documents below</p>
            </div>
            <button class="btn btn-light fw-bold" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                <i class="fas fa-plus"></i> Add Document
            </button>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card p-3 text-center">
                    <i class="fas fa-folder-open fa-2x mb-2" style="color:#667eea"></i>
                    <h3 class="fw-bold">{{ $documents->count() }}</h3>
                    <p class="text-muted mb-0">Total Documents</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 text-center">
                    <i class="fas fa-clock fa-2x mb-2 text-warning"></i>
                    <h3 class="fw-bold">{{ $documents->where('status', 'pending')->count() }}</h3>
                    <p class="text-muted mb-0">Pending</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 text-center">
                    <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                    <h3 class="fw-bold">{{ $documents->where('status', 'approved')->count() }}</h3>
                    <p class="text-muted mb-0">Approved</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 text-center">
                    <i class="fas fa-times-circle fa-2x mb-2 text-danger"></i>
                    <h3 class="fw-bold">{{ $documents->where('status', 'rejected')->count() }}</h3>
                    <p class="text-muted mb-0">Rejected</p>
                </div>
            </div>
        </div>

        <!-- Documents Table -->
        <div class="card p-4">
            <h5 class="fw-bold mb-3"><i class="fas fa-file-alt"></i> My Documents</h5>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
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
                            <i class="fas {{ $ti['icon'] }} {{ $ti['color'] }} me-1"></i> {{ $doc->type }}
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
                            <button class="btn btn-sm btn-warning edit-btn"
                                data-id="{{ $doc->id }}"
                                data-title="{{ $doc->title }}"
                                data-description="{{ $doc->description }}"
                                data-type="{{ $doc->type }}"
                                data-due="{{ $doc->due_date ? $doc->due_date->format('Y-m-d') : '' }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editDocumentModal">
                                <i class="fas fa-edit"></i> Edit
                            </button>
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
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block" style="color:#ddd"></i>
                            No documents yet. Click <strong>Add Document</strong> to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Document Modal -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:linear-gradient(135deg,#F48200 0%,#F6BB0A 100%)">
                    <h5 class="modal-title text-white"><i class="fas fa-plus"></i> Add Document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('documents.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Document Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter document title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Type</label>
                            <select name="type" class="form-select" required>
                                <option value="PDF">PDF</option>
                                <option value="Word">Word</option>
                                <option value="Excel">Excel</option>
                                <option value="Image">Image</option>
                                <option value="Other" selected>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description <span class="text-muted fw-normal">(optional)</span></label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Add notes or description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Due Date <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit Document</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Document Modal -->
    <div class="modal fade" id="editDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:linear-gradient(135deg,#F48200 0%,#F6BB0A 100%)">
                    <h5 class="modal-title text-white"><i class="fas fa-edit"></i> Edit Document</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="editDocumentForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Document Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Type</label>
                            <select name="type" id="edit_type" class="form-select" required>
                                <option value="PDF">PDF</option>
                                <option value="Word">Word</option>
                                <option value="Excel">Excel</option>
                                <option value="Image">Image</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Due Date</label>
                            <input type="date" name="due_date" id="edit_due" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update Document</button>
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
