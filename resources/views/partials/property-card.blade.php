  <a href="{{ route('properties.show', $property->slug) }}">
      <div class="property-card h-100">

          <div class="card-img-wrapper">


              @php
                  $firstImage = $property->images->first();
              @endphp

              @if ($firstImage)
                  <img src="{{ asset('uploads/' . $firstImage->image_path) }}" alt="{{ $property->title }}" loading="lazy"
                      onerror="this.onerror=null;this.src='{{ asset('images/no-image.svg') }}'">
              @else
                  <img src="{{ asset('images/no-image.svg') }}" alt="{{ $property->title }}" loading="lazy">
              @endif

              <span class="badge-status badge-{{ $property->listing_type === 'rent' ? 'rent' : 'sale' }}">

                  {{ $property->listing_type === 'rent' ? __('messages.common.for_rent') : __('messages.common.for_sale') }}

              </span>

              @if ($property->featured)
                  <span class="badge-status badge-featured" style="left:auto;right:12px;">

                      {{ __('messages.common.featured') }}

                  </span>
              @endif

          </div>

          <div class="p-3 d-flex flex-column" style="flex:1;">
              <div class="d-flex justify-content-between align-items-start mb-1">
                  <span class="card-price">{!! $property->price_html !!}</span>
                  @if ($property->price_unit)
                      <small class="text-muted ms-1 mt-1" style="font-size:0.72rem;">{{ $property->price_unit }}</small>
                  @endif
              </div>
              <a href="{{ route('properties.show', $property->slug) }}" class="card-title mb-2 d-block"
                  style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $property->title }}</a>
              <div class="d-flex flex-wrap gap-2 mb-2">
                  <span class="prop-meta"><i class="bi bi-tag"></i>{{ __('messages.types.' . $property->type) }}</span>
                  <span class="prop-meta"><i class="bi bi-rulers"></i>{{ $property->size }}
                      {{ $property->size_unit }}</span>
                  @if ($property->bedrooms)
                      <span class="prop-meta"><i class="bi bi-door-closed"></i>{{ $property->bedrooms }}
                          {{ __('messages.common.bed') }}</span>
                  @endif
                  @if ($property->bathrooms)
                      <span class="prop-meta"><i class="bi bi-droplet"></i>{{ $property->bathrooms }}
                          {{ __('messages.common.bath') }}</span>
                  @endif
              </div>
              <p class="prop-meta mt-auto pt-2 border-top mb-0" style="border-color:var(--border)!important;">
                  <i
                      class="bi bi-geo-alt-fill me-1"></i>{{ $property->area ? $property->area . ', ' : '' }}{{ $property->district }}
              </p>
          </div>
      </div>
  </a>
