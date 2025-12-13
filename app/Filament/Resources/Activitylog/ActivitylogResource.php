<?php

namespace App\Filament\Resources\Activitylog;

use App\Filament\Resources\Activitylog\Pages\ListActivitylogs;
use App\Filament\Resources\Activitylog\Pages\ViewActivity;
use App\Filament\Resources\Activitylog\Tables\ActivitylogsTable;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class ActivitylogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    
    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 90;

    public static function getLabel(): string
    {
        return __('filament.Activity Logs');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Activity Logs');
    }

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Only admin and super_admin can view activity logs
        return $user && $user->hasRole(['admin', 'super_admin']);
    }

    // Disable all actions except viewing
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return ActivitylogsTable::configure($table);
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
            'index' => ListActivitylogs::route('/'),
            'view' => ViewActivity::route('/{record}'),
        ];
    }
}