@extends('layouts.admin')
@section('title', 'Booking #' . $booking->id)
@section('breadcrumb', 'Bookings / #' . $booking->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Booking #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h1>
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <!-- Customer Info -->
        <div class="admin-card mb-4">
            <div class="card-header">Customer Information</div>
            <div class="card-body">
                <div class="row g-3">
                    @foreach([
                        ['Full Name', $booking->customer_name],
                        ['Phone', $booking->phone],
                        ['Email', $booking->email ?? '—'],
                        ['Preferred Date', $booking->preferred_date ? $booking->preferred_date->format('d M Y') : '—'],
                        ['Submitted', $booking->created_at->format('d M Y, h:i A')],
                    ] as $row)
                    <div class="col-sm-6">
                        <small style="color:var(--text-muted);font-size:0.75rem;text-transform:uppercase;letter-spacing:0.5px;">{{ $row[0] }}</small>
                        <div style="font-weight:600;color:var(--primary);font-size:0.9rem;margin-top:0.2rem;">{{ $row[1] }}</div>
                    </div>
                    @endforeach
                </div>
                @if($booking->message)
                <div class="mt-3 pt-3 border-top">
                    <small style="color:var(--text-muted);font-size:0.75rem;text-transform:uppercase;">Customer Message</small>
                    <p style="color:var(--text);font-size:0.88rem;margin-top:0.4rem;">{{ $booking->message }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Property Info -->
        @if($booking->property)
        <div class="admin-card mb-4">
            <div class="card-header">Property Details</div>
            <div class="card-body">
                <div class="d-flex gap-3">
                    @if($booking->property->images->count())
                    <img src="{{ $booking->property->images->first()->url }}" alt="" style="width:80px;height:80px;border-radius:10px;object-fit:cover;">
                    @endif
                    <div>
                        <h6 style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:1.1rem;">{{ $booking->property->title }}</h6>
                        <div style="font-size:0.85rem;color:var(--text-muted);"><i class="bi bi-geo-alt me-1"></i>{{ $booking->property->location_text }}</div>
                        <div style="font-size:1.1rem;color:var(--accent);font-weight:700;margin-top:0.3rem;">{{ $booking->property->formatted_price }}</div>
                        <a href="{{ route('admin.properties.edit', $booking->property) }}" class="btn btn-sm btn-outline-primary rounded-pill mt-2" style="font-size:0.75rem;">View Property</a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment history (Phase 2 placeholder) -->
        @if($booking->payments->count())
        <div class="admin-card mb-4">
            <div class="card-header">Payment History</div>
            <div class="card-body p-0">
                <table class="table admin-table mb-0">
                    <thead><tr><th>Transaction ID</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @foreach($booking->payments as $pay)
                        <tr>
                            <td style="font-size:0.82rem;">{{ $pay->transaction_id }}</td>
                            <td style="font-weight:600;">৳ {{ number_format($pay->amount) }}</td>
                            <td>{{ ucfirst($pay->payment_method) }}</td>
                            <td><span class="status-badge" style="background:{{ $pay->status === 'success' ? 'rgba(25,135,84,0.15)' : 'rgba(220,53,69,0.15)' }};color:{{ $pay->status === 'success' ? '#198754' : '#dc3545' }};">{{ ucfirst($pay->status) }}</span></td>
                            <td style="font-size:0.78rem;color:var(--text-muted);">{{ $pay->paid_at ? $pay->paid_at->format('d M Y') : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-5">
        <!-- Update Status -->
        <div class="admin-card">
            <div class="card-header">Update Booking</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" id="updateBookingForm">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Booking Status</label>
                        <select name="status" class="form-select" id="bookingStatusSelect">
                            @foreach(['pending' => 'Pending', 'confirmed' => 'Confirmed', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled'] as $v => $l)
                            <option value="{{ $v }}" {{ $booking->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            @foreach(['unpaid' => 'Unpaid', 'partial' => 'Partial', 'paid' => 'Paid'] as $v => $l)
                            <option value="{{ $v }}" {{ $booking->payment_status === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Advance Amount (৳)</label>
                        <input type="number" name="advance_amount" class="form-control" value="{{ $booking->advance_amount }}" step="0.01" min="0" placeholder="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Admin Note <small class="text-muted">(internal)</small></label>
                        <textarea name="admin_note" class="form-control" rows="3" placeholder="Internal notes about this booking...">{{ $booking->admin_note }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-accent w-100">
                        <i class="bi bi-check-lg me-2"></i>Update Booking
                    </button>
                </form>

                <div class="mt-3 pt-3 border-top">
                    <a href="tel:{{ $booking->phone }}" class="btn btn-outline-success w-100 mb-2">
                        <i class="bi bi-telephone me-2"></i>Call {{ $booking->customer_name }}
                    </a>
                    @if($booking->email)
                    <a href="mailto:{{ $booking->email }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-envelope me-2"></i>Email Customer
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#updateBookingForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(res) {
            if (res.success) {
                showToast(res.message, 'success');
            }
        },
        error: function() {
            // fall back to normal submit
            $('#updateBookingForm')[0].submit();
        }
    });
});

function showToast(msg, type) {
    const id = 'toast_' + Date.now();
    const html = `<div id="${id}" class="toast align-items-center text-bg-${type} border-0" role="alert">
        <div class="d-flex"><div class="toast-body"><i class="bi bi-check-circle-fill me-2"></i>${msg}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>`;
    $('body').append('<div class="toast-container position-fixed bottom-0 end-0 p-3">' + html + '</div>');
    new bootstrap.Toast(document.getElementById(id), { delay: 4000 }).show();
}
</script>
@endpush
