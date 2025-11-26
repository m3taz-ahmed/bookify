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
        // Get locale from URL route parameter
        $locale = $request->route('locale') ?? config('app.locale', 'ar');
        
        // Validate locale is one of the supported values
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = config('app.locale', 'ar');
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Also store in session if it's not already there or different
        if (Session::has('locale') && Session::get('locale') !== $locale) {
            Session::put('locale', $locale);
        } elseif (!Session::has('locale')) {
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}