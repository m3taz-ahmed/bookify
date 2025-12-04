<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <nav class="bg-white shadow-sm border-b border-background-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('booking-welcome') }}" class="flex items-center">
                            <img src="{{ asset('images/logo.svg') }}" alt="SkyBridge Logo" class="h-12 w-10 invert">
                            <span class="ml-2 text-xl font-bold">
                                <span style="color: #536B7C">Sky</span>
                                <span style="color: #000000">Bridge</span>
                            </span>
                        </a>
                    </div>
                </div>
                @php
                    // Get the current locale to determine the switch locale
                    $currentLocale = app()->getLocale();
                    $switchLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                @endphp
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <!-- Language Switcher -->
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" class="px-3 py-2 text-sm rounded-md {{ app()->getLocale() === $switchLocale ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-100' }}" onclick="event.preventDefault(); document.getElementById('language-switch-form-{{ $switchLocale }}').submit();">
                            {{ $switchLocale === 'ar' ? __('website.arabic') : __('website.english') }}
                        </a>
                        <form id="language-switch-form-{{ $switchLocale }}" action="{{ route('lang.switch', ['locale' => $switchLocale]) }}" method="GET" class="hidden">
                            @csrf
                        </form>
                    </div>
                    <a href="{{ route('pages.show', 'about-us') }}" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">{{ __('website.about') }}</a>
                    <a href="{{ route('pages.show', 'contact-us') }}" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">{{ __('website.contact_us') }}</a>
                    @auth('customer')
                        <a href="{{ route('customer.dashboard') }}" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('customer.dashboard') ? 'bg-primary-100 text-primary-600' : '' }}">{{ __('website.dashboard') }}</a>
                        <a href="{{ route('customer.bookings') }}" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('customer.bookings') ? 'bg-primary-100 text-primary-600' : '' }}">{{ __('website.my_bookings') }}</a>
                        <a href="{{ route('customer.profile') }}" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('customer.profile') ? 'bg-primary-100 text-primary-600' : '' }}">{{ __('website.profile') }}</a>
                        <a href="{{ route('customer.bookings.create') }}" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('customer.bookings.create') ? 'bg-primary-100 text-primary-600' : '' }}">{{ __('website.book_appointment_nav') }}</a>
                        <a href="{{ route('customer.logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            {{ __('website.logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('customer.login') }}" class="text-dark-500 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">{{ __('website.login') }}</a>
                        <a href="{{ route('customer.register') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">{{ __('website.register') }}</a>
                    @endauth
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
                <a href="{{ route('pages.show', 'about-us') }}" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    {{ __('website.about') }}
                </a>
                <a href="{{ route('pages.show', 'contact-us') }}" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    {{ __('website.contact_us') }}
                </a>
                @auth('customer')
                    <a href="{{ route('customer.dashboard') }}" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('customer.dashboard') ? 'bg-primary-100 border-primary-500' : '' }}">
                        {{ __('website.dashboard') }}
                    </a>
                    <a href="{{ route('customer.bookings') }}" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('customer.bookings') ? 'bg-primary-100 border-primary-500' : '' }}">
                        {{ __('website.my_bookings') }}
                    </a>
                    <a href="{{ route('customer.profile') }}" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('customer.profile') ? 'bg-primary-100 border-primary-500' : '' }}">
                        {{ __('website.profile') }}
                    </a>
                    <a href="{{ route('customer.bookings.create') }}" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('customer.bookings.create') ? 'bg-primary-100 border-primary-500' : '' }}">
                        {{ __('website.book_appointment_nav') }}
                    </a>
                @else
                    <a href="{{ route('customer.login') }}" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        {{ __('website.login') }}
                    </a>
                    <a href="{{ route('customer.register') }}" class="border-transparent text-dark-600 hover:bg-background-50 hover:border-background-300 hover:text-dark-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                        {{ __('website.register') }}
                    </a>
                @endauth
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <!-- Language Switcher Mobile -->
                    <div class="px-4 py-2">
                        <div class="flex space-x-2">
                            <a href="{{ route('lang.switch', ['locale' => $switchLocale]) }}" class="px-3 py-1 text-sm rounded-md {{ app()->getLocale() === $switchLocale ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-100' }}" onclick="event.preventDefault(); document.getElementById('language-switch-form-mobile-{{ $switchLocale }}').submit();">
                                {{ $switchLocale === 'ar' ? __('website.arabic') : __('website.english') }}
                            </a>
                            <form id="language-switch-form-mobile-{{ $switchLocale }}" action="{{ route('lang.switch', ['locale' => $switchLocale]) }}" method="GET" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                    @auth('customer')
                        <a href="{{ route('customer.logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-4 py-2 text-base font-medium text-dark-500 hover:text-dark-800 hover:bg-background-100">
                            {{ __('website.logout') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

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