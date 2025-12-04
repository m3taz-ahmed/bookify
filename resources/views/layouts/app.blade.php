@extends('layouts.main')

@section('content')
    @auth('customer')
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-background-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <img src="{{ asset('images/logo.svg') }}" alt="SkyBridge Logo" class="h-12 w-10 invert">
                            <span class="ml-2 text-xl font-bold">
                                <span style="color: #536B7C">Sky</span>
                                <span style="color: #000000">Bridge</span>
                            </span>
                        </div>
                        <div class="hidden md:ml-6 md:flex md:space-x-8">
                            <a href="{{ route('customer.dashboard') }}" class="text-dark-500 hover:text-dark-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('customer.dashboard') ? 'border-primary-500 text-primary-600' : 'border-transparent' }}">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ __('website.dashboard') }}
                            </a>
                            <a href="{{ route('customer.bookings') }}" class="text-dark-500 hover:border-background-300 hover:text-dark-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('customer.bookings', 'customer.bookings.edit') ? 'border-primary-500 text-primary-600'  : 'border-transparent' }}">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                                {{ __('website.my_bookings') }}
                            </a>
                            <a href="{{ route('customer.bookings.create') }}" class="text-dark-500 hover:border-background-300 hover:text-dark-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('customer.bookings.create') ? 'border-primary-500 text-primary-600'  : 'border-transparent' }}">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('website.book_appointment_nav') }}
                            </a>
                            <a href="{{ route('customer.profile') }}" class="text-dark-500 hover:border-background-300 hover:text-dark-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('customer.profile', 'customer.profile.edit') ? 'border-primary-500 text-primary-600'  : 'border-transparent' }}">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('website.profile') }}
                            </a>
                        </div>
                    </div>
                    @php
                        // Get the current locale to determine the switch locale
                        $currentLocale = app()->getLocale();
                        $switchLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                    @endphp
                    <div class="hidden md:ml-6 md:flex md:items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <!-- Language Switcher -->
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" class="px-3 py-1 text-sm rounded-md {{ app()->getLocale() === $switchLocale ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-100' }}" onclick="console.log('Customer language switcher clicked'); return true;">
                                        {{ $switchLocale === 'ar' ? __('website.arabic') : __('website.english') }}
                                    </a>
                                </div>
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-primary-100 flex items-center justify-center mr-2">
                                        <svg class="h-4 w-4 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-dark-500">{{ auth()->guard('customer')->user()->name }}</span>
                                </div>
                                <a href="{{ route('customer.logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="inline-flex items-center text-sm text-dark-500 hover:text-dark-900 transition-colors duration-200">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('website.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-dark-400 hover:text-dark-500 hover:bg-background-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div class="md:hidden hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('customer.dashboard') }}" class="text-dark-600 hover:bg-background-50 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('customer.dashboard') ? 'bg-primary-50 border-primary-500 text-primary-700' : 'border-transparent' }}">
                        {{ __('website.dashboard') }}
                    </a>
                    <a href="{{ route('customer.bookings') }}" class="text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('customer.bookings', 'customer.bookings.edit') ? 'border-primary-500 bg-primary-50 text-primary-700' : '' }}">
                        {{ __('website.my_bookings') }}
                    </a>
                    <a href="{{ route('customer.bookings.create') }}" class="text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('customer.bookings.create') ? 'border-primary-500 bg-primary-50 text-primary-700' : '' }}">
                        {{ __('website.book_appointment_nav') }}
                    </a>
                    <a href="{{ route('customer.profile') }}" class="text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('customer.profile', 'customer.profile.edit') ? 'border-primary-500 bg-primary-50 text-primary-700' : '' }}">
                        {{ __('website.profile') }}
                    </a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-dark-800">{{ auth()->guard('customer')->user()->name }}</div>
                            <div class="text-sm font-medium text-dark-500">{{ auth()->guard('customer')->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <!-- Language Switcher Mobile -->
                        <div class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" class="px-3 py-1 text-sm rounded-md {{ app()->getLocale() === $switchLocale ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-100' }}" onclick="console.log('Mobile customer language switcher clicked'); return true;">
                                    {{ $switchLocale === 'ar' ? __('website.arabic') : __('website.english') }}
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('customer.logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-4 py-2 text-base font-medium text-dark-500 hover:text-dark-800 hover:bg-background-100">
                            {{ __('website.logout') }}
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow border-b border-background-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Breadcrumbs -->
    @if (!request()->is('login') && !request()->is('register') && !request()->is('customer/login') && !request()->is('customer/register') && !request()->is('password/*') && !request()->is('/') && !request()->is('customer/dashboard'))
        <div class="container mx-auto px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('booking-welcome') }}" class="inline-flex items-center text-sm font-medium text-primary-700 hover:text-primary-900 dark:text-primary-400 dark:hover:text-white">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                {{ __('website.app_name') }}
                            </a>
                        </li>
                        @hasSection('breadcrumbs')
                            @yield('breadcrumbs')
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>
    
    @include('layouts.partials.footer')
@endsection