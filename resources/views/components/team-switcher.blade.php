@props([
    'teams' => [],
])

<div
        x-data="teamSwitcher(@js($teams))"
        x-on:team-selected="selectTeam($event.detail)"
    >
        <x-ui.sidebar.menu>
            <x-ui.sidebar.menu-item>
                <x-ui.dropdown-menu>
                    <x-ui.dropdown-menu.trigger as-child>
                        <button
                            type="button"
                            class="peer/menu-button flex h-12 w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-hidden ring-sidebar-ring transition-[width,height,padding] duration-200 ease-linear hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-0!"
                            data-slot="sidebar-menu-button"
                            data-sidebar="menu-button"
                            data-size="lg"
                        >
                            <span class="flex aspect-square size-8 shrink-0 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
                                @foreach ($teams as $team)
                                    <span x-show="activeTeam?.name === @js($team['name'])" x-cloak>
                                        <x-ui.icon :name="$team['logo']" class="size-4" />
                                    </span>
                                @endforeach
                            </span>
                            <div class="grid min-w-0 flex-1 truncate text-start text-sm leading-tight">
                                <span class="truncate font-medium" x-text="activeTeam.name"></span>
                                <span class="truncate text-xs text-muted-foreground" x-text="activeTeam.plan"></span>
                            </div>
                            <x-ui.icon name="chevrons-up-down" class="ms-auto size-4 shrink-0" />
                        </button>
                    </x-ui.dropdown-menu.trigger>
                <x-ui.dropdown-menu.content
                    align="start"
                    side="right"
                    :side-offset="4"
                    class="w-56 rounded-lg"
                >
                        <div class="px-2 py-1.5 text-xs text-muted-foreground">
                            {{ __('Teams') }}
                        </div>
                        @foreach ($teams as $index => $team)
                            <x-ui.dropdown-menu.item class="gap-2 p-2">
                                <button
                                    type="button"
                                    class="flex w-full cursor-default items-center gap-2 text-left"
                                    x-on:click="$dispatch('team-selected', {{ $index }})"
                                >
                                    <span class="flex size-6 items-center justify-center rounded-md border">
                                        <x-ui.icon :name="$team['logo']" class="size-3.5 shrink-0" />
                                    </span>
                                    <span class="flex-1">{{ $team['name'] }}</span>
                                    <x-ui.dropdown-menu.shortcut>⌘{{ $index + 1 }}</x-ui.dropdown-menu.shortcut>
                                </button>
                            </x-ui.dropdown-menu.item>
                        @endforeach
                        <x-ui.dropdown-menu.separator />
                        <x-ui.dropdown-menu.item class="gap-2 p-2">
                            <span class="flex size-6 items-center justify-center rounded-md border bg-transparent">
                                <x-ui.icon name="plus" class="size-4" />
                            </span>
                            <span class="font-medium text-muted-foreground">{{ __('Add team') }}</span>
                        </x-ui.dropdown-menu.item>
                    </x-ui.dropdown-menu.content>
                </x-ui.dropdown-menu>
            </x-ui.sidebar.menu-item>
        </x-ui.sidebar.menu>
    </div>

@pushOnce('bladcn-scripts')
    <script>
        bladcnOnAlpine((Alpine) => {
            Alpine.data('teamSwitcher', (teams) => ({
                activeTeam: teams[0] ?? null,
                    teams,

                    init() {
                        console.log('teamSwitcher init');
                    },

                    selectTeam(index) {
                        if (this.teams[index]) {
                            this.activeTeam = this.teams[index];
                        }
                    },
                }));
            });
        </script>
    @endPushOnce
