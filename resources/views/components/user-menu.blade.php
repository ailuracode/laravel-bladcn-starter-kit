<x-ui.dropdown-menu>
    <x-ui.dropdown-menu.trigger as-child>
        <button
            type="button"
            class="flex w-full items-center gap-2 rounded-md p-2 text-left text-sm hover:bg-sidebar-accent hover:text-sidebar-accent-foreground"
            data-test="sidebar-menu-button"
        >
            <x-ui.avatar size="sm">
                <x-ui.avatar.fallback>{{ auth()->user()->initials() }}</x-ui.avatar.fallback>
            </x-ui.avatar>
            <span class="grid flex-1 text-start text-sm leading-tight group-data-[collapsible=icon]:hidden">
                <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                <span class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</span>
            </span>
            <x-ui.icon name="chevrons-up-down" class="size-4 text-muted-foreground group-data-[collapsible=icon]:hidden" />
        </button>
    </x-ui.dropdown-menu.trigger>
    <x-ui.dropdown-menu.content align="end" class="w-56">
        <div class="flex items-center gap-2 px-2 py-1.5">
            <x-ui.avatar size="sm">
                <x-ui.avatar.fallback>{{ auth()->user()->initials() }}</x-ui.avatar.fallback>
            </x-ui.avatar>
            <div class="grid flex-1 text-start text-sm leading-tight">
                <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                <span class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</span>
            </div>
        </div>
        <x-ui.dropdown-menu.separator />
        <x-ui.dropdown-menu.item>
            <a href="{{ route('profile.edit') }}" class="flex w-full items-center gap-2" wire:navigate>
                <x-ui.icon name="settings" class="size-4" />
                {{ __('Settings') }}
            </a>
        </x-ui.dropdown-menu.item>
        <x-ui.dropdown-menu.separator />
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <x-ui.dropdown-menu.item>
                <button type="submit" class="flex w-full cursor-pointer items-center gap-2" data-test="logout-button">
                    <x-ui.icon name="log-out" class="size-4" />
                    {{ __('Log out') }}
                </button>
            </x-ui.dropdown-menu.item>
        </form>
    </x-ui.dropdown-menu.content>
</x-ui.dropdown-menu>
