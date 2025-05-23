<?php

use Illuminate\Support\Facades\Route;
use Saman9074\Quickstart\Http\Controllers\InstallController; // We will create this controller next

/*
|--------------------------------------------------------------------------
| Quickstart Installer Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the QuickstartServiceProvider.
| They handle the web-based installation process.
|
*/

// Get the route prefix and middleware from the config file
$prefix = config('quickstart.route_prefix', 'quickstart-install');
$middleware = config('quickstart.route_middleware', ['web']);

Route::group(['prefix' => $prefix, 'as' => 'quickstart.install.', 'middleware' => $middleware], function () {

    // Route to show the initial welcome/start page or redirect to the first step
    Route::get('/', [InstallController::class, 'showWelcome'])->name('welcome');

    // Example routes for different steps based on the 'steps' config
    // We can make this more dynamic later or define each step explicitly.

    // Step 1: Server Requirements Check
    Route::get('/requirements', [InstallController::class, 'showRequirements'])->name('requirements');
    Route::post('/requirements', [InstallController::class, 'checkRequirements']);

    // Step 2: Folder Permissions Check
    Route::get('/permissions', [InstallController::class, 'showPermissions'])->name('permissions');
    Route::post('/permissions', [InstallController::class, 'checkPermissions']);

    // Step 3: Environment Configuration (.env setup)
    Route::get('/environment', [InstallController::class, 'showEnvironmentSetup'])->name('environment');
    Route::post('/environment', [InstallController::class, 'saveEnvironmentSetup']);

    // Step 4: Run final installation tasks (migrations, seeds, etc.)
    Route::get('/finalize', [InstallController::class, 'showFinalize'])->name('finalize');
    Route::post('/finalize', [InstallController::class, 'runFinalizeTasks']);

    // Step 5: Installation Finished Page
    Route::get('/finished', [InstallController::class, 'showFinished'])->name('finished');

    // A general route to handle steps dynamically based on a slug, if preferred
    // Route::get('/step/{stepSlug}', [InstallController::class, 'showStep'])->name('step');
    // Route::post('/step/{stepSlug}', [InstallController::class, 'processStep']);

    Route::post('/set-locale', [InstallController::class, 'setLocale'])->name('setLocale');

});
