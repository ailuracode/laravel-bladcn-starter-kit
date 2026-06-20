@php
    use App\Support\BladcnDocs;

    $groups = BladcnDocs::groups();
    $currentSlug = request()->route('slug');
@endphp

<aside
    class="hidden w-64 shrink-0 border-e bg-muted/30 lg:block"
    x-data="{
        query: '',
        matches(label) {
            if (! this.query.trim()) return true;
            return label.toLowerCase().includes(this.query.trim().toLowerCase());
        }
    }"
>
    <div class="sticky top-0 flex h-screen flex-col">
        <div class="border-b p-4">
            <a href="{{ route('docs.index') }}" class="flex items-center gap-2 font-semibold" wire:navigate>
                <x-app-logo-icon class="size-5 fill-current" />
                <span>bladcn</span>
            </a>
            <p class="mt-1 text-xs text-muted-foreground">{{ __('Component documentation') }}</p>
            <div class="relative mt-4">
                <x-ui.icon name="search" class="absolute top-2.5 left-2.5 size-4 text-muted-foreground" />
                <x-ui.input
                    class="ps-8"
                    placeholder="{{ __('Search components…') }}"
                    x-model="query"
                />
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 text-sm">
            <div class="space-y-6">
                <div>
                    <p class="mb-2 font-medium text-muted-foreground">{{ __('Getting Started') }}</p>
                    <div class="space-y-1">
                        <a
                            href="{{ route('docs.index') }}"
                            @class([
                                'block rounded-md px-2 py-1.5 transition-colors hover:bg-accent hover:text-accent-foreground',
                                'bg-accent text-accent-foreground' => request()->routeIs('docs.index'),
                            ])
                            wire:navigate
                        >{{ __('Introduction') }}</a>
                        <a
                            href="{{ route('docs.installation') }}"
                            @class([
                                'block rounded-md px-2 py-1.5 transition-colors hover:bg-accent hover:text-accent-foreground',
                                'bg-accent text-accent-foreground' => request()->routeIs('docs.installation'),
                            ])
                            wire:navigate
                        >{{ __('Installation') }}</a>
                    </div>
                </div>

                @foreach ($groups as $group => $slugs)
                    <div>
                        <p class="mb-2 font-medium text-muted-foreground">{{ __($group) }}</p>
                        <div class="space-y-1">
                            @foreach ($slugs as $slug)
                                @php($label = BladcnDocs::make($slug, $group)['title'])
                                <a
                                    href="{{ route('docs.components.show', $slug) }}"
                                    x-show="matches(@js($label))"
                                    @class([
                                        'block rounded-md px-2 py-1.5 transition-colors hover:bg-accent hover:text-accent-foreground',
                                        'bg-accent text-accent-foreground' => $currentSlug === $slug,
                                    ])
                                    wire:navigate
                                >{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </nav>
    </div>
</aside>
