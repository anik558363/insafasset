<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'property_id', 'user_id', 'customer_name', 'phone', 'email',
        'preferred_date', 'message', 'status', 'advance_amount',
        'payment_status', 'admin_note',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'advance_amount' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'confirmed' => 'success',
            'rejected'  => 'danger',
            'cancelled' => 'secondary',
            default     => 'secondary',
        };
    }
}
