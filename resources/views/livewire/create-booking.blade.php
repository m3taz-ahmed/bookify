<div class="max-w-4xl mx-auto p-4 sm:p-6">
    <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 transition-all duration-300 overflow-hidden relative">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-primary-100 to-secondary-100 rounded-full opacity-20 -mt-32 -mr-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-accent-100 to-primary-100 rounded-full opacity-20 -mb-24 -ml-24"></div>
        <div class="text-center mb-8 relative">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-gradient-to-br from-primary-50 to-secondary-50 rounded-full opacity-20"></div>
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-gradient-to-br from-accent-50 to-primary-50 rounded-full opacity-20"></div>
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ __('website.book_a_service') }}</h1>
                <p class="text-gray-600 max-w-md mx-auto">{{ __('website.follow_simple_steps') }}</p>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="mb-10 relative">
            <div class="flex justify-between relative">
                <!-- Progress line -->
                <div class="absolute top-4 left-0 right-0 h-1.5 bg-gray-200 -z-10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-primary-500 to-secondary-500 transition-all duration-700 ease-in-out rounded-full" 
                         style="width: <?php echo ($step - 1) * 25; ?>%"></div>
                </div>
                
                <!-- Steps -->
                <div class="flex flex-col items-center relative z-10 group">
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
                    <span class="text-xs text-center hidden sm:block {{ $step >= 2 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ __('website.people') }}</span>
                </div>
                
                <div class="flex flex-col items-center relative z-10 group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 
                                {{ $step >= 3 ? 'bg-primary-500 text-white shadow-lg scale-110' : 'bg-white text-gray-500 border-2 border-gray-300 shadow-sm' }}">
                        <span class="font-bold">3</span>
                    </div>
                    <span class="text-xs text-center hidden sm:block {{ $step >= 3 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ __('website.date') }}</span>
                </div>
                
                <div class="flex flex-col items-center relative z-10 group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 
                                {{ $step >= 4 ? 'bg-primary-500 text-white shadow-lg scale-110' : 'bg-white text-gray-500 border-2 border-gray-300 shadow-sm' }}">
                        <span class="font-bold">4</span>
                    </div>
                    <span class="text-xs text-center hidden sm:block {{ $step >= 4 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ __('website.payment') }}</span>
                </div>
                
                <div class="flex flex-col items-center relative z-10 group">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-2 transition-all duration-300 
                                {{ $step >= 5 ? 'bg-primary-500 text-white shadow-lg scale-110' : 'bg-white text-gray-500 border-2 border-gray-300 shadow-sm' }}">
                        <span class="font-bold">5</span>
                    </div>
                    <span class="text-xs text-center hidden sm:block {{ $step >= 5 ? 'font-semibold text-primary-700' : 'text-gray-500' }}">{{ __('website.confirmation') }}</span>
                </div>
            </div>
        </div>
        
        <!-- Step 1: Select Service -->
        @if ($step === 1)
            <div class="transition-all duration-300 fade-in">
                <div class="mb-8 text-center relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full opacity-30 blur-xl"></div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3 relative z-10">{{ __('website.select_service') }}</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">{{ __('website.choose_from_available') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <div class="border border-gray-200 rounded-2xl p-6 hover:border-primary-300 cursor-pointer transition-all duration-300 shadow-sm hover:shadow-xl bg-white hover:bg-gradient-to-br from-white to-primary-50 transform hover:-translate-y-2 relative overflow-hidden group flex flex-col"
                             wire:click="selectService({{ $service->id }})">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500 rounded-full -mt-16 -mr-16 transition-all duration-500 group-hover:scale-[2]"></div>
                            <div class="relative z-10 flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="font-bold text-xl text-gray-900">{{ $service->name }}</h3>
                                </div>
                                <p class="text-sm text-gray-600 mb-5 line-clamp-2 flex-grow">{{ $service->description }}</p>
                                <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-auto">
                                    <span class="text-2xl font-bold text-primary-600">${{ $service->price }}</span>
                                    <span class="inline-flex items-center text-white font-medium text-sm bg-gradient-to-r from-primary-500 to-secondary-600 hover:from-primary-600 hover:to-secondary-700 px-4 py-2 rounded-full transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        {{ __('website.select') }}
                                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Step 2: Select Number of People -->
        @if ($step === 2)
            <div class="transition-all duration-300 fade-in">
                <div class="mb-8 text-center relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 w-24 h-24 bg-gradient-to-br from-accent-100 to-primary-100 rounded-full opacity-30 blur-xl"></div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3 relative z-10">{{ __('website.how_many_people') }}</h2>
                    <p class="text-gray-600 max-w-xl mx-auto text-lg">{{ __('website.select_number_of_people') }}</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 max-w-2xl mx-auto mb-8">
                    @for ($i = 1; $i <= 10; $i++)
                        <div class="border border-gray-200 rounded-2xl p-5 hover:border-primary-300 cursor-pointer transition-all duration-300 bg-white hover:bg-gradient-to-br from-white to-primary-50 text-center transform hover:-translate-y-2 shadow-sm hover:shadow-lg flex flex-col items-center justify-center group {{ $numberOfPeople == $i ? 'ring-2 ring-primary-500 ring-offset-2' : '' }}"
                             wire:click="selectNumberOfPeople({{ $i }})">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center mb-3 transition-all duration-300 group-hover:from-primary-200 group-hover:to-secondary-200 group-hover:scale-110 shadow-md">
                                <span class="text-2xl font-bold text-primary-600">{{ $i }}</span>
                            </div>
                            <div class="text-sm font-medium text-gray-700">{{ __('website.people') }}</div>
                        </div>
                    @endfor
                </div>
                <div class="flex justify-center">
                    <button wire:click="goToPreviousStep()" 
                            class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('website.back_to_services') }}
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Step 3: Select Date and Time -->
        @if ($step === 3)
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
                                   class="w-full pl-4 pr-10 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 bg-white shadow-sm hover:shadow-md">
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
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center">
                        <svg class="h-5 w-5 text-blue-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-blue-800">{{ __('website.selected_date') }}:</span>
                            <span class="font-semibold text-blue-900 ml-1">{{ \Carbon\Carbon::parse($selectedDate)->timezone('Asia/Riyadh')->format('l, F j, Y') }}</span>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Working Hours Display -->
                @if(count($selectedDateWorkingHours) > 0)
                <div class="max-w-md mx-auto mb-6">
                    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium text-indigo-800">{{ __('website.working_hours') }}:</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($selectedDateWorkingHours as $slot)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
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
                                    @foreach($availableTimeSlots as $time)
                                        <button type="button"
                                                wire:click="selectTime('{{ $time }}')"
                                                class="py-3 px-4 text-center rounded-xl border transition-all duration-300 {{ $selectedTime === $time ? 'bg-primary-500 text-white border-primary-500 shadow-md transform scale-105' : 'bg-white border-gray-300 text-gray-700 hover:bg-primary-50 hover:border-primary-300' }}">
                                            {{ $time }}
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
                            <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <span class="text-sm font-medium text-green-800">{{ __('website.selected_time') }}:</span>
                                    <span class="font-semibold text-green-900 ml-1">{{ $selectedTime }}</span>
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
        
        <!-- Step 4: Select Payment Method -->
        @if ($step === 4)
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
                                <span class="font-semibold text-blue-900 ml-1">{{ $selectedTime }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="border border-gray-200 rounded-2xl p-6 hover:border-primary-300 cursor-pointer transition-all duration-300 bg-white hover:bg-gradient-to-br from-white to-primary-50 transform hover:-translate-y-2 shadow-sm hover:shadow-lg" 
                         wire:click="selectPaymentMethod('cash')">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-yellow-100 to-amber-100 flex items-center justify-center shadow-md">
                                    <svg class="w-8 h-8 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl text-gray-900">{{ __('website.cash_payment') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('website.pay_upon_arrival') }}</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                            <p>{{ __('website.cash_payment_description') }}</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-200 rounded-2xl p-6 hover:border-primary-300 cursor-pointer transition-all duration-300 bg-white hover:bg-gradient-to-br from-white to-primary-50 transform hover:-translate-y-2 shadow-sm hover:shadow-lg" 
                         wire:click="selectPaymentMethod('online')">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center shadow-md">
                                    <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-xl text-gray-900">{{ __('website.online_payment') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('website.secure_online_payment') }}</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p>{{ __('website.online_payment_description') }}</p>
                        </div>
                    </div>
                </div>
                
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
        
        <!-- Step 5: Booking Confirmation and QR Code -->
        @if ($step === 5)
            <div class="text-center py-8 relative">
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full opacity-30 blur-2xl"></div>
                <div class="mb-8 relative z-10">
                    <div class="w-24 h-24 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('website.booking_confirmed') }}</h2>
                    <p class="text-gray-600 max-w-lg mx-auto text-xl">{{ __('website.appointment_successfully_booked') }}</p>
                </div>
                
                <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-2xl p-8 max-w-md mx-auto mb-8 border border-primary-100 shadow-lg hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary-500 rounded-full -mt-12 -mr-12 opacity-10"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-secondary-500 rounded-full -mb-16 -ml-16 opacity-10"></div>
                    <div class="relative z-10">
                        <div class="mb-4">
                            <img src="{{ $qrCode }}" alt="Booking QR Code" class="mx-auto w-48 h-48">
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('website.booking_reference') }}</h3>
                            <p class="text-2xl font-mono font-bold text-primary-600">{{ $referenceCode }}</p>
                            <p class="mt-2 text-gray-600">{{ __('website.save_reference_number') }}</p>
                        </div>
                    </div>
                </div>
                
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