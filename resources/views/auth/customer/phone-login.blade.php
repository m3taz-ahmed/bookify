@extends('layouts.app')

@section('content')
<!-- Include intl-tel-input CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/css/intlTelInput.css">

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-background-50 to-background-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl border-t-4 border-primary">
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 rounded-full bg-gradient-to-r from-primary-500 to-secondary-600 flex items-center justify-center mb-4 shadow-lg">
                    <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">{{ __('website.login') }}</h2>
                <p class="mt-2 text-gray-600">{{ __('website.enter_your_phone_to_receive_otp') }}</p>
            </div>
            
            <form class="mt-6 space-y-6" method="POST" action="{{ route('customer.login.attempt') }}">
                @csrf
                
                <div class="space-y-4">
                    <x-intl-phone-input 
                        name="phone" 
                        id="phone" 
                        :value="old('phone')" 
                        :required="true"
                        :error="$errors->first('phone')"
                    />
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5">
                        {{ __('website.send_otp') }}
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">{{ __('website.dont_have_account') }} 
                    <a href="{{ route('customer.register') }}" class="font-medium text-primary-600 hover:text-primary-500 transition-colors duration-200">{{ __('website.register_here') }}</a>
                </p>
            </div>
        </div>
        
        <div class="text-center text-sm text-gray-500 mt-4">
            <p>&copy; {{ date('Y') }} Bookify. {{ __('website.all_rights_reserved') }}</p>
        </div>
    </div>
</div>

<!-- Include intl-tel-input JS -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/intlTelInput.min.js"></script>
@endsection