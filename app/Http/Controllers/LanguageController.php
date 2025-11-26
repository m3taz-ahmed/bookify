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

        // Redirect to the same page with the switched locale
        // Get the previous URL
        $previousUrl = url()->previous();
        
        // Get the base URL
        $baseUrl = config('app.url');
        
        // Remove the base URL to get the path
        $path = str_replace($baseUrl, '', $previousUrl);
        
        // Remove leading slash if present
        $path = ltrim($path, '/');
        
        // Split the path into parts
        $pathParts = explode('/', $path);
        
        // If the first part is a locale, replace it
        if (isset($pathParts[0]) && in_array($pathParts[0], ['ar', 'en'])) {
            $pathParts[0] = $locale;
        } else {
            // If no locale in path, prepend the new locale
            array_unshift($pathParts, $locale);
        }
        
        // Reconstruct the path
        $switchedPath = implode('/', $pathParts);
        
        // Build the full URL with the switched locale
        $switchedUrl = $baseUrl . '/' . $switchedPath;
        
        // Ensure the URL is properly formatted
        if (strpos($switchedUrl, 'http') !== 0) {
            $switchedUrl = $baseUrl . '/' . ltrim($switchedUrl, '/');
        }
        
        // Redirect to the same page with the switched locale
        return redirect($switchedUrl);
    }
}