<?php

namespace Pishgaman\Pishgaman;

use Illuminate\Support\ServiceProvider;
use Pishgaman\Pishgaman\Library\Theme\ThemeManager;
use Pishgaman\Pishgaman\Library\Theme\ThemeStrategies;

class PishgamanServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'PishgamanView');

        // Load translations
        $this->loadTranslationsFrom(__DIR__.'/Resources/lang', 'PishgamanLang');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');

        // Publish configuration (if needed)
        $this->publishes([
            // __DIR__.'/config/PishgamanSMS.php' => config_path('PishgamanSMS.php'),
        ]);

        // Bind ThemeManager to ThemeStrategies
        $this->app->bind(ThemeManager::class, ThemeStrategies::class);
    }

    public function register()
    {
        // Register services if needed
    }
}
