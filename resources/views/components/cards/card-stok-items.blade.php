<ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 rounded">
  @foreach ($collection as $item)
    @php
      // $route = str_replace('XXXX', $item->id, $item->route);
      $color = color_stock($item->stock);
      $route = '';
    @endphp
    <li>
      <a href="{{ $route }}" class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6" wire:navigate>
        <div class="flex min-w-0 gap-x-4">
          <div class="p-1 rounded-full w-10 h-10 bg-{{ $color }}-500 flex items-center justify-center text-white">
            @switch($item->type)
                @case('top')
                    <x-icons.top class="h-5"/>
                    @break
                @case('combination')
                    <x-icons.mattresss class="h-5"/>
                    @break
                  @case('cover')
                    <x-icons.cover class="h-5"/>
                    @break
                  @case('base')
                    <x-icons.base class="h-5"/>
                    @break
                @default
            @endswitch
          </div>
          <div class="min-w-0 flex-auto">
            <p class="text-sm font-semibold leading-6 text-gray-900">
              <span href="{{ $route }}">
                {{ $item->code->value }}
              </span>
            </p>
            <p class="flex text-xs leading-5 text-gray-500">
              <span class="uppercase">
                {{ __($item->type) }}
              </span>
            </p>
          </div>
        </div>
        <div class="flex shrink-0 items-center gap-x-4">
          <div class="hidden sm:flex sm:flex-col sm:items-end">
            <p class="text-sm leading-6 text-gray-900">
              {{ __('Stock') }}
            </p>
            <div class="flex items-center gap-x-1.5">
              <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-{{ $color }}-600 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-{{ $color }}-600"></span>
              </span>
              <p class="text-xs leading-5 text-gray-500">
                {{ $item->stock }}
              </p>
            </div>
          </div>
          <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
          </svg>
        </div>
      </a>
    </li>
  @endforeach
</ul>
