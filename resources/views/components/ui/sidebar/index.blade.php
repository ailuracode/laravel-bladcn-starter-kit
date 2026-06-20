@blaze(fold: true)
{{-- @see https://ui.shadcn.com/docs/components/sidebar --}}

@props([
    'side' => 'left',
    'collapsible' => 'icon',
    'variant' => 'sidebar',
    'style' => null,
    'class' => null,
])

@php
    $isInsetOrFloating = in_array($variant, ['inset', 'floating'], true);

    $innerClass = $isInsetOrFloating
        ? 'rounded-lg border border-sidebar-border shadow-sm'
        : '';

    $gapIconWidth = $isInsetOrFloating
        ? 'group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4)))]'
        : 'group-data-[collapsible=icon]:w-(--sidebar-width-icon)';

    $fixedIconWidth = $isInsetOrFloating
        ? 'group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4))+2px)] group-data-[collapsible=icon]:p-2!'
        : 'group-data-[collapsible=icon]:w-(--sidebar-width-icon)';

    $fixedBorder = $isInsetOrFloating
        ? ''
        : ($side === 'left' ? 'border-e border-sidebar-border' : 'border-s border-sidebar-border');

    $presetAttributes = [
        'data-slot' => 'sidebar',
        'data-side' => $side,
        'data-variant' => $variant,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

@if ($collapsible === 'none')
    <div
        {{ $attributes->merge($presetAttributes)->class(['flex h-full w-(--sidebar-width) flex-col bg-sidebar text-sidebar-foreground', $class]) }}>
        {{ $slot }}
    </div>
@else
    <div
        {{ $attributes->merge($presetAttributes)->class(['group peer relative text-sidebar-foreground', $class]) }}
        x-bind:data-state="$store.bladcnSidebar.state"
        x-bind:data-collapsible="! $store.bladcnSidebar.open ? @js($collapsible) : null"
    >
        <div
            data-slot="sidebar-mobile-overlay"
            data-state="closed"
            x-cloak
            x-show="$store.bladcnSidebar.isMobile && $store.bladcnSidebar.mobilePresent"
            x-on:click="$store.bladcnSidebar.setOpen(false)"
            x-bind:data-state="$store.bladcnSidebar.mobileAnimationState"
            class="fixed inset-0 z-40 bg-black/50 md:hidden"
        ></div>

        <div
            aria-hidden="true"
            class="relative hidden w-(--sidebar-width) bg-transparent transition-[width] duration-200 ease-linear group-data-[collapsible=offcanvas]:w-0 md:block {{ $gapIconWidth }}"
            x-bind:class="$store.bladcnSidebar.open ? 'w-(--sidebar-width)' : (@js($collapsible) === 'icon' ? 'w-(--sidebar-width-icon)' : 'w-0')"
        ></div>

        <div
            data-slot="sidebar-mobile-panel"
            data-state="closed"
            class="fixed inset-y-0 z-50 flex h-svh w-(--sidebar-width) md:translate-x-0 md:transition-[width] md:duration-200 md:ease-linear md:z-10 {{ $fixedIconWidth }} {{ $fixedBorder }} {{ $side === 'left' ? 'start-0 group-data-[collapsible=offcanvas]:md:-start-(--sidebar-width)' : 'end-0 group-data-[collapsible=offcanvas]:md:-end-(--sidebar-width)' }}"
            x-cloak
            x-show="! $store.bladcnSidebar.isMobile || $store.bladcnSidebar.mobilePresent"
            x-bind:data-state="$store.bladcnSidebar.isMobile ? $store.bladcnSidebar.mobileAnimationState : 'open'"
            x-bind:class="[
                $store.bladcnSidebar.open
                    ? 'md:w-(--sidebar-width)'
                    : (@js($collapsible) === 'icon' ? 'md:w-(--sidebar-width-icon)' : 'md:w-(--sidebar-width)'),
            ]"
        >
            <div
                @class([
                    'relative flex h-full w-full flex-col overflow-hidden bg-sidebar',
                    $innerClass,
                ])
                data-sidebar="sidebar"
                data-slot="sidebar-inner"
                x-on:click="if ($store.bladcnSidebar.isMobile && $event.target.closest('a[href]:not([target=_blank]), button[type=submit]')) { $store.bladcnSidebar.setOpen(false); }"
            >
                {{ $slot }}
            </div>
        </div>

        <x-ui.sidebar.rail class="max-md:hidden" />
    </div>
@endif
