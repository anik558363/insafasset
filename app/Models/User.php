<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'phone', 'password', 'role', 'avatar', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'agent', 'employee']);
    }

    public function canAccessMenu(string $menuKey): bool
    {
        if ($this->isAdmin()) return true;
        return in_array($menuKey, MenuPermission::allowedMenusForRole($this->role));
    }

    public function getRoleColorAttribute(): string
    {
        return match($this->role) {
            'admin'    => 'danger',
            'agent'    => 'primary',
            'employee' => 'info',
            default    => 'secondary',
        };
    }
}
