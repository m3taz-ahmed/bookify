<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\SiteSetting;
use App\Services\CapacityService;
use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Actions\CreateAction;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarBookings extends Page
{
    protected static string $resource = BookingResource::class;

    protected static bool $shouldRegisterNavigation = true;

    public function getView(): string
    {
        return 'filament.resources.bookings.pages.calendar-bookings';
    }

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?int $navigationSort = 2;

    public static function getLabel(): string
    {
        return __('filament.Calendar');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Calendar');
    }
    
    public function getTitle(): string
    {
        return __('filament.Calendar');
    }

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

        // Get the current month and year from the request, or use the current date
        $currentMonth = (int) request()->query('month', Carbon::now()->timezone('Asia/Riyadh')->month);
        $currentYear = (int) request()->query('year', Carbon::now()->timezone('Asia/Riyadh')->year);
        
        // Create a Carbon instance for the first day of the month
        $startDate = Carbon::createFromDate($currentYear, $currentMonth, 1)->timezone('Asia/Riyadh');
        $endDate = $startDate->copy()->endOfMonth();
        
        // Get all bookings for the current month with related data, excluding cancelled bookings
        $bookings = Booking::with(['customer', 'service'])
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();
            
        // Create an array of weeks with days
        $weeks = [];
        // Always start the week on Saturday, regardless of locale
        $currentDate = $startDate->copy()->startOfWeek(6); // 6 = Saturday in Carbon
        
        while ($currentDate <= $endDate->copy()->endOfWeek(6)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $date = $currentDate->copy();
                $dayBookings = $bookings->filter(function ($booking) use ($date) {
                    return $booking->booking_date->isSameDay($date);
                });
                
                // Get capacity information
                $totalPeople = CapacityService::getTotalPeopleForDate($date);
                $maxCapacity = SiteSetting::getMaxCapacity();
                $capacityPercentage = CapacityService::getCapacityPercentage($date);
                $capacityColor = CapacityService::getCapacityStatusColor($date);
                $isWorkingDay = SiteSetting::isWorkingDay($date);
                
                $week[] = [
                    'date' => $date,
                    'isCurrentMonth' => $date->month == $currentMonth,
                    'bookings' => $dayBookings,
                    'totalPeople' => $totalPeople,
                    'maxCapacity' => $maxCapacity,
                    'capacityPercentage' => $capacityPercentage,
                    'capacityColor' => $capacityColor,
                    'isWorkingDay' => $isWorkingDay,
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
            // CreateAction::make(),
        ];
    }
}