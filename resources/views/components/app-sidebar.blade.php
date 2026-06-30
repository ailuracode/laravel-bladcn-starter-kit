@php
    $navMain = [
        [
            'title' => __('Dashboard'),
            'url' => route('dashboard'),
            'icon' => 'layout-grid',
            'isActive' => request()->routeIs('dashboard'),
        ],
        [
            'title' => __('Analytics'),
            'url' => route('dashboard'),
            'icon' => 'chart-line',
        ],
        [
            'title' => __('Users'),
            'url' => route('dashboard'),
            'icon' => 'users',
        ],
        [
            'title' => __('Orders'),
            'url' => route('dashboard'),
            'icon' => 'shopping-cart',
        ],
        [
            'title' => __('Products'),
            'url' => route('dashboard'),
            'icon' => 'package',
        ],
        [
            'title' => __('Inventory'),
            'url' => route('dashboard'),
            'icon' => 'warehouse',
        ],
        [
            'title' => __('Invoices'),
            'url' => route('dashboard'),
            'icon' => 'file-text',
        ],
        [
            'title' => __('Reports'),
            'url' => route('dashboard'),
            'icon' => 'bar-chart-3',
        ],
        [
            'title' => __('Messages'),
            'url' => route('dashboard'),
            'icon' => 'mail',
        ],
        [
            'title' => __('Calendar'),
            'url' => route('dashboard'),
            'icon' => 'calendar',
        ],
        [
            'title' => __('Tasks'),
            'url' => route('dashboard'),
            'icon' => 'list-checks',
        ],
        [
            'title' => __('Projects'),
            'url' => route('dashboard'),
            'icon' => 'folder-kanban',
        ],
        [
            'title' => __('Team'),
            'url' => route('dashboard'),
            'icon' => 'user-round',
        ],
        [
            'title' => __('Billing'),
            'url' => route('dashboard'),
            'icon' => 'credit-card',
        ],
        [
            'title' => __('Notifications'),
            'url' => route('dashboard'),
            'icon' => 'bell',
        ],
        [
            'title' => __('Integrations'),
            'url' => route('dashboard'),
            'icon' => 'plug',
        ],
        [
            'title' => __('API'),
            'url' => route('dashboard'),
            'icon' => 'code-2',
        ],
        [
            'title' => __('Security'),
            'url' => route('dashboard'),
            'icon' => 'shield',
        ],
        [
            'title' => __('Support'),
            'url' => route('dashboard'),
            'icon' => 'life-buoy',
        ],
        [
            'title' => __('Settings'),
            'url' => route('profile.edit'),
            'icon' => 'settings',
            'isActive' => request()->routeIs('profile.edit'),
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
