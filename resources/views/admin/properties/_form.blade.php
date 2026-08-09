@if($errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0 ps-3" style="font-size:0.85rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Basic Info -->
        <div class="admin-card mb-4">
            <div class="card-header">Basic Information</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Property Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $property->title ?? '') }}" placeholder="e.g. Premium Land in Bashundhara R/A" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="6" placeholder="Detailed property description..." required>{{ old('description', $property->description ?? '') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $property->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Property Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required id="typeSelect">
                            <option value="">Select Type</option>
                            @foreach(['land' => 'Land', 'flat' => 'Flat', 'house' => 'House', 'commercial' => 'Commercial'] as $v => $l)
                            <option value="{{ $v }}" {{ old('type', $property->type ?? '') === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Listing Type <span class="text-danger">*</span></label>
                        <select name="listing_type" class="form-select" required>
                            @foreach(['sale' => 'For Sale', 'rent' => 'For Rent'] as $v => $l)
                            <option value="{{ $v }}" {{ old('listing_type', $property->listing_type ?? '') === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Price & Size -->
        <div class="admin-card mb-4">
            <div class="card-header">Price & Dimensions</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Price (৳) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $property->price ?? '') }}" placeholder="0.00" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price Unit</label>
                        <input type="text" name="price_unit" class="form-control" value="{{ old('price_unit', $property->price_unit ?? '') }}" placeholder="e.g. per katha, total">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Size <span class="text-danger">*</span></label>
                        <input type="number" name="size" class="form-control" value="{{ old('size', $property->size ?? '') }}" placeholder="0.00" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Size Unit <span class="text-danger">*</span></label>
                        <select name="size_unit" class="form-select" required>
                            @foreach(['katha', 'bigha', 'decimal', 'sft', 'acre'] as $u)
                            <option value="{{ $u }}" {{ old('size_unit', $property->size_unit ?? 'katha') === $u ? 'selected' : '' }}>{{ strtoupper($u) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 bedroom-bath-field">
                        <label class="form-label">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control" value="{{ old('bedrooms', $property->bedrooms ?? '') }}" placeholder="0" min="0">
                    </div>
                    <div class="col-md-3 bedroom-bath-field">
                        <label class="form-label">Bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control" value="{{ old('bathrooms', $property->bathrooms ?? '') }}" placeholder="0" min="0">
                    </div>
                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="admin-card mb-4">
            <div class="card-header">Location Details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Full Address / Location Text <span class="text-danger">*</span></label>
                    <input type="text" name="location_text" class="form-control" value="{{ old('location_text', $property->location_text ?? '') }}" placeholder="e.g. Block-C, Bashundhara R/A, Dhaka" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Division</label>
                        <input type="text" name="division" class="form-control" value="{{ old('division', $property->division ?? '') }}" placeholder="e.g. Dhaka">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">District</label>
                        <input type="text" name="district" class="form-control" value="{{ old('district', $property->district ?? '') }}" placeholder="e.g. Dhaka">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Area / Thana</label>
                        <input type="text" name="area" class="form-control" value="{{ old('area', $property->area ?? '') }}" placeholder="e.g. Gulshan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $property->latitude ?? '') }}" placeholder="23.7465">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $property->longitude ?? '') }}" placeholder="90.3760">
                    </div>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="admin-card mb-4">
            <div class="card-header">Property Images</div>
            <div class="card-body">
                <!-- Existing images -->
                @if(isset($property) && $property->images->count())
                <label class="form-label">Existing Images</label>
                <div class="img-preview-grid mb-3" id="existingImages">
                    @foreach($property->images->sortBy('sort_order') as $img)
                    <div class="img-preview-item" data-id="{{ $img->id }}" data-order="{{ $img->sort_order }}">
                        <img src="{{ $img->url }}" alt="">
                        @if($img->is_primary)
                        <div style="position:absolute;bottom:2px;left:2px;background:var(--accent);color:#fff;font-size:0.55rem;padding:1px 5px;border-radius:3px;">PRIMARY</div>
                        @endif
                        <button type="button" class="remove-img" data-id="{{ $img->id }}" title="Remove"><i class="bi bi-x"></i></button>
                    </div>
                    @endforeach
                </div>
                <input type="hidden" name="delete_images" id="deleteImagesInput">
                <input type="hidden" name="image_order" id="imageOrderInput">
                <p style="font-size:0.78rem;color:var(--text-muted);margin-bottom:1rem;"><i class="bi bi-info-circle me-1"></i>Drag to reorder. Click × to mark for deletion. Changes save on form submit.</p>
                @endif

                <!-- New images upload -->
                
            <div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Agent Name</label>
        <input
            type="text"
            name="agent_name"
            class="form-control"
            value="{{ old('agent_name', isset($property) ? $property->agent_name : '') }}"
            placeholder="Agent Name">
    </div>

    <div class="col-md-6">
        <label class="form-label">Agent Phone</label>
        <input
            type="text"
            name="agent_phone"
            class="form-control"
            value="{{ old('agent_phone', isset($property) ? $property->agent_phone : '') }}"
            placeholder="Agent Phone">
    </div>
</div>
                
                <label class="form-label">{{ isset($property) ? 'Add More Images' : 'Upload Images' }}</label>
                <input type="file" name="images[]" id="imageUpload" class="form-control" multiple accept="image/*">
                <div class="img-preview-grid mt-2" id="newImagesPreview"></div>
                <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.5rem;">Max 5MB per image. JPG, PNG, WEBP. First image becomes primary.</div>
            </div>
        </div>

        <!-- SEO -->
        <div class="admin-card mb-4">
            <div class="card-header">SEO Settings</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Meta Title <small class="text-muted">(max 200 chars)</small></label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $property->meta_title ?? '') }}" maxlength="200">
                </div>
                <div>
                    <label class="form-label">Meta Description <small class="text-muted">(max 300 chars)</small></label>
                    <textarea name="meta_description" class="form-control" rows="2" maxlength="300">{{ old('meta_description', $property->meta_description ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Right sidebar -->
    <div class="col-lg-4">
        <!-- Publish options -->
        <div class="admin-card mb-4">
            <div class="card-header">Publish Settings</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['available' => 'Available', 'booked' => 'Booked', 'sold' => 'Sold', 'rented' => 'Rented'] as $v => $l)
                        <option value="{{ $v }}" {{ old('status', $property->status ?? 'available') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck" value="1"
                        {{ old('featured', $property->featured ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="featuredCheck">
                        <i class="bi bi-star-fill me-1" style="color:var(--accent);"></i>Featured Property
                    </label>
                </div>
                <button type="submit" class="btn btn-accent w-100 py-2">
                    <i class="bi bi-check-lg me-2"></i>{{ isset($property) ? 'Update Property' : 'Publish Property' }}
                </button>
            </div>
        </div>

        <!-- Video Tour -->
        <div class="admin-card mb-4">
            <div class="card-header"><i class="bi bi-play-circle me-1"></i>Video Tour</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">YouTube Video URL</label>
                    <input type="text" name="youtube_link" class="form-control" value="{{ old('youtube_link', $property->youtube_link ?? '') }}" placeholder="https://youtu.be/... or youtube.com/watch?v=...">
                    <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.4rem;">Paste any YouTube link — auto-converted to embed format.</div>
                    @if(isset($property) && $property->youtube_embed_url)
                    <div class="ratio ratio-16x9 mt-2">
                        <iframe src="{{ $property->youtube_embed_url }}" title="YouTube Preview" allowfullscreen></iframe>
                    </div>
                    @endif
                </div>

                <div>
                    <label class="form-label">Facebook Video URL</label>
                    <input type="url" name="facebook_video_url" class="form-control"
                        value="{{ old('facebook_video_url', $property->facebook_video_url ?? '') }}"
                        placeholder="https://www.facebook.com/videos/... or https://fb.watch/...">
                    <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.4rem;">
                        <i class="bi bi-info-circle me-1"></i>Supports facebook.com/videos/ and fb.watch links. The video must be public.
                    </div>
                    @if(isset($property) && $property->facebook_embed_url)
                    <div class="ratio ratio-16x9 mt-2" style="max-height:280px;">
                        <iframe src="{{ $property->facebook_embed_url }}"
                            title="Facebook Video Preview"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function() {
    // Show/hide bedroom/bathroom fields based on type
    function toggleBedroomFields() {
        const type = $('#typeSelect').val();
        const show = type === 'flat' || type === 'house';
        $('.bedroom-bath-field').toggle(show);
    }
    toggleBedroomFields();
    $('#typeSelect').on('change', toggleBedroomFields);

    // New image preview
    let newFilesDataTransfer = new DataTransfer();

    $('#imageUpload').on('change', function() {
        const files = this.files;
        $('#newImagesPreview').empty();

        for (let i = 0; i < files.length; i++) {
            newFilesDataTransfer.items.add(files[i]);
            const reader = new FileReader();
            reader.onload = (function(idx) {
                return function(e) {
                    const item = $('<div class="img-preview-item">').append(
                        $('<img>').attr('src', e.target.result),
                        $('<button type="button" class="remove-img">').attr('data-new-idx', idx).html('<i class="bi bi-x"></i>')
                    );
                    if (idx === 0 && !$('#existingImages .img-preview-item').length) {
                        item.append($('<div style="position:absolute;bottom:2px;left:2px;background:var(--accent);color:#fff;font-size:0.55rem;padding:1px 5px;border-radius:3px;">PRIMARY</div>'));
                    }
                    $('#newImagesPreview').append(item);
                };
            })(i);
            reader.readAsDataURL(files[i]);
        }
    });

    // Remove new preview image
    $(document).on('click', '.remove-img[data-new-idx]', function() {
        $(this).closest('.img-preview-item').remove();
    });

    // Remove existing image (mark for deletion)
    let toDelete = [];
    $(document).on('click', '.remove-img[data-id]', function() {
        const id = $(this).data('id');
        toDelete.push(id);
        $('#deleteImagesInput').val(toDelete.join(','));
        $(this).closest('.img-preview-item').css('opacity', 0.3).find('.remove-img').remove();
    });

    // Drag-to-reorder existing images
    @if(isset($property) && $property->images->count())
    const existingGrid = document.getElementById('existingImages');
    if (existingGrid) {
        new Sortable(existingGrid, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function() {
                const order = [];
                $('#existingImages .img-preview-item').each(function(idx) {
                    order.push({ id: $(this).data('id'), order: idx });
                });
                $('#imageOrderInput').val(JSON.stringify(order));
            }
        });
    }
    @endif
});
</script>
<style>
.sortable-ghost { opacity: 0.4; }
</style>
@endpush
