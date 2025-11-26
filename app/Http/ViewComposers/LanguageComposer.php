<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Get the current locale from the application
        $currentLocale = App::getLocale();
        
        // Also check session for consistency
        if (Session::has('locale') && Session::get('locale') !== $currentLocale) {
            // If there's a mismatch, use the session locale
            $currentLocale = Session::get('locale');
            App::setLocale($currentLocale);
        }
        
        $view->with('currentLocale', $currentLocale);
    }
}