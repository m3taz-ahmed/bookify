<div class="custom-date-picker">
    <input type="date" 
           wire:model.live="selectedDate" 
           min="{{ $minDate }}"
           max="{{ $maxDate }}"
           class="w-full pl-4 pr-10 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-300 bg-white shadow-sm hover:shadow-md">
    
    <style>
        /* Style for non-working days */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.5) sepia(1) saturate(5) hue-rotate(180deg);
        }
        
        /* Custom styles for the date picker */
        input[type="date"] {
            position: relative;
        }
        
        /* We'll add JavaScript to customize the calendar */
    </style>
    
    <script>
        document.addEventListener('livewire:load', function () {
            // This would be enhanced with more JavaScript to customize the calendar
            // For now, we're using the native date picker with some styling
        });
    </script>
</div>