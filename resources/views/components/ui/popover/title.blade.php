@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'font-medium';

    $presetAttributes = [
        'data-slot' => 'popover-title',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>
