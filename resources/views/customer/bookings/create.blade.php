@extends('layouts.app')

@section('breadcrumbs')
<li>
    <div class="flex items-center">
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <a href="{{ route('customer.bookings') }}" class="ml-1 text-sm font-medium text-primary-700 hover:text-primary-900 md:ml-2 dark:text-primary-400 dark:hover:text-white">{{ __('website.my_bookings') }}</a>
    </div>
</li>
<li>
    <div class="flex items-center">
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <a href="{{ route('customer.bookings.create') }}" class="ml-1 text-sm font-medium text-primary-700 hover:text-primary-900 md:ml-2 dark:text-primary-400 dark:hover:text-white">{{ __('website.book_new_appointment') }}</a>
    </div>
</li>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white dark:bg-dark-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl border-t-4 border-primary">
        <div class="px-8 py-6 border-b border-gray-200 dark:border-dark-700 bg-gradient-to-r from-background-50 to-accent-50 dark:from-dark-700 dark:to-dark-600">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('website.book_new_appointment') }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('website.follow_steps_below') }}</p>
                </div>
                <!-- <div class="hidden md:block">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">1</div>
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">2</div>
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">3</div>
                        <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold">4</div>
                    </div>
                </div> -->
            </div>
        </div>
        
        <div class="px-6 py-8">
            @livewire('create-booking')
        </div>
    </div>
    
    <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
        <p>{{ __('website.need_help_contact_support', ['email' => 'support@skybridge.com']) }}</p>
    </div>
</div>
@endsection