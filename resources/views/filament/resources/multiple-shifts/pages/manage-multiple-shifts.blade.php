<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        @if($this->userId)
            <div style="display: flex; margin-top: 24px; gap: 18px; flex-wrap: wrap; justify-content: flex-start;">
                @foreach(range(0, 6) as $day)
                    <div style="margin: 0; max-width: 370px; min-width: 320px; flex-shrink: 0; border-radius: 18px; box-shadow: 0 2px 16px 0 rgba(60,72,88,0.10); border: 1px solid rgb(85, 90, 95); display: flex; flex-direction: column;">
                        <div style="padding: 20px 24px 12px 24px; border-bottom: 1px solid #e0e7ef; background: #161617 ; border-top-left-radius: 18px; border-top-right-radius: 18px;">
                            <div style="display: flex; align-items: center; gap: 10px; justify-content: space-between;">
                                <span style="font-size: 1.1rem; font-weight: 700; color: #f19739; letter-spacing: 0.5px;">{{ match($day) {
                                    0 => 'Sunday',
                                    1 => 'Monday',
                                    2 => 'Tuesday',
                                    3 => 'Wednesday',
                                    4 => 'Thursday',
                                    5 => 'Friday',
                                    6 => 'Saturday',
                                } }}</span>
                                <x-filament::button 
                                    wire:click="addShiftBlock({{ $day }})"
                                    color="primary"
                                    size="sm"
                                    icon="heroicon-o-plus"
                                >
                                    Add Shift
                                </x-filament::button>
                            </div>
                        </div>
                        
                        <div style="padding: 18px 24px 12px 24px; flex: 1; display: flex; flex-direction: column; gap: 18px; background: transparent;">
                            @foreach($this->shiftGroups[$day] as $index => $shift)
                                <div style="display: flex; flex-direction: column; gap: 8px; padding: 12px; border: 1px solid #333; border-radius: 8px; background: #1a1a1a;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <label style="font-size: 0.97rem; font-weight: 500; margin-bottom: 2px;">Shift {{ $index + 1 }}</label>
                                        @if(count($this->shiftGroups[$day]) > 1)
                                            <x-filament::button 
                                                wire:click="removeShiftBlock({{ $day }}, {{ $index }})"
                                                color="danger"
                                                size="xs"
                                                icon="heroicon-o-trash"
                                            >
                                                Remove
                                            </x-filament::button>
                                        @endif
                                    </div>
                                    
                                    <div style="display: flex; gap: 10px;">
                                        <div style="flex: 1;">
                                            <label style="font-size: 0.85rem; display: block; margin-bottom: 4px;">Start Time</label>
                                            <input 
                                                wire:model="shiftGroups.{{ $day }}.{{ $index }}.start_time"
                                                type="time"
                                                step="60"
                                                style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1.5px solid #c7d2fe; font-size: 1rem; box-shadow: 0 1px 2px 0 rgba(60,72,88,0.04); transition: border-color 0.2s;"
                                                onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#c7d2fe'"
                                            />
                                        </div>
                                        
                                        <div style="flex: 1;">
                                            <label style="font-size: 0.85rem; display: block; margin-bottom: 4px;">End Time</label>
                                            <input 
                                                wire:model="shiftGroups.{{ $day }}.{{ $index }}.end_time"
                                                type="time"
                                                step="60"
                                                style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1.5px solid #c7d2fe; font-size: 1rem; box-shadow: 0 1px 2px 0 rgba(60,72,88,0.04); transition: border-color 0.2s;"
                                                onfocus="this.style.borderColor='#6366f1'" onblur="this.style.borderColor='#c7d2fe'"
                                            />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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