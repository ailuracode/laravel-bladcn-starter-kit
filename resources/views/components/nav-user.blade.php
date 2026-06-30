<x-ui.sidebar.menu>
    <x-ui.sidebar.menu-item>
        <x-ui.dropdown-menu class="w-full">
            <x-ui.dropdown-menu.trigger as-child>
                <button
                    type="button"
                    class="peer/menu-button flex h-12 w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm text-sidebar-accent-foreground outline-hidden ring-sidebar-ring transition-[width,height,padding,gap] duration-200 ease-linear hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground data-[state=open]:bg-sidebar-accent group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:gap-0 group-data-[collapsible=icon]:p-0! group-data-[collapsible=icon]:[&>*:not(:first-child)]:flex-[0_0_0] group-data-[collapsible=icon]:[&>*:not(:first-child)]:max-w-0 group-data-[collapsible=icon]:[&>*:not(:first-child)]:overflow-hidden group-data-[collapsible=icon]:[&>*:not(:first-child)]:ms-0 group-data-[collapsible=icon]:[&>*:not(:first-child)]:transition-[max-width,margin] [&>*:not(:first-child)]:min-w-0"
                    data-slot="sidebar-menu-button"
                    data-sidebar="menu-button"
                    data-size="lg"
                    data-test="sidebar-menu-button"
                >
                    <x-ui.avatar class="size-8 shrink-0 overflow-hidden rounded-full">
                        <x-ui.avatar.fallback class="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                            {{ auth()->user()->initials() }}
                        </x-ui.avatar.fallback>
                    </x-ui.avatar>
                    <div class="grid min-w-0 flex-1 truncate text-start text-sm leading-tight">
                        <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                    </div>
                    <x-ui.icon name="chevrons-up-down" class="ms-auto size-4 shrink-0" />
                </button>
            </x-ui.dropdown-menu.trigger>
            <x-ui.dropdown-menu.content
                align="end"
                side="right"
                :side-offset="4"
                data-sidebar-menu="nav-user"
                class="w-56 rounded-lg data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:slide-out-to-right-2 data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:slide-in-from-left-2 duration-200"
            >
                <div class="flex items-center gap-2 px-2 py-1.5 text-start text-sm">
                    <x-ui.avatar class="size-8 overflow-hidden rounded-full">
                        <x-ui.avatar.fallback class="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                            {{ auth()->user()->initials() }}
                        </x-ui.avatar.fallback>
                    </x-ui.avatar>
                    <div class="grid min-w-0 flex-1 text-start text-sm leading-tight">
                        <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                        <span class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</span>
                    </div>
                </div>
                <x-ui.dropdown-menu.separator />
                <x-ui.dropdown-menu.item>
                    <a href="{{ route('profile.edit') }}" class="flex w-full cursor-pointer items-center gap-2" wire:navigate>
                        <x-ui.icon name="settings" class="size-4 shrink-0" />
                        {{ __('Settings') }}
                    </a>
                </x-ui.dropdown-menu.item>
                <x-ui.dropdown-menu.separator />
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <x-ui.dropdown-menu.item>
                        <button type="submit" class="flex w-full cursor-pointer items-center gap-2" data-test="logout-button">
                            <x-ui.icon name="log-out" class="size-4 shrink-0" />
                            {{ __('Log out') }}
                        </button>
                    </x-ui.dropdown-menu.item>
                </form>
            </x-ui.dropdown-menu.content>
        </x-ui.dropdown-menu>
    </x-ui.sidebar.menu-item>
</x-ui.sidebar.menu>
