<?php

namespace Morbzeno\PruebaDePlugin;

use Filament\Contracts\Plugin;
use Filament\Panel;

class PruebaDePluginPlugin implements Plugin
{
    public function getId(): string
    {
        return 'prueba-de-plugin';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources(config('prueba-de-plugin.resources', []));
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
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
