<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MenuPermission extends Model
{
    protected $fillable = ['role', 'menu_key'];

    public static function allowedMenusForRole(string $role): array
    {
        return Cache::remember("menu_permissions_{$role}", 3600, function () use ($role) {
            return static::where('role', $role)->pluck('menu_key')->toArray();
        });
    }

    public static function clearCacheForRole(string $role): void
    {
        Cache::forget("menu_permissions_{$role}");
    }

    public static function syncForRole(string $role, array $menuKeys): void
    {
        static::where('role', $role)->delete();
        foreach ($menuKeys as $key) {
            static::create(['role' => $role, 'menu_key' => $key]);
        }
        static::clearCacheForRole($role);
    }
}
