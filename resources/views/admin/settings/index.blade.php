@extends('layouts.admin')
@section('title', 'Settings')
@section('breadcrumb', 'Settings / ' . ($groups[$activeGroup]['label'] ?? 'General'))

@push('styles')
<style>
.settings-nav .nav-link {
    color: var(--text-muted);
    font-size: 0.85rem;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}
.settings-nav .nav-link.active,
.settings-nav .nav-link:hover {
    background: rgba(26,43,74,0.07);
    color: var(--primary);
}
.settings-nav .nav-link.active {
    font-weight: 600;
    color: var(--primary);
    background: rgba(184,150,46,0.1);
    border-left: 3px solid var(--accent);
}
.setting-row { padding: 1.2rem 0; border-bottom: 1px solid var(--border); }
.setting-row:last-child { border-bottom: none; }
.setting-label { font-size: 0.85rem; font-weight: 600; color: var(--text); margin-bottom: 0.25rem; }
.setting-key   { font-size: 0.72rem; color: var(--text-muted); font-family: monospace; }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title"><i class="bi bi-gear me-2" style="color:var(--accent);font-size:1.5rem;"></i>Settings</h1>
</div>

<div class="row g-4">
    <!-- Sidebar Navigation -->
    <div class="col-lg-3">
        <div class="admin-card">
            <div class="card-header" style="font-size:0.78rem;letter-spacing:1px;text-transform:uppercase;">Configuration</div>
            <div class="card-body p-2">
                <nav class="settings-nav d-flex flex-column gap-1">
                    @foreach($groups as $key => $meta)
                    <a href="{{ route('admin.settings.index', ['group' => $key]) }}"
                       class="nav-link {{ $activeGroup === $key ? 'active' : '' }}">
                        <i class="bi {{ $meta['icon'] }}"></i> {{ $meta['label'] }}
                    </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="col-lg-9">
        <div class="admin-card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="bi {{ $groups[$activeGroup]['icon'] }}" style="color:var(--accent);"></i>
                {{ $groups[$activeGroup]['label'] }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="group" value="{{ $activeGroup }}">

                    @foreach($settings as $key => $setting)
                    <div class="setting-row">
                        <div class="row align-items-start">
                            <div class="col-md-4">
                                <div class="setting-label">{{ $setting->label ?? ucwords(str_replace('_', ' ', $key)) }}</div>
                                <div class="setting-key">{{ $key }}</div>
                            </div>
                            <div class="col-md-8">
                                @if($setting->type === 'textarea')
                                    <textarea name="{{ $key }}" class="form-control" rows="3" placeholder="{{ $setting->label }}">{{ old($key, $setting->value) }}</textarea>

                                @elseif($setting->type === 'image')
                                    @if($setting->value)
                                    <div class="mb-2">
                                        <img src="{{ asset($setting->value) }}" alt="Current" style="max-height:60px;border-radius:6px;border:1px solid var(--border);" onerror="this.style.display='none'">
                                        <div style="font-size:0.72rem;color:var(--text-muted);margin-top:0.25rem;">Current: {{ $setting->value }}</div>
                                    </div>
                                    @endif
                                    <input type="file" name="{{ $key }}" class="form-control" accept="image/*">
                                    <div style="font-size:0.75rem;color:var(--text-muted);margin-top:0.3rem;">Leave empty to keep existing image.</div>

                                @elseif($setting->type === 'url')
                                    <input type="url" name="{{ $key }}" class="form-control" value="{{ old($key, $setting->value) }}" placeholder="https://...">

                                @elseif($setting->type === 'email')
                                    <input type="email" name="{{ $key }}" class="form-control" value="{{ old($key, $setting->value) }}" placeholder="email@example.com">

                                @elseif($setting->type === 'number')
                                    <input type="number" name="{{ $key }}" class="form-control" value="{{ old($key, $setting->value) }}" placeholder="0">

                                @else
                                    <input type="text" name="{{ $key }}" class="form-control" value="{{ old($key, $setting->value) }}" placeholder="{{ $setting->label }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if($settings->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-exclamation-circle fs-3 d-block mb-2"></i>
                        No settings found for this group. Run <code>php artisan db:seed --class=SettingSeeder</code> to initialize.
                    </div>
                    @endif

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-accent px-4 py-2 rounded-pill">
                            <i class="bi bi-check-lg me-2"></i>Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
