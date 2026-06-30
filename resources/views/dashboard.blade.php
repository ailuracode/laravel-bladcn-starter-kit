<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">{{ __('Dashboard') }}</h1>
            <p class="text-sm text-muted-foreground">
                {{ __('Component examples powered by @ailuracode/alpinejs-toolkit.') }}
            </p>
        </div>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Dialog') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Modal overlays with focus trap, scroll lock, and keyboard dismissal via the dialog store.') }}
                </x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content class="flex flex-wrap gap-3">
                {{-- Basic --}}
                <x-ui.dialog>
                    <x-ui.dialog.trigger>
                        <x-ui.button variant="outline">{{ __('Open dialog') }}</x-ui.button>
                    </x-ui.dialog.trigger>
                    <x-ui.dialog.content>
                        <x-ui.dialog.header>
                            <x-ui.dialog.title>{{ __('Edit profile') }}</x-ui.dialog.title>
                            <x-ui.dialog.description>
                                {{ __('Make changes to your profile here. Click save when you are done.') }}
                            </x-ui.dialog.description>
                        </x-ui.dialog.header>
                    </x-ui.dialog.content>
                </x-ui.dialog>

                {{-- With footer actions --}}
                <x-ui.dialog>
                    <x-ui.dialog.trigger>
                        <x-ui.button>{{ __('Share link') }}</x-ui.button>
                    </x-ui.dialog.trigger>
                    <x-ui.dialog.content>
                        <x-ui.dialog.header>
                            <x-ui.dialog.title>{{ __('Share this project') }}</x-ui.dialog.title>
                            <x-ui.dialog.description>
                                {{ __('Anyone with the link can view this project.') }}
                            </x-ui.dialog.description>
                        </x-ui.dialog.header>
                        <div class="flex items-center gap-2">
                            <x-ui.input
                                class="font-mono text-sm"
                                readonly
                                value="https://example.com/share/abc123" />
                            <x-ui.button size="sm" variant="secondary">{{ __('Copy') }}</x-ui.button>
                        </div>
                        <x-ui.dialog.footer>
                            <x-ui.dialog.close>
                                <x-ui.button variant="outline">{{ __('Close') }}</x-ui.button>
                            </x-ui.dialog.close>
                            <x-ui.button>{{ __('Share') }}</x-ui.button>
                        </x-ui.dialog.footer>
                    </x-ui.dialog.content>
                </x-ui.dialog>

                {{-- Explicit id + store API --}}
                <x-ui.dialog id="dashboard-settings-dialog">
                    <x-ui.dialog.trigger>
                        <x-ui.button variant="secondary">{{ __('Settings') }}</x-ui.button>
                    </x-ui.dialog.trigger>
                    <x-ui.dialog.content :show-close-button="false">
                        <x-ui.dialog.header>
                            <x-ui.dialog.title>{{ __('Settings') }}</x-ui.dialog.title>
                            <x-ui.dialog.description>
                                {{ __('Opened with a stable id. Toggle programmatically from Alpine.') }}
                            </x-ui.dialog.description>
                        </x-ui.dialog.header>
                        <x-ui.dialog.footer :show-close-button="true" />
                    </x-ui.dialog.content>
                </x-ui.dialog>

                <x-ui.button
                    type="button"
                    variant="ghost"
                    x-data
                    x-on:click="$store.dialog.toggle('dashboard-settings-dialog')">
                    {{ __('Toggle settings (store)') }}
                </x-ui.button>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Dropdown menu') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Exclusive mode. ↑↓ navigate items, Enter selects, Escape closes. Submenus open with →. Content is teleported to body with fixed anchor positioning.') }}
                </x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content class="flex flex-col gap-8">
                <div class="flex flex-wrap items-center gap-3">
                {{-- Basic --}}
                <x-ui.dropdown-menu id="dashboard-open-menu">
                    <x-ui.dropdown-menu.trigger>
                        <x-ui.button variant="outline">{{ __('Open menu') }}</x-ui.button>
                    </x-ui.dropdown-menu.trigger>
                    <x-ui.dropdown-menu.content class="w-48">
                        <x-ui.dropdown-menu.label>{{ __('My account') }}</x-ui.dropdown-menu.label>
                        <x-ui.dropdown-menu.separator />
                        <x-ui.dropdown-menu.item>{{ __('Profile') }}</x-ui.dropdown-menu.item>
                        <x-ui.dropdown-menu.item>{{ __('Billing') }}</x-ui.dropdown-menu.item>
                        <x-ui.dropdown-menu.separator />
                        <x-ui.dropdown-menu.item variant="destructive">{{ __('Delete account') }}</x-ui.dropdown-menu.item>
                    </x-ui.dropdown-menu.content>
                </x-ui.dropdown-menu>

                {{-- With submenu --}}
                <x-ui.dropdown-menu id="dashboard-submenu-menu">
                    <x-ui.dropdown-menu.trigger>
                        <x-ui.button variant="secondary">{{ __('With submenu') }}</x-ui.button>
                    </x-ui.dropdown-menu.trigger>
                    <x-ui.dropdown-menu.content class="w-48">
                        <x-ui.dropdown-menu.item>{{ __('New tab') }}</x-ui.dropdown-menu.item>
                        <x-ui.dropdown-menu.item>{{ __('New window') }}</x-ui.dropdown-menu.item>
                        <x-ui.dropdown-menu.separator />
                        <x-ui.dropdown-menu.sub>
                            <x-ui.dropdown-menu.sub-trigger>{{ __('More tools') }}</x-ui.dropdown-menu.sub-trigger>
                            <x-ui.dropdown-menu.sub-content>
                                <x-ui.dropdown-menu.item>{{ __('Save page as…') }}</x-ui.dropdown-menu.item>
                                <x-ui.dropdown-menu.item>{{ __('Create shortcut') }}</x-ui.dropdown-menu.item>
                            </x-ui.dropdown-menu.sub-content>
                        </x-ui.dropdown-menu.sub>
                    </x-ui.dropdown-menu.content>
                </x-ui.dropdown-menu>

                {{-- Explicit id + store API --}}
                <x-ui.dropdown-menu id="dashboard-actions-menu">
                    <x-ui.dropdown-menu.trigger>
                        <x-ui.button>{{ __('Actions') }}</x-ui.button>
                    </x-ui.dropdown-menu.trigger>
                    <x-ui.dropdown-menu.content align="end" class="w-44">
                        <x-ui.dropdown-menu.item>{{ __('Duplicate') }}</x-ui.dropdown-menu.item>
                        <x-ui.dropdown-menu.item>{{ __('Archive') }}</x-ui.dropdown-menu.item>
                    </x-ui.dropdown-menu.content>
                </x-ui.dropdown-menu>

                <x-ui.button
                    type="button"
                    variant="ghost"
                    x-data
                    x-on:click="$store.menu.toggle('dashboard-actions-menu')">
                    {{ __('Toggle actions (store)') }}
                </x-ui.button>
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-medium">{{ __('Anchor placement') }}</p>
                    <p class="text-sm text-muted-foreground">
                        {{ __('Each trigger uses side + align on dropdown-menu.content. Menus are portaled to body so they are not clipped by overflow containers.') }}
                    </p>
                    <div class="grid min-h-64 grid-cols-3 grid-rows-3 place-items-center gap-2 rounded-lg border border-dashed p-6">
                        @php
                            $anchorVariants = [
                                ['id' => 'dashboard-anchor-top-start', 'side' => 'top', 'align' => 'start', 'label' => 'top · start', 'class' => 'col-start-1 row-start-1'],
                                ['id' => 'dashboard-anchor-top', 'side' => 'top', 'align' => 'center', 'label' => 'top · center', 'class' => 'col-start-2 row-start-1'],
                                ['id' => 'dashboard-anchor-top-end', 'side' => 'top', 'align' => 'end', 'label' => 'top · end', 'class' => 'col-start-3 row-start-1'],
                                ['id' => 'dashboard-anchor-left', 'side' => 'left', 'align' => 'center', 'label' => 'left · center', 'class' => 'col-start-1 row-start-2'],
                                ['id' => 'dashboard-anchor-right', 'side' => 'right', 'align' => 'center', 'label' => 'right · center', 'class' => 'col-start-3 row-start-2'],
                                ['id' => 'dashboard-anchor-bottom-start', 'side' => 'bottom', 'align' => 'start', 'label' => 'bottom · start', 'class' => 'col-start-1 row-start-3'],
                                ['id' => 'dashboard-anchor-bottom', 'side' => 'bottom', 'align' => 'center', 'label' => 'bottom · center', 'class' => 'col-start-2 row-start-3'],
                                ['id' => 'dashboard-anchor-bottom-end', 'side' => 'bottom', 'align' => 'end', 'label' => 'bottom · end', 'class' => 'col-start-3 row-start-3'],
                            ];
                        @endphp

                        @foreach ($anchorVariants as $variant)
                            <x-ui.dropdown-menu
                                id="{{ $variant['id'] }}"
                                class="{{ $variant['class'] }}"
                            >
                                <x-ui.dropdown-menu.trigger>
                                    <x-ui.button size="sm" variant="outline">{{ $variant['label'] }}</x-ui.button>
                                </x-ui.dropdown-menu.trigger>
                                <x-ui.dropdown-menu.content
                                    :side="$variant['side']"
                                    :align="$variant['align']"
                                    class="w-44"
                                >
                                    <x-ui.dropdown-menu.label>{{ $variant['label'] }}</x-ui.dropdown-menu.label>
                                    <x-ui.dropdown-menu.separator />
                                    <x-ui.dropdown-menu.item>{{ __('Action one') }}</x-ui.dropdown-menu.item>
                                    <x-ui.dropdown-menu.item>{{ __('Action two') }}</x-ui.dropdown-menu.item>
                                    <x-ui.dropdown-menu.separator />
                                    <x-ui.dropdown-menu.item variant="destructive">{{ __('Remove') }}</x-ui.dropdown-menu.item>
                                </x-ui.dropdown-menu.content>
                            </x-ui.dropdown-menu>
                        @endforeach

                        <span class="col-start-2 row-start-2 text-xs text-muted-foreground">{{ __('trigger grid') }}</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-sm font-medium">{{ __('Side offset') }}</p>
                    <div class="flex flex-wrap items-center gap-3">
                        @foreach ([0, 4, 12, 24] as $offset)
                            <x-ui.dropdown-menu id="dashboard-anchor-offset-{{ $offset }}">
                                <x-ui.dropdown-menu.trigger>
                                    <x-ui.button size="sm" variant="secondary">{{ __('offset :px', ['px' => $offset]) }}</x-ui.button>
                                </x-ui.dropdown-menu.trigger>
                                <x-ui.dropdown-menu.content
                                    side="bottom"
                                    align="start"
                                    :side-offset="$offset"
                                    class="w-40"
                                >
                                    <x-ui.dropdown-menu.label>{{ __('sideOffset = :px', ['px' => $offset]) }}</x-ui.dropdown-menu.label>
                                    <x-ui.dropdown-menu.separator />
                                    <x-ui.dropdown-menu.item>{{ __('Option A') }}</x-ui.dropdown-menu.item>
                                    <x-ui.dropdown-menu.item>{{ __('Option B') }}</x-ui.dropdown-menu.item>
                                </x-ui.dropdown-menu.content>
                            </x-ui.dropdown-menu>
                        @endforeach
                    </div>
                </div>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Context menu') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Right-click to open. Uses the same menu store with cursor anchoring.') }}
                </x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <x-ui.context-menu>
                    <x-ui.context-menu.trigger>
                        <div
                            class="flex h-32 w-full items-center justify-center rounded-lg border border-dashed text-sm text-muted-foreground">
                            {{ __('Right click here') }}
                        </div>
                    </x-ui.context-menu.trigger>
                    <x-ui.context-menu.content class="w-48">
                        <x-ui.context-menu.item>{{ __('Back') }}</x-ui.context-menu.item>
                        <x-ui.context-menu.item disabled>{{ __('Forward') }}</x-ui.context-menu.item>
                        <x-ui.context-menu.item>{{ __('Reload') }}</x-ui.context-menu.item>
                        <x-ui.context-menu.separator />
                        <x-ui.context-menu.item>{{ __('Inspect') }}</x-ui.context-menu.item>
                    </x-ui.context-menu.content>
                </x-ui.context-menu>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Menubar') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Horizontal menu bar. Each top-level item registers a separate menu instance in the store.') }}
                </x-ui.card.description>
            </x-ui.card.header>
            <x-ui.card.content>
                <x-ui.menubar id="dashboard-menubar">
                    <x-ui.menubar.menu value="file">
                        <x-ui.menubar.trigger>{{ __('File') }}</x-ui.menubar.trigger>
                        <x-ui.menubar.content>
                            <x-ui.menubar.item>{{ __('New tab') }}</x-ui.menubar.item>
                            <x-ui.menubar.item>{{ __('New window') }}</x-ui.menubar.item>
                            <x-ui.menubar.separator />
                            <x-ui.menubar.item>{{ __('Print') }}</x-ui.menubar.item>
                        </x-ui.menubar.content>
                    </x-ui.menubar.menu>
                    <x-ui.menubar.menu value="edit">
                        <x-ui.menubar.trigger>{{ __('Edit') }}</x-ui.menubar.trigger>
                        <x-ui.menubar.content>
                            <x-ui.menubar.item>{{ __('Undo') }}</x-ui.menubar.item>
                            <x-ui.menubar.item>{{ __('Redo') }}</x-ui.menubar.item>
                            <x-ui.menubar.separator />
                            <x-ui.menubar.item>{{ __('Cut') }}</x-ui.menubar.item>
                            <x-ui.menubar.item>{{ __('Copy') }}</x-ui.menubar.item>
                            <x-ui.menubar.item>{{ __('Paste') }}</x-ui.menubar.item>
                        </x-ui.menubar.content>
                    </x-ui.menubar.menu>
                    <x-ui.menubar.menu value="view">
                        <x-ui.menubar.trigger>{{ __('View') }}</x-ui.menubar.trigger>
                        <x-ui.menubar.content>
                            <x-ui.menubar.item>{{ __('Zoom in') }}</x-ui.menubar.item>
                            <x-ui.menubar.item>{{ __('Zoom out') }}</x-ui.menubar.item>
                            <x-ui.menubar.separator />
                            <x-ui.menubar.item>{{ __('Full screen') }}</x-ui.menubar.item>
                        </x-ui.menubar.content>
                    </x-ui.menubar.menu>
                </x-ui.menubar>
            </x-ui.card.content>
        </x-ui.card>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @foreach (range(1, 3) as $index)
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <x-placeholder-pattern class="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
                </div>
            @endforeach
        </div>
        <div class="relative min-h-[40vh] flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-neutral-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts::app>
