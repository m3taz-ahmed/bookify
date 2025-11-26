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