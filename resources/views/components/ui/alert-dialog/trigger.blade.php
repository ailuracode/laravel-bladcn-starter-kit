@blaze(fold: true)

@props([
    'asChild' => true,
    'variant' => null,
    'size' => 'default',
    'style' => null,
    'class' => null,
])

@php
    $presetAttributes = [
        'type' => 'button',
        'data-slot' => 'alert-dialog-trigger',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-on:click' => '$store.dialog.open(id, { trigger: $event.target })',
        'x-bind:data-state' =>
            '$store.dialog.isOpen(id) ? \'open\' : \'closed\'',
        'x-bind:aria-expanded' => '$store.dialog.isOpen(id)',
    ];
@endphp

@if (filled($variant))
    <x-ui.button :size="$size"
        :variant="$variant"
        {{ $attributes->except(['variant', 'size'])->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}>
        {{ $slot }}
    </x-ui.button>
@else
    <button
        {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class($class) }}>
        {{ $slot }}
    </button>
@endif
