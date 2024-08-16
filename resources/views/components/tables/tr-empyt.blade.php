@props([
    'title' => "Lo siento, no se encontraron registros en la base de datos.",
    'description' => 'Actualmente, no hay resultados disponibles para mostrar. Por favor, compruebe si hay datos en la base de datos.'
])

<tr>
    <td>
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6 flex gap-1">
                <div class="flex flex-col">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900 flex gap-1">
                        <x-icon name="x" class="w-10 min-w-10 md:w-6 md:min-w-6 text-red-600"/>
                        {{ $title }}
                    </h3>
                    <div class="max-w-xl text-base text-gray-500">
                        <p>
                            {!! $description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
