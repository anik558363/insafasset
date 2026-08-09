<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    protected $fillable = ['name', 'designation', 'message', 'image', 'rating'];

    /**
     * Resolve a publicly accessible URL for the testimonial photo.
     *
     * cPanel-safe: prefers the symlink-free public/uploads/ path, then falls
     * back to the storage symlink, then the Storage facade. Returns null when
     * there is no image so views can render the initial-letter avatar instead.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        // Preferred: direct public path (no symlink needed — works on cPanel)
        if (file_exists(public_path('uploads/' . $this->image))) {
            return asset('uploads/' . $this->image);
        }

        // Legacy: storage symlink path
        if (file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        // Last resort: Storage facade
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        return null;
    }
}
