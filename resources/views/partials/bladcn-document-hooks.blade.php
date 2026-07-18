<script>
    window.bladcnOnAlpine = window.bladcnOnAlpine ?? ((callback) => {
        const run = () => {
            if (typeof window.Alpine === 'undefined') {
                return;
            }

            callback(window.Alpine);
        };

        if (typeof window.Alpine !== 'undefined') {
            run();

            return;
        }

        document.addEventListener('alpine:init', run, {
            once: true,
        });
    });

    window.bladcnRegister = window.bladcnRegister ?? ((name, factory) => {
        bladcnOnAlpine((Alpine) => {
            Alpine.data(name, factory);
        });
    });

    window.bladcnSidebarLayout = window.bladcnSidebarLayout ?? {
        STORAGE_KEY: 'sidebar-expanded',
        COOKIE_MAX_AGE: 31536000,
        DESKTOP_QUERY: '(min-width: 768px)',

        readCookie() {
            const match = document.cookie.match(/(?:^|;\s*)sidebar-expanded=([^;]+)/);

            return match ? decodeURIComponent(match[1]) : null;
        },

        readExpanded() {
            try {
                let value = localStorage.getItem(this.STORAGE_KEY);

                if (value === null) {
                    value = this.readCookie();
                }

                if (value === 'false') {
                    return false;
                }

                if (value === 'true') {
                    return true;
                }

                return true;
            } catch {
                return true;
            }
        },

        writeExpanded(value) {
            const stringValue = String(value);

            try {
                localStorage.setItem(this.STORAGE_KEY, stringValue);
                document.cookie = `${this.STORAGE_KEY}=${stringValue}; path=/; max-age=${this.COOKIE_MAX_AGE}; SameSite=Lax`;
            } catch {}
        },

        migrateStorageToCookie() {
            try {
                const stored = localStorage.getItem(this.STORAGE_KEY);

                if (stored === 'false' || stored === 'true') {
                    this.writeExpanded(stored === 'true');
                }
            } catch {}
        },

        isDesktopViewport() {
            return window.matchMedia(this.DESKTOP_QUERY).matches;
        },

        syncSidebarElement(sidebar) {
            if (!sidebar || !this.isDesktopViewport()) {
                return;
            }

            if (this.readExpanded() === false) {
                sidebar.setAttribute('data-collapsible', 'icon');
                sidebar.setAttribute('data-state', 'collapsed');
            } else {
                sidebar.setAttribute('data-state', 'expanded');
                sidebar.removeAttribute('data-collapsible');
            }
        },

        applyFootGuard() {
            const sidebar = document.querySelector('[data-slot="sidebar"]');

            if (sidebar) {
                this.syncSidebarElement(sidebar);

                return true;
            }

            return false;
        },
    };

    (function () {
        const stored = localStorage.getItem('theme');
        const mode = stored === 'light' || stored === 'dark' || stored === 'system' ? stored : 'system';
        const resolved = mode === 'system'
            ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
            : mode;

        document.documentElement.classList.toggle('dark', resolved === 'dark');
        document.documentElement.style.colorScheme = resolved;
    })();

    try {
        // FOUC: mirror localStorage → cookie so the next SSR response matches desktop collapse.
        window.bladcnSidebarLayout.migrateStorageToCookie();
    } catch {
        console.error('Error migrating sidebar preference to cookie');
    }
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
