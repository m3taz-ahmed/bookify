@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-2xl shadow-xl p-8 mb-8 text-white">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->guard('customer')->user()->name }}!</h1>
                    <p class="text-light-100 max-w-2xl">Manage your appointments, view booking history, and schedule new services all in one place.</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-xl p-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold">{{ \App\Models\Booking::where('customer_id', auth()->guard('customer')->id())->count() }}</div>
                        <div class="text-sm text-light-100">Total Bookings</div>
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
                    <h3 class="text-xl font-bold text-gray-900">Book Appointment</h3>
                </div>
                <p class="text-gray-600 mb-4">Schedule a new service with our professionals</p>
                <span class="inline-flex items-center text-primary-600 font-medium">
                    Book now
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
                    <h3 class="text-xl font-bold text-gray-900">My Bookings</h3>
                </div>
                <p class="text-gray-600 mb-4">View and manage your upcoming appointments</p>
                <span class="inline-flex items-center text-accent-600 font-medium">
                    View all
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            </a>

            <div class="bg-white rounded-2xl shadow-md p-6 border border-accent-200">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-secondary-100 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-secondary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Profile</h3>
                </div>
                <p class="text-gray-600 mb-4">Update your personal information and preferences</p>
                <button class="inline-flex items-center text-secondary-600 font-medium">
                    Edit profile
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8 border border-accent-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Upcoming Appointments</h2>
                <a href="{{ route('customer.bookings') }}" class="text-primary-600 hover:text-primary-800 font-medium text-sm">View all</a>
            </div>
            
            @php
                $upcomingBookings = \App\Models\Booking::where('customer_id', auth()->guard('customer')->id())
                    ->where('booking_date', '>=', date('Y-m-d'))
                    ->where('status', '!=', 'cancelled')
                    ->orderBy('booking_date')
                    ->orderBy('start_time')
                    ->limit(3)
                    ->get();
            @endphp
            
            @if($upcomingBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingBookings as $booking)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-primary-100 flex items-center justify-center mr-4">
                                    <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $booking->service->name_en }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M j, Y') }} at {{ $booking->start_time }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 mr-3">
                                    {{ $booking->status }}
                                </span>
                                <button class="text-gray-400 hover:text-primary-600">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming appointments</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by booking a new appointment.</p>
                    <div class="mt-6">
                        <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Book Appointment
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Services Overview -->
        <div class="bg-white rounded-2xl shadow-md p-6 border border-accent-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Popular Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach(\App\Models\Service::where('is_active', true)->limit(3)->get() as $service)
                    <div class="border border-gray-200 rounded-xl p-5 hover:border-primary-300 transition-colors duration-200">
                        <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $service->name_en }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ $service->description }}</p>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                            <span class="text-lg font-bold text-primary-600">${{ $service->price }}</span>
                            <span class="text-sm text-gray-500">{{ $service->duration_minutes }} mins</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center text-primary-600 hover:text-primary-800 font-medium">
                    View all services
                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection