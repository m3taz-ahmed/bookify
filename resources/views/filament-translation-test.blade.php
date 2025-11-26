<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filament Translation Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6">Filament Translation Test</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Current Locale Information</h2>
            <p><strong>App Locale:</strong> {{ app()->getLocale() }}</p>
            <p><strong>Session Locale:</strong> {{ session('locale', 'not set') }}</p>
            <p><strong>Direction:</strong> {{ app()->getLocale() === 'ar' ? 'RTL' : 'LTR' }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Translation Tests</h2>
            <p><strong>Dashboard (filament::layout.dashboard):</strong> {{ __('filament::layout.dashboard') }}</p>
            <p><strong>Bookings (custom):</strong> {{ __('filament.Bookings') }}</p>
            <p><strong>Customers (custom):</strong> {{ __('filament.Customers') }}</p>
            <p><strong>Employee Shifts (custom):</strong> {{ __('filament.Employee Shifts') }}</p>
            <p><strong>Multiple Shifts (custom):</strong> {{ __('filament.Multiple Shifts') }}</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Config Values</h2>
            <p><strong>App Locale:</strong> {{ config('app.locale') }}</p>
            <p><strong>App Fallback Locale:</strong> {{ config('app.fallback_locale') }}</p>
        </div>
    </div>
</body>
</html>