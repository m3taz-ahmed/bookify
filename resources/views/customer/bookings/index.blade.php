@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-background-50 to-accent-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500 rounded-full -mt-16 -mr-16 opacity-10"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-secondary-500 rounded-full -mb-12 -ml-12 opacity-10"></div>
                <div class="flex flex-col md:flex-row md:items-center md:justify-between relative z-10">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ __('website.my_bookings') }}</h1>
                        <p class="mt-1 text-sm text-gray-600">{{ __('website.manage_appointments') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-xl shadow-md text-base font-medium text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg"
                            <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ __('website.book_new_appointment') }}
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-6">
                <!-- Filter Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex space-x-8">
                        <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {{ __('website.all_bookings') }}
                        </button>
                        <button class="border-primary-500 text-primary-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {{ __('website.upcoming') }}
                        </button>
                        <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {{ __('website.past') }}
                        </button>
                        <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {{ __('website.cancelled') }}
                        </button>
                    </nav>
                </div>
                
                <!-- Bookings List -->
                <div class="space-y-4">
                    @forelse($bookings as $booking)
                        <div class="border border-gray-200 rounded-2xl p-6 hover:border-primary-300 transition-all duration-300 bg-white hover:bg-gradient-to-br from-white to-primary-50 shadow-sm hover:shadow-lg transform hover:-translate-y-1 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-primary-500 rounded-full -mt-12 -mr-12 transition-all duration-500 group-hover:scale-150 opacity-5"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-secondary-500 rounded-full -mb-8 -ml-8 transition-all duration-500 group-hover:scale-150 opacity-5"></div>
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex items-start">
                                    <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center mr-4 flex-shrink-0">
                                        <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-900">{{ $booking->service->name }}</h3>
                                        <p class="text-gray-600 mt-1">
                                            <span class="inline-flex items-center">
                                                <svg class="h-4 w-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M j, Y') }}
                                            </span>
                                            <span class="mx-2">•</span>
                                            <span class="inline-flex items-center">
                                                <svg class="h-4 w-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $booking->start_time }} - {{ $booking->end_time }}
                                            </span>
                                        </p>
                                        {{-- Employee information removed as per requirement --}}
                                        <p class="text-sm text-gray-500 mt-1">
                                            <span class="inline-flex items-center">
                                                <svg class="h-4 w-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                {{ $booking->number_of_people }} {{ __('website.people') }}
                                            </span>
                                            <span class="mx-2">•</span>
                                            <span class="inline-flex items-center">
                                                @if($booking->payment_method === 'cash')
                                                    <svg class="h-4 w-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ __('website.cash_payment') }}
                                                @else
                                                    <svg class="h-4 w-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                    {{ __('website.online_payment') }}
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 md:mt-0 flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($booking->status === 'confirmed') bg-accent-100 text-accent-800
                                        @elseif($booking->status === 'pending') bg-light-100 text-light-800
                                        @elseif($booking->status === 'cancelled') bg-background-100 text-background-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <button class="ml-3 text-gray-400 hover:text-primary-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-gray-500">
                                    {{ __('website.reference') }}: <span class="font-mono">{{ $booking->reference_code }}</span>
                                </div>
                                <div class="mt-2 sm:mt-0 flex space-x-2">
                                    @if($booking->qr_code)
                                        <button onclick="showQRCode('{{ $booking->reference_code }}', '{{ $booking->qr_code }}')" class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-900 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-full transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                                            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 011 1v2a1 1 0 01-1 1H9a1 1 0 01-1-1V8a1 1 0 011-1h2a1 1 0 001-1V5a1 1 0 00-1-1H7a2 2 0 00-2 2v2a2 2 0 002 2h2zm0 0v4m0 0h.01M12 16h.01" />
                                            </svg>
                                            {{ __('website.view_qr_code') }}
                                        </button>
                                    @endif
                                    @if($booking->status === 'confirmed' || $booking->status === 'pending')
                                        <button class="text-sm font-medium text-red-600 hover:text-red-900">
                                            {{ __('website.cancel_booking') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ __('website.no_bookings_found') }}</h3>
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
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($bookings->hasPages())
                    <div class="mt-6">
                        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                            <div class="flex flex-1 justify-between sm:hidden">
                                <a href="{{ $bookings->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('website.previous') }}</a>
                                <a href="{{ $bookings->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('website.next') }}</a>
                            </div>
                            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        {{ __('website.showing') }}
                                        <span class="font-medium">{{ $bookings->firstItem() }}</span>
                                        {{ __('website.to') }}
                                        <span class="font-medium">{{ $bookings->lastItem() }}</span>
                                        {{ __('website.of') }}
                                        <span class="font-medium">{{ $bookings->total() }}</span>
                                        {{ __('website.results') }}
                                    </p>
                                </div>
                                <div>
                                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                        @if ($bookings->onFirstPage())
                                            <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 cursor-not-allowed">
                                                <span class="sr-only">{{ __('website.previous') }}</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        @else
                                            <a href="{{ $bookings->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                <span class="sr-only">{{ __('website.previous') }}</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif

                                        @for ($i = 1; $i <= $bookings->lastPage(); $i++)
                                            @if ($i == $bookings->currentPage())
                                                <span class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold text-primary-600 bg-primary-100 ring-1 ring-inset ring-primary-600">{{ $i }}</span>
                                            @else
                                                <a href="{{ $bookings->url($i) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">{{ $i }}</a>
                                            @endif
                                        @endfor

                                        @if ($bookings->hasMorePages())
                                            <a href="{{ $bookings->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                                                <span class="sr-only">{{ __('website.next') }}</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @else
                                            <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 cursor-not-allowed">
                                                <span class="sr-only">{{ __('website.next') }}</span>
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        @endif
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showQRCode(reference, qrCodeUrl) {
    // Create modal container
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 overflow-y-auto';
    modal.innerHTML = `
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 opacity-80" onclick="this.closest('.fixed').remove()"></div>
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
}
</script>
@endsection