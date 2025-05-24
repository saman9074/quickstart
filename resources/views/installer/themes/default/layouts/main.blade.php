<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ __('quickstart::installer.direction') === 'rtl' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? __('quickstart::installer.default_page_title') }} - {{ config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name')) }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer utilities {
            .step-active {
                @apply bg-sky-600 text-white;
            }
            .step-inactive {
                @apply bg-gray-200 text-gray-700 hover:bg-gray-300;
            }
            .step-completed {
                @apply bg-green-500 text-white;
            }
            /* Custom scrollbar (optional) */
            ::-webkit-scrollbar {
                width: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{-- Add specific styles for RTL if needed --}}
    @if(__('quickstart::installer.direction') === 'rtl')
    <style>
        body {
            /* Example: Change font for Persian */
            /* font-family: 'Vazirmatn', sans-serif; */
        }
        .step-active i, .step-completed i {
            margin-left: 0; /* Reset margin for icons */
            margin-right: auto; /* Push icons to the left in RTL */
        }
        .fa-arrow-right { /* Ensure arrow points correctly in RTL */
            transform: scaleX(-1);
        }
        .fa-arrow-left {
             transform: scaleX(-1);
        }
        /* Adjust icon margins for RTL */
        .fa-rocket.mr-2 { margin-right: 0; margin-left: 0.5rem; }
        /* Add other RTL specific adjustments here */
    </style>
    @endif

</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="min-h-screen flex flex-col items-center justify-center py-8 px-4">
        <div class="w-full max-w-3xl bg-white shadow-xl rounded-lg overflow-hidden">
            <header class="bg-sky-700 p-6 text-white">
                <h1 class="text-3xl font-bold text-center">
                    <i class="fas fa-rocket {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}"></i> {{-- The config value itself should be a translation key or translated --}}
                    {{ __(config('quickstart.welcome_message_key', 'quickstart::installer.header_title_fallback')) }}
                </h1>
            </header>

            <div class="flex flex-col md:flex-row">
                <aside class="w-full md:w-1/4 bg-gray-50 p-6 border-r border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">{{ __('quickstart::installer.steps_navigation_title') }}</h2>
                    <nav>
                        <ul>
                            @if(isset($allSteps) && is_array($allSteps) && count($allSteps) > 0)
                                @foreach($allSteps as $step) {{-- Removed $index, will use $loop --}}
                                    @php
                                        $isCurrent = ($currentStepKey ?? '') === $step['key'];
                                        // Use $loop->index (0-based) for comparison with $currentStepIndex (0-based)
                                        $isCompleted = ($currentStepIndex !== false && $loop->index < $currentStepIndex);
                                        $stepClass = 'step-inactive';
                                        if ($isCurrent) {
                                            $stepClass = 'step-active';
                                        } elseif ($isCompleted) {
                                            $stepClass = 'step-completed';
                                        }
                                    @endphp
                                    <li class="mb-2">
                                        <a href="{{ $isCompleted || $isCurrent ? $step['route'] : '#' }}"
                                           class="block px-4 py-2 rounded-md text-sm font-medium transition-colors duration-150 {{ $stepClass }} {{ !($isCompleted || $isCurrent) ? 'opacity-50 cursor-not-allowed' : '' }}">
                                            {{-- Use $loop->iteration (1-based) for display --}}
                                            <span class="{{ __('quickstart::installer.direction') === 'rtl' ? 'ml-2' : 'mr-2' }}">{{ $loop->iteration }}.</span> {{ $step['title'] }}
                                            @if($isCompleted)
                                                <i class="fas fa-check-circle {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-auto' : 'ml-auto' }} text-xs"></i>
                                            @elseif($isCurrent)
                                                <i class="fas fa-arrow-right {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-auto' : 'ml-auto' }} text-xs"></i>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-gray-500 text-sm">{{ __('quickstart::installer.steps_loading_error') }}</li>
                            @endif
                        </ul>
                    </nav>
                </aside>

                <main class="w-full md:w-3/4 p-6 md:p-8">
                    {{-- $pageTitle should be a translated string passed from the controller --}}
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ $pageTitle ?? __('quickstart::installer.default_page_title') }}</h2>

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                            <p class="font-bold">{{ __('quickstart::installer.error_title') }}</p>
                            <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-4' : 'list-inside pl-4' }}">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li> {{-- Individual errors are usually already translated by Laravel's validator --}}
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @foreach (['success', 'warning', 'info'] as $msgType)
                        @if (session($msgType))
                            <div class="p-4 mb-6 rounded-md
                                @if($msgType == 'success') bg-green-100 border-l-4 border-green-500 text-green-700 @endif
                                @if($msgType == 'warning') bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 @endif
                                @if($msgType == 'info') bg-blue-100 border-l-4 border-blue-500 text-blue-700 @endif
                            " role="alert">
                                {{-- Session messages should ideally be set using translated strings from the controller --}}
                                {{ session($msgType) }}
                            </div>
                        @endif
                    @endforeach

                    @yield('content')
                </main>
            </div>

            <footer class="bg-gray-100 border-t border-gray-200 p-4 text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} {{ config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name')) }}. {{ __('quickstart::installer.footer_powered_by') }}
                <a href="https://github.com/saman9074" target="_blank" class="text-sky-600 hover:text-sky-800">Saman9074</a>
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
