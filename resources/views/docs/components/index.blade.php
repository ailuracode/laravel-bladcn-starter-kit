<x-layouts::docs :title="__('Components')">
    <x-slot name="breadcrumb">
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.link href="{{ route('docs.index') }}" wire:navigate>{{ __('Docs') }}</x-ui.breadcrumb.link>
        </x-ui.breadcrumb.item>
        <x-ui.breadcrumb.separator />
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.page>{{ __('Components') }}</x-ui.breadcrumb.page>
        </x-ui.breadcrumb.item>
    </x-slot>

    <div class="space-y-8" x-data="{ query: '' }">
        <div class="space-y-4">
            <x-ui.typography.h1 class="text-4xl font-bold tracking-tight">{{ __('Components') }}</x-ui.typography.h1>
            <x-ui.typography.lead>
                {{ __('Here you can find all the components available in the library.') }}
            </x-ui.typography.lead>
            <div class="relative max-w-md">
                <x-ui.icon name="search" class="absolute top-2.5 left-2.5 size-4 text-muted-foreground" />
                <x-ui.input class="ps-8" placeholder="{{ __('Search components…') }}" x-model="query" />
            </div>
        </div>

        <x-ui.separator />

        @foreach ($groups as $group => $slugs)
            <x-docs.section :label="__($group)">
                <div class="grid gap-2 sm:grid-cols-2">
                    @foreach ($slugs as $slug)
                        @php($meta = $components[$slug])
                        <a
                            href="{{ route('docs.components.show', $slug) }}"
                            class="rounded-lg border p-4 transition-colors hover:bg-muted/50"
                            x-show="!query.trim() || @js(strtolower($meta['title'])).includes(query.trim().toLowerCase()) || @js($slug).includes(query.trim().toLowerCase())"
                            wire:navigate
                        >
                            <p class="font-medium">{{ $meta['title'] }}</p>
                            <p class="mt-1 line-clamp-2 text-sm text-muted-foreground">{{ $meta['description'] }}</p>
                        </a>
                    @endforeach
                </div>
            </x-docs.section>
        @endforeach
    </div>
</x-layouts::docs>
