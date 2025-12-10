<div class="max-w-4xl mx-auto p-4 sm:p-6">
    <div class="bg-white dark:bg-dark-800 rounded-2xl shadow-xl p-6 sm:p-8 transition-all duration-300 overflow-hidden relative">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-primary-100 to-secondary-100 rounded-full opacity-20 -mt-32 -mr-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-accent-100 to-primary-100 rounded-full opacity-20 -mb-24 -ml-24"></div>
        <div class="text-center mb-8 relative">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-gradient-to-br from-primary-50 to-secondary-50 rounded-full opacity-20"></div>
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-gradient-to-br from-accent-50 to-primary-50 rounded-full opacity-20"></div>
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ __('website.book_a_service') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">{{ __('website.follow_simple_steps') }}</p>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mb-10 relative booking-progress-container" style="position: static !important; top: auto !important;">
            <div class="flex justify-between relative" style="position: static !important;">
                <!-- Progress line -->
                <div class="absolute top-4 left-0 right-0 h-1.5 bg-gray-200 -z-10 rounded-full overflow-hidden" style="position: absolute !important;">
                    <div class="h-full bg-gradient-to-r from-primary-500 to-secondary-500 transition-all duration-700 ease-in-out rounded-full" 
                         style="width: <?php echo (($step - 1) / 4) * 100; ?>%"></div>
                </div>
                
                <!-- Steps -->
                <div class="flex flex-col items-center relative z-10 group" style="position: relative !important;">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 
                                {{ $step >= 1 ? 'bg-primary-500 text-white shadow-lg scale-110' : 'bg-white text-gray-500 border-2 border-gray-300 shadow-sm' }}">
                        <span class="font-bold">1</span>
                    </div>
                    <span class="text-xs text-center hidden sm:block {{ $step >= 1 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ __('website.service') }}</span>
                </div>
                
                <div class="flex flex-col items-center relative z-10 group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 
                                {{ $step >= 2 ? 'bg-primary-500 text-white shadow-lg scale-110' : 'bg-white text-gray-500 border-2 border-gray-300 shadow-sm' }}">
                        <span class="font-bold">2</span>
                    </div>
                    <span class="text-xs text-center hidden sm:block {{ $step >= 2 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ __('website.date') }}</span>
                </div>
                
                <div class="flex flex-col items-center relative z-10 group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 
                                {{ $step >= 3 ? 'bg-primary-500 text-white shadow-lg scale-110' : 'bg-white text-gray-500 border-2 border-gray-300 shadow-sm' }}">
                        <span class="font-bold">3</span>
                    </div>
                    <span class="text-xs text-center hidden sm:block {{ $step >= 3 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ __('website.payment') }}</span>
                </div>
                
                <div class="flex flex-col items-center relative z-10 group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 
                                {{ $step >= 4 ? 'bg-primary-500 text-white shadow-lg scale-110' : 'bg-white text-gray-500 border-2 border-gray-300 shadow-sm' }}">
                        <span class="font-bold">4</span>
                    </div>
                    <span class="text-xs text-center hidden sm:block {{ $step >= 4 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ __('website.confirmation') }}</span>
                </div>
                
                <div class="flex flex-col items-center relative z-10 group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 
                                {{ $step >= 5 ? 'bg-primary-500 text-white shadow-lg scale-110' : 'bg-white text-gray-500 border-2 border-gray-300 shadow-sm' }}">
                        <span class="font-bold">5</span>
                    </div>
                    <span class="text-xs text-center hidden sm:block {{ $step >= 5 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ app()->getLocale() === 'ar' ? 'النتيجة' : 'Result' }}</span>
                </div>
                
                
            </div>
        </div>
        
        <!-- Step 1: Select Tickets -->
        @if ($step === 1)
            <div class="transition-all duration-300 fade-in">
                <div class="mb-8 text-center relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full opacity-30 blur-xl"></div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3 relative z-10">{{ __('website.select_service') }}</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">{{ __('website.choose_from_available') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <div class="rounded-2xl p-5 bg-white border border-gray-200 hover:border-primary-300 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                            <div class="flex items-start justify-between mb-4 flex-grow">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">{{ $service->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $service->description }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-primary-700 font-bold text-xl flex items-center justify-end gap-1">
                                        <x-sar-icon class="w-5 h-5" />
                                        {{ $service->price }}
                                    </div>
                                    {{-- <div class="mt-2 inline-flex items-center bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">
                                        {{ __('website.people') }}
                                    </div> --}}
                                </div>
                            </div>
                            <div class="mt-auto flex items-center justify-between">
                                <div class="inline-flex items-center gap-2">
                                    <button type="button" wire:click="decrementItem({{ $service->id }})" class="w-10 h-10 rounded-full border border-gray-300" style="background-color:#8d8c8c;color:#000;" @if(($ticketItems[$service->id] ?? 0) < 1) disabled @endif>-</button>
                                    <span class="w-10 text-center font-semibold">{{ $ticketItems[$service->id] ?? 0 }}</span>
                                    <button type="button" wire:click="incrementItem({{ $service->id }})" class="w-10 h-10 rounded-full border border-transparent text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800">+</button>
                                </div>
                                @if(($ticketItems[$service->id] ?? 0) > 0)
                                    <span class="text-sm text-gray-600">× {{ $service->price }} = <span class="font-semibold text-gray-900">{{ ($ticketItems[$service->id] ?? 0) * $service->price }}</span></span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 flex items-center justify-between">
                    <div class="text-lg">
                        <span class="text-gray-700">{{ __('website.people') }}:</span>
                        <span class="font-bold text-primary-700">{{ $numberOfPeople }}</span>
                    </div>
                    <div class="flex gap-3">
                        <button wire:click="goToNextStep()" @if($numberOfPeople < 1) disabled @endif class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800">{{ __('website.select_date_time') }}</button>
                    </div>
                </div>
            </div>
        @endif
        
        
        
        <!-- Step 2: Select Date and Time -->
        @if ($step === 2)
            <div class="transition-all duration-300 fade-in">
                <div class="mb-8 text-center relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-gradient-to-br from-accent-100 to-primary-100 rounded-full opacity-30 blur-xl"></div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3 relative z-10">{{ __('website.select_date_time') }}</h2>
                    <p class="text-gray-600 max-w-xl mx-auto text-lg">{{ __('website.choose_appointment_date_time') }}</p>
                </div>
                
                <!-- Date Selection -->
                <div class="max-w-md mx-auto mb-8">
                    <div class="bg-gradient-to-br from-white to-primary-50 rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <label class="block text-gray-700 text-sm font-medium mb-3">{{ __('website.appointment_date') }}</label>
                        <div class="relative">
                            <input type="date" 
                                   wire:model.live="selectedDate" 
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full pl-4 pr-10 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 bg-white shadow-sm hover:shadow-md"
                            @error('selectedDate')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Selected Date Summary -->
                @if($selectedDate)
                <div class="max-w-md mx-auto mb-6">
                    <div class="bg-blue-50 border border-blue-200 dark:bg-blue-900/20 dark:border-blue-800 rounded-xl p-4 flex items-center">
                        <svg class="h-5 w-5 text-blue-500 dark:text-blue-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-blue-800 dark:text-blue-300">{{ __('website.selected_date') }}:</span>
                            <span class="font-semibold text-blue-900 dark:text-blue-100 ml-1">{{ \Carbon\Carbon::parse($selectedDate)->timezone('Asia/Riyadh')->format('l, F j, Y') }}</span>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Working Hours Display -->
                @if(count($selectedDateWorkingHours) > 0)
                <div class="max-w-md mx-auto mb-6">
                    <div class="bg-indigo-50 border border-indigo-200 dark:bg-indigo-900/20 dark:border-indigo-800 rounded-xl p-4">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-indigo-500 dark:text-indigo-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium text-indigo-800 dark:text-indigo-300">{{ __('website.working_hours') }}:</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($selectedDateWorkingHours as $slot)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-200">
                                    {{ $slot['start'] }} - {{ $slot['end'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Time Selection -->
                @if($selectedDate)
                    @php
                        // Check if the selected date is a working day
                        $isWorkingDay = false;
                        try {
                            $bookingDate = \Carbon\Carbon::parse($selectedDate)->timezone('Asia/Riyadh');
                            $isWorkingDay = \App\Models\SiteSetting::isWorkingDay($bookingDate);
                        } catch (\Exception $e) {
                            $isWorkingDay = false;
                        }
                    @endphp
                    
                    @if($isWorkingDay && count($availableTimeSlots) > 0)
                        <div class="max-w-md mx-auto mb-8">
                            <div class="bg-gradient-to-br from-white to-primary-50 rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                                <label class="block text-gray-700 text-sm font-medium mb-3">{{ __('website.Time') }} (الوقت)</label>
                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                    @php
                                        $today = \Carbon\Carbon::today()->timezone('Asia/Riyadh');
                                        $selectedDateObj = $selectedDate ? \Carbon\Carbon::parse($selectedDate)->timezone('Asia/Riyadh') : null;
                                        $isToday = $selectedDateObj && $selectedDateObj->isSameDay($today);
                                        $currentTime = \Carbon\Carbon::now('Asia/Riyadh');
                                        
                                        // Round up to the next 30-minute slot
                                        $currentHour = $currentTime->hour;
                                        $currentMinute = $currentTime->minute;
                                        
                                        // Round up to next 30-minute interval
                                        if ($currentMinute > 0 && $currentMinute <= 30) {
                                            $currentMinute = 30;
                                        } elseif ($currentMinute > 30) {
                                            $currentHour += 1;
                                            $currentMinute = 0;
                                        }
                                        
                                        // Format as H:i
                                        $currentSlot = sprintf('%02d:%02d', $currentHour, $currentMinute);
                                    @endphp
                                    
                                    @foreach($availableTimeSlots as $time)
                                        @php
                                            $isPastTime = $isToday && $time < $currentSlot;
                                        @endphp
                                        <button type="button"
                                                @if(!$isPastTime) wire:click="selectTime('{{ $time }}')" @endif
                                                @if($isPastTime) disabled @endif
                                                class="py-3 px-4 text-center rounded-xl border transition-all duration-300 {{ $isPastTime ? 'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed' : ($selectedTime === $time ? 'bg-primary-500 text-white border-primary-500 shadow-md transform scale-105' : 'bg-white border-gray-300 text-gray-700 hover:bg-primary-50 hover:border-primary-300') }}">
                                            {{ $time }}
                                            @if($isPastTime)
                                                <span class="block text-xs mt-1">{{ app()->getLocale() === 'ar' ? '(غير متاح)' : '(Unavailable)' }}</span>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                                @error('selectedTime')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Selected Time Summary -->
                        @if($selectedTime)
                        <div class="max-w-md mx-auto mb-6">
                            <div class="bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800 rounded-xl p-4 flex items-center">
                                <svg class="h-5 w-5 text-green-500 dark:text-green-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-green-800 dark:text-green-300">{{ __('website.selected_time') }}:</span>
                                    <span class="font-semibold text-green-900 dark:text-green-100 ml-1">{{ \Carbon\Carbon::createFromFormat('H:i', $selectedTime, 'Asia/Riyadh')->format('g:i A') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    @elseif($isWorkingDay)
                        <div class="max-w-md mx-auto mb-8">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
                                <svg class="h-12 w-12 text-yellow-500 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="text-lg font-medium text-yellow-800 mb-2">{{ __('website.no_available_slots') }}</h3>
                                <p class="text-yellow-700">{{ __('website.please_select_another_date') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="max-w-md mx-auto mb-8">
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
                                <svg class="h-12 w-12 text-red-500 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="text-lg font-medium text-red-800 mb-2">{{ __('website.non_working_day') }}</h3>
                                <p class="text-red-700">{{ __('website.cannot_book_on_non_working_day') }}</p>
                            </div>
                        </div>
                    @endif
                @endif
                
                <div class="flex justify-center mb-4">
                    <button wire:click="handleDateSelection()" 
                            wire:loading.attr="disabled" wire:target="handleDateSelection"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            @if(!$selectedDate || !$selectedTime) disabled @endif>
                        {{ __('website.continue_to_payment') }}
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="flex justify-center">
                    <button wire:click="goToPreviousStep()" 
                            class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('website.back') }}
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Step 3: Select Payment Method -->
        @if ($step === 3)
            <div class="transition-all duration-300 fade-in max-w-2xl mx-auto">
                <div class="mb-8 text-center relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-gradient-to-br from-accent-100 to-primary-100 rounded-full opacity-30 blur-xl"></div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3 relative z-10">{{ __('website.select_payment_method') }}</h2>
                    <p class="text-gray-600 text-lg">{{ __('website.choose_how_to_pay') }}</p>
                </div>
                
                <!-- Selected Service Summary -->
                @if($selectedService)
                <div class="max-w-md mx-auto mb-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-sm font-medium text-blue-800">{{ __('website.selected_service') }}:</span>
                                <span class="font-semibold text-blue-900 ml-1">{{ $services->firstWhere('id', $selectedService)?->name }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-medium text-blue-800">{{ __('website.people') }}:</span>
                                <span class="font-semibold text-blue-900 ml-1">{{ $numberOfPeople }}</span>
                            </div>
                        </div>
                        <div class="mt-2 flex justify-between items-center">
                            <div>
                                <span class="text-sm font-medium text-blue-800">{{ __('website.date') }}:</span>
                                <span class="font-semibold text-blue-900 ml-1">{{ \Carbon\Carbon::parse($selectedDate)->timezone('Asia/Riyadh')->format('M j, Y') }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-medium text-blue-800">{{ __('website.time') }}:</span>
                                <span class="font-semibold text-blue-900 ml-1">{{ \Carbon\Carbon::createFromFormat('H:i', $selectedTime, 'Asia/Riyadh')->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Processing bar -->
                <div wire:loading wire:target="selectPaymentMethod" class="mb-6">
                  <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full w-1/3 bg-gradient-to-r from-primary-500 to-secondary-500 animate-pulse"></div>
                  </div>
                  <p class="mt-2 text-sm text-gray-600 text-center">{{ app()->getLocale() === 'ar' ? 'جاري معالجة اختيارك...' : 'Processing your selection...' }}</p>
                </div>
                
                <!-- Check if both payment methods are disabled -->
                @if(!$isCashPaymentEnabled && !$isOnlinePaymentEnabled)
                <div class="max-w-md mx-auto mb-8">
                    <div class="bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800 rounded-xl p-6 text-center">
                        <svg class="h-12 w-12 text-red-500 dark:text-red-400 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-lg font-medium text-red-800 dark:text-red-300 mb-2">{{ __('website.payment_methods_unavailable') }}</h3>
                        <p class="text-red-700 dark:text-red-400">{{ __('website.payment_methods_unavailable_message') }}</p>
                    </div>
                </div>
                @else
                @php
                    $enabledPaymentCount = ($isCashPaymentEnabled ? 1 : 0) + ($isOnlinePaymentEnabled ? 1 : 0);
                @endphp
                <div class="grid grid-cols-1 {{ $enabledPaymentCount === 2 ? 'md:grid-cols-2' : '' }} gap-6 mb-8 {{ $enabledPaymentCount === 1 ? 'max-w-md mx-auto' : '' }}">
                    @if($isCashPaymentEnabled)
                    <div class="border border-gray-200 dark:border-dark-700 rounded-2xl p-6 hover:border-primary-300 dark:hover:border-primary-500 cursor-pointer transition-all duration-300 bg-white dark:bg-dark-800 hover:bg-gradient-to-br from-white to-primary-50 dark:from-dark-800 dark:to-primary-900/20 transform hover:-translate-y-2 shadow-sm hover:shadow-lg" 
                         wire:click="selectPaymentMethod('cash')" 
                         wire:loading.class="opacity-50 pointer-events-none" 
                         wire:loading.attr="disabled" 
                         wire:target="selectPaymentMethod"
                         onclick="console.log('Cash payment clicked');">
                        <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 mr-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-yellow-100 to-amber-100 dark:from-yellow-900/30 dark:to-amber-900/30 flex items-center justify-center shadow-md">
                                <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl text-gray-900 dark:text-white">{{ __('website.cash_payment') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('website.pay_upon_arrival') }}</p>
                        </div>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-100 dark:border-yellow-900/30">
                            <p>{{ __('website.cash_payment_description') }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($isOnlinePaymentEnabled)
                    <div class="border border-gray-200 dark:border-dark-700 rounded-2xl p-6 bg-white dark:bg-dark-800 shadow-sm">
                        <div class="mb-4">
                            <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-2">{{ __('website.online_payment') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('website.secure_online_payment') }}</p>
                        </div>
                        
                        <!-- Payment Type Selection: Card or Apple Pay -->
                        <div class="space-y-3">
                            <!-- Card Payment -->
                            <div class="border border-gray-200 dark:border-dark-700 rounded-xl p-4 hover:border-primary-300 dark:hover:border-primary-500 cursor-pointer transition-all duration-300 hover:bg-gradient-to-br from-white to-primary-50 dark:from-dark-800 dark:to-primary-900/20 transform hover:-translate-y-1 shadow-sm hover:shadow-md"
                                 wire:click="selectPaymentType('card')" 
                                 wire:loading.class="opacity-50 pointer-events-none" 
                                 wire:loading.attr="disabled" 
                                 wire:target="selectPaymentType"
                                 onclick="console.log('Card payment clicked');">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center relative">
                                            <!-- Loading spinner -->
                                            <div wire:loading wire:target="selectPaymentType" class="absolute inset-0 flex items-center justify-center">
                                                <svg class="animate-spin h-6 w-6 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                            <!-- Card icon -->
                                            <svg wire:loading.remove wire:target="selectPaymentType" class="w-6 h-6 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ app()->getLocale() === 'ar' ? 'بطاقة ائتمان/خصم' : 'Credit/Debit Card' }}</h4>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <span wire:loading.remove wire:target="selectPaymentType">{{ app()->getLocale() === 'ar' ? 'فيزا، ماستركارد، مدى' : 'Visa, Mastercard, Mada' }}</span>
                                            <span wire:loading wire:target="selectPaymentType" class="text-blue-600 dark:text-blue-500">{{ app()->getLocale() === 'ar' ? 'جاري المعالجة...' : 'Processing...' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Apple Pay -->
                            <div class="border border-gray-200 dark:border-dark-700 rounded-xl p-4 hover:border-primary-300 dark:hover:border-primary-500 cursor-pointer transition-all duration-300 hover:bg-gradient-to-br from-white to-primary-50 dark:from-dark-800 dark:to-primary-900/20 transform hover:-translate-y-1 shadow-sm hover:shadow-md"
                                 wire:click="selectPaymentType('apple_pay')" 
                                 wire:loading.class="opacity-50 pointer-events-none" 
                                 wire:loading.attr="disabled" 
                                 wire:target="selectPaymentType"
                                 onclick="console.log('Apple Pay clicked');">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gray-800 to-black dark:from-gray-700 dark:to-gray-900 flex items-center justify-center relative">
                                            <!-- Loading spinner -->
                                            <div wire:loading wire:target="selectPaymentType" class="absolute inset-0 flex items-center justify-center">
                                                <svg class="animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                            <!-- Apple Pay icon -->
                                            <svg wire:loading.remove wire:target="selectPaymentType" class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M17.05 20.28c-.98.95-2.05.88-3.08.4-1.09-.5-2.08-.48-3.24 0-1.44.62-2.2.44-3.06-.4C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Apple Pay</h4>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <span wire:loading.remove wire:target="selectPaymentType">{{ app()->getLocale() === 'ar' ? 'ادفع بأمان بواسطة Apple Pay' : 'Pay securely with Apple Pay' }}</span>
                                            <span wire:loading wire:target="selectPaymentType" class="text-gray-800 dark:text-gray-300">{{ app()->getLocale() === 'ar' ? 'جاري المعالجة...' : 'Processing...' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
                <!-- Billing Information Collection Form -->
                @if($collectBillingInfo)
                <div class="max-w-md mx-auto mt-8 mb-8 p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-blue-200 dark:border-blue-800 shadow-lg">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ app()->getLocale() === 'ar' ? 'معلومات الدفع المطلوبة' : 'Required Payment Information' }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ app()->getLocale() === 'ar' ? 'يرجى تقديم المعلومات التالية لإكمال عملية الدفع' : 'Please provide the following information to complete your payment' }}</p>
                    </div>
                    
                    <form wire:submit.prevent="submitBillingInfo" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ app()->getLocale() === 'ar' ? 'الاسم الأول' : 'First Name' }} *</label>
                            <input type="text" 
                                   wire:model="billingFirstName" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-dark-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 bg-white dark:bg-dark-700 dark:text-white shadow-sm hover:shadow-md"
                                   placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل اسمك الأول' : 'Enter your first name' }}">
                            @error('billingFirstName')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ app()->getLocale() === 'ar' ? 'اسم العائلة' : 'Last Name' }} *</label>
                            <input type="text" 
                                   wire:model="billingLastName" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-dark-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 bg-white dark:bg-dark-700 dark:text-white shadow-sm hover:shadow-md"
                                   placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل اسم عائلتك' : 'Enter your last name' }}">
                            @error('billingLastName')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ app()->getLocale() === 'ar' ? 'البريد الإلكتروني' : 'Email Address' }} *</label>
                            <input type="email" 
                                   wire:model="billingEmail" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-dark-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 bg-white dark:bg-dark-700 dark:text-white shadow-sm hover:shadow-md"
                                   placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل بريدك الإلكتروني' : 'Enter your email address' }}">
                            @error('billingEmail')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ app()->getLocale() === 'ar' ? 'رقم الهاتف' : 'Phone Number' }} *</label>
                            <input type="tel" 
                                   wire:model="billingPhone" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-dark-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 bg-white dark:bg-dark-700 dark:text-white shadow-sm hover:shadow-md"
                                   placeholder="{{ app()->getLocale() === 'ar' ? 'أدخل رقم هاتفك' : 'Enter your phone number' }}">
                            @error('billingPhone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-between pt-4">
                            {{-- <button type="button" 
                                    wire:click="collectBillingInfo = false"
                                    class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'رجوع' : 'Back' }}
                            </button> --}}
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ app()->getLocale() === 'ar' ? 'متابعة الدفع' : 'Continue to Payment' }}
                            </button>
                        </div>
                    </form>
                </div>
                @endif
                
                <!-- Display booking errors -->
                @error('booking')
                    <div class="max-w-md mx-auto mb-6">
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <span class="text-sm font-medium text-red-800">{{ $message }}</span>
                            </div>
                        </div>
                    </div>
                @enderror
                
                <div class="flex justify-center">
                    <button wire:click="goToPreviousStep()" 
                            class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('website.back') }}
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Step 4: Booking Confirmation and QR Code -->
        @if ($step === 4)
            <div class="text-center py-8 relative">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full opacity-30 blur-2xl"></div>
                <div class="mb-8 relative z-10">
                    <div class="w-24 h-24 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ __('website.booking_confirmed') }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 max-w-lg mx-auto text-xl">{{ __('website.appointment_successfully_booked') }}</p>
                </div>
                
                <div class="bg-gradient-to-r from-primary-50 to-secondary-50 dark:from-primary-900/30 dark:to-secondary-900/30 rounded-2xl p-8 max-w-md mx-auto mb-8 border border-primary-100 dark:border-primary-900/50 shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary-500 rounded-full -mt-12 -mr-12 opacity-10"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-secondary-500 rounded-full -mb-16 -ml-16 opacity-10"></div>
                    <div class="relative z-10">
                        <div class="mb-4">
                            <img src="{{ $qrCode }}" alt="Booking QR Code" class="mx-auto w-48 h-48">
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ __('website.booking_reference') }}</h3>
                            <p class="text-2xl font-mono font-bold text-primary-600 dark:text-primary-400">{{ $referenceCode }}</p>
                            <p class="mt-2 text-gray-600 dark:text-gray-300">{{ __('website.save_reference_number') }}</p>
                        </div>
                    </div>
                </div>
                @if($bookingLink)
                <div class="max-w-md mx-auto mb-8">
                    <div class="bg-white dark:bg-dark-800 border border-gray-200 dark:border-dark-700 rounded-xl p-4 text-center">
                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">{{ app()->getLocale() === 'ar' ? 'رابط تفاصيل الحجز (للمشاركة على الجوال)' : 'Booking details link (for SMS)' }}</p>
                        <a href="{{ $bookingLink }}" class="break-all text-primary-700 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300">{{ $bookingLink }}</a>
                    </div>
                </div>
                @endif
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('customer.bookings') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('website.view_my_bookings') }}
                    </a>
                    <a href="{{ route('customer.bookings.create') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('website.book_another_service') }}
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Step 5: Payment Result -->
        @if ($step === 5)
            <div class="text-center py-8 relative">
                @if($paymentStatus === 'success')
                    <!-- Payment Success -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full opacity-30 blur-2xl"></div>
                    <div class="mb-8 relative z-10">
                        <div class="w-24 h-24 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ app()->getLocale() === 'ar' ? 'تم الدفع بنجاح!' : 'Payment Successful!' }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 max-w-lg mx-auto text-xl">{{ __('website.booking_confirmed') }}</p>
                    </div>
                    
                    <div class="bg-gradient-to-r from-primary-50 to-secondary-50 dark:from-primary-900/30 dark:to-secondary-900/30 rounded-2xl p-8 max-w-md mx-auto mb-8 border border-primary-100 dark:border-primary-900/50 shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-primary-500 rounded-full -mt-12 -mr-12 opacity-10"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-secondary-500 rounded-full -mb-16 -ml-16 opacity-10"></div>
                        <div class="relative z-10">
                            <div class="mb-4">
                                <img src="{{ $qrCode }}" alt="Booking QR Code" class="mx-auto w-48 h-48">
                            </div>
                            <div class="text-center">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ __('website.booking_reference') }}</h3>
                                <p class="text-2xl font-mono font-bold text-primary-600 dark:text-primary-400">{{ $referenceCode }}</p>
                                <p class="mt-2 text-gray-600 dark:text-gray-300">{{ __('website.save_reference_number') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($bookingLink)
                    <div class="max-w-md mx-auto mb-8">
                        <div class="bg-white dark:bg-dark-800 border border-gray-200 dark:border-dark-700 rounded-xl p-4 text-center">
                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">{{ app()->getLocale() === 'ar' ? 'رابط تفاصيل الحجز' : 'Booking details link' }}</p>
                            <a href="{{ $bookingLink }}" class="break-all text-primary-700 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300">{{ $bookingLink }}</a>
                        </div>
                    </div>
                    @endif
                @elseif($paymentStatus === 'pending')
                    <!-- Payment Pending -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-gradient-to-br from-yellow-100 to-amber-100 rounded-full opacity-30 blur-2xl"></div>
                    <div class="mb-8 relative z-10">
                        <div class="w-24 h-24 bg-gradient-to-r from-yellow-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ app()->getLocale() === 'ar' ? 'الدفع قيد المعالجة' : 'Payment Pending' }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 max-w-lg mx-auto text-xl">{{ app()->getLocale() === 'ar' ? 'يتم التحقق من الدفع. سنرسل لك التأكيد قريباً.' : 'Your payment is being verified. We will send you confirmation shortly.' }}</p>
                    </div>
                    
                    <div class="max-w-md mx-auto mb-8">
                        <div class="bg-yellow-50 border border-yellow-200 dark:bg-yellow-900/20 dark:border-yellow-800 rounded-xl p-6 text-center">
                            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ app()->getLocale() === 'ar' ? 'رقم مرجع الحجز' : 'Booking Reference' }}:</p>
                            <p class="text-2xl font-mono font-bold text-yellow-700 dark:text-yellow-400">{{ $referenceCode }}</p>
                        </div>
                    </div>
                @else
                    <!-- Payment Failed -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-gradient-to-br from-red-100 to-pink-100 rounded-full opacity-30 blur-2xl"></div>
                    <div class="mb-8 relative z-10">
                        <div class="w-24 h-24 bg-gradient-to-r from-red-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ app()->getLocale() === 'ar' ? 'فشل الدفع' : 'Payment Failed' }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 max-w-lg mx-auto text-xl">{{ app()->getLocale() === 'ar' ? 'لم نتمكن من معالجة دفعتك. يرجى المحاولة مرة أخرى.' : 'We could not process your payment. Please try again.' }}</p>
                    </div>
                    
                    <div class="max-w-md mx-auto mb-8">
                        <div class="bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800 rounded-xl p-6 text-center">
                            @if($payment && $payment->failed_reason)
                                <p class="text-red-700 dark:text-red-400 mb-4">{{ $payment->failed_reason }}</p>
                            @endif
                            <p class="text-gray-700 dark:text-gray-300">{{ app()->getLocale() === 'ar' ? 'تم إلغاء الحجز. يمكنك المحاولة مرة أخرى.' : 'Your booking has been cancelled. You can try again.' }}</p>
                        </div>
                    </div>
                @endif
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('customer.bookings') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('website.view_my_bookings') }}
                    </a>
                    <a href="{{ route('customer.bookings.create') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        {{ __('website.book_another_service') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
    
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Ensure progress bar doesn't stick or move */
        .booking-progress-container {
            position: static !important;
            top: auto !important;
            bottom: auto !important;
            left: auto !important;
            right: auto !important;
            transform: none !important;
            will-change: auto !important;
        }
        
        .booking-progress-container * {
            position: relative !important;
            transform: none !important;
        }
        
        .booking-progress-container .absolute {
            position: absolute !important;
            transform: none !important;
        }
        
        /* Prevent any scroll-based movement on steps */
        .booking-progress-container .flex.flex-col.items-center {
            transform: none !important;
            position: relative !important;
        }
    </style>
    
    <script>
        document.addEventListener('livewire:load', function () {
            // Listen for the custom date-selected event
            window.addEventListener('date-selected', function (event) {
                // Update the Livewire property
                Livewire.emit('setSelectedDate', event.detail.date);
            });
        });
    </script>
</div>
