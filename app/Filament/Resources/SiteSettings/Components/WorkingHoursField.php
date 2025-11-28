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
        
        $this->afterStateHydrated(function (WorkingHoursField $component, $state) {
            // Debug: Log the incoming state
            // Log::info('WorkingHoursField hydrated with state:', ['state' => $state, 'type' => gettype($state)]);
            
            // Always fetch the actual data from the database for working_hours
            try {
                // Fetch the actual working hours data directly from database
                $actualData = \App\Models\SiteSetting::where('setting_key', 'working_hours')->value('setting_value');
                // Log::info('Fetched actual data from database:', ['data' => $actualData, 'type' => gettype($actualData)]);
                
                if ($actualData) {
                    if (is_string($actualData)) {
                        $decoded = json_decode($actualData, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            // Log::info('Successfully decoded working hours data:', ['data' => $decoded]);
                            $component->state($decoded);
                            return;
                        }
                    } elseif (is_array($actualData)) {
                        // Log::info('Successfully fetched working hours data as array:', ['data' => $actualData]);
                        $component->state($actualData);
                        return;
                    }
                }
            } catch (\Exception $e) {
                // Log::error('Error fetching working hours data:', ['exception' => $e->getMessage()]);
            }
            
            // Fallback to handling the provided state
            // Handle different types of state data
            if (is_string($state) && !empty($state)) {
                // Clean the string by removing extra whitespace
                $cleanState = trim($state);
                
                // Try to decode JSON string
                $decoded = json_decode($cleanState, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    // Log::info('Decoded JSON successfully:', ['decoded' => $decoded]);
                    $component->state($decoded);
                } else {
                    // If JSON decoding fails, initialize with empty array
                    // Log::warning('Failed to decode JSON, using empty array', [
                    //     'json_error' => json_last_error(), 
                    //     'json_error_msg' => json_last_error_msg(),
                    //     'state' => $state,
                    //     'clean_state' => $cleanState
                    // ]);
                    $component->state([]);
                }
            } elseif (is_array($state)) {
                // Log::info('State is already an array:', ['state' => $state]);
                $component->state($state);
            } else {
                // Log::info('State is neither string nor array, using empty array', ['state' => $state]);
                $component->state([]);
            }
        });
        
        $this->dehydrateStateUsing(function ($state) {
            // Convert array to JSON string when saving data
            if (is_array($state)) {
                $json = json_encode($state, JSON_UNESCAPED_UNICODE);
                if ($json !== false && json_last_error() === JSON_ERROR_NONE) {
                    return $json;
                }
            }
            // If encoding fails, return the original state or empty JSON object
            return is_string($state) ? $state : '{}';
        });
        
        $this->default([]);
    }
}