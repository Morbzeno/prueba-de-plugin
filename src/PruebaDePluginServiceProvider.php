<?php

namespace Morbzeno\PruebaDePlugin;

use Illuminate\Support\Facades\Route;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Morbzeno\PruebaDePlugin\Commands\PruebaDePluginCommand;
use Morbzeno\PruebaDePlugin\Testing\TestsPruebaDePlugin;
use Morbzeno\PruebaDePlugin\Filament\Resources\RoleResource;
use Morbzeno\PruebaDePlugin\Filament\Resources\PermissionResource;
use Filament\Facades\Filament;


class PruebaDePluginServiceProvider extends PackageServiceProvider
{
    public static string $name = 'prueba-de-plugin';

    public static string $viewNamespace = 'prueba-de-plugin';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('morbzeno/prueba-de-plugin');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations();
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/prueba-de-plugin/{$file->getFilename()}"),
                ], 'prueba-de-plugin-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsPruebaDePlugin);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'morbzeno/prueba-de-plugin';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('prueba-de-plugin', __DIR__ . '/../resources/dist/components/prueba-de-plugin.js'),
            Css::make('prueba-de-plugin-styles', __DIR__ . '/../resources/dist/prueba-de-plugin.css'),
            Js::make('prueba-de-plugin-scripts', __DIR__ . '/../resources/dist/prueba-de-plugin.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            PruebaDePluginCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_prueba-de-plugin_table',
        ];
    }
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerResources([
                RoleResource::class,
            ]);
        });

        Filament::serving(function () {
            Filament::registerResources([
                PermissionResource::class,
            ]);
        });
        
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
            __DIR__.'/../database/seeders/' => database_path('seeders'),
            __DIR__.'/../database/factories/' => database_path('factories'),
            __DIR__.'/../tests' => base_path('tests/'),
            __DIR__.'/../app/Mail' => app_path('mail'),
            __DIR__ . '/../resources/views' => resource_path('views/'),
            __DIR__.'/../app/Http/Controllers' => app_path('Http/Controllers'),
        ], 'prueba-de-plugin-morbzeno');
    
        $this->registerRoutes();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'prueba-de-plugin');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'prueba-de-plugin');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
    protected function registerRoutes()
    {
        Route::middleware('web') 
            ->group(__DIR__ . '/../routes/web.php'); 
    }
}
