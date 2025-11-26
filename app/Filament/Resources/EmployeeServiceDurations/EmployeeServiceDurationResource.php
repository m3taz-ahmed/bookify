<?php

namespace App\Filament\Resources\EmployeeServiceDurations;

use App\Filament\Resources\EmployeeServiceDurations\Pages\CreateEmployeeServiceDuration;
use App\Filament\Resources\EmployeeServiceDurations\Pages\EditEmployeeServiceDuration;
use App\Filament\Resources\EmployeeServiceDurations\Pages\ListEmployeeServiceDurations;
use App\Filament\Resources\EmployeeServiceDurations\Schemas\EmployeeServiceDurationForm;
use App\Filament\Resources\EmployeeServiceDurations\Tables\EmployeeServiceDurationsTable;
use App\Models\EmployeeServiceDuration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EmployeeServiceDurationResource extends Resource
{
    protected static ?string $model = EmployeeServiceDuration::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clock';
    
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    public static function getLabel(): string
    {
        return __('filament.Employee Service Durations');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Employee Service Durations');
    }

    public static function form(Schema $schema): Schema
    {
        return EmployeeServiceDurationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeeServiceDurationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployeeServiceDurations::route('/'),
            // 'create' => CreateEmployeeServiceDuration::route('/create'),
            'edit' => EditEmployeeServiceDuration::route('/{record}/edit'),
        ];
    }
}