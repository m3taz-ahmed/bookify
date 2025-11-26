<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if locale is stored in session (like Filament does)
        $locale = Session::get('locale');
        
        // If not in session, fallback to app default locale
        if (!$locale) {
            $locale = config('app.locale', 'ar');
        }
        
        // Validate locale is one of the supported values
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = config('app.locale', 'ar');
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Also store in session to ensure consistency
        Session::put('locale', $locale);

        return $next($request);
    }
}