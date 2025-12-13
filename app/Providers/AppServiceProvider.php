<?php

namespace App\Providers;

use App\Exceptions\Handler as ExceptionHandlerImplementation;
use App\Helpers\ActivityLogHelper;
use App\Http\ViewComposers\LanguageComposer;
use App\Models\Booking;
use App\Observers\BookingObserver;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExceptionHandler::class, ExceptionHandlerImplementation::class);
        
        // Register activity log helper
        require_once app_path('Helpers/ActivityLogHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Booking::observe(BookingObserver::class);
        
        // Register the language composer for all views
        View::composer('*', LanguageComposer::class);
        
        // Register asset versioning directive for cache busting
        Blade::directive('assetVersion', function ($expression) {
            // Get version from file or use timestamp as fallback
            $versionFile = storage_path('app/version.txt');
            $version = file_exists($versionFile) ? trim(file_get_contents($versionFile)) : time();
            return "<?php echo asset($expression) . '?v=' . '$version'; ?>";
        });
    }
}