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
    ];

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
}