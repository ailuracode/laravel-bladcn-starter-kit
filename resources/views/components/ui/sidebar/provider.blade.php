@blaze(fold: false)

@props([
    'style' => null,
    'class' => null,
])
@php
    $presetClass =
        'group/sidebar-wrapper flex min-h-svh w-full has-data-[variant=inset]:bg-sidebar';

    $presetAttributes = [
        'data-slot' => 'sidebar-wrapper',
    ];

    $mergedStyle = trim(
        collect(['--sidebar-width: 16rem; --sidebar-width-icon: 3rem;', $style])
            ->filter()
            ->implode(' '),
    );
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}
    @if ($mergedStyle !== '') style="{{ $mergedStyle }}" @endif
    x-data="bladcnSidebar()">
    {{ $slot }}
</div>

{{-- FOUC: cookie SSR in sidebar/index + writeExpanded cookie mirror; foot script is legacy fallback. --}}
@pushOnce('bladcn-scripts')
    <script>
        bladcnOnAlpine((Alpine) => {
            const layout = window.bladcnSidebarLayout;
            const DESKTOP_MEDIA_QUERY = layout?.DESKTOP_QUERY ?? '(min-width: 768px)';

            const readStoredExpanded = () => layout?.readExpanded?.() ?? true;

            const writeStoredExpanded = (value) => {
                layout?.writeExpanded?.(value);
            };

            const resolveLayoutMode = (mediaBreakpoint) => {
                if (mediaBreakpoint === 'desktop' || mediaBreakpoint === 'mobile') {
                    return mediaBreakpoint;
                }

                return window.matchMedia(DESKTOP_MEDIA_QUERY).matches ? 'desktop' : 'mobile';
            };

            const syncSidebarElement = (sidebar) => {
                layout?.syncSidebarElement?.(sidebar);
            };

            const emitSidebarLayout = () => {
                if (typeof window === 'undefined') {
                    return;
                }

                window.dispatchEvent(new CustomEvent('bladcn:sidebar-layout'));
            };

            const findAnchor = (event) => {
                if (!(event?.target instanceof Element)) {
                    return null;
                }

                return event.target.closest('a[href], button[data-sidebar-nav], [data-sidebar-nav-link]');
            };

            Alpine.data('bladcnSidebar', () => ({
                expanded: readStoredExpanded(),

                init() {
                    this.expanded = readStoredExpanded();
                    this.syncCollapsedDom();
                    this.$watch('layoutMode', () => {
                        syncSidebarElement(this.$root.querySelector('[data-slot="sidebar"]'));
                        emitSidebarLayout();
                    });
                    const onNavigate = () => this.syncExpandedFromStorage();
                    document.addEventListener('livewire:navigated', onNavigate);
                    this.$cleanup(() => document.removeEventListener('livewire:navigated', onNavigate));
                    this.$nextTick(() => emitSidebarLayout());
                },

                get layoutMode() {
                    return resolveLayoutMode(this.$store.media?.breakpoint);
                },

                get isDesktop() {
                    return this.layoutMode === 'desktop';
                },

                get effectivelyExpanded() {
                    return this.expanded || !this.isDesktop;
                },

                get mobileOpen() {
                    return !this.isDesktop && Boolean(this.$store.sidebar?.visible);
                },

                syncCollapsedDom() {
                    syncSidebarElement(this.$root.querySelector('[data-slot="sidebar"]'));
                },

                toggleExpanded() {
                    if (!this.isDesktop) {
                        return;
                    }

                    this.expanded = !this.expanded;
                    writeStoredExpanded(this.expanded);
                    this.syncCollapsedDom();
                    emitSidebarLayout();
                },

                syncExpandedFromStorage() {
                    this.expanded = readStoredExpanded();
                    this.syncCollapsedDom();
                },

                showMobile() {
                    if (this.isDesktop) {
                        this.toggleExpanded();

                        return;
                    }

                    this.$store.sidebar.show();
                },

                hideMobile() {
                    if (this.isDesktop) {
                        return;
                    }

                    this.$store.sidebar.hide();
                },

                toggleMobile() {
                    if (this.isDesktop) {
                        this.toggleExpanded();

                        return;
                    }

                    this.$store.sidebar.toggle();
                },

                handleMobileNavClick(event) {
                    if (this.isDesktop) {
                        return;
                    }

                    if (findAnchor(event)) {
                        this.hideMobile();
                    }
                },
            }));
        });
    </script>
@endPushOnce
