<table class="min-w-full divide-y divide-gray-300 w-full rounded my-5">
    @foreach ($warning as $key => $item)
        <tr class="divide-x divide-gray-200 | text-base text-left border-t border-2">
            {{--
            <td class="w-0 px-1">
                {{  $key + 1 }}
            </td>
            --}}
            <td class="py-1 px-1">{!!  $item !!}</td>
        </tr>
    @endforeach
</table>