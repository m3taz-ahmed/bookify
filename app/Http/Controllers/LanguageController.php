<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

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
        // Validate the locale
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = config('app.locale', 'ar');
        }
        
        // Set the application locale
        App::setLocale($locale);
        
        // Store the locale in session
        session(['locale' => $locale]);
        
        // Check if this is a Filament request (contains /admin in the referrer)
        $referrer = $request->headers->get('referer');
        
        if ($referrer && strpos($referrer, '/admin') !== false) {
            // For Filament requests, redirect back to the admin panel
            // $adminBaseUrl = config('app.url') . '/admin';
            $adminBaseUrl = rtrim(config('app.url'), '/') . '/admin';
            
            // Get the current admin path (if any)
            $adminPath = '';
            if (preg_match('#/admin(.*)#', $referrer, $matches)) {
                $adminPath = $matches[1];
            }
            
            $redirectUrl = $adminBaseUrl . $adminPath;
            return redirect($redirectUrl);
        } else {
            // For regular site requests, redirect back to the same page
            $previousUrl = url()->previous();
            
            // If previous URL is null or empty, redirect to home
            if (empty($previousUrl)) {
                return redirect()->route('home');
            }
            
            // Check if the user came from a customer authenticated page
            if ($referrer && (strpos($referrer, '/customer/') !== false)) {
                // If the user is authenticated as a customer, allow the redirect
                if (Auth::guard('customer')->check()) {
                    return redirect($previousUrl);
                } else {
                    // If not authenticated, redirect to the login page
                    return redirect()->route('customer.login');
                }
            }
            
            // For all other cases, redirect back to the previous page
            return redirect($previousUrl);
        }
    }
}