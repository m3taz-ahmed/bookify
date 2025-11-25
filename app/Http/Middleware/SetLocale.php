<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

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
        // Log the locale setting process
        Log::info('SetLocale middleware executing', [
            'session_driver' => config('session.driver'),
            'session_has_locale' => $request->session()->has('locale'),
            'session_locale' => $request->session()->get('locale'),
            'session_id' => $request->hasSession() ? $request->session()->getId() : null,
            'session_started' => $request->hasSession() ? $request->session()->isStarted() : false,
            'app_locale_before' => App::getLocale()
        ]);
        
        // Check if locale is set in session
        if ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
            App::setLocale($locale);
            Log::info('Locale set from session', [
                'locale' => $locale,
                'session_all_data' => $request->session()->all()
            ]);
        } else {
            // Set default locale to Arabic
            App::setLocale('ar');
            
            // Ensure session is started before storing
            if ($request->hasSession() && !$request->session()->isStarted()) {
                $request->session()->start();
                Log::info('Session started in middleware');
            }
            
            // Store in session if session is available
            if ($request->hasSession() && $request->session()->isStarted()) {
                $request->session()->put('locale', 'ar');
                $request->session()->save(); // Explicitly save the session
                Log::info('Locale set to default (ar) and stored in session', [
                    'session_locale_after_put' => $request->session()->get('locale'),
                    'session_all_data' => $request->session()->all()
                ]);
            } else {
                Log::info('Locale set to default (ar) but session not available, not storing');
            }
        }
        
        Log::info('App locale after middleware', [
            'app_locale' => App::getLocale(),
            'final_session_locale' => $request->session()->get('locale')
        ]);

        return $next($request);
    }
}