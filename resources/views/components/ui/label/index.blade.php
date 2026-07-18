@blaze(fold: true)
{{-- @see https://ui.shadcn.com/docs/components/label --}}

@props([
    'id' => null,
    'for' => null,
    'style' => null,
    'class' => null,
    'asChild' => false,
])

@php
    $presetClass =
        'flex items-center gap-2 text-sm leading-none font-medium select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50';

    $presetAttributes = [
        'id' => $id,
        'data-slot' => 'label',
    ];

    if (filled($for)) {
        $presetAttributes['for'] = $for;
    }

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<label
    {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</label>
