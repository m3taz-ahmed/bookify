<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\SiteSetting;
use App\Services\CapacityService;
use BackedEnum;
use Filament\Resources\Pages\Page;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WeekCalendarBookings extends Page
{
    protected static string $resource = BookingResource::class;

    protected static bool $shouldRegisterNavigation = true;

    public function getView(): string
    {
        return 'filament.resources.bookings.pages.week-calendar-bookings';
    }

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?int $navigationSort = 3;

    public static function getLabel(): string
    {
        return __('filament.Week Calendar');
    }

    public static function getPluralLabel(): string
    {
        return __('filament.Week Calendar');
    }
    
    public function getTitle(): string
    {
        return __('filament.Week Calendar');
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
        \Carbon\Carbon::setLocale(app()->getLocale());
        // Get the current week start date from the request, or use the current date
        $currentDate = request()->query('date', Carbon::now()->timezone('Asia/Riyadh')->toDateString());
        $currentDate = Carbon::parse($currentDate)->timezone('Asia/Riyadh');
        
        // Always start the week on Saturday, regardless of locale
        $startDate = $currentDate->copy()->startOfWeek(6); // 6 = Saturday in Carbon
        $endDate = $startDate->copy()->addDays(6);
        
        // Get all bookings for the current week with related data, excluding cancelled bookings
        $bookings = Booking::with(['customer', 'service', 'items.service'])
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();
            
        // Create an array of days for the week
        $days = [];
        $currentDay = $startDate->copy();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $currentDay->copy();
            $dayBookings = $bookings->filter(function ($booking) use ($date) {
                return $booking->booking_date->isSameDay($date);
            })->sortBy('start_time');
            
            // Get capacity information
            $totalPeople = CapacityService::getTotalPeopleForDate($date);
            $maxCapacity = SiteSetting::getMaxCapacity();
            $capacityPercentage = CapacityService::getCapacityPercentage($date);
            $capacityColor = CapacityService::getCapacityStatusColor($date);
            $isWorkingDay = SiteSetting::isWorkingDay($date);
            
            // Group bookings by time
            $groupedBookings = [];
            foreach ($dayBookings as $booking) {
                $timeKey = $booking->start_time ? $booking->start_time->format('H:i') : '00:00';
                if (!isset($groupedBookings[$timeKey])) {
                    $groupedBookings[$timeKey] = [
                        'time' => $timeKey,
                        'bookings' => [],
                        'totalPeople' => 0
                    ];
                }
                $groupedBookings[$timeKey]['bookings'][] = $booking;
                $groupedBookings[$timeKey]['totalPeople'] += $booking->number_of_people;
            }
            
            // Calculate capacity percentage for each time slot
            foreach ($groupedBookings as &$slot) {
                $slot['capacityPercentage'] = ($maxCapacity > 0) ? ($slot['totalPeople'] / $maxCapacity) * 100 : 0;
            }
            unset($slot); // Break reference

            // Sort by time
            ksort($groupedBookings);

            $days[] = [
                'date' => $date,
                'bookings' => $dayBookings, // Keep original flattened list if needed, or remove if unused
                'groupedBookings' => $groupedBookings, // New grouped structure
                'totalPeople' => $totalPeople,
                'maxCapacity' => $maxCapacity,
                'capacityPercentage' => $capacityPercentage,
                'capacityColor' => $capacityColor,
                'isWorkingDay' => $isWorkingDay,
            ];
            
            $currentDay->addDay();
        }

        return [
            'currentWeekStart' => $startDate,
            'currentWeekEnd' => $endDate,
            'days' => $days,
            'previousWeek' => $startDate->copy()->subWeek(),
            'nextWeek' => $startDate->copy()->addWeek(),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.Week Calendar');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.Week Calendar');
    }

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
