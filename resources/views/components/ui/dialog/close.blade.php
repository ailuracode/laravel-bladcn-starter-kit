@blaze(fold: true)

@props([
    'asChild' => true,
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'type' => 'button',
        'data-slot' => 'dialog-close',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-on:click' => '$store.dialog.close(id)',
    ];
@endphp

<button
    {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}>
    {{ $slot }}
</button>
