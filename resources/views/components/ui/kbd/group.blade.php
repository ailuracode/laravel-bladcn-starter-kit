@blaze(fold: true)

@props([
    'id' => null,
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'inline-flex items-center gap-1';

    $presetAttributes = [
        'id' => $id,
        'data-slot' => 'kbd-group',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<kbd {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</kbd>
