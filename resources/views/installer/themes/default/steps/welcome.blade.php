@extends($layout_path)

@section('content')
    {{-- Language Selector --}}
    @php
        $supportedLocales = config('quickstart.supported_locales', ['en' => 'quickstart::installer.language_english']);
    @endphp
    @if(count($supportedLocales) > 1)
    <div class="mb-8 pb-6 border-b border-gray-200">
        <form method="POST" action="{{ route('quickstart.install.setLocale') }}" class="flex items-center justify-center md:justify-end">
            @csrf
            <label for="locale_switcher" class="text-sm font-medium text-gray-700 {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}">{{ __('quickstart::installer.language_select_label') }}:</label>
            <select name="locale" id="locale_switcher" onchange="this.form.submit()"
                    class="py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 text-sm">
                @foreach($supportedLocales as $localeCode => $localeNameKey)
                    <option value="{{ $localeCode }}" {{ app()->getLocale() === $localeCode ? 'selected' : '' }}>{{ __($localeNameKey) }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @endif

    <div class="prose max-w-none {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-lg text-gray-700 mb-6">
            {{ __('quickstart::installer.welcome_intro', ['app_name' => config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name'))]) }}
        </p>

        <p class="text-gray-600 mb-4">
            {{ __('quickstart::installer.welcome_checklist_title') }}
        </p>
        <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-4' : 'list-inside pl-4' }} text-gray-600 mb-6 space-y-1">
            <li>{{ __('quickstart::installer.welcome_checklist_item_db') }}</li>
            <li>{{ __('quickstart::installer.welcome_checklist_item_req') }}</li>
            <li>{{ __('quickstart::installer.welcome_checklist_item_perm') }}</li>
        </ul>

        <p class="text-gray-600 mb-8">
            {{ __('quickstart::installer.welcome_start_process_message') }}
        </p>
    </div>

    <div class="mt-8 pt-6 border-t border-gray-200">
        <form method="GET" action="{{ route('quickstart.install.requirements') }}">
            <button type="submit"
                    class="w-full md:w-auto bg-sky-600 hover:bg-sky-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out text-lg flex items-center justify-center">
                {{ __('quickstart::installer.welcome_start_button') }} <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-2 animate-pulse-rtl' : 'ml-2 animate-pulse' }}"></i>
            </button>
        </form>
    </div>
@endsection

@push('styles')
@if(__('quickstart::installer.direction') === 'rtl')
<style>
    .animate-pulse-rtl {
        animation: pulse-rtl 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse-rtl {
        0%, 100% { opacity: 1; transform: scaleX(-1) translateX(0); }
        50% { opacity: .5; transform: scaleX(-1) translateX(-2px); }
    }
</style>
@else
<style>
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
     @keyframes pulse {
        0%, 100% { opacity: 1; transform: translateX(0); }
        50% { opacity: .5; transform: translateX(2px); }
    }
</style>
@endif
@endpush
