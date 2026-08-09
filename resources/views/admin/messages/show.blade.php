@extends('layouts.admin')
@section('title', 'Message from ' . $message->name)
@section('breadcrumb', 'Messages / View')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Message Details</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary rounded-pill px-3"><i class="bi bi-arrow-left me-1"></i>Back</a>
        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="form-delete">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger rounded-pill px-3"><i class="bi bi-trash me-1"></i>Delete</button>
        </form>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header d-flex justify-content-between">
                <span>From: <strong>{{ $message->name }}</strong></span>
                <small style="color:var(--text-muted);">{{ $message->created_at ? $message->created_at->format('d M Y, h:i A') : '—' }}</small>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-4">
                    @foreach(['Email' => $message->email, 'Phone' => $message->phone ?? '—', 'Subject' => $message->subject ?? '—'] as $k => $v)
                    <div class="col-md-4">
                        <small style="color:var(--text-muted);font-size:0.75rem;text-transform:uppercase;">{{ $k }}</small>
                        <div style="font-weight:600;font-size:0.88rem;color:var(--primary);">{{ $v }}</div>
                    </div>
                    @endforeach
                </div>
                <div style="background:var(--bg);border-radius:var(--radius);padding:1.5rem;">
                    <p style="font-size:0.92rem;line-height:1.85;color:var(--text);margin:0;">{{ $message->message }}</p>
                </div>
                <div class="d-flex gap-3 mt-4">
                    <a href="mailto:{{ $message->email }}" class="btn btn-outline-primary rounded-pill px-4">
                        <i class="bi bi-envelope me-2"></i>Reply via Email
                    </a>
                    @if($message->phone)
                    <a href="tel:{{ $message->phone }}" class="btn btn-outline-success rounded-pill px-4">
                        <i class="bi bi-telephone me-2"></i>Call
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
