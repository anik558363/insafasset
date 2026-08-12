@extends('layouts.admin')
@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">Dashboard</h1>
        <a href="{{ route('admin.properties.create') }}" class="btn btn-accent rounded-pill px-3">
            <i class="bi bi-plus-lg me-1"></i>Add Property
        </a>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        @php
            $statCards = [
                [
                    'icon' => 'bi-houses',
                    'color' => '#1a2b4a',
                    'light' => 'rgba(26,43,74,0.1)',
                    'label' => 'Total Properties',
                    'value' => $stats['total_properties'],
                ],
                [
                    'icon' => 'bi-check-circle',
                    'color' => '#198754',
                    'light' => 'rgba(25,135,84,0.1)',
                    'label' => 'Available',
                    'value' => $stats['available'],
                ],
                [
                    'icon' => 'bi-calendar-check',
                    'color' => '#b8962e',
                    'light' => 'rgba(184,150,46,0.1)',
                    'label' => 'Total Bookings',
                    'value' => $stats['total_bookings'],
                ],
                [
                    'icon' => 'bi-hourglass-split',
                    'color' => '#fd7e14',
                    'light' => 'rgba(253,126,20,0.1)',
                    'label' => 'Pending Bookings',
                    'value' => $stats['pending_bookings'],
                ],
                [
                    'icon' => 'bi-check2-all',
                    'color' => '#0d6efd',
                    'light' => 'rgba(13,110,253,0.1)',
                    'label' => 'Confirmed',
                    'value' => $stats['confirmed_bookings'],
                ],
                [
                    'icon' => 'bi-envelope',
                    'color' => '#6f42c1',
                    'light' => 'rgba(111,66,193,0.1)',
                    'label' => 'Unread Messages',
                    'value' => $stats['unread_messages'],
                ],
                [
                    'icon' => 'bi-people',
                    'color' => '#20c997',
                    'light' => 'rgba(32,201,151,0.1)',
                    'label' => 'Customers',
                    'value' => $stats['total_customers'],
                ],
            ];
        @endphp

        @foreach ($statCards as $s)
            <div class="col-6 col-md-4 col-xl-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-number">{{ number_format($s['value']) }}</div>
                            <div class="stat-label">{{ $s['label'] }}</div>
                        </div>
                        <div class="stat-icon" style="background:{{ $s['light'] }};">
                            <i class="bi {{ $s['icon'] }}" style="color:{{ $s['color'] }};"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4">
        <!-- Recent Bookings -->
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-calendar-check me-2" style="color:var(--accent);"></i>Recent Bookings</span>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill"
                        style="font-size:0.75rem;">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table admin-table mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Property</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $b)
                                    <tr>
                                        <td>
                                            <div style="font-weight:600;font-size:0.85rem;">{{ $b->customer_name }}</div>
                                            <div style="font-size:0.75rem;color:var(--text-muted);">{{ $b->phone }}
                                            </div>
                                        </td>
                                        <td style="font-size:0.82rem;max-width:200px;">
                                            {{ $b->property ? Str::limit($b->property->title, 35) : '—' }}
                                        </td>
                                        <td style="font-size:0.78rem;color:var(--text-muted);">
                                            {{ $b->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="status-badge"
                                                style="background:{{ match ($b->status) {'pending' => 'rgba(253,126,20,0.15)','confirmed' => 'rgba(25,135,84,0.15)','rejected' => 'rgba(220,53,69,0.15)',default => 'rgba(108,117,125,0.15)'} }};color:{{ match ($b->status) {'pending' => '#fd7e14','confirmed' => '#198754','rejected' => '#dc3545',default => '#6c757d'} }};">
                                                {{ ucfirst($b->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.bookings.show', $b) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-2"
                                                style="font-size:0.72rem;">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3 text-muted">No bookings yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right column -->
        <div class="col-lg-4">
            <!-- Recent Messages -->
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-envelope me-2" style="color:var(--accent);"></i>Messages</span>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill"
                        style="font-size:0.75rem;">View All</a>
                </div>
                <div class="card-body p-0">
                    @forelse($recentMessages as $m)
                        <a href="{{ route('admin.messages.show', $m) }}"
                            class="d-flex align-items-start p-3 text-decoration-none border-bottom"
                            style="gap:0.75rem;{{ !$m->is_read ? 'background:rgba(184,150,46,0.04);' : '' }}">
                            <div
                                style="width:36px;height:36px;background:var(--bg);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-person" style="color:var(--accent);"></i>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div
                                    style="font-size:0.82rem;font-weight:{{ $m->is_read ? '400' : '600' }};color:var(--text);">
                                    {{ $m->name }}</div>
                                <div style="font-size:0.75rem;color:var(--text-muted);" class="text-truncate">
                                    {{ $m->subject ?? $m->message }}</div>
                            </div>
                            @if (!$m->is_read)
                                <span
                                    style="width:8px;height:8px;background:var(--accent);border-radius:50%;flex-shrink:0;margin-top:5px;"></span>
                            @endif
                        </a>
                    @empty
                        <div class="p-3 text-center text-muted" style="font-size:0.85rem;">No messages yet.</div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Properties -->
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-houses me-2" style="color:var(--accent);"></i>Recent Properties</span>
                    <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill"
                        style="font-size:0.75rem;">View All</a>
                </div>
                <div class="card-body p-0">
                    @foreach ($recentProperties as $p)
                        <div class="d-flex align-items-center p-3 border-bottom" style="gap:0.75rem;">
                            @if ($p->primaryImage)
                                <img src="{{ $p->primaryImage->url }}" alt=""
                                    style="width:40px;height:40px;border-radius:8px;object-fit:cover;"
                                    onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'">
                            @else
                                <div
                                    style="width:40px;height:40px;background:var(--bg);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-house" style="color:var(--accent);"></i></div>
                            @endif
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:0.82rem;font-weight:600;color:var(--text);" class="text-truncate">
                                    {{ $p->title }}</div>
                                <div style="font-size:0.72rem;color:var(--accent);">৳ {{ $p->price }}</div>
                            </div>
                            <a href="{{ route('admin.properties.edit', $p) }}" class="btn btn-sm"
                                style="font-size:0.72rem;color:var(--text-muted);">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
