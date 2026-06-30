@props([
    'showEmail' => false,
])

<x-ui.avatar class="size-8 overflow-hidden rounded-lg">
    <x-ui.avatar.fallback class="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
        {{ auth()->user()->initials() }}
    </x-ui.avatar.fallback>
</x-ui.avatar>
<div class="grid min-w-0 flex-1 text-start text-sm leading-tight group-data-[collapsible=icon]:hidden">
    <span class="truncate font-medium">{{ auth()->user()->name }}</span>
    @if ($showEmail)
        <span class="truncate text-xs text-muted-foreground">{{ auth()->user()->email }}</span>
    @endif
</div>
