@extends('layouts.admin')
@section('title', 'Employees')
@section('breadcrumb', 'Settings / Employees')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><i class="bi bi-people me-2" style="color:var(--accent);font-size:1.5rem;"></i>Employees</h1>
    <a href="{{ route('admin.employees.create') }}" class="btn btn-accent rounded-pill px-3">
        <i class="bi bi-person-plus me-1"></i>Add Employee
    </a>
</div>

<!-- Filters -->
<div class="admin-card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name, email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
                    <option value="employee" {{ request('role') === 'employee' ? 'selected' : '' }}>Employee</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="card-header">{{ $employees->total() }} Employee(s)</div>
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.8rem;">#{{ $emp->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:36px;height:36px;background:var(--primary);color:var(--accent-light);font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:700;flex-shrink:0;">
                                {{ strtoupper(substr($emp->name, 0, 1)) }}
                            </div>
                            <span style="font-weight:600;font-size:0.88rem;">{{ $emp->name }}</span>
                        </div>
                    </td>
                    <td style="font-size:0.85rem;">{{ $emp->email }}</td>
                    <td style="font-size:0.85rem;">{{ $emp->phone ?? '—' }}</td>
                    <td>
                        <span class="status-badge" style="background:rgba(26,43,74,0.1);color:var(--primary);">
                            {{ ucfirst($emp->role) }}
                        </span>
                    </td>
                    <td>
                        @if($emp->is_active)
                            <span class="status-badge" style="background:rgba(25,135,84,0.12);color:#198754;">Active</span>
                        @else
                            <span class="status-badge" style="background:rgba(220,53,69,0.12);color:#dc3545;">Inactive</span>
                        @endif
                    </td>
                    <td style="font-size:0.78rem;color:var(--text-muted);">{{ $emp->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('admin.employees.edit', $emp) }}" class="btn btn-sm btn-outline-primary rounded-pill" style="font-size:0.72rem;padding:2px 10px;">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form method="POST" action="{{ route('admin.employees.toggle-active', $emp) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm rounded-pill" style="font-size:0.72rem;padding:2px 10px;background:{{ $emp->is_active ? 'rgba(220,53,69,0.1)' : 'rgba(25,135,84,0.1)' }};color:{{ $emp->is_active ? '#dc3545' : '#198754' }};border:1px solid {{ $emp->is_active ? '#dc3545' : '#198754' }};">
                                    {{ $emp->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.employees.destroy', $emp) }}" class="form-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" style="font-size:0.72rem;padding:2px 10px;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="bi bi-people fs-2 text-muted d-block mb-2"></i>
                        <span class="text-muted">No employees found.</span><br>
                        <a href="{{ route('admin.employees.create') }}" class="btn btn-accent btn-sm rounded-pill mt-2">Add First Employee</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($employees->hasPages())
    <div class="card-body border-top">
        {{ $employees->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
