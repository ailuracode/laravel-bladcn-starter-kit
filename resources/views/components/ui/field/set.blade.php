@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass =
        'flex flex-col gap-6 has-[>[data-slot=checkbox-group]]:gap-3 has-[>[data-slot=radio-group]]:gap-3';

    $presetAttributes = [
        'data-slot' => 'field-set',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<fieldset
    {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</fieldset>
