@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])


@php
    $presetClass =
        'relative flex w-full flex-1 flex-col bg-background md:peer-data-[variant=inset]:m-2 md:peer-data-[variant=inset]:ml-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow-sm md:peer-data-[variant=inset]:peer-data-[state=collapsed]:ml-2';

    $presetAttributes = [
        'data-slot' => 'sidebar-inset',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<main
    {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</main>
