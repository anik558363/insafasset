@extends('layouts.admin')
@section('title', 'Categories')
@section('breadcrumb', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Categories</h1>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="card-header">Add New Category</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Commercial">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon Class <small class="text-muted">(Bootstrap Icons)</small></label>
                        <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="e.g. bi-building">
                        <div class="mt-2" style="font-size:0.78rem;color:var(--text-muted);">
                            Options: bi-map, bi-building, bi-house-door, bi-shop, bi-geo-alt
                        </div>
                    </div>
                    <button type="submit" class="btn btn-accent px-4">
                        <i class="bi bi-plus-lg me-1"></i>Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="admin-card">
            <div class="card-header">All Categories ({{ $categories->count() }})</div>
            <div class="table-responsive">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Properties</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td><i class="bi {{ $cat->icon ?? 'bi-tag' }}" style="font-size:1.2rem;color:var(--accent);"></i></td>
                            <td style="font-weight:600;">{{ $cat->name }}</td>
                            <td style="color:var(--text-muted);font-size:0.82rem;">{{ $cat->slug }}</td>
                            <td>
                                <span class="badge" style="background:rgba(26,43,74,0.1);color:var(--primary);">{{ $cat->properties_count }}</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary rounded me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $cat->id }}" title="Edit"><i class="bi bi-pencil"></i></button>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="d-inline form-delete">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-3 text-muted">No categories yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach($categories as $cat)
<div class="modal fade" id="editModal{{ $cat->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.categories.update', $cat) }}">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon Class</label>
                        <input type="text" name="icon" class="form-control" value="{{ $cat->icon }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-accent">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
