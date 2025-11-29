<div x-data="{
    workingHours: {{ Illuminate\Support\Js::from($getState() ?: []) }},
    days: ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
    dayNames: {
        'sunday': 'Sunday',
        'monday': 'Monday', 
        'tuesday': 'Tuesday',
        'wednesday': 'Wednesday',
        'thursday': 'Thursday',
        'friday': 'Friday',
        'saturday': 'Saturday'
    },
    init() {
        console.log('Initial workingHours:', this.workingHours);
        console.log('Type of workingHours:', typeof this.workingHours);
        // Ensure workingHours is always an object
        if (!this.workingHours || typeof this.workingHours !== 'object') {
            this.workingHours = {};
        }
        
        // Ensure each day has proper data structure
        this.days.forEach(day => {
            if (this.workingHours[day] !== undefined && this.workingHours[day] !== null) {
                // Handle boolean false as closed day
                if (this.workingHours[day] === false) {
                    this.workingHours[day] = null;
                } 
                // Handle single object by converting to array
                else if (typeof this.workingHours[day] === 'object' && !Array.isArray(this.workingHours[day])) {
                    this.workingHours[day] = [this.workingHours[day]];
                }
                // Handle string data (might be JSON)
                else if (typeof this.workingHours[day] === 'string') {
                    try {
                        const parsed = JSON.parse(this.workingHours[day]);
                        if (Array.isArray(parsed)) {
                            this.workingHours[day] = parsed;
                        } else if (parsed === null) {
                            this.workingHours[day] = null;
                        } else {
                            this.workingHours[day] = null;
                        }
                    } catch (e) {
                        this.workingHours[day] = null;
                    }
                }
            }
        });
        
        // Make sure all days are initialized
        this.days.forEach(day => {
            if (this.workingHours[day] === undefined) {
                this.workingHours[day] = null;
            }
        });
        
        console.log('Processed workingHours:', this.workingHours);
    },
    addTimeSlot(day) {
        if (!this.workingHours[day]) {
            this.workingHours[day] = [];
        }
        
        // Find the latest end time among existing slots
        let latestEndTime = '09:00'; // Default start time
        if (this.workingHours[day].length > 0) {
            // Sort existing slots by start time
            const sortedSlots = [...this.workingHours[day]].sort((a, b) => {
                const aStartParts = a.start.split(':');
                const bStartParts = b.start.split(':');
                const aStartMinutes = parseInt(aStartParts[0]) * 60 + parseInt(aStartParts[1]);
                const bStartMinutes = parseInt(bStartParts[0]) * 60 + parseInt(bStartParts[1]);
                return aStartMinutes - bStartMinutes;
            });
            
            // Get the end time of the last slot
            const lastSlot = sortedSlots[sortedSlots.length - 1];
            if (lastSlot.end) {
                latestEndTime = lastSlot.end;
            }
        }
        
        // Calculate new start time (30 minutes after latest end time)
        const latestEndParts = latestEndTime.split(':');
        const latestEndMinutes = parseInt(latestEndParts[0]) * 60 + parseInt(latestEndParts[1]);
        const newStartMinutes = latestEndMinutes + 30;
        const newStartHour = Math.floor(newStartMinutes / 60) % 24;
        const newStartMinute = newStartMinutes % 60;
        const newStartTime = `${String(newStartHour).padStart(2, '0')}:${String(newStartMinute).padStart(2, '0')}`;
        
        // Calculate new end time (8 hours after start time)
        const newEndMinutes = newStartMinutes + 8 * 60; // 8 hours
        const newEndHour = Math.floor(newEndMinutes / 60) % 24;
        const newEndMinute = newEndMinutes % 60;
        const newEndTime = `${String(newEndHour).padStart(2, '0')}:${String(newEndMinute).padStart(2, '0')}`;
        
        // Add a new time slot with valid times
        const newSlot = {start: newStartTime, end: newEndTime};
        this.workingHours[day].push(newSlot);
        this.updateState();
    },
    removeTimeSlot(day, index) {
        if (this.workingHours[day]) {
            this.workingHours[day].splice(index, 1);
            if (this.workingHours[day].length === 0) {
                delete this.workingHours[day];
            }
            this.updateState();
        }
    },
    toggleDay(day) {
        if (this.workingHours[day] === null) {
            // Currently closed, open with default slot
            const defaultSlot = {start: '09:00', end: '17:00'};
            this.workingHours[day] = [defaultSlot];
        } else if (this.workingHours[day]) {
            // Currently open, close it
            this.workingHours[day] = null;
        } else {
            // Not set, open with default slot
            const defaultSlot = {start: '09:00', end: '17:00'};
            this.workingHours[day] = [defaultSlot];
        }
        this.updateState();
    },
    updateState() {
        $wire.$set('{{ $getStatePath() }}', this.workingHours);
    },
    // Validate that end time is not smaller than start time and no overlapping time slots
    validateTimeSlot(day, index) {
        if (this.workingHours[day] && this.workingHours[day][index]) {
            const slot = this.workingHours[day][index];
            if (slot.start && slot.end) {
                // Convert time strings to minutes for comparison
                const startParts = slot.start.split(':');
                const endParts = slot.end.split(':');
                const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
                const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);
                
                // If end time is smaller than start time, auto-correct it
                if (endMinutes <= startMinutes) {
                    // Set end time to 30 minutes after start time
                    const newEndMinutes = startMinutes + 30;
                    const newEndHour = Math.floor(newEndMinutes / 60) % 24;
                    const newEndMinute = newEndMinutes % 60;
                    slot.end = `${String(newEndHour).padStart(2, '0')}:${String(newEndMinute).padStart(2, '0')}`;
                }
                
                // Check for overlapping time slots
                this.validateNoOverlaps(day, index);
            }
        }
        this.updateState();
    },
    // Check if a time slot is invalid (end time smaller than start time or overlapping)
    isInvalidTimeSlot(slot, day, index) {
        if (slot.start && slot.end) {
            // Convert time strings to minutes for comparison
            const startParts = slot.start.split(':');
            const endParts = slot.end.split(':');
            const startMinutes = parseInt(startParts[0]) * 60 + parseInt(startParts[1]);
            const endMinutes = parseInt(endParts[0]) * 60 + parseInt(endParts[1]);
            
            // Check if end time is smaller than or equal to start time
            if (endMinutes <= startMinutes) {
                return true;
            }
            
            // Check for overlaps with other slots in the same day
            // This is just for visual indication, actual validation happens on change
        }
        return false;
    },
    // Validate that time slots don't overlap
    validateNoOverlaps(day, currentIndex) {
        const slots = this.workingHours[day];
        if (!slots || slots.length <= 1) return;
        
        // Sort slots by start time
        const sortedSlots = [...slots].map((slot, index) => ({ ...slot, index }));
        sortedSlots.sort((a, b) => {
            const aStartParts = a.start.split(':');
            const bStartParts = b.start.split(':');
            const aStartMinutes = parseInt(aStartParts[0]) * 60 + parseInt(aStartParts[1]);
            const bStartMinutes = parseInt(bStartParts[0]) * 60 + parseInt(bStartParts[1]);
            return aStartMinutes - bStartMinutes;
        });
        
        // Check for overlaps
        for (let i = 0; i < sortedSlots.length - 1; i++) {
            const currentSlot = sortedSlots[i];
            const nextSlot = sortedSlots[i + 1];
            
            const currentEndParts = currentSlot.end.split(':');
            const nextStartParts = nextSlot.start.split(':');
            const currentEndMinutes = parseInt(currentEndParts[0]) * 60 + parseInt(currentEndParts[1]);
            const nextStartMinutes = parseInt(nextStartParts[0]) * 60 + parseInt(nextStartParts[1]);
            
            // If current slot ends after next slot starts, there's an overlap
            if (currentEndMinutes > nextStartMinutes) {
                // Auto-correct by moving the next slot to start after the current slot ends
                if (nextSlot.index !== currentIndex) {
                    // Only auto-correct the other slot, not the one being edited
                    const newStartMinutes = currentEndMinutes + 30; // 30 minutes gap
                    const newStartHour = Math.floor(newStartMinutes / 60) % 24;
                    const newStartMinute = newStartMinutes % 60;
                    slots[nextSlot.index].start = `${String(newStartHour).padStart(2, '0')}:${String(newStartMinute).padStart(2, '0')}`;
                    
                    // Also ensure the end time is valid
                    const newEndParts = slots[nextSlot.index].end.split(':');
                    const newEndMinutes = parseInt(newEndParts[0]) * 60 + parseInt(newEndParts[1]);
                    if (newEndMinutes <= newStartMinutes) {
                        const correctedEndMinutes = newStartMinutes + 30;
                        const correctedEndHour = Math.floor(correctedEndMinutes / 60) % 24;
                        const correctedEndMinute = correctedEndMinutes % 60;
                        slots[nextSlot.index].end = `${String(correctedEndHour).padStart(2, '0')}:${String(correctedEndMinute).padStart(2, '0')}`;
                    }
                } else {
                    // Auto-correct the current slot being edited
                    const newEndMinutes = nextStartMinutes - 30; // 30 minutes gap
                    if (newEndMinutes > 0) { // Only adjust if it makes sense
                        const newEndHour = Math.floor(newEndMinutes / 60) % 24;
                        const newEndMinute = newEndMinutes % 60;
                        slots[currentSlot.index].end = `${String(newEndHour).padStart(2, '0')}:${String(newEndMinute).padStart(2, '0')}`;
                    }
                }
            }
        }
    },
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
    }
    .whf-toggle-btn.open {
        background-color: #C36100;
        color: #ffffff;
    }
    .whf-toggle-btn.closed {
        background-color: #C36100;
        color: #1f2937;
    }
    .whf-toggle-btn.not-configured {
        background-color: #fee2e2;
        color: #991b1b;
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
        /* background-color: white; */
    }
    .whf-time-input optgroup {
        font-weight: bold;
        background-color: #f5f5f5;
    }
    .whf-time-input option {
        font-weight: normal;
        padding: 0.1rem 0.25rem;
        background-color:rgb(41, 41, 41);
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
    }
    .whf-add-btn {
        background: none;
        border: none;
        color: #3b82f6;
        font-size: 0.875rem;
        cursor: pointer;
        padding: 0.25rem;
        text-align: left;
    }
    .whf-closed-text, .whf-not-configured-text {
        font-size: 0.875rem;
        /* font-style: italic; */
        color: #6b7280;
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
                        x-text="(workingHours[day] && Array.isArray(workingHours[day])) ? 'Close' : (workingHours[day] === null ? 'Open' : 'Open')"
                    ></button>
                </div>
                
                <template x-if="workingHours[day] && Array.isArray(workingHours[day])">
                    <div class="space-y-2">
                        <template x-for="(slot, index) in workingHours[day]" :key="index">
                            <div class="whf-time-slot">
                                <div class="whf-time-select-group">
                                    <label class="whf-time-label">Start</label>
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
                                <span class="text-gray-500">to</span>
                                <div class="whf-time-select-group">
                                    <label class="whf-time-label">End</label>
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
                            + Add time slot
                        </button>
                    </div>
                </template>
                <template x-if="workingHours[day] === null">
                    <div class="whf-closed-text">
                        Closed
                    </div>
                </template>
                
                <template x-if="!workingHours[day]">
                    <div class="whf-not-configured-text">
                        Not configured (will be closed)
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>