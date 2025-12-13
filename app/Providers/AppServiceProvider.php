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
    }
}