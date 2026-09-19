<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'description',
    ];

    public function scopeGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $group = 'general', $type = 'text', $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    public static function getUiSettings(): array
    {
        return [
            'primary_color' => self::get('primary_color', '#ef4444'),
            'secondary_color' => self::get('secondary_color', '#3b82f6'),
            'site_name' => self::get('site_name', 'OuedKniss Clone'),
            'site_logo' => self::get('site_logo'),
            'site_favicon' => self::get('site_favicon'),
            'hero_title' => self::get('hero_title', 'ابحث عن ما تحتاجه'),
            'hero_subtitle' => self::get('hero_subtitle', 'آلاف الإعلانات بانتظارك'),
            'hero_image' => self::get('hero_image'),
            'show_featured_section' => self::get('show_featured_section', true),
            'show_popular_categories' => self::get('show_popular_categories', true),
            'show_recent_ads' => self::get('show_recent_ads', true),
            'footer_text' => self::get('footer_text'),
            'contact_email' => self::get('contact_email'),
            'contact_phone' => self::get('contact_phone'),
            'social_facebook' => self::get('social_facebook'),
            'social_instagram' => self::get('social_instagram'),
            'social_twitter' => self::get('social_twitter'),
        ];
    }
}
