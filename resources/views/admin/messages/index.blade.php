@extends('layouts.admin')
@section('title', 'Messages')
@section('breadcrumb', 'Contact Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Contact Messages</h1>
    <a href="{{ route('admin.messages.index') }}?filter=unread" class="btn btn-outline-secondary rounded-pill px-3" style="font-size:0.85rem;">
        <i class="bi bi-envelope-exclamation me-1"></i>Unread Only
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table mb-0">
            <thead>
                <tr>
                    <th width="30"></th>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $m)
                <tr style="{{ !$m->is_read ? 'background:rgba(184,150,46,0.03);font-weight:500;' : '' }}">
                    <td>
                        @if(!$m->is_read)
                        <span style="width:8px;height:8px;background:var(--accent);border-radius:50%;display:inline-block;"></span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:0.88rem;">{{ $m->name }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $m->email }}</div>
                    </td>
                    <td style="max-width:250px;">
                        <a href="{{ route('admin.messages.show', $m) }}" class="text-decoration-none" style="color:var(--primary);font-size:0.85rem;">
                            {{ Str::limit($m->subject ?? $m->message, 50) }}
                        </a>
                    </td>
                    <td style="font-size:0.82rem;color:var(--text-muted);">{{ $m->phone ?? '—' }}</td>
                    <td style="font-size:0.78rem;color:var(--text-muted);">{{ $m->created_at ? $m->created_at->format('d M Y, h:i A') : '—' }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.messages.show', $m) }}" class="btn btn-sm btn-outline-primary rounded" title="View"><i class="bi bi-eye"></i></a>
                            <form method="POST" action="{{ route('admin.messages.destroy', $m) }}" class="form-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No messages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
    <div class="card-body border-top">
        {{ $messages->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
