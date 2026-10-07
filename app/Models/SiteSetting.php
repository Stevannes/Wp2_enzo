<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'group',
    ];

    /**
     * Retrieve a setting value by key with an optional default.
     */
    public static function getValue(string $key, ?string $default = null): ?string
    {
        $setting = static::where('setting_key', $key)->first();

        return $setting?->setting_value ?? $default;
    }
}
