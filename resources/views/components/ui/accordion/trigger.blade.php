@blaze(fold: true)

@aware(['value', 'defaultValue', 'disabled' => false])

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

    $presetClass = implode(' ', [
        'group/accordion-trigger relative flex flex-1 items-start justify-between rounded-lg border border-transparent py-2.5 text-left text-sm font-medium transition-all outline-none hover:underline focus-visible:border-ring focus-visible:ring-3 focus-visible:ring-ring/50 focus-visible:after:border-ring aria-disabled:pointer-events-none aria-disabled:opacity-50',
        '**:data-[slot=accordion-trigger-icon]:ml-auto **:data-[slot=accordion-trigger-icon]:size-4 **:data-[slot=accordion-trigger-icon]:text-muted-foreground',
    ]);

    $presetAttributes = [
        'type' => 'button',
        'data-slot' => 'accordion-trigger',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div class="flex"
    data-slot="accordion-header">
    <button
        x-on:click="$store.accordion.toggle(accordionId, @js($value))"
        {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}
        @disabled($disabled)
        :id="`${accordionId}-trigger-@js($value)`"
        x-bind:aria-controls="`${accordionId}-panel-@js($value)`"
        x-bind:aria-expanded="$store.accordion.isOpen(accordionId, @js($value)) || (@js($initiallyOpen) && !Object.hasOwn($store.accordion.groups[accordionId]?.open ?? {}, @js($value)))"
        x-bind:aria-disabled="@js((bool) $disabled) ? 'true' : null"
        x-bind:tabindex="$store.accordion.activeItem(accordionId) === @js($value) ? 0 : -1">
        {{ $slot }}
        <x-lucide-chevron-down
            data-slot="accordion-trigger-icon"
            class="pointer-events-none shrink-0 group-aria-expanded/accordion-trigger:hidden"
            aria-hidden="true" />
        <x-lucide-chevron-up
            data-slot="accordion-trigger-icon"
            class="pointer-events-none hidden shrink-0 group-aria-expanded/accordion-trigger:inline"
            aria-hidden="true" />
    </button>
</div>
