<?php

namespace App\Filament\Resources\SiteSettings\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Log;

class WorkingHoursField extends Field
{
    protected string $view = 'filament.resources.site-settings.components.working-hours-field';

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->afterStateHydrated(function (WorkingHoursField $component, $state, callable $get) {
            // Only run this logic if the setting_key is working_hours
            if ($get('setting_key') !== 'working_hours') {
                return;
            }

            // Handle the provided state directly
            // The state is populated via afterStateHydrated in the form schema
            if (is_array($state)) {
                $component->state($state);
            } elseif (is_string($state) && !empty($state)) {
                $decoded = json_decode($state, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $component->state($decoded);
                } else {
                    $component->state([]);
                }
            } else {
                $component->state([]);
            }
        });
        
        $this->dehydrateStateUsing(function ($state) {
            // Return the array directly as the model handles JSON casting
            if (is_array($state)) {
                return $state;
            }
            // If it's a JSON string, try to decode it to array to ensure clean storage
            if (is_string($state)) {
                $decoded = json_decode($state, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $decoded;
                }
                return $state;
            }
            return [];
        });
        
        $this->default([]);
    }
}