@props(['label' => null])

<div {{ $attributes->merge(['class' => 'space-y-3']) }}>
    @if ($label)
        <x-ui.typography.h3 class="text-lg font-semibold tracking-tight">{{ $label }}</x-ui.typography.h3>
    @endif
    {{ $slot }}
</div>
