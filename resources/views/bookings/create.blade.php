<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $currentLocale) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Service - SkyBridge</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100">
    <?php if (!session()->isStarted()) session()->start(); ?>
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">SkyBridge</h1>
                <!-- Language Switcher -->
                <div class="flex items-center space-x-2">
                    <a href="@php echo route('booking-welcome'); @endphp" class="px-3 py-2 text-sm rounded-md {{ $currentLocale === 'ar' ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ __('website.arabic') }}
                    </a>
                    <a href="@php echo route('booking-welcome'); @endphp" class="px-3 py-2 text-sm rounded-md {{ $currentLocale === 'en' ? 'bg-primary-100 text-primary-700 font-medium' : 'text-gray-600 hover:bg-gray-100' }}">
                        {{ __('website.english') }}
                    </a>
                </div>
            </div>
        </header>
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                @livewire('create-booking')
            </div>
        </main>
    </div>
    @livewireScripts
</body>
</html>