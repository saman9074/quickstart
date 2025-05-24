{{-- This view should extend the layout path provided by the controller --}}
@extends($layout_path)

@section('content')
    <div class="prose prose-sm sm:prose-base max-w-none dark:prose-invert {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            {{ __('quickstart::installer.perm_intro') }}
        </p>
    </div>

    <div class="mb-6 p-4 sm:p-5 border border-gray-200 dark:border-gray-700/50 rounded-lg shadow-sm bg-white/70 dark:bg-slate-800/80">
        <h3 class="text-md sm:text-lg font-semibold mb-3 text-gray-800 dark:text-gray-200 flex items-center">
            <i class="fas fa-folder-open fa-fw {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }} text-xl sm:text-2xl text-teal-600 dark:text-teal-400"></i>
            {{ __('quickstart::installer.perm_folder_check_title') }}
        </h3>
        @if(empty($permissionsStatus))
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('quickstart::installer.perm_not_defined') }}</p>
        @else
            <ul class="list-none space-y-2">
                @php $allPermissionsOk = true; @endphp
                @foreach($permissionsStatus as $directory => $isWritable)
                    @if(!$isWritable) @php $allPermissionsOk = false; @endphp @endif
                    <li class="flex items-center justify-between p-3 rounded-md text-sm @if($isWritable) bg-emerald-500/10 dark:bg-emerald-600/20 border border-emerald-500/20 dark:border-emerald-600/40 @else bg-red-500/10 dark:bg-red-600/20 border border-red-500/20 dark:border-red-600/40 @endif">
                        <span class="font-mono text-sm @if($isWritable) text-emerald-700 dark:text-emerald-300 @else text-red-700 dark:text-red-300 @endif {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                            {{ $directory }}
                        </span>
                        @if($isWritable)
                            <span class="flex items-center text-xs bg-emerald-500 dark:bg-emerald-600 text-white px-2.5 py-1 rounded-full">
                                <i class="fas fa-check-circle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.perm_writable') }}
                            </span>
                        @else
                            <span class="flex items-center text-xs bg-red-500 dark:bg-red-600 text-white px-2.5 py-1 rounded-full">
                                <i class="fas fa-times-circle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.perm_not_writable') }}
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
            @if(!$allPermissionsOk)
                <div class="mt-4 text-sm text-red-600 dark:text-red-400 p-3 bg-red-500/10 dark:bg-red-600/20 border border-red-500/20 dark:border-red-600/40 rounded-md {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i>
                    {!! __('quickstart::installer.perm_resolve_issues') !!}
                </div>
            @endif
        @endif
    </div>

    @php
        $canProceed = (!isset($allPermissionsOk) || $allPermissionsOk);
    @endphp

    <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700/50 flex flex-col sm:flex-row justify-between items-center gap-4">
        <a href="{{ route('quickstart.install.requirements') }}"
           class="button-secondary-pg w-full sm:w-auto">
            <i class="fas fa-arrow-left {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>
            <span>{{ __('quickstart::installer.req_btn_prev') }}</span>
        </a>
        @if($canProceed)
            <form method="POST" action="{{ route('quickstart.install.permissions') }}" class="w-full sm:w-auto">
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
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.perm_resolve_folder_issues_proceed') }}
                </p>
                @endif
            </div>
        @endif
    </div>
@endsection

