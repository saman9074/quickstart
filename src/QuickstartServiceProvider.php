<?php

namespace Saman9074\Quickstart;

use Illuminate\Support\ServiceProvider;
use Saman9074\Quickstart\Commands\InstallCommand; // This line will be added later for command registration

class QuickstartServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // In this method, services and classes are usually bound to the Service Container.
        // For example, if your package has specific classes you want to be accessible via Dependency Injection.

        // Merge the package's default config file with the user's published config file.
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
        // The boot method is called after all other service providers have been registered.
        // This is the best place to load and register the following:

        // 1. Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class, // This line will be uncommented later for command registration
            ]);
        }

        // 2. Load routes (if your package has web or API routes)
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // 3. Load views
        // Path to your package's view files
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'quickstart');
        // 'quickstart' is the namespace used to access package views (e.g., view('quickstart::installer.index'))

        // 4. Load translation files
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'quickstart');
        // Usage: __('quickstart::installer.welcome')

        // 5. Define publishable assets
        // This allows users to copy config files, views, migrations, etc., to their main application.

        // Publish config file
        $this->publishes([
            __DIR__.'/../config/quickstart.php' => config_path('quickstart.php'),
        ], 'quickstart-config'); // 'quickstart-config' tag for group publishing

        $this->publishes([
            __DIR__.'/../resources/lang' => lang_path('vendor/quickstart'),
        ], 'quickstart-lang'); // تگ برای انتشار گروهی

        // Publish views (example)
        /*
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/quickstart'),
        ], 'quickstart-views');
        */

        // Publish language files (example)
        /*
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/quickstart'),
        ], 'quickstart-lang');
        */

        // Publish Assets (example)
        /*
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/quickstart'),
        ], 'quickstart-assets');
        */
    }
}
