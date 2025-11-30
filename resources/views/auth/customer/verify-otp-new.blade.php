@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-background-50 to-background-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl border-t-4 border-primary">
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 rounded-full bg-gradient-to-r from-primary-500 to-secondary-600 flex items-center justify-center mb-4 shadow-lg">
                    <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">{{ __('website.verify_otp') }}</h2>
                <p class="mt-2 text-gray-600">{{ __('website.enter_otp_sent_to_your_phone') }}</p>
                <p class="mt-1 text-sm text-primary-600 font-medium">{{ $tempCustomer->phone }}</p>
            </div>
            
            <form class="mt-6 space-y-6" method="POST" action="{{ route('customer.verify-otp') }}">
                @csrf
                
                <input type="hidden" name="phone" value="{{ $tempCustomer->phone }}">
                <input type="hidden" name="is_new_customer" value="1">
                
                <div class="space-y-4">
                    @if(!isset($hasName) || !$hasName)
                    {{-- Show name field only if coming from login (name not provided yet) --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('website.full_name') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="name" name="name" type="text" required class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror transition duration-200" placeholder="{{ __('website.full_name_placeholder') }}" value="{{ old('name', $tempCustomer->name) }}" autocomplete="name">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @else
                    {{-- Hide name field if coming from registration (name already provided) --}}
                    <input type="hidden" name="name" value="{{ $tempCustomer->name }}">
                    @endif
                    
                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">{{ __('website.otp_code') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="otp" name="otp" type="text" maxlength="6" required class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('otp') border-red-500 @enderror transition duration-200" placeholder="{{ __('website.enter_6_digit_code') }}" autocomplete="one-time-code">
                        </div>
                        @error('otp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5">
                        {{ __('website.verify_and_login') }}
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __('website.didnt_receive_code') }}
                    <a href="{{ route('customer.login') }}" class="font-medium text-primary-600 hover:text-primary-500 transition-colors duration-200">{{ __('website.resend_otp') }}</a>
                </p>
            </div>
        </div>
        
        <div class="text-center text-sm text-gray-500 mt-4">
            <p>&copy; {{ date('Y') }} Bookify. {{ __('website.all_rights_reserved') }}</p>
        </div>
    </div>
</div>
@endsection