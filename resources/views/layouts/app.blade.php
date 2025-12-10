@extends('layouts.main')

@section('content')
    @auth('customer')
        <!-- Navigation -->
        <nav class="bg-white/95 dark:bg-dark-900/95 backdrop-blur-md shadow-md border-b border-background-200 dark:border-dark-700 sticky top-0 z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center">
                            <div class="relative">
                                {{-- Conditional logo based on language and theme --}}
                                @php
                                    $currentLocale = app()->getLocale();
                                    $isDarkMode = isset($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === 'true';
                                    
                                    if ($currentLocale === 'ar') {
                                        $logoPath = $isDarkMode ? 'images/logo/logo04.png' : 'images/logo/logo03.png';
                                    } else {
                                        $logoPath = $isDarkMode ? 'images/logo/logo02.png' : 'images/logo/logo01.png';
                                    }
                                @endphp
                                <img src="{{ asset($logoPath) }}" alt="SkyBridge Logo" class="h-16 w-auto transition-transform duration-300 group-hover:rotate-6 drop-shadow-sm">
                                <div class="absolute inset-0 bg-primary-500 rounded-full opacity-0 group-hover:opacity-10 blur-xl transition-opacity duration-300"></div>
                            </div>
                            <span class="ml-3 text-2xl font-bold">
                                <span style="color: #79878C" class="transition-colors duration-200 group-hover:text-primary-600 dark:text-primary-400">Sky</span>
                                <span style="color: #000000" class="transition-colors duration-200 group-hover:text-primary-700 dark:text-white">Bridge</span>
                            </span>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-1">
                        <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 {{ request()->routeIs('customer.bookings.create') ? 'ring-2 ring-primary-500 ring-offset-2' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            {{ __('website.book_appointment_nav') }}
                        </a>
                        <div class="mx-2 h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 {{ request()->routeIs('customer.dashboard') ? 'bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : 'text-dark-600 dark:text-gray-300' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ __('website.dashboard') }}
                        </a>
                        <a href="{{ route('customer.bookings') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 {{ request()->routeIs('customer.bookings', 'customer.bookings.edit') ? 'bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : 'text-dark-600 dark:text-gray-300' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ __('website.my_bookings') }}
                        </a>
                        <a href="{{ route('customer.profile') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 {{ request()->routeIs('customer.profile', 'customer.profile.edit') ? 'bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : 'text-dark-600 dark:text-gray-300' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('website.profile') }}
                        </a>
                        <div class="mx-2 h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                        @php
                            $currentLocale = app()->getLocale();
                            $switchLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                        @endphp
                        <!-- User Menu -->
                        <div class="flex items-center space-x-3">
                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-primary-500 to-secondary-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                {{ strtoupper(substr(auth()->guard('customer')->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-dark-900 dark:text-gray-100">{{ auth()->guard('customer')->user()->name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('website.dashboard') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('customer.logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('website.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <div class="mx-2 h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <!-- Language Switcher -->
                        <div class="flex items-center">
                            <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" 
                               onclick="event.preventDefault(); document.getElementById('language-switch-form-{{ $switchLocale }}').submit();"
                               class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ app()->getLocale() === $switchLocale ? 'bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700' }}">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                                {{ $switchLocale === 'ar' ? __('website.arabic') : __('website.english') }}
                            </a>
                            <form id="language-switch-form-{{ $switchLocale }}" action="{{ route('lang.switch', ['locale' => $switchLocale]) }}" method="GET" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="flex items-center lg:hidden">
                        <button type="button" class="inline-flex items-center justify-center p-2.5 rounded-lg text-dark-400 dark:text-gray-300 hover:text-dark-600 dark:hover:text-white hover:bg-primary-50 dark:hover:bg-dark-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-200" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div class="lg:hidden hidden border-t border-gray-200 dark:border-dark-700 bg-white dark:bg-dark-800" id="mobile-menu">
                <div class="px-4 pt-4 pb-3 space-y-1">
                    <a href="{{ route('customer.bookings.create') }}" class="flex items-center justify-center px-4 py-3 rounded-lg text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 transition-all duration-200 shadow-md mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('website.book_appointment_nav') }}
                    </a>
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('customer.dashboard') ? 'bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        {{ __('website.dashboard') }}
                    </a>
                    <a href="{{ route('customer.bookings') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('customer.bookings', 'customer.bookings.edit') ? 'bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        {{ __('website.my_bookings') }}
                    </a>
                    <a href="{{ route('customer.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 transition-all duration-200 {{ request()->routeIs('customer.profile', 'customer.profile.edit') ? 'bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('website.profile') }}
                    </a>
                    <div class="border-t border-gray-200 dark:border-dark-700 my-2"></div>
                    <!-- User Info -->
                    <div class="flex items-center px-4 py-3">
                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-primary-500 to-secondary-600 flex items-center justify-center text-white font-semibold text-lg shadow-md mr-3">
                            {{ strtoupper(substr(auth()->guard('customer')->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <div class="text-base font-semibold text-dark-900 dark:text-gray-100">{{ auth()->guard('customer')->user()->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->guard('customer')->user()->email }}</div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 dark:border-dark-700 my-2"></div>
                    <!-- Language Switcher Mobile -->
                    <div class="px-4 py-2">
                        <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" 
                           onclick="event.preventDefault(); document.getElementById('language-switch-form-mobile-{{ $switchLocale }}').submit();"
                           class="flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ app()->getLocale() === $switchLocale ? 'bg-primary-100 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400' : 'text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-dark-700 hover:bg-gray-100 dark:hover:bg-dark-600' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                            </svg>
                            {{ $switchLocale === 'ar' ? __('website.arabic') : __('website.english') }}
                        </a>
                        <form id="language-switch-form-mobile-{{ $switchLocale }}" action="{{ route('lang.switch', ['locale' => $switchLocale]) }}" method="GET" class="hidden">
                            @csrf
                        </form>
                    </div>
                    <a href="{{ route('customer.logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('website.logout') }}
                    </a>
                </div>
            </div>
        </nav>
    @endauth

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white dark:bg-dark-800 shadow border-b border-background-200 dark:border-dark-700">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Breadcrumbs -->
    <!-- Breadcrumbs removed as they are handled by main layout -->

    <!-- Page Content -->
    <div class="min-h-screen">
        @yield('content')
    </div>
    
    <!-- Footer removed as it is handled by main layout -->
@endsection