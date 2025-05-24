@extends($layout_path)

@section('content')
    <div class="prose max-w-none {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-gray-700 mb-6">
            {{ __('quickstart::installer.req_intro') }}
        </p>
    </div>

    <div class="mb-8 p-4 border rounded-lg @if($phpVersionOk) border-green-300 bg-green-50 @else border-red-300 bg-red-50 @endif">
        <h3 class="text-lg font-semibold mb-3 flex items-center @if($phpVersionOk) text-green-700 @else text-red-700 @endif">
            <i class="fab fa-php fa-fw {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }} text-2xl"></i> {{ __('quickstart::installer.req_php_version_check') }}
            @if($phpVersionOk)
                <span class="{{ __('quickstart::installer.direction') === 'rtl' ? 'mr-auto' : 'ml-auto' }} text-xs bg-green-500 text-white px-2 py-1 rounded-full">{{ __('quickstart::installer.req_php_ok') }}</span>
            @else
                <span class="{{ __('quickstart::installer.direction') === 'rtl' ? 'mr-auto' : 'ml-auto' }} text-xs bg-red-500 text-white px-2 py-1 rounded-full">{{ __('quickstart::installer.req_php_fail') }}</span>
            @endif
        </h3>
        <p class="text-sm text-gray-600">
            {{ __('quickstart::installer.req_php_version_required', ['version' => $requiredPhpVersion]) }}
        </p>
        <p class="text-sm text-gray-600">
            {{ __('quickstart::installer.req_php_version_current', ['version' => $phpVersion]) }}
        </p>
        @if(!$phpVersionOk)
            <p class="mt-2 text-sm text-red-600">
                <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.req_php_version_fail') }}
            </p>
        @endif
    </div>

    <div class="mb-8 p-4 border rounded-lg">
        <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
            <i class="fas fa-puzzle-piece fa-fw {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }} text-xl"></i> {{ __('quickstart::installer.req_extensions_check') }}
        </h3>
        @if(empty($extensionsStatus))
            <p class="text-sm text-gray-500">{{ __('quickstart::installer.req_extension_not_defined') }}</p>
        @else
            <ul class="list-none space-y-2">
                @php $allExtensionsOk = true; @endphp
                @foreach($extensionsStatus as $extension => $isLoaded)
                    @if(!$isLoaded) @php $allExtensionsOk = false; @endphp @endif
                    <li class="flex items-center justify-between p-2 rounded-md @if($isLoaded) bg-green-50 border border-green-200 @else bg-red-50 border border-red-200 @endif">
                        <span class="text-sm @if($isLoaded) text-green-700 @else text-red-700 @endif">
                            {{ $extension }}
                        </span>
                        @if($isLoaded)
                            <i class="fas fa-check-circle text-green-500"></i>
                        @else
                            <i class="fas fa-times-circle text-red-500"></i>
                        @endif
                    </li>
                @endforeach
            </ul>
            @if(!$allExtensionsOk)
                <div class="mt-3 text-sm text-red-600 {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i>
                    {!! __('quickstart::installer.req_extensions_missing') !!} {{-- Using {!! !!} because the lang string contains HTML (icon) --}}
                </div>
            @endif
        @endif
    </div>

    @php
        $canProceed = $phpVersionOk && (!isset($allExtensionsOk) || $allExtensionsOk);
    @endphp

    <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
        <a href="{{ route('quickstart.install.welcome') }}"
           class="w-full md:w-auto mb-4 md:mb-0 text-center bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg flex items-center justify-center">
            <i class="fas fa-arrow-left {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{ __('quickstart::installer.req_btn_prev') }}
        </a>
        @if($canProceed)
            <form method="POST" action="{{ route('quickstart.install.requirements') }}" class="w-full md:w-auto">
                @csrf
                <button type="submit"
                        class="w-full md:w-auto bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg flex items-center justify-center">
                    {{ __('quickstart::installer.req_btn_next') }} <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"></i>
                </button>
            </form>
        @else
             <div class="w-full md:w-auto flex flex-col items-center {{ __('quickstart::installer.direction') === 'rtl' ? 'md:items-start' : 'md:items-end' }}">
                <button type="button"
                        disabled
                        class="w-full md:w-auto bg-gray-400 cursor-not-allowed text-white font-semibold py-3 px-6 rounded-lg shadow-md text-lg flex items-center justify-center">
                    {{ __('quickstart::installer.req_btn_next') }} <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-2' : 'ml-2' }}"></i>
                </button>
                <p class="text-sm text-red-600 mt-2 {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                    <i class="fas fa-exclamation-triangle {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-1' : 'mr-1' }}"></i> {{ __('quickstart::installer.req_resolve_issues') }}
                </p>
            </div>
        @endif
    </div>
@endsection
