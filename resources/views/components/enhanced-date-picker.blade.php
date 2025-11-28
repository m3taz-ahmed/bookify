<div class="enhanced-date-picker" 
     x-data="enhancedDatePicker({
        selectedDate: '{{ $value ?? '' }}',
        minDate: '{{ date('Y-m-d') }}',
        maxDate: '{{ date('Y-m-d', strtotime('+3 months')) }}',
        dateAvailability: {{ json_encode($dateAvailability ?? []) }}
    })"
     x-init="init()">
    <div class="relative">
        <input 
            type="text" 
            x-model="displayDate"
            @click="showCalendar = true"
            readonly
            placeholder="{{ __('website.select_date') }}"
            class="w-full pl-4 pr-10 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 bg-white shadow-sm hover:shadow-md cursor-pointer">
        
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
            </svg>
        </div>
        
        <div x-show="showCalendar" 
             @click.away="showCalendar = false"
             class="absolute z-50 mt-2 bg-white rounded-xl shadow-xl border border-gray-200 p-4 w-80">
            <div class="flex justify-between items-center mb-4">
                <button @click="previousMonth()" class="p-2 rounded-full hover:bg-gray-100">
                    <svg class="h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
                
                <div class="font-semibold text-gray-800">
                    <span x-text="formatMonthYear(currentMonth, currentYear)"></span>
                </div>
                
                <button @click="nextMonth()" class="p-2 rounded-full hover:bg-gray-100">
                    <svg class="h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            
            <div class="grid grid-cols-7 gap-1 mb-2">
                <template x-for="day in ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']" :key="day">
                    <div class="text-center text-xs font-medium text-gray-500 py-1" x-text="day"></div>
                </template>
            </div>
            
            <div class="grid grid-cols-7 gap-1">
                <template x-for="day in emptyDays" :key="day">
                    <div class="h-10"></div>
                </template>
                
                <template x-for="day in daysInMonth" :key="day">
                    <div>
                        <button 
                            @click="selectDate(day)"
                            :class="getDateClass(day)"
                            class="w-10 h-10 rounded-full text-sm flex items-center justify-center transition-all duration-200"
                            x-text="day">
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
    
    <input type="hidden" name="{{ $name ?? 'selectedDate' }}" x-model="selectedDate">
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('enhancedDatePicker', (config) => ({
        selectedDate: config.selectedDate,
        minDate: new Date(config.minDate),
        maxDate: new Date(config.maxDate),
        dateAvailability: config.dateAvailability || {},
        showCalendar: false,
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        
        init() {
            if (this.selectedDate) {
                const date = new Date(this.selectedDate);
                this.currentMonth = date.getMonth();
                this.currentYear = date.getFullYear();
            }
        },
        
        get displayDate() {
            if (!this.selectedDate) return '';
            const date = new Date(this.selectedDate);
            return date.toLocaleDateString();
        },
        
        get daysInMonth() {
            return new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
        },
        
        get emptyDays() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1).getDay();
            return Array.from({ length: firstDay }, (_, i) => i);
        },
        
        formatMonthYear(month, year) {
            const date = new Date(year, month, 1);
            return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        },
        
        previousMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },
        
        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
        },
        
        selectDate(day) {
            const date = new Date(this.currentYear, this.currentMonth, day);
            if (date >= this.minDate && date <= this.maxDate) {
                this.selectedDate = date.toISOString().split('T')[0];
                this.showCalendar = false;
                
                // Dispatch a custom event so Livewire can catch it
                this.$el.dispatchEvent(new CustomEvent('date-selected', {
                    bubbles: true,
                    detail: { date: this.selectedDate }
                }));
            }
        },
        
        getDateClass(day) {
            const date = new Date(this.currentYear, this.currentMonth, day);
            const dateStr = date.toISOString().split('T')[0];
            
            // Check if it's today
            const today = new Date();
            const isToday = date.toDateString() === today.toDateString();
            
            // Check if it's selected
            const isSelected = this.selectedDate === dateStr;
            
            // Check date status from backend data
            let dateStatus = 'available';
            if (this.dateAvailability && this.dateAvailability[dateStr]) {
                dateStatus = this.dateAvailability[dateStr];
            }
            
            let classes = 'w-10 h-10 rounded-full text-sm flex items-center justify-center transition-all duration-200 ';
            
            if (isSelected) {
                classes += 'bg-primary-500 text-white font-bold ';
            } else if (isToday) {
                classes += 'bg-blue-100 text-blue-800 font-medium ';
            } else if (dateStatus === 'non-working') {
                classes += 'text-gray-400 cursor-not-allowed bg-gray-100 ';
            } else if (dateStatus === 'fully-booked') {
                classes += 'text-red-500 line-through cursor-not-allowed bg-red-50 ';
            } else {
                classes += 'text-gray-700 hover:bg-primary-100 cursor-pointer ';
            }
            
            // Disable non-working and fully booked days
            if (dateStatus === 'non-working' || dateStatus === 'fully-booked') {
                classes += 'cursor-not-allowed ';
            } else {
                classes += 'cursor-pointer ';
            }
            
            return classes;
        }
    }));
});
</script>