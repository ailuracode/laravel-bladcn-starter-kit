@blaze(fold: true)

@props([
    'asChild' => false,
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'type' => 'button',
        'data-slot' => 'popover-trigger',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-ref' => 'trigger',
        'x-on:click' => 'toggle($event)',
        'x-bind:data-state' => "isOpen ? 'open' : 'closed'",
        'x-bind:aria-expanded' => 'isOpen',
    ];
@endphp

<button
    {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}>
    {{ $slot }}
</button>
