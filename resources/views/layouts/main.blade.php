<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SkyBridge') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-background-50 to-background-100 min-h-screen text-dark-500" style="font-family: 'Tajawal', sans-serif;">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-md border-b border-background-200 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('booking-welcome') }}" class="flex items-center">
                        <div class="relative">
                            <img src="{{ asset('images/logo.svg') }}" alt="SkyBridge Logo" class="h-14 w-12 invert transition-transform duration-300 group-hover:rotate-6 drop-shadow-sm">
                            <div class="absolute inset-0 bg-primary-500 rounded-full opacity-0 group-hover:opacity-10 blur-xl transition-opacity duration-300"></div>
                        </div>
                        <span class="ml-3 text-2xl font-bold">
                            <span style="color: #536B7C" class="transition-colors duration-200 group-hover:text-primary-600">Sky</span>
                            <span style="color: #000000" class="transition-colors duration-200 group-hover:text-primary-700">Bridge</span>
                        </span>
                    </a>
                </div>
                
                @php
                    $currentLocale = app()->getLocale();
                    $switchLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                @endphp
                
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex lg:items-center lg:space-x-1">
                    <!-- Main Navigation Links -->
                    <a href="{{ route('pages.show', 'about-us') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 hover:text-primary-700 {{ request()->routeIs('pages.show') && request()->route('slug') === 'about-us' ? 'bg-primary-100 text-primary-700' : 'text-dark-600' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('website.about') }}
                    </a>
                    <a href="{{ route('pages.show', 'contact-us') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 hover:text-primary-700 {{ request()->routeIs('pages.show') && request()->route('slug') === 'contact-us' ? 'bg-primary-100 text-primary-700' : 'text-dark-600' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ __('website.contact_us') }}
                    </a>
                    
                    @auth('customer')
                        <!-- Authenticated User Menu -->
                        <div class="mx-2 h-6 w-px bg-gray-300"></div>
                        <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 {{ request()->routeIs('customer.bookings.create') ? 'ring-2 ring-primary-500 ring-offset-2' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            {{ __('website.book_appointment_nav') }}
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 hover:text-primary-700 {{ request()->routeIs('customer.dashboard') ? 'bg-primary-100 text-primary-700' : 'text-dark-600' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ __('website.dashboard') }}
                        </a>
                        <a href="{{ route('customer.bookings') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 hover:text-primary-700 {{ request()->routeIs('customer.bookings') ? 'bg-primary-100 text-primary-700' : 'text-dark-600' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            {{ __('website.my_bookings') }}
                        </a>
                        <a href="{{ route('customer.profile') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-primary-50 hover:text-primary-700 {{ request()->routeIs('customer.profile') ? 'bg-primary-100 text-primary-700' : 'text-dark-600' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('website.profile') }}
                        </a>
                        <div class="mx-2 h-6 w-px bg-gray-300"></div>
                        <a href="{{ route('customer.logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            {{ __('website.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        <!-- Guest Menu -->
                        <div class="mx-2 h-6 w-px bg-gray-300"></div>
                        <a href="{{ route('customer.login') }}" class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-medium text-dark-600 hover:bg-gray-50 transition-all duration-200">
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
                    
                    <!-- Language Switcher -->
                    <div class="mx-2 h-6 w-px bg-gray-300"></div>
                    <div class="flex items-center">
                        <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" 
                           onclick="event.preventDefault(); document.getElementById('language-switch-form-{{ $switchLocale }}').submit();"
                           class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ app()->getLocale() === $switchLocale ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
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
                    <button type="button" class="inline-flex items-center justify-center p-2.5 rounded-lg text-dark-400 hover:text-dark-600 hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 transition-all duration-200" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="lg:hidden hidden border-t border-gray-200 bg-white" id="mobile-menu">
            <div class="px-4 pt-4 pb-3 space-y-1">
                <!-- Main Links -->
                <a href="{{ route('pages.show', 'about-us') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 {{ request()->routeIs('pages.show') && request()->route('slug') === 'about-us' ? 'bg-primary-100 text-primary-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('website.about') }}
                </a>
                <a href="{{ route('pages.show', 'contact-us') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 {{ request()->routeIs('pages.show') && request()->route('slug') === 'contact-us' ? 'bg-primary-100 text-primary-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ __('website.contact_us') }}
                </a>
                
                @auth('customer')
                    <div class="border-t border-gray-200 my-2"></div>
                    <a href="{{ route('customer.bookings.create') }}" class="flex items-center justify-center px-4 py-3 rounded-lg text-base font-semibold text-white bg-gradient-to-r from-primary-600 to-secondary-700 hover:from-primary-700 hover:to-secondary-800 transition-all duration-200 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('website.book_appointment_nav') }}
                    </a>
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 {{ request()->routeIs('customer.dashboard') ? 'bg-primary-100 text-primary-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        {{ __('website.dashboard') }}
                    </a>
                    <a href="{{ route('customer.bookings') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 {{ request()->routeIs('customer.bookings') ? 'bg-primary-100 text-primary-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        {{ __('website.my_bookings') }}
                    </a>
                    <a href="{{ route('customer.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 hover:bg-primary-50 hover:text-primary-700 transition-all duration-200 {{ request()->routeIs('customer.profile') ? 'bg-primary-100 text-primary-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        {{ __('website.profile') }}
                    </a>
                    <div class="border-t border-gray-200 my-2"></div>
                    <a href="{{ route('customer.logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-red-600 hover:bg-red-50 transition-all duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('website.logout') }}
                    </a>
                @else
                    <div class="border-t border-gray-200 my-2"></div>
                    <a href="{{ route('customer.login') }}" class="flex items-center px-4 py-3 rounded-lg text-base font-medium text-dark-600 hover:bg-gray-50 transition-all duration-200">
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
                
                <!-- Language Switcher Mobile -->
                <div class="border-t border-gray-200 my-2"></div>
                <div class="px-4 py-2">
                    <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" 
                       onclick="event.preventDefault(); document.getElementById('language-switch-form-mobile-{{ $switchLocale }}').submit();"
                       class="flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ app()->getLocale() === $switchLocale ? 'bg-primary-100 text-primary-700' : 'text-gray-600 bg-gray-50 hover:bg-gray-100' }}">
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
    
    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                    mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                    mobileMenu.classList.toggle('hidden');
                });
            }
            
            // Set RTL/LTR based on current locale
            if (document.documentElement.lang === 'ar') {
                document.documentElement.setAttribute('dir', 'rtl');
            } else {
                document.documentElement.setAttribute('dir', 'ltr');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>