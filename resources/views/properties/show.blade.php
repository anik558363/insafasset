@extends('layouts.app')
@section('title', $property->meta_title ?? $property->title)
@section('title_suffix', $property->district . ', ' . $property->division)
@section('meta_description', $property->meta_description ?? Str::limit($property->description, 160))

@push('styles')
    <style>
        .gallery-main img {
            width: 100%;
            height: 460px;
            object-fit: cover;
            border-radius: var(--radius-lg);
            cursor: pointer;
        }

        .gallery-thumbs .swiper-slide img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.2s;
            border: 2px solid transparent;
        }

        .gallery-thumbs .swiper-slide-thumb-active img {
            opacity: 1;
            border-color: var(--accent);
        }

        .property-detail-box {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }

        .detail-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.9rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(26, 43, 74, 0.08);
            color: var(--primary);
            margin-right: 0.4rem;
            margin-bottom: 0.4rem;
        }

        .detail-badge i {
            color: var(--accent);
        }

        .spec-item {
            display: flex;
            justify-content: space-between;
            padding: 0.7rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }

        .spec-item:last-child {
            border-bottom: none;
        }

        .spec-item .label {
            color: var(--text-muted);
        }

        .spec-item .value {
            font-weight: 600;
            color: var(--primary);
        }

        .price-box {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            border-radius: var(--radius-lg);
            padding: 2rem;
            color: #fff;
            margin-bottom: 1.5rem;
        }

        .price-main {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--accent-light);
            line-height: 1;
        }

        .book-btn {
            background: var(--accent);
            color: #fff;
            border: none;
            width: 100%;
            padding: 0.9rem;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.25s;
            margin-top: 1rem;
        }

        .book-btn:hover {
            background: var(--accent-light);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(184, 150, 46, 0.4);
        }

        /* Booking modal */
        .modal-booking .modal-header {
            background: var(--primary);
            color: #fff;
            border-bottom: none;
        }

        .modal-booking .modal-header .btn-close {
            filter: invert(1);
        }

        .map-container {
            border-radius: var(--radius);
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .gallery-main img {
                height: 260px;
            }
        }

        .galleryMain img {
            width: 100%;
            height: 460px;
            /* object-fit: cover; */
            border-radius: var(--radius-lg);
            cursor: pointer;
        }

        .galleryThumbs .swiper-slide img {
            width: 100%;
            height: 100%;
            /* object-fit: cover; */
            border-radius: 6px;
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.2s;
            border: 2px solid transparent;
        }

        .galleryThumbs .swiper-slide-thumb-active img {
            opacity: 1;
            border-color: var(--accent);
        }

        @media (max-width: 768px) {
            .galleryMain img {
                height: 260px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="container py-4">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb" style="font-size:0.82rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.nav.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">{{ __('messages.nav.properties') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($property->title, 40) }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Left column: gallery + details -->
            <div class="col-lg-8">
                <!-- Image Gallery -->
                @if ($property->images->count())
                    <div class="mb-3">
                        <div class="swiper galleryMain mb-2">
                            <div class="swiper-wrapper">
                                @foreach ($property->images as $img)
                                    <div class="swiper-slide">
                                        <a href="{{ $img->url }}" class="glightbox" data-gallery="property-gallery">
                                            <img src="{{ $img->url }}" alt="{{ $property->title }}" loading="lazy"
                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next" style="color:var(--accent);"></div>
                            <div class="swiper-button-prev" style="color:var(--accent);"></div>
                        </div>
                        @if ($property->images->count() > 1)
                            <div class="swiper galleryThumbs">
                                <div class="swiper-wrapper">
                                    @foreach ($property->images as $img)
                                        <div class="swiper-slide">
                                            <img src="{{ $img->url }}" alt=""
                                                onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <img src="{{ asset('images/no-image.svg') }}" class="w-100 rounded-3 mb-3"
                        alt="{{ $property->title }}" style="height:340px;object-fit:cover;">
                @endif

                <!-- Title & Tags -->
                <div class="property-detail-box">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <span class="badge me-1"
                                style="background:{{ $property->listing_type === 'rent' ? 'var(--accent)' : 'var(--primary)' }};font-size:0.72rem;">
                                {{ $property->listing_type === 'rent' ? __('messages.common.for_rent') : __('messages.common.for_sale') }}
                            </span>
                            <span class="badge me-1"
                                style="background:rgba(26,43,74,0.1);color:var(--primary);font-size:0.72rem;">{{ __('messages.types.' . $property->type) }}</span>
                            @if ($property->category)
                                <span class="badge"
                                    style="background:rgba(184,150,46,0.15);color:var(--accent);font-size:0.72rem;">{{ $property->category->name }}</span>
                            @endif
                        </div>
                        <small class="text-muted" style="font-size:0.78rem;"><i
                                class="bi bi-eye me-1"></i>{{ number_format($property->views_count) }}
                            {{ __('messages.property.views') }}</small>
                    </div>
                    <h1
                        style="font-family:'Cormorant Garamond',serif;font-size:1.9rem;color:var(--primary);line-height:1.3;">
                        {{ $property->title }}</h1>
                    <p class="text-muted mb-3" style="font-size:0.9rem;"><i class="bi bi-geo-alt-fill me-1"
                            style="color:var(--accent);"></i>{{ $property->location_text }}</p>

                    <!-- Quick specs badges -->
                    <div>
                        <span class="detail-badge"><i class="bi bi-rulers"></i>{{ $property->size }}
                            {{ $property->size_unit }}</span>
                        @if ($property->bedrooms)
                            <span class="detail-badge"><i class="bi bi-door-closed"></i>{{ $property->bedrooms }}
                                {{ __('messages.property.bedrooms') }}</span>
                        @endif
                        @if ($property->bathrooms)
                            <span class="detail-badge"><i class="bi bi-droplet"></i>{{ $property->bathrooms }}
                                {{ __('messages.property.bathrooms') }}</span>
                        @endif
                        <span class="detail-badge"><i
                                class="bi bi-check-circle"></i>{{ ucfirst($property->status) }}</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="property-detail-box">
                    <h4 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1rem;">
                        {{ __('messages.property.description') }}</h4>
                    <div style="font-size:0.92rem;line-height:1.85;color:var(--text);">{!! nl2br(e($property->description)) !!}</div>
                </div>

                <!-- Specifications Table -->
                <div class="property-detail-box">
                    <h4 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1rem;">
                        {{ __('messages.property.details') }}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="spec-item">
                                <span class="label"> Property ID </span>
                                <span class="value">#{{ str_pad($property->property_id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="label">{{ __('messages.property.type') }}</span>
                                <span class="value">{{ __('messages.types.' . $property->type) }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="label">{{ __('messages.property.listing') }}</span>
                                <span
                                    class="value">{{ $property->listing_type === 'rent' ? __('messages.common.for_rent') : __('messages.common.for_sale') }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="label">{{ __('messages.property.area_size') }}</span>
                                <span class="value">{{ $property->size }} {{ $property->size_unit }}</span>
                            </div>
                            @if ($property->bedrooms)
                                <div class="spec-item">
                                    <span class="label">{{ __('messages.property.bedrooms') }}</span>
                                    <span class="value">{{ $property->bedrooms }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if ($property->bathrooms)
                                <div class="spec-item">
                                    <span class="label">{{ __('messages.property.bathrooms') }}</span>
                                    <span class="value">{{ $property->bathrooms }}</span>
                                </div>
                            @endif
                            <div class="spec-item">
                                <span class="label">{{ __('messages.property.division') }}</span>
                                <span class="value">{{ $property->division }}</span>
                            </div>
                            <div class="spec-item">
                                <span class="label">{{ __('messages.property.district') }}</span>
                                <span class="value">{{ $property->district }}</span>
                            </div>
                            @if ($property->area)
                                <div class="spec-item">
                                    <span class="label">{{ __('messages.property.area') }}</span>
                                    <span class="value">{{ $property->area }}</span>
                                </div>
                            @endif
                            <div class="spec-item">
                                <span class="label">{{ __('messages.property.status') }}</span>
                                <span class="value">{{ ucfirst($property->status) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- YouTube Video -->
                @if ($property->youtube_embed_url)
                    <div class="property-detail-box">
                        <h4 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1rem;">
                            <i class="bi bi-play-circle me-2"
                                style="color:var(--accent);"></i>{{ __('messages.property.video_tour') }}
                        </h4>
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $property->youtube_embed_url }}" title="Property Video Tour"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen loading="lazy"></iframe>
                        </div>
                    </div>
                @endif

                <!-- Facebook Video -->
                @if ($property->facebook_embed_url)
                    <div class="property-detail-box">
                        <h4 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1rem;">
                            <i class="bi bi-facebook me-2"
                                style="color:#1877f2;"></i>{{ __('messages.property.fb_video_tour') }}
                        </h4>
                        <div
                            style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:var(--radius);">
                            <iframe src="{{ $property->facebook_embed_url }}"
                                style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                                title="Property Facebook Video Tour"
                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                allowfullscreen loading="lazy"></iframe>
                        </div>
                        <p style="font-size:0.78rem;color:var(--text-muted);margin-top:0.5rem;">
                            <i class="bi bi-info-circle me-1"></i>{!! __('messages.property.fb_video_hint', [
                                'public' => '<strong>' . __('messages.property.public') . '</strong>',
                            ]) !!}
                        </p>
                    </div>
                @endif

                <!-- Map -->
                @if ($property->latitude && $property->longitude)
                    <div class="property-detail-box">
                        <h4 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1rem;">
                            <i class="bi bi-geo-alt me-2"
                                style="color:var(--accent);"></i>{{ __('messages.property.location_map') }}
                        </h4>
                        <div class="map-container">
                            <iframe
                                src="https://maps.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}&z=15&output=embed"
                                width="100%" height="320" style="border:0;" allowfullscreen loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right column: price + book -->
            <div class="col-lg-4">
                <!-- Price box -->
                <div class="price-box">
                    <div class="mb-1"
                        style="font-size:0.8rem;color:rgba(255,255,255,0.6);letter-spacing:1px;text-transform:uppercase;">
                        {{ __('messages.property.listed_price') }}</div>
                    <div class="price-main">{!! $property->price_html !!}</div>
                    @if ($property->price_unit)
                        <div style="color:rgba(255,255,255,0.65);font-size:0.82rem;margin-top:0.3rem;">
                            {{ $property->price_unit }}</div>
                    @endif
                    <hr style="border-color:rgba(255,255,255,0.15);margin:1.2rem 0;">
                    <div style="font-size:0.82rem;color:rgba(255,255,255,0.7);">
                        <i class="bi bi-geo-alt me-1"></i>{{ $property->location_text }}
                    </div>

                    @if ($property->status === 'available')
                        <button class="book-btn" data-bs-toggle="modal" data-bs-target="#bookingModal">
                            <i class="bi bi-calendar-check me-2"></i>{{ __('messages.property.book_this') }}
                        </button>
                    @else
                        <div class="mt-3 p-2 text-center rounded"
                            style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);font-size:0.88rem;">
                            {{ __('messages.property.is_status', ['status' => $property->status]) }}
                        </div>
                    @endif
                </div>

                <!-- Contact card -->
                <div class="property-detail-box">
                    <h6
                        style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:1.1rem;margin-bottom:1rem;">
                        {{ __('messages.property.need_help') }}</h6>
                    <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:1rem;">
                        {{ __('messages.property.need_help_text') }}</p>
                    <a href="tel:{{ preg_replace('/\s+/', '', $siteSettings['company_phone'] ?? '+8801700000000') }}"
                        class="btn btn-outline-accent w-100 rounded-pill mb-2">
                        <i class="bi bi-telephone me-2"></i>{{ $siteSettings['company_phone'] ?? '+880 1700-000000' }}
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-secondary w-100 rounded-pill"
                        style="font-size:0.88rem;">
                        <i class="bi bi-envelope me-2"></i>{{ __('messages.common.send_enquiry') }}
                    </a>
                </div>

                <!-- Share -->
                <div class="property-detail-box">
                    <h6
                        style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:1rem;margin-bottom:1rem;">
                        {{ __('messages.property.share') }}</h6>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            target="_blank" class="btn btn-sm rounded-pill px-3"
                            style="background:#1877f2;color:#fff;font-size:0.8rem;">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($property->title . ' ' . url()->current()) }}"
                            target="_blank" class="btn btn-sm rounded-pill px-3"
                            style="background:#25d366;color:#fff;font-size:0.8rem;">
                            <i class="bi bi-whatsapp me-1"></i>WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Properties -->
        @if ($related->count())
            <div class="mt-5">
                <h3 style="font-family:'Cormorant Garamond',serif;color:var(--primary);margin-bottom:1.5rem;">
                    {{ __('messages.property.similar') }}</h3>
                <div class="row g-4">
                    @foreach ($related as $rp)
                        <div class="col-md-4">
                            @include('partials.property-card', ['property' => $rp])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Booking Modal -->
    @if ($property->status === 'available')
        <div class="modal fade modal-booking" id="bookingModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-family:'Cormorant Garamond',serif;font-size:1.4rem;">
                            <i class="bi bi-calendar-check me-2"></i>{{ __('messages.booking.modal_title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3 p-3 rounded" style="background:var(--bg);font-size:0.85rem;">
                            <strong style="color:var(--primary);">{{ $property->title }}</strong><br>
                            <span style="color:var(--text-muted);">{{ $property->location_text }}</span>
                        </div>

                        <div id="bookingSuccess" class="alert alert-success d-none">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span id="bookingSuccessMsg"></span>
                        </div>

                        <form id="bookingForm" method="POST" action="{{ route('bookings.store', $property->slug) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold"
                                    style="font-size:0.88rem;">{{ __('messages.booking.full_name') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    value="{{ old('customer_name') }}"
                                    placeholder="{{ __('messages.booking.name_ph') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold"
                                    style="font-size:0.88rem;">{{ __('messages.booking.phone') }} <span
                                        class="text-danger">*</span></label>
                                <input type="tel" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                                    placeholder="+880 1XXX-XXXXXX" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold"
                                    style="font-size:0.88rem;">{{ __('messages.booking.email') }}</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="your@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold"
                                    style="font-size:0.88rem;">{{ __('messages.booking.visit_date') }}</label>
                                <input type="date" name="preferred_date"
                                    class="form-control @error('preferred_date') is-invalid @enderror"
                                    value="{{ old('preferred_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                @error('preferred_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold"
                                    style="font-size:0.88rem;">{{ __('messages.booking.message') }}</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="3"
                                    placeholder="{{ __('messages.booking.message_ph') }}">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="bookingErrors" class="alert alert-danger d-none" style="font-size:0.85rem;"></div>
                            <button type="submit" class="btn btn-accent w-100 py-2" id="bookingSubmitBtn">
                                <i class="bi bi-send me-2"></i>{{ __('messages.booking.submit') }}
                            </button>
                            <p style="font-size:0.75rem;color:var(--text-muted);text-align:center;margin-top:0.8rem;">
                                {{ __('messages.booking.agent_note') }}
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        $(function() {
            // Gallery swiper — only init when elements actually exist in DOM
            let galleryThumbs;
            if (document.querySelector('.galleryThumbs')) {
                galleryThumbs = new Swiper('.galleryThumbs', {
                    spaceBetween: 8,
                    slidesPerView: 5,
                    watchSlidesProgress: true,
                });
            }

            if (document.querySelector('.galleryMain')) {
                const mainOpts = {
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                };
                if (galleryThumbs) mainOpts.thumbs = {
                    swiper: galleryThumbs
                };
                new Swiper('.galleryMain', mainOpts);
            }

            // Lightbox
            GLightbox({
                selector: '.glightbox'
            });

            // Auto-reopen modal if server-side validation failed (non-AJAX fallback)
            @if ($errors->any() || old('customer_name') || old('phone'))
                (new bootstrap.Modal(document.getElementById('bookingModal'))).show();
            @endif

            // Booking AJAX form
            $('#bookingForm').on('submit', function(e) {
                e.preventDefault();

                const btn = $('#bookingSubmitBtn');
                const submitLabel = '<i class="bi bi-send me-2"></i>' + @json(__('messages.booking.submit'));
                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>' +
                    @json(__('messages.booking.submitting')));
                $('#bookingErrors').addClass('d-none');

                $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                    })
                    .done(function(res) {
                        if (res.success) {
                            $('#bookingForm').addClass('d-none');
                            $('#bookingSuccess').removeClass('d-none');
                            $('#bookingSuccessMsg').text(res.message);
                        }
                    })
                    .fail(function(xhr) {
                        btn.prop('disabled', false).html(submitLabel);
                        let errors = '';
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(k, v) {
                                errors += '<div>' + v[0] + '</div>';
                            });
                        } else {
                            errors = @json(__('messages.booking.error_generic'));
                        }
                        $('#bookingErrors').removeClass('d-none').html(errors);
                    });
            });
        });
    </script>
@endpush
