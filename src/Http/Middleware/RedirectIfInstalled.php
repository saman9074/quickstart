<?php

namespace Saman9074\Quickstart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config; // Import Config facade or use helper

class RedirectIfInstalled
{
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
        $isInstalled = File::exists($installedFlagPath);

        // Get the name of the current route
        $currentRouteName = $request->route()->getName();
        $finishRouteName = 'quickstart.install.finished'; // As defined in routes/web.php
        $welcomeRouteName = 'quickstart.install.welcome'; // As defined in routes/web.php

        if ($isInstalled) {
            // If installed and trying to access any installer route other than 'finished'
            if ($currentRouteName !== $finishRouteName) {
                // Redirect to the 'finished' page
                return Redirect::route($finishRouteName)->with('info', __('quickstart::installer.middleware_already_installed'));
            }
        } else {
            // If not installed, but trying to access the 'finished' page directly
            // (or any other page that is not the welcome/first step if you have more complex logic)
            if ($currentRouteName === $finishRouteName) {
                // Redirect to the first step of the installer
                return Redirect::route($welcomeRouteName)->with('warning', __('quickstart::installer.middleware_please_install_first'));
            }
        }

        return $next($request);
    }
}
