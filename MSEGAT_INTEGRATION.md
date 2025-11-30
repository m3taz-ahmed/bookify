# Msegat SMS Integration Documentation

## Overview

This integration connects your Bookify application with Msegat SMS service to provide:

1. **OTP Authentication**: Real OTP codes sent via SMS for customer login
2. **Booking Notifications**: SMS notifications for booking confirmations and cancellations

## Features

### 1. OTP Authentication
- Generates random 6-digit OTP codes
- Sends OTP via Msegat SMS API
- 5-minute expiration time for security
- Replaces the hardcoded "123456" OTP

### 2. Booking Notifications
- Sends SMS when booking is confirmed
- Sends SMS when booking is cancelled
- Messages in Arabic for better customer experience
- Includes booking details (service, date, time, reference code)

## Configuration

### Environment Variables

Add these variables to your `.env` file:

```env
MSEGAT_USERNAME=techflipp
MSEGAT_API_KEY=4563eb312a38125a5b63acb0d57bd57a
MSEGAT_SENDER=Bookify
MSEGAT_BASE_URL=https://www.msegat.com/gw
```

### Admin Panel Configuration

1. Log in to your Filament admin panel
2. Navigate to **Settings** → **SMS Settings (Msegat)**
3. Fill in your credentials:
   - **Username**: techflipp
   - **API Key**: 4563eb312a38125a5b63acb0d57bd57a
   - **Sender Name**: Bookify (max 11 characters)
4. Click **Save Settings**
5. Use **Send Test SMS** to verify the configuration

## Files Created/Modified

### New Files

1. **app/Services/MsegatService.php**
   - Main service class for Msegat API integration
   - Methods: `sendOtpFree()`, `sendOtpCode()`, `verifyOtpCode()`, `sendSms()`

2. **app/Notifications/Channels/MsegatSmsChannel.php**
   - Custom notification channel for Laravel notifications
   - Integrates with Laravel's notification system

3. **app/Filament/Pages/MsegatSettings.php**
   - Admin panel page for managing SMS settings
   - Includes test SMS functionality

4. **resources/views/filament/pages/msegat-settings.blade.php**
   - View for the settings page

### Modified Files

1. **config/services.php**
   - Added Msegat configuration

2. **app/Models/Customer.php**
   - Updated `generateOtp()` to create random 6-digit codes
   - Changed expiration from 60 seconds to 5 minutes

3. **app/Http/Controllers/Auth/CustomerPhoneAuthController.php**
   - Integrated Msegat SMS service for OTP sending
   - Sends real OTP codes via SMS

4. **app/Notifications/BookingConfirmed.php**
   - Added SMS channel support
   - Added `toMsegatSms()` method with Arabic message

5. **app/Notifications/BookingCancelled.php**
   - Added SMS channel support
   - Added `toMsegatSms()` method with Arabic message

## API Endpoints Used

### 1. Send OTP Code
```
POST https://www.msegat.com/gw/sendOTPCode.php
```
**Parameters:**
- `userName`: Your Msegat username
- `apiKey`: Your API key
- `numbers`: Phone number (966xxxxxxxxx)
- `userSender`: Sender name
- `code`: The OTP code to send

### 2. Send SMS
```
POST https://www.msegat.com/gw/sendsms.php
```
**Parameters:**
- `userName`: Your Msegat username
- `apiKey`: Your API key
- `numbers`: Phone number (966xxxxxxxxx)
- `userSender`: Sender name
- `msg`: Message content

### 3. Send OTP Free (Alternative)
```
POST https://www.msegat.com/gw/senOTPFree.php
```
**Parameters:**
- `userName`: Your Msegat username
- `apiKey`: Your API key
- `numbers`: Phone number (966xxxxxxxxx)
- `userSender`: Sender name

### 4. Verify OTP Code
```
POST https://www.msegat.com/gw/verifyOTPCode.php
```
**Parameters:**
- `userName`: Your Msegat username
- `apiKey`: Your API key
- `id`: OTP ID from sendOTPFree
- `code`: Code to verify

## Phone Number Format

Phone numbers must be in international format without the `+` sign:
- ✅ Correct: `966501234567`
- ❌ Incorrect: `+966501234567`
- ❌ Incorrect: `0501234567`

The service automatically formats phone numbers:
- Removes spaces, dashes, and plus signs
- Adds `966` prefix if missing (Saudi Arabia)
- Replaces leading `0` with `966`

## Usage Examples

### Sending OTP
```php
use App\Services\MsegatService;

$msegatService = app(MsegatService::class);
$otp = $msegatService->generateOtpCode(); // Generates 6-digit code

$result = $msegatService->sendOtpCode('966501234567', $otp);

if ($result['success']) {
    // OTP sent successfully
    $messageId = $result['msg_id'];
} else {
    // Handle error
    $error = $result['message'];
}
```

### Sending Booking Notification
```php
use App\Models\Customer;
use App\Notifications\BookingConfirmed;

$customer = Customer::find(1);
$booking = $customer->bookings()->first();

// This will automatically send via SMS if customer has phone number
$customer->notify(new BookingConfirmed($booking));
```

### Sending Custom SMS
```php
use App\Services\MsegatService;

$msegatService = app(MsegatService::class);

$result = $msegatService->sendSms(
    '966501234567',
    'مرحباً! هذه رسالة تجريبية من Bookify'
);

if ($result['success']) {
    echo "SMS sent! Message ID: " . $result['msg_id'];
}
```

## SMS Message Templates

### Booking Confirmed (Arabic)
```
مرحباً {customer_name}، تم تأكيد حجزك
الخدمة: {service_name}
التاريخ: {date}
الوقت: {time}
رمز الحجز: {reference_code}
```

### Booking Cancelled (Arabic)
```
مرحباً {customer_name}، تم إلغاء حجزك
الخدمة: {service_name}
التاريخ: {date}
الوقت: {time}
رمز الحجز: {reference_code}
```

## Error Handling

The service includes comprehensive error handling:

1. **Logging**: All API calls are logged to Laravel logs
2. **Graceful Degradation**: If SMS fails, the application continues to work
3. **Error Messages**: Clear error messages returned from API

### Common Error Codes

- `M0000`: Success
- `M0001`: Authentication failed
- `M0002`: Insufficient balance
- `M0003`: Invalid phone number
- `M0004`: Invalid sender name

## Testing

### Test SMS from Admin Panel

1. Go to **Settings** → **SMS Settings (Msegat)**
2. Scroll to **Test SMS** section
3. Enter a phone number (e.g., `966501234567`)
4. Enter a test message
5. Click **Send Test SMS**
6. Check the notification for success/failure

### Test OTP Flow

1. Log out from customer account
2. Go to customer login page
3. Enter phone number
4. Check your phone for OTP SMS
5. Enter the OTP code
6. Verify successful login

## Security Considerations

1. **API Key Protection**: API key is stored in `.env` file (not in version control)
2. **OTP Expiration**: OTP codes expire after 5 minutes
3. **One-time Use**: OTP codes are cleared after successful verification
4. **Hashed Storage**: OTP codes are hashed in database

## Troubleshooting

### SMS Not Received

1. Check Msegat account balance
2. Verify credentials in admin panel
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify phone number format
5. Test with **Send Test SMS** feature

### OTP Not Working

1. Check if OTP expired (5-minute limit)
2. Verify SMS was sent (check logs)
3. Ensure phone number is correct
4. Try requesting new OTP

### Configuration Issues

1. Clear config cache: `php artisan config:clear`
2. Verify `.env` file has correct values
3. Check file permissions on `.env`
4. Restart application server

## API Documentation

For complete API documentation, visit:
**https://msegat.docs.apiary.io/**

## Support

For Msegat API support:
- Website: https://www.msegat.com
- Documentation: https://msegat.docs.apiary.io/

For Bookify integration support:
- Check Laravel logs
- Review this documentation
- Contact your development team

## Future Enhancements

Possible future improvements:

1. **SMS Templates**: Admin-configurable message templates
2. **Multi-language**: Support for English SMS messages
3. **SMS History**: Track all sent SMS in database
4. **Balance Monitoring**: Check Msegat account balance
5. **Delivery Reports**: Track SMS delivery status
6. **Scheduled SMS**: Send reminder SMS before appointments
7. **Bulk SMS**: Send promotional messages to customers

## Changelog

### Version 1.0.0 (2025-11-30)
- Initial integration with Msegat API
- OTP authentication via SMS
- Booking confirmation/cancellation SMS
- Admin panel settings page
- Test SMS functionality
- Comprehensive documentation
