<?php

namespace App\Filament\Resources\Shifts\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->label(__('filament.Employee'))
                    ->relationship('user', 'name')
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'employee');
                    })->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->live(),
                
                Select::make('day_of_week')
                    ->label(__('filament.Day of Week'))
                    ->options([
                        1 => __('filament.Monday'),
                        2 => __('filament.Tuesday'),
                        3 => __('filament.Wednesday'),
                        4 => __('filament.Thursday'),
                        5 => __('filament.Friday'),
                        6 => __('filament.Saturday'),
                        0 => __('filament.Sunday'),
                    ])
                    ->required()
                    ->live(),
                
                TimePicker::make('start_time')
                    ->label(__('filament.Start Time'))
                    ->required()
                    ->seconds(false)
                    ->live(),
                
                TimePicker::make('end_time')
                    ->label(__('filament.End Time'))
                    ->required()
                    ->seconds(false)
                    ->live(),
            ]);
    }
}