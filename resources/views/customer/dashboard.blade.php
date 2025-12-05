@extends('layouts.app')

@section('breadcrumbs')
<li>
    <div class="flex items-center">
        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <a href="{{ route('customer.dashboard') }}" class="ml-1 text-sm font-medium text-primary-700 hover:text-primary-900 md:ml-2 dark:text-primary-400 dark:hover:text-white">{{ __('website.dashboard') }}</a>
    </div>
</li>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl font-bold mb-2">{{ __('website.welcome_back') }}, {{ auth()->guard('customer')->user()->name }}!</h1>
                    <p class="text-light-100 max-w-2xl">{{ __('website.manage_your_appointments') }}</p>
                </div>
                <div class="bg-opacity-20 rounded-xl p-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold">{{ \App\Models\Booking::where('customer_id', auth()->guard('customer')->id())->count() }}</div>
                        <div class="text-sm text-light-100">{{ __('website.total_bookings') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('customer.bookings.create') }}" class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-accent-200">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ __('website.book_appointment') }}</h3>
                </div>
                <p class="text-gray-600 mb-4">{{ __('website.schedule_new_service') }}</p>
                <span class="inline-flex items-center text-primary-600 font-medium">
                    {{ __('website.book_now') }}
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>

            <a href="{{ route('customer.bookings') }}" class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-accent-200">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-accent-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-accent-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ __('website.my_bookings') }}</h3>
                </div>
                <p class="text-gray-600 mb-4">{{ __('website.view_manage_upcoming_appointments') }}</p>
                <span class="inline-flex items-center text-accent-600 font-medium">
                    {{ __('website.view_all') }}
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>

            <a href="{{ route('customer.profile.edit') }}" class="bg-white rounded-2xl shadow-md p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-accent-200">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-accent-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-secondary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ __('website.profile') }}</h3>
                </div>
                <span class="inline-flex items-center text-accent-600 font-medium">
                    {{ __('website.update_personal_info') }}
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Upcoming Appointments -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-accent-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('website.upcoming_appointments') }}</h2>
                    <a href="{{ route('customer.bookings') }}" class="text-primary-600 hover:text-primary-800 font-medium text-sm">{{ __('website.view_all') }}</a>
                </div>
                
                @php
                    $upcomingBookings = \App\Models\Booking::where('customer_id', auth()->guard('customer')->id())
                        ->where('booking_date', '>=', date('Y-m-d'))
                        ->where('status', '!=', 'cancelled')
                        ->orderBy('booking_date')
                        ->orderBy('start_time')
                        ->limit(5)
                        ->get();
                @endphp
                
                @if($upcomingBookings->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingBookings as $booking)
                            <div class="border border-gray-200 rounded-xl hover:shadow-md transition-all duration-200 overflow-hidden">
                                <div class="py-2 px-5 bg-gradient-to-r from-primary-50 to-secondary-50">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4">
                                            <!-- <div class="h-14 w-14 rounded-full bg-white shadow-sm flex items-center justify-center flex-shrink-0">
                                                <svg class="h-7 w-7 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div> -->
                                            <div class="flex-1">
                                                <div class="font-bold text-lg text-gray-900 mb-1 flex flex-wrap gap-3">
                                                    <div class="flex items-center text-gray-700">
                                                        <svg class="h-5 w-5 mr-1.5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->timezone('Asia/Riyadh')->translatedFormat('l, F j, Y') }}</span>
                                                    </div>
                                                    <div class="flex items-center text-gray-700">
                                                        <svg class="h-5 w-5 mr-1.5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->start_time)->timezone('Asia/Riyadh')->format('g:i A') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $booking->status_badge_class }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="py-3 px-5 bg-white">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">{{ __('website.reference') }}</p>
                                                <p class="text-sm font-bold text-gray-900">{{ $booking->reference_code }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <div class="h-10 w-10 rounded-lg bg-purple-50 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">{{ __('website.people') }}</p>
                                                <p class="text-sm font-bold text-gray-900">{{ $booking->number_of_people }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <div class="h-10 w-10 rounded-lg bg-green-50 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">{{ __('website.payment') }}</p>
                                                <p class="text-sm font-bold text-gray-900">{{ ucfirst($booking->payment_method) }}</p>
                                            </div>
                                        </div>
                                        
                                        @php
                                            $totalPrice = $booking->items->sum('total_price');
                                        @endphp
                                        <div class="flex items-center space-x-2">
                                            <div class="h-10 w-10 rounded-lg bg-amber-50 flex items-center justify-center">
                                                <x-sar-icon class="h-5 w-5 text-amber-600" />
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-500">{{ __('website.total_price') }}</p>
                                                <p class="text-sm font-bold text-gray-900">{{ number_format($totalPrice, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($booking->items->count() > 0)
                                        <div class="border-t border-gray-100 pt-4 mb-4">
                                            <p class="text-xs font-semibold text-gray-700 mb-2">{{ __('website.booking_items') }}:</p>
                                            <div class="space-y-1">
                                                @foreach($booking->items as $item)
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">{{ $item->service->name }} × {{ $item->quantity }}</span>
                                                        <span class="font-semibold text-gray-900">{{ number_format($item->total_price, 2) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="flex flex-wrap gap-3">
                                        <button class="view-qr-btn inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors" data-reference-code="{{ $booking->reference_code }}" data-qr-code="{{ $booking->qr_code }}">
                                            <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                            {{ __('website.view_qr_code') }}
                                        </button>
                                        <a href="{{ route('booking.link', ['customer' => $booking->customer_id, 'reference' => $booking->reference_code]) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                                            <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ __('website.view_details') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('website.no_upcoming_appointments') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('website.get_started_by_booking') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('website.book_appointment') }}
                            </a>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Tickets Overview -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-accent-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">{{ __('website.popular_tickets') }}</h2>
                    <a href="{{ route('customer.bookings.create') }}" class="text-primary-600 hover:text-primary-800 font-medium text-sm">{{ __('website.view_all') }}</a>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    @foreach(\App\Models\Service::where('is_active', true)->with('images')->limit(3)->get() as $service)
                        <div class="border rounded-xl overflow-hidden bg-white shadow-sm flex items-center p-4 gap-4" data-service-id="{{ $service->id }}">
                            <div class="relative w-28 h-28 flex-shrink-0 image-slider">
                                @foreach($service->images as $index => $image)
                                    <img src="{{ Storage::url($image->image) }}" class="image-slide absolute inset-0 w-full h-full object-cover rounded-xl {{ $index === 0 ? '' : 'hidden' }}">
                                @endforeach
                                <div class="slider-dots absolute bottom-1 left-1/2 -translate-x-1/2 flex gap-1">
                                    @foreach($service->images as $index => $image)
                                        <div class="dot w-2 h-2 rounded-full {{ $index === 0 ? 'bg-primary-600' : 'bg-gray-300' }}"></div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-gray-900">{{ $service->name }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $service->description }}</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-lg font-bold text-primary-600 flex items-center gap-1">
                                        <x-sar-icon class="w-5 h-5" />
                                        {{ $service->price }}
                                    </span>
                                    <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-3 py-1.5 text-sm rounded-md bg-primary-600 text-white hover:bg-primary-700">
                                        {{ __('website.book_now') }}
                                    </a>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <span class="px-2 py-0.5 text-xs bg-primary-100 text-primary-700 rounded-full">{{ __('website.activity_panorama_title') }}</span>
                                    <span class="px-2 py-0.5 text-xs bg-secondary-100 text-secondary-700 rounded-full">{{ __('website.activity_sunset_title') }}</span>
                                    <span class="px-2 py-0.5 text-xs bg-accent-100 text-accent-700 rounded-full">{{ __('website.activity_photography_title') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium">
                        {{ __('website.view_all_services') }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Show QR Code modal
function showQRCode(reference, qrCodeUrl) {
    // Create modal container
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 overflow-y-auto';
    modal.innerHTML = `
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 opacity-80"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-primary-100 to-secondary-100 rounded-full opacity-20 -mt-16 -mr-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-accent-100 to-primary-100 rounded-full opacity-20 -mb-12 -ml-12"></div>
                
                <div class="bg-white px-6 pt-6 pb-6 sm:p-8 sm:pb-6 relative z-10">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <div class="flex items-center justify-center mb-6">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-500 to-secondary-500 flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 011 1v2a1 1 0 01-1 1H9a1 1 0 01-1-1V8a1 1 0 011-1h2a1 1 0 001-1V5a1 1 0 00-1-1H7a2 2 0 00-2 2v2a2 2 0 002 2h2zm0 0v4m0 0h.01M12 16h.01" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ __('website.booking_qr_code') }}</h3>
                            </div>
                            
                            <div class="mt-2 flex flex-col items-center">
                                <div class="bg-gradient-to-br from-gray-50 to-accent-50 rounded-2xl p-6 mb-6 w-full border border-gray-100 shadow-sm">
                                    <p class="text-sm text-gray-600 mb-2">{{ __('website.booking_reference') }}</p>
                                    <p class="text-lg font-bold text-gray-900 mb-4 font-mono">${reference}</p>
                                    <div class="flex justify-center">
                                        <div class="p-3 bg-white rounded-xl shadow-lg border-4 border-white inline-block transform hover:scale-105 transition-all duration-300">
                                            <img src="${qrCodeUrl}" alt="QR Code" class="w-48 h-48 mx-auto">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-xl p-4 w-full border border-primary-100 mb-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0 mr-3">
                                            <svg class="h-5 w-5 text-primary-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-primary-800 mb-1">{{ __('website.helpful_tip') }}</h4>
                                            <p class="text-sm text-primary-700">{{ __('website.scan_qr_code_for_check_in') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse relative z-10">
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:-translate-y-0.5">
                        {{ __('website.close') }}
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.appendChild(modal);
    
    // Add event listener to close modal when clicking outside
    modal.querySelector('.fixed.inset-0.transition-opacity').addEventListener('click', function() {
        document.body.removeChild(modal);
    });
    
    // Add event listener to close modal when clicking close button
    modal.querySelector('[aria-hidden="true"]').addEventListener('click', function() {
        document.body.removeChild(modal);
    });
    
    // Add event listener to close modal when clicking the close button in footer
    modal.querySelector('.bg-gray-50 button').addEventListener('click', function() {
        document.body.removeChild(modal);
    });
    
    // Prevent closing when clicking inside the modal content
    modal.querySelector('.inline-block').addEventListener('click', function(e) {
        e.stopPropagation();
    });
}

// Event listeners for buttons
document.addEventListener('DOMContentLoaded', function() {
    // View QR Code buttons
    const viewQrButtons = document.querySelectorAll('.view-qr-btn');
    if (viewQrButtons.length > 0) {
        viewQrButtons.forEach(button => {
            button.addEventListener('click', function() {
                const referenceCode = this.getAttribute('data-reference-code');
                const qrCode = this.getAttribute('data-qr-code');
                showQRCode(referenceCode, qrCode);
            });
        });
    }
});
</script>
@endsection