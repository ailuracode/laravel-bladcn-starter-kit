@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
    'asChild' => false,
])

@php
    $presetClass =
        'flex items-center gap-2 rounded-lg border bg-muted px-4 text-sm font-medium shadow-xs [&_svg]:pointer-events-none [&_svg:not([class*=\'size-\'])]:size-4';

    $presetAttributes = [
        'data-slot' => 'button-group-text',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>
