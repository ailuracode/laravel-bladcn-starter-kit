@blaze(fold: true)

@props([
    'asChild' => false,
    'isActive' => false,
    'href' => '#',
    'size' => 'default',
    'style' => null,
    'class' => null,
])

@php
    $sizeClass = match ($size) {
        'sm' => 'h-7 text-xs group-data-[collapsible=icon]/sidebar-wrapper:p-2!',
        'lg' => 'h-12 text-sm group-data-[collapsible=icon]/sidebar-wrapper:p-0!',
        default => 'h-8 text-sm group-data-[collapsible=icon]/sidebar-wrapper:p-2!',
    };

    $presetClass = new \AiluraCode\Bladcn\Support\ClassResolver()->add(
        'peer/menu-button flex w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left text-sm outline-hidden ring-sidebar-ring transition-[width,height,padding] hover:bg-sidebar-accent hover:text-sidebar-accent-foreground focus-visible:ring-2 active:bg-sidebar-accent active:text-sidebar-accent-foreground disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 group-data-[collapsible=icon]/sidebar-wrapper:size-8! [&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0',
    )->add($sizeClass);

    if ($isActive) {
        $presetClass->add(
            'bg-sidebar-accent font-medium text-sidebar-accent-foreground',
        );
    }

    $presetAttributes = [
        'data-slot' => 'sidebar-menu-button',
        'data-sidebar' => 'menu-button',
        'data-size' => $size !== 'default' ? $size : null,
        'data-active' => $isActive ? '' : null,
        'href' => $href,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<x-ui.abstract :as-child="$asChild"
    {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}
    default-tag="a">
    {{ $slot }}
</x-ui.abstract>
