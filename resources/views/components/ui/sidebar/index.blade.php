@blaze(fold: false)

@props([
    'side' => 'left',
    'variant' => 'sidebar',
    'collapsible' => 'icon',
    'initialExpanded' => null,
    'style' => null,
    'class' => null,
])

@php
    $isInsetOrFloating = in_array($variant, ['floating', 'inset'], true);

    $resolvedInitialExpanded = $initialExpanded ?? request()->cookie('sidebar-expanded', 'true') !== 'false';

    $gapCollapsedClass = $isInsetOrFloating
        ? 'group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4)))]'
        : 'group-data-[collapsible=icon]:w-(--sidebar-width-icon)';

    $panelCollapsedClass = $isInsetOrFloating
        ? 'p-2 group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+(--spacing(4))+2px)]'
        : 'group-data-[collapsible=icon]:w-(--sidebar-width-icon) group-data-[side=left]:border-r group-data-[side=right]:border-l';

    $sidePositionClass = $side === 'right'
        ? 'right-0 group-data-[collapsible=offcanvas]:right-[calc(var(--sidebar-width)*-1)]'
        : 'left-0 group-data-[collapsible=offcanvas]:left-[calc(var(--sidebar-width)*-1)]';

    [$mobileEnterStart, $mobileLeaveEnd] = match ($side) {
        'right' => ['translate-x-full', 'translate-x-full'],
        default => ['-translate-x-full', '-translate-x-full'],
    };
@endphp

@if ($collapsible === 'none')
    <div {{ $attributes->class(['flex h-full w-(--sidebar-width) flex-col bg-sidebar text-sidebar-foreground', $class]) }}
        @if (filled($style)) style="{{ $style }}" @endif
        data-slot="sidebar">
        {{ $slot }}
    </div>
@else
    <button type="button"
        class="fixed inset-0 z-50 bg-black/50 md:hidden"
        aria-label="{{ __('Close navigation') }}"
        x-cloak
        x-show="mobileOpen"
        x-transition:enter="transition-opacity ease-in-out duration-500 motion-reduce:transition-none"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in-out duration-300 motion-reduce:transition-none"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:click="hideMobile()">
    </button>

    {{-- FOUC: SSR cookie attrs below; Alpine x-bind takes over after init. --}}
    <div class="group peer text-sidebar-foreground max-md:contents md:block"
        @if (filled($style)) style="{{ $style }}" @endif
        data-side="{{ $side }}"
        data-slot="sidebar"
        data-variant="{{ $variant }}"
        @if ($collapsible !== 'none' && ! $resolvedInitialExpanded)
            data-collapsible="{{ $collapsible }}"
            data-state="collapsed"
        @elseif ($collapsible !== 'none')
            data-state="expanded"
        @endif
        x-bind:data-collapsible="isDesktop && !expanded ? @js($collapsible) : null"
        x-bind:data-state="isDesktop
            ? (expanded ? 'expanded' : 'collapsed')
            : (mobileOpen ? 'open' : 'closed')">
        <div @class([
            'relative w-(--sidebar-width) bg-transparent transition-[width] duration-200 ease-linear',
            'group-data-[collapsible=offcanvas]:w-0',
            'group-data-[side=right]:rotate-180',
            $gapCollapsedClass,
            'hidden md:block',
        ])
            data-slot="sidebar-gap"></div>

        {{-- FOUC: no x-cloak — `hidden md:flex` keeps desktop painted before Alpine (x-cloak would force display:none). --}}
        <div {{ $attributes->class([
            'fixed inset-y-0 z-10 hidden h-svh w-(--sidebar-width) transition-[left,right,width] duration-200 ease-linear md:flex',
            $sidePositionClass,
            $panelCollapsedClass,
            $class,
        ]) }}
            data-slot="sidebar-container"
            x-show="isDesktop || $store.sidebar.visible"
            x-bind:class="!isDesktop && mobileOpen && 'flex! z-50 max-md:bg-sidebar max-md:p-0 max-md:text-sidebar-foreground max-md:[&>button]:hidden'"
            x-bind:style="!isDesktop && mobileOpen ? { '--sidebar-width': '18rem' } : null"
            x-transition:enter="transition ease-in-out duration-500 will-change-transform motion-reduce:transition-none md:transition-none"
            x-transition:enter-start="{{ $mobileEnterStart }}"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 will-change-transform motion-reduce:transition-none md:transition-none"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="{{ $mobileLeaveEnd }}"
            x-bind:aria-modal="!isDesktop ? 'true' : null"
            x-bind:role="!isDesktop ? 'dialog' : null"
            x-bind:data-mobile="!isDesktop ? 'true' : null">
            <div class="flex h-full w-full flex-col bg-sidebar group-data-[variant=floating]:rounded-lg group-data-[variant=floating]:border group-data-[variant=floating]:border-sidebar-border group-data-[variant=floating]:shadow-sm"
                data-sidebar="sidebar"
                data-slot="sidebar-inner"
                x-on:click="handleMobileNavClick($event)">
                <div class="sr-only md:hidden">
                    <h2>{{ __('Sidebar') }}</h2>
                    <p>{{ __('Displays the mobile sidebar.') }}</p>
                </div>
                {{ $slot }}
            </div>
        </div>
    </div>
@endif
