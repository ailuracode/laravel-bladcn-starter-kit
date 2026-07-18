@blaze(fold: true)

@props([
    'asChild' => true,
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'type' => 'button',
        'data-slot' => 'collapsible-trigger',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-on:click' => 'toggle()',
        'x-bind:data-state' => 'isOpen ? \'open\' : \'closed\'',
        'x-bind:aria-expanded' => 'isOpen',
        'x-bind:aria-controls' => 'id + \'-content\'',
    ];
@endphp

<button
    {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}>
    {{ $slot }}
</button>
