<?php

namespace App\Filament\Resources\Activitylog\Pages;

use App\Filament\Resources\Activitylog\ActivitylogResource;
use Filament\Resources\Pages\Page;
use Spatie\Activitylog\Models\Activity;

class ViewActivity extends Page
{
    protected static string $resource = ActivitylogResource::class;

    protected string $view = 'filament.resources.activitylog.pages.view-activity';

    public Activity $activity;

    public function mount(int $record): void
    {
        $this->activity = Activity::findOrFail($record);
    }

    public function getTitle(): string
    {
        return __('filament.View Activity Log');
    }

    public function getHeading(): string
    {
        return __('filament.Activity Log Details');
    }
}