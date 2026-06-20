@props([
    'items' => [],
])

<x-ui.sidebar.group {{ $attributes }}>
    <div class="w-full text-sm" data-sidebar="group-content">
        <x-ui.sidebar.menu>
            @foreach ($items as $item)
                <x-ui.sidebar.menu-item>
                    <x-ui.sidebar.menu-button :href="$item['url']" class="h-7 text-xs">
                        <x-ui.icon :name="$item['icon']" />
                        <span>{{ $item['title'] }}</span>
                    </x-ui.sidebar.menu-button>
                </x-ui.sidebar.menu-item>
            @endforeach
        </x-ui.sidebar.menu>
    </div>
</x-ui.sidebar.group>
