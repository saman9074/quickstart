<?php

namespace Saman9074\Quickstart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetInstallerLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('installer_locale')) {
            App::setLocale(Session::get('installer_locale'));
        } elseif (config('app.locale')) { // Fallback to app's default locale
             App::setLocale(config('app.locale'));
        }
        // You might also want to set a default for the installer if no session and no app default
        // else { App::setLocale('en'); }


        return $next($request);
    }
}