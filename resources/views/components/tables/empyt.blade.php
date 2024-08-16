@props([
'title' => "No se encontraron registros en la base de datos.",
'description' => 'Actualmente, no hay resultados disponibles para mostrar. Por favor, compruebe si hay datos en la base de datos.'
])

<div class="bg-white shadow sm:rounded-lg rounded">
    <div class="px-4 py-5 sm:p-6 flex gap-1">
        <x-icon name="exclamation-circle" class="min-w-10 w-10 h-10 min-h-10 text-red-600"></x-icon>
        <div class="flex flex-col">
            <h3 class="text-lg font-semibold leading-6 text-gray-900">
                {{ $title }}
            </h3>
            <div class="max-w-xl text-base text-gray-500">
                <p>
                    {!! $description !!}
                </p>
            </div>
        </div>
        {{-- <div class="mt-3 text-sm leading-6">
            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">
                Learn more about our CI features
                <span aria-hidden="true"> &rarr;</span>
            </a>
        </div> --}}
    </div>
</div>
