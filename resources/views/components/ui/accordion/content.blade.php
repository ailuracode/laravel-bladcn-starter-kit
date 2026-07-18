@blaze(fold: true)

@aware(['value', 'defaultValue', 'transition' => true])

@props([
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

    $presetClass = 'overflow-hidden text-sm';

    $innerClass =
        'pt-0 pb-2.5 [&_a]:underline [&_a]:underline-offset-3 [&_a]:hover:text-foreground [&_p:not(:last-child)]:mb-4';

    $presetAttributes = [
        'data-slot' => 'accordion-content',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div x-bind:data-open="($store.accordion.isOpen(accordionId, @js($value)) || (
    @js($initiallyOpen) && !Object.hasOwn($store.accordion.groups[
        accordionId]?.open ?? {}, @js($value)))) ? '' : null"
    {{ $attributes->merge($presetAttributes)->class($presetClass) }}
    @if ($initiallyOpen) data-open @endif
    @if ($transition) x-collapse @endif
    @unless ($initiallyOpen)
        x-cloak
    @endunless
    x-bind="$store.accordion.panelProps(accordionId, @js($value))"
    x-show="$store.accordion.isOpen(accordionId, @js($value)) || (@js($initiallyOpen) && ! Object.hasOwn($store.accordion.groups[accordionId]?.open ?? {}, @js($value)))">
    <div @class([$innerClass, $class])>
        {{ $slot }}
    </div>
</div>
