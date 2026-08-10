@extends('layouts.admin')
@section('title', 'My Profile')
@section('breadcrumb', 'Profile / Account Settings')

@push('styles')
    <style>
        .setting-row {
            padding: 1rem 0;
            /* border-bottom: 1px solid var(--border); */
        }

        .setting-row:last-child {
            border-bottom: none;
        }

        .setting-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title"><i class="bi bi-person-circle me-2" style="color:var(--accent);font-size:1.5rem;"></i>My Profile
        </h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <!-- Account Info -->
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-person-lines-fill" style="color:var(--accent);"></i> Account Info
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="setting-row">
                            <div class="setting-label">Name</div>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="setting-row">
                            <div class="setting-label">Email</div>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="setting-row">
                            <div class="setting-label">Phone</div>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-accent px-4 py-2 rounded-pill">
                                <i class="bi bi-check-lg me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock" style="color:var(--accent);"></i> Change Password
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.profile.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="setting-row">
                            <div class="setting-label">Current Password</div>
                            <input type="password" name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="setting-row">
                            <div class="setting-label">New Password</div>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="setting-row">
                            <div class="setting-label">Confirm New Password</div>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-warning px-4 py-2 rounded-pill">
                                <i class="bi bi-arrow-repeat me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
