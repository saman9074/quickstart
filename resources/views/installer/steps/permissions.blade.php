@extends('quickstart::installer.layouts.main')

@section('content')
    <div class="prose max-w-none {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-gray-700 mb-6">
            {{ __('quickstart::installer.perm_intro') }}
        </p>
    </div>

    <div class="mb-8 p-4 border rounded-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
            <i class="fas fa-folder-open fa-fw {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }} text-xl"></i> {{ __('quickstart::installer.perm_folder_check_title') }}
        </h3>
        @if(empty($permissionsStatus))
            <p class="text-sm text-gray-500">{{ __('quickstart::installer.perm_not_defined') }}</p>
        @else
            <ul class="list-none space-y-2">
                @php $allPermissionsOk = true; @endphp
                @foreach($permissionsStatus as $directory => $isWritable)
                    @if(!$isWritable) @php $allPermissionsOk = false; @endphp @endif
                    <li class="flex items-center justify-between p-3 rounded-md @if($isWritable) bg-green-50 border border-green-200 @else bg-red-50 border border-red-200 @endif">
                        <span class="text-sm font-mono @if($isWritable) text-green-700 @else text-red-700 @endif {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                            {{ $directory }}
                        </span>
                        @if($isWritable)
                            <span class="flex items-center text-xs bg-green-500 text-white px-2 py-1 rounded-full">
                                <i class="fas fa-check-circle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.perm_writable') }}
                            </span>
                        @else
                            <span class="flex items-center text-xs bg-red-500 text-white px-2 py-1 rounded-full">
                                <i class="fas fa-times-circle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.perm_not_writable') }}
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
            @if(!$allPermissionsOk)
                <div class="mt-4 text-sm text-red-600 {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i>
                    {!! __('quickstart::installer.perm_resolve_issues') !!} {{-- Using {!! !!} because the lang string might contain HTML (like <i> or <code>) --}}
                </div>
            @endif
        @endif
    </div>

    @php
        $canProceed = (!isset($allPermissionsOk) || $allPermissionsOk);
    @endphp

    <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
        <a href="{{ route('quickstart.install.requirements') }}"
           class="w-full md:w-auto mb-4 md:mb-0 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg flex items-center justify-center">
            <i class="fas fa-arrow-left {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.req_btn_prev') }}
        </a>
        @if($canProceed)
            <form method="POST" action="{{ route('quickstart.install.permissions') }}" class="w-full md:w-auto">
                @csrf
                <button type="submit"
                        class="w-full md:w-auto bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg flex items-center justify-center">
                    {{ __('quickstart::installer.req_btn_next') }} <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"></i>
                </button>
            </form>
        @else
            <div class="w-full md:w-auto flex flex-col items-center md:items-end">
                <button type="button"
                        disabled
                        class="w-full md:w-auto bg-gray-400 cursor-not-allowed text-white font-semibold py-3 px-6 rounded-lg shadow-md text-lg flex items-center justify-center">
                    {{ __('quickstart::installer.req_btn_next') }} <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"></i>
                </button>
                <p class="text-sm text-red-600 mt-2 {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.perm_resolve_folder_issues_proceed') }}
                </p>
            </div>
        @endif
    </div>
@endsection
