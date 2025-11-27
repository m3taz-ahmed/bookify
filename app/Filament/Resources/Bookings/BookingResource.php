<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages\CalendarBookings;
use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Filament\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use BackedEnum;
use Filament\Navigation\NavigationItem;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;


class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getLabel(): string
    {
        return __('filament.Bookings');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Bookings');
    }

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return $user->can('ViewAny:Booking');
    }

    public static function canCreate(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return $user->can('Create:Booking');
    }

    public static function canEdit($record): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return $user->can('Update:Booking');
    }

    public static function canDelete($record): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return $user->can('Delete:Booking');
    }

    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingsTable::configure($table);
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
            'index' => ListBookings::route('/'),
            // 'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
            'calendar' => CalendarBookings::route('/calendar'),
        ];
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make()
                ->label(__('filament.booking_list'))
                ->icon('heroicon-o-book-open')
                ->group(__('filament.Bookings'))
                ->url(static::getUrl()),

            NavigationItem::make()
                ->label(__('filament.Calendar'))
                ->icon('heroicon-o-calendar')
                ->group(__('filament.Bookings'))
                ->url(static::getUrl('calendar')),
        ];
    }
}