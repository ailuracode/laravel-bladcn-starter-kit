@blaze(fold: true)

@props([
    'asChild' => false,
    'href' => '#',
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'transition-colors hover:text-foreground';

    $presetAttributes = [
        'data-slot' => 'breadcrumb-link',
        'href' => $href,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<a {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</a>
