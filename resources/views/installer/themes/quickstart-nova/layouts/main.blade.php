<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ __('quickstart::installer.direction') === 'rtl' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? __('quickstart::installer.default_page_title') }} - {{ config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name')) }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Vazirmatn:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" xintegrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style type="text/tailwindcss">
        @layer base {
            html {
                font-family: 'Inter', 'Vazirmatn', sans-serif;
            }
        }
        @layer utilities {
            .step {
                @apply flex items-center text-gray-500 dark:text-gray-400 relative;
            }
            .step .step-circle {
                @apply flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0 transition-colors duration-300;
            }
            .step .step-line {
                @apply w-full h-1 bg-gray-200 dark:bg-gray-700 hidden sm:block;
            }
            .step.step-active .step-circle {
                @apply bg-sky-600 text-white dark:bg-sky-500;
            }
            .step.step-completed .step-circle {
                @apply bg-green-600 text-white dark:bg-green-500;
            }
            .step.step-completed .step-label {
                @apply text-green-700 dark:text-green-400;
            }
            .step.step-active .step-label {
                @apply text-sky-700 dark:text-sky-400 font-semibold;
            }
            .step .step-label {
                @apply font-medium {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-3' : 'ml-3' }} hidden sm:block;
            }
            /* Custom scrollbar */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px;}
            ::-webkit-scrollbar-thumb { background: #c4c4c4; border-radius: 3px;}
            ::-webkit-scrollbar-thumb:hover { background: #a1a1a1; }
        }
    </style>
    @if(__('quickstart::installer.direction') === 'rtl')
    <style>
        .fa-arrow-right { transform: scaleX(-1); }
        .fa-arrow-left { transform: scaleX(-1); }
        /* Add other RTL specific adjustments here */
    </style>
    @endif
</head>
<body class="bg-gradient-to-br from-slate-50 to-gray-200 dark:from-slate-900 dark:to-gray-800 text-gray-800 dark:text-gray-200 antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center py-6 sm:py-12 px-4">
        <div class="w-full max-w-4xl">
            <div class="text-center mb-8">
                <a href="{{ route('quickstart.install.welcome') }}" class="inline-flex items-center text-3xl font-extrabold text-sky-600 dark:text-sky-400 tracking-tight">
                    <i class="fas fa-rocket {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-3' : 'mr-3' }} text-4xl"></i>
                    <span>{{ __(config('quickstart.welcome_message_key', 'quickstart::installer.header_title_fallback')) }}</span>
                </a>
            </div>

            @if(isset($allSteps) && is_array($allSteps) && count($allSteps) > 0)
            <ol class="items-center justify-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse mb-10 px-4 sm:px-0">
                @foreach($allSteps as $step)
                    @php
                        $isCurrent = ($currentStepKey ?? '') === $step['key'];
                        $isCompleted = ($currentStepIndex !== false && $loop->index < $currentStepIndex);
                        $isLast = $loop->last;
                    @endphp
                    <li class="step {{ $isCurrent ? 'step-active' : '' }} {{ $isCompleted ? 'step-completed' : '' }} {{ $isLast ? 'flex-none' : 'flex-1' }}">
                        <a href="{{ $isCompleted || $isCurrent ? $step['route'] : '#' }}" class="flex items-center {{ !($isCompleted || $isCurrent) ? 'opacity-60 cursor-not-allowed' : '' }}">
                            <div class="step-circle">
                                @if($isCompleted)
                                    <i class="fas fa-check w-5 h-5 lg:w-6 lg:h-6"></i>
                                @elseif($isCurrent)
                                    <i class="fas fa-arrow-right w-4 h-4 lg:w-5 lg:h-5"></i>
                                @else
                                    <span class="text-sm lg:text-base font-medium">{{ $loop->iteration }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="step-label">{{ $step['title'] }}</h3>
                                {{-- You can add a small description for each step here if needed --}}
                                {{-- <p class="text-xs">Step details</p> --}}
                            </div>
                        </a>
                        @if(!$isLast)
                        <div class="step-line flex-1 {{ $isCompleted ? 'bg-green-600 dark:bg-green-500' : '' }} {{ __('quickstart::installer.direction') === 'rtl' ? 'sm:mr-8' : 'sm:ml-8' }}"></div>
                        @endif
                    </li>
                @endforeach
            </ol>
            @endif

            <div class="bg-white dark:bg-slate-800 shadow-2xl rounded-xl overflow-hidden">
                <div class="px-6 py-8 sm:p-10">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2 text-center sm:{{ __('quickstart::installer.direction') === 'rtl' ? 'text-right' : 'text-left' }}">{{ $pageTitle ?? __('quickstart::installer.default_page_title') }}</h2>
                    <hr class="mb-8 border-gray-200 dark:border-gray-700">

                    @if ($errors->any())
                        <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 dark:border-red-400 text-red-700 dark:text-red-300 p-4 mb-6 rounded-md shadow" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-times-circle text-red-500 dark:text-red-400 mt-1"></i>
                                </div>
                                <div class="{{ __('quickstart::installer.direction') === 'rtl' ? 'mr-3' : 'ml-3' }}">
                                    <p class="font-semibold">{{ __('quickstart::installer.error_title') }}</p>
                                    <ul class="list-disc {{ __('quickstart::installer.direction') === 'rtl' ? 'list-inside-rtl pr-4' : 'list-inside pl-4' }} text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    @foreach (['success', 'warning', 'info'] as $msgType)
                        @if (session($msgType))
                            <div class="p-4 mb-6 rounded-md shadow
                                @if($msgType == 'success') bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 dark:border-green-400 text-green-700 dark:text-green-300 @endif
                                @if($msgType == 'warning') bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-500 dark:border-yellow-400 text-yellow-700 dark:text-yellow-300 @endif
                                @if($msgType == 'info') bg-sky-50 dark:bg-sky-900/30 border-l-4 border-sky-500 dark:border-sky-400 text-sky-700 dark:text-sky-300 @endif
                            " role="alert">
                                {{ session($msgType) }}
                            </div>
                        @endif
                    @endforeach

                    @yield('content')
                </div>
            </div>

            <footer class="mt-10 text-center text-sm text-gray-600 dark:text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name', __('quickstart::installer.footer_copyright_fallback_app_name')) }}. {{ __('quickstart::installer.footer_powered_by') }}
                <a href="https://github.com/saman9074" target="_blank" class="text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition-colors">Saman9074</a>
            </footer>
        </div>
    </div>
    @stack('styles') {{-- For page specific styles like pulse animation --}}
    @stack('scripts')
</body>
</html>
