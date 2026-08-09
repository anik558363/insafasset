@extends('layouts.admin')
@section('title', 'Testimonials')
@section('breadcrumb', 'Testimonials')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Testimonials</h1>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="card-header">Add Testimonial</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Client Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control" value="{{ old('designation') }}" placeholder="e.g. Property Buyer">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-select">
                            @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} Stars</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Client Photo</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-accent px-4">
                        <i class="bi bi-plus-lg me-1"></i>Add Testimonial
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="admin-card">
            <div class="card-header">All Testimonials ({{ $testimonials->count() }})</div>
            <div class="card-body p-0">
                @forelse($testimonials as $t)
                <div class="d-flex align-items-start p-3 border-bottom gap-3">
                    @if($t->image_url)
                    <img src="{{ $t->image_url }}" class="rounded-circle" width="50" height="50" style="object-fit:cover;flex-shrink:0;" alt="{{ $t->name }}">
                    @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:50px;height:50px;background:var(--primary);color:var(--accent-light);font-size:1.2rem;font-weight:700;font-family:'Cormorant Garamond',serif;">{{ substr($t->name,0,1) }}</div>
                    @endif
                    <div style="flex:1;min-width:0;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong style="font-size:0.9rem;">{{ $t->name }}</strong>
                                @if($t->designation)<span style="font-size:0.75rem;color:var(--text-muted);margin-left:0.5rem;">{{ $t->designation }}</span>@endif
                            </div>
                            <div style="color:#f4b400;font-size:0.8rem;">
                                @for($i=0;$i<5;$i++)<i class="bi bi-star{{ $i<$t->rating ? '-fill' : '' }}"></i>@endfor
                            </div>
                        </div>
                        <p style="font-size:0.82rem;color:var(--text-muted);margin:0.3rem 0 0.6rem;">{{ Str::limit($t->message, 100) }}</p>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary rounded" data-bs-toggle="modal" data-bs-target="#editTestimonial{{ $t->id }}"><i class="bi bi-pencil"></i></button>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" class="form-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">No testimonials yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals -->
@foreach($testimonials as $t)
<div class="modal fade" id="editTestimonial{{ $t->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Edit Testimonial</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <form method="POST" action="{{ route('admin.testimonials.update', $t) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name</label><input type="text" name="name" class="form-control" value="{{ $t->name }}" required></div>
                    <div class="mb-3"><label class="form-label">Designation</label><input type="text" name="designation" class="form-control" value="{{ $t->designation }}"></div>
                    <div class="mb-3"><label class="form-label">Message</label><textarea name="message" class="form-control" rows="3" required>{{ $t->message }}</textarea></div>
                    <div class="mb-3"><label class="form-label">Rating</label>
                        <select name="rating" class="form-select">
                            @for($i=5;$i>=1;$i--)<option value="{{ $i }}" {{ $t->rating==$i?'selected':''}}>{{ $i }} Stars</option>@endfor
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">New Photo</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-accent btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
