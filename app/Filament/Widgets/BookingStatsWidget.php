<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Bookings', Booking::count())
                ->description('All time bookings')
                ->descriptionIcon('heroicon-o-magnifying-glass')
                ->color('primary'),
                
            Stat::make('Confirmed Bookings', Booking::where('status', 'confirmed')->count())
                ->description('Awaiting service')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('warning'),
                
            Stat::make('Completed Bookings', Booking::where('status', 'completed')->count())
                ->description('Successfully served')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
                
            Stat::make('Cancelled Bookings', Booking::where('status', 'cancelled')->count())
                ->description('Cancelled reservations')
                ->descriptionIcon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}