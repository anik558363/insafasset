<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PropertyImage extends Model
{
    public $timestamps = false;
    protected $fillable = ['property_id', 'image_path', 'disk', 'is_primary', 'sort_order'];

    protected $casts = ['is_primary' => 'boolean'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Returns a publicly accessible URL for the image.
     *
     * Supports two storage strategies:
     *  - 'uploads' disk: stored directly in public/uploads/ (no symlink needed, cPanel safe)
     *  - 'public'  disk: stored in storage/app/public/ and served via storage:link symlink
     *
     * Falls back gracefully between the two so that images uploaded before or after
     * a hosting migration continue to display correctly.
     */
    public function getUrlAttribute(): string
    {
        if (!$this->image_path) {
            return asset('images/no-image.svg');
        }

        $disk = $this->disk ?? 'public';

        if ($disk === 'uploads') {
            // Direct public path — always works on cPanel without symlinks
            if (file_exists(public_path('uploads/' . $this->image_path))) {
                return asset('uploads/' . $this->image_path);
            }
        }

        // Try the uploads directory as a fallback (handles migrated images)
        if (file_exists(public_path('uploads/' . $this->image_path))) {
            return asset('uploads/' . $this->image_path);
        }

        // Try storage symlink path
        if (file_exists(public_path('storage/' . $this->image_path))) {
            return asset('storage/' . $this->image_path);
        }

        // Last resort: Storage facade check
        if (Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }

        return asset('images/no-image.svg');
    }
}
