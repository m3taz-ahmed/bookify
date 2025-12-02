<?php

namespace App\Filament\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Enums\ThemeMode;

class SkyBridgeThemePlugin implements Plugin
{
    public function getId(): string
    {
        return 'skybridge-theme';
    }

    public function register(Panel $panel): void
    {
        $panel->assets([
            Css::make('custom-filament-theme', resource_path('css/custom-filament-theme.css')),
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }
}