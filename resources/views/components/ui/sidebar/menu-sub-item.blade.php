@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'data-slot' => 'sidebar-menu-sub-item',
        'data-sidebar' => 'menu-sub-item',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<li {{ $attributes->merge($presetAttributes)->class(['group/menu-sub-item relative', $class]) }}>
    {{ $slot }}
</li>
