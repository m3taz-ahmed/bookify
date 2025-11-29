<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Resources\SiteSettings\Components\WorkingHoursField;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('setting_key')
                    ->required()
                    ->disabledOn('edit')
                    ->helperText('Unique identifier for this setting.'),

                TextInput::make('setting_value')
                    ->label('Maximum Capacity')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->helperText('Maximum number of people allowed per day')
                    ->visible(fn ($get) => $get('setting_key') === 'max_capacity')
                    ->dehydrateStateUsing(fn ($state) => (int) $state)
                    ->formatStateUsing(function ($state) {
                        // Handle the case where the value might be an array due to model casting
                        if (is_array($state)) {
                            // Extract the actual integer value from the array
                            return (int) ($state[0] ?? 200);
                        }
                        
                        // If it's already a scalar value, convert to int
                        return $state;
                    }),

                // Working hours setting with improved UI
                WorkingHoursField::make('setting_value')
                    ->label('Working Hours')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('setting_key') === 'working_hours'),
                
                // Fallback textarea for other settings
                Textarea::make('setting_value')
                    ->columnSpanFull()
                    ->required()
                    ->helperText('Enter value for this setting')
                    ->visible(fn ($get) => !in_array($get('setting_key'), ['max_capacity', 'working_hours'])),
                
                TextInput::make('description')
                    ->helperText('Brief description of what this setting controls'),
            ]);
    }
}
