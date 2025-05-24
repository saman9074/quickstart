{{-- This view should extend the layout path provided by the controller --}}
@extends($layout_path)

@section('content')
    {{-- Language Selector --}}
    @php
        $supportedLocales = config('quickstart.supported_locales', ['en' => 'quickstart::installer.language_english']);
    @endphp
    @if(isset($supportedLocales) && is_array($supportedLocales) && count($supportedLocales) > 1)
    <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700/50">
        <form method="POST" action="{{ route('quickstart.install.setLocale') }}" class="flex items-center justify-center md:justify-end">
            @csrf
            <label for="locale_switcher" class="text-sm font-medium text-gray-700 dark:text-gray-300 {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}">{{ __('quickstart::installer.language_select_label') }}:</label>
            <select name="locale" id="locale_switcher" onchange="this.form.submit()"
                    class="py-2 px-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400 text-sm">
                @foreach($supportedLocales as $localeCode => $localeNameKey)
                    <option value="{{ $localeCode }}" {{ app()->getLocale() === $localeCode ? 'selected' : '' }}>{{ __($localeNameKey) }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @endif

    <div class="prose prose-sm sm:prose-base max-w-none dark:prose-invert {{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">
        <p class="text-lg text-gray-800 dark:text-gray-200 mb-6">
            {!! __('quickstart::installer.welcome_intro', ['app_name' => '<span class="font-bold text-teal-600 dark:text-teal-400">'.config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name')).'</span>']) !!}
        </p>

        <div class="bg-teal-500/10 dark:bg-teal-400/10 p-4 rounded-lg shadow-sm mb-6 border border-teal-500/20 dark:border-teal-400/20">
            <p class="font-semibold text-teal-800 dark:text-teal-200 mb-3">
                <i class="fas fa-list-check {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i>{{ __('quickstart::installer.welcome_checklist_title') }}
            </p>
            <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-5' : 'list-inside pl-5' }} text-gray-700 dark:text-gray-300 space-y-1 text-sm">
                <li>{{ __('quickstart::installer.welcome_checklist_item_db') }}</li>
                <li>{{ __('quickstart::installer.welcome_checklist_item_req') }}</li>
                <li>{{ __('quickstart::installer.welcome_checklist_item_perm') }}</li>
            </ul>
        </div>

        <p class="text-gray-700 dark:text-gray-300 mb-8">
            {{ __('quickstart::installer.welcome_start_process_message') }}
        </p>
    </div>

    <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700/50 flex justify-center sm:justify-end">
        <form method="GET" action="{{ route('quickstart.install.requirements') }}">
            {{-- No CSRF needed for GET --}}
            <button type="submit"
                    class="button-primary-pg">
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
    .list-inside-rtl { list-style-position: inside; }
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
