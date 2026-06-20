@props([
    'items' => [],
])

<x-ui.sidebar.group>
    <x-ui.sidebar.group-label>{{ __('Platform') }}</x-ui.sidebar.group-label>
    <x-ui.sidebar.menu>
        @foreach ($items as $item)
            <x-ui.sidebar.menu-item>
                <x-ui.sidebar.menu-button
                    :href="$item['url']"
                    :is-active="$item['isActive'] ?? false"
                    wire:navigate
                >
                    @if (! empty($item['icon']))
                        <x-ui.icon :name="$item['icon']" />
                    @endif
                    <span>{{ $item['title'] }}</span>
                </x-ui.sidebar.menu-button>
            </x-ui.sidebar.menu-item>
        @endforeach
    </x-ui.sidebar.menu>
</x-ui.sidebar.group>
