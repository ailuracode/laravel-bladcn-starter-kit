@blaze(fold: false, safe: ['src', 'alt', 'class'])
{{-- @see https://ui.shadcn.com/docs/components/avatar --}}

@props([
    'src' => null,
    'alt' => '',
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'absolute inset-0 aspect-square size-full rounded-full object-cover';

    $presetAttributes = [
        'data-slot' => 'avatar-image',
        'src' => $src,
        'alt' => $alt,
    ];

    if (filled($src)) {
        // FOUC: native `hidden` paints before Vite/Alpine; JS reveals on load (see avatar/index @pushOnce).
        $presetAttributes['hidden'] = true;
    }

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

@if (filled($src))
    <img {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }} />
@endif
