<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(Request $request, $locale)
    {
        // Log the incoming request
        Log::info('Language switch request', [
            'requested_locale' => $locale,
            'current_locale' => App::getLocale(),
            'session_locale_before' => $request->session()->get('locale'),
            'session_active' => $request->hasSession() && $request->session()->isStarted()
        ]);
        
        // Validate the locale
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = config('app.locale', 'ar');
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Ensure session is started
        if (!$request->hasSession() || !$request->session()->isStarted()) {
            $request->session()->start();
            Log::info('Session started for language switch');
        }
        
        // Store the locale in session
        $request->session()->put('locale', $locale);
        $request->session()->save(); // Explicitly save the session
        
        // Log the change
        Log::info('Language switched and stored in session', [
            'new_locale' => $locale,
            'session_locale_after' => $request->session()->get('locale')
        ]);

        // Check if this is a Filament request (contains /admin in the referrer)
        $referrer = $request->headers->get('referer');
        
        if ($referrer && strpos($referrer, '/admin') !== false) {
            // For Filament requests, redirect back to the admin panel
            // But we need to ensure we're not using locale-prefixed URLs
            $adminBaseUrl = config('app.url') . '/admin';
            
            // Get the current admin path (if any)
            $adminPath = '';
            if (preg_match('#/admin(.*)#', $referrer, $matches)) {
                $adminPath = $matches[1];
            }
            
            $redirectUrl = $adminBaseUrl . $adminPath;
            return redirect($redirectUrl);
        } else {
            // For regular site requests, redirect back to the same page
            // We no longer use locale prefixes in URLs
            return redirect(url()->previous());
        }
    }
}