@props([
    'sidebar' => false,
])

@if ($sidebar)
    <span class="flex aspect-square size-8 shrink-0 items-center justify-center rounded-md bg-violet-600 text-white">
        <x-app-logo-icon class="size-5 fill-current text-white" />
    </span>
    <span class="ms-1 grid min-w-0 flex-1 text-start text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">{{ __('Laravel Bladcn Starter Kit') }}</span>
    </span>
@else
    <a {{ $attributes->merge(['class' => 'flex items-center gap-2 font-medium']) }} wire:navigate>
        <span class="flex size-9 items-center justify-center rounded-md bg-violet-600 text-white">
            <x-app-logo-icon class="size-5 fill-current text-white" />
        </span>
        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
    </a>
@endif
