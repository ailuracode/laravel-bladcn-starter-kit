{{-- Must register before @livewireScripts: deferred Vite modules load after Alpine.start(). --}}
<script>
    (function () {
        const BREAKPOINTS = {
            md: 768,
            lg: 1024,
        };

        const MEDIA_QUERIES = {
            mobile: `(max-width: ${BREAKPOINTS.md - 1}px)`,
            tablet: `(min-width: ${BREAKPOINTS.md}px) and (max-width: ${BREAKPOINTS.lg - 1}px)`,
            desktop: `(min-width: ${BREAKPOINTS.lg}px)`,
        };

        function resolveDevice(isMobile, isTablet) {
            if (isMobile) {
                return 'mobile';
            }

            if (isTablet) {
                return 'tablet';
            }

            return 'desktop';
        }

        window.bladcnBreakpoints = {
            BREAKPOINTS,
            MEDIA_QUERIES,
            resolveDevice,
        };

        bladcnOnAlpine((Alpine) => {
            const mediaQueryMobile = window.matchMedia(MEDIA_QUERIES.mobile);
            const mediaQueryTablet = window.matchMedia(MEDIA_QUERIES.tablet);
            const mediaQueryDesktop = window.matchMedia(MEDIA_QUERIES.desktop);

            Alpine.store('bladcnBreakpoints', {
                device: 'desktop',
                isMobile: mediaQueryMobile.matches,
                isTablet: mediaQueryTablet.matches,
                isDesktop: mediaQueryDesktop.matches,

                sync() {
                    this.isMobile = mediaQueryMobile.matches;
                    this.isTablet = mediaQueryTablet.matches;
                    this.isDesktop = mediaQueryDesktop.matches;
                    this.device = resolveDevice(this.isMobile, this.isTablet);
                },

                init() {
                    this.sync();

                    mediaQueryMobile.addEventListener('change', () => this.sync());
                    mediaQueryTablet.addEventListener('change', () => this.sync());
                    mediaQueryDesktop.addEventListener('change', () => this.sync());
                },
            });

            Alpine.store('bladcnBreakpoints').init();
        });
    })();
</script>
