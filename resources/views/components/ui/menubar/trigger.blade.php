@blaze(fold: true)

@aware(['value' => null])

@props([
    'asChild' => false,
    'style' => null,
    'class' => null,
])

@php
    $presetClass =
        'flex cursor-default items-center rounded-sm px-2 py-1 text-sm font-medium outline-hidden select-none focus:bg-accent focus:text-accent-foreground data-[state=open]:bg-accent data-[state=open]:text-accent-foreground';

    $presetAttributes = [
        'type' => 'button',
        'data-slot' => 'menubar-trigger',
        'role' => 'menuitem',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }

    $alpineAttributes = [
        'x-on:click' =>
            'openMenu(' . \Illuminate\Support\Js::from($value) . ', $event)',
        'x-bind:data-state' =>
            'isMenuOpen(' .
            \Illuminate\Support\Js::from($value) .
            ') ? \'open\' : \'closed\'',
    ];
@endphp

<button
    {{ $attributes->merge($presetAttributes)->merge($alpineAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</button>
