<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none;
        }

    </style>

    <!-- Scripts -->
    <blade
        vite|(%5B%26%2339%3Bresources%2Fcss%2Fapp.scss%26%2339%3B%2C%20%26%2339%3Bresources%2Fjs%2Fapp.js%26%2339%3B%5D)>

        <!-- Styles -->
        @livewireStyles
            <wireui:scripts />

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
</head>

<body class="font-sans antialiased">
    @env('local', 'staging', 'develop')
        <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        El entorno actual está configurado en <strong>modo prueba</strong>, por lo que los cambios en el stock no serán sincronizados con Factusol.
                    </p>
                </div>
            </div>
        </div>
    @endenv

    <x-banner />
    <x-wireui:notifications />
    <x-wireui:dialog />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('navigation-menu')

            <!-- Page Heading -->
            @if(isset($header))
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

    @stack('modals')

    @livewireScripts
</body>

</html>
