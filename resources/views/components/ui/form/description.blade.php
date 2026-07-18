@blaze(fold: true)

@aware(['id', 'descriptionId', 'messageId', 'error' => false])

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'text-sm text-muted-foreground';

    $presetAttributes = [
        'data-slot' => 'form-description',
        'id' => $descriptionId,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<p {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</p>
