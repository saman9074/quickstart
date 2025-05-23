<?php

namespace Saman9074\Quickstart\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quickstart:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application using the Quickstart installer (CLI)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting Quickstart Application Installer...');

        // Step 1: Check if already installed
        $installedFlag = storage_path(config('quickstart.installed_flag_file', 'installed.flag'));
        if (File::exists($installedFlag)) {
            $this->error('Application already installed. Remove the "' . config('quickstart.installed_flag_file', 'installed.flag') . '" file from storage to reinstall.');
            return Command::FAILURE;
        }

        // Step 2: Check PHP Version (Example)
        if (version_compare(PHP_VERSION, config('quickstart.required_php_version', '8.1.0'), '<')) {
            $this->error('PHP version ' . config('quickstart.required_php_version', '8.1.0') . ' or higher is required. You have ' . PHP_VERSION);
            return Command::FAILURE;
        }
        $this->info('PHP version check passed.');

        // Step 3: Check PHP Extensions (Example)
        $requiredExtensions = config('quickstart.required_php_extensions', []);
        $missingExtensions = [];
        foreach ($requiredExtensions as $extension) {
            if (!extension_loaded($extension)) {
                $missingExtensions[] = $extension;
            }
        }
        if (!empty($missingExtensions)) {
            $this->error('Missing required PHP extensions: ' . implode(', ', $missingExtensions));
            return Command::FAILURE;
        }
        $this->info('PHP extensions check passed.');


        // Step 4: Copy .env.example to .env if .env does not exist
        if (!File::exists(base_path('.env'))) {
            if (File::exists(base_path('.env.example'))) {
                File::copy(base_path('.env.example'), base_path('.env'));
                $this->info('.env file created from .env.example.');
            } else {
                $this->warn('.env.example not found. Please create a .env file manually.');
                // Optionally, create a basic .env file here if needed
            }
        } else {
            $this->info('.env file already exists.');
        }

        // For a CLI installer, you would prompt for .env values here.
        // For a web installer, this command might just set up prerequisites
        // or trigger the web installation process if desired.

        $this->comment('----------------------------------------------------------------');
        $this->comment('CLI part of installation is minimal for web-based installer.');
        $this->comment('Please navigate to /' . config('quickstart.route_prefix', 'quickstart-install') . ' in your browser to complete the installation.');
        $this->comment('----------------------------------------------------------------');


        // Example of running post-install commands (can be moved to web installer logic)
        /*
        $this->info('Running post-installation commands...');
        foreach (config('quickstart.post_install_commands', []) as $command) {
            try {
                $this->line("> php artisan {$command}");
                Artisan::call($command, [], $this->getOutput());
            } catch (\Exception $e) {
                $this->error("Error running command '{$command}': " . $e->getMessage());
            }
        }
        */

        // Create installed flag file (usually done at the end of web installation)
        // File::put($installedFlag, 'Installed on: ' . now());
        // $this->info('Installation completed. "installed.flag" created.');

        $this->info('Quickstart CLI tasks finished. Please proceed with web installation if available.');
        return Command::SUCCESS;
    }
}
