<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SkyBridge') }} - {{ __('website.booking_details') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-background-50 to-background-100 min-h-screen text-dark-500" style="font-family: 'Tajawal', sans-serif;">
    <!-- Page Content Only - No Header/Footer -->
    <main class="min-h-screen">
        @yield('content')
    </main>
    
    <script>
        // Set RTL/LTR based on current locale
        if (document.documentElement.lang === 'ar') {
            document.documentElement.setAttribute('dir', 'rtl');
        } else {
            document.documentElement.setAttribute('dir', 'ltr');
        }
    </script>
    @stack('scripts')
</body>
</html>

