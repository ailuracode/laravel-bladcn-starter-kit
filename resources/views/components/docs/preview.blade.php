@props(['title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border bg-background']) }}>
    @if ($title || $description)
        <div class="border-b px-4 py-3">
            @if ($title)
                <p class="text-sm font-medium">{{ $title }}</p>
            @endif
            @if ($description)
                <p class="text-xs text-muted-foreground">{{ $description }}</p>
            @endif
        </div>
    @endif
    <div class="p-6 w-full">
        {{ $slot }}
    </div>
</div>
