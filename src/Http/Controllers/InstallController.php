<?php

namespace Saman9074\Quickstart\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Ensure Log facade is imported
use Illuminate\Support\Facades\View as ViewFacade;


class InstallController extends Controller
{
    public function __construct()
    {
        // Middleware is now handled in the package's routes/web.php
        // using a custom middleware stack.
    }

    public function setLocale(Request $request)
    {
        $supportedLocales = array_keys(Config::get('quickstart.supported_locales', ['en' => 'English', 'fa' => 'Persian']));
        $request->validate([
            'locale' => 'required|string|in:' . implode(',', $supportedLocales),
        ]);
        session(['installer_locale' => $request->locale]);
        return Redirect::back();
    }

    public function showWelcome()
    {
        if ($this->isAlreadyInstalled()) {
            return Redirect::route('quickstart.install.finished');
        }
        $pageTitle = __(Config::get('quickstart.steps.welcome.title_key', 'quickstart::installer.step_welcome_title'));
        return $this->view('welcome', ['pageTitle' => $pageTitle]);
    }

    public function showRequirements()
    {
        if ($this->isAlreadyInstalled()) {
            return Redirect::route('quickstart.install.finished');
        }
        $phpVersion = phpversion();
        $requiredPhpVersion = Config::get('quickstart.required_php_version', '8.1.0');
        $phpVersionOk = version_compare($phpVersion, $requiredPhpVersion, '>=');

        $requiredExtensions = Config::get('quickstart.required_php_extensions', []);
        $loadedExtensions = get_loaded_extensions();
        $extensionsStatus = [];
        foreach ($requiredExtensions as $ext) {
            $extensionsStatus[$ext] = in_array($ext, $loadedExtensions);
        }
        $pageTitle = __(Config::get('quickstart.steps.requirements.title_key', 'quickstart::installer.step_requirements_title'));
        return $this->view('requirements', [
            'pageTitle' => $pageTitle,
            'phpVersion' => $phpVersion,
            'requiredPhpVersion' => $requiredPhpVersion,
            'phpVersionOk' => $phpVersionOk,
            'extensionsStatus' => $extensionsStatus,
        ]);
    }

    public function checkRequirements(Request $request)
    {
        return Redirect::route('quickstart.install.permissions');
    }

    public function showPermissions()
    {
        if ($this->isAlreadyInstalled()) {
            return Redirect::route('quickstart.install.finished');
        }
        $writableDirectories = Config::get('quickstart.writable_directories', []);
        $permissionsStatus = [];
        foreach ($writableDirectories as $dir) {
            $permissionsStatus[$dir] = is_writable(base_path($dir));
        }
        $pageTitle = __(Config::get('quickstart.steps.permissions.title_key', 'quickstart::installer.step_permissions_title'));
        return $this->view('permissions', [
            'pageTitle' => $pageTitle,
            'permissionsStatus' => $permissionsStatus,
        ]);
    }

    public function checkPermissions(Request $request)
    {
        return Redirect::route('quickstart.install.environment');
    }

    public function showEnvironmentSetup()
    {
        if ($this->isAlreadyInstalled()) {
            return Redirect::route('quickstart.install.finished');
        }
        $envFields = Config::get('quickstart.env_keys', []);
        $currentEnvValues = $this->getCurrentEnvValues(array_keys($envFields));
        $pageTitle = __(Config::get('quickstart.steps.environment.title_key', 'quickstart::installer.step_environment_title'));
        return $this->view('environment', [
            'pageTitle' => $pageTitle,
            'envFields' => $envFields,
            'currentEnvValues' => $currentEnvValues,
        ]);
    }

    public function saveEnvironmentSetup(Request $request)
    {
        $envFields = Config::get('quickstart.env_keys', []);
        $rules = [];
        $dbSettingsFromRequest = [];
        $dbRelatedKeys = ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];

        foreach ($envFields as $key => $field) {
            if (isset($field['rules'])) {
                $rules[$key] = $field['rules'];
            }
            if (in_array($key, $dbRelatedKeys) && $request->has($key)) {
                $dbSettingsFromRequest[$key] = $request->input($key);
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $testConnectionName = 'quickstart_db_test_'.uniqid();
        try {
            $databaseName = $dbSettingsFromRequest['DB_DATABASE'] ?? null;
            $dbDriver = strtolower($dbSettingsFromRequest['DB_CONNECTION'] ?? 'mysql');

            if (empty($databaseName)) {
                 throw new \Exception(__('quickstart::installer.db_name_required_for_test'));
            }

            $testConnectionConfig = [
                'driver'    => $dbDriver,
                'host'      => $dbSettingsFromRequest['DB_HOST'] ?? '127.0.0.1',
                'port'      => $dbSettingsFromRequest['DB_PORT'] ?? ($dbDriver === 'mysql' ? '3306' : ($dbDriver === 'pgsql' ? '5432' : null)),
                'database'  => $databaseName,
                'username'  => $dbSettingsFromRequest['DB_USERNAME'] ?? 'root',
                'password'  => $dbSettingsFromRequest['DB_PASSWORD'] ?? '',
                'charset'   => Config::get("database.connections.{$dbDriver}.charset", 'utf8mb4'),
                'collation' => Config::get("database.connections.{$dbDriver}.collation", 'utf8mb4_unicode_ci'),
                'prefix'    => '',
                'strict'    => true,
                'engine'    => null,
                'options'   => Config::get("database.connections.{$dbDriver}.options", []),
            ];
            if ($dbDriver === 'sqlite' && !File::isAbsolutePath($databaseName)) {
                 $testConnectionConfig['database'] = database_path($databaseName);
            }

            Config::set("database.connections.{$testConnectionName}", $testConnectionConfig);
            DB::purge($testConnectionName);
            $connection = DB::connection($testConnectionName);
            $connection->getPdo();

            if ($dbDriver === 'mysql') {
                $connection->statement("USE `{$databaseName}`");
            }
            elseif ($dbDriver === 'pgsql') {
                 $connection->select('SELECT 1');
            }

        } catch (\Exception $e) {
            Log::error("Quickstart Installer - DB Connection Test Failed (before .env save): " . $e->getMessage() . " | Attempted DB: " . ($databaseName ?? 'N/A'));
            $errorMessage = __('quickstart::installer.db_connection_test_failed_message');
            $exceptionMessageLower = strtolower($e->getMessage());
            $sqlErrorCode = null;

            if ($e instanceof \PDOException && isset($e->errorInfo[1])) {
                $sqlErrorCode = (string) $e->errorInfo[1];
            } elseif (method_exists($e, 'getCode') && is_numeric($e->getCode()) && $e->getCode() != 0) {
                 $sqlErrorCode = (string) $e->getCode();
            }

            if ($sqlErrorCode === '1049' || str_contains($exceptionMessageLower, 'unknown database')) {
                 $errorMessage = __('quickstart::installer.db_unknown_database_error', ['database' => $databaseName ?? '']);
            } elseif ($sqlErrorCode === '1045' || str_contains($exceptionMessageLower, 'access denied')) {
                 $errorMessage = __('quickstart::installer.db_access_denied_error');
            } elseif ($sqlErrorCode === '2002' || str_contains($exceptionMessageLower, 'no such file or directory') || str_contains($exceptionMessageLower, "can't connect to mysql server") || str_contains($exceptionMessageLower, "connection refused")) {
                 $errorMessage = __('quickstart::installer.db_server_connection_error');
            } elseif ($e->getMessage() === __('quickstart::installer.db_name_required_for_test')) {
                 $errorMessage = $e->getMessage();
            } else {
                 $errorMessage = __('quickstart::installer.db_connection_test_failed_message_detailed', ['error' => $e->getMessage()]);
            }

            return Redirect::back()
                ->withErrors(['db_connection_error' => $errorMessage])
                ->withInput($request->except('DB_PASSWORD'));
        } finally {
            Config::offsetUnset("database.connections.{$testConnectionName}");
        }

        try {
            $this->updateEnvFile($request->only(array_keys($rules)));
        } catch (\Exception $e) {
            $errorMessage = __('quickstart::installer.env_save_error') . ' (' . $e->getMessage() . ')';
            return Redirect::back()->withErrors(['env_save_error' => $errorMessage])->withInput();
        }

        return Redirect::route('quickstart.install.finalize');
    }


    public function showFinalize()
    {
        if ($this->isAlreadyInstalled()) {
            return Redirect::route('quickstart.install.finished');
        }
        $pageTitle = __(Config::get('quickstart.steps.finalize.title_key', 'quickstart::installer.step_finalize_title'));
        return $this->view('finalize', ['pageTitle' => $pageTitle]);
    }

    public function runFinalizeTasks(Request $request)
    {
        if ($this->isAlreadyInstalled()) {
            return Redirect::route('quickstart.install.finished')->with('warning', __('quickstart::installer.already_installed_warning'));
        }

        try {
            $connectionName = Config::get('database.default');
            DB::purge($connectionName); // Ensure fresh connection for migrations/seeds

            $postInstallCommands = Config::get('quickstart.post_install_commands', []);
            Log::info("Quickstart Installer: Starting post-installation commands.", ['commands' => $postInstallCommands]);

            foreach ($postInstallCommands as $command) {
                Log::info("Quickstart Installer: Attempting to run command '{$command}'");
                $exitCode = Artisan::call($command); // Execute the command
                $output = Artisan::output();      // Get the output of the command

                if ($exitCode === 0) {
                    Log::info("Quickstart Installer: Command '{$command}' executed successfully.", ['output' => $output]);
                } else {
                    Log::error("Quickstart Installer: Command '{$command}' failed with exit code {$exitCode}.", ['output' => $output]);
                    // Optionally, throw an exception to stop the process and show a generic error,
                    // or collect errors and display them. For now, we log and continue.
                    // throw new \Exception("Command '{$command}' failed. See logs for details.");
                }
            }
            $this->createInstalledFlagFile();
            Log::info("Quickstart Installer: Post-installation commands completed and installed flag created.");

        } catch (\Exception $e) {
            Log::error("Quickstart Installer - Finalization Error: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Use the translated error message, but also append the specific command if possible
            $errorMessage = __('quickstart::installer.finalize_error') . ' (' . $e->getMessage() . ')';
            return Redirect::route('quickstart.install.finalize')
                           ->withErrors(['finalize_error' => $errorMessage]);
        }
        return Redirect::route('quickstart.install.finished');
    }

    public function showFinished()
    {
        if (!$this->isAlreadyInstalled() && !session('installation_just_completed')) {
            return Redirect::route('quickstart.install.welcome');
        }
        session()->forget('installation_just_completed');
        $pageTitle = __(Config::get('quickstart.steps.finished.title_key', 'quickstart::installer.step_finished_title'));
        return $this->view('finished', ['pageTitle' => $pageTitle]);
    }

    protected function isAlreadyInstalled(): bool
    {
        return File::exists(storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag')));
    }

    protected function createInstalledFlagFile(): void
    {
        $flagFileContent = __('quickstart::installer.installed_on_message') . now()->toDateTimeString();
        File::put(storage_path(Config::get('quickstart.installed_flag_file', 'installed.flag')), $flagFileContent);
        session(['installation_just_completed' => true]);
    }

    protected function getCurrentEnvValues(array $keys): array
    {
        $envPath = base_path('.env');
        $values = [];

        if (!File::exists($envPath)) {
            $envPath = base_path('.env.example');
            if (!File::exists($envPath)) {
                return array_fill_keys($keys, '');
            }
        }

        $content = File::get($envPath);
        foreach ($keys as $key) {
            if (preg_match("/^{$key}=(.*)$/m", $content, $matches)) {
                $value = trim($matches[1]);
                if (preg_match('/^([\'"])(.*)\1$/', $value, $quoteMatches)) {
                    $value = $quoteMatches[2];
                }
                $values[$key] = $value;
            } else {
                $values[$key] = Config::get('quickstart.env_keys.'.$key.'.default', '');
            }
        }
        return $values;
    }

    protected function updateEnvFile(array $data): void
    {
        $envPath = base_path('.env');

        if (!File::exists($envPath)) {
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), $envPath);
            } else {
                File::put($envPath, '');
            }
        }
        $content = File::get($envPath);
        foreach ($data as $key => $value) {
            $key = strtoupper($key);
            if (preg_match('/\s/', $value) && !in_array(strtolower($value), ['true', 'false', 'null', ''])) {
                $value = '"' . $value . '"';
            }
            if (preg_match("/^{$key}=/m", $content)) {
                $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
            } else {
                $content .= "\n{$key}={$value}";
            }
        }
        File::put($envPath, $content);
        Artisan::call('config:clear');
    }

    protected function view(string $viewNameSuffix, array $data = [])
    {
        $activeTheme = Config::get('quickstart.theme', 'default');
        $defaultTheme = 'default';

        $themeStepView = "installer.themes.{$activeTheme}.steps.{$viewNameSuffix}";
        $defaultStepView = "installer.themes.{$defaultTheme}.steps.{$viewNameSuffix}";
        $viewToRender = ViewFacade::exists("quickstart::{$themeStepView}") ? $themeStepView : $defaultStepView;

        $themeLayoutPath = "installer.themes.{$activeTheme}.layouts.main";
        $defaultLayoutPath = "installer.themes.{$defaultTheme}.layouts.main";
        $layoutPath = ViewFacade::exists("quickstart::{$themeLayoutPath}") ? $themeLayoutPath : $defaultLayoutPath;

        $stepsConfig = Config::get('quickstart.steps', []);
        $currentStepStringKey = null;
        foreach ($stepsConfig as $key => $details) {
            if (isset($details['view_suffix']) && $details['view_suffix'] === $viewNameSuffix) {
                $currentStepStringKey = $key;
                break;
            }
        }
        if ($currentStepStringKey === null && isset($stepsConfig[$viewNameSuffix])) {
            $currentStepStringKey = $viewNameSuffix;
        }

        $allSteps = [];
        if ($stepsConfig && is_array($stepsConfig)) {
           $allSteps = array_map(function($stepDetails, $stepKey) use ($activeTheme, $defaultTheme) {
               $titleKey = $stepDetails['title_key'] ?? ('quickstart::installer.step_' . $stepKey . '_title');
               return [
                   'key' => $stepKey,
                   'title' => __($titleKey),
                   'route' => route('quickstart.install.' . ($stepDetails['view_suffix'] ?? $stepKey)),
               ];
           }, $stepsConfig, array_keys($stepsConfig));
        }

        $currentStepNumericalIndex = false;
        if ($currentStepStringKey !== null) {
             $orderedStepKeys = array_keys($stepsConfig);
             $currentStepNumericalIndex = array_search($currentStepStringKey, $orderedStepKeys);
        }
        
        $pageTitleData = $data['pageTitle'] ?? '';
        if (empty($pageTitleData) && $currentStepStringKey !== null && isset($stepsConfig[$currentStepStringKey]['title_key'])) {
             $pageTitleData = __(Config::get('quickstart.steps.'.$currentStepStringKey.'.title_key', 'quickstart::installer.step_'.$currentStepStringKey.'_title'));
        } elseif (empty($pageTitleData) && $currentStepStringKey !== null && isset($stepsConfig[$currentStepStringKey])) {
             $pageTitleData = __( 'quickstart::installer.step_'.$currentStepStringKey.'_title');
        } elseif (empty($pageTitleData)) {
             $pageTitleData = __('quickstart::installer.default_page_title');
        }

        $viewData = array_merge($data, [
            'allSteps' => $allSteps,
            'currentStepKey' => $currentStepStringKey,
            'currentStepIndex' => $currentStepNumericalIndex,
            'pageTitle' => $pageTitleData,
            'active_theme' => $activeTheme,
            'layout_path' => 'quickstart::'.$layoutPath,
        ]);

        return view("quickstart::{$viewToRender}", $viewData);
    }
}
