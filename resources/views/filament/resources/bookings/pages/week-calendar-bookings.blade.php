<x-filament-panels::page>

    <div x-data="{
        showModal: false,
        customerName: '',
        customerPhone: '',
        bookingService: '',
        openModal(name, phone, service) {
            this.customerName = name;
            this.customerPhone = phone;
            this.bookingService = service;
            this.showModal = true;
        }
    }">
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
                {{ $currentWeekStart->isoFormat('MMM D') }} - {{ $currentWeekEnd->isoFormat('MMM D, YYYY') }}
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
                    
                    // Create day labels with dates
                    $headerDates = [];
                    $currentHeaderDate = $currentWeekStart->copy();
                    for ($i = 0; $i < 7; $i++) {
                        $headerDates[] = $currentHeaderDate->copy();
                        $currentHeaderDate->addDay();
                    }
                @endphp
                @for($i = 0; $i < 7; $i++)
                    <div class="calendar-header-cell">
                        <div>{{ $rotatedDayNames[$i] }}</div>
                        <div class="text-base font-bold mt-1 text-gray-900 dark:text-white">{{ $headerDates[$i]->day }}</div>
                    </div>
                @endfor

                <!-- Calendar Days -->
                @foreach($days as $day)
                    <div class="calendar-day-cell min-h-40 border-r border-b border-gray-200 dark:border-gray-700 p-1 relative flex flex-col
                        {{ $day['date']->isToday() ? 'calendar-day-today ring-1 ring-inset ring-[#8B5A2B]' : 'bg-white dark:bg-gray-800' }}
                        {{-- Apply closed day styling --}}
                        {{ !$day['isWorkingDay'] ? 'closed-day' : '' }}
                        {{-- Apply capacity colors only for working days --}}
                        {{ $day['isWorkingDay'] && $day['capacityColor'] == 'red' ? 'bg-red-50 dark:bg-red-900/10' : '' }}
                        {{ $day['isWorkingDay'] && $day['capacityColor'] == 'yellow' ? 'bg-yellow-50 dark:bg-yellow-900/10' : '' }}
                        {{ $day['isWorkingDay'] && $day['capacityColor'] == 'green' ? 'bg-green-50 dark:bg-green-900/10' : '' }}">
                        <!-- Day number in circle in upper right corner -->
                        <div class="absolute top-2 right-2 flex justify-end">
                            <div class="calendar-day-number-circle w-6 h-6 rounded-full flex items-center justify-center {{ $day['date']->isToday() ? 'calendar-day-number-active' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300' }}">
                                <span class="text-xs font-medium">{{ $day['date']->day }}</span>
                            </div>
                        </div>
                        
                        <!-- Booking information -->
                        <div class="flex-grow flex flex-col mt-6">
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
                                
                                <!-- Bookings list -->
                                <div class="booking-list mt-2 overflow-y-auto max-h-32 w-full">
                                    @foreach($day['bookings'] as $booking)
                                        <div class="text-[10px] p-0.5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                                            <div class="flex items-center space-x-1 w-full">
                                                <span class="font-medium text-[10px] text-gray-500">{{ (new \DateTime($booking->start_time))->format('H:i') }}</span>
                                                <button 
                                                    type="button" 
                                                    class="text-primary-600 hover:text-primary-800 hover:underline focus:outline-none text-[10px] truncate max-w-[80px] text-left"
                                                    @click="openModal(@js($booking->customer->name), @js($booking->customer->phone), @js($booking->service->name_en))"
                                                >
                                                    {{ $booking->customer->name }}
                                                </button>
                                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-primary-100 text-primary-800 text-[9px] font-bold border border-primary-200 ml-auto flex-shrink-0">
                                                    {{ $booking->number_of_people }}
                                                </span>
                                            </div>
                                            
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="no-bookings text-gray-400 dark:text-gray-500 text-center text-xs flex flex-col items-center justify-center h-full w-full">
                                    <span class="mb-1">No Bookings</span>
                                    <span class="text-[10px]">{{ $day['totalPeople'] }}/{{ $day['maxCapacity'] }} People</span>
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
        <div
            x-show="showModal"
            x-cloak
            style="display: none;"
            class="custom-modal-overlay"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="custom-modal-container">
                <div
                    x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="custom-modal-content"
                    @click.away="showModal = false"
                >
                    <!-- Header -->
                    <div class="custom-modal-header">
                        <h3 class="custom-modal-title" id="modal-title">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Customer Details
                        </h3>
                        <button @click="showModal = false" class="text-white hover:text-gray-200 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="custom-modal-body">
                        <div class="space-y-4">
                            <!-- Name -->
                            <div class="custom-info-row">
                                <div class="custom-icon-circle bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer Name</p>
                                    <p class="text-base font-semibold text-gray-900 dark:text-white" x-text="customerName"></p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="custom-info-row">
                                <div class="custom-icon-circle bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Phone Number</p>
                                    <p class="text-base font-semibold text-gray-900 dark:text-white" x-text="customerPhone"></p>
                                </div>
                            </div>

                            <!-- Service -->
                            <div class="custom-info-row">
                                <div class="custom-icon-circle bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Service</p>
                                    <p class="text-base font-semibold text-gray-900 dark:text-white" x-text="bookingService"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="custom-footer">
                        <button
                            type="button"
                            class="custom-close-btn"
                            @click="showModal = false"
                        >
                            Close
                        </button>
                    </div>
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
        });
    </script>
    @endpush
</x-filament-panels::page>