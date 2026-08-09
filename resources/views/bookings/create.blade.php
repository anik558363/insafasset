@extends('layouts.app')
@section('title', 'Book Property — ' . $property->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb" style="font-size:0.82rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.nav.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">{{ __('messages.nav.properties') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('properties.show', $property->slug) }}">{{ Str::limit($property->title, 30) }}</a></li>
                    <li class="breadcrumb-item active">{{ __('messages.booking.book_now') }}</li>
                </ol>
            </nav>

            <div style="background:var(--white);border-radius:var(--radius-lg);padding:2.5rem;box-shadow:var(--card-shadow);border:1px solid var(--border);">
                <div class="mb-3 p-3 rounded" style="background:var(--bg);border-left:4px solid var(--accent);">
                    <small style="color:var(--accent);font-weight:600;text-transform:uppercase;font-size:0.75rem;letter-spacing:1px;">{{ __('messages.booking.booking_for') }}</small>
                    <h5 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin:0.3rem 0 0;">{{ $property->title }}</h5>
                    <small style="color:var(--text-muted);"><i class="bi bi-geo-alt me-1"></i>{{ $property->location_text }}</small>
                </div>

                <h3 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1.5rem;">{{ __('messages.booking.contact_details') }}</h3>

                <form id="bookingForm" method="POST" action="{{ route('bookings.store', $property->slug) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.booking.full_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                            value="{{ old('customer_name') }}" placeholder="{{ __('messages.booking.name_ph') }}" required>
                        @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.booking.phone_short') }} <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="+880 1XXX-XXXXXX" required>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.booking.email_short') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="your@email.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mt-3 mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.booking.visit_date') }}</label>
                        <input type="date" name="preferred_date" class="form-control @error('preferred_date') is-invalid @enderror"
                            value="{{ old('preferred_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('preferred_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.booking.message_long') }}</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="4"
                            placeholder="{{ __('messages.booking.message_ph_long') }}">{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div id="ajaxErrors" class="alert alert-danger d-none"></div>

                    <button type="submit" class="btn btn-accent w-100 py-2" id="submitBtn" style="border-radius:var(--radius);font-size:1rem;">
                        <i class="bi bi-calendar-check me-2"></i>{{ __('messages.booking.submit') }}
                    </button>
                    <p class="text-center text-muted mt-2 mb-0" style="font-size:0.8rem;">
                        {{ __('messages.booking.agent_note') }}
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#bookingForm').on('submit', function(e) {
    e.preventDefault();
    const btn = $('#submitBtn');
    const submitLabel = '<i class="bi bi-calendar-check me-2"></i>' + @json(__('messages.booking.submit'));
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>' + @json(__('messages.booking.submitting')));
    $('#ajaxErrors').addClass('d-none');

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(res) {
            if (res.success) {
                Swal.fire({
                    icon: 'success',
                    title: @json(__('messages.booking.success_title')),
                    html: `
                        <p style="color:#4a5568;font-size:1rem;margin-bottom:0.5rem;">
                            ${res.message}
                        </p>
                        <p style="color:#718096;font-size:0.88rem;">
                            <i class="bi bi-telephone-fill" style="color:#b8962e;"></i>
                            ${@json(__('messages.booking.call_note'))}
                        </p>
                    `,
                    confirmButtonText: @json(__('messages.booking.view_more')),
                    confirmButtonColor: '#b8962e',
                    showCancelButton: true,
                    cancelButtonText: @json(__('messages.booking.back_home')),
                    cancelButtonColor: '#1a2b4a',
                    allowOutsideClick: false,
                    customClass: {
                        popup: 'swal-booking-popup',
                        title: 'swal-booking-title',
                    },
                    didOpen: () => {
                        const popup = Swal.getPopup();
                        popup.style.borderRadius = '16px';
                        popup.style.padding = '2rem';
                        const title = Swal.getTitle();
                        title.style.fontFamily = "'Cormorant Garamond', serif";
                        title.style.color = '#1a2b4a';
                        title.style.fontSize = '1.8rem';
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("properties.index") }}';
                    } else {
                        window.location.href = '{{ route("home") }}';
                    }
                });
            }
        },
        error: function(xhr) {
            btn.prop('disabled', false).html(submitLabel);
            let errHtml = '';
            if (xhr.status === 422) {
                $.each(xhr.responseJSON.errors, function(k, v) { errHtml += '<div>' + v[0] + '</div>'; });
            } else {
                errHtml = @json(__('messages.booking.error_generic'));
            }
            $('#ajaxErrors').removeClass('d-none').html(errHtml);
        }
    });
});
</script>
@endpush
