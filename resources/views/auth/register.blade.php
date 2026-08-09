@extends('layouts.app')
@section('title', __('messages.auth.create_account'))

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;padding:3rem 0;background:var(--bg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div style="text-align:center;margin-bottom:2rem;">
                    <h2 style="font-family:'Cormorant Garamond',serif;color:var(--primary);font-size:2.2rem;">{{ __('messages.auth.create_account') }}</h2>
                    <p style="color:var(--text-muted);">{{ __('messages.auth.register_subtitle', ['site' => $siteSettings['site_name'] ?? 'LandMark Realty']) }}</p>
                </div>
                <div style="background:var(--white);border-radius:var(--radius-lg);padding:2.5rem;box-shadow:var(--card-shadow);border:1px solid var(--border);">
                    @if($errors->any())
                    <div class="alert alert-danger" style="font-size:0.88rem;">
                        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.auth.full_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('messages.booking.name_ph') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.auth.email_address') }} <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="your@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.auth.phone_number') }}</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+880 1XXX-XXXXXX">
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.auth.password') }} <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="{{ __('messages.auth.password_hint') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:0.88rem;">{{ __('messages.auth.confirm_password') }} <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('messages.auth.repeat_password') }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-accent w-100 py-2 rounded-pill">
                            <i class="bi bi-person-check me-2"></i>{{ __('messages.auth.create_account') }}
                        </button>
                    </form>
                    <div style="text-align:center;margin-top:1.5rem;font-size:0.88rem;color:var(--text-muted);">
                        {{ __('messages.auth.have_account') }} <a href="{{ route('login') }}" style="color:var(--accent);font-weight:600;">{{ __('messages.auth.sign_in_link') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
