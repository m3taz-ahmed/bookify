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
        // DEBUG LOGGING
        $logFile = public_path('lang-switch-debug.log');
        $debug = "\n=== LANGUAGE SWITCH DEBUG ===\n";
        $debug .= date('Y-m-d H:i:s') . "\n";
        $debug .= "Locale: " . $locale . "\n";
        $debug .= "Referrer: " . ($request->headers->get('referer') ?? 'NULL') . "\n";
        $debug .= "Previous URL: " . url()->previous() . "\n";
        $debug .= "APP_URL: " . config('app.url') . "\n";
        @file_put_contents($logFile, $debug, FILE_APPEND);
        
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
            $adminBaseUrl = rtrim(config('app.url'), '/') . '/admin';
            
            // Get the current admin path (if any)
            $adminPath = '';
            if (preg_match('#/admin(.*)#', $referrer, $matches)) {
                $adminPath = $matches[1];
            }
            
            $redirectUrl = $adminBaseUrl . $adminPath;
            $debug .= "DECISION: Redirecting to admin: " . $redirectUrl . "\n";
            @file_put_contents($logFile, $debug, FILE_APPEND);
            
            return redirect($redirectUrl);
        } else {
            // For regular site requests, redirect back to the same page
            $previousUrl = url()->previous();
            
            // If previous URL is null or empty, redirect to home
            if (empty($previousUrl)) {
                $debug .= "DECISION: Redirecting to home (no previous URL)\n";
                @file_put_contents($logFile, $debug, FILE_APPEND);
                return redirect()->route('home');
            }
            
            // Check if the user came from a customer authenticated page
            if ($referrer && (strpos($referrer, '/customer/') !== false)) {
                // If the user is authenticated as a customer, allow the redirect
                if (Auth::guard('customer')->check()) {
                    $debug .= "DECISION: Redirecting to previous (customer authenticated): " . $previousUrl . "\n";
                    @file_put_contents($logFile, $debug, FILE_APPEND);
                    return redirect($previousUrl);
                } else {
                    // If not authenticated, redirect to the login page
                    $debug .= "DECISION: Redirecting to customer login (not authenticated)\n";
                    @file_put_contents($logFile, $debug, FILE_APPEND);
                    return redirect()->route('customer.login');
                }
            }
            
            // For all other cases, redirect back to the previous page
            $debug .= "DECISION: Redirecting to previous: " . $previousUrl . "\n";
            @file_put_contents($logFile, $debug, FILE_APPEND);
            return redirect($previousUrl);
        }
    }
}