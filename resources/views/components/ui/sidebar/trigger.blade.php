@blaze(fold: true)

@props([
    'asChild' => false,
    'class' => null,
])

<x-ui.button {{ $attributes->class(['size-7', $class]) }}
    data-sidebar="trigger"
    data-slot="sidebar-trigger"
    size="icon-sm"
    type="button"
    variant="ghost"
    x-on:click="toggleMobile()">
    <x-ui.icon aria-hidden="true"
        class="size-4"
        name="panel-left" />
    <span class="sr-only">Toggle Sidebar</span>
</x-ui.button>
