@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-dark-900 mb-6">Language Switcher Test</h1>
        
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-dark-800 mb-4">Current Language Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-background-50 p-4 rounded-lg">
                    <p class="text-sm text-dark-500">App Locale</p>
                    <p class="text-lg font-medium">{{ app()->getLocale() }}</p>
                </div>
                <div class="bg-background-50 p-4 rounded-lg">
                    <p class="text-sm text-dark-500">Session Locale</p>
                    <p class="text-lg font-medium">{{ session('locale', 'Not set') }}</p>
                </div>
            </div>
        </div>
        
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-dark-800 mb-4">Generated URLs</h2>
            <div class="bg-background-50 p-6 rounded-lg">
                <p class="mb-2"><strong>English Switch URL:</strong> {{ route('lang.switch', ['locale' => 'en']) }}</p>
                <p class="mb-2"><strong>Arabic Switch URL:</strong> {{ route('lang.switch', ['locale' => 'ar']) }}</p>
                <p class="mb-2"><strong>Current URL:</strong> {{ url()->current() }}</p>
                <p class="mb-2"><strong>Previous URL:</strong> {{ url()->previous() }}</p>
            </div>
        </div>
        
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-dark-800 mb-4">Test Language Switching</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('lang.switch', ['locale' => 'en']) }}" 
                   class="px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200">
                    Switch to English
                </a>
                <a href="{{ route('lang.switch', ['locale' => 'ar']) }}" 
                   class="px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200">
                    Switch to Arabic
                </a>
            </div>
        </div>
        
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-dark-800 mb-4">Test Translations</h2>
            <div class="bg-background-50 p-6 rounded-lg">
                <p class="mb-2"><strong>Welcome:</strong> {{ __('website.welcome') }}</p>
                <p class="mb-2"><strong>Tagline:</strong> {{ __('website.tagline') }}</p>
                <p class="mb-2"><strong>About:</strong> {{ __('website.about') }}</p>
                <p class="mb-2"><strong>Contact Us:</strong> {{ __('website.contact_us') }}</p>
            </div>
        </div>
        
        <div>
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-secondary-600 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection