@blaze(fold: true)

@aware(['defaultValue'])

@props([
    'value' => null,
    'disabled' => false,
    'style' => null,
    'class' => null,
])

@php
    $defaultOpen = match (true) {
        is_array($defaultValue) => $defaultValue,
        filled($defaultValue) => [$defaultValue],
        default => [],
    };

    $initiallyOpen = in_array($value, $defaultOpen, true);

    $presetClass = 'not-last:border-b';

    $presetAttributes = [
        'data-slot' => 'accordion-item',
        'data-value' => $value,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div x-bind:data-open="($store.accordion.isOpen(accordionId, @js($value)) || (
    @js($initiallyOpen) && !Object.hasOwn($store.accordion.groups[
        accordionId]?.open ?? {}, @js($value)))) ? '' : null"
    x-bind:data-disabled="@js((bool) $disabled) ? '' : null"
    {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}
    @if ($initiallyOpen) data-open @endif
    @if ($disabled) data-disabled @endif
    x-init="$store.accordion.registerItem(accordionId, @js($value), @js((bool) $disabled))">
    {{ $slot }}
</div>
