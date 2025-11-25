<!DOCTYPE html>
<html>
<head>
    <title>Test Authentication</title>
</head>
<body>
    <h1>Test Authentication</h1>
    <p>This is a test page to check authentication.</p>
    <a href="{{ route('customer.dashboard', ['locale' => $currentLocale]) }}">Go to Customer Dashboard</a>
    <br>
    <a href="{{ route('customer.login', ['locale' => $currentLocale]) }}">Go to Login</a>
</body>
</html>