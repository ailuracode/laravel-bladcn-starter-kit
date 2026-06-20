@php
    $navMain = [
        [
            'title' => __('Dashboard'),
            'url' => route('dashboard'),
            'icon' => 'layout-grid',
            'isActive' => request()->routeIs('dashboard'),
        ],
    ];

    $footerNavItems = [
        [
            'title' => __('Repository'),
            'url' => 'https://github.com/SiddharthaGF/laravel-bladcn-starter-kit',
            'icon' => 'folder-git-2',
        ],
        [
            'title' => __('Documentation'),
            'url' => route('docs.index'),
            'icon' => 'book-open-text',
        ],
    ];
@endphp

<x-ui.sidebar collapsible="icon" variant="inset">
    <x-ui.sidebar.header>
        <x-ui.sidebar.menu>
            <x-ui.sidebar.menu-item>
                <x-ui.sidebar.menu-button
                    :href="route('dashboard')"
                    size="lg"
                    wire:navigate
                >
                    <x-app-logo sidebar />
                </x-ui.sidebar.menu-button>
            </x-ui.sidebar.menu-item>
        </x-ui.sidebar.menu>
    </x-ui.sidebar.header>

    <x-ui.sidebar.content>
        <x-nav-main :items="$navMain" />
    </x-ui.sidebar.content>

    <x-ui.sidebar.footer>
        <x-nav-footer :items="$footerNavItems" class="mt-auto" />
        <x-nav-user />
    </x-ui.sidebar.footer>
</x-ui.sidebar>
