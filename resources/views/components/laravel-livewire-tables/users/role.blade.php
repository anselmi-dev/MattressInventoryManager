@props(['row'])

<span class="uppercase">
    {{ __(optional($row->role)->name) }}
</span>