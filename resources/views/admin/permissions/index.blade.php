@extends('layouts.admin')
@section('title', 'Menu Permissions')
@section('breadcrumb', 'Settings / Permissions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><i class="bi bi-shield-check me-2" style="color:var(--accent);font-size:1.5rem;"></i>Menu Permissions</h1>
</div>

<div class="admin-card mb-4" style="border-left:4px solid var(--accent);">
    <div class="card-body" style="font-size:0.85rem;">
        <i class="bi bi-info-circle-fill me-2" style="color:var(--accent);"></i>
        <strong>Admin</strong> users always have full access to all menus. Configure below what <strong>Agent</strong> and <strong>Employee</strong> roles can see in the sidebar.
        Deactivated users cannot log in regardless of permissions.
    </div>
</div>

<div class="row g-4">
    @foreach($roles as $role)
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi bi-person-badge" style="color:var(--accent);"></i>
                <span>{{ ucfirst($role) }} Permissions</span>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.permissions.update') }}">
                    @csrf @method('PUT')
                    <input type="hidden" name="role" value="{{ $role }}">

                    <div class="row g-2">
                        @foreach($menus as $key => $meta)
                        <div class="col-6">
                            <div class="form-check p-3 rounded" style="background:var(--bg);border:1px solid var(--border);">
                                <input class="form-check-input" type="checkbox"
                                    name="menus[]"
                                    value="{{ $key }}"
                                    id="{{ $role }}_{{ $key }}"
                                    {{ in_array($key, $permissions[$role]) ? 'checked' : '' }}>
                                <label class="form-check-label" for="{{ $role }}_{{ $key }}"
                                    style="font-size:0.85rem;cursor:pointer;display:flex;align-items:center;gap:0.4rem;">
                                    <i class="bi {{ $meta['icon'] }}" style="color:var(--accent);"></i>
                                    {{ $meta['label'] }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-end mt-3 pt-3 border-top">
                        <button type="submit" class="btn btn-accent rounded-pill px-4">
                            <i class="bi bi-check-lg me-2"></i>Save {{ ucfirst($role) }} Permissions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
