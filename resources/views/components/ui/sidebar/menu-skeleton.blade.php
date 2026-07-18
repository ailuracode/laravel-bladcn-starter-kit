@blaze(fold: true)

@props([
    'showIcon' => false,
    'style' => null,
    'class' => null,
])

@php
    $presetClass = 'flex h-8 items-center gap-2 rounded-md px-2';

    $presetAttributes = [
        'data-slot' => 'sidebar-menu-skeleton',
        'data-sidebar' => 'menu-skeleton',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    @if ($showIcon)
        <x-ui.skeleton class="size-4 rounded-md" data-sidebar="menu-skeleton-icon" />
    @endif
    <x-ui.skeleton class="h-4 max-w-(--skeleton-width) flex-1"
        data-sidebar="menu-skeleton-text"
        style="--skeleton-width: {{ random_int(50, 90) }}%;" />
</div>
