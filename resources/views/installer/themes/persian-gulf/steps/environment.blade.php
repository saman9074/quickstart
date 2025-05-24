{{-- This view should extend the layout path provided by the controller --}}
@extends($layout_path)

@section('content')
    <div class="prose prose-sm sm:prose-base max-w-none dark:prose-invert {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            {{ __('quickstart::installer.env_intro') }}
        </p>
    </div>

    <form method="POST" action="{{ route('quickstart.install.environment') }}" class="space-y-8">
        @csrf

        @if(empty($envFields))
            <div class="bg-yellow-100 dark:bg-yellow-700/30 border-l-4 border-yellow-500 dark:border-yellow-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-500 dark:text-yellow-400 text-xl"></i>
                    </div>
                    <div class="{{ __('quickstart::installer.direction') === 'rtl' ? 'mr-3' : 'ml-3' }}">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            {{ __('quickstart::installer.env_no_fields_defined') }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            @php
                $groups = [
                    'application' => ['APP_NAME', 'APP_ENV', 'APP_DEBUG', 'APP_URL', 'APP_LOCALE'],
                    'database'    => ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'],
                    'mail'        => ['MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD', 'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME'],
                    'drivers'     => ['SESSION_DRIVER', 'QUEUE_CONNECTION', 'CACHE_STORE'],
                    'redis'       => ['REDIS_HOST', 'REDIS_PASSWORD', 'REDIS_PORT'],
                    'recaptcha'   => ['RECAPTCHA_SITE_KEY', 'RECAPTCHA_SECRET_KEY'],
                ];

                $groupedKeys = [];
                foreach ($groups as $groupName => $keysInGroup) {
                    foreach ($keysInGroup as $key) {
                        if (isset($envFields[$key])) {
                            $groupedKeys[$key] = $groupName;
                        }
                    }
                }
                $otherFields = array_diff_key($envFields, $groupedKeys);

                $envFieldPartialPath = "quickstart::installer.themes.{$active_theme}.partials.env_field";
                if (!View::exists($envFieldPartialPath)) {
                    $envFieldPartialPath = "quickstart::installer.themes.default.partials.env_field";
                }
            @endphp

            {{-- Application Settings Group --}}
            @if(count(array_intersect_key($envFields, array_flip($groups['application']))) > 0)
            <fieldset class="border border-teal-500/30 dark:border-teal-400/30 p-4 sm:p-6 rounded-xl shadow-lg bg-white/60 dark:bg-slate-800/70 backdrop-blur-md">
                <legend class="text-lg font-semibold text-teal-700 dark:text-teal-300 px-3 py-1 bg-white/80 dark:bg-slate-700/80 rounded-md shadow-sm flex items-center">
                    <i class="fas fa-cogs {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_app_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">
                    @foreach($groups['application'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include($envFieldPartialPath, compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- Database Settings Group --}}
            @if(count(array_intersect_key($envFields, array_flip($groups['database']))) > 0)
            <fieldset class="border border-teal-500/30 dark:border-teal-400/30 p-4 sm:p-6 rounded-xl shadow-lg bg-white/60 dark:bg-slate-800/70 backdrop-blur-md">
                <legend class="text-lg font-semibold text-teal-700 dark:text-teal-300 px-3 py-1 bg-white/80 dark:bg-slate-700/80 rounded-md shadow-sm flex items-center">
                    <i class="fas fa-database {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_db_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">
                     @foreach($groups['database'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include($envFieldPartialPath, compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- Mail Settings Group --}}
            @if(count(array_intersect_key($envFields, array_flip($groups['mail']))) > 0)
            <fieldset class="border border-teal-500/30 dark:border-teal-400/30 p-4 sm:p-6 rounded-xl shadow-lg bg-white/60 dark:bg-slate-800/70 backdrop-blur-md">
                <legend class="text-lg font-semibold text-teal-700 dark:text-teal-300 px-3 py-1 bg-white/80 dark:bg-slate-700/80 rounded-md shadow-sm flex items-center">
                    <i class="fas fa-envelope {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_mail_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">
                     @foreach($groups['mail'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include($envFieldPartialPath, compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- Driver Settings Group --}}
            @if(count(array_intersect_key($envFields, array_flip($groups['drivers']))) > 0)
            <fieldset class="border border-teal-500/30 dark:border-teal-400/30 p-4 sm:p-6 rounded-xl shadow-lg bg-white/60 dark:bg-slate-800/70 backdrop-blur-md">
                <legend class="text-lg font-semibold text-teal-700 dark:text-teal-300 px-3 py-1 bg-white/80 dark:bg-slate-700/80 rounded-md shadow-sm flex items-center">
                    <i class="fas fa-sliders-h {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_driver_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">
                     @foreach($groups['drivers'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include($envFieldPartialPath, compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- Redis Settings Group --}}
            @if(count(array_intersect_key($envFields, array_flip($groups['redis']))) > 0)
            <fieldset class="border border-teal-500/30 dark:border-teal-400/30 p-4 sm:p-6 rounded-xl shadow-lg bg-white/60 dark:bg-slate-800/70 backdrop-blur-md">
                <legend class="text-lg font-semibold text-teal-700 dark:text-teal-300 px-3 py-1 bg-white/80 dark:bg-slate-700/80 rounded-md shadow-sm flex items-center">
                    <i class="fab fa-redis {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_redis_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">
                     @foreach($groups['redis'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include($envFieldPartialPath, compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- reCAPTCHA Settings Group --}}
            @if(count(array_intersect_key($envFields, array_flip($groups['recaptcha']))) > 0)
            <fieldset class="border border-teal-500/30 dark:border-teal-400/30 p-4 sm:p-6 rounded-xl shadow-lg bg-white/60 dark:bg-slate-800/70 backdrop-blur-md">
                <legend class="text-lg font-semibold text-teal-700 dark:text-teal-300 px-3 py-1 bg-white/80 dark:bg-slate-700/80 rounded-md shadow-sm flex items-center">
                    <i class="fas fa-shield-alt {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_recaptcha_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">
                     @foreach($groups['recaptcha'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include($envFieldPartialPath, compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- Other Settings (if any) --}}
            @if(!empty($otherFields))
            <fieldset class="border border-teal-500/30 dark:border-teal-400/30 p-4 sm:p-6 rounded-xl shadow-lg bg-white/60 dark:bg-slate-800/70 backdrop-blur-md">
                <legend class="text-lg font-semibold text-teal-700 dark:text-teal-300 px-3 py-1 bg-white/80 dark:bg-slate-700/80 rounded-md shadow-sm flex items-center">
                    <i class="fas fa-ellipsis-h {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_other_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">
                    @foreach($otherFields as $key => $fieldConfig)
                        @php $field = $fieldConfig; @endphp
                        @include($envFieldPartialPath, compact('key', 'field', 'currentEnvValues'))
                    @endforeach
                </div>
            </fieldset>
            @endif

        @endif

        <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="{{ route('quickstart.install.permissions') }}"
               class="button-secondary-pg w-full sm:w-auto">
                <i class="fas fa-arrow-left {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
                <span>{{ __('quickstart::installer.req_btn_prev') }}</span>
            </a>
            <button type="submit"
                    class="button-primary-pg w-full sm:w-auto">
                <span>{{ __('quickstart::installer.env_btn_save_continue') }}</span>
                <i class="fas fa-save {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
                <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-1' : 'ml-1' }}"></i>
            </button>
        </div>
    </form>
@endsection
