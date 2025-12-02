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

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-900 mt-12">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <div class="flex items-center">
                        <a href="{{ route('booking-welcome') }}" class="flex items-center">
                            <img src="{{ asset('images/logo.svg') }}" alt="SkyBridge Logo" class="h-12 w-10 filter brightness-0 invert" style="filter: drop-shadow(0 0 2px rgba(0,0,0,0.5));">
                            <span class="ml-2 text-xl font-bold">
                                <span style="color: #536B7C">Sky</span>
                                <span style="color: #ffffff">Bridge</span>
                            </span>
                        </a>
                    </div>
                    <p class="text-dark-300 text-base">
                        {{ __('website.our_platform') }}
                    </p>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-dark-300 tracking-wider uppercase">
                                {{ __('website.support') }}
                            </h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="#" class="text-base text-dark-400 hover:text-primary-300">
                                        {{ __('website.help_center') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-base text-dark-400 hover:text-primary-300">
                                        {{ __('website.contact_us') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-dark-300 tracking-wider uppercase">
                                {{ __('website.company') }}
                            </h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="{{ route('pages.show', 'about-us') }}" class="text-base text-dark-400 hover:text-primary-300">
                                        {{ __('website.about') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pages.show', 'contact-us') }}" class="text-base text-dark-400 hover:text-primary-300">
                                        {{ __('website.contact_us') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-dark-300 tracking-wider uppercase">
                                {{ __('website.legal') }}
                            </h3>
                            <ul class="mt-4 space-y-4">
                                <li>
                                    <a href="{{ route('pages.show', 'privacy-policy') }}" class="text-base text-dark-400 hover:text-primary-300">
                                        {{ __('website.privacy') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pages.show', 'terms-and-conditions') }}" class="text-base text-dark-400 hover:text-primary-300">
                                        {{ __('website.terms') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('pages.show', 'faq') }}" class="text-base text-dark-400 hover:text-primary-300">
                                        {{ __('website.faq') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-base text-dark-400 xl:text-center">
                    &copy; {{ date('Y') }} SkyBridge. {{ __('website.all_rights_reserved') }}
                </p>
            </div>
        </div>
    </footer>
    
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