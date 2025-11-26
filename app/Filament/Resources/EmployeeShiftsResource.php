<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeShiftsResource\Pages\ManageEmployeeShifts;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

class EmployeeShiftsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    
    protected static string|UnitEnum|null $navigationGroup = 'Employees';
    
    public static function getNavigationLabel(): string
    {
        return __('filament.Employee Shifts');
    }
    
    protected static ?int $navigationSort = 4;

    public static function getLabel(): string
    {
        return __('filament.Employee Shifts');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Employee Shifts');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageEmployeeShifts::route('/'),
        ];
    }
    
    public static function canAccess(): bool
    {
        return true;
    }
    
    public static function getNavigationBadge(): ?string
    {
        return null;
    }
}