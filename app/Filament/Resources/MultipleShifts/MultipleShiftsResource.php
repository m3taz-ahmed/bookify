<?php

namespace App\Filament\Resources\MultipleShifts;

use App\Filament\Resources\MultipleShifts\Pages\ManageMultipleShifts;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;

class MultipleShiftsResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    
    protected static string|UnitEnum|null $navigationGroup = 'Employees';
    
    protected static ?string $navigationLabel = 'Multiple Shifts';
    
    protected static ?int $navigationSort = 5;

    public static function getPages(): array
    {
        return [
            'index' => ManageMultipleShifts::route('/'),
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