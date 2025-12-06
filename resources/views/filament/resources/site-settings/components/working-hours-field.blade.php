<div x-data="{
    workingHours: {{ Illuminate\Support\Js::from($getState() ?: []) }},
    days: ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
    dayNames: {
        'sunday': '{{ __('filament.Sunday') }}',
        'monday': '{{ __('filament.Monday') }}', 
        'tuesday': '{{ __('filament.Tuesday') }}',
        'wednesday': '{{ __('filament.Wednesday') }}',
        'thursday': '{{ __('filament.Thursday') }}',
        'friday': '{{ __('filament.Friday') }}',
        'saturday': '{{ __('filament.Saturday') }}'
    },
    init() {
        // Ensure workingHours is always an object
        if (!this.workingHours || typeof this.workingHours !== 'object' || Array.isArray(this.workingHours)) {
            if (Array.isArray(this.workingHours) && this.workingHours.length === 0) {
                this.workingHours = {};
            } else if (Array.isArray(this.workingHours)) {
                this.workingHours = {};
            }
        }
        
        // Ensure each day has proper data structure
        this.days.forEach(day => {
            let val = this.workingHours[day];
            
            if (val === undefined || val === null || val === false) {
                this.workingHours[day] = null;
            } else if (Array.isArray(val)) {
                // Already in correct format
            } else if (typeof val === 'object') {
                this.workingHours[day] = [val];
            } else {
                this.workingHours[day] = null;
            }
        });
    },
    addTimeSlot(day) {
        if (!this.workingHours[day]) {
            this.workingHours[day] = [];
        }
        
        // Find the latest end time among existing slots
        let latestEndTime = '09:00';
        if (this.workingHours[day].length > 0) {
            const sortedSlots = [...this.workingHours[day]].sort((a, b) => {
                const aStartParts = a.start.split(':');
                const bStartParts = b.start.split(':');
                const aStartMinutes = parseInt(aStartParts[0]) * 60 + parseInt(aStartParts[1]);
                const bStartMinutes = parseInt(bStartParts[0]) * 60 + parseInt(bStartParts[1]);
                return aStartMinutes - bStartMinutes;
            });
            
            const lastSlot = sortedSlots[sortedSlots.length - 1];
            if (lastSlot.end) {
                latestEndTime = lastSlot.end;
            }
        }
        
        const latestEndParts = latestEndTime.split(':');
        const latestEndMinutes = parseInt(latestEndParts[0]) * 60 + parseInt(latestEndParts[1]);
        const newStartMinutes = latestEndMinutes + 30;
        const newStartHour = Math.floor(newStartMinutes / 60) % 24;
        const newStartMinute = newStartMinutes % 60;
        const newStartTime = `${String(newStartHour).padStart(2, '0')}:${String(newStartMinute).padStart(2, '0')}`;
        
        const newEndMinutes = newStartMinutes + 8 * 60;
        const newEndHour = Math.floor(newEndMinutes / 60) % 24;
        const newEndMinute = newEndMinutes % 60;
        const newEndTime = `${String(newEndHour).padStart(2, '0')}:${String(newEndMinute).padStart(2, '0')}`;
        
        const newSlot = {start: newStartTime, end: newEndTime};
        this.workingHours[day].push(newSlot);
        this.updateState();
    },
    removeTimeSlot(day, index) {
        if (this.workingHours[day]) {
            this.workingHours[day].splice(index, 1);
            if (this.workingHours[day].length === 0) {
                this.workingHours[day] = null;
            }
            this.updateState();
        }
    },
    toggleDay(day) {
        if (this.workingHours[day] === null) {
            const defaultSlot = {start: '09:00', end: '17:00'};
            this.workingHours[day] = [defaultSlot];
        } else if (this.workingHours[day]) {
            this.workingHours[day] = null;
        } else {
            const defaultSlot = {start: '09:00', end: '17:00'};
            this.workingHours[day] = [defaultSlot];
        }
        this.updateState();
    },
    updateState() {
        $wire.$set('{{ $getStatePath() }}', this.workingHours);
    },
    validateTimeSlot(day, index) {
        if (this.workingHours[day] && this.workingHours[day][index]) {
            const slot = this.workingHours[day][index];
            if (slot.start && slot.end) {
                const startParts = slot.start.split(':');
                const endParts = slot.end.split(':');
                const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
                const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);
                
                if (endMinutes <= startMinutes) {
                    const newEndMinutes = startMinutes + 30;
                    const newEndHour = Math.floor(newEndMinutes / 60) % 24;
                    const newEndMinute = newEndMinutes % 60;
                    slot.end = `${String(newEndHour).padStart(2, '0')}:${String(newEndMinute).padStart(2, '0')}`;
                }
                
                this.validateNoOverlaps(day, index);
            }
        }
        this.updateState();
    },
    isInvalidTimeSlot(slot, day, index) {
        if (slot.start && slot.end) {
            const startParts = slot.start.split(':');
            const endParts = slot.end.split(':');
            const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
            const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);
            
            if (endMinutes <= startMinutes) {
                return true;
            }
        }
        return false;
    },
    validateNoOverlaps(day, currentIndex) {
        const slots = this.workingHours[day];
        if (!slots || slots.length <= 1) return;
        
        const sortedSlots = [...slots].map((slot, index) => ({ ...slot, index }));
        sortedSlots.sort((a, b) => {
            const aStartParts = a.start.split(':');
            const bStartParts = b.start.split(':');
            const aStartMinutes = parseInt(aStartParts[0]) * 60 + parseInt(aStartParts[1]);
            const bStartMinutes = parseInt(bStartParts[0]) * 60 + parseInt(bStartParts[1]);
            return aStartMinutes - bStartMinutes;
        });
        
        for (let i = 0; i < sortedSlots.length - 1; i++) {
            const currentSlot = sortedSlots[i];
            const nextSlot = sortedSlots[i + 1];
            
            const currentEndParts = currentSlot.end.split(':');
            const nextStartParts = nextSlot.start.split(':');
            const currentEndMinutes = parseInt(currentEndParts[0]) * 60 + parseInt(currentEndParts[1]);
            const nextStartMinutes = parseInt(nextStartParts[0]) * 60 + parseInt(nextStartParts[1]);
            
            if (currentEndMinutes > nextStartMinutes) {
                if (nextSlot.index !== currentIndex) {
                    const newStartMinutes = currentEndMinutes + 30;
                    const newStartHour = Math.floor(newStartMinutes / 60) % 24;
                    const newStartMinute = newStartMinutes % 60;
                    slots[nextSlot.index].start = `${String(newStartHour).padStart(2, '0')}:${String(newStartMinute).padStart(2, '0')}`;
                    
                    const newEndParts = slots[nextSlot.index].end.split(':');
                    const newEndMinutes = parseInt(newEndParts[0]) * 60 + parseInt(newEndParts[1]);
                    if (newEndMinutes <= newStartMinutes) {
                        const correctedEndMinutes = newStartMinutes + 30;
                        const correctedEndHour = Math.floor(correctedEndMinutes / 60) % 24;
                        const correctedEndMinute = correctedEndMinutes % 60;
                        slots[nextSlot.index].end = `${String(correctedEndHour).padStart(2, '0')}:${String(correctedEndMinute).padStart(2, '0')}`;
                    }
                } else {
                    const newEndMinutes = nextStartMinutes - 30;
                    if (newEndMinutes > 0) {
                        const newEndHour = Math.floor(newEndMinutes / 60) % 24;
                        const newEndMinute = newEndMinutes % 60;
                        slots[currentSlot.index].end = `${String(newEndHour).padStart(2, '0')}:${String(newEndMinute).padStart(2, '0')}`;
                    }
                }
            }
        }
    },
    getToggleButtonLabel(day) {
        if (this.workingHours[day] && Array.isArray(this.workingHours[day])) {
            return '{{ __('website.close') }}';
        } else {
            return '{{ __('website.open') }}';
        }
    },
    getClosedText() {
        return '{{ __('filament.Closed') }}';
    },
    getNotConfiguredText() {
        return '{{ __('website.not_configured_will_be_closed') }}';
    },
    getAddTimeSlotText() {
        return '{{ __('website.add_time_slot') }}';
    },
    getStartLabelText() {
        return '{{ __('filament.Start Time') }}';
    },
    getEndLabelText() {
        return '{{ __('filament.End Time') }}';
    },
    getToText() {
        return '{{ __('filament.to') }}';
    }
}" 
x-init="init()"
class="space-y-4"
style="margin-bottom: 1rem;">
    <style>
        .whf-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
        .whf-day-card {
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            padding: 1rem;
            background-color: #161617;
        }
        .dark .whf-day-card {
            border-color: rgba(255, 255, 255, 0.1);
        }
        .whf-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .whf-day-name {
            font-weight: 600;
            font-size: 1rem;
        }
        .whf-toggle-btn {
            font-size: 0.875rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .whf-toggle-btn.open {
            background-color: #8B5A2B;
            color: #ffffff;
        }
        .whf-toggle-btn.open:hover {
            background-color: #A67C52;
        }
        .whf-toggle-btn.closed {
            background-color: #6b7280;
            color: #ffffff;
        }
        .whf-toggle-btn.closed:hover {
            background-color: #9ca3af;
        }
        .whf-toggle-btn.not-configured {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .dark .whf-toggle-btn.not-configured {
            background-color: rgba(254, 226, 226, 0.1);
            color: #fca5a5;
        }
        .whf-time-slot {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .whf-time-input {
            flex: 1;
            padding: 0.25rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            background-color: #ffffff;
            color: #1f2937;
        }
        .dark .whf-time-input {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            color: #e5e7eb;
        }
        .whf-time-input optgroup {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .dark .whf-time-input optgroup {
            background-color: #374151;
        }
        .whf-time-input option {
            font-weight: normal;
            padding: 0.1rem 0.25rem;
            background-color: #ffffff;
        }
        .dark .whf-time-input option {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .whf-remove-btn {
            background: none;
            border: none;
            color: #ef4444;
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }
        .whf-remove-btn:hover {
            color: #dc2626;
        }
        .dark .whf-remove-btn {
            color: #f87171;
        }
        .dark .whf-remove-btn:hover {
            color: #ef4444;
        }
        .whf-add-btn {
            background: none;
            border: none;
            color: #8B5A2B;
            font-size: 0.875rem;
            cursor: pointer;
            padding: 0.25rem;
            text-align: left;
            transition: color 0.2s ease;
        }
        .whf-add-btn:hover {
            color: #A67C52;
        }
        .dark .whf-add-btn {
            color: #c99b72;
        }
        .dark .whf-add-btn:hover {
            color: #d4ad85;
        }
        .whf-closed-text, .whf-not-configured-text {
            font-size: 0.875rem;
            color: #6b7280;
        }
        .dark .whf-closed-text, .dark .whf-not-configured-text {
            color: #9ca3af;
        }
        .whf-time-label {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }
        .dark .whf-time-label {
            color: #9ca3af;
        }
        .text-gray-500 {
            color: #6b7280;
        }
        .dark .text-gray-500 {
            color: #9ca3af;
        }
    </style>
    
    <div class="whf-grid">
        <template x-for="day in days" :key="day">
            <div class="whf-day-card">
                <div class="whf-header">
                    <h3 class="whf-day-name" x-text="dayNames[day]"></h3>
                    <button 
                        type="button"
                        @click="toggleDay(day)"
                        class="whf-toggle-btn"
                        :class="(workingHours[day] && Array.isArray(workingHours[day])) ? 'open' : (workingHours[day] === null ? 'closed' : 'not-configured')"
                        x-text="getToggleButtonLabel(day)"
                    ></button>
                </div>
                
                <template x-if="workingHours[day] && Array.isArray(workingHours[day])">
                    <div class="space-y-2">
                        <template x-for="(slot, index) in workingHours[day]" :key="index">
                            <div class="whf-time-slot">
                                <div class="whf-time-select-group">
                                    <label class="whf-time-label" x-text="getStartLabelText()"></label>
                                    <select 
                                        x-model="slot.start"
                                        @change="validateTimeSlot(day, index)"
                                        class="whf-time-input"
                                    >
                                        <?php for ($hour = 0; $hour < 24; $hour++): ?>
                                            <option value="<?= sprintf('%02d:00', $hour) ?>"><?= sprintf('%02d:00', $hour) ?></option>
                                            <option value="<?= sprintf('%02d:30', $hour) ?>"><?= sprintf('%02d:30', $hour) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <span class="text-gray-500" x-text="getToText()"></span>
                                <div class="whf-time-select-group">
                                    <label class="whf-time-label" x-text="getEndLabelText()"></label>
                                    <select 
                                        x-model="slot.end"
                                        @change="validateTimeSlot(day, index)"
                                        class="whf-time-input"
                                        :class="{'border-red-500': isInvalidTimeSlot(slot, day, index)}"
                                    >
                                        <?php for ($hour = 0; $hour < 24; $hour++): ?>
                                            <option value="<?= sprintf('%02d:00', $hour) ?>"><?= sprintf('%02d:00', $hour) ?></option>
                                            <option value="<?= sprintf('%02d:30', $hour) ?>"><?= sprintf('%02d:30', $hour) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <button 
                                    type="button"
                                    @click="removeTimeSlot(day, index)"
                                    class="whf-remove-btn"
                                >
                                    &times;
                                </button>
                            </div>
                        </template>
                        <button 
                            type="button"
                            @click="addTimeSlot(day)"
                            class="whf-add-btn"
                        >
                            + <span x-text="getAddTimeSlotText()"></span>
                        </button>
                    </div>
                </template>
                <template x-if="workingHours[day] === null">
                    <div class="whf-closed-text">
                        <span x-text="getClosedText()"></span>
                    </div>
                </template>
                
                <template x-if="!workingHours[day]">
                    <div class="whf-not-configured-text">
                        <span x-text="getNotConfiguredText()"></span>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>