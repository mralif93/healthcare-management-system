<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'label', 'type'];

    /**
     * Get a setting value by key.
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function set($key, $value, $group = 'general', $label = null, $type = 'text')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'label' => $label, 'type' => $type]
        );
    }
}
