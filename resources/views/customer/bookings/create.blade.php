@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl border-t-4 border-primary">
        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-background-50 to-accent-50">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ __('website.book_new_appointment') }}</h1>
                    <p class="text-gray-600 mt-2">{{ __('website.follow_steps_below') }}</p>
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
    
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>{{ __('website.need_help_contact_support', ['email' => 'support@skybridge.com']) }}</p>
    </div>
</div>
@endsection