@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <x-ui.typography.h1 class="text-xl font-semibold">{{ $title }}</x-ui.typography.h1>
    <x-ui.typography.muted class="mt-1">{{ $description }}</x-ui.typography.muted>
</div>
