@blaze(fold: true)

@props([
    'style' => null,
    'class' => null,
])

<x-ui.separator {{ $attributes->class(['mx-2 w-auto bg-sidebar-border', $class]) }}
    data-sidebar="separator"
    data-slot="sidebar-separator"
    @if (filled($style)) style="{{ $style }}" @endif />
