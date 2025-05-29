<?php

namespace Saman9074\Quickstart;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
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
        $this->mergeConfigFrom(
            __DIR__.'/../config/quickstart.php', 'quickstart'
        );

        $installedFlagPath = storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag'));

        if (!File::exists($installedFlagPath)) {
            Config::set('session.driver', 'file');
            $cookieName = Config::get('quickstart.installer_session_cookie', 'quickstart_installer_session');
            Config::set('session.cookie', $cookieName);
            Config::set('session.expire_on_close', true);
            Config::set('session.path', '/');
            Config::set('session.http_only', true);

            // Determine if the request is secure
            $secureCookie = false; // Default for safety in register if request not fully available
            if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1 || $_SERVER['HTTPS'] === '1')) {
                $secureCookie = true;
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
                $secureCookie = true;
            } elseif (strtolower(substr(Config::get('app.url', 'http://localhost'), 0, 5)) === 'https') {
                $secureCookie = true;
            }
            Config::set('session.secure', $secureCookie);
            Config::set('session.same_site', 'lax');

            // Set session domain to null to allow current domain, or configure based on APP_URL
            // This is CRUCIAL to fix the cookie domain issue.
            $appUrl = Config::get('app.url', 'http://localhost');
            $parsedUrl = parse_url($appUrl);
            $host = $parsedUrl['host'] ?? null;

            // Only set a specific domain if APP_URL is properly configured and not localhost.
            // For 'localhost' or '127.0.0.1', domain should be null.
            // If running on a real domain, set it to that domain (or null to default to current host).
            // Setting to null is often safest as it defaults to the host making the request.
            Config::set('session.domain', null);
            // If you want to be more explicit for your domain (ensure APP_URL is correct in .env):
            // if ($host && !in_array($host, ['localhost', '127.0.0.1'])) {
            //    Config::set('session.domain', $host);
            // } else {
            //    Config::set('session.domain', null);
            // }
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $installedFlagPath = storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag'));

        if (!File::exists($installedFlagPath)) {
            $this->loadInstallerResources();
        }
    }

    /**
     * Load resources specific to the installer.
     */
    protected function loadInstallerResources()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'quickstart');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'quickstart');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/quickstart.php' => config_path('quickstart.php'),
            ], 'quickstart-config');

            $this->publishes([
                __DIR__.'/../resources/views/installer' => resource_path('views/vendor/quickstart/installer'),
            ], 'quickstart-views');

            $this->publishes([
                __DIR__.'/../resources/lang' => $this->app->langPath('vendor/quickstart'),
            ], 'quickstart-lang');
        }
    }
}
