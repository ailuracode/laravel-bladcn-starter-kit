@props([
    'projects' => [],
])

<x-ui.sidebar.group class="group-data-[collapsible=icon]:hidden">
    <x-ui.sidebar.group-label>{{ __('Projects') }}</x-ui.sidebar.group-label>
    <x-ui.sidebar.menu>
        @foreach ($projects as $project)
            <x-ui.sidebar.menu-item>
                <x-ui.sidebar.menu-button :href="$project['url']">
                    <x-ui.icon :name="$project['icon']" />
                    <span>{{ $project['name'] }}</span>
                </x-ui.sidebar.menu-button>

                <x-ui.dropdown-menu>
                    <x-ui.dropdown-menu.trigger as-child>
                        <button
                            type="button"
                            class="absolute top-1.5 right-1 flex aspect-square w-5 items-center justify-center rounded-md p-0 text-sidebar-foreground outline-hidden ring-sidebar-ring transition-transform hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 peer-hover/menu-button:text-sidebar-accent-foreground data-[state=open]:opacity-100 group-focus-within/menu-item:opacity-100 group-hover/menu-item:opacity-100 md:opacity-0 [&>svg]:size-4 [&>svg]:shrink-0"
                            data-sidebar="menu-action"
                        >
                            <x-ui.icon name="ellipsis" />
                            <span class="sr-only">{{ __('More') }}</span>
                        </button>
                    </x-ui.dropdown-menu.trigger>
                    <x-ui.dropdown-menu.content align="start" side="right" class="w-48 rounded-lg">
                        <x-ui.dropdown-menu.item>
                            <x-ui.icon name="folder" class="text-muted-foreground" />
                            <span>{{ __('View Project') }}</span>
                        </x-ui.dropdown-menu.item>
                        <x-ui.dropdown-menu.item>
                            <x-ui.icon name="forward" class="text-muted-foreground" />
                            <span>{{ __('Share Project') }}</span>
                        </x-ui.dropdown-menu.item>
                        <x-ui.dropdown-menu.separator />
                        <x-ui.dropdown-menu.item>
                            <x-ui.icon name="trash-2" class="text-muted-foreground" />
                            <span>{{ __('Delete Project') }}</span>
                        </x-ui.dropdown-menu.item>
                    </x-ui.dropdown-menu.content>
                </x-ui.dropdown-menu>
            </x-ui.sidebar.menu-item>
        @endforeach

        <x-ui.sidebar.menu-item>
            <x-ui.sidebar.menu-button href="#" class="text-sidebar-foreground/70">
                <x-ui.icon name="ellipsis" class="text-sidebar-foreground/70" />
                <span>{{ __('More') }}</span>
            </x-ui.sidebar.menu-button>
        </x-ui.sidebar.menu-item>
    </x-ui.sidebar.menu>
</x-ui.sidebar.group>
