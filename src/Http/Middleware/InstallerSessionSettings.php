<?php

namespace Saman9074\Quickstart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Contracts\Foundation\Application; // For app instance

class InstallerSessionSettings
{
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $installedFlagPath = storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag'));

        if (!File::exists($installedFlagPath)) {
            $newDriver = 'file';
            $newCookieName = Config::get('quickstart.installer_session_cookie', 'quickstart_installer_session');

            Config::set('session.driver', $newDriver);
            Config::set('session.cookie', $newCookieName);
            Config::set('session.expire_on_close', true);
            Config::set('session.path', '/');
            Config::set('session.http_only', true);
            Config::set('session.secure', $request->isSecure());
            Config::set('session.same_site', 'lax');

            // If the session manager has already been resolved,
            // try to force it to use the new default driver.
            if ($this->app->resolved('session')) {
                $sessionManager = $this->app['session'];
                $sessionManager->setDefaultDriver($newDriver); // Set the default driver on the manager

                // Forget the existing session store instance so it's recreated with the new driver
                // when StartSession middleware calls $request->session()
                $this->app->forgetInstance('session.store');
                $this->app->forgetInstance('cookie.jar'); // Also forget cookie jar to use new cookie name

                // Re-bind cookie jar with new config
                $this->app->singleton('cookie.jar', function ($app) {
                    return $app->make('cookie');
                });


            }
        }
        return $next($request);
    }
}
