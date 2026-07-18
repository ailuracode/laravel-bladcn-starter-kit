@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass =
        'mx-3.5 flex min-w-0 translate-x-px flex-col gap-1 border-l border-sidebar-border px-2.5 py-0.5 group-data-[collapsible=icon]:hidden';

    $presetAttributes = [
        'data-slot' => 'sidebar-menu-sub',
        'data-sidebar' => 'menu-sub',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<ul {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</ul>
