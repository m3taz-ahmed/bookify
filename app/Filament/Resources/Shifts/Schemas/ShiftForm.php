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
                    ->label('Employee')
                    ->relationship('user', 'name')
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'employee');
                    })->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->live(),
                
                Select::make('day_of_week')
                    ->label('Day of Week')
                    ->options([
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                        0 => 'Sunday',
                    ])
                    ->required()
                    ->live(),
                
                TimePicker::make('start_time')
                    ->label('Start Time')
                    ->required()
                    ->seconds(false)
                    ->live(),
                
                TimePicker::make('end_time')
                    ->label('End Time')
                    ->required()
                    ->seconds(false)
                    ->live(),
            ]);
    }
}