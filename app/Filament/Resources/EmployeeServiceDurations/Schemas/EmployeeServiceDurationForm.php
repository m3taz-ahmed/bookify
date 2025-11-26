<?php

namespace App\Filament\Resources\EmployeeServiceDurations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeServiceDurationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('employee', 'name')
                    ->label(__('filament.Employee'))
                    ->required(),
                Select::make('service_id')
                    ->relationship('service', 'name_ar')
                    ->label(__('filament.Service'))
                    ->required(),
                TextInput::make('duration')
                    ->label(__('filament.Duration (minutes)'))
                    ->numeric()
                    ->minValue(1)
                    ->required(),
            ]);
    }
}