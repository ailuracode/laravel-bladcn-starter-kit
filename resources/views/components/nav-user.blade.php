<x-ui.sidebar.menu>
    <x-ui.sidebar.menu-item>
        <x-ui.sidebar.menu-button
            :href="route('profile.edit')"
            :tooltip="false"
            class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
            size="lg"
            wire:navigate
        >
            <x-user-info />
        </x-ui.sidebar.menu-button>
    </x-ui.sidebar.menu-item>
</x-ui.sidebar.menu>
