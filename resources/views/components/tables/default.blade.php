<table {{
        $attributes->merge([
            "class" => "min-w-full divide-y divide-gray-300 w-full rounded"
        ])
    }}>
    @isset($thead)
        <thead>
            {{ $thead }}
        </thead>
    @endisset

    @isset($tbody)
        <tbody>
            {{ $tbody }}
        </tbody>
    @endisset
</table>
