@extends('layouts.app')
@section('title', __('messages.nav.login'))

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;padding:3rem 0;background:var(--bg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div style="text-align:center;margin-bottom:2rem;">
                    <h2 style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:2.2rem;">{{ __('messages.auth.welcome_back') }}</h2>
                    <p style="color:var(--text-muted);">{{ __('messages.auth.sign_in_subtitle', ['site' => $siteSettings['site_name'] ?? 'LandMark Realty']) }}</p>
                </div>
                <div style="background:var(--white);border-radius:var(--radius-lg);padding:2.5rem;box-shadow:var(--card-shadow);border:1px solid var(--border);">
                    @if($errors->any())
                    <div class="alert alert-danger" style="font-size:0.88rem;">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.auth.email_address') }}</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="your@email.com" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.auth.password') }}</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember" style="font-size:0.85rem;">{{ __('messages.auth.remember_me') }}</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-accent w-100 py-2 rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('messages.auth.sign_in') }}
                        </button>
                    </form>

                    <div style="text-align:center;margin-top:1.5rem;font-size:0.88rem;color:var(--text-muted);">
                        {{ __('messages.auth.no_account') }} <a href="{{ route('register') }}" style="color:var(--accent);font-weight:600;">{{ __('messages.auth.register_here') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
