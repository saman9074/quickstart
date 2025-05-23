# Laravel Quickstart Installer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/saman9074/quickstart.svg?style=flat-square)](https://packagist.org/packages/saman9074/quickstart)
[![Total Downloads](https://img.shields.io/packagist/dt/saman9074/quickstart.svg?style=flat-square)](https://packagist.org/packages/saman9074/quickstart)
[![License](https://img.shields.io/packagist/l/saman9074/quickstart.svg?style=flat-square)](LICENSE.md)
The Laravel Quickstart Installer is a package designed to provide a user-friendly, web-based interface for installing your Laravel applications. It guides users through a step-by-step setup process, similar to popular CMS platforms, making initial application deployment straightforward.

This package is developed by [Saman9074 (Ali Abdi)](https://github.com/saman9074).

## Features

* **Step-by-Step Web UI:** Intuitive wizard for easy installation.
* **Multi-Language Support:** Comes with English and Persian out-of-the-box. Easily extendable.
* **Server Requirements Check:** Verifies PHP version and necessary extensions.
* **Folder Permissions Check:** Ensures critical directories are writable.
* **`.env` Configuration:** Dynamically creates and configures the `.env` file through a form.
* **Database Connection Testing:** Validates database credentials before proceeding.
* **Automated Artisan Commands:** Executes migrations, seeders, and other post-installation commands.
* **Installation Lock:** Prevents re-running the installer once the application is set up.
* **Customizable:** Configuration, views, and language files can be published and modified.

## Requirements

* PHP: `^8.1` (or as specified in your package's `composer.json`)
* Laravel: `^10.0` | `^11.0` | `^12.0` (or as specified in your package's `composer.json`)

## Installation

1.  **Require the package using Composer:**

    ```bash
    composer require saman9074/quickstart
    ```

2.  **Publish package assets:**
    This will publish the configuration file, views (optional), and language files (optional).

    ```bash
    php artisan vendor:publish --provider="Saman9074\Quickstart\QuickstartServiceProvider"
    ```

    You can also publish specific groups using tags:
    * Config: `--tag="quickstart-config"`
    * Views: `--tag="quickstart-views"`
    * Language files: `--tag="quickstart-lang"`

## Configuration

After publishing, the main configuration file will be located at `config/quickstart.php`.

Key options include:

* **`supported_locales`**: Array of supported languages (e.g., `['en' => 'quickstart::installer.language_english', 'fa' => 'quickstart::installer.language_persian']`).
* **`default_locale`**: Default installer language (e.g., `en`).
* **`route_prefix`**: URL prefix for installer routes (default: `quickstart-install`).
* **`route_middleware`**: Middleware group for installer routes (default: `['web']`).
* **`welcome_message_key`**: Translation key for the installer header message.
* **`required_php_version`**: Minimum PHP version string.
* **`required_php_extensions`**: Array of required PHP extensions.
* **`writable_directories`**: Array of directories that must be writable.
* **`env_keys`**: Detailed configuration for each `.env` variable to be set during installation. Each entry defines:
    * `label_key`: Translation key for the field's label.
    * `type`: Input type (`text`, `select`, `password`, etc.).
    * `rules`: Laravel validation rules.
    * `default`: Default value.
    * `options`: For `select` type, an array of `value => translation_key_for_label`.
    * `help_key`: Translation key for help text.
* **`steps`**: Defines the installer steps, their order, title translation keys, and view suffixes.
* **`post_install_commands`**: Array of Artisan commands (e.g., `migrate --force`, `db:seed`) to run during the finalization step.
* **`installed_flag_file`**: Name of the file created in `storage_path()` to mark installation as complete (default: `installed.flag`).

## Usage

1.  **Prerequisites for the target Laravel application:**
    * Ensure no `.env` file exists, or if it does, its database details are not yet configured if you want the installer to set them up. The installer will attempt to copy `.env.example` if `.env` is missing.
    * A database server (MySQL, PostgreSQL, etc.) should be running.
    * **Crucially, the database schema itself (e.g., `your_app_database`) must be created manually on your database server *before* running the installer's database setup step.** The installer will test the connection to this *existing* database and then run migrations. It does not create the database schema automatically.
2.  **Accessing the Installer:**
    Navigate to the installer URL in your browser. By default:
    `http://your-laravel-app.test/quickstart-install`
    (Replace `your-laravel-app.test` with your application's URL and use your configured `route_prefix`).
3.  **Follow the On-Screen Instructions:**
    * **Welcome:** Choose your language and get an overview.
    * **Server Requirements:** Checks PHP version and extensions.
    * **Folder Permissions:** Verifies writability of key directories.
    * **Environment Configuration:** Fill in application name, environment, URL, database credentials, mail settings, etc. The database connection will be tested here.
    * **Finalize Installation:** Confirms settings and runs post-installation commands (migrations, etc.).
    * **Finished:** Displays a success message and links to your application.

## Localization

* A language switcher is available on the welcome page.
* To customize translations or add new languages:
    1.  Publish the language files: `php artisan vendor:publish --tag="quickstart-lang"`
    2.  Edit the files in `lang/vendor/quickstart/` (for Laravel 9+) or `resources/lang/vendor/quickstart/` (for older versions).
* All texts use translation keys like `quickstart::installer.some_key`.

## Artisan Command (Optional)

A basic Artisan command is included:

```bash
php artisan quickstart:install
```
This command currently performs initial checks and guides the user to the web installer. It can be expanded for a full CLI installation if needed.

## Troubleshooting

    "The connection was reset" (browser) / "Environment modified. Restarting server..." (console):
    This is normal if you are using php artisan serve. When the installer updates the .env file, php artisan serve restarts. Simply wait for the server to restart (you'll see "Server running on..." in the console) and then manually navigate to the next step of the installer in your browser (e.g., /quickstart-install/finalize).

    "Unknown database 'database_name'" error:
    This means the database name you provided in the "Environment Configuration" step does not exist on your database server. You must create the database manually (e.g., via phpMyAdmin, Sequel Pro, or SQL command CREATE DATABASE database_name;) before the installer can run migrations on it. The installer tests the connection to this database but does not create it.

    Permission denied errors:
    Ensure the storage/ and bootstrap/cache/ directories in your Laravel application are writable by the web server process.

## Contributing

Contributions are welcome! If you'd like to contribute, please follow these general guidelines:

    Fork the repository.

    Create a new branch for your feature or bug fix.

    Write tests for your changes.

    Ensure your code follows existing coding standards.

    Submit a pull request with a clear description of your changes.

## License

The Laravel Quickstart Installer is open-source software licensed under the MIT license. Please see the LICENSE file for more details.
