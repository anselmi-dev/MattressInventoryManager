<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('favicon/cropped-favicon-32x32.png') }}" sizes="32x32">
        <link rel="icon" href="{{ asset('favicon/cropped-favicon-192x192.png') }}" sizes="192x192">
        <link rel="apple-touch-icon" href="{{ asset('favicon/cropped-favicon-180x180.png') }}">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/cropped-favicon-270x270.png') }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
        <script
            src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-tooltip@1.x.x/dist/cdn.min.js"
            defer
        ></script>
        <style>
            [x-cloak] {
                display: none;
            }
        </style>
        <script>
            document.addEventListener('livewire:navigate', (event) => {
                document.body.classList.remove('in');
                document.body.classList.add('out');
            })

            document.addEventListener('livewire:navigated', () => {
                document.body.classList.remove('out');
                document.body.classList.add('in');
            })
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.scss', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <wireui:scripts />
        <!-- Adds the Core Table Styles -->
        @rappasoftTableStyles

        <!-- Adds any relevant Third-Party Styles (Used for DateRangeFilter (Flatpickr) and NumberRangeFilter) -->
        @rappasoftTableThirdPartyStyles

        <style>
            #modal-container {
                overflow: initial !important;
            }
        </style>

        @stack('styles')

    </head>
    <body class="font-sans antialiased">
        <x-banner />
        <x-wireui:dialog />
        <x-wireui:notifications />
        <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
            <div id="app-header" class="relative z-1">
                @livewire('navigation-menu')
            </div>

            <div id="app-content">
                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')

        @stack('scripts')

        @livewireScripts

        @livewire('wire-elements-modal')

        @stack('scripts-end')
    </body>
</html>
