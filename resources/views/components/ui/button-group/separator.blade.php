@blaze(fold: true)

@props([
    'class' => null,
    'orientation' => 'vertical',
])

@php
    $presetClass =
        'relative self-stretch bg-input data-[orientation=horizontal]:mx-px data-[orientation=horizontal]:w-auto data-[orientation=vertical]:my-px data-[orientation=vertical]:h-auto';
@endphp

<x-ui.separator :orientation="$orientation"
    {{ $attributes->merge(['data-slot' => 'button-group-separator'])->class([$presetClass, $class]) }} />
