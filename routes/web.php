<?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Config;
    use Saman9074\Quickstart\Http\Controllers\InstallController;

    // میدل‌ویرهای مورد نیاز برای نصب‌کننده
    // شما باید namespace صحیح این میدل‌ویرها را بر اساس پروژه لاراولی که کاربر استفاده می‌کند، در نظر بگیرید
    // یا از کلاس‌های معادل در Illuminate استفاده کنید اگر در App نیستند.
    // برای سادگی، فرض می‌کنیم کاربر از ساختار پیش‌فرض لاراول استفاده می‌کند.
    // در یک پکیج واقعی، بهتر است این وابستگی‌ها را به حداقل برسانید یا روشی برای پیکربندی آن‌ها توسط کاربر فراهم کنید.

    $installerMiddlewareStack = [
        // ۱. میدل‌ویر شما برای تنظیم درایور سشن به 'file' و کوکی ایزوله
        \Saman9074\Quickstart\Http\Middleware\InstallerSessionSettings::class,

        // ۲. میدل‌ویرهای ضروری که معمولاً در گروه 'web' هستند
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, // یا App\Http\Middleware\VerifyCsrfToken::class
        \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // ۳. میدل‌ویرهای اختصاصی دیگر پکیج شما
        \Saman9074\Quickstart\Http\Middleware\SetInstallerLocale::class,
        \Saman9074\Quickstart\Http\Middleware\RedirectIfInstalled::class,
    ];

    Route::group([
        'prefix' => Config::get('quickstart.route_prefix', 'quickstart-install'),
        'as' => 'quickstart.install.',
        'middleware' => $installerMiddlewareStack
    ], function () {
        Route::get('/', [InstallController::class, 'showWelcome'])->name('welcome');
        Route::post('/set-locale', [InstallController::class, 'setLocale'])->name('setLocale');

        Route::get('/requirements', [InstallController::class, 'showRequirements'])->name('requirements');
        Route::post('/requirements', [InstallController::class, 'checkRequirements']);

        Route::get('/permissions', [InstallController::class, 'showPermissions'])->name('permissions');
        Route::post('/permissions', [InstallController::class, 'checkPermissions']);

        Route::get('/environment', [InstallController::class, 'showEnvironmentSetup'])->name('environment');
        Route::post('/environment', [InstallController::class, 'saveEnvironmentSetup']);

        Route::get('/finalize', [InstallController::class, 'showFinalize'])->name('finalize');
        Route::post('/finalize', [InstallController::class, 'runFinalizeTasks']);

        Route::get('/finished', [InstallController::class, 'showFinished'])->name('finished');
    });
    