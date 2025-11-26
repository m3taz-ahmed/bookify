<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LanguageSwitcherServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register the language switcher component in the header
        FilamentView::registerRenderHook(
            'panels::global-search.before',
            function () {
                if (!Auth::check()) {
                    return '';
                }
                
                $currentLocale = app()->getLocale();
                $switchLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                $switchLabel = strtoupper($switchLocale);
                
                // Get the current URL
                $currentUrl = url()->current();
                $baseUrl = config('app.url');
                
                // Remove the base URL to get the path
                $path = str_replace($baseUrl, '', $currentUrl);
                
                // Remove leading slash if present
                $path = ltrim($path, '/');
                
                // Split the path into parts
                $pathParts = explode('/', $path);
                
                // Check if we're in the admin panel (look for 'admin' in the path)
                $adminIndex = array_search('admin', $pathParts);
                
                if ($adminIndex !== false) {
                    // We're in the admin panel - Filament doesn't support locale prefixes
                    // So we remove any locale prefix and redirect to the clean admin URL
                    // But we still need to switch the app locale for the session
                    app()->setLocale($switchLocale);
                    
                    // For Filament, we redirect to the clean admin URL without locale prefix
                    $switchedUrl = $baseUrl . '/admin';
                    
                    // Add any remaining path after 'admin'
                    $adminPathParts = array_slice($pathParts, $adminIndex + 1);
                    if (!empty($adminPathParts)) {
                        $switchedUrl .= '/' . implode('/', $adminPathParts);
                    }
                } else {
                    // Not in admin panel, handle regular URLs
                    // If the first part is a locale, replace it
                    if (isset($pathParts[0]) && in_array($pathParts[0], ['ar', 'en'])) {
                        $pathParts[0] = $switchLocale;
                    } else {
                        // If no locale in path, prepend the switch locale
                        array_unshift($pathParts, $switchLocale);
                    }
                    
                    // Reconstruct the path
                    $switchedPath = implode('/', $pathParts);
                    
                    // Build the full URL
                    $switchedUrl = $baseUrl . '/' . $switchedPath;
                }
                
                return Blade::render('
                    <div class="flex items-center justify-center mr-4">
                        <a href="' . $switchedUrl . '" 
                           class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ring-offset-background bg-primary text-primary-foreground hover:bg-primary/90 h-10 py-2 px-4">
                            ' . $switchLabel . '
                        </a>
                    </div>
                ');
            }
        );
    }
}