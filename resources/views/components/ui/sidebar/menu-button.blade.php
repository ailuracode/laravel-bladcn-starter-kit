@blaze(fold: true)

@props([
    'asChild' => false,
    'isActive' => false,
    'href' => '#',
    'size' => 'default',
    'variant' => 'default',
    'tooltip' => null,
    'style' => null,
    'class' => null,
])

@php
    $baseClass =
        'peer/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm ring-sidebar-ring outline-hidden transition-[width,height,padding] group-has-data-[sidebar=menu-action]/menu-item:pr-8 group-data-[collapsible=icon]:size-8! hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 data-[active=true]:bg-sidebar-accent data-[active=true]:font-medium data-[active=true]:text-sidebar-accent-foreground data-[state=open]:hover:bg-sidebar-accent data-[state=open]:hover:text-sidebar-accent-foreground [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0';

    $variantClass = match ($variant) {
        'outline'
            => 'bg-background shadow-[0_0_0_1px_var(--sidebar-border)] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground hover:shadow-[0_0_0_1px_var(--sidebar-accent)]',
        default => 'hover:bg-sidebar-accent hover:text-sidebar-accent-foreground',
    };

    $sizeClass = match ($size) {
        'sm' => 'h-7 text-xs group-data-[collapsible=icon]:p-2!',
        'lg' => 'h-12 text-sm group-data-[collapsible=icon]:p-0!',
        default => 'h-8 text-sm group-data-[collapsible=icon]:p-2!',
    };

    $presetClass = implode(' ', [$baseClass, $variantClass, $sizeClass]);

    $presetAttributes = [
        'data-slot' => 'sidebar-menu-button',
        'data-sidebar' => 'menu-button',
        'data-size' => $size,
        'data-active' => $isActive ? 'true' : 'false',
        'href' => $href,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<a {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}
    data-sidebar-nav-trigger
    x-data="bladcnSidebarNavItem({ delayDuration: 0, tooltip: @js($tooltip) })"
    x-ref="menuButton"
    x-on:mouseenter="show()"
    x-on:mouseleave="hide()"
    x-on:focus="show()"
    x-on:blur="hide()"
    x-bind:aria-label="ariaLabel">
    {{ $slot }}

    <template x-teleport="body">
        <div data-sidebar-nav-tooltip
            role="tooltip"
            data-slot="tooltip-content"
            x-show="isOpen"
            x-cloak
            x-anchor.right.offset.8.fixed="$refs.menuButton"
            x-transition:enter="transition ease-out duration-150 motion-reduce:transition-none"
            x-transition:enter-start="opacity-0 scale-95 -translate-x-2"
            x-transition:enter-end="opacity-100 scale-100 translate-x-0"
            x-transition:leave="transition ease-in duration-100 motion-reduce:transition-none"
            x-transition:leave-start="opacity-100 scale-100 translate-x-0"
            x-transition:leave-end="opacity-0 scale-95 -translate-x-2"
            class="pointer-events-none z-50 w-fit">
            <div class="relative w-fit origin-left rounded-md bg-foreground px-3 py-1.5 text-xs text-balance text-background">
                <span x-text="label"></span>
                <span aria-hidden="true"
                    class="pointer-events-none absolute top-1/2 left-0 block size-2.5 -translate-x-1/2 -translate-y-1/2 rotate-45 rounded-[2px] bg-foreground"></span>
            </div>
        </div>
    </template>
</a>
@pushOnce('bladcn-scripts')
    <script>
        bladcnOnAlpine((Alpine) => {
            const findSidebarData = (element) => {
                if (!element || typeof element.closest !== 'function') {
                    return null;
                }

                const wrapper = element.closest('[data-slot="sidebar-wrapper"]');

                if (!wrapper) {
                    return null;
                }

                return Alpine.$data(wrapper);
            };

            Alpine.data('bladcnSidebarNavItem', (config = {}) => ({
                isOpen: false,
                delayDuration: config.delayDuration ?? 0,
                tooltipEnabled: config.tooltip !== false,
                timeout: null,
                sidebar: null,
                label: '',

                init() {
                    this.sidebar = findSidebarData(this.$el);

                    if (typeof config.tooltip === 'string') {
                        this.label = config.tooltip;
                    } else {
                        this.label =
                            this.$el.querySelector('[data-sidebar-nav-label]')?.textContent.trim() ??
                            this.$el.querySelector('span')?.textContent.trim() ??
                            this.$el.textContent.trim();
                    }
                },

                destroy() {
                    if (this.timeout !== null) {
                        clearTimeout(this.timeout);
                        this.timeout = null;
                    }
                },

                get isCollapsed() {
                    return Boolean(this.sidebar?.isDesktop) && this.sidebar?.expanded === false;
                },

                get ariaLabel() {
                    return this.isCollapsed ? this.label : null;
                },

                show() {
                    if (!this.tooltipEnabled || !this.isCollapsed || this.label === '') {
                        return;
                    }

                    clearTimeout(this.timeout);

                    if (this.delayDuration > 0) {
                        this.timeout = setTimeout(() => {
                            this.isOpen = true;
                        }, this.delayDuration);

                        return;
                    }

                    this.isOpen = true;
                },

                hide() {
                    clearTimeout(this.timeout);
                    this.timeout = null;
                    this.isOpen = false;
                },
            }));
        });
    </script>
@endPushOnce
