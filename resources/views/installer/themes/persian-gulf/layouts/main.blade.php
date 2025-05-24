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
                font-family: 'Vazirmatn', 'Inter', sans-serif;
            }
            body.theme-persian-gulf {
                @apply bg-slate-100 dark:bg-slate-900 text-gray-800 dark:text-gray-200;
                /* Enhanced background: Waves at the bottom, sky gradient at the top */
                background-image:
                    /* Subtle wave SVG pattern at the bottom */
                    url("data:image/svg+xml,%3Csvg width='80' height='40' viewBox='0 0 80 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230d9488' fill-opacity='0.07'%3E%3Cpath d='M0 40C20 40 20 0 40 0s20 40 40 40V0C60 0 60 40 40 40S20 0 0 0z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"),
                    /* Sky gradient */
                    linear-gradient(to bottom, rgba(135, 206, 250, 0.15) 0%, rgba(240, 248, 255, 0) 60%);
                background-repeat: repeat-x, no-repeat;
                background-position: bottom, top;
                background-size: auto 80px, 100% 100%; /* Control wave height */
                background-attachment: fixed;
            }
        }
        @layer utilities {
            .theme-persian-gulf .step {
                @apply flex items-center text-gray-600 dark:text-gray-400 relative;
            }
            .theme-persian-gulf .step-circle {
                @apply flex items-center justify-center w-10 h-10 rounded-lg lg:h-12 lg:w-12 shrink-0 transition-all duration-300 border-2 shadow-md;
                /* Teal border, slightly off-white background for depth */
                @apply border-teal-500 bg-white dark:bg-slate-700 dark:border-teal-400 text-teal-600 dark:text-teal-300;
            }
            .theme-persian-gulf .step-line {
                @apply w-full h-1.5 bg-teal-200 dark:bg-teal-800 hidden sm:block rounded-full;
            }
            .theme-persian-gulf .step.step-active .step-circle {
                @apply bg-teal-500 text-white border-teal-600 dark:bg-teal-500 dark:border-teal-300 shadow-xl scale-110 ring-4 ring-teal-500/30 dark:ring-teal-400/30;
            }
            .theme-persian-gulf .step.step-completed .step-circle {
                @apply bg-emerald-500 text-white border-emerald-600 dark:bg-emerald-500 dark:border-emerald-300;
            }
            .theme-persian-gulf .step.step-completed .step-label {
                @apply text-emerald-700 dark:text-emerald-400 font-semibold;
            }
            .theme-persian-gulf .step.step-active .step-label {
                @apply text-teal-700 dark:text-teal-300 font-bold;
            }
            .theme-persian-gulf .step .step-label {
                @apply font-medium {{ __('quickstart::installer.direction') === 'rtl' ? 'mr-3' : 'ml-3' }} hidden sm:block text-gray-700 dark:text-gray-300;
            }
            .card-persian-gulf {
                /* Slightly more opaque, more pronounced blur, softer shadow */
                @apply bg-white/80 dark:bg-slate-800/85 backdrop-blur-xl shadow-2xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700/50;
            }
            .header-persian-gulf {
                /* Richer gradient, perhaps with a hint of gold/sunset orange */
                @apply bg-gradient-to-br from-sky-600 via-teal-600 to-emerald-600 dark:from-sky-700 dark:via-teal-700 dark:to-emerald-700;
                @apply p-6 text-white shadow-lg;
            }
            .button-primary-pg {
                @apply bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 dark:from-teal-600 dark:to-emerald-700 dark:hover:from-teal-700 dark:hover:to-emerald-800 text-white;
                @apply font-semibold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-500/50 dark:focus:ring-teal-400/50 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all duration-200 ease-in-out text-lg inline-flex items-center justify-center;
            }
            .button-secondary-pg {
                @apply bg-slate-500 hover:bg-slate-600 dark:bg-slate-600 dark:hover:bg-slate-700 text-white;
                @apply font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all duration-150 ease-in-out text-lg inline-flex items-center justify-center;
            }
            .poem-container {
                @apply border-t-2 border-b-2 border-teal-500/30 dark:border-teal-400/30 py-3 my-3 bg-teal-500/5 dark:bg-teal-400/5 rounded-md;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar { width: 8px; height: 8px; }
            ::-webkit-scrollbar-track { background: rgba(204, 229, 229, 0.3); /* Lighter tealish */ border-radius: 4px;}
            ::-webkit-scrollbar-thumb { background: #0D9488; /* teal-600 */ border-radius: 4px;}
            ::-webkit-scrollbar-thumb:hover { background: #0F766E; /* teal-700 */ }
        }
    </style>
    @if(__('quickstart::installer.direction') === 'rtl')
    <style>
        .fa-arrow-right { transform: scaleX(-1); }
        .fa-arrow-left { transform: scaleX(-1); }
        .rtl .fa-ship { margin-left: 0.75rem; margin-right: 0; }
        .ltr .fa-ship { margin-right: 0.75rem; margin-left: 0; }
    </style>
    @endif
</head>
<body class="theme-persian-gulf antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center py-6 sm:py-12 px-4">
        <div class="w-full max-w-4xl">
            <div class="text-center mb-10">
                <a href="{{ route('quickstart.install.welcome') }}" class="inline-flex items-center text-3xl sm:text-4xl font-extrabold text-teal-600 dark:text-teal-400 tracking-tight group">
                    <i class="fas fa-ship text-4xl sm:text-5xl group-hover:text-teal-500 dark:group-hover:text-teal-300 transition-colors duration-300 {{ __('quickstart::installer.direction') === 'rtl' ? 'ml-3' : 'mr-3' }}"></i>
                    <span>{{ __(config('quickstart.welcome_message_key', 'quickstart::installer.header_title_fallback')) }}</span>
                </a>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic">{{ __('quickstart::installer.persian_gulf_subtitle') }}</p>
                {{-- Persian Gulf Poem --}}
                <div class="poem-container mt-6 text-teal-700 dark:text-teal-300 font-medium text-sm sm:text-base">
                    <p class="leading-relaxed">{{ __('quickstart::installer.persian_gulf_poem_line1') }}</p>
                    <p class="leading-relaxed">{{ __('quickstart::installer.persian_gulf_poem_line2') }}</p>
                </div>
            </div>

            @if(isset($allSteps) && is_array($allSteps) && count($allSteps) > 0)
            <ol class="items-center justify-center w-full space-y-4 sm:flex sm:space-x-6 sm:space-y-0 rtl:space-x-reverse mb-12 px-2 sm:px-0">
                @foreach($allSteps as $step)
                    @php
                        $isCurrent = ($currentStepKey ?? '') === $step['key'];
                        $isCompleted = ($currentStepIndex !== false && $loop->index < $currentStepIndex);
                        $isLast = $loop->last;
                    @endphp
                    <li class="step {{ $isCurrent ? 'step-active' : '' }} {{ $isCompleted ? 'step-completed' : '' }} {{ $isLast ? 'flex-none' : 'flex-1' }}">
                        <a href="{{ $isCompleted || $isCurrent ? $step['route'] : '#' }}" class="flex flex-col sm:flex-row items-center group {{ !($isCompleted || $isCurrent) ? 'opacity-60 cursor-not-allowed' : '' }}">
                            <div class="step-circle group-hover:shadow-lg group-hover:border-teal-600 dark:group-hover:border-teal-300">
                                @if($isCompleted)
                                    <i class="fas fa-check w-5 h-5 lg:w-6 lg:h-6"></i>
                                @elseif($isCurrent)
                                    <i class="fas fa-compass w-5 h-5 lg:w-6 lg:h-6 animate-pulse"></i>
                                @else
                                    <span class="text-sm lg:text-base font-medium">{{ $loop->iteration }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="step-label mt-2 sm:mt-0 group-hover:text-teal-600 dark:group-hover:text-teal-200">{{ $step['title'] }}</h3>
                            </div>
                        </a>
                        @if(!$isLast)
                        <div class="step-line flex-1 {{ $isCompleted ? 'bg-emerald-500 dark:bg-emerald-400' : '' }} {{ __('quickstart::installer.direction') === 'rtl' ? 'sm:mr-6' : 'sm:ml-6' }}"></div>
                        @endif
                    </li>
                @endforeach
            </ol>
            @endif

            <div class="card-persian-gulf">
                <div class="header-persian-gulf">
                     <h2 class="text-xl sm:text-2xl font-semibold text-center">{{ $pageTitle ?? __('quickstart::installer.default_page_title') }}</h2>
                </div>
                <div class="px-6 py-8 sm:p-10">
                    @if ($errors->any())
                        <div class="bg-red-100 dark:bg-red-800/40 border-l-4 border-red-500 dark:border-red-400 text-red-700 dark:text-red-200 p-4 mb-6 rounded-md shadow" role="alert">
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
                                @if($msgType == 'success') bg-green-100 dark:bg-green-800/40 border-l-4 border-green-500 dark:border-green-400 text-green-700 dark:text-green-200 @endif
                                @if($msgType == 'warning') bg-yellow-100 dark:bg-yellow-800/40 border-l-4 border-yellow-500 dark:border-yellow-400 text-yellow-700 dark:text-yellow-200 @endif
                                @if($msgType == 'info') bg-sky-100 dark:bg-sky-800/40 border-l-4 border-sky-500 dark:border-sky-400 text-sky-700 dark:text-sky-200 @endif
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
                <a href="https://github.com/saman9074" target="_blank" class="text-teal-600 hover:text-teal-500 dark:text-teal-400 dark:hover:text-teal-300 transition-colors">Saman9074</a>
            </footer>
        </div>
    </div>
    @stack('styles')
    @stack('scripts')
</body>
</html>
