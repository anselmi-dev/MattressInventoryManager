<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    @env('local', 'staging', 'develop')
        <div class=" bg-yellow-50 px-4 p-2">
            <div class="flex justify-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-center text-sm text-yellow-700">
                        El entorno actual está configurado en <strong>modo prueba</strong>, por lo que los cambios en el
                        stock no serán sincronizados con Factusol.
                    </p>
                </div>
            </div>
        </div>
    @endenv
    
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-mark class="block h-9 w-auto text-app-primary" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 lg:-my-px lg:ms-10 lg:flex">
                    <x-nav-link href="{{ route('dimensions.index') }}" :active="request()->routeIs('dimensions.*')" wire:navigate>
                        <span class="relative">
                            <x-icons.dimension class="h-4 mr-1"/>
                            <span class="cout-nav-item">{{ count_dimensions() }}</span>
                        </span>
                        {{ __('Dimensions') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')" wire:navigate>
                        <span class="relative">
                            <x-icons.cover class="h-4 mr-1"/>
                            <span class="cout-nav-item">{{ count_products() }}</span>
                        </span>
                        {{ __('Parts') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('combinations.index') }}" :active="request()->routeIs('combinations.*')" wire:navigate>
                        <span class="relative">
                            <x-icons.combinations class="h-4 mr-1"/>
                            <span class="cout-nav-item">{{ count_combinations() }}</span>
                        </span>
                        {{ __('Combinations') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('sales.index') }}" :active="request()->routeIs('sales.*')" wire:navigate>
                        <span class="relative inline-block">
                            <x-icons.sale class="h-4 mr-1"/>
                        </span>
                        {{ __('Sales') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('orders.index') }}" :active="request()->routeIs('orders.*')" wire:navigate>
                        <span class="relative inline-block">
                            <x-icons.orders class="h-4 mr-1"/>
                        </span>
                        {{ __('Orders') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('manufacture-special-measures.index') }}" :active="request()->routeIs('manufacture-special-measures.*')" wire:navigate>
                        <span class="relative inline-block">
                            <x-icons.special-measures class="h-4 mr-1"/>
                        </span>
                        {{ __('Special Measures') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden lg:flex lg:items-center lg:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" wire:navigate>
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}" wire:navigate>
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}" wire:navigate title="{{ __('Profile') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (!auth()->user()->hasRole('operator'))
                                <x-dropdown-link href="{{ route('settings.index') }}" wire:navigate title="{{ __('Settings') }}">
                                    {{ __('Settings') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('products.export') }}" title="{{ __('Exportar') }}">
                                    {{ __('Exportar productos') }}
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('users.index') }}" wire:navigate title="{{ __('Users') }}">
                                    {{ __('Users') }}
                                </x-dropdown-link>
                            @endif

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}" wire:navigate>
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="lg:hidden hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (!auth()->user()->hasRole('operator'))
                <x-responsive-nav-link href="{{ route('settings.index') }}" wire:navigate title="{{ __('Settings') }}">
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link href="{{ route('users.index') }}" wire:navigate title="{{ __('Users') }}">
                    {{ __('Users') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link href="{{ route('dimensions.index') }}" :active="request()->routeIs('dimensions.*')" wire:navigate>
                <span class="relative inline-block">
                    <x-icons.dimension class="h-4 mr-1"/>
                </span>
                {{ __('Dimensions') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.*')" wire:navigate>
                <span class="relative inline-block">
                    <x-icons.cover class="h-4 mr-1"/>
                </span>
                {{ __('Parts') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link href="{{ route('combinations.index') }}" :active="request()->routeIs('combinations.*')" wire:navigate>
                <span class="relative inline-block">
                    <x-icons.combinations class="h-4 mr-1"/>
                </span>
                {{ __('Combinations') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('sales.index') }}" :active="request()->routeIs('sales.*')" wire:navigate>
                <span class="relative inline-block">
                    <x-icons.sale class="h-4 mr-1"/>
                </span>
                {{ __('Sales') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('manufacture-special-measures.index') }}" :active="request()->routeIs('manufacture-special-measures.*')" wire:navigate>
                <span class="relative inline-block">
                    <x-icons.special-measures class="h-4 mr-1"/>
                </span>
                {{ __('Special Measures') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200 dark:border-gray-600"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
