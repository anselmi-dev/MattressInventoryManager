<div {{ $attributes->merge(['class' => "relative"]) }}>
    <div class="sm:hidden">
        <select class="block w-full rounded-md border-gray-300 focus:border-main-500 focus:ring-main-500">
            <template x-for="xtab in {{ $xTabs }}.options" :key="xtab.key"
                x-model="{{ $xTabs }}.current">
                <option :value="xtab.key" x-text="xtab.label"></option>
            </template>
        </select>
    </div>
    <div class="hidden sm:block">
        <div class="border-b-2 border-gray-200">
            <nav class="-mb-px flex space-x-1" aria-label="Tabs">
                <template x-for="xtab in {{ $xTabs }}.options" :key="xtab.key">
                    <a href="#" @click="{{ $xTabs }}.current = xtab.key"
                        :class="{
                            'border-main-500 text-main-600': {{ $xTabs }}.current == xtab.key,
                            'border-transparent': {{ $xTabs }}.current != xtab.key
                        }"
                        class=" text-gray-500 hover:border-gray-200 hover:text-gray-700 flex whitespace-nowrap border-b-2 py-2 px-2 text-sm font-medium">
                        <span x-text="xtab.label"></span>
                        <span x-show="xtab.total" x-text="xtab.total"
                            class="bg-indigo-100 text-main-600 ml-3 hidden rounded-full py-0.5 px-2.5 text-xs font-medium md:inline-block"></span>
                    </a>
                </template>
            </nav>
        </div>
    </div>
</div>
