# Page Customization Implementation Summary

## Overview
This implementation customizes the Page resources in Filament to handle different page types with specific requirements:
- About Us: Company information, history, mission/vision
- Contact Us: Contact form fields and Google Maps integration
- Other pages (Privacy Policy, Terms & Conditions, FAQ): Standard content fields

## Key Changes

### 1. Database Structure
- Added `type` column to `pages` table to categorize pages
- Added specialized fields for About Us and Contact Us pages:
  - About Us: company_name, founded_year, location, company_description, history
  - Contact Us: email, phone, whatsapp, address, latitude, longitude, map_zoom

### 2. Model Updates
- Added constants for page types in `App\Models\Page`
- Added helper method to get available page types
- Added scopes for querying by type

### 3. Form Customization
- Created `DynamicPageForm` that displays different fields based on page type
- Implemented conditional visibility for form sections
- Added specialized fields for each page type

### 4. Data Seeding
- Updated `PageSeeder` with sample data for all page types
- Included appropriate values for new fields

### 5. UI Improvements
- Updated Pages table to show page type badges
- Improved form organization with sections

## Page Types and Their Fields

### About Us
- Company Name (English/Arabic)
- Founded Year
- Location (English/Arabic)
- Company Description (English/Arabic)
- History (English/Arabic)

### Contact Us
- Email Address
- Phone Number
- WhatsApp Number
- Address (English/Arabic)
- Latitude/Longitude for Google Maps
- Map Zoom Level
- Contact Description (English/Arabic)

### Other Pages (Privacy Policy, Terms & Conditions, FAQ)
- Standard content fields (English/Arabic)

## Files Created/Modified

1. `app/Models/Page.php` - Added type constants and methods
2. `database/migrations/2025_12_03_000000_add_type_to_pages_table.php` - Migration for type column
3. `database/migrations/2025_12_03_000001_add_additional_fields_to_pages_table.php` - Migration for specialized fields
4. `database/seeders/PageSeeder.php` - Updated with sample data
5. `app/Filament/Resources/Pages/Schemas/DynamicPageForm.php` - Dynamic form implementation
6. `app/Filament/Resources/Pages/PageResource.php` - Updated to use dynamic form
7. `app/Filament/Resources/Pages/Tables/PagesTable.php` - Updated to show page type

## Usage Instructions

1. Navigate to the Pages section in Filament
2. Create a new page or edit an existing one
3. Select a page type from the dropdown
4. The form will dynamically update to show relevant fields
5. Fill in the appropriate information for that page type
6. Save the page

## Google Maps Integration

For Contact Us pages, the latitude and longitude fields can be used to display a Google Maps embed in the frontend. The map zoom level controls how close the map view is by default.

Coordinates for SkyBridge Tower in Riyadh, Saudi Arabia:
- Latitude: 24.7136
- Longitude: 46.6753