@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'ml-auto text-xs tracking-widest text-muted-foreground';

    $presetAttributes = [
        'data-slot' => 'menubar-shortcut',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<span
    {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</span>
