@extends('layouts.admin')
@section('title', 'Properties')
@section('breadcrumb', 'Properties / All')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Properties</h1>
    <a href="{{ route('admin.properties.create') }}" class="btn btn-accent rounded-pill px-3">
        <i class="bi bi-plus-lg me-1"></i>Add Property
    </a>
</div>

<!-- Filters -->
<div class="admin-card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Title, location..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['available', 'booked', 'sold', 'rented'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    @foreach(['land', 'flat', 'house', 'commercial'] as $t)
                    <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="card-header d-flex justify-content-between">
        <span>{{ $properties->total() }} Properties</span>
    </div>
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Property</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th width="130">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $p)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.8rem;">#{{ $p->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                           @php
    $firstImage = $p->images->first();
@endphp

@if($firstImage)
    <img src="{{ asset('uploads/' . $firstImage->image_path) }}"
         alt=""
         style="width:44px;height:44px;border-radius:8px;object-fit:cover;"
         onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'">
@else
    <div style="width:44px;height:44px;background:var(--bg);border-radius:8px;display:flex;align-items:center;justify-content:center;">
        <i class="bi bi-house" style="color:var(--accent);"></i>
    </div>
@endif
                            <div>
                                <div style="font-weight:600;font-size:0.85rem;max-width:200px;" class="text-truncate">{{ $p->title }}</div>
                                <div style="font-size:0.72rem;color:var(--text-muted);">{{ $p->size }} {{ $p->size_unit }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge" style="background:rgba(26,43,74,0.1);color:var(--primary);">{{ ucfirst($p->type) }}</span>
                        <br><span style="font-size:0.72rem;color:var(--text-muted);">{{ ucfirst($p->listing_type) }}</span>
                    </td>
                    <td style="font-weight:600;color:var(--accent);font-size:0.88rem;">৳ {{ number_format($p->price) }}</td>
                    <td style="font-size:0.82rem;color:var(--text-muted);">{{ $p->district }}, {{ $p->division }}</td>
                    <td>
                        <span class="status-badge" style="background:{{ match($p->status) { 'available' => 'rgba(25,135,84,0.15)', 'booked' => 'rgba(253,126,20,0.15)', 'sold' => 'rgba(220,53,69,0.15)', default => 'rgba(108,117,125,0.15)' } }};color:{{ match($p->status) { 'available' => '#198754', 'booked' => '#fd7e14', 'sold' => '#dc3545', default => '#6c757d' } }};">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>
                        @if($p->featured)
                        <i class="bi bi-star-fill" style="color:var(--accent);"></i>
                        @else
                        <i class="bi bi-star" style="color:var(--border);"></i>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('properties.show', $p->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.properties.edit', $p) }}" class="btn btn-sm btn-outline-primary rounded" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.properties.destroy', $p) }}" class="form-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">No properties found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($properties->hasPages())
    <div class="card-body border-top pt-3">
        {{ $properties->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
