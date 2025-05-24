{{-- This view should extend the layout path provided by the controller --}}
@extends($layout_path)

@section('content')
    <div class="prose prose-sm sm:prose-base max-w-none dark:prose-invert {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            {{ __('quickstart::installer.req_intro') }}
        </p>
    </div>

    <div class="mb-6 p-4 sm:p-5 border rounded-lg shadow-sm @if($phpVersionOk) border-emerald-500/30 dark:border-emerald-600/50 bg-emerald-500/10 dark:bg-emerald-600/20 @else border-red-500/30 dark:border-red-600/50 bg-red-500/10 dark:bg-red-600/20 @endif">
        <div class="flex items-center justify-between">
            <h3 class="text-md sm:text-lg font-semibold flex items-center @if($phpVersionOk) text-emerald-700 dark:text-emerald-300 @else text-red-700 dark:text-red-300 @endif">
                <i class="fab fa-php fa-fw {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }} text-xl sm:text-2xl"></i>
                {{ __('quickstart::installer.req_php_version_check') }}
            </h3>
            @if($phpVersionOk)
                <span class="text-xs font-medium bg-emerald-100 dark:bg-emerald-700 text-emerald-700 dark:text-emerald-200 px-2.5 py-1 rounded-full">{{ __('quickstart::installer.req_php_ok') }}</span>
            @else
                <span class="text-xs font-medium bg-red-100 dark:bg-red-700 text-red-700 dark:text-red-200 px-2.5 py-1 rounded-full">{{ __('quickstart::installer.req_php_fail') }}</span>
            @endif
        </div>
        <div class="mt-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-[calc(1.25rem+0.5rem)] sm:mr-[calc(1.5rem+0.5rem)]' : 'ml-[calc(1.25rem+0.5rem)] sm:ml-[calc(1.5rem+0.5rem)]' }}">
            <p>
                {!! __('quickstart::installer.req_php_version_required', ['version' => '<strong class="text-gray-700 dark:text-gray-200">'.$requiredPhpVersion.'</strong>']) !!}
            </p>
            <p>
                {!! __('quickstart::installer.req_php_version_current', ['version' => '<code class="px-1 py-0.5 bg-slate-200 dark:bg-slate-700 rounded text-xs">'.$phpVersion.'</code>']) !!}
            </p>
            @if(!$phpVersionOk)
                <p class="mt-1 text-red-600 dark:text-red-400">
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.req_php_version_fail_message') }}
                </p>
            @endif
        </div>
    </div>

    <div class="mb-6 p-4 sm:p-5 border border-gray-200 dark:border-gray-700/50 rounded-lg shadow-sm bg-white/70 dark:bg-slate-800/80">
        <h3 class="text-md sm:text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200 flex items-center">
            <i class="fas fa-puzzle-piece fa-fw {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }} text-xl sm:text-2xl"></i>
            {{ __('quickstart::installer.req_extensions_check') }}
        </h3>
        @if(empty($extensionsStatus))
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('quickstart::installer.req_extension_not_defined') }}</p>
        @else
            <ul class="list-none space-y-2">
                @php $allExtensionsOk = true; @endphp
                @foreach($extensionsStatus as $extension => $isLoaded)
                    @if(!$isLoaded) @php $allExtensionsOk = false; @endphp @endif
                    <li class="flex items-center justify-between p-2.5 rounded-md text-sm @if($isLoaded) bg-emerald-500/10 dark:bg-emerald-600/20 border border-emerald-500/20 dark:border-emerald-600/40 @else bg-red-500/10 dark:bg-red-600/20 border border-red-500/20 dark:border-red-600/40 @endif">
                        <span class="font-mono @if($isLoaded) text-emerald-700 dark:text-emerald-300 @else text-red-700 dark:text-red-300 @endif">
                            {{ $extension }}
                        </span>
                        @if($isLoaded)
                            <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400"></i>
                        @else
                            <i class="fas fa-times-circle text-red-500 dark:text-red-400"></i>
                        @endif
                    </li>
                @endforeach
            </ul>
            @if(!$allExtensionsOk)
                <div class="mt-3 text-sm text-red-600 dark:text-red-400 {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i>
                    {!! __('quickstart::installer.req_extensions_missing') !!}
                </div>
            @endif
        @endif
    </div>

    @php
        $canProceed = $phpVersionOk && (!isset($allExtensionsOk) || $allExtensionsOk);
    @endphp

    <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700/50 flex flex-col sm:flex-row justify-between items-center gap-4">
        <a href="{{ route('quickstart.install.welcome') }}"
           class="button-secondary-pg w-full sm:w-auto">
            <i class="fas fa-arrow-left {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
            <span>{{ __('quickstart::installer.req_btn_prev') }}</span>
        </a>
        @if($canProceed)
            <form method="POST" action="{{ route('quickstart.install.requirements') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit"
                        class="button-primary-pg w-full sm:w-auto">
                    <span>{{ __('quickstart::installer.req_btn_next') }}</span>
                    <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"></i>
                </button>
            </form>
        @else
            <div class="w-full sm:w-auto flex flex-col items-center {{ __('quickstart::installer.direction') === 'rtl' ? 'sm:items-start' : 'sm:items-end' }}">
                <button type="button"
                        disabled
                        class="w-full sm:w-auto bg-gray-400 dark:bg-gray-500 cursor-not-allowed text-white font-semibold py-3 px-6 rounded-lg shadow-md text-lg inline-flex items-center justify-center">
                    <span>{{ __('quickstart::installer.req_btn_next') }}</span>
                    <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"></i>
                </button>
                @if(!$canProceed)
                <p class="text-xs text-red-600 dark:text-red-400 mt-2 text-center sm:{{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.req_resolve_issues') }}
                </p>
                @endif
            </div>
        @endif
    </div>
@endsection
