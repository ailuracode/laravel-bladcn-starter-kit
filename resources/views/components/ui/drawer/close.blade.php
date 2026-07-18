@blaze(fold: true)

@props([
    'asChild' => false,
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'type' => 'button',
        'data-slot' => 'drawer-close',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-on:click' => 'close()',
    ];
@endphp

<button
    {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}>
    {{ $slot }}
</button>
