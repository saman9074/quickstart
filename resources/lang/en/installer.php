<?php

// resources/lang/en/installer.php

return [
    // General Layout & Common
    'direction'                       => 'ltr',
    'title_suffix'                    => 'Quickstart Installer',
    'default_page_title'              => 'Installation Step',
    'header_title_fallback'           => 'Application Installer',
    'error_title'                     => 'Error!',
    'footer_copyright_fallback_app_name' => 'Your Application',
    'footer_powered_by'               => 'Powered by Quickstart Package.',

    // Language Switcher
    'language_select_label'           => 'Select Language',
    'language_english'                => 'English',
    'language_persian'                => 'Persian',
    'language_change_button'          => 'Change',

    // Steps Navigation
    'steps_navigation_title'          => 'Installation Steps:',
    'steps_loading_error'             => 'Steps could not be loaded.',

    // Step Titles
    'step_welcome_title'              => 'Welcome',
    'step_requirements_title'         => 'Server Requirements',
    'step_permissions_title'          => 'Folder Permissions',
    'step_environment_title'          => 'Environment Configuration',
    'step_finalize_title'             => 'Finalize Installation',
    'step_finished_title'             => 'Installation Complete',

    // --- Environment Field Keys ---
    // Application
    'env_app_name_label'              => 'Application Name',
    'env_app_name_help'               => 'The name of your application.',
    'env_app_env_label'               => 'Application Environment',
    'env_app_env_help'                => 'The environment your application is running in.',
    'env_app_env_option_local'        => 'Local',
    'env_app_env_option_production'   => 'Production',
    'env_app_env_option_testing'      => 'Testing',
    'env_app_debug_label'             => 'Application Debug Mode',
    'env_app_debug_help'              => 'Enable or disable debug mode. Should be false in production.',
    'env_app_debug_option_true'       => 'True (Enabled)',
    'env_app_debug_option_false'      => 'False (Disabled)',
    'env_app_url_label'               => 'Application URL',
    'env_app_url_help'                => 'The main URL of your application.',
    'env_app_locale_label'            => 'Application Language',
    'env_app_locale_help'             => 'The default language for the application.',

    // Database
    'env_db_connection_label'         => 'Database Connection',
    'env_db_connection_help'          => 'The type of database connection.',
    'env_db_connection_option_mysql'  => 'MySQL',
    'env_db_connection_option_pgsql'  => 'PostgreSQL',
    'env_db_connection_option_sqlite' => 'SQLite',
    'env_db_connection_option_sqlsrv' => 'SQL Server',
    'env_db_host_label'               => 'Database Host',
    'env_db_host_help'                => 'The hostname or IP address of your database server.',
    'env_db_port_label'               => 'Database Port',
    'env_db_port_help'                => 'The port your database server is listening on.',
    'env_db_database_label'           => 'Database Name',
    'env_db_database_help'            => 'The name of your database.',
    'env_db_username_label'           => 'Database Username',
    'env_db_username_help'            => 'The username to connect to the database.',
    'env_db_password_label'           => 'Database Password',
    'env_db_password_help'            => 'The password for the database user. Can be empty for local development.',

    // Mail
    'env_mail_mailer_label'           => 'Mail Driver (Mailer)',
    'env_mail_mailer_help'            => 'The driver to use for sending emails.',
    'env_mail_mailer_option_smtp'     => 'SMTP',
    'env_mail_mailer_option_log'      => 'Log',
    'env_mail_mailer_option_array'    => 'Array (for testing)',
    'env_mail_host_label'             => 'Mail Host',
    'env_mail_host_help'              => 'SMTP host address.',
    'env_mail_port_label'             => 'Mail Port',
    'env_mail_port_help'              => 'SMTP port (e.g., 587, 465, 2525).',
    'env_mail_username_label'         => 'Mail Username',
    'env_mail_username_help'          => 'SMTP username.',
    'env_mail_password_label'         => 'Mail Password',
    'env_mail_password_help'          => 'SMTP password.',
    'env_mail_encryption_label'       => 'Mail Encryption',
    'env_mail_encryption_help'        => 'SMTP encryption protocol (e.g., tls, ssl, or null).',
    'env_mail_encryption_option_null' => 'None (null)',
    'env_mail_encryption_option_tls'  => 'TLS',
    'env_mail_encryption_option_ssl'  => 'SSL',
    'env_mail_from_address_label'     => 'Mail From Address',
    'env_mail_from_address_help'      => 'The email address that emails will be sent from.',
    'env_mail_from_name_label'        => 'Mail From Name',
    'env_mail_from_name_help'         => 'The name that emails will be sent from (e.g., your application name).',

    // Session, Queue, Cache
    'env_session_driver_label'        => 'Session Driver',
    'env_session_driver_help'         => 'How session data will be stored.',
    'env_session_driver_option_file'  => 'File',
    'env_session_driver_option_cookie'=> 'Cookie',
    'env_session_driver_option_database'=> 'Database',
    'env_session_driver_option_redis' => 'Redis',
    'env_queue_connection_label'      => 'Queue Connection (Driver)',
    'env_queue_connection_help'       => 'The driver for background queue jobs.',
    'env_queue_connection_option_sync'=> 'Sync (immediate)',
    'env_queue_connection_option_database'=> 'Database',
    'env_queue_connection_option_redis'=> 'Redis',
    'env_cache_store_label'           => 'Cache Driver (Store)', // Changed from CACHE_DRIVER to CACHE_STORE
    'env_cache_store_help'            => 'The driver for application caching.',
    'env_cache_store_option_file'     => 'File',
    'env_cache_store_option_database' => 'Database',
    'env_cache_store_option_redis'    => 'Redis',
    'env_cache_store_option_memcached'=> 'Memcached',

    // Redis
    'env_redis_host_label'            => 'Redis Host',
    'env_redis_host_help'             => 'Redis server host.',
    'env_redis_password_label'        => 'Redis Password',
    'env_redis_password_help'         => 'Redis server password (leave empty if none).',
    'env_redis_port_label'            => 'Redis Port',
    'env_redis_port_help'             => 'Redis server port (default: 6379).',

    // reCAPTCHA 
    'env_recaptcha_site_key_label'    => 'reCAPTCHA Site Key',
    'env_recaptcha_site_key_help'     => 'Your reCAPTCHA site key for Google reCAPTCHA integration.',
    'env_recaptcha_secret_key_label'  => 'reCAPTCHA Secret Key',
    'env_recaptcha_secret_key_help'   => 'Your reCAPTCHA secret key for Google reCAPTCHA integration.',


    // --- View Specific Translations ---
    // Welcome View
    'welcome_page_title'              => 'Welcome to Installer',
    'welcome_intro'                   => 'Welcome to the :app_name application installer! This wizard will guide you through the installation process.',
    'welcome_checklist_title'         => 'Before you begin, please ensure you have the following ready (if applicable):',
    'welcome_checklist_item_db'       => 'Database connection details (name, username, password, host, port).',
    'welcome_checklist_item_req'      => 'Server requirements are met (PHP version, required extensions).',
    'welcome_checklist_item_perm'     => 'Folder permissions are correctly set.',
    'welcome_start_process_message'   => 'To start the installation process, click the button below.',
    'welcome_start_button'            => 'Start Installation',

    // Requirements View
    'req_page_title'                  => 'Server Requirements Check',
    'req_intro'                       => 'This step checks if your server meets the minimum requirements to run the application.',
    'req_php_version_check'           => 'PHP Version Check',
    'req_php_version_required'        => 'Required PHP version: :version or higher.',
    'req_php_version_current'         => 'Your current PHP version: :version.',
    'req_php_version_fail_message'    => 'Please update your server\'s PHP version.',
    'req_extensions_check'            => 'PHP Extensions Check',
    'req_extension_not_defined'       => 'No specific extensions defined for checking.',
    'req_extensions_missing'          => 'Please install and enable the missing PHP extensions marked with <i class="fas fa-times-circle"></i>.',
    'req_all_ok'                      => 'All server requirements are met.',
    'req_btn_next'                    => 'Next',
    'req_btn_prev'                    => 'Previous',
    'req_resolve_issues'              => 'Please resolve the highlighted issues before proceeding.',
    'req_php_ok'                      => 'Pass',
    'req_php_fail'                    => 'Fail',

    // Permissions View
    'perm_page_title'                 => 'Folder Permissions Check',
    'perm_intro'                      => 'This step checks if the required folders have the correct write permissions. These are necessary for storing logs, cache files, and uploads.',
    'perm_folder_check_title'         => 'Folder Permissions Check',
    'perm_not_defined'                => 'No folders defined for permission checking.',
    'perm_writable'                   => 'Writable',
    'perm_not_writable'               => 'Not Writable',
    'perm_all_ok'                     => 'All folder permissions are correctly set.',
    'perm_resolve_issues'             => 'Please set write permissions for the folders marked with <i class="fas fa-times-circle"></i>. This is often done using <code>chmod -R 775 directory_name</code> or by setting the correct web server user ownership. Be aware of security implications before changing permissions.',
    'perm_resolve_folder_issues_proceed' => 'Please resolve the folder permission issues before proceeding.',

    // Environment View
    'env_page_title'                  => 'Environment Configuration',
    'env_intro'                       => 'Configure the main settings for your application. These values will be saved in your project\'s <code>.env</code> file. Please enter the information carefully, especially the database connection details.',
    'env_no_fields_defined'           => 'No environment fields are defined in the configuration file (<code>config/quickstart.php</code> under <code>env_keys</code>).',
    'env_group_app_settings'          => 'Application Settings',
    'env_group_db_settings'           => 'Database Settings',
    'env_group_other_settings'        => 'Other Settings',
    'env_btn_save_continue'           => 'Save and Continue',
    'env_group_mail_settings'         => 'Mail Settings',
    'env_group_driver_settings'       => 'Driver Settings',
    'env_group_redis_settings'        => 'Redis Settings',
    'env_group_recaptcha_settings'    => 'reCAPTCHA Settings',


    // Finalize View
    'finalize_page_title'             => 'Finalize Installation',
    'finalize_intro_success'          => 'Your environment settings have been saved successfully.',
    'finalize_intro_tasks'            => 'We are now ready to perform the final installation steps. These include (based on your configuration):',
    'finalize_tasks_list_title'       => 'Commands to be executed:',
    'finalize_tasks_install_flag'     => 'Creation of the installation indicator file (<code>:filename</code>).',
    'finalize_no_post_commands'       => 'No post-installation commands are defined in the config. Only the installation indicator file will be created.',
    'finalize_warning'                => 'Clicking the "Run Final Installation" button will execute these commands and complete the application setup. This process may take a few moments.',
    'finalize_btn_run'                => 'Run Final Installation & Complete Process',
    'finalize_btn_return_env'         => 'Return to Environment Settings',

    // Finished View
    'finished_page_title'             => 'Installation Complete!',
    'finished_header'                 => 'Installation Successful!',
    'finished_intro'                  => 'Congratulations! The :app_name application has been successfully installed and configured on your server.',
    'finished_install_flag_info'      => 'The installation indicator file (<code>:path</code>) has been created to prevent re-running the installer. If you need to re-run the installer, please delete this file first.',
    'finished_next_steps_title'       => 'Next Steps:',
    'finished_next_step_env'          => 'You might want to review and edit your <code>.env</code> file for any advanced settings.',
    'finished_next_step_cron'         => 'Ensure any scheduled tasks (cron jobs) are set up correctly (if applicable).',
    'finished_next_step_permissions'  => 'Re-check file and folder permissions for security.',
    'finished_next_step_debug'        => 'In a production environment, ensure <code>APP_DEBUG</code> is set to <code>false</code>.',
    'finished_btn_go_home'            => 'Go to Application Homepage',
    'finished_dev_info_title'         => 'Information for Developers:',
    'finished_dev_info_rerun'         => 'To re-run the installer in a development environment, delete the following file:',

    // Controller / Middleware Messages
    'env_save_error'                  => 'Could not save .env file: ',
    'db_name_required_for_test'       => 'Database name is required for connection test.',
    'db_connection_test_failed_message' => 'Database connection test failed. Please check your settings and ensure the database exists and is accessible.',
    'db_connection_test_failed_message_detailed' => 'Database connection test failed: :error',
    'db_unknown_database_error'       => 'Database \':database\' not found. Please create it first.',
    'db_access_denied_error'          => 'Access denied to the database with the provided credentials. Please check the username and password.',
    'db_server_connection_error'      => 'Cannot connect to the database server. Please check the host and port, and ensure the server is running.',
    'already_installed_warning'       => 'Application already installed.',
    'finalize_error'                  => 'An error occurred during finalization: ',
    'installed_on_message'            => 'Installed on: ',
    'middleware_already_installed'    => 'Application is already installed.',
    'middleware_please_install_first' => 'Please complete the installation steps first.',
];
