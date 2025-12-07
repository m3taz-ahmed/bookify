# Hostinger hPanel Deployment Guide for Bookify
## Website: https://facilitiesservices.sa

---

## 📋 Pre-Deployment Checklist

### Local Preparation (Run these commands on your local machine):

```bash
# 1. Install production dependencies
composer install --optimize-autoloader --no-dev

# 2. Build frontend assets
npm run build

# 3. Clear and cache configuration (optional but recommended)
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📁 Step 1: Prepare Files for Upload

### 1.1 Copy Environment File
- Copy `.env.production` to `.env`
- Update the following variables with YOUR Hostinger credentials:
  ```env
  APP_KEY=base64:YOUR_APP_KEY_HERE
  DB_DATABASE=your_database_name
  DB_USERNAME=your_database_user
  DB_PASSWORD=your_database_password
  MAIL_USERNAME=noreply@facilitiesservices.sa
  MAIL_PASSWORD=your_email_password
  ```

### 1.2 Generate APP_KEY (if not already set)
```bash
php artisan key:generate
```
Copy the generated key to your `.env` file.

---

## 📤 Step 2: Upload to Hostinger

### Option A: Using File Manager (Recommended for beginners)

1. Login to Hostinger hPanel
2. Go to **File Manager**
3. Navigate to `public_html` folder
4. Upload the **entire `bookify` folder** (including all subfolders)

### Option B: Using FTP (Faster for large files)

1. Use FileZilla or similar FTP client
2. Connect using your Hostinger FTP credentials
3. Upload entire `bookify` folder to `public_html/`

**Final structure should be:**
```
public_html/
└── bookify/
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env
    └── ... other files
```

---

## 🔧 Step 3: Configure .htaccess Files

### 3.1 Root .htaccess File
**Location:** `public_html/.htaccess`

**Content:**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Redirect all requests to bookify/public folder
    RewriteCond %{REQUEST_URI} !^/bookify/public/
    RewriteRule ^(.*)$ /bookify/public/$1 [L,QSA]
</IfModule>
```

**How to create:**
1. In File Manager, navigate to `public_html/`
2. Create new file named `.htaccess`
3. Paste the content above
4. Save

### 3.2 Laravel .htaccess File
**Location:** `public_html/bookify/public/.htaccess`

This file should already exist from your upload. Verify it contains the Laravel rewrite rules.

---

## 🔐 Step 4: Set Permissions

Via File Manager, set these folder permissions to **755** or **775**:

1. Right-click on `bookify/storage` → Permissions → **775**
2. Right-click on `bookify/bootstrap/cache` → Permissions → **775**

All subfolders within `storage/` should also be **775**.

---

## 🗄️ Step 5: Configure Database

### 5.1 Create Database in Hostinger
1. In hPanel, go to **Databases** → **MySQL Databases**
2. Create a new database (e.g., `u123456789_bookify`)
3. Create a database user with a strong password
4. Assign user to database with ALL PRIVILEGES
5. Note down: database name, username, password

### 5.2 Update .env File
Navigate to `public_html/bookify/.env` and update:
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_bookify
DB_USERNAME=u123456789_bookify_user
DB_PASSWORD=your_strong_password
```

---

## 🚀 Step 6: Run Deployment Commands

### 6.1 Access Terminal/SSH
In hPanel, go to **Advanced** → **SSH Access** (or use terminal if available)

### 6.2 Navigate to Project
```bash
cd public_html/bookify
```

### 6.3 Run Laravel Commands
```bash
# Set correct PHP version (if needed)
# Check available PHP versions: php -v
# If needed, use: /usr/bin/php8.2 or similar

# Run migrations
php artisan migrate --force

# Install Shield permissions
php artisan shield:install --fresh

# Seed database (creates admin user and basic data)
php artisan db:seed

# Create storage link
php artisan storage:link

# Cache configuration for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ Step 7: Verify Deployment

### 7.1 Test URLs
- **Main site:** https://facilitiesservices.sa
- **Admin panel:** https://facilitiesservices.sa/admin
- **Customer area:** https://facilitiesservices.sa/customer/login

### 7.2 Default Admin Credentials
Check your `database/seeders/AdminUserSeeder.php` for default credentials.

Typically:
- Email: admin@bookify.com (or similar)
- Password: Check your seeder file

**IMPORTANT:** Change admin password immediately after first login!

---

## 🔄 Step 8: Post-Deployment (Optional but Recommended)

### 8.1 Set up Cron Jobs (for scheduled tasks)
In hPanel → **Advanced** → **Cron Jobs**

Add:
```bash
* * * * * cd /home/username/public_html/bookify && php artisan schedule:run >> /dev/null 2>&1
```

### 8.2 Enable HTTPS Redirect (Force SSL)
Add to `public_html/.htaccess` at the top:
```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## 🐛 Troubleshooting

### Issue: 500 Internal Server Error
**Solutions:**
1. Check file permissions (storage and bootstrap/cache must be 775)
2. Verify `.env` file exists and has correct database credentials
3. Check Laravel logs: `storage/logs/laravel.log`
4. Run: `php artisan config:clear`

### Issue: CSS/JS Not Loading
**Solutions:**
1. Verify files exist in `public_html/bookify/public/build/`
2. Check if you ran `npm run build` before upload
3. Clear browser cache
4. Verify `.htaccess` files are correct

### Issue: Database Connection Error
**Solutions:**
1. Verify database credentials in `.env`
2. Check if database user has correct privileges
3. Ensure DB_HOST is set to `localhost`

### Issue: Routes Not Working
**Solutions:**
1. Check both `.htaccess` files are in place
2. Run: `php artisan route:clear && php artisan route:cache`
3. Verify mod_rewrite is enabled on server

---

## 📞 Need Help?

1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode temporarily: Set `APP_DEBUG=true` in `.env`
3. Check Hostinger's PHP error logs in hPanel

---

## 🔒 Security Checklist

- [ ] Changed default admin password
- [ ] Set `APP_DEBUG=false` in production `.env`
- [ ] Set `SESSION_SECURE_COOKIE=true` for HTTPS
- [ ] Removed all test/debug routes from `routes/web.php`
- [ ] Set strong database password
- [ ] Enabled HTTPS redirect
- [ ] Set proper file permissions (never 777!)

---

## 📝 Notes

- **App URL:** https://facilitiesservices.sa
- **Server Structure:** `public_html/bookify/`
- **Public Folder:** `public_html/bookify/public/`
- **PHP Version:** Check Hostinger's supported versions (recommend 8.1+)
- **Database Type:** MySQL
- **Session Driver:** Database (not file-based)

---

**Deployment Date:** _______________
**Deployed By:** _______________
**Server PHP Version:** _______________
**Laravel Version:** _______________

---

Good luck with your deployment! 🚀
