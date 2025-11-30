@extends('layouts.app')

@section('content')
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
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">{{ __('website.phone_number') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <input id="phone" name="phone" type="tel" required class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror transition duration-200" placeholder="{{ __('website.phone_placeholder') }}" value="{{ old('phone') }}" autocomplete="tel">
                        </div>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Format Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="font-medium mb-1">Phone Number Format:</h3>
                                <ul class="list-disc list-inside space-y-1 text-blue-700">
                                    <li>
                                        <span class="font-medium">Saudi Arabia (KSA):</span> 
                                        Start with <code class="bg-blue-100 px-1 rounded">05</code> or <code class="bg-blue-100 px-1 rounded">5</code> 
                                        <br><span class="text-xs opacity-75 ml-4">(e.g., 0512345678)</span>
                                    </li>
                                    <li>
                                        <span class="font-medium">International:</span> 
                                        Enter full number with country code
                                        <br><span class="text-xs opacity-75 ml-4">(e.g., 201001234567 for Egypt)</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
@endsection