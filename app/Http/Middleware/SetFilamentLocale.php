<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetFilamentLocale
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
        // Check if this is a Livewire request with locale change
        if ($request->is('livewire/*') && $request->has('components')) {
            $components = $request->input('components', []);
            foreach ($components as $component) {
                if (isset($component['updates']) && is_array($component['updates'])) {
                    foreach ($component['updates'] as $update) {
                        // Check if locale is being updated
                        if (isset($update['payload']['value']) && in_array($update['payload']['value'], ['ar', 'en'])) {
                            $locale = $update['payload']['value'];
                            Session::put('locale', $locale);
                            App::setLocale($locale);
                            
                            // Log for debugging
                            $logFile = public_path('filament-locale-change.log');
                            @file_put_contents($logFile, date('Y-m-d H:i:s') . " | Locale changed to: " . $locale . "\n", FILE_APPEND);
                        }
                    }
                }
            }
        }
        
        // Set the locale for Filament requests
        if ($request->is('admin*')) {
            $locale = Session::get('locale', config('app.locale', 'ar'));
            if (in_array($locale, ['ar', 'en'])) {
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}