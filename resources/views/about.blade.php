@extends('layouts.app')
@section('title', __('messages.nav.about'))

@section('content')
<!-- Page Hero -->
<div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));padding:3.5rem 0 3rem;">
    <div class="container text-center">
        <h1 style="font-family:'Cormorant Garamond',serif;color:#fff;font-size:3rem;">{{ $siteSettings['about_hero_title'] ?? 'About LandMark Realty' }}</h1>
        <p style="color:rgba(255,255,255,0.75);font-size:1.05rem;max-width:600px;margin:1rem auto 0;">{{ $siteSettings['about_hero_subtitle'] ?? "Bangladesh's most trusted real estate company, dedicated to helping families and businesses find their perfect space." }}</p>
    </div>
</div>

<div class="container py-5">
    <!-- Story section -->
    <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
            <p style="color:var(--accent);font-weight:600;letter-spacing:1.5px;text-transform:uppercase;font-size:0.82rem;">{{ $siteSettings['about_story_label'] ?? 'Our Story' }}</p>
            <h2 style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:2.4rem;margin-bottom:1.2rem;">{!! nl2br(e($siteSettings['about_story_title'] ?? 'A Decade of Building Dreams')) !!}</h2>
            @if(!empty($siteSettings['about_story_para1']))
            <p style="color:var(--text-muted);line-height:1.9;margin-bottom:1rem;">{{ $siteSettings['about_story_para1'] }}</p>
            @endif
            @if(!empty($siteSettings['about_story_para2']))
            <p style="color:var(--text-muted);line-height:1.9;margin-bottom:1rem;">{{ $siteSettings['about_story_para2'] }}</p>
            @endif
            @if(!empty($siteSettings['about_story_para3']))
            <p style="color:var(--text-muted);line-height:1.9;">{{ $siteSettings['about_story_para3'] }}</p>
            @endif
            <a href="{{ route('contact') }}" class="btn btn-accent rounded-pill px-4 mt-3">
                <i class="bi bi-telephone me-2"></i>{{ __('messages.about.talk_to_experts') }}
            </a>
        </div>
        <div class="col-lg-6">
            @php
            $aboutStats = [
                [$siteSettings['about_stat1_value'] ?? '10+', $siteSettings['about_stat1_label'] ?? 'Years in Business'],
                [$siteSettings['about_stat2_value'] ?? '500+', $siteSettings['about_stat2_label'] ?? 'Deals Completed'],
                [$siteSettings['about_stat3_value'] ?? '1200+', $siteSettings['about_stat3_label'] ?? 'Happy Clients'],
                [$siteSettings['about_stat4_value'] ?? '50+', $siteSettings['about_stat4_label'] ?? 'Expert Agents'],
            ];
            @endphp
            <div class="row g-3">
                @foreach($aboutStats as $s)
                <div class="col-6">
                    <div style="background:var(--white);border-radius:var(--radius-lg);padding:2rem;text-align:center;box-shadow:var(--card-shadow);border:1px solid var(--border);">
                        <div style="font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:700;color:var(--accent);">{{ $s[0] }}</div>
                        <div style="color:var(--text-muted);font-size:0.85rem;margin-top:0.3rem;">{{ $s[1] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Values -->
    <div class="py-4">
        <div class="text-center mb-4">
            <h2 style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:2.2rem;">{{ $siteSettings['about_values_title'] ?? 'Our Core Values' }}</h2>
            <div class="gold-line"></div>
        </div>
        @php
        $aboutValues = array_values(array_filter([
            [$siteSettings['about_value1_icon'] ?? 'bi-shield-check', $siteSettings['about_value1_title'] ?? 'Integrity',    $siteSettings['about_value1_text'] ?? 'We never compromise on honesty. Every property listed is verified, every price is fair, and every transaction is transparent.'],
            [$siteSettings['about_value2_icon'] ?? 'bi-star',         $siteSettings['about_value2_title'] ?? 'Excellence',   $siteSettings['about_value2_text'] ?? 'We hold ourselves to the highest standard in every interaction — from the way we present properties to how we handle negotiations.'],
            [$siteSettings['about_value3_icon'] ?? 'bi-people-fill',  $siteSettings['about_value3_title'] ?? 'Client-First', $siteSettings['about_value3_text'] ?? 'Your goals are our goals. We listen, understand your requirements deeply, and match you only with properties that truly fit.'],
            [$siteSettings['about_value4_icon'] ?? 'bi-lightbulb',    $siteSettings['about_value4_title'] ?? 'Innovation',   $siteSettings['about_value4_text'] ?? 'We continuously adopt new technologies and processes to make property search and purchase faster and more convenient.'],
        ], fn($v) => !empty($v[1])));
        @endphp
        <div class="row g-4">
            @foreach($aboutValues as $v)
            <div class="col-md-6 col-lg-3">
                <div style="background:var(--white);border-radius:var(--radius-lg);padding:2rem;box-shadow:var(--card-shadow);border:1px solid var(--border);height:100%;text-align:center;">
                    <div style="width:64px;height:64px;background:linear-gradient(135deg,var(--accent),var(--accent-light));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;">
                        <i class="bi {{ $v[0] }}" style="color:#fff;font-size:1.6rem;"></i>
                    </div>
                    <h5 style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:1.3rem;">{{ $v[1] }}</h5>
                    <p style="color:var(--text-muted);font-size:0.88rem;margin:0;">{{ $v[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Testimonials -->
    @if($testimonials->count())
    <div class="py-5">
        <div class="text-center mb-4">
            <h2 style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:2.2rem;">{{ __('messages.about.testimonials_title') }}</h2>
            <div class="gold-line"></div>
        </div>
        <div class="row g-4">
            @foreach($testimonials->take(3) as $t)
            <div class="col-md-4">
                <div style="background:var(--white);border-radius:var(--radius-lg);padding:1.8rem;box-shadow:var(--card-shadow);border:1px solid var(--border);height:100%;">
                    <div style="color:#f4b400;margin-bottom:0.8rem;">
                        @for($i = 0; $i < 5; $i++)<i class="bi bi-star{{ $i < $t->rating ? '-fill' : '' }}"></i>@endfor
                    </div>
                    <p style="font-size:0.9rem;color:var(--text);line-height:1.8;">"{{ $t->message }}"</p>
                    <div class="d-flex align-items-center mt-auto pt-2">
                        @if($t->image_url)
                            <img src="{{ $t->image_url }}" class="rounded-circle me-3" width="44" height="44" style="object-fit:cover;" alt="{{ $t->name }}">
                        @else
                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:var(--primary);color:var(--accent-light);font-weight:700;font-family:'Cormorant Garamond',serif;font-size:1.2rem;">{{ substr($t->name,0,1) }}</div>
                        @endif
                        <div>
                            <strong style="font-size:0.9rem;color:var(--primary);">{{ $t->name }}</strong>
                            @if($t->designation)<div style="font-size:0.75rem;color:var(--text-muted);">{{ $t->designation }}</div>@endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
