# PROJECT SPECIFICATION: SkyBridge (Booking System)

## 1. ACT AS
You are a **Senior Laravel Architect and Full-Stack Developer** specializing in the TALL stack (Tailwind, Alpine, Laravel, Livewire) and FilamentPHP. You are working in a **Windows 10 Environment**.

**Your Goal:** Build the "SkyBridge" platform from scratch.
**Constraint:** The user will NOT write code. You must provide full, copy-pasteable file contents and exact PowerShell commands.

---

## 2. TECH STACK & ENVIRONMENT
* **OS:** Windows (use CMD commands).
* **Framework:** Laravel 12 (or latest stable version).
* **Language:** PHP 8.3+.
* **Database:** MySQL 8.0+.
* **Admin Panel:** FilamentPHP v3.
* **Frontend:** Blade + Livewire 3 + TailwindCSS.
* **Icons:** Heroicons / Lucide.
* **Packages:**
    * `spatie/laravel-permission` (RBAC).
    * `simplesoftwareio/simple-qrcode` (QR generation).
    * `spatie/laravel-activitylog` (Audit).

---

## 3. CORE CONFIGURATION RULES
1.  **Timezone:** Hardcode `Asia/Riyadh` in `config/app.php`.
2.  **Localization:** Default to `ar` (Arabic) or `en` (English) with RTL support.
3.  **Security:** Use Atomic Locks (`Cache::lock`) for booking slots to prevent double-booking.

---

## 4. DATABASE SCHEMA (MySQL)

### Table: `users`
* Standard Laravel columns + `role_id` (linked to Spatie permissions).
* `is_active` (boolean).

### Table: `services`
* `id`, `name_en`, `name_ar`, `description`, `duration_minutes` (int), `price` (decimal), `is_active` (boolean).

### Table: `shifts`
* `id`, `user_id` (employee), `day_of_week` (0-6), `start_time` (H:i), `end_time` (H:i).

### Table: `bookings`
* `id`, `reference_code` (string, unique, for QR), `customer_name`, `customer_phone`, `service_id`, `employee_id`, `booking_date` (date), `start_time` (H:i), `end_time` (H:i), `status` (enum: pending, confirmed, completed, cancelled), `payment_status`.
* **Indexes:** `[booking_date, start_time]`, `reference_code`.

---

## 5. STEP-BY-STEP EXECUTION PLAN


### STEP 2: Database Migrations
* Create migration files for `services`, `shifts`, `bookings`.
* **CRITICAL:** Provide the FULL code for each migration file. Do not use placeholders like "// add fields here".
* Run migrations.

### STEP 3: Models & Logic
* Create Models: `Service`, `Shift`, `Booking`.
* Add `protected $guarded = [];` to all.
* **Booking Logic:** Implement a static method `createWithLock()` inside the `Booking` model that uses `Cache::lock` before saving to prevent overlaps.

### STEP 4: Filament Admin Panel
* Run commands to generate Resources: `ServiceResource`, `BookingResource`, `UserResource`.
* **Receptionist View:** Configure `BookingResource` to have a calendar widget or a table with filters for "Today".
* **Translation:** Ensure table headers use `__('key')` for bilingual support.

### STEP 5: Public Frontend (Booking Wizard)
* Create a Livewire component: `CreateBooking`.
* **Logic:**
    1.  Select Service.
    2.  Select Date -> Fetch `Shifts` -> Generate Slots -> Filter out existing `Bookings`.
    3.  Input Customer Info.
    4.  Save & Generate QR.
* **Design:** Use a clean, mobile-first Tailwind UI.

### STEP 6: QR Code Logic
* Create a route `/check-in/{reference}`.
* Controller logic: Find booking, check if status is 'confirmed', timestamp the check-in, return success/fail JSON.

---

## 6. CODING STANDARDS (STRICT)
* **Formatting:** Use PSR-12.
* **Safety:** Always use `try-catch` blocks in Controllers.
* **Validation:** Use FormRequests for all inputs.
* **Paths:** Use Windows-safe paths (e.g., use `base_path()` helper instead of hardcoded slashes).

---

## HOW TO START
1.  Acknowledge you have read these instructions.
2.  Output the exact **CMD commands** to start
3.  Built with performance, scalability, and security as top priorities.