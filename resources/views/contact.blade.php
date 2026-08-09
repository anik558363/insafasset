@extends('layouts.app')
@section('title', __('messages.common.contact_us'))

@section('content')
<div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));padding:3rem 0 2.5rem;">
    <div class="container text-center">
        <h1 style="font-family:'Cormorant Garamond',serif;color:#fff;font-size:2.8rem;">{{ $siteSettings['contact_hero_title'] ?? 'Get In Touch' }}</h1>
        <p style="color:rgba(255,255,255,0.75);">{{ $siteSettings['contact_hero_subtitle'] ?? 'Our team is ready to help you find your perfect property.' }}</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-4">
            <h3 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1.5rem;">{{ $siteSettings['contact_info_title'] ?? 'Contact Information' }}</h3>
            @php
            $contactItems = array_filter([
                !empty($siteSettings['company_address']) ? ['bi-geo-alt-fill', __('messages.contact.address'), e($siteSettings['company_address'])] : null,
                !empty($siteSettings['company_phone'])   ? ['bi-telephone-fill', __('messages.contact.phone'), '<a href="tel:'.preg_replace('/\s+/','',$siteSettings['company_phone']).'" style="color:var(--text-muted);">'.e($siteSettings['company_phone']).'</a>'] : null,
                !empty($siteSettings['company_email'])   ? ['bi-envelope-fill', __('messages.contact.email'), '<a href="mailto:'.e($siteSettings['company_email']).'" style="color:var(--text-muted);">'.e($siteSettings['company_email']).'</a>'] : null,
                !empty($siteSettings['company_hours'])   ? ['bi-clock-fill', __('messages.contact.office_hours'), e($siteSettings['company_hours'])] : null,
            ]);
            @endphp
            @foreach($contactItems as $c)
            <div class="d-flex mb-4">
                <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--accent),var(--accent-light));border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-right:1rem;">
                    <i class="bi {{ $c[0] }}" style="color:#fff;font-size:1.1rem;"></i>
                </div>
                <div>
                    <div style="font-weight:600;color:var(--primary);font-size:0.9rem;">{{ $c[1] }}</div>
                    <div style="color:var(--text-muted);font-size:0.88rem;margin-top:0.2rem;">{!! $c[2] !!}</div>
                </div>
            </div>
            @endforeach

            <div class="mt-3">
                <h6 style="font-family:'Cormorant Garamond',serif;color:var(--primary);">{{ __('messages.common.follow_us') }}</h6>
                <div class="d-flex gap-2 mt-2">
                    @if(!empty($siteSettings['social_facebook']))
                    <a href="{{ $siteSettings['social_facebook'] }}" target="_blank" rel="noopener" class="d-flex align-items-center justify-content-center rounded-circle" style="width:38px;height:38px;background:var(--primary);color:var(--accent-light);" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    @endif
                    @if(!empty($siteSettings['social_instagram']))
                    <a href="{{ $siteSettings['social_instagram'] }}" target="_blank" rel="noopener" class="d-flex align-items-center justify-content-center rounded-circle" style="width:38px;height:38px;background:var(--primary);color:var(--accent-light);" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    @endif
                    @if(!empty($siteSettings['social_youtube']))
                    <a href="{{ $siteSettings['social_youtube'] }}" target="_blank" rel="noopener" class="d-flex align-items-center justify-content-center rounded-circle" style="width:38px;height:38px;background:var(--primary);color:var(--accent-light);" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    @endif
                    @if(!empty($siteSettings['company_whatsapp']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['company_whatsapp']) }}" target="_blank" rel="noopener" class="d-flex align-items-center justify-content-center rounded-circle" style="width:38px;height:38px;background:#25d366;color:#fff;" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div style="background:var(--white);border-radius:var(--radius-lg);padding:2.5rem;box-shadow:var(--card-shadow);border:1px solid var(--border);">
                <h3 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1.5rem;">{{ $siteSettings['contact_form_title'] ?? 'Send Us a Message' }}</h3>

                <div id="formSuccess" class="alert alert-success d-none">
                    <i class="bi bi-check-circle-fill me-2"></i><span id="successMsg"></span>
                </div>

                <form id="contactForm" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.contact.full_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="{{ __('messages.contact.name_ph') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.contact.email_address') }} <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="your@email.com" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.contact.phone_number') }}</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+880 1XXX-XXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.contact.subject') }}</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="{{ __('messages.contact.subject_ph') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.contact.message') }} <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5"
                                placeholder="{{ __('messages.contact.message_ph') }}" required>{{ old('message') }}</textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <div id="ajaxErrors" class="alert alert-danger d-none"></div>
                            <button type="submit" class="btn btn-accent px-5 py-2 rounded-pill" id="contactSubmitBtn">
                                <i class="bi bi-send me-2"></i>{{ __('messages.contact.send') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@php
    // Accepts either a full Google Maps <iframe ...> embed code OR a plain embed URL.
    $rawMap = trim($siteSettings['company_map_url'] ?? '');
    if ($rawMap !== '' && \Illuminate\Support\Str::contains($rawMap, '<iframe')) {
        preg_match('/src=["\']([^"\']+)["\']/i', $rawMap, $mapMatch);
        $mapSrc = $mapMatch[1] ?? '';
    } else {
        $mapSrc = $rawMap;
    }
@endphp
@if($mapSrc)
<section class="pb-5">
    <div class="container">
        <div style="border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--card-shadow);border:1px solid var(--border);line-height:0;">
            <iframe src="{{ $mapSrc }}"
                    width="100%" height="420" style="border:0;display:block;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    title="{{ $siteSettings['company_address'] ?? 'Our location' }}"></iframe>
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
$('#contactForm').on('submit', function(e) {
    e.preventDefault();
    const btn = $('#contactSubmitBtn');
    const sendLabel = '<i class="bi bi-send me-2"></i>' + @json(__('messages.contact.send'));
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>' + @json(__('messages.contact.sending')));
    $('#ajaxErrors').addClass('d-none');

    $.post($(this).attr('action'), $(this).serialize())
        .done(function(res) {
            if (res.success) {
                $('#contactForm')[0].reset();
                $('#formSuccess').removeClass('d-none');
                $('#successMsg').text(res.message);
                btn.prop('disabled', false).html(sendLabel);
                $('html, body').animate({ scrollTop: $('#formSuccess').offset().top - 100 }, 400);
            }
        })
        .fail(function(xhr) {
            btn.prop('disabled', false).html(sendLabel);
            let errors = '';
            if (xhr.status === 422) {
                $.each(xhr.responseJSON.errors, function(k, v) { errors += '<div>' + v[0] + '</div>'; });
            } else {
                errors = @json(__('messages.contact.error_generic'));
            }
            $('#ajaxErrors').removeClass('d-none').html(errors);
        });
});
</script>
@endpush
