<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        @if($this->userId)
            <div class="flex flex-wrap gap-4 mt-6">
                @foreach(range(0, 6) as $day)
                    <div class="flex-shrink-0" style="min-width: 300px; max-width: 370px;">
                        <x-filament::section>
                            <x-slot name="heading">
                                {{ match($day) {
                                    0 => 'Sunday',
                                    1 => 'Monday',
                                    2 => 'Tuesday',
                                    3 => 'Wednesday',
                                    4 => 'Thursday',
                                    5 => 'Friday',
                                    6 => 'Saturday',
                                } }}
                            </x-slot>

                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                        Start Time
                                    </label>
                                    <label class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                        End Time
                                    </label>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <input 
                                        wire:model="shifts.{{ $day }}.start_time"
                                        type="time"
                                        step="60"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500"
                                    />

                                    <input 
                                        wire:model="shifts.{{ $day }}.end_time"
                                        type="time"
                                        step="60"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500"
                                    />
                                </div>
                            </div>
                        </x-filament::section>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex justify-end mt-6" style="margin: 10px;">
            <x-filament::button type="submit">
                Save Shifts
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>