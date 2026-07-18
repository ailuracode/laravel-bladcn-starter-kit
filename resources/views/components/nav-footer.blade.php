@props([
    'items' => [],
])

<x-ui.sidebar.group {{ $attributes }}>
    <x-ui.sidebar.group-content>
        <x-ui.sidebar.menu>
            @foreach ($items as $item)
                <x-ui.sidebar.menu-item>
                    <x-ui.sidebar.menu-button
                        :href="$item['url']"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        @if (! empty($item['icon']))
                            <x-ui.icon :name="$item['icon']" />
                        @endif
                        <span data-sidebar-nav-label>{{ $item['title'] }}</span>
                    </x-ui.sidebar.menu-button>
                </x-ui.sidebar.menu-item>
            @endforeach
        </x-ui.sidebar.menu>
    </x-ui.sidebar.group-content>
</x-ui.sidebar.group>
