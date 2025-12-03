<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Page extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'map_zoom' => 'integer',
        'founded_year' => 'integer',
    ];

    // Add the page type constants
    public const TYPE_ABOUT_US = 'about_us';
    public const TYPE_CONTACT_US = 'contact_us';
    public const TYPE_PRIVACY_POLICY = 'privacy_policy';
    public const TYPE_TERMS_CONDITIONS = 'terms_conditions';
    public const TYPE_FAQ = 'faq';
    
    public static function getTypes(): array
    {
        return [
            self::TYPE_ABOUT_US => 'About Us',
            self::TYPE_CONTACT_US => 'Contact Us',
            self::TYPE_PRIVACY_POLICY => 'Privacy Policy',
            self::TYPE_TERMS_CONDITIONS => 'Terms & Conditions',
            self::TYPE_FAQ => 'FAQ',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Page {$eventName}");
    }

    // Accessors for multilingual fields
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->title_ar : $this->title_en;
    }

    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->content_ar : $this->content_en;
    }

    // Scope for active pages
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for finding by slug
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }
    
    // Scope for finding by type
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}