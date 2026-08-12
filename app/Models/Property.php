<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'user_id',
        'type',
        'listing_type',
        'price',
        'price_unit',
        'size',
        'size_unit',
        'bedrooms',
        'bathrooms',
        'location_text',
        'division',
        'district',
        'area',
        'latitude',
        'longitude',
        'youtube_link',
        'facebook_video_url',
        'status',
        'featured',
        'views_count',
        'meta_title',
        'meta_description',
        'agent_name',
        'agent_phone',
        'property_id'
    ];

    protected $casts = [
        'featured' => 'boolean',

        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_link) return null;
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_link, $matches);
        return isset($matches[1]) ? 'https://www.youtube.com/embed/' . $matches[1] : null;
    }

    /**
     * Converts a Facebook video/post URL into an embeddable iframe src.
     * Handles: fb.watch, facebook.com/videos/, facebook.com/watch/?v=
     */
    public function getFacebookEmbedUrlAttribute(): ?string
    {
        if (!$this->facebook_video_url) return null;

        $url = trim($this->facebook_video_url);

        // Validate it looks like a Facebook URL
        if (!preg_match('/facebook\.com|fb\.watch/i', $url)) return null;

        return 'https://www.facebook.com/plugins/video.php?href='
            . urlencode($url)
            . '&show_text=false&width=720&mute=0&autoplay=false';
    }

    public function getFormattedPriceAttribute(): string
    {
        return '৳ ' . $this->price;
    }

    /**
     * Price markup for on-page display. The Taka symbol (৳, U+09F3) is wrapped
     * in a span so it renders with a Bengali-capable webfont, keeping it crisp
     * and consistent everywhere instead of relying on a system fallback glyph.
     * Render with {!! $property->price_html !!}.
     */
    public function getPriceHtmlAttribute(): string
    {
        return '<span class="taka">৳</span> ' . $this->price;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true)->where('status', 'available');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }
        if (!empty($filters['listing_type'])) {
            $query->where('listing_type', $filters['listing_type']);
        }
        if (!empty($filters['division'])) {
            $query->where('division', 'like', '%' . $filters['division'] . '%');
        }
        if (!empty($filters['district'])) {
            $query->where('district', 'like', '%' . $filters['district'] . '%');
        }
        if (!empty($filters['area'])) {
            $query->where('area', 'like', '%' . $filters['area'] . '%')
                ->orWhere('location_text', 'like', '%' . $filters['area'] . '%');
        }
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }
        if (!empty($filters['min_size'])) {
            $query->where('size', '>=', $filters['min_size']);
        }
        if (!empty($filters['max_size'])) {
            $query->where('size', '<=', $filters['max_size']);
        }
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (!empty($filters['bedrooms'])) {
            $query->where('bedrooms', '>=', $filters['bedrooms']);
        }
        return $query;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title) . '-' . uniqid();
            }
        });
    }

    public function getFirstImageAttribute()
    {
        $image = $this->images->first();

        return $image
            ? asset($image->image)
            : asset('images/no-image.svg');
    }
}
