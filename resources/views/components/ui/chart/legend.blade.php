@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'flex flex-wrap items-center justify-center gap-4';

    $presetAttributes = [
        'data-slot' => 'chart-legend',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>
