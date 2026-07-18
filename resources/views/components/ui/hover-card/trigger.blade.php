@blaze(fold: true)

@props([
    'asChild' => false,
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'data-slot' => 'hover-card-trigger',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-bind:data-state' => "isOpen ? 'open' : 'closed'",
    ];
@endphp

<button
    {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}>
    {{ $slot }}
</button>
