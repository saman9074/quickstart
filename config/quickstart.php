<?php

// config/quickstart.php

return [

        /*
    |--------------------------------------------------------------------------
    | Installer Theme
    |--------------------------------------------------------------------------
    |
    | Specify the theme to be used for the installer UI.
    | The package provides a 'default' theme. You can create custom themes
    | by creating a new directory under the package's
    | `resources/views/installer/themes/` path and then setting its name here.
    | If a view is not found in the selected theme, it will fallback to the 'default' theme.
    |
    */
    'theme' => 'quickstart-nova', // Available: 'default', 'quickstart-nova' (example)

    /*
    |--------------------------------------------------------------------------
    | Supported Locales
    |--------------------------------------------------------------------------
    |
    | Define the languages supported by the installer.
    | The key is the locale code (e.g., 'en', 'fa') and the value is the
    | display name's translation key.
    |
    */
    'supported_locales' => [
        'en' => 'quickstart::installer.language_english', // Translation key for "English"
        'fa' => 'quickstart::installer.language_persian', // Translation key for "Persian"
        // Example for adding another language:
        // 'es' => 'quickstart::installer.language_spanish', // Translation key for "Spanish"
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Locale for Installer
    |--------------------------------------------------------------------------
    |
    | If no locale is set in the session, this locale will be used as the default.
    | This value should be one of the keys defined in 'supported_locales'.
    |
    */
    'default_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Installer Core Configuration
    |--------------------------------------------------------------------------
    |
    | General configuration settings for the Quickstart installer.
    | This includes route settings, server requirements, paths,
    | and the main welcome message key.
    |
    */

    // Route settings for the installer pages
    'route_prefix' => 'quickstart-install', // URL prefix for installer routes
    'route_middleware' => ['web'],         // Middleware group for installer routes

    // Translation key for the main welcome message displayed in the installer header.
    'welcome_message_key' => 'quickstart::installer.header_title_fallback',

    // Minimum required PHP version for the application.
    'required_php_version' => '8.1.0',

    // A list of PHP extensions required by the application.
    'required_php_extensions' => [
        'bcmath',
        'ctype',
        'fileinfo',
        'json',
        'mbstring',
        'openssl',
        'pdo',
        'tokenizer',
        'xml',
    ],

    // A list of directories that need to be writable by the web server.
    'writable_directories' => [
        'storage/framework',
        'storage/logs',
        'bootstrap/cache',
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Variables Configuration (.env Keys)
    |--------------------------------------------------------------------------
    |
    | Define the essential .env keys that the installer should prompt the user for.
    | These keys will be used to generate the form in the environment setup step.
    |
    | For each key, you can specify:
    |   - 'label_key': Translation key for the display name of the input field.
    |   - 'type': Input type (e.g., 'text', 'password', 'select', 'textarea', 'number').
    |   - 'rules': Laravel validation rules (e.g., 'required|string').
    |   - 'default': A default value for the field (optional).
    |   - 'options': For 'select' type, an associative array where keys are option values
    |                and values are translation keys for option labels (optional).
    |   - 'help_key': Translation key for a short help text or tooltip (optional).
    |   - 'placeholder_key': Translation key for placeholder text (optional).
    |
    */
    'env_keys' => [
        // Application Settings
        'APP_NAME' => [
            'label_key' => 'quickstart::installer.env_app_name_label',
            'type' => 'text',
            'rules' => 'required|string|max:255',
            'default' => 'Laravel',
            'help_key' => 'quickstart::installer.env_app_name_help',
        ],
        'APP_ENV' => [
            'label_key' => 'quickstart::installer.env_app_env_label',
            'type' => 'select',
            'options' => [
                'local' => 'quickstart::installer.env_app_env_option_local',
                'production' => 'quickstart::installer.env_app_env_option_production',
                'testing' => 'quickstart::installer.env_app_env_option_testing',
            ],
            'rules' => 'required|string|in:local,production,testing',
            'default' => 'local',
            'help_key' => 'quickstart::installer.env_app_env_help',
        ],
        'APP_DEBUG' => [
            'label_key' => 'quickstart::installer.env_app_debug_label',
            'type' => 'select',
            'options' => [
                'true' => 'quickstart::installer.env_app_debug_option_true',
                'false' => 'quickstart::installer.env_app_debug_option_false',
            ],
            'rules' => 'required|in:true,false',
            'default' => 'true',
            'help_key' => 'quickstart::installer.env_app_debug_help',
        ],
        'APP_URL' => [
            'label_key' => 'quickstart::installer.env_app_url_label',
            'type' => 'text',
            'rules' => 'required|url',
            'default' => 'http://localhost',
            'help_key' => 'quickstart::installer.env_app_url_help',
        ],
        'APP_LOCALE' => [
            'label_key' => 'quickstart::installer.env_app_locale_label',
            'type' => 'select',
            'options' => [ // These should map to your 'supported_locales' keys for consistency
                'en' => 'quickstart::installer.language_english',
                'fa' => 'quickstart::installer.language_persian',
            ],
            'rules' => 'required|string',
            'default' => 'en',
            'help_key' => 'quickstart::installer.env_app_locale_help',
        ],

        // Database Configuration
        'DB_CONNECTION' => [
            'label_key' => 'quickstart::installer.env_db_connection_label',
            'type' => 'select',
            'options' => [
                'mysql' => 'quickstart::installer.env_db_connection_option_mysql',
                'pgsql' => 'quickstart::installer.env_db_connection_option_pgsql',
                'sqlite' => 'quickstart::installer.env_db_connection_option_sqlite',
                'sqlsrv' => 'quickstart::installer.env_db_connection_option_sqlsrv',
            ],
            'rules' => 'required|string',
            'default' => 'sqlite', // Changed from mysql to match typical Laravel default
            'help_key' => 'quickstart::installer.env_db_connection_help',
        ],
        'DB_HOST' => [ // Only shown if DB_CONNECTION is not sqlite
            'label_key' => 'quickstart::installer.env_db_host_label',
            'type' => 'text',
            'rules' => 'required_unless:DB_CONNECTION,sqlite|nullable|string',
            'default' => '127.0.0.1',
            'help_key' => 'quickstart::installer.env_db_host_help',
        ],
        'DB_PORT' => [ // Only shown if DB_CONNECTION is not sqlite
            'label_key' => 'quickstart::installer.env_db_port_label',
            'type' => 'text',
            'rules' => 'required_unless:DB_CONNECTION,sqlite|nullable|numeric',
            'default' => '3306',
            'help_key' => 'quickstart::installer.env_db_port_help',
        ],
        'DB_DATABASE' => [
            'label_key' => 'quickstart::installer.env_db_database_label',
            'type' => 'text',
            'rules' => 'required|string',
            'default' => 'laravel', // Default name, user should change for non-sqlite
            'help_key' => 'quickstart::installer.env_db_database_help',
        ],
        'DB_USERNAME' => [ // Only shown if DB_CONNECTION is not sqlite
            'label_key' => 'quickstart::installer.env_db_username_label',
            'type' => 'text',
            'rules' => 'required_unless:DB_CONNECTION,sqlite|nullable|string',
            'default' => 'root',
            'help_key' => 'quickstart::installer.env_db_username_help',
        ],
        'DB_PASSWORD' => [ // Only shown if DB_CONNECTION is not sqlite
            'label_key' => 'quickstart::installer.env_db_password_label',
            'type' => 'password',
            'rules' => 'nullable|string',
            'default' => '',
            'help_key' => 'quickstart::installer.env_db_password_help',
        ],

        // Mail Configuration
        'MAIL_MAILER' => [
            'label_key' => 'quickstart::installer.env_mail_mailer_label',
            'type' => 'select',
            'options' => [
                'smtp' => 'quickstart::installer.env_mail_mailer_option_smtp',
                'log' => 'quickstart::installer.env_mail_mailer_option_log',
                'array' => 'quickstart::installer.env_mail_mailer_option_array',
                // 'mailgun' => 'quickstart::installer.env_mail_mailer_option_mailgun',
                // 'ses' => 'quickstart::installer.env_mail_mailer_option_ses',
                // 'postmark' => 'quickstart::installer.env_mail_mailer_option_postmark',
            ],
            'rules' => 'required|string',
            'default' => 'log',
            'help_key' => 'quickstart::installer.env_mail_mailer_help',
        ],
        'MAIL_HOST' => [ // Shown if MAIL_MAILER is smtp
            'label_key' => 'quickstart::installer.env_mail_host_label',
            'type' => 'text',
            'rules' => 'required_if:MAIL_MAILER,smtp|nullable|string',
            'default' => '127.0.0.1',
            'help_key' => 'quickstart::installer.env_mail_host_help',
        ],
        'MAIL_PORT' => [ // Shown if MAIL_MAILER is smtp
            'label_key' => 'quickstart::installer.env_mail_port_label',
            'type' => 'text',
            'rules' => 'required_if:MAIL_MAILER,smtp|nullable|numeric',
            'default' => '2525',
            'help_key' => 'quickstart::installer.env_mail_port_help',
        ],
        'MAIL_USERNAME' => [ // Shown if MAIL_MAILER is smtp
            'label_key' => 'quickstart::installer.env_mail_username_label',
            'type' => 'text',
            'rules' => 'nullable|string',
            'default' => '',
            'help_key' => 'quickstart::installer.env_mail_username_help',
        ],
        'MAIL_PASSWORD' => [ // Shown if MAIL_MAILER is smtp
            'label_key' => 'quickstart::installer.env_mail_password_label',
            'type' => 'password',
            'rules' => 'nullable|string',
            'default' => '',
            'help_key' => 'quickstart::installer.env_mail_password_help',
        ],
        'MAIL_ENCRYPTION' => [ // Shown if MAIL_MAILER is smtp
            'label_key' => 'quickstart::installer.env_mail_encryption_label',
            'type' => 'select',
            'options' => [
                'null' => 'quickstart::installer.env_mail_encryption_option_null',
                'tls' => 'quickstart::installer.env_mail_encryption_option_tls',
                'ssl' => 'quickstart::installer.env_mail_encryption_option_ssl',
            ],
            'rules' => 'nullable|string',
            'default' => 'null',
            'help_key' => 'quickstart::installer.env_mail_encryption_help',
        ],
        'MAIL_FROM_ADDRESS' => [
            'label_key' => 'quickstart::installer.env_mail_from_address_label',
            'type' => 'text',
            'rules' => 'required|email',
            'default' => 'hello@example.com',
            'help_key' => 'quickstart::installer.env_mail_from_address_help',
        ],
        'MAIL_FROM_NAME' => [
            'label_key' => 'quickstart::installer.env_mail_from_name_label',
            'type' => 'text',
            'rules' => 'required|string',
            'default' => '${APP_NAME}', // This will be replaced by the actual APP_NAME value
            'help_key' => 'quickstart::installer.env_mail_from_name_help',
        ],

        // Session, Queue, Cache Drivers
        'SESSION_DRIVER' => [
            'label_key' => 'quickstart::installer.env_session_driver_label',
            'type' => 'select',
            'options' => [
                'file' => 'quickstart::installer.env_session_driver_option_file',
                'cookie' => 'quickstart::installer.env_session_driver_option_cookie',
                'database' => 'quickstart::installer.env_session_driver_option_database',
                'redis' => 'quickstart::installer.env_session_driver_option_redis',
                // 'memcached' => 'quickstart::installer.env_session_driver_option_memcached',
                // 'array' => 'quickstart::installer.env_session_driver_option_array',
            ],
            'rules' => 'required|string',
            'default' => 'database', // Changed to database as per your .env
            'help_key' => 'quickstart::installer.env_session_driver_help',
        ],
        'QUEUE_CONNECTION' => [
            'label_key' => 'quickstart::installer.env_queue_connection_label',
            'type' => 'select',
            'options' => [
                'sync' => 'quickstart::installer.env_queue_connection_option_sync',
                'database' => 'quickstart::installer.env_queue_connection_option_database',
                'redis' => 'quickstart::installer.env_queue_connection_option_redis',
                // 'beanstalkd' => 'quickstart::installer.env_queue_connection_option_beanstalkd',
                // 'sqs' => 'quickstart::installer.env_queue_connection_option_sqs',
            ],
            'rules' => 'required|string',
            'default' => 'database', // Changed to database as per your .env
            'help_key' => 'quickstart::installer.env_queue_connection_help',
        ],
         'CACHE_STORE' => [ // Renamed from CACHE_DRIVER for Laravel 9+
            'label_key' => 'quickstart::installer.env_cache_store_label',
            'type' => 'select',
            'options' => [
                'file' => 'quickstart::installer.env_cache_store_option_file',
                'database' => 'quickstart::installer.env_cache_store_option_database',
                'redis' => 'quickstart::installer.env_cache_store_option_redis',
                'memcached' => 'quickstart::installer.env_cache_store_option_memcached',
                // 'array' => 'quickstart::installer.env_cache_store_option_array',
                // 'dynamodb' => 'quickstart::installer.env_cache_store_option_dynamodb',
            ],
            'rules' => 'required|string',
            'default' => 'database', // Changed to database as per your .env
            'help_key' => 'quickstart::installer.env_cache_store_help',
        ],
        // Redis (only if Redis is selected for session, queue, or cache)
        'REDIS_HOST' => [
            'label_key' => 'quickstart::installer.env_redis_host_label',
            'type' => 'text',
            'rules' => 'required_if:SESSION_DRIVER,redis|required_if:QUEUE_CONNECTION,redis|required_if:CACHE_STORE,redis|nullable|string',
            'default' => '127.0.0.1',
            'help_key' => 'quickstart::installer.env_redis_host_help',
        ],
        'REDIS_PASSWORD' => [
            'label_key' => 'quickstart::installer.env_redis_password_label',
            'type' => 'password',
            'rules' => 'nullable|string',
            'default' => '', // Default is null, but empty string for form
            'help_key' => 'quickstart::installer.env_redis_password_help',
        ],
        'REDIS_PORT' => [
            'label_key' => 'quickstart::installer.env_redis_port_label',
            'type' => 'text',
            'rules' => 'required_if:SESSION_DRIVER,redis|required_if:QUEUE_CONNECTION,redis|required_if:CACHE_STORE,redis|nullable|numeric',
            'default' => '6379',
            'help_key' => 'quickstart::installer.env_redis_port_help',
        ],
        
        //Google recaptcha
        'RECAPTCHA_SITE_KEY' => [
            'label_key' => 'quickstart::installer.env_recaptcha_site_key_label',
            'type' => 'text',
            'rules' => 'required|string',
            'default' => '',
            'help_key' => 'quickstart::installer.env_recaptcha_site_key_help',
        ],
        'RECAPTCHA_SECRET_KEY' => [
            'label_key' => 'quickstart::installer.env_recaptcha_secret_key_label',
            'type' => 'text',
            'rules' => 'required|string',
            'default' => '',
            'help_key' => 'quickstart::installer.env_recaptcha_secret_key_help',
        ],

        // Other Environment Variables
    ],

    /*
    |--------------------------------------------------------------------------
    | Installer Steps Configuration
    |--------------------------------------------------------------------------
    */
    'steps' => [
        'welcome'      => ['title_key' => 'quickstart::installer.step_welcome_title', 'view_suffix' => 'welcome'],
        'requirements' => ['title_key' => 'quickstart::installer.step_requirements_title', 'view_suffix' => 'requirements'],
        'permissions'  => ['title_key' => 'quickstart::installer.step_permissions_title', 'view_suffix' => 'permissions'],
        'environment'  => ['title_key' => 'quickstart::installer.step_environment_title', 'view_suffix' => 'environment'],
        'finalize'     => ['title_key' => 'quickstart::installer.step_finalize_title', 'view_suffix' => 'finalize'],
        'finished'     => ['title_key' => 'quickstart::installer.step_finished_title', 'view_suffix' => 'finished'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Post-Installation Commands
    |--------------------------------------------------------------------------
    */
    'post_install_commands' => [
        'key:generate',      // Generates the application key (if not already set).
        'migrate --force',   // Runs database migrations. The --force flag is used to run without confirmation, suitable for automated processes.
        // 'db:seed',        // Example: Runs all main database seeders.
        // 'db:seed --class=YourSpecificSeeder', // Example: Runs a specific seeder class.
        // 'storage:link',   // Example: Creates the symbolic link for public storage.
        // 'optimize:clear', // Example: Clears all compiled files (routes, config, views, events).
        // 'config:cache',   // Example: Caches the configuration (typically for production).
        // 'route:cache',    // Example: Caches the routes (typically for production).
        // 'view:cache',     // Example: Caches the Blade views (typically for production).
    ],

    /*
    |--------------------------------------------------------------------------
    | "Installed" Flag File
    |--------------------------------------------------------------------------
    */
    'installed_flag_file' => 'installed.flag',

];
