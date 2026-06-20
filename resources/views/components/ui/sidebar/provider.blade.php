@blaze(fold: false)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass = new \AiluraCode\Bladcn\Support\ClassResolver()->add(
        'group/sidebar-wrapper flex min-h-svh w-full has-[[data-variant=inset]]:bg-sidebar',
    );

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
    x-init="$store.bladcnSidebar.init()"
    x-bind:data-state="$store.bladcnSidebar.state"
    x-bind:data-collapsible="! $store.bladcnSidebar.open ? 'icon' : null"
    x-effect="$store.bladcnSidebar.syncMobileScrollLock()"
    x-on:keydown.escape.window="$store.bladcnSidebar.isMobile && $store.bladcnSidebar.setOpen(false)">
    {{ $slot }}
</div>
@pushOnce('bladcn-scripts')
    <script>
        bladcnOnAlpine((Alpine) => {
            const MOBILE_ANIMATION_DURATION = 200;

            Alpine.store('bladcnSidebar', {
                open: true,
                openMobile: false,
                mobilePresent: false,
                mobileAnimationState: 'closed',
                mobileCloseTimer: null,
                isMobile: window.matchMedia('(max-width: 767px)').matches,
                mediaQuery: window.matchMedia('(max-width: 767px)'),

                init() {
                    this.mediaQuery.addEventListener('change', (
                        event) => {
                        this.isMobile = event.matches;

                        if (! event.matches) {
                            this.resetMobile();
                        }
                    });
                },

                get state() {
                    return this.open ? 'expanded' : 'collapsed';
                },

                resetMobile() {
                    clearTimeout(this.mobileCloseTimer);
                    this.openMobile = false;
                    this.mobilePresent = false;
                    this.mobileAnimationState = 'closed';
                },

                openMobileDrawer() {
                    clearTimeout(this.mobileCloseTimer);
                    this.openMobile = true;
                    this.mobilePresent = true;
                    this.mobileAnimationState = 'closed';

                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            this.mobileAnimationState = 'open';
                        });
                    });
                },

                closeMobile() {
                    if (! this.mobilePresent) {
                        return;
                    }

                    clearTimeout(this.mobileCloseTimer);
                    this.openMobile = false;
                    this.mobileAnimationState = 'closed';

                    this.mobileCloseTimer = setTimeout(() => {
                        this.mobilePresent = false;

                        requestAnimationFrame(() => {
                            this.mobileAnimationState = 'closed';
                        });
                    }, MOBILE_ANIMATION_DURATION);
                },

                toggle() {
                    if (this.isMobile) {
                        if (this.openMobile) {
                            this.closeMobile();
                        } else {
                            this.openMobileDrawer();
                        }

                        return;
                    }

                    this.open = ! this.open;
                },

                setOpen(value) {
                    if (this.isMobile) {
                        if (value) {
                            this.openMobileDrawer();
                        } else {
                            this.closeMobile();
                        }

                        return;
                    }

                    this.open = value;
                },

                syncMobileScrollLock() {
                    if (this.isMobile && this.mobilePresent) {
                        window.bladcnBodyScrollLock?.lock();
                    } else if (this.isMobile) {
                        window.bladcnBodyScrollLock?.unlock();
                    }
                },
            });
        });
    </script>
@endPushOnce
