<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
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
                
                return Blade::render('
                    <div class="flex items-center justify-center mr-4">
                        <a href="' . route('lang.switch', $switchLocale) . '" 
                           class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none ring-offset-background bg-primary text-primary-foreground hover:bg-primary/90 h-10 py-2 px-4">
                            ' . $switchLabel . '
                        </a>
                    </div>
                ');
            }
        );
    }
}