@extends('layouts.app')

@section('title', $siteSettings['site_name'] ?? 'LandMark Realty')
@section('title_suffix', $siteSettings['site_tagline'] ?? 'Your Trusted Real Estate Partner in Bangladesh')

@push('styles')
<style>
    /* Hero */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, #1e3a5f 100%);
        min-height: 620px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23b8962e' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .hero-content { position: relative; z-index: 1; }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.2rem, 5vw, 3.8rem);
        font-weight: 700;
        color: #fff;
        line-height: 1.2;
    }

    .hero-title span { color: var(--accent-light); }

    .hero-subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 1.05rem;
        margin: 1.2rem 0 2rem;
    }

    /* Search box */
    .search-box {
        background: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 16px 60px rgba(0,0,0,0.25);
        margin-top: 2rem;
    }

    .search-box .form-control, .search-box .form-select {
        border: 1.5px solid #e2d9c8;
        height: 48px;
    }

    .search-box .btn-search {
        height: 48px;
        background: var(--accent);
        border: none;
        color: #fff;
        font-weight: 600;
        border-radius: 8px;
        padding: 0 1.5rem;
        white-space: nowrap;
        transition: all 0.25s;
    }

    .search-box .btn-search:hover { background: var(--accent-light); }

    /* Hero buttons responsive */
    .hero-btn {
        font-size: 0.95rem;
        min-width: 140px;
        text-align: center;
    }

    @media (max-width: 480px) {
        .hero-btn {
            width: 100%;
            font-size: 0.9rem;
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }

    /* Stats strip */
    .stats-strip {
        background: var(--primary);
        padding: 2rem 0;
    }

    .stat-item { text-align: center; }
    .stat-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.4rem;
        font-weight: 700;
        color: var(--accent-light);
    }

    .stat-label { color: rgba(255,255,255,0.75); font-size: 0.85rem; margin-top: 0.2rem; }

    /* Category cards */
    .cat-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: var(--card-shadow);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .cat-card:hover {
        background: var(--primary);
        color: #fff;
        transform: translateY(-6px);
        box-shadow: var(--card-shadow-hover);
    }

    .cat-card i {
        font-size: 2.5rem;
        color: var(--accent);
        margin-bottom: 1rem;
        display: block;
        transition: color 0.3s;
    }

    .cat-card:hover i { color: var(--accent-light); }

    .cat-card h6 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.3rem;
    }

    .cat-card small { font-size: 0.8rem; color: var(--text-muted); }
    .cat-card:hover small { color: rgba(255,255,255,0.6); }

    /* Why choose us */
    .why-card {
        padding: 2rem;
        border-radius: var(--radius-lg);
        background: var(--white);
        box-shadow: var(--card-shadow);
        height: 100%;
        border-left: 4px solid var(--accent);
        transition: transform 0.3s;
    }

    .why-card:hover { transform: translateY(-4px); }

    .why-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--accent), var(--accent-light));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.2rem;
    }

    .why-icon i { font-size: 1.5rem; color: #fff; }

    /* Testimonials */
    .testimonial-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid var(--border);
        height: 100%;
    }

    .testimonial-card .stars { color: #f4b400; font-size: 0.9rem; }

    .testimonial-card .quote {
        font-size: 3rem;
        color: var(--accent);
        line-height: 0.8;
        font-family: 'Cormorant Garamond', serif;
        opacity: 0.3;
    }

    .swiper-pagination-bullet-active { background: var(--accent) !important; }
</style>
@endpush

@section('content')

<!-- Hero Section -->
  <section class="hero-section"
        style="
        background-image: url('{{ asset('images/hero.webp') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    ">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 hero-content">
               <p class="d-none d-md-block" style="color:var(--accent-light);font-size:0.85rem;font-weight:600;letter-spacing:2px;text-transform:uppercase;margin-bottom:0.5rem;">
                    <i class="bi bi-star-fill me-1"></i>{{ $siteSettings['home_hero_badge'] ?? "Bangladesh's Trusted Real Estate Platform" }}
                </p>
                <h1 class="hero-title">{{ $siteSettings['home_hero_title'] ?? 'Find Your Perfect Property in Bangladesh' }}</h1>
                <p class="hero-subtitle">{{ $siteSettings['home_hero_subtitle'] ?? 'Explore thousands of verified land, flats, houses and commercial properties for sale and rent. Your dream property is just a search away.' }}</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('properties.index') }}?listing_type=sale" class="btn btn-accent px-4 py-2 rounded-pill hero-btn">
                        <i class="bi bi-house-check me-2"></i>{{ __('messages.common.buy_property') }}
                    </a>
                    <a href="{{ route('properties.index') }}?listing_type=rent" class="btn btn-outline-light px-4 py-2 rounded-pill hero-btn">
                        <i class="bi bi-key me-2"></i>{{ __('messages.common.rent_property') }}
                    </a>
                </div>

                <!-- Search Box -->
                <div class="search-box">
                    <form action="{{ route('properties.index') }}" method="GET" id="heroSearchForm">
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-md-4">
                                <input type="text" name="area" class="form-control" placeholder="{{ __('messages.home.search_location_ph') }}">
                            </div>
                            <div class="col-6 col-md-2">
                                <select name="type" class="form-select">
                                    <option value="">{{ __('messages.common.any_type') }}</option>
                                    <option value="land">{{ __('messages.types.land') }}</option>
                                    <option value="flat">{{ __('messages.types.flat') }}</option>
                                    <option value="house">{{ __('messages.types.house') }}</option>
                                    <option value="commercial">{{ __('messages.types.commercial') }}</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-2">
                                <select name="listing_type" class="form-select">
                                    <option value="">{{ __('messages.common.sale_rent') }}</option>
                                    <option value="sale">{{ __('messages.common.for_sale') }}</option>
                                    <option value="rent">{{ __('messages.common.for_rent') }}</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-2">
                                <select name="max_price" class="form-select">
                                    <option value="">{{ __('messages.home.max_price') }}</option>
                                    <option value="1000000">{{ __('messages.home.price_10lac') }}</option>
                                    <option value="5000000">{{ __('messages.home.price_50lac') }}</option>
                                    <option value="10000000">{{ __('messages.home.price_1crore') }}</option>
                                    <option value="50000000">{{ __('messages.home.price_5crore') }}</option>
                                    <option value="100000000">{{ __('messages.home.price_10crore') }}</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-2">
                                <button type="submit" class="btn btn-search w-100">
                                    <i class="bi bi-search me-1"></i> {{ __('messages.common.search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Strip -->
<section class="stats-strip">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($stats['total_properties']) }}+</div>
                    <div class="stat-label">{{ $siteSettings['home_stats_properties'] ?? 'Available Properties' }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($stats['total_sold']) }}+</div>
                    <div class="stat-label">{{ $siteSettings['home_stats_sold_label'] ?? 'Successful Deals' }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($stats['happy_clients']) }}+</div>
                    <div class="stat-label">{{ $siteSettings['home_stats_clients_label'] ?? __('messages.home.stats_clients') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-item">
                    <div class="stat-number">{{ $stats['years_experience'] }}+</div>
                    <div class="stat-label">{{ $siteSettings['home_stats_years_label'] ?? __('messages.home.stats_years') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-5 mt-2">
    <div class="container">
        <div class="text-center">
            <p style="color:var(--accent);font-weight:600;letter-spacing:1.5px;text-transform:uppercase;font-size:0.82rem;">{{ __('messages.home.browse_by') }}</p>
            <h2 class="section-title">{{ __('messages.home.categories_title') }}</h2>
            <div class="gold-line"></div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($categories as $cat)
            <div class="col-6 col-md-3">
                <a href="{{ route('properties.index') }}?category_id={{ $cat->id }}" class="cat-card">
                    <i class="bi {{ $cat->icon ?? 'bi-building' }}"></i>
                    <h6>{{ $cat->name }}</h6>
                    <small>{{ $cat->properties_count }} {{ app()->getLocale() === 'en' ? Str::plural('property', $cat->properties_count) : __('messages.common.properties') }}</small>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Properties -->
<section class="py-5" style="background: linear-gradient(180deg, var(--bg) 0%, #f0ebe0 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <p style="color:var(--accent);font-weight:600;letter-spacing:1.5px;text-transform:uppercase;font-size:0.82rem;">{{ __('messages.home.handpicked') }}</p>
                <h2 class="section-title mb-0">{{ __('messages.home.featured_title') }}</h2>
                <div class="gold-line" style="margin:0.8rem 0 0;"></div>
            </div>
            <a href="{{ route('properties.index') }}" class="btn btn-outline-accent rounded-pill px-4 d-none d-md-inline-flex">
                {{ __('messages.common.view_all') }} <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($featuredProperties as $property)
            <div class="col-md-6 col-lg-4">
                @include('partials.property-card', ['property' => $property])
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">{{ __('messages.home.no_featured') }}</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-4 d-md-none">
            <a href="{{ route('properties.index') }}" class="btn btn-outline-accent rounded-pill px-4">{{ __('messages.common.view_all_properties') }}</a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container">
        <div class="text-center">
            <p style="color:var(--accent);font-weight:600;letter-spacing:1.5px;text-transform:uppercase;font-size:0.82rem;">{{ __('messages.home.why_us') }}</p>
            <h2 class="section-title">{{ $siteSettings['home_why_title'] ?? 'Why Choose LandMark Realty?' }}</h2>
            <div class="gold-line"></div>
            <p class="section-subtitle">{{ $siteSettings['home_why_subtitle'] ?? 'We stand apart with our commitment to transparency, verified listings, and exceptional customer care.' }}</p>
        </div>
        @php
        $whyCards = [
            [$siteSettings['home_why_card1_icon'] ?? 'bi-shield-check', $siteSettings['home_why_card1_title'] ?? 'Verified Listings', $siteSettings['home_why_card1_text'] ?? 'Every property is personally verified by our team. No fraud, no fake listings — only authentic, legally clear properties.'],
            [$siteSettings['home_why_card2_icon'] ?? 'bi-people', $siteSettings['home_why_card2_title'] ?? 'Expert Guidance', $siteSettings['home_why_card2_text'] ?? 'Our experienced team guides you from property search to final registration, making the process smooth and stress-free.'],
            [$siteSettings['home_why_card3_icon'] ?? 'bi-clock-history', $siteSettings['home_why_card3_title'] ?? 'Fast & Efficient', $siteSettings['home_why_card3_text'] ?? 'We respect your time. From first inquiry to deal close, we ensure the fastest possible turnaround without cutting corners.'],
            [$siteSettings['home_why_card4_icon'] ?? 'bi-hand-thumbs-up', $siteSettings['home_why_card4_title'] ?? 'After-Sale Support', $siteSettings['home_why_card4_text'] ?? "Our relationship doesn't end at the deal. We provide ongoing support including documentation and mutation assistance."],
        ];
        @endphp
        <div class="row g-4">
            @foreach($whyCards as $w)
            <div class="col-md-6 col-lg-3">
                <div class="why-card">
                    <div class="why-icon"><i class="bi {{ $w[0] }}"></i></div>
                    <h5 style="font-size:1.2rem;margin-bottom:0.6rem;">{{ $w[1] }}</h5>
                    <p class="text-muted mb-0" style="font-size:0.88rem;">{{ $w[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials -->
@if($testimonials->count())
<section class="py-5" style="background:#f0ebe0;">
    <div class="container">
        <div class="text-center">
            <p style="color:var(--accent);font-weight:600;letter-spacing:1.5px;text-transform:uppercase;font-size:0.82rem;">{{ __('messages.home.client_stories') }}</p>
            <h2 class="section-title">{{ __('messages.home.testimonials_title') }}</h2>
            <div class="gold-line"></div>
        </div>

        <div class="swiper testimonialSwiper mt-4">
            <div class="swiper-wrapper pb-4">
                @foreach($testimonials as $t)
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="stars mb-2">
                            @for($i = 0; $i < 5; $i++)
                                <i class="bi bi-star{{ $i < $t->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <div class="quote">"</div>
                        <p style="font-size:0.92rem;color:var(--text);margin:-0.5rem 0 1.2rem;">"{{ $t->message }}"</p>
                        <div class="d-flex align-items-center">
                            @if($t->image_url)
                                <img src="{{ $t->image_url }}" alt="{{ $t->name }}" class="rounded-circle me-3" width="48" height="48" style="object-fit:cover;">
                            @else
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:var(--primary);color:var(--accent-light);font-family:'Cormorant Garamond',serif;font-size:1.3rem;font-weight:700;">{{ substr($t->name,0,1) }}</div>
                            @endif
                            <div>
                                <strong style="font-size:0.95rem;color:var(--primary);">{{ $t->name }}</strong>
                                @if($t->designation)
                                <div style="font-size:0.78rem;color:var(--text-muted);">{{ $t->designation }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-3"></div>
        </div>
    </div>
</section>
@endif

<!-- CTA Banner -->
<section class="py-5" style="background:linear-gradient(135deg, var(--primary-dark), var(--primary));">
    <div class="container text-center">
        <h2 style="font-family:'Cormorant Garamond',serif;color:#fff;font-size:2.2rem;margin-bottom:1rem;">{{ $siteSettings['home_cta_title'] ?? 'Ready to Find Your Dream Property?' }}</h2>
        <p style="color:rgba(255,255,255,0.75);margin-bottom:2rem;">{{ $siteSettings['home_cta_subtitle'] ?? 'Talk to our experts today. Free consultation, no obligation.' }}</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('properties.index') }}" class="btn btn-accent px-5 py-2 rounded-pill">
                <i class="bi bi-search me-2"></i>{{ __('messages.common.browse_properties') }}
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-light px-5 py-2 rounded-pill">
                <i class="bi bi-telephone me-2"></i>{{ __('messages.common.contact_us') }}
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
new Swiper('.testimonialSwiper', {
    slidesPerView: 1,
    spaceBetween: 24,
    loop: true,
    autoplay: { delay: 5000, disableOnInteraction: false },
    pagination: { el: '.swiper-pagination', clickable: true },
    breakpoints: {
        640:  { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
    }
});
</script>
@endpush
