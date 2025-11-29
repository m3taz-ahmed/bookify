<x-filament-panels::page>
    <!-- Force load custom CSS -->
    @pushOnce('styles')
        <link rel="stylesheet" href="{{ asset('css/app/filament-custom.css') }}">
        <style>
            .customer-details-trigger {
                background: none;
                border: none;
                padding: 0;
                font: inherit;
                cursor: pointer;
                outline: inherit;
            }
        </style>
    @endPushOnce

    <div class="force-flex-row items-center justify-between">
            <div class="flex-shrink-0 w-20 bg-red-300 text-center">
                <button id="next-btn" class="calendar-nav-btn px-4 py-2 flex items-center gap-2">
                    <span>Next</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            <div class="month-middle flex-1 bg-green-300 text-center">
                {{ $currentWeekStart->isoFormat('MMM D') }} - {{ $currentWeekEnd->isoFormat('MMM D, YYYY') }}
            </div>
            <div class="flex-shrink-0 w-20 bg-blue-300 text-center">
                <button id="prev-btn" class="calendar-nav-btn px-4 py-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Prev</span>
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
                
                // Create day labels with dates
                $headerDates = [];
                $currentHeaderDate = $currentWeekStart->copy();
                for ($i = 0; $i < 7; $i++) {
                    $headerDates[] = $currentHeaderDate->copy();
                    $currentHeaderDate->addDay();
                }
            @endphp
            @for($i = 0; $i < 7; $i++)
                <div class="calendar-day-header text-center font-medium text-gray-500 py-2 bg-gray-50 dark:bg-gray-700 dark:text-gray-300 border-r border-b border-gray-200 dark:border-gray-700 text-xs">
                    <div>{{ $rotatedDayNames[$i] }}</div>
                    <div class="text-base font-bold mt-1">{{ $headerDates[$i]->day }}</div>
                </div>
            @endfor

            <!-- Calendar Days -->
            @foreach($days as $day)
                <div class="calendar-day-cell min-h-40 border-r border-b border-gray-200 dark:border-gray-700 p-1 relative flex flex-col
                    {{ $day['date']->isToday() ? 'bg-blue-50 dark:bg-blue-900/20 ring-2 ring-primary-500 ring-inset' : 'bg-white dark:bg-gray-800' }}
                    {{-- Apply closed day styling --}}
                    {{ !$day['isWorkingDay'] ? 'closed-day' : '' }}
                    {{-- Apply capacity colors only for working days --}}
                    {{ $day['isWorkingDay'] && $day['capacityColor'] == 'red' ? 'bg-red-100 dark:bg-red-900/30' : '' }}
                    {{ $day['isWorkingDay'] && $day['capacityColor'] == 'yellow' ? 'bg-yellow-100 dark:bg-yellow-900/30' : '' }}
                    {{ $day['isWorkingDay'] && $day['capacityColor'] == 'green' ? 'bg-green-100 dark:bg-green-900/30' : '' }}">
                    <!-- Day number in circle in upper right corner -->
                    <div class="absolute top-2 right-2 flex justify-end">
                        <div class="calendar-day-number-circle w-6 h-6 rounded-full flex items-center justify-center {{ $day['date']->isToday() ? 'bg-primary-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }}">
                            <span class="text-xs font-medium">{{ $day['date']->day }}</span>
                        </div>
                    </div>
                    
                    <!-- Booking information -->
                    <div class="flex-grow flex flex-col mt-6">
                        @if(!$day['isWorkingDay'])
                            <div class="closed-label text-gray-500 dark:text-gray-400 font-medium text-center">
                                Closed
                            </div>
                        @elseif(count($day['bookings']) > 0)
                            <div class="booking-count text-center text-sm">
                                {{ count($day['bookings']) }} Booked
                            </div>
                            <div class="people-count text-center text-xs">
                                {{ $day['totalPeople'] }}/{{ $day['maxCapacity'] }} People
                            </div>
                            <div class="capacity-bar w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mt-2 overflow-hidden">
                                <div class="h-full rounded-full 
                                    @if($day['capacityPercentage'] >= 100)
                                        bg-red-500
                                    @elseif($day['capacityPercentage'] >= 50)
                                        bg-yellow-500
                                    @else
                                        bg-green-500
                                    @endif" 
                                    style="<?php echo 'width: ' . min($day['capacityPercentage'], 100) . '%'; ?>">
                                </div>
                            </div>
                            
                            <!-- Bookings list -->
                            <div class="mt-2 overflow-y-auto max-h-32">
                                @foreach($day['bookings'] as $booking)
                                    <div class="text-xs p-0.5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                                        <div class="flex items-center space-x-1">
                                            <span class="font-medium text-xs">{{ (new \DateTime($booking->start_time))->format('H:i') }}</span>
                                            <button 
                                                type="button" 
                                                class="text-primary-600 hover:text-primary-800 hover:underline focus:outline-none customer-details-trigger text-xs"
                                                data-customer-name="{{ $booking->customer->name }}"
                                                data-customer-phone="{{ $booking->customer->phone }}"
                                                data-booking-service="{{ $booking->service->name_en }}"
                                            >
                                                {{ $booking->customer->name }}
                                            </button>
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-primary-100 text-primary-800 text-xs font-bold border border-primary-200">
                                                {{ $booking->number_of_people }}
                                            </span>
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="no-bookings text-gray-500 dark:text-gray-400 text-center">
                                {{ $day['totalPeople'] }}/{{ $day['maxCapacity'] }} People
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Legend -->
        <div class="calendar-legend-container mt-6 flex flex-wrap gap-6 justify-center">
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
        </div>
    </div>

    <!-- Customer Details Modal -->
    <div id="customer-details-modal" class="fixed inset-0 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-4 py-3 sm:px-6">
                    <h3 class="text-base leading-6 font-bold text-white">
                        Customer Details
                    </h3>
                </div>
                <div class="bg-white px-4 pt-4 pb-4 sm:p-5 sm:pb-3">
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-blue-500 mr-2 mt-2"></div>
                            <div>
                                <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Name</p>
                                <p class="text-sm font-medium text-gray-900 mt-0.5" id="customer-name"></p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-green-500 mr-2 mt-2"></div>
                            <div>
                                <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Phone</p>
                                <p class="text-sm font-medium text-gray-900 mt-0.5" id="customer-phone"></p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 rounded-full bg-purple-500 mr-2 mt-2"></div>
                            <div>
                                <p class="text-[10px] font-medium text-gray-500 uppercase tracking-wide">Service</p>
                                <p class="text-sm font-medium text-gray-900 mt-0.5" id="booking-service"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-3 py-1.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-2 sm:w-auto close-modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Store PHP values in JavaScript variables
        const prevWeek = '<?php echo $previousWeek->toDateString(); ?>';
        const nextWeek = '<?php echo $nextWeek->toDateString(); ?>';
        
        // Navigation buttons
        if (document.getElementById('prev-btn')) {
            document.getElementById('prev-btn').addEventListener('click', function() {
                const url = new URL(window.location);
                url.searchParams.set('date', prevWeek);
                window.location.href = url.toString();
            });
        }
        
        if (document.getElementById('next-btn')) {
            document.getElementById('next-btn').addEventListener('click', function() {
                const url = new URL(window.location);
                url.searchParams.set('date', nextWeek);
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
            }
        });
        
        // Modal functionality
        const modal = document.getElementById('customer-details-modal');
        
        // Add event listeners for customer details buttons
        document.querySelectorAll('.customer-details-trigger').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                document.getElementById('customer-name').textContent = this.dataset.customerName;
                document.getElementById('customer-phone').textContent = this.dataset.customerPhone;
                document.getElementById('booking-service').textContent = this.dataset.bookingService;
                
                // Show modal
                modal.classList.remove('hidden');
            });
        });
        
        // Close modal when clicking close button
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', function() {
                modal.classList.add('hidden');
            });
        });
        
        // Close modal when clicking on backdrop
        document.querySelector('#customer-details-modal .transition-opacity').addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
            }
        });
    });
</script>
@endpush
</x-filament-panels::page>