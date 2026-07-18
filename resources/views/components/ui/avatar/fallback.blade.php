@blaze(fold: true)
{{-- @see https://ui.shadcn.com/docs/components/avatar --}}

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass =
        'absolute inset-0 flex size-full items-center justify-center overflow-hidden rounded-full bg-muted text-sm text-muted-foreground group-data-[size=sm]/avatar:text-xs';

    $presetAttributes = [
        'data-slot' => 'avatar-fallback',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

{{-- FOUC: visible in first HTML byte; hidden by avatar/index JS when the image loads. --}}
<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>
