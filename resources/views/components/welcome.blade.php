<div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        Welcome to your Jetstream application!
    </h1>

    <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
        Laravel Jetstream provides a beautiful, robust starting point for your next Laravel application. Laravel is designed
        to help you build your application using a development environment that is simple, powerful, and enjoyable. We believe
        you should love expressing your creativity through programming, so we have spent time carefully crafting the Laravel
        ecosystem to be a breath of fresh air. We hope you love it.
    </p>
</div>

<div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    <div>
        <div class="flex items-center">
            <x-icons.mattresss class="w-6 h-6 stroke-gray-400"/>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('mattresses.index') }}">{{ __('Mattresses') }}</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Las "Combinaciones" representan la unión de todos los elementos anteriores (Tapas, Fundas, Bases y Medidas) para formar un producto completo y personalizado. Estas combinaciones permiten a los clientes seleccionar configuraciones específicas que mejor se adapten a sus necesidades y preferencias.
        </p>

        <p class="mt-4 text-sm">
            <a href="{{ route('mattresses.index') }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{ __('Ver inventario') }}

                <x-icons.solar-round-arrow-right-line-duotone class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200"/>
            </a>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <x-icons.dimension class="w-6 h-6 stroke-gray-400"/>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('dimensions.index') }}">{{ __('Dimensions') }}</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Las "Medidas" especifican las dimensiones del colchón y son esenciales para asegurar que los colchones se ajusten adecuadamente a los marcos de cama y a las preferencias del usuario.
        </p>

        <p class="mt-4 text-sm">
            <a href="{{ route('dimensions.index') }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{ __('Ver inventario') }}

                <x-icons.solar-round-arrow-right-line-duotone class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200"/>
            </a>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <x-icons.cover class="w-6 h-6 stroke-gray-400"/>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('covers.index') }}">{{ __('Cover') }}</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Las "Fundas" son coberturas que protegen el colchón y sus componentes internos. Estas fundas pueden ser removibles o fijas y están diseñadas para aumentar la durabilidad del colchón, facilitar su limpieza, y en algunos casos, mejorar su apariencia estética.
        </p>

        <p class="mt-4 text-sm">
            <a href="{{ route('covers.index') }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{ __('Ver inventario') }}

                <x-icons.solar-round-arrow-right-line-duotone class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200"/>
            </a>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <x-icons.top class="w-6 h-6 stroke-gray-400"/>
            <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                <a href="{{ route('tops.index') }}">{{ __('Tops') }}</a>
            </h2>
        </div>

        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            Las "Tapas" son los componentes superiores de un colchón que proporcionan una superficie cómoda para dormir. Estas pueden estar hechas de diversos materiales como espuma de memoria, látex, algodón o una mezcla de textiles, y pueden incluir características adicionales como acolchado extra o tecnología de enfriamiento para mejorar la comodidad del usuario.
        </p>

        <p class="mt-4 text-sm">
            <a href="{{ route('tops.index') }}" class="inline-flex items-center font-semibold text-indigo-700 dark:text-indigo-300">
                {{ __('Ver inventario') }}

                <x-icons.solar-round-arrow-right-line-duotone class="ms-1 w-5 h-5 fill-indigo-500 dark:fill-indigo-200"/>
            </a>
        </p>
    </div>
</div>
