<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Blade;

class FilamentTranslationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set the locale for Filament based on session
        $this->setFilamentLocale();
        
        // Register a Blade directive to help with debugging
        Blade::directive('filamentLocale', function () {
            return "<?php echo app()->getLocale(); ?>";
        });
    }
    
    /**
     * Set the locale for Filament requests
     */
    protected function setFilamentLocale(): void
    {
        // Only set locale for Filament requests
        if (request()->is('admin*') || (request()->headers->get('referer') && strpos(request()->headers->get('referer'), '/admin') !== false)) {
            $locale = Session::get('locale', config('app.locale', 'ar'));
            if (in_array($locale, ['ar', 'en'])) {
                App::setLocale($locale);
            }
        }
    }
}