<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 transition-all duration-300">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('website.book_a_service') }}</h1>
            <p class="text-gray-600">{{ __('website.follow_simple_steps') }}</p>
        </div>
        
        <!-- Step 1: Select Service -->
        @if ($step === 1)
            <div class="transition-all duration-300 fade-in">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('website.select_service') }}</h2>
                    <p class="text-gray-600">{{ __('website.choose_from_available') }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <div class="border border-gray-200 rounded-xl p-6 hover:border-primary-300 cursor-pointer transition-all duration-300 shadow-sm hover:shadow-md bg-white hover:bg-primary-50 transform hover:-translate-y-1" 
                             wire:click="selectService({{ $service->id }})">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-lg text-gray-900">{{ $service->name_en }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    {{ $service->duration_minutes }} {{ __('website.mins') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">{{ $service->description }}</p>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="text-xl font-bold text-primary-600">${{ $service->price }}</span>
                                <span class="inline-flex items-center text-primary-600 font-medium text-sm">
                                    {{ __('website.select') }}
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Step 2: Select Date -->
        @if ($step === 2)
            <div class="transition-all duration-300 fade-in">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('website.select_date') }}</h2>
                    <p class="text-gray-600">{{ __('website.choose_appointment_date') }}</p>
                </div>
                <div class="mb-6 max-w-md mx-auto">
                    <label class="block text-gray-700 text-sm font-medium mb-3">{{ __('website.appointment_date') }}</label>
                    <div class="relative">
                        <input type="date" 
                               wire:model="selectedDate" 
                               min="{{ date('Y-m-d') }}"
                               class="w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-primary-50 rounded-lg p-4 max-w-md mx-auto mb-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-primary-400 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-primary-700">{{ __('website.available_slots_info') }}</p>
                    </div>
                </div>
                <div class="flex justify-center">
                    <button wire:click="step = 1" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('website.back_to_services') }}
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Step 3: Select Time Slot -->
        @if ($step === 3)
            <div class="transition-all duration-300 fade-in">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('website.select_time_slot') }}</h2>
                    <p class="text-gray-600">{{ __('website.available_slots_for', ['date' => \Carbon\Carbon::parse($selectedDate)->format('F j, Y')]) }}</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($availableSlots as $slot)
                        <div class="border border-gray-200 rounded-xl p-5 hover:border-primary-300 cursor-pointer transition-all duration-300 bg-white hover:bg-primary-50 transform hover:-translate-y-1" 
                             wire:click="selectSlot({{ $slot['employee_id'] }}, '{{ $slot['start_time'] }}')">
                            <div class="flex items-center mb-3">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $slot['employee_name'] }}</div>
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($slot['start_time'])->diffInMinutes(\Carbon\Carbon::parse($slot['end_time'])) }} {{ __('website.minutes') }}</div>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100 flex justify-between items-center">
                                <span class="font-medium text-gray-900">{{ $slot['start_time'] }} - {{ $slot['end_time'] }}</span>
                                <span class="inline-flex items-center text-primary-600 font-medium text-sm">
                                    {{ __('website.select') }}
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 text-gray-500 bg-gray-50 rounded-xl border border-gray-200">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-4 font-medium text-lg text-gray-900">{{ __('website.no_available_slots') }}</p>
                            <p class="mt-1 text-gray-500">{{ __('website.select_different_date') }}</p>
                        </div>
                    @endforelse
                </div>
                <div class="flex justify-center mt-8">
                    <button wire:click="step = 2" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('website.back_to_date_selection') }}
                    </button>
                </div>
            </div>
        @endif
        
        <!-- Step 4: Customer Information -->
        @if ($step === 4)
            <div class="transition-all duration-300 fade-in max-w-2xl mx-auto">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('website.customer_information') }}</h2>
                    <p class="text-gray-600">{{ __('website.provide_contact_details') }}</p>
                </div>
                <form wire:submit.prevent="saveBooking" class="space-y-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="customerName">
                            {{ __('website.full_name') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" 
                                   wire:model="customerName"
                                   id="customerName"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 @error('customerName') border-red-500 @enderror"
                                   placeholder="{{ __('website.enter_full_name') }}">
                        </div>
                        @error('customerName') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="customerPhone">
                            {{ __('website.phone_number') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   wire:model="customerPhone"
                                   id="customerPhone"
                                   class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 @error('customerPhone') border-red-500 @enderror"
                                   placeholder="{{ __('website.enter_phone_number') }}">
                        </div>
                        @error('customerPhone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
                        <button wire:click="step = 3" 
                                type="button"
                                class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('website.back') }}
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ __('website.confirm_booking') }}
                        </button>
                    </div>
                </form>
            </div>
        @endif
        
        <!-- Step 5: Booking Confirmation and QR Code -->
        @if ($step === 5)
            <div class="text-center py-8">
                <div class="mb-8">
                    <div class="w-20 h-20 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-3">{{ __('website.booking_confirmed') }}</h2>
                    <p class="text-gray-600 max-w-lg mx-auto text-lg">{{ __('website.appointment_successfully_booked') }}</p>
                </div>
                
                <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-2xl p-8 max-w-md mx-auto mb-8 border border-primary-100 shadow-sm">
                    <div class="mb-4">
                        <svg class="mx-auto h-12 w-12 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800 mb-3">{{ __('website.booking_reference') }}</p>
                    <p class="text-3xl font-bold text-primary-700 mb-5 tracking-wider">{{ $referenceCode }}</p>
                    <p class="text-sm text-gray-600">{{ __('website.save_reference_number') }}</p>
                </div>
                
                <div class="mb-10 max-w-md mx-auto">
                    <h3 class="font-bold text-xl text-gray-900 mb-4">{{ __('website.check_in_qr_code') }}</h3>
                    <div class="flex justify-center mb-4">
                        <!-- QR Code -->
                        @if ($qrCode)
                            <div class="p-4 bg-white rounded-xl shadow-lg border-4 border-white inline-block">
                                <img src="data:image/png;base64, {{ $qrCode }}" alt="{{ __('website.booking_qr_code') }}" class="mx-auto">
                            </div>
                        @else
                            <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-xl w-48 h-48 mx-auto flex items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <p class="text-gray-600 max-w-md mx-auto">{{ __('website.scan_qr_code_for_check_in') }}</p>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <button wire:click="step = 1" 
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                        <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        {{ __('website.book_another_service') }}
                    </button>
                    <a href="{{ route('customer.bookings', ['locale' => $currentLocale]) }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 shadow-sm">
                        <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        {{ __('website.view_my_bookings') }}
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
</div>