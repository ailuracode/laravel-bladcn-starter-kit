@blaze(fold: true)

@props([
    'asChild' => false,
    'isActive' => false,
    'href' => '#',
    'size' => 'md',
    'style' => null,
    'class' => null,
])

@php
    $sizeClass = match ($size) {
        'sm' => 'text-xs',
        default => 'text-sm',
    };

    $presetClass = implode(' ', [
        'flex h-7 min-w-0 -translate-x-px items-center gap-2 overflow-hidden rounded-md px-2 text-sidebar-foreground ring-sidebar-ring outline-hidden hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0 [&>svg]:text-sidebar-accent-foreground data-[active=true]:bg-sidebar-accent data-[active=true]:text-sidebar-accent-foreground group-data-[collapsible=icon]:hidden',
        $sizeClass,
    ]);

    $presetAttributes = [
        'data-slot' => 'sidebar-menu-sub-button',
        'data-sidebar' => 'menu-sub-button',
        'data-size' => $size,
        'data-active' => $isActive ? 'true' : 'false',
        'href' => $href,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<a {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</a>
