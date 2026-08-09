@extends('layouts.admin')
@section('title', 'Bookings')
@section('breadcrumb', 'Bookings / All')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Bookings</h1>
</div>

<div class="admin-card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search Customer</label>
                <input type="text" name="search" class="form-control" placeholder="Name, phone, email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    @foreach(['pending', 'confirmed', 'rejected', 'cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="card-header">{{ $bookings->total() }} Bookings</div>
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Property</th>
                    <th>Preferred Date</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td style="color:var(--text-muted);font-size:0.8rem;">{{ $b->id }}</td>
                    <td>
                        <div style="font-weight:600;font-size:0.85rem;">{{ $b->customer_name }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $b->phone }}</div>
                        @if($b->email)<div style="font-size:0.72rem;color:var(--text-muted);">{{ $b->email }}</div>@endif
                    </td>
                    <td style="font-size:0.82rem;max-width:180px;">
                        @if($b->property)
                        <a href="{{ route('admin.properties.edit', $b->property) }}" class="text-decoration-none" style="color:var(--primary);">
                            {{ Str::limit($b->property->title, 35) }}
                        </a>
                        @else —@endif
                    </td>
                    <td style="font-size:0.82rem;">{{ $b->preferred_date ? $b->preferred_date->format('d M Y') : '—' }}</td>
                    <td>
                        <span class="status-badge" style="background:{{ match($b->status) { 'pending' => 'rgba(253,126,20,0.15)', 'confirmed' => 'rgba(25,135,84,0.15)', 'rejected' => 'rgba(220,53,69,0.15)', default => 'rgba(108,117,125,0.15)' } }};color:{{ match($b->status) { 'pending' => '#fd7e14', 'confirmed' => '#198754', 'rejected' => '#dc3545', default => '#6c757d' } }};">
                            {{ ucfirst($b->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge" style="background:{{ match($b->payment_status) { 'paid' => 'rgba(25,135,84,0.15)', 'partial' => 'rgba(253,126,20,0.15)', default => 'rgba(108,117,125,0.1)' } }};color:{{ match($b->payment_status) { 'paid' => '#198754', 'partial' => '#fd7e14', default => '#6c757d' } }};">
                            {{ ucfirst($b->payment_status) }}
                        </span>
                    </td>
                    <td style="font-size:0.78rem;color:var(--text-muted);">{{ $b->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-outline-primary rounded-pill px-2" style="font-size:0.72rem;">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">No bookings found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
    <div class="card-body border-top">
        {{ $bookings->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
