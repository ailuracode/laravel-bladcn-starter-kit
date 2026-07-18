@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'text-sm text-muted-foreground';

    $presetAttributes = [
        'data-slot' => 'alert-dialog-description',
        'x-bind:id' => 'id + \'-description\'',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<p {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</p>
