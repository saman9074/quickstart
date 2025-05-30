<?php

namespace Saman9074\Quickstart;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
// use Illuminate\Support\Facades\Route; // اگر در این فایل مستقیماً استفاده نمی‌شود، لازم نیست
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
        // فایل کانفیگ پکیج همیشه باید merge شود تا مقادیری مانند installed_flag_file در دسترس باشند
        $this->mergeConfigFrom(
            __DIR__.'/../config/quickstart.php', 'quickstart'
        );

        $installedFlagPath = storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag'));

        // تنظیمات سشن فقط زمانی که برنامه نصب نشده است، بازنویسی شوند
        if (!File::exists($installedFlagPath)) {
            Config::set('session.driver', 'file');
            $cookieName = Config::get('quickstart.installer_session_cookie', 'quickstart_installer_session');
            Config::set('session.cookie', $cookieName);
            Config::set('session.expire_on_close', true);
            Config::set('session.path', '/');
            Config::set('session.http_only', true);

            $secureCookie = Config::get('session.secure', false);
            if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1 || $_SERVER['HTTPS'] === '1')) {
                $secureCookie = true;
            } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
                $secureCookie = true;
            } elseif (strtolower(substr(Config::get('app.url', 'http://localhost'), 0, 5)) === 'https') {
                $secureCookie = true;
            }
            Config::set('session.secure', $secureCookie);
            Config::set('session.same_site', 'lax');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // مسیر ویوها و ترجمه‌ها همیشه باید بارگذاری شوند تا صفحه "پایان نصب"
        // و سایر ویوهای احتمالی پکیج (حتی پس از نصب) قابل دسترس باشند.
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'quickstart');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'quickstart');

        // موارد قابل انتشار (publishable) همیشه باید تعریف شوند چون فقط از طریق دستور Artisan اجرا می‌شوند.
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

        // روت‌ها و کامندهای نصب‌کننده فقط در صورتی بارگذاری می‌شوند که برنامه هنوز نصب نشده باشد.
        $installedFlagPath = storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag'));
        if (!File::exists($installedFlagPath)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

            if ($this->app->runningInConsole()) {
                $this->commands([
                    InstallCommand::class,
                ]);
            }
        }
        // اگر برنامه نصب شده باشد، روت‌ها و کامندهای نصب‌کننده بارگذاری نمی‌شوند
        // و میدل‌ویر RedirectIfInstalled نیز از دسترسی به روت‌های نصب‌کننده (حتی اگر به نحوی فعال بودند) جلوگیری می‌کند.
    }
}
