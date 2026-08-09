@forelse($properties as $property)
<div class="col-md-6 col-lg-4 property-col">
    @include('partials.property-card', ['property' => $property])
</div>
@empty
<div class="col-12">
    <div class="text-center py-5">
        <i class="bi bi-house-x" style="font-size:4rem;color:var(--border);"></i>
        <h5 class="mt-3" style="color:var(--text-muted);">{{ __('messages.filter.none_found') }}</h5>
        <p class="text-muted">{{ __('messages.filter.none_hint') }}</p>
    </div>
</div>
@endforelse
