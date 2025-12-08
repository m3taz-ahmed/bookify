<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
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
        
        // Check if this is a Filament request
        $referrer = $request->headers->get('referer');
        
        if ($referrer && strpos($referrer, '/admin') !== false) {
            $adminBaseUrl = rtrim(config('app.url'), '/') . '/admin';
            
            $adminPath = '';
            if (preg_match('#/admin(.*)#', $referrer, $matches)) {
                $adminPath = $matches[1];
            }
            
            return redirect($adminBaseUrl . $adminPath);
        }
        
        // For regular site requests
        $previousUrl = url()->previous();
        
        if (empty($previousUrl)) {
            return redirect()->route('home');
        }
        
        if ($referrer && strpos($referrer, '/customer/') !== false) {
            if (Auth::guard('customer')->check()) {
                return redirect($previousUrl);
            } else {
                return redirect()->route('customer.login');
            }
        }
        
        return redirect($previousUrl);
    }
}