<x-layouts::docs :title="__('Introduction')">
    <x-slot name="breadcrumb">
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.link href="{{ route('docs.index') }}" wire:navigate>{{ __('Docs') }}</x-ui.breadcrumb.link>
        </x-ui.breadcrumb.item>
        <x-ui.breadcrumb.separator />
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.page>{{ __('Introduction') }}</x-ui.breadcrumb.page>
        </x-ui.breadcrumb.item>
    </x-slot>

    <div class="space-y-8">
        <div class="space-y-4">
            <x-ui.typography.h1 class="scroll-m-20 text-4xl font-bold tracking-tight">
                {{ __('Introduction') }}
            </x-ui.typography.h1>
            <x-ui.typography.lead>
                {{ __('Beautifully designed Blade components that you can copy, customize, and build on. Styled with Tailwind CSS and powered by Alpine.js.') }}
            </x-ui.typography.lead>
        </div>

        <x-ui.separator />

        <x-docs.section :label="__('About')">
            <x-ui.typography.p>
                {{ __('bladcn is a port of the shadcn/ui design system for Laravel. Components live in your codebase as Blade files — not a black-box package — so you own and control every line.') }}
            </x-ui.typography.p>
            <x-ui.typography.p class="mt-4">
                {{ __('This starter kit ships with :count components pre-installed, a Livewire app shell, authentication, and this documentation site.', ['count' => $componentCount]) }}
            </x-ui.typography.p>
        </x-docs.section>

        <x-docs.section :label="__('Principles')">
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ([
                    ['title' => __('Open code'), 'body' => __('Components are copied into resources/views/components/ui. Modify anything.')],
                    ['title' => __('Composable'), 'body' => __('Every component uses the same patterns: slots, variants, and Alpine data.')],
                    ['title' => __('Beautiful defaults'), 'body' => __('Carefully chosen styles so your app looks great out of the box.')],
                    ['title' => __('shadcn compatible'), 'body' => __('APIs mirror shadcn/ui so React docs translate to Blade.')],
                ] as $item)
                    <x-ui.card>
                        <x-ui.card.header>
                            <x-ui.card.title>{{ $item['title'] }}</x-ui.card.title>
                            <x-ui.card.description>{{ $item['body'] }}</x-ui.card.description>
                        </x-ui.card.header>
                    </x-ui.card>
                @endforeach
            </div>
        </x-docs.section>

        <x-docs.section :label="__('Quick start')">
            <x-docs.install-block command="php artisan bladcn:init" />
            <div class="mt-4 flex flex-wrap gap-2">
                <x-ui.button asChild>
                    <a href="{{ route('docs.installation') }}" wire:navigate>{{ __('Read installation guide') }}</a>
                </x-ui.button>
                <x-ui.button variant="outline" asChild>
                    <a href="{{ route('docs.components.index') }}" wire:navigate>{{ __('Browse components') }}</a>
                </x-ui.button>
            </div>
        </x-docs.section>
    </div>
</x-layouts::docs>
