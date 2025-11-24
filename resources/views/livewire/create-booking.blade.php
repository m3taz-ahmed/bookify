<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Book a Service</h1>
        
        <!-- Step 1: Select Service -->
        @if ($step === 1)
            <div>
                <h2 class="text-xl font-semibold mb-4">Select a Service</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($services as $service)
                        <div class="border rounded-lg p-4 hover:bg-gray-50 cursor-pointer" 
                             wire:click="selectService({{ $service->id }})">
                            <h3 class="font-semibold">{{ $service->name_en }}</h3>
                            <p class="text-sm text-gray-600">{{ $service->description }}</p>
                            <div class="mt-2 flex justify-between items-center">
                                <span class="text-lg font-bold">${{ $service->price }}</span>
                                <span class="text-sm text-gray-500">{{ $service->duration_minutes }} mins</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Step 2: Select Date -->
        @if ($step === 2)
            <div>
                <h2 class="text-xl font-semibold mb-4">Select Date</h2>
                <div class="mb-4">
                    <input type="date" 
                           wire:model="selectedDate" 
                           min="{{ date('Y-m-d') }}"
                           class="border rounded px-4 py-2">
                </div>
                <button wire:click="selectDate(selectedDate)" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        @if (!$selectedDate) disabled @endif>
                    Continue
                </button>
                <button wire:click="step = 1" 
                        class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </button>
            </div>
        @endif
        
        <!-- Step 3: Select Time Slot -->
        @if ($step === 3)
            <div>
                <h2 class="text-xl font-semibold mb-4">Select Time Slot</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($availableSlots as $slot)
                        <div class="border rounded-lg p-4 hover:bg-blue-50 cursor-pointer" 
                             wire:click="selectSlot({{ $slot['employee_id'] }}, '{{ $slot['start_time'] }}')">
                            <div class="font-semibold">{{ $slot['employee_name'] }}</div>
                            <div>{{ $slot['start_time'] }} - {{ $slot['end_time'] }}</div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-4 text-gray-500">
                            No available slots for the selected date
                        </div>
                    @endforelse
                </div>
                <button wire:click="step = 2" 
                        class="mt-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </button>
            </div>
        @endif
        
        <!-- Step 4: Customer Information -->
        @if ($step === 4)
            <div>
                <h2 class="text-xl font-semibold mb-4">Customer Information</h2>
                <form wire:submit.prevent="saveBooking">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customerName">
                            Full Name
                        </label>
                        <input type="text" 
                               wire:model="customerName"
                               id="customerName"
                               class="border rounded w-full py-2 px-3 text-gray-700">
                        @error('customerName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customerPhone">
                            Phone Number
                        </label>
                        <input type="text" 
                               wire:model="customerPhone"
                               id="customerPhone"
                               class="border rounded w-full py-2 px-3 text-gray-700">
                        @error('customerPhone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Confirm Booking
                        </button>
                        <button wire:click="step = 3" 
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </button>
                    </div>
                </form>
            </div>
        @endif
        
        <!-- Step 5: Booking Confirmation and QR Code -->
        @if ($step === 5)
            <div class="text-center">
                <h2 class="text-xl font-semibold mb-4">Booking Confirmed!</h2>
                <div class="mb-4">
                    <p>Your booking reference: <strong>{{ $referenceCode }}</strong></p>
                </div>
                <div class="mb-4">
                    <!-- QR Code -->
                    @if ($qrCode)
                        <img src="data:image/png;base64, {{ $qrCode }}" alt="Booking QR Code" class="mx-auto">
                    @else
                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-48 h-48 mx-auto flex items-center justify-center">
                            QR Code Placeholder
                        </div>
                    @endif
                </div>
                <p class="mb-4 text-sm text-gray-600">Scan this QR code at the venue for check-in</p>
                <button wire:click="step = 1" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Book Another Service
                </button>
            </div>
        @endif
    </div>
</div>