<?php

namespace Saman9074\Quickstart;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File; // Added
use Illuminate\Support\Facades\Config; // Added
use Saman9074\Quickstart\Commands\InstallCommand;

class QuickstartServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $installedFlagPath = storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag'));

        // If the installed flag file exists, do nothing in the register method.
        if (File::exists($installedFlagPath)) {
            return;
        }

        // Merge package configuration
        $this->mergeConfigFrom(
            __DIR__.'/../config/quickstart.php', 'quickstart'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $installedFlagPath = storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag'));

        // If the installed flag file exists, do nothing in the boot method.
        // This effectively disables the installer's routes, views, commands, etc.
        if (File::exists($installedFlagPath)) {
            return;
        }

        // Load package routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Load package views
        // Ensure your views are in resources/views and referenced like: view('quickstart::installer.themes.default.steps.welcome')
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'quickstart');

        // Load package translations
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'quickstart');

        // Register package commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }

        // Define publishable assets
        if ($this->app->runningInConsole()) {
            // Publish config file
            $this->publishes([
                __DIR__.'/../config/quickstart.php' => config_path('quickstart.php'),
            ], 'quickstart-config');

            // Publish views
            $this->publishes([
                __DIR__.'/../resources/views/installer' => resource_path('views/vendor/quickstart/installer'),
            ], 'quickstart-views');

            // Publish language files
            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->langPath('vendor/quickstart'),
            ], 'quickstart-lang');

            // Example for publishing assets (e.g., CSS, JS for themes if not using CDN)
            /*
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/quickstart'),
            ], 'quickstart-assets');
            */
        }
    }
}
