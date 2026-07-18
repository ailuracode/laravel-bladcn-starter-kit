@blaze(fold: true)
{{-- @see https://ui.shadcn.com/docs/components/skeleton --}}

@props([
    'id' => null,
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'animate-pulse rounded-md bg-accent';

    $presetAttributes = [
        'id' => $id,
        'data-slot' => 'skeleton',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>
