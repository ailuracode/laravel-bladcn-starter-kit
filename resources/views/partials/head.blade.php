<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

{{-- Restore sidebar compact state before paint (must run before critical CSS below). --}}
<script>
    (function () {
        const themeKey = 'theme';
        const sidebarExpandedKey = 'sidebar-expanded';

        function applyTheme() {
            const stored = localStorage.getItem(themeKey);
            const mode = stored === 'light' || stored === 'dark' || stored === 'system' ? stored : 'system';
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const dark = mode === 'dark' || (mode === 'system' && prefersDark);

            document.documentElement.classList.toggle('dark', dark);
            document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
        }

        function applySidebarExpanded() {
            try {
                document.documentElement.toggleAttribute(
                    'data-sidebar-collapsed',
                    localStorage.getItem(sidebarExpandedKey) === 'false',
                );
            } catch (e) {
                document.documentElement.removeAttribute('data-sidebar-collapsed');
            }
        }

        applyTheme();
        applySidebarExpanded();

        document.addEventListener('livewire:navigating', () => {
            document.documentElement.removeAttribute('data-alpine-initialized');
        });

        document.addEventListener('livewire:navigating', (event) => {
            event.detail.onSwap?.(() => {
                applyTheme();
                applySidebarExpanded();
            });
        });

        document.addEventListener('livewire:navigated', () => {
            applyTheme();
            applySidebarExpanded();
        });
    })();
</script>

{{-- Critical sidebar CSS — compact layout before Alpine/Tailwind group-data (FOUC guard). --}}
<style>
    @media (min-width: 768px) {
        /* Layout width — tied to html attr (synced with localStorage), not Alpine init */
        html[data-sidebar-collapsed] [data-slot="sidebar-gap"] {
            width: calc(var(--sidebar-width-icon, 3rem) + 1rem) !important;
        }

        html[data-sidebar-collapsed] [data-slot="sidebar-container"] {
            width: calc(var(--sidebar-width-icon, 3rem) + 1rem + 2px) !important;
        }

        /* Sidebar chrome — FOUC guard until Alpine applies group-data */
        html[data-sidebar-collapsed]:not([data-alpine-initialized]) [data-slot="sidebar-group-label"] {
            margin-top: -2rem !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        html[data-sidebar-collapsed]:not([data-alpine-initialized]) [data-sidebar="menu-button"] {
            width: 2rem !important;
            height: 2rem !important;
            overflow: hidden !important;
        }

        html[data-sidebar-collapsed]:not([data-alpine-initialized]) [data-sidebar="menu-button"]:not([data-size="lg"]) {
            padding: 0.5rem !important;
        }

        html[data-sidebar-collapsed]:not([data-alpine-initialized]) [data-sidebar="menu-button"][data-size="lg"] {
            padding: 0 !important;
        }

        html[data-sidebar-collapsed]:not([data-alpine-initialized]) [data-slot="sidebar-footer"] [data-slot="sidebar-group"] {
            padding: 0 !important;
        }

        html[data-sidebar-collapsed]:not([data-alpine-initialized]) [data-sidebar="menu-button"] > *:not(:first-child) {
            display: none !important;
        }
    }

    @media (max-width: 767px) {
        [data-slot="sidebar-container"] {
            transform: translate3d(-100%, 0, 0);
        }

        html[data-sidebar] [data-slot="sidebar-container"] {
            transform: translate3d(0, 0, 0);
        }
    }
</style>

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

@livewireStyles

@livewireScriptConfig

@vite(['resources/css/app.css', 'resources/js/app.ts'])
