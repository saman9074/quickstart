{{-- This view should extend the layout path provided by the controller --}}
@extends($layout_path)

@section('content')
    <div class="prose prose-sm sm:prose-base max-w-none dark:prose-invert {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-lg text-gray-800 dark:text-gray-200 mb-4 flex items-center">
            <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-3 text-xl' : 'mr-3 text-xl' }}"></i>
            <span>{{ __('quickstart::installer.finalize_intro_success') }}</span>
        </p>
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            {{ __('quickstart::installer.finalize_intro_tasks') }}
        </p>

        @php
            $postInstallCommands = config('quickstart.post_install_commands', []);
            $installFlagFile = config('quickstart.installed_flag_file', 'installed.flag');
        @endphp

        @if(!empty($postInstallCommands) || !empty($installFlagFile))
            <div class="bg-teal-500/10 dark:bg-teal-400/10 p-4 rounded-lg shadow-sm mb-6 border border-teal-500/20 dark:border-teal-400/20">
                <h4 class="font-semibold text-teal-800 dark:text-teal-200 mb-3 flex items-center">
                    <i class="fas fa-tasks {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
                    {{ __('quickstart::installer.finalize_tasks_list_title') }}
                </h4>
                <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-5' : 'list-inside pl-5' }} text-sm text-gray-700 dark:text-gray-300 space-y-1">
                    @foreach($postInstallCommands as $command)
                        <li><code class="text-xs bg-slate-200 dark:bg-slate-700 px-1 py-0.5 rounded">{{ __('quickstart::installer.command_prefix') }} {{ $command }}</code></li>
                    @endforeach
                    @if(!empty($installFlagFile))
                    <li>{{ __('quickstart::installer.finalize_tasks_install_flag', ['filename' => $installFlagFile]) }}</li>
                    @endif
                </ul>
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                {{ __('quickstart::installer.finalize_no_post_commands') }}
            </p>
        @endif

        <div class="mt-6 p-4 bg-sky-500/10 dark:bg-sky-400/10 border-l-4 border-sky-500 dark:border-sky-400 text-sky-800 dark:text-sky-200 rounded-md shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-xl"></i>
                </div>
                <div class="{{ __('quickstart::installer.direction') === 'rtl' ? 'mr-3' : 'ml-3' }} text-sm">
                    {{ __('quickstart::installer.finalize_warning') }}
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700/50 flex flex-col sm:flex-row justify-between items-center gap-4">
         <a href="{{ route('quickstart.install.environment') }}"
           class="button-secondary-pg w-full sm:w-auto order-2 sm:order-1">
            <i class="fas fa-arrow-left {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
            <span>{{ __('quickstart::installer.finalize_btn_return_env') }}</span>
        </a>
        <form method="POST" action="{{ route('quickstart.install.finalize') }}" class="w-full sm:w-auto order-1 sm:order-2">
            @csrf
            <button type="submit"
                    class="button-primary-pg w-full">
                <i class="fas fa-cogs {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
                <span>{{ __('quickstart::installer.finalize_btn_run') }}</span>
            </button>
        </form>
    </div>
@endsection
