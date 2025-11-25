<?php

namespace App\Filament\Pages\Components;

use Filament\Actions\Action;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(fn () => strtoupper(App::getLocale()))
            ->icon('heroicon-o-language')
            ->color('secondary')
            ->tooltip('Switch Language')
            ->action(function () {
                $currentLocale = App::getLocale();
                $newLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                
                // Set the new locale
                App::setLocale($newLocale);
                
                // Store in session
                Session::put('locale', $newLocale);
                
                // Redirect to refresh the page with new locale
                return redirect()->back();
            });
    }

    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'language-switcher');
    }
}