{{-- This view should extend the layout path provided by the controller --}}
@extends($layout_path)

@section('content')
    <div class="text-center">
        <div class="mb-8">
            {{-- A more thematic success icon, perhaps a pearl or a stylized sun --}}
            <svg class="w-24 h-24 text-emerald-500 dark:text-emerald-400 mx-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{-- Or keep the original checkmark if preferred:
            <svg class="w-24 h-24 text-emerald-500 dark:text-emerald-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg> --}}
        </div>

        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('quickstart::installer.finished_header') }}</h2>

        <div class="prose prose-sm sm:prose-base max-w-none {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }} mx-auto bg-emerald-500/10 dark:bg-emerald-400/10 p-6 rounded-lg shadow-md border border-emerald-500/20 dark:border-emerald-400/20">
            <p class="text-gray-700 dark:text-gray-200 mb-4">
                {!! __('quickstart::installer.finished_intro', ['app_name' => '<span class="font-semibold text-teal-600 dark:text-teal-400">'.config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name')).'</span>']) !!}
            </p>
            <p class="text-gray-600 dark:text-gray-300 mb-4 text-xs sm:text-sm">
                {!! __('quickstart::installer.finished_install_flag_info', ['path' => '<code class="text-xs bg-slate-200 dark:bg-slate-700 px-1 py-0.5 rounded">'.storage_path(config('quickstart.installed_flag_file', 'installed.flag')).'</code>']) !!}
            </p>
            <p class="text-gray-700 dark:text-gray-200 mb-3 mt-6 font-semibold">
                {{ __('quickstart::installer.finished_next_steps_title') }}
            </p>
            <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-5' : 'list-inside pl-5' }} text-gray-600 dark:text-gray-300 space-y-1.5 text-sm">
                <li>{{ __('quickstart::installer.finished_next_step_env') }}</li>
                <li>{{ __('quickstart::installer.finished_next_step_cron') }}</li>
                <li>{{ __('quickstart::installer.finished_next_step_permissions') }}</li>
                <li>{{ __('quickstart::installer.finished_next_step_debug') }}</li>
            </ul>
        </div>

        <div class="mt-10">
            <a href="{{ url('/') }}"
               class="button-primary-pg w-full sm:w-auto">
                <i class="fas fa-home {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
                <span>{{ __('quickstart::installer.finished_btn_go_home') }}</span>
            </a>
        </div>

        @if(config('app.env') === 'local' || config('app.debug') === true)
        <div class="mt-8 text-xs sm:text-sm text-gray-500 dark:text-gray-400 {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }} bg-slate-100 dark:bg-slate-800/50 p-3 rounded-md border border-slate-200 dark:border-slate-700">
            <p class="font-semibold mb-1">{{ __('quickstart::installer.finished_dev_info_title') }}</p>
            <p>{{ __('quickstart::installer.finished_dev_info_rerun') }}</p>
            <code class="block bg-slate-200 dark:bg-slate-700 p-1.5 rounded-md mt-1 text-xs break-all">{{ storage_path(config('quickstart.installed_flag_file', 'installed.flag')) }}</code>
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    // Optional: Prevent back button from going to previous installer steps
    (function () {
        if (window.history && window.history.pushState) {
            window.history.pushState('forward', null, './#finished'); // Use a more descriptive hash
            window.addEventListener('popstate', function (event) {
                if (event.state === 'forward' || event.state === null) { // Check if it's our state or initial state
                     // If user tries to go back from finished, push them forward again or to home
                    window.history.pushState('forward', null, './#finished');
                    // Alternatively, redirect to home:
                    // window.location.href = "{{ url('/') }}";
                }
            });
        }
    })();
</script>
@endpush
