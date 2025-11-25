<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $locale = $request->route('locale') ?? app()->getLocale();
        return $request->expectsJson() ? null : route('customer.login', ['locale' => $locale]);
    }
}