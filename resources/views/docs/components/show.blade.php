@php
    $slug = $doc['slug'];
@endphp

<x-layouts::docs :title="$doc['title']">
    <x-slot name="breadcrumb">
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.link href="{{ route('docs.index') }}" wire:navigate>{{ __('Docs') }}</x-ui.breadcrumb.link>
        </x-ui.breadcrumb.item>
        <x-ui.breadcrumb.separator />
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.link href="{{ route('docs.components.index') }}" wire:navigate>{{ __('Components') }}</x-ui.breadcrumb.link>
        </x-ui.breadcrumb.item>
        <x-ui.breadcrumb.separator />
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.page>{{ $doc['title'] }}</x-ui.breadcrumb.page>
        </x-ui.breadcrumb.item>
    </x-slot>

    <div class="space-y-8">
        <div class="space-y-4">
            <div class="flex flex-wrap items-center gap-2">
                <x-ui.typography.h1 class="text-4xl font-bold tracking-tight">{{ $doc['title'] }}</x-ui.typography.h1>
                <x-ui.badge variant="secondary">{{ $doc['group'] }}</x-ui.badge>
            </div>
            <x-ui.typography.lead>{{ $doc['description'] }}</x-ui.typography.lead>
            @if ($doc['shadcn_url'])
                <a href="{{ $doc['shadcn_url'] }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-primary hover:underline">
                    {{ __('View on shadcn/ui') }}
                    <x-ui.icon name="external-link" class="size-3.5" />
                </a>
            @endif
        </div>

        <x-ui.separator />

        <x-docs.section :label="__('Preview')">
            <x-docs.preview>
                @includeFirst(["docs.demos.{$slug}", 'docs.demos._placeholder'])
            </x-docs.preview>
        </x-docs.section>

        <x-docs.section :label="__('Installation')">
            <x-ui.typography.p class="mb-3">{{ __('Run the following command to add this component to your project:') }}</x-ui.typography.p>
            <x-docs.install-block :command="$doc['install_command']" />
        </x-docs.section>

        <x-docs.section :label="__('Usage')">
            <x-docs.code-block
                filename="resources/views/example.blade.php"
                language="blade"
                :code="$doc['usage']"
            />
        </x-docs.section>

        <x-docs.section :label="__('API Reference')">
            <x-docs.api-table :props="$doc['props']" />
        </x-docs.section>
    </div>
</x-layouts::docs>
