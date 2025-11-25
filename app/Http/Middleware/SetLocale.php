<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
        // Get locale from URL route parameter
        $locale = $request->route('locale') ?? config('app.locale', 'ar');
        
        // Validate locale is one of the supported values
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = config('app.locale', 'ar');
        }
        
        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}