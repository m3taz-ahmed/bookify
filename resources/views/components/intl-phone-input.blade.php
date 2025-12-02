@props(['name' => 'phone', 'id' => 'phone', 'value' => '', 'required' => true, 'error' => null])

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ __('website.phone_number') }}
    </label>
    
    <div class="relative">
        <!-- Hidden input for country code -->
        <input type="hidden" id="{{ $id }}_country_code" name="country_code" value="">
        
        <!-- Hidden input for full international number -->
        <input type="hidden" id="{{ $id }}_full" name="{{ $name }}" value="{{ $value }}">
        
        <!-- Visible phone input -->
        <input 
            type="tel" 
            id="{{ $id }}" 
            class="w-full pl-16 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @if($error) border-red-500 @endif transition duration-200" 
            placeholder="{{ __('website.phone_placeholder') }}"
            {{ $required ? 'required' : '' }}
            autocomplete="tel"
        >
    </div>
    
    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>

<style>
    /* International Telephone Input Styles */
    .iti {
        width: 100%;
        position: relative;
    }
    
    .iti__flag-container {
        position: absolute;
        top: 0;
        bottom: 0;
        right: auto;
        left: 0;
        padding: 1px;
    }
    
    .iti__selected-flag {
        z-index: 1;
        position: relative;
        display: flex;
        align-items: center;
        height: 100%;
        padding: 0 12px;
        border-right: 1px solid #d1d5db;
        background-color: #f9fafb;
        border-radius: 0.5rem 0 0 0.5rem;
        transition: background-color 0.2s;
    }
    
    .iti__selected-flag:hover {
        background-color: #f3f4f6;
    }
    
    .iti__country-list {
        position: absolute;
        z-index: 2;
        list-style: none;
        text-align: left;
        padding: 0;
        margin: 0 0 0 -1px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        background-color: white;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        max-height: 200px;
        overflow-y: scroll;
        width: 300px;
        margin-top: 4px;
    }
    
    .iti__country {
        padding: 8px 12px;
        cursor: pointer;
        transition: background-color 0.15s;
    }
    
    .iti__country:hover {
        background-color: #f3f4f6;
    }
    
    .iti__country.iti__highlight {
        background-color: #eff6ff;
    }
    
    .iti__country.iti__active {
        background-color: #dbeafe;
    }
    
    .iti__flag-box {
        display: inline-block;
        width: 20px;
        margin-right: 8px;
    }
    
    .iti__country-name {
        margin-right: 6px;
        color: #374151;
    }
    
    .iti__dial-code {
        color: #6b7280;
    }
    
    .iti__arrow {
        margin-left: 6px;
        width: 0;
        height: 0;
        border-left: 3px solid transparent;
        border-right: 3px solid transparent;
        border-top: 4px solid #6b7280;
    }
    
    .iti__arrow--up {
        border-top: none;
        border-bottom: 4px solid #6b7280;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.querySelector("#{{ $id }}");
        const hiddenInput = document.querySelector("#{{ $id }}_full");
        const countryCodeInput = document.querySelector("#{{ $id }}_country_code");
        
        if (!input) return;
        
        // Initialize intl-tel-input
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch('https://ipapi.co/json/')
                    .then(response => response.json())
                    .then(data => {
                        const countryCode = (data && data.country_code) ? data.country_code : "sa";
                        callback(countryCode.toLowerCase());
                    })
                    .catch(() => {
                        callback("sa"); // Default to Saudi Arabia
                    });
            },
            preferredCountries: ["sa", "eg", "ae", "kw", "bh", "om", "qa"],
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js",
            formatOnDisplay: true,
            nationalMode: false,
            autoPlaceholder: "polite",
            placeholderNumberType: "MOBILE",
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                return selectedCountryPlaceholder;
            }
        });
        
        // Set initial value if provided
        @if($value)
            iti.setNumber("{{ $value }}");
        @endif
        
        // Update hidden inputs on change
        function updateHiddenInputs() {
            const fullNumber = iti.getNumber();
            const countryData = iti.getSelectedCountryData();
            
            hiddenInput.value = fullNumber.replace(/\+/g, ''); // Remove + sign
            countryCodeInput.value = countryData.dialCode;
            
            console.log('Phone updated:', {
                full: hiddenInput.value,
                countryCode: countryCodeInput.value
            });
        }
        
        // Listen for changes
        input.addEventListener('blur', updateHiddenInputs);
        input.addEventListener('change', updateHiddenInputs);
        input.addEventListener('countrychange', updateHiddenInputs);
        
        // Update on page load if there's a value
        if (input.value) {
            updateHiddenInputs();
        }
        
        // Validate on form submit
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                updateHiddenInputs();
                
                if (!iti.isValidNumber()) {
                    e.preventDefault();
                    alert('{{ __("website.invalid_phone_number") }}');
                    input.focus();
                    return false;
                }
            });
        }
    });
</script>
