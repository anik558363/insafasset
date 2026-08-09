@extends('layouts.admin')
@section('title', 'Edit Employee')
@section('breadcrumb', 'Settings / Employees / Edit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Edit Employee</h1>
    <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<div class="row g-4">
    <!-- Profile Edit -->
    <div class="col-lg-7">
        <div class="admin-card mb-4">
            <div class="card-header">Employee Information</div>
            <div class="card-body">
                @if($errors->has('name') || $errors->has('email') || $errors->has('role'))
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 ps-3" style="font-size:0.85rem;">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role', $employee->role) === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3 pt-3 border-top">
                        <button type="submit" class="btn btn-accent rounded-pill px-4">
                            <i class="bi bi-check-lg me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right panel -->
    <div class="col-lg-5">
        <!-- Reset Password -->
        <div class="admin-card mb-4">
            <div class="card-header"><i class="bi bi-key me-2" style="color:var(--accent);"></i>Reset Password</div>
            <div class="card-body">
                @error('password')
                <div class="alert alert-danger mb-3" style="font-size:0.85rem;">{{ $message }}</div>
                @enderror
                <form method="POST" action="{{ route('admin.employees.reset-password', $employee) }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min 8 chars, mixed case + numbers" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">
                        <i class="bi bi-shield-lock me-2"></i>Reset Password
                    </button>
                </form>
            </div>
        </div>

        <!-- Status & Delete -->
        <div class="admin-card">
            <div class="card-header">Account Actions</div>
            <div class="card-body d-flex flex-column gap-2">
                <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background:var(--bg);">
                    <div>
                        <div style="font-size:0.85rem;font-weight:600;">Account Status</div>
                        <div style="font-size:0.78rem;color:var(--text-muted);">{{ $employee->is_active ? 'Currently active' : 'Currently inactive' }}</div>
                    </div>
                    <form method="POST" action="{{ route('admin.employees.toggle-active', $employee) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm rounded-pill px-3" style="background:{{ $employee->is_active ? 'rgba(220,53,69,0.1)' : 'rgba(25,135,84,0.1)' }};color:{{ $employee->is_active ? '#dc3545' : '#198754' }};border:1px solid {{ $employee->is_active ? '#dc3545' : '#198754' }};">
                            {{ $employee->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </div>

                <form method="POST" action="{{ route('admin.employees.destroy', $employee) }}" class="form-delete">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100 rounded-pill" style="font-size:0.85rem;">
                        <i class="bi bi-trash me-2"></i>Delete Employee
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
