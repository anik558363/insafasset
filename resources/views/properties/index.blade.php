@extends('layouts.app')
@section('title', __('messages.property.all_properties'))

@push('styles')
    <style>
        .filter-sidebar {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border);
            position: sticky;
            top: 80px;
        }

        .filter-sidebar h6 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.8rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--accent);
        }

        .filter-sidebar .form-check-label {
            font-size: 0.88rem;
            cursor: pointer;
        }

        .filter-sidebar .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .sort-bar {
            background: var(--white);
            border-radius: var(--radius);
            padding: 0.8rem 1.2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border);
        }

        .page-hero {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .price-range-inputs {
            gap: 0.5rem;
        }

        #loadMoreBtn {
            display: none;
            margin: 2rem auto;
        }

        .card-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 350px !important;
        }
    </style>
@endpush

@section('content')

    <div class="page-hero">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2" style="font-size:0.8rem;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            style="color:rgba(255,255,255,0.6);">{{ __('messages.nav.home') }}</a></li>
                    <li class="breadcrumb-item active" style="color:rgba(255,255,255,0.9);">
                        {{ __('messages.nav.properties') }}</li>
                </ol>
            </nav>
            <h1 style="font-family:'Cormorant Garamond',serif;color:#fff;font-size:2.4rem;margin-bottom:0.3rem;">
                {{ __('messages.property.all_properties') }}</h1>
            <p style="color:rgba(255,255,255,0.7);margin:0;" id="resultCount">
                {{ __('messages.filter.showing', ['count' => $properties->total()]) }}
            </p>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row g-4">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="filter-sidebar" id="filterSidebar">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:1.3rem;margin:0;">
                            {{ __('messages.filter.title') }}</h5>
                        <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill"
                            style="font-size:0.75rem;">{{ __('messages.filter.clear_all') }}</a>
                    </div>

                    <!-- Listing Type -->
                    <div class="mb-3">
                        <h6>{{ __('messages.filter.for_sale_rent') }}</h6>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-sm filter-type-btn {{ ($filters['listing_type'] ?? '') === '' ? 'btn-primary-custom active' : 'btn-outline-secondary' }} rounded-pill"
                                data-filter="listing_type" data-val="">{{ __('messages.common.all') }}</button>
                            <button
                                class="btn btn-sm filter-type-btn {{ ($filters['listing_type'] ?? '') === 'sale' ? 'btn-primary-custom active' : 'btn-outline-secondary' }} rounded-pill"
                                data-filter="listing_type" data-val="sale">{{ __('messages.common.sale') }}</button>
                            <button
                                class="btn btn-sm filter-type-btn {{ ($filters['listing_type'] ?? '') === 'rent' ? 'btn-primary-custom active' : 'btn-outline-secondary' }} rounded-pill"
                                data-filter="listing_type" data-val="rent">{{ __('messages.common.rent') }}</button>
                        </div>
                    </div>

                    <!-- Property Type -->
                    <div class="mb-3">
                        <h6>{{ __('messages.filter.property_type') }}</h6>
                        @foreach (['land', 'flat', 'house', 'commercial'] as $val)
                            <div class="form-check">
                                <input class="form-check-input filter-check" type="radio" name="type_radio"
                                    id="type_{{ $val }}" data-filter="type" data-val="{{ $val }}"
                                    {{ ($filters['type'] ?? '') === $val ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="type_{{ $val }}">{{ __('messages.types.' . $val) }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                        <h6>{{ __('messages.filter.location') }}</h6>
                        <select class="form-select form-select-sm mb-2 filter-select" data-filter="division">
                            <option value="">{{ __('messages.filter.all_divisions') }}</option>
                            @foreach ($divisions as $d)
                                <option value="{{ $d }}"
                                    {{ ($filters['division'] ?? '') === $d ? 'selected' : '' }}>{{ $d }}
                                </option>
                            @endforeach
                        </select>
                        <select class="form-select form-select-sm filter-select" data-filter="district">
                            <option value="">{{ __('messages.filter.all_districts') }}</option>
                            @foreach ($districts as $d)
                                <option value="{{ $d }}"
                                    {{ ($filters['district'] ?? '') === $d ? 'selected' : '' }}>{{ $d }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-3">
                        <h6>{{ __('messages.filter.price_range') }}</h6>
                        <div class="d-flex price-range-inputs">
                            <input type="number" class="form-control form-control-sm filter-input" data-filter="min_price"
                                placeholder="{{ __('messages.filter.min') }}" value="{{ $filters['min_price'] ?? '' }}">
                            <input type="number" class="form-control form-control-sm filter-input" data-filter="max_price"
                                placeholder="{{ __('messages.filter.max') }}" value="{{ $filters['max_price'] ?? '' }}">
                        </div>
                    </div>

                    <!-- Bedrooms -->
                    <div class="mb-3">
                        <h6>{{ __('messages.filter.min_bedrooms') }}</h6>
                        <select class="form-select form-select-sm filter-select" data-filter="bedrooms">
                            <option value="">{{ __('messages.common.any') }}</option>
                            @foreach ([1, 2, 3, 4, 5] as $b)
                                <option value="{{ $b }}"
                                    {{ ($filters['bedrooms'] ?? '') == $b ? 'selected' : '' }}>{{ $b }}+
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-accent w-100 rounded-pill" id="applyFiltersBtn">
                        <i class="bi bi-funnel me-1"></i>{{ __('messages.filter.apply') }}
                    </button>
                </div>
            </div>

            <!-- Property Grid -->
            <div class="col-lg-9">
                <!-- Sort bar -->
                <div class="sort-bar d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <span id="resultCountBar" style="font-size:0.9rem;color:var(--text-muted);">
                        {{ __('messages.filter.found', ['count' => $properties->total()]) }}
                    </span>
                    <select class="form-select form-select-sm w-auto" id="sortSelect">
                        <option value="latest">{{ __('messages.filter.sort_latest') }}</option>
                        <option value="price_asc">{{ __('messages.filter.sort_price_asc') }}</option>
                        <option value="price_desc">{{ __('messages.filter.sort_price_desc') }}</option>
                        <option value="size_asc">{{ __('messages.filter.sort_size_asc') }}</option>
                    </select>
                </div>

                <!-- Loading spinner -->
                <div id="loadingSpinner" class="text-center py-4 d-none">
                    <div class="spinner-border" style="color:var(--accent);" role="status">
                        <span class="visually-hidden">{{ __('messages.common.loading') }}</span>
                    </div>
                </div>

                <!-- Properties grid -->
                <div class="row g-4" id="propertiesGrid">
                    @include('partials.property-cards', ['properties' => $properties])
                </div>

                <!-- Pagination -->
                <div class="mt-4" id="paginationWrapper">
                    {{ $properties->appends($filters)->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {
            let currentFilters = {!! json_encode($filters) !!};

            // Localized result-count templates ('__COUNT__' is replaced at runtime).
            const i18n = {
                showing: @json(__('messages.filter.showing', ['count' => '__COUNT__'])),
                found: @json(__('messages.filter.found', ['count' => '__COUNT__'])),
            };

            // Filter state tracker
            function getFilters() {
                let filters = {};

                // Listing type buttons
                $('.filter-type-btn.active').each(function() {
                    const key = $(this).data('filter');
                    const val = $(this).data('val');
                    if (val) filters[key] = val;
                });

                // Radio checks
                $('.filter-check:checked').each(function() {
                    const key = $(this).data('filter');
                    const val = $(this).data('val');
                    if (val) filters[key] = val;
                });

                // Selects
                $('.filter-select').each(function() {
                    const key = $(this).data('filter');
                    const val = $(this).val();
                    if (val) filters[key] = val;
                });

                // Text/number inputs
                $('.filter-input').each(function() {
                    const key = $(this).data('filter');
                    const val = $(this).val();
                    if (val) filters[key] = val;
                });

                return filters;
            }

            function fetchProperties(filters, page) {
                $('#loadingSpinner').removeClass('d-none');
                $('#propertiesGrid').css('opacity', 0.5);

                const params = Object.assign({}, filters, page ? {
                    page
                } : {});

                $.get('{{ route('properties.index') }}', params, function(data) {
                    $('#propertiesGrid').html(data.html).css('opacity', 1);
                    $('#loadingSpinner').addClass('d-none');
                    $('#resultCount').text(i18n.showing.replace('__COUNT__', data.total));
                    $('#resultCountBar').text(i18n.found.replace('__COUNT__', data.total));

                    // Update URL without reload
                    const searchParams = new URLSearchParams(params);
                    window.history.replaceState({}, '', '?' + searchParams.toString());
                }).fail(function() {
                    $('#loadingSpinner').addClass('d-none');
                    $('#propertiesGrid').css('opacity', 1);
                });
            }

            // Listing type toggle buttons
            $(document).on('click', '.filter-type-btn', function() {
                $('.filter-type-btn[data-filter="' + $(this).data('filter') + '"]').removeClass(
                    'active btn-primary-custom').addClass('btn-outline-secondary');
                $(this).removeClass('btn-outline-secondary').addClass('active btn-primary-custom');
            });

            // Apply filters button
            $('#applyFiltersBtn').on('click', function() {
                currentFilters = getFilters();
                fetchProperties(currentFilters);
            });

            // Sort change
            $('#sortSelect').on('change', function() {
                currentFilters.sort = $(this).val();
                fetchProperties(currentFilters);
            });

            // Price filter inputs — debounced
            let priceTimer;
            $('.filter-input').on('input', function() {
                clearTimeout(priceTimer);
                priceTimer = setTimeout(() => {}, 500);
            });
        });
    </script>

    <style>
        .btn-primary-custom {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }
    </style>
@endpush
