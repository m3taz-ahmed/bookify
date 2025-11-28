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
                    ->helperText('Unique identifier for this setting. Use "max_capacity" for capacity or "working_hours" for working hours'),
                
                // Capacity setting
                TextInput::make('setting_value')
                    ->label('Maximum Capacity')
                    ->numeric()
                    ->minValue(1)
                    ->default(200)
                    ->required()
                    ->helperText('Maximum number of people allowed per day')
                    ->visible(fn ($get) => $get('setting_key') === 'max_capacity'),
                
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
