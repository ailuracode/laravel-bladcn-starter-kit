@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass =
        'text-lg font-semibold sm:group-data-[size=default]/alert-dialog-content:group-has-data-[slot=alert-dialog-media]/alert-dialog-content:col-start-2';

    $presetAttributes = [
        'data-slot' => 'alert-dialog-title',
        'x-bind:id' => 'id + \'-title\'',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<h2 {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</h2>
