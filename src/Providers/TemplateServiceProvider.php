<?php

namespace Pishgaman\Pishgaman\Providers;

use Illuminate\Support\ServiceProvider;
use Pishgaman\Pishgaman\Library\Theme\ThemeManager;
use Pishgaman\Pishgaman\Library\Theme\ThemeStrategies\OtherThemeStrategy;
class TemplateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register services if needed
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $otherStrategy = new OtherThemeStrategy();
        $themeManager = new ThemeManager($otherStrategy);
        $template = $themeManager->getTheme('Admin');
        view()->share('Template', $template);
        $UserTemplate = $themeManager->getTheme('user');
        view()->share('UserTemplate', $UserTemplate);
    }
}
