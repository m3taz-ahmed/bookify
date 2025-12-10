<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" 
      class="">
<head>
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'SkyBridge'))</title>
    <meta name="description" content="@yield('description', __('website.tagline'))">
    <meta name="keywords" content="@yield('keywords', 'SkyBridge, Riyadh, Booking, Events, Luxury, Experience')">
    <meta name="author" content="SkyBridge">
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#8B5A2B">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.svg') }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'SkyBridge'))">
    <meta property="og:description" content="@yield('description', __('website.tagline'))">
    <meta property="og:image" content="@yield('og_image', asset('images/hero-slider/slide-1.png'))">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', config('app.name', 'SkyBridge'))">
    <meta property="twitter:description" content="@yield('description', __('website.tagline'))">
    <meta property="twitter:image" content="@yield('og_image', asset('images/hero-slider/slide-1.png'))">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('schema')
</head>
<body class="font-sans antialiased bg-gradient-to-br from-background-50 to-background-100 dark:from-dark-900 dark:to-dark-800 min-h-screen text-dark-500 dark:text-light-100 transition-colors duration-300" style="font-family: 'Tajawal', sans-serif;">
    @php
        $currentLocale = app()->getLocale();
        $switchLocale = $currentLocale === 'ar' ? 'en' : 'ar';
    @endphp

    <nav class="bg-white/95 dark:bg-dark-900/95 backdrop-blur-md shadow-md border-b border-background-200 dark:border-dark-700 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="{{ route('booking-welcome') }}" class="flex items-center">
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
                            <span style="color: #536B7C" class="transition-colors duration-200 group-hover:text-primary-600 dark:text-primary-400">Sky</span>
                            <span style="color: #000000" class="transition-colors duration-200 group-hover:text-primary-700 dark:text-white">Bridge</span>
                        </span>
                    </a>
                </div>
                
                <div class="hidden lg:flex lg:items-center lg:space-x-1">
                    <a href="{{ route('pages.show', 'about-us') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 text-dark-600 dark:text-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('website.about') }}
                    </a>
                    <a href="{{ route('pages.show', 'contact-us') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 text-dark-600 dark:text-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('website.contact_us') }}
                    </a>
                    
                    @auth('customer')
                        <div class="mx-2 h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            {{ __('website.book_appointment_nav') }}
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 text-dark-600 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ __('website.dashboard') }}
                        </a>
                        <a href="{{ route('customer.bookings') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 text-dark-600 dark:text-gray-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002-2h2a2 2 0 002 2"/>
                            </svg>
                            {{ __('website.my_bookings') }}
                        </a>
                        <!-- <a href="{{ route('customer.profile') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 hover:text-primary-700 text-dark-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('website.profile') }}
                        </a> -->
                        <div class="mx-2 h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <a href="{{ route('customer.logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('website.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        <div class="mx-2 h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                        <a href="{{ route('customer.login') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-dark-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-dark-700 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('website.login') }}
                        </a>
                        <a href="{{ route('customer.register') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            {{ __('website.register') }}
                        </a>
                    @endauth
                    
                    <div class="mx-2 h-6 w-px bg-gray-300 dark:bg-dark-600"></div>
                    <button onclick="toggleDarkMode()" class="dark-mode-toggle p-2 rounded-lg text-dark-400 hover:text-primary-600 hover:bg-primary-50 dark:text-light-400 dark:hover:text-primary-400 dark:hover:bg-dark-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500" aria-label="Toggle Dark Mode">
                        <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                    
                    <div class="mx-2 h-6 w-px bg-gray-300 dark:bg-dark-600"></div>
                    <div class="flex items-center">
                        <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" 
                           onclick="event.preventDefault(); document.getElementById('language-switch-form-{{ $switchLocale }}').submit();"
                           class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-dark-700">
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
        
        <div class="lg:hidden hidden border-t border-gray-200 dark:border-dark-700 bg-white dark:bg-dark-800" id="mobile-menu">
            <div class="px-4 pt-4 pb-3 space-y-1">
                <a href="{{ route('pages.show', 'about-us') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-light-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('website.about') }}
                </a>
                <a href="{{ route('pages.show', 'contact-us') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-light-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ __('website.contact_us') }}
                </a>
                
                @auth('customer')
                    <div class="border-t border-gray-200 dark:border-dark-700 my-2"></div>
                    <a href="{{ route('customer.bookings.create') }}" class="flex items-center justify-center px-4 py-3 rounded-lg text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 transition-all duration-200 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('website.book_appointment_nav') }}
                    </a>
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-light-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        {{ __('website.dashboard') }}
                    </a>
                    <a href="{{ route('customer.bookings') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-light-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        {{ __('website.my_bookings') }}
                    </a>
                    <a href="{{ route('customer.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-light-200 hover:bg-primary-50 dark:hover:bg-dark-700 hover:text-primary-700 dark:hover:text-primary-400 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('website.profile') }}
                    </a>
                    <div class="border-t border-gray-200 dark:border-dark-700 my-2"></div>
                    <a href="{{ route('customer.logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('website.logout') }}
                    </a>
                @else
                    <div class="border-t border-gray-200 dark:border-dark-700 my-2"></div>
                    <a href="{{ route('customer.login') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-light-200 hover:bg-gray-50 dark:hover:bg-dark-700 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('website.login') }}
                    </a>
                    <a href="{{ route('customer.register') }}" class="flex items-center justify-center px-4 py-3 rounded-lg text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 transition-all duration-200 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        {{ __('website.register') }}
                    </a>
                @endauth
                
                <div class="border-t border-gray-200 dark:border-dark-700 my-2"></div>
                <button onclick="toggleDarkMode()" class="dark-mode-toggle w-full flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 dark:text-light-200 hover:bg-gray-50 dark:hover:bg-dark-700 transition-all duration-200">
                    <div class="flex items-center w-full">
                         <span class="mr-3 dark:hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                        <span class="mr-3 hidden dark:inline">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </span>
                        <span>{{ __('website.toggle_theme') }}</span>
                    </div>
                </button>
                
                <div class="border-t border-gray-200 dark:border-dark-700 my-2"></div>
                <div class="px-4 py-2">
                    <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" 
                       onclick="event.preventDefault(); document.getElementById('language-switch-form-mobile-{{ $switchLocale }}').submit();"
                       class="flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-600 dark:text-light-300 bg-gray-50 dark:bg-dark-700 hover:bg-gray-100 dark:hover:bg-dark-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        {{ $switchLocale === 'ar' ? __('website.arabic') : __('website.english') }}
                    </a>
                    <form id="language-switch-form-mobile-{{ $switchLocale }}" action="{{ route('lang.switch', ['locale' => $switchLocale]) }}" method="GET" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumbs -->
    @if (!request()->is('login') && !request()->is('register') && !request()->is('customer/login') && !request()->is('customer/register') && !request()->is('password/*') && !request()->is('/') && !request()->is('welcome') && !request()->is('customer/dashboard') && !request()->routeIs('booking-welcome'))
        <div class="container mx-auto px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('booking-welcome') }}" class="inline-flex items-center text-sm font-medium text-primary-700 hover:text-primary-900 dark:text-primary-400 dark:hover:text-white">
                                <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                {{ __('website.app_name') }}
                            </a>
                        </li>
                        @yield('breadcrumbs')
                    </ol>
                </nav>
            </div>
        </div>
    @endif

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-900/50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                {{ session('success') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" class="inline-flex bg-green-50 dark:bg-green-900/20 rounded-md p-1.5 text-green-500 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600 dark:focus:ring-offset-green-900/20 dark:focus:ring-green-500" aria-label="Dismiss" onclick="dismissFlashMessage(this)">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800 dark:text-red-200">
                                {{ session('error') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" class="inline-flex bg-red-50 dark:bg-red-900/20 rounded-md p-1.5 text-red-500 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600 dark:focus:ring-offset-red-900/20 dark:focus:ring-red-500" aria-label="Dismiss" onclick="dismissFlashMessage(this)">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="container mx-auto px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <div class="rounded-lg bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-900/50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                {{ session('warning') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" class="inline-flex bg-yellow-50 dark:bg-yellow-900/20 rounded-md p-1.5 text-yellow-500 dark:text-yellow-400 hover:bg-yellow-100 dark:hover:bg-yellow-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:ring-yellow-600 dark:focus:ring-offset-yellow-900/20 dark:focus:ring-yellow-500" aria-label="Dismiss" onclick="dismissFlashMessage(this)">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="container mx-auto px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <div class="rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-900/50 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                {{ session('info') }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" class="inline-flex bg-blue-50 dark:bg-blue-900/20 rounded-md p-1.5 text-blue-500 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-50 focus:ring-blue-600 dark:focus:ring-offset-blue-900/20 dark:focus:ring-blue-500" aria-label="Dismiss" onclick="dismissFlashMessage(this)">
                                    <span class="sr-only">Dismiss</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')
    
    <script>
        function toggleDarkMode() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', isDark);
            
            // Update logos based on new theme
            updateLogos(isDark);
        }
        
        function updateLogos(isDark) {
            const currentLocale = document.documentElement.lang;
            let logoPath;
            
            // Determine which logo to use based on language and theme
            if (currentLocale === 'ar') {
                logoPath = isDark ? '/images/logo/logo04.png' : '/images/logo/logo03.png';
            } else {
                logoPath = isDark ? '/images/logo/logo02.png' : '/images/logo/logo01.png';
            }
            
            // Update all logo images on the page that have the specific class
            const logoImages = document.querySelectorAll('img.h-14.w-auto, img.h-12.w-auto');
            logoImages.forEach(img => {
                // Check if this is a SkyBridge logo by checking the alt attribute or parent structure
                if (img.alt && img.alt.includes('SkyBridge')) {
                    img.src = logoPath;
                }
            });
        }

        // Function to dismiss flash messages
        function dismissFlashMessage(button) {
            const alert = button.closest('.rounded-lg');
            if (alert) {
                alert.style.transition = 'opacity 0.3s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to dismiss buttons
            const dismissButtons = document.querySelectorAll('[aria-label="Dismiss"]');
            dismissButtons.forEach(button => {
                button.addEventListener('click', function() {
                    dismissFlashMessage(this);
                });
            });
            
            // Initialize dark mode based on localStorage or system preference
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode !== null) {
                if (savedDarkMode === 'true') {
                    document.documentElement.classList.add('dark');
                }
            } else {
                // Use system preference if no saved preference
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('darkMode', 'true');
                }
            }

            // const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
            // const mobileMenu = document.getElementById('mobile-menu');
            
            // if (mobileMenuButton && mobileMenu) {
            //     mobileMenuButton.addEventListener('click', function() {
            //         const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            //         mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            //         mobileMenu.classList.toggle('hidden');
            //     });
            // }
            
            if (document.documentElement.lang === 'ar') {
                document.documentElement.setAttribute('dir', 'rtl');
            } else {
                document.documentElement.setAttribute('dir', 'ltr');
            }

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('Service Worker registered with scope:', registration.scope);
                    })
                    .catch(error => {
                        console.log('Service Worker registration failed:', error);
                    });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>