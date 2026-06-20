@blaze(fold: true)

@props([
    'class' => null,
])

<button
    type="button"
    data-sidebar="rail"
    aria-label="{{ __('Toggle Sidebar') }}"
    title="{{ __('Toggle Sidebar') }}"
    tabindex="-1"
    x-on:click="$store.bladcnSidebar.toggle()"
    @class([
        'absolute inset-y-0 z-20 hidden w-4 -translate-x-1/2 transition-all ease-linear after:absolute after:inset-y-0 after:start-1/2 after:w-[2px] hover:after:bg-sidebar-border group-data-[side=left]:-end-4 group-data-[side=right]:start-0 sm:flex',
        'cursor-pointer',
        $class,
    ])
></button>
