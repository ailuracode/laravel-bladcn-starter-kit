@props([
    'items' => [],
])

<x-ui.sidebar.group {{ $attributes->class(['group-data-[collapsible=icon]/sidebar-wrapper:p-0']) }}>
    <div class="w-full text-sm" data-sidebar="group-content">
        <x-ui.sidebar.menu>
            @foreach ($items as $item)
                <x-ui.sidebar.menu-item>
                    <x-ui.sidebar.menu-button
                        :href="$item['url']"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
                    >
                        @if (! empty($item['icon']))
                            <x-ui.icon :name="$item['icon']" class="size-5" />
                        @endif
                        <span>{{ $item['title'] }}</span>
                    </x-ui.sidebar.menu-button>
                </x-ui.sidebar.menu-item>
            @endforeach
        </x-ui.sidebar.menu>
    </div>
</x-ui.sidebar.group>
