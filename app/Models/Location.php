<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'parent_id', 'type'];

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function scopeDivisions($query)
    {
        return $query->where('type', 'division');
    }

    public function scopeDistricts($query)
    {
        return $query->where('type', 'district');
    }

    public function scopeAreas($query)
    {
        return $query->where('type', 'area');
    }
}
