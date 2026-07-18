@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

<x-ui.input {{ $attributes->class(['h-8 w-full bg-background shadow-none', $class]) }}
    data-sidebar="input"
    data-slot="sidebar-input"
    @if (filled($style)) style="{{ $style }}" @endif />
