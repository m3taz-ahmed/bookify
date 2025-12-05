# SkyBridge - Booking System

A comprehensive booking and appointment management system built with Laravel, Filament PHP, and Tailwind CSS.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.3+
- **Database:** MySQL 8.0+
- **Admin Panel:** FilamentPHP v3
- **Frontend:** Blade + Livewire 3 + Tailwind CSS 4
- **JavaScript:** Alpine.js
- **Icons:** Heroicons

## Features

### Core Features
- **Booking System:** Multi-step booking wizard with service selection, date/time picking
- **Customer Portal:** Login via OTP, view/manage bookings
- **Admin Dashboard:** Full Filament admin panel for managing services, bookings, customers
- **QR Check-in:** Generate QR codes for bookings, scan for check-in

### SMS Integration (Msegat)
- **OTP Authentication:** Real SMS OTP for customer login (replaces hardcoded codes)
- **Booking Notifications:** SMS confirmations and cancellations in Arabic
- **Configuration:** Admin panel settings page for SMS credentials

### Design Features
- **Dark Mode:** Full dark mode support with toggle
- **RTL Support:** Arabic language with proper RTL layout
- **Responsive:** Mobile-first design
- **PWA Ready:** Service worker and manifest for offline support

## Installation

### Prerequisites
- PHP 8.3+
- Composer
- Node.js & NPM
- MySQL 8.0+

### Setup

```bash
# Clone the repository
git clone <repository-url>
cd bookify

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env
# DB_DATABASE=bookify
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Build assets
npm run build

# Start development server
php artisan serve
```

### SMS Configuration (Msegat)

Add to your `.env` file:
```env
MSEGAT_USERNAME=your_username
MSEGAT_API_KEY=your_api_key
MSEGAT_SENDER=SkyBridge
MSEGAT_BASE_URL=https://www.msegat.com/gw
```

Then configure via Admin Panel → Settings → SMS Settings (Msegat)

## Development

```bash
# Development with hot reload
npm run dev

# Build for production
npm run build

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Project Structure

```
app/
├── Filament/           # Admin panel resources
├── Http/Controllers/   # Web controllers
├── Livewire/          # Livewire components
├── Models/            # Eloquent models
├── Notifications/     # Email & SMS notifications
└── Services/          # Business logic services

resources/
├── css/app.css        # Tailwind styles & dark mode
├── js/app.js          # Alpine.js & JavaScript
├── views/
│   ├── layouts/       # Main layout templates
│   ├── components/    # Blade components
│   ├── livewire/      # Livewire views
│   └── pages/         # Static pages
```

## Key Files

| File | Purpose |
|------|---------|
| `app/Services/MsegatService.php` | SMS API integration |
| `app/Livewire/CreateBooking.php` | Booking wizard component |
| `resources/css/app.css` | Tailwind config & dark mode |
| `resources/views/layouts/main.blade.php` | Main website layout |

## Configuration

### Timezone
Set in `config/app.php`: `'timezone' => 'Asia/Riyadh'`

### Localization
Default language: Arabic (`ar`) with English (`en`) support

### Dark Mode
Toggle via button in navigation. Preference saved in localStorage.

## Page Types

The system supports different page types:
- **About Us:** Company information, history, mission
- **Contact Us:** Contact details with Google Maps
- **General Pages:** Privacy Policy, Terms, FAQ

## Troubleshooting

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Rebuild Assets
```bash
npm run build
```

### SMS Not Working
1. Check Msegat credentials in admin panel
2. Verify phone number format (966xxxxxxxxx)
3. Check Laravel logs: `storage/logs/laravel.log`

## License

This project is proprietary software for SkyBridge.

---

Built with Laravel, FilamentPHP, and Tailwind CSS.
