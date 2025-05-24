{{-- This view should extend the layout path provided by the controller --}}
@extends($layout_path)

@section('content')
    {{-- Language Selector --}}
    @php
        $supportedLocales = config('quickstart.supported_locales', ['en' => 'quickstart::installer.language_english']);
    @endphp
    @if(isset($supportedLocales) && is_array($supportedLocales) && count($supportedLocales) > 1)
    <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
        <form method="POST" action="{{ route('quickstart.install.setLocale') }}" class="flex items-center justify-center md:justify-end">
            @csrf
            <label for="locale_switcher" class="text-sm font-medium text-gray-700 dark:text-gray-300 {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}">{{ __('quickstart::installer.language_select_label') }}:</label>
            <select name="locale" id="locale_switcher" onchange="this.form.submit()"
                    class="py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 text-sm">
                @foreach($supportedLocales as $localeCode => $localeNameKey)
                    <option value="{{ $localeCode }}" {{ app()->getLocale() === $localeCode ? 'selected' : '' }}>{{ __($localeNameKey) }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @endif

    <div class="prose prose-sm sm:prose-base max-w-none dark:prose-invert {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
            {!! __('quickstart::installer.welcome_intro', ['app_name' => '<strong>'.config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name')).'</strong>']) !!}
        </p>

        <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-lg shadow-sm mb-6">
            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-3">
                {{ __('quickstart::installer.welcome_checklist_title') }}
            </p>
            <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-5' : 'list-inside pl-5' }} text-gray-600 dark:text-gray-400 space-y-1 text-sm">
                <li>{{ __('quickstart::installer.welcome_checklist_item_db') }}</li>
                <li>{{ __('quickstart::installer.welcome_checklist_item_req') }}</li>
                <li>{{ __('quickstart::installer.welcome_checklist_item_perm') }}</li>
            </ul>
        </div>

        <p class="text-gray-600 dark:text-gray-400 mb-8">
            {{ __('quickstart::installer.welcome_start_process_message') }}
        </p>
    </div>

    <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-center sm:justify-end">
        <form method="GET" action="{{ route('quickstart.install.requirements') }}">
            {{-- No CSRF needed for GET --}}
            <button type="submit"
                    class="w-full sm:w-auto bg-sky-600 hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-600 text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-all duration-150 ease-in-out text-lg inline-flex items-center justify-center">
                <span>{{ __('quickstart::installer.welcome_start_button') }}</span>
                <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-2 animate-pulse-rtl' : 'ml-2 animate-pulse' }}"></i>
            </button>
        </form>
    </div>
@endsection

{{-- Add pulse animation styles for the button icon --}}
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
    .list-inside-rtl { list-style-position: inside; } /* For better bullet alignment in RTL */
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
