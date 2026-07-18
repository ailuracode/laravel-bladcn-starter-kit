@blaze(fold: true)

@props([
    'asChild' => false,
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'data-slot' => 'tooltip-trigger',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-on:mouseenter' => 'show()',
        'x-on:mouseleave' => 'hide()',
        'x-on:focus' => 'show()',
        'x-on:blur' => 'hide()',
    ];
@endphp

<button
    {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}>
    {{ $slot }}
</button>
