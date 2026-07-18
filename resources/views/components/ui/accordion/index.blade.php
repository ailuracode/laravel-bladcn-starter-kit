@blaze(fold: false)
{{-- @see https://ui.shadcn.com/docs/components/accordion --}}
{{-- @see https://github.com/ailuracode/alpinejs-toolkit/blob/master/packages/accordion/README.md --}}

@props([
    'id' => null,
    'type' => 'single',
    'defaultValue' => null,
    'transition' => true,
    'style' => null,
    'class' => null,
])

@php
    $accordionId = filled($id)
        ? $id
        : 'accordion-' . Illuminate\Support\Str::random(8);
    $transition = filter_var($transition, FILTER_VALIDATE_BOOLEAN);

    $defaultOpen = match (true) {
        is_array($defaultValue) => $defaultValue,
        filled($defaultValue) => [$defaultValue],
        default => [],
    };

    $registerDefaultOpen = match ($type) {
        'multiple' => count($defaultOpen) > 0 ? $defaultOpen : null,
        default => filled($defaultOpen[0] ?? null) ? $defaultOpen[0] : null,
    };

    $presetClass = 'flex w-full flex-col';

    $presetAttributes = [
        'id' => $accordionId,
        'data-slot' => 'accordion',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div x-on:keydown="$store.accordion.handleKeydown(accordionId, $event)"
    {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}
    x-data="bladcnAccordion({
        accordionId: @js($accordionId),
        type: @js($type),
        defaultOpen: @js($registerDefaultOpen),
    })">
    {{ $slot }}
</div>

@pushOnce('bladcn-scripts')
    <script>
        bladcnOnAlpine((Alpine) => {
            Alpine.data('bladcnAccordion', (config = {}) => ({
                accordionId: config.accordionId,
                type: config.type ?? 'single',
                defaultOpen: config.defaultOpen ?? null,

                init() {
                    const options = {
                        mode: this.type,
                    };

                    if (this.defaultOpen !== null) {
                        options.defaultOpen = this.defaultOpen;
                    }

                    this.$store.accordion.register(this.accordionId, options);
                },
            }));
        });
    </script>
@endPushOnce
