@extends($layout_path)

@section('content')
    <div class="prose max-w-none">
        <p class="text-lg text-gray-700 mb-4">
            <i class="fas fa-check-circle text-green-500 {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.finalize_intro_success') }}
        </p>
        <p class="text-gray-600 mb-6">
            {{ __('quickstart::installer.finalize_intro_tasks') }}
        </p>

        @php
            $postInstallCommands = config('quickstart.post_install_commands', []);
            $installFlagFile = config('quickstart.installed_flag_file', 'installed.flag');
        @endphp

        @if(!empty($postInstallCommands))
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-gray-700 mb-2">{{ __('quickstart::installer.finalize_tasks_list_title') }}</h4>
                <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-4' : 'list-inside pl-4' }} text-sm text-gray-600 space-y-1">
                    @foreach($postInstallCommands as $command)
                        <li><code>php artisan {{ $command }}</code></li>
                    @endforeach
                    <li>{{ __('quickstart::installer.finalize_tasks_install_flag', ['filename' => $installFlagFile]) }}</li>
                </ul>
            </div>
        @else
            <p class="text-gray-600 mb-6">
                {{ __('quickstart::installer.finalize_no_post_commands') }}
            </p>
        @endif

        <p class="text-gray-600 mb-8">
            {{ __('quickstart::installer.finalize_warning') }}
        </p>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-200">
        <form method="POST" action="{{ route('quickstart.install.finalize') }}">
            @csrf
            <button type="submit"
                    class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg flex items-center justify-center">
                <i class="fas fa-cogs {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.finalize_btn_run') }}
            </button>
        </form>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('quickstart.install.environment') }}"
           class="text-sm text-gray-500 hover:text-sky-600 transition-colors">
            <i class="fas fa-arrow-left {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.finalize_btn_return_env') }}
        </a>
    </div>
@endsection
