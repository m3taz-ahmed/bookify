@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center">
        <h1 class="text-3xl font-bold text-dark-900 mb-8">Language Test Page</h1>
        
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-dark-800 mb-4">Current Locale: {{ app()->getLocale() }}</h2>
            
            <div class="mb-6">
                <h3 class="text-lg font-medium text-dark-700 mb-2">Translated Content:</h3>
                <p class="text-dark-600">{{ __('website.welcome') }}</p>
                <p class="text-dark-600">{{ __('website.tagline') }}</p>
                <p class="text-dark-600">{{ __('website.features') }}</p>
            </div>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ route('lang.switch', 'ar') }}" 
                   class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors">
                    Switch to Arabic
                </a>
                <a href="{{ route('lang.switch', 'en') }}" 
                   class="px-4 py-2 bg-secondary-600 text-white rounded-md hover:bg-secondary-700 transition-colors">
                    Switch to English
                </a>
            </div>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-medium text-dark-700 mb-2">Available Translations:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                <div>
                    <h4 class="font-medium text-dark-600">Arabic (ar):</h4>
                    <p>مرحبا بكم في Bookify</p>
                    <p>احجز موعدك اليوم</p>
                    <p>الميزات</p>
                </div>
                <div>
                    <h4 class="font-medium text-dark-600">English (en):</h4>
                    <p>Welcome to Bookify</p>
                    <p>Book Your Appointment Today</p>
                    <p>Features</p>
                </div>
            </div>
        </div>
        
        <div class="mt-8 bg-yellow-50 rounded-lg p-6 text-left">
            <h3 class="text-lg font-medium text-dark-700 mb-2">Debug Information:</h3>
            <ul class="list-disc pl-5 space-y-1">
                <li>App Locale: {{ app()->getLocale() }}</li>
                <li>Session Locale: {{ session('locale') }}</li>
                <li>Config Locale: {{ config('app.locale') }}</li>
                <li>Fallback Locale: {{ config('app.fallback_locale') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection