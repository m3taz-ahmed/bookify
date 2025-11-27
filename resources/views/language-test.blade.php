@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-dark-900 mb-6">{{ __('website.language_test_page') }}</h1>
        
        <div class="mb-8">
            <p class="text-lg text-dark-700 mb-4">
                {{ __('website.current_language') }}: <span class="font-bold">{{ app()->getLocale() }}</span>
            </p>
            
            <p class="text-lg text-dark-700 mb-4">
                {{ __('website.session_language') }}: <span class="font-bold">{{ session('locale', 'not set') }}</span>
            </p>
        </div>
        
        <div class="flex space-x-4">
            <a href="{{ route('lang.switch', ['locale' => 'en']) }}" 
               class="px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200">
                {{ __('website.switch_to_english') }}
            </a>
            
            <a href="{{ route('lang.switch', ['locale' => 'ar']) }}" 
               class="px-6 py-3 bg-secondary-600 text-white font-medium rounded-lg hover:bg-secondary-700 transition-colors duration-200">
                {{ __('website.switch_to_arabic') }}
            </a>
        </div>
        
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-dark-900 mb-4">{{ __('website.test_translations') }}</h2>
            <ul class="space-y-2">
                <li class="text-dark-700">{{ __('website.welcome') }}</li>
                <li class="text-dark-700">{{ __('website.tagline') }}</li>
                <li class="text-dark-700">{{ __('website.our_platform') }}</li>
                <li class="text-dark-700">{{ __('website.book_appointment') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection