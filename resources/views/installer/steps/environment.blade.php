@extends('quickstart::installer.layouts.main')

@section('content')
    <div class="prose max-w-none {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-gray-700 mb-6">
            {{ __('quickstart::installer.env_intro') }}
        </p>
    </div>

    <form method="POST" action="{{ route('quickstart.install.environment') }}" class="space-y-6">
        @csrf

        @if(empty($envFields))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 3.001-1.742 3.001H4.42c-1.53 0-2.493-1.667-1.743-3.001l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1.75-5.75a.75.75 0 00-1.5 0v3a.75.75 0 001.5 0v-3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="{{ __('quickstart::installer.direction') === 'rtl' ? 'mr-3' : 'ml-3' }}">
                        <p class="text-sm text-yellow-700">
                            {{ __('quickstart::installer.env_no_fields_defined') }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            @php
                // Define groups for form fields based on your config/quickstart.php env_keys
                $groups = [
                    'application' => ['APP_NAME', 'APP_ENV', 'APP_DEBUG', 'APP_URL', 'APP_LOCALE'],
                    'database'    => ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'],
                    'mail'        => ['MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 'MAIL_PASSWORD', 'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME'],
                    'drivers'     => ['SESSION_DRIVER', 'QUEUE_CONNECTION', 'CACHE_STORE'],
                    'redis'       => ['REDIS_HOST', 'REDIS_PASSWORD', 'REDIS_PORT'],
                    'recaptcha'   => ['RECAPTCHA_SITE_KEY', 'RECAPTCHA_SECRET_KEY'],
                ];

                // Consolidate all keys from defined groups
                $groupedKeys = [];
                foreach ($groups as $groupName => $keysInGroup) {
                    foreach ($keysInGroup as $key) {
                        $groupedKeys[$key] = $groupName; // Keep track of which group a key belongs to
                    }
                }
                // Find keys that are in $envFields but not in any defined group
                $otherFields = array_diff_key($envFields, $groupedKeys);
            @endphp

            {{-- Application Settings Group --}}
            <fieldset class="border border-gray-300 p-4 rounded-lg">
                <legend class="text-lg font-semibold text-gray-700 px-2">
                    <i class="fas fa-cogs {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_app_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                    @foreach($groups['application'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include('quickstart::installer.partials.env_field', compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>

            {{-- Database Settings Group --}}
            <fieldset class="border border-gray-300 p-4 rounded-lg">
                <legend class="text-lg font-semibold text-gray-700 px-2">
                    <i class="fas fa-database {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_db_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                     @foreach($groups['database'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include('quickstart::installer.partials.env_field', compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>

            {{-- Mail Settings Group --}}
            @if(count(array_intersect(array_keys($envFields), $groups['mail'])) > 0)
            <fieldset class="border border-gray-300 p-4 rounded-lg">
                <legend class="text-lg font-semibold text-gray-700 px-2">
                    <i class="fas fa-envelope {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_mail_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                     @foreach($groups['mail'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include('quickstart::installer.partials.env_field', compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- Driver Settings Group --}}
            @if(count(array_intersect(array_keys($envFields), $groups['drivers'])) > 0)
            <fieldset class="border border-gray-300 p-4 rounded-lg">
                <legend class="text-lg font-semibold text-gray-700 px-2">
                    <i class="fas fa-cogs {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_driver_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                     @foreach($groups['drivers'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include('quickstart::installer.partials.env_field', compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- Redis Settings Group --}}
            @if(count(array_intersect(array_keys($envFields), $groups['redis'])) > 0)
            <fieldset class="border border-gray-300 p-4 rounded-lg">
                <legend class="text-lg font-semibold text-gray-700 px-2">
                    <i class="fab fa-redis {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_redis_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                     @foreach($groups['redis'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include('quickstart::installer.partials.env_field', compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- reCAPTCHA Settings Group --}}
             @if(count(array_intersect(array_keys($envFields), $groups['recaptcha'])) > 0)
            <fieldset class="border border-gray-300 p-4 rounded-lg">
                <legend class="text-lg font-semibold text-gray-700 px-2">
                    <i class="fas fa-shield-alt {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_recaptcha_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                     @foreach($groups['recaptcha'] as $key)
                        @if(isset($envFields[$key]))
                            @php $field = $envFields[$key]; @endphp
                            @include('quickstart::installer.partials.env_field', compact('key', 'field', 'currentEnvValues'))
                        @endif
                    @endforeach
                </div>
            </fieldset>
            @endif

            {{-- Other Settings (if any) --}}
            @if(!empty($otherFields))
            <fieldset class="border border-gray-300 p-4 rounded-lg">
                <legend class="text-lg font-semibold text-gray-700 px-2">
                    <i class="fas fa-sliders-h {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.env_group_other_settings') }}
                </legend>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mt-4">
                    @foreach($otherFields as $key => $fieldConfig) {{-- Iterate over $otherFields which contains key => config --}}
                        @php $field = $fieldConfig; @endphp {{-- $field is already the config array --}}
                        @include('quickstart::installer.partials.env_field', compact('key', 'field', 'currentEnvValues'))
                    @endforeach
                </div>
            </fieldset>
            @endif

        @endif

        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
            <a href="{{ route('quickstart.install.permissions') }}"
               class="w-full md:w-auto mb-4 md:mb-0 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg flex items-center justify-center">
                <i class="fas fa-arrow-left {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.req_btn_prev') }}
            </a>
            <button type="submit"
                    class="w-full md:w-auto bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg flex items-center justify-center">
                {{ __('quickstart::installer.env_btn_save_continue') }} <i class="fas fa-save {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-1' : 'ml-1' }}"></i>
            </button>
        </div>
    </form>
@endsection
