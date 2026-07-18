@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'px-2 py-1.5 text-xs text-muted-foreground';

    $presetAttributes = [
        'data-slot' => 'select-label',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>
