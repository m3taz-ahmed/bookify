<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bookify - Redirecting...</title>
    <meta http-equiv="refresh" content="0;url={{ route('booking-welcome') }}" />
</head>
<body>
    <p>Redirecting to the booking system... <a href="{{ route('booking-welcome') }}">Click here if you are not redirected</a>.</p>
    <script>
        window.location.href = "{{ route('booking-welcome') }}";
    </script>
</body>
</html>