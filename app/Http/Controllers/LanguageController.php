<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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
        if (in_array($locale, ['ar', 'en'])) {
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
        }

        // Redirect back to the previous page
        return redirect()->back();
    }
}