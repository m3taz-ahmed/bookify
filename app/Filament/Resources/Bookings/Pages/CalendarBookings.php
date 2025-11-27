<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Actions\CreateAction;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarBookings extends Page
{
    protected static string $resource = BookingResource::class;

    protected static ?string $title = 'Bookings Calendar';

    protected static bool $shouldRegisterNavigation = true;

    public function getView(): string
    {
        return 'filament.resources.bookings.pages.calendar-bookings';
    }

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return $user && $user->can('ViewAny:Booking');
    }

    public static function canCreate(): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return $user && $user->can('Create:Booking');
    }

    public static function canAccess(array $parameters = []): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return $user && $user->can('ViewAny:Booking');
    }

    public static function shouldRegisterNavigation(array $parameters = []): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        return $user && $user->can('ViewAny:Booking');
    }

    public function getViewData(): array
    {
        // Get the current month and year
        $currentMonth = (int) request()->query('month', now()->month);
        $currentYear = (int) request()->query('year', now()->year);
        
        // Create a Carbon instance for the first day of the month
        $startDate = Carbon::createFromDate($currentYear, $currentMonth, 1);
        $endDate = $startDate->copy()->endOfMonth();
        
        // Get all bookings for the current month with related data
        $bookings = Booking::with(['customer', 'service'])
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();
            
        // Create an array of weeks with days
        $weeks = [];
        $currentDate = $startDate->copy()->startOfWeek();
        
        while ($currentDate <= $endDate->copy()->endOfWeek()) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $date = $currentDate->copy();
                $dayBookings = $bookings->filter(function ($booking) use ($date) {
                    return $booking->booking_date->isSameDay($date);
                });
                
                $week[] = [
                    'date' => $date,
                    'isCurrentMonth' => $date->month == $currentMonth,
                    'bookings' => $dayBookings,
                ];
                
                $currentDate->addDay();
            }
            $weeks[] = $week;
        }

        return [
            'currentMonth' => $startDate,
            'weeks' => $weeks,
            'previousMonth' => $startDate->copy()->subMonth(),
            'nextMonth' => $startDate->copy()->addMonth(),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('Calendar');
    }

    public function getBreadcrumb(): string
    {
        return __('Calendar');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}