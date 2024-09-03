<p>Buenas,</p>

<p>Los siguientes productos se requieren:</p>
<table>
    <tr>
        <th>
            {{ __('Code') }}
        </th>
        <th>
            {{ __('Name') }}
        </th>
        <th>
            {{ __('Quantity') }}
        </th>
    </tr>
    @foreach ($products as $product)
        <tr>
            <td>
                {{ $product->code }}
            </td>
            <td>
                {{ $product->name }}
            </td>
            <td>
                {{ $product->quantity }}
            </td>
        </tr>
    @endforeach
</table>

<p>Saludos</p>