@extends('quickstart::installer.layouts.main')

@section('content')
    <div class="text-center">
        <div class="mb-8">
            <svg class="w-24 h-24 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ __('quickstart::installer.finished_header') }}</h2>

        <div class="prose max-w-none {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }} mx-auto bg-gray-50 p-6 rounded-lg shadow">
            <p class="text-gray-700 mb-4">
                {{ __('quickstart::installer.finished_intro', ['app_name' => config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name'))]) }}
            </p>
            <p class="text-gray-600 mb-4">
                {{ __('quickstart::installer.finished_install_flag_info', ['path' => storage_path(config('quickstart.installed_flag_file', 'installed.flag'))]) }}
            </p>
            <p class="text-gray-600 mb-6">
                <strong>{{ __('quickstart::installer.finished_next_steps_title') }}</strong>
            </p>
            <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-4' : 'list-inside pl-4' }} text-gray-600 space-y-2 mb-6">
                <li>{{ __('quickstart::installer.finished_next_step_env') }}</li>
                <li>{{ __('quickstart::installer.finished_next_step_cron') }}</li>
                <li>{{ __('quickstart::installer.finished_next_step_permissions') }}</li>
                <li>{{ __('quickstart::installer.finished_next_step_debug') }}</li>
            </ul>
        </div>

        <div class="mt-10">
            <a href="{{ url('/') }}"
               class="w-full sm:w-auto bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg inline-flex items-center justify-center">
                <i class="fas fa-home {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.finished_btn_go_home') }}
            </a>
        </div>

        @if(config('app.env') === 'local' || config('app.debug') === true)
        <div class="mt-8 text-sm text-gray-500 {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
            <p class="font-semibold">{{ __('quickstart::installer.finished_dev_info_title') }}</p>
            <p>{{ __('quickstart::installer.finished_dev_info_rerun') }}</p>
            <code class="block bg-gray-100 p-2 rounded-md mt-1 text-xs {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">{{ storage_path(config('quickstart.installed_flag_file', 'installed.flag')) }}</code>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    // Optional: Prevent back button from going to previous installer steps
    // This is a simple history manipulation, might not be foolproof
    (function () {
        if (window.history && window.history.pushState) {
            // Push a new state to effectively "clear" the back history for installer pages
            window.history.pushState('forward', null, './#forward'); // Use a relative path or a path that makes sense for the finished page
            window.addEventListener('popstate', function (event) {
                // If user tries to go back, push them forward again to the current "finished" page
                // Or redirect them to the application's home page
                window.history.pushState('forward', null, './#forward');
                // Alternatively, redirect to home:
                // window.location.href = "{{ url('/') }}";
            });
        }
    })();
</script>
@endpush
