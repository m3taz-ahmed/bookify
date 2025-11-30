<x-filament-panels::page>


    <div class="calendar-nav-container">
        <div>
            <button id="prev-btn" class="calendar-nav-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span>Prev</span>
            </button>
        </div>
        <div class="calendar-nav-title">
            {{ $currentMonth->isoFormat('MMMM YYYY') }}
        </div>
        <div>
            <button id="next-btn" class="calendar-nav-btn">
                <span>Next</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
        <!-- Calendar Grid -->
        <div class="calendar-grid grid grid-cols-7 gap-0 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm">
            <!-- Day Headers -->
            @php
                // Always start the week on Saturday, regardless of locale
                $firstDayOfWeek = 6; // 6 = Saturday in Carbon (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
                $dayNames = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
                // Rotate the array so that Saturday is first
                $rotatedDayNames = array_merge(array_slice($dayNames, $firstDayOfWeek), array_slice($dayNames, 0, $firstDayOfWeek));
            @endphp
            @foreach($rotatedDayNames as $dayName)
                <div class="calendar-header-cell">
                    {{ $dayName }}
                </div>
            @endforeach

            <!-- Calendar Days -->
            @foreach($weeks as $week)
                @foreach($week as $day)
                    @if($day === null)
                        <div class="calendar-empty-day min-h-36 border-r border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900"></div>
                    @else
                        <div class="calendar-day-cell min-h-36 border-r border-b border-gray-200 dark:border-gray-700 p-2 relative flex flex-col
                            {{ !$day['isCurrentMonth'] ? 'bg-gray-50 text-gray-400 dark:bg-gray-900 dark:text-gray-600' : 'bg-white dark:bg-gray-800' }}
                            {{ $day['date']->isToday() ? 'calendar-day-today ring-1 ring-inset ring-[#8B5A2B]' : '' }}
                            {{-- Apply closed day styling --}}
                            {{ !$day['isWorkingDay'] ? 'closed-day' : '' }}
                            {{-- Apply capacity colors only for working days --}}
                            {{ $day['isWorkingDay'] && $day['capacityColor'] == 'red' ? 'bg-red-50 dark:bg-red-900/10' : '' }}
                            {{ $day['isWorkingDay'] && $day['capacityColor'] == 'yellow' ? 'bg-yellow-50 dark:bg-yellow-900/10' : '' }}
                            {{ $day['isWorkingDay'] && $day['capacityColor'] == 'green' ? 'bg-green-50 dark:bg-green-900/10' : '' }}">
                            <!-- Day number in circle in upper right corner -->
                            <div class="absolute top-2 right-2 flex justify-end">
                                <div class="calendar-day-number-circle w-8 h-8 rounded-full flex items-center justify-center {{ $day['date']->isToday() ? 'calendar-day-number-active' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                                    <span class="text-sm font-medium">{{ $day['date']->day }}</span>
                                </div>
                            </div>
                            
                            <!-- Booking information in center -->
                            <div class="flex-grow flex flex-col items-center justify-center text-center mt-4">
                                @if(!$day['isWorkingDay'])
                                    <div class="closed-label text-gray-500 dark:text-gray-400 font-medium text-center flex flex-col items-center justify-center h-full">
                                        Closed
                                    </div>
                                @elseif(count($day['bookings']) > 0)
                                    <div class="flex flex-col items-center justify-center w-full">
                                        <div class="booking-count text-center text-sm font-bold">
                                            {{ count($day['bookings']) }} Booked
                                        </div>
                                        <div class="people-count text-gray-500">
                                            {{ $day['totalPeople'] }}/{{ $day['maxCapacity'] }} People
                                        </div>
                                        <div class="capacity-bar w-full h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full mt-1.5 overflow-hidden">
                                            <div class="h-full rounded-full 
                                                @if($day['capacityPercentage'] >= 100)
                                                    bg-red-500
                                                @elseif($day['capacityPercentage'] >= 50)
                                                    bg-yellow-500
                                                @else
                                                    bg-green-500
                                                @endif" 
                                                style="width: {{ min($day['capacityPercentage'], 100) }}%">&nbsp
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="no-bookings text-gray-400 dark:text-gray-500 text-center text-xs flex flex-col items-center justify-center h-full w-full">
                                        <span class="mb-1">No Bookings</span>
                                        <span class="text-[10px]">{{ $day['totalPeople'] }}/{{ $day['maxCapacity'] }} People</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        </div>
        
        <!-- Legend -->
        <div class="calendar-legend-container mt-6 flex flex-wrap gap-6 justify-center">
            <!-- <div class="calendar-legend-item flex items-center">
                <div class="calendar-legend-color-box w-4 h-4 bg-blue-50 border border-blue-200 rounded mr-2 dark:bg-blue-900/30 dark:border-blue-800"></div>
                <span class="calendar-legend-text">Confirmed</span>
            </div>
            <div class="calendar-legend-item flex items-center">
                <div class="calendar-legend-color-box w-4 h-4 bg-green-50 border border-green-200 rounded mr-2 dark:bg-green-900/30 dark:border-green-800"></div>
                <span class="calendar-legend-text">Completed</span>
            </div>
            <div class="calendar-legend-item flex items-center">
                <div class="calendar-legend-color-box w-4 h-4 bg-yellow-50 border border-yellow-200 rounded mr-2 dark:bg-yellow-900/30 dark:border-yellow-800"></div>
                <span class="calendar-legend-text">Pending</span>
            </div>
            <div class="calendar-legend-item flex items-center">
                <div class="calendar-legend-color-box w-4 h-4 bg-red-50 border border-red-200 rounded mr-2 dark:bg-red-900/30 dark:border-red-800"></div>
                <span class="calendar-legend-text">Cancelled</span>
            </div> -->
            <div class="calendar-legend-item flex items-center">
                <div class="calendar-legend-color-box w-4 h-4 bg-green-100 border border-green-200 rounded mr-2 dark:bg-green-900/30 dark:border-green-800"></div>
                <span class="calendar-legend-text">&lt; 50% Capacity</span>
            </div>
            <div class="calendar-legend-item flex items-center">
                <div class="calendar-legend-color-box w-4 h-4 bg-yellow-100 border border-yellow-200 rounded mr-2 dark:bg-yellow-900/30 dark:border-yellow-800"></div>
                <span class="calendar-legend-text">50-100% Capacity</span>
            </div>
            <div class="calendar-legend-item flex items-center">
                <div class="calendar-legend-color-box w-4 h-4 bg-red-100 border border-red-200 rounded mr-2 dark:bg-red-900/30 dark:border-red-800"></div>
                <span class="calendar-legend-text">Fully Booked</span>
            </div>
            <!-- <div class="calendar-legend-item flex items-center">
                <div class="calendar-legend-color-box w-4 h-4 bg-gray-100 border border-gray-200 rounded mr-2 dark:bg-gray-900 dark:border-gray-800"></div>
                <span class="calendar-legend-text">Closed Day</span>
            </div> -->
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Store PHP values in JavaScript variables
        const prevMonth = <?php echo $previousMonth->month; ?>;
        const prevYear = <?php echo $previousMonth->year; ?>;
        const nextMonth = <?php echo $nextMonth->month; ?>;
        const nextYear = <?php echo $nextMonth->year; ?>;
        
        // Navigation buttons
        if (document.getElementById('prev-btn')) {
            document.getElementById('prev-btn').addEventListener('click', function() {
                const url = new URL(window.location);
                url.searchParams.set('month', prevMonth);
                url.searchParams.set('year', prevYear);
                window.location.href = url.toString();
            });
        }
        
        if (document.getElementById('next-btn')) {
            document.getElementById('next-btn').addEventListener('click', function() {
                const url = new URL(window.location);
                url.searchParams.set('month', nextMonth);
                url.searchParams.set('year', nextYear);
                window.location.href = url.toString();
            });
        }
        
        if (document.getElementById('today-btn')) {
            document.getElementById('today-btn').addEventListener('click', function() {
                const now = new Date();
                const url = new URL(window.location);
                url.searchParams.set('month', now.getMonth() + 1);
                url.searchParams.set('year', now.getFullYear());
                window.location.href = url.toString();
            });
        }
        
        // Go button
        if (document.getElementById('go-btn')) {
            document.getElementById('go-btn').addEventListener('click', function() {
                const month = document.getElementById('month-select').value;
                const year = document.getElementById('year-input').value;
                const url = new URL(window.location);
                url.searchParams.set('month', month);
                url.searchParams.set('year', year);
                window.location.href = url.toString();
            });
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                if (document.getElementById('prev-btn')) {
                    document.getElementById('prev-btn').click();
                }
            } else if (e.key === 'ArrowRight') {
                if (document.getElementById('next-btn')) {
                    document.getElementById('next-btn').click();
                }
            } else if (e.key === 't' || e.key === 'T') {
                if (document.getElementById('today-btn')) {
                    document.getElementById('today-btn').click();
                }
            }
        });
    });
</script>
@endpush
</x-filament-panels::page>
