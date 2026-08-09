<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = ['key', 'group', 'type', 'label', 'value'];

    // Cache TTL in seconds
    const CACHE_TTL = 3600;

    public static function get(string $key, $default = null): mixed
    {
        $all = static::allCached();
        return $all[$key] ?? $default;
    }

    public static function set(string $key, $value, string $group = 'general', string $type = 'text', ?string $label = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type, 'label' => $label]
        );
        static::clearCache();
    }

    public static function getGroup(string $group): array
    {
        $all = static::allCached();
        $prefix = $group . '_';
        $result = [];
        foreach ($all as $key => $value) {
            if (str_starts_with($key, $prefix)) {
                $result[substr($key, strlen($prefix))] = $value;
            }
        }
        return $result;
    }

    public static function allCached(): array
    {
        return Cache::remember('app_settings', self::CACHE_TTL, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('app_settings');
    }

    public static function getByGroup(string $group): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('group', $group)->orderBy('key')->get();
    }
}
