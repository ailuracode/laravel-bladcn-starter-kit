@blaze(fold: true)

@props([
    'asChild' => false,
    'showOnHover' => false,
    'style' => null,
    'class' => null,
])

@php
    $showOnHoverClass = $showOnHover
        ? 'group-focus-within/menu-item:opacity-100 group-hover/menu-item:opacity-100 peer-data-[active=true]/menu-button:text-sidebar-accent-foreground data-[state=open]:opacity-100 md:opacity-0'
        : '';

    $presetClass = implode(' ', [
        'absolute top-1.5 right-1 flex aspect-square w-5 items-center justify-center rounded-md p-0 text-sidebar-foreground ring-sidebar-ring outline-hidden transition-transform peer-hover/menu-button:text-sidebar-accent-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 [&>svg]:size-4 [&>svg]:shrink-0 after:absolute after:-inset-2 md:after:hidden peer-data-[size=sm]/menu-button:top-1 peer-data-[size=default]/menu-button:top-1.5 peer-data-[size=lg]/menu-button:top-2.5 group-data-[collapsible=icon]:hidden',
        $showOnHoverClass,
    ]);

    $presetAttributes = [
        'data-slot' => 'sidebar-menu-action',
        'data-sidebar' => 'menu-action',
        'type' => 'button',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<button {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</button>
