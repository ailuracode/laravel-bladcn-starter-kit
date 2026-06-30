<x-layouts::docs :title="__('Installation')">
    <x-slot name="breadcrumb">
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.link href="{{ route('docs.index') }}" wire:navigate>{{ __('Docs') }}</x-ui.breadcrumb.link>
        </x-ui.breadcrumb.item>
        <x-ui.breadcrumb.separator />
        <x-ui.breadcrumb.item>
            <x-ui.breadcrumb.page>{{ __('Installation') }}</x-ui.breadcrumb.page>
        </x-ui.breadcrumb.item>
    </x-slot>

    <div class="space-y-8">
        <div class="space-y-4">
            <x-ui.typography.h1 class="text-4xl font-bold tracking-tight">{{ __('Installation') }}</x-ui.typography.h1>
            <x-ui.typography.lead>
                {{ __('How to set up bladcn in a Laravel project and add components.') }}
            </x-ui.typography.lead>
        </div>

        <x-ui.separator />

        <x-docs.section :label="__('Prerequisites')">
            <x-ui.typography.list>
                <li>PHP 8.3+</li>
                <li>Laravel 12+</li>
                <li>Node.js 18+</li>
                <li>Tailwind CSS 4</li>
            </x-ui.typography.list>
        </x-docs.section>

        <x-docs.section :label="__('Install the CLI')">
            <x-ui.typography.p>{{ __('Add bladcn as a dev dependency:') }}</x-ui.typography.p>
            <div class="mt-3">
                <x-docs.install-block command="composer require --dev ailuracode/bladcn" />
            </div>
        </x-docs.section>

        <x-docs.section :label="__('Initialize your project')">
            <x-ui.typography.p>{{ __('Run the init command to configure paths, theme CSS, and dark mode:') }}</x-ui.typography.p>
            <div class="mt-3">
                <x-docs.install-block command="php artisan bladcn:init --with-dark-mode" />
            </div>
            <x-ui.typography.muted class="mt-3">
                {{ __('This publishes theme files, registers the service provider, and updates your CSS entrypoint.') }}
            </x-ui.typography.muted>
        </x-docs.section>

        <x-docs.section :label="__('Add components')">
            <x-ui.typography.p>{{ __('Install individual components into resources/views/components/ui:') }}</x-ui.typography.p>
            <div class="mt-3 space-y-3">
                <x-docs.install-block command="php artisan bladcn:add button" />
                <x-docs.install-block command="php artisan bladcn:add dialog card input" />
            </div>
        </x-docs.section>

        <x-docs.section :label="__('Usage')">
            <x-ui.typography.p>{{ __('Use components with the x-ui namespace:') }}</x-ui.typography.p>
            <div class="mt-3">
                <x-docs.code-block
                    filename="example.blade.php"
                    language="blade"
                    code="<x-ui.button variant=&quot;outline&quot;>
    Click me
</x-ui.button>"
                />
            </div>
        </x-docs.section>

        <x-docs.section :label="__('Local registry (development)')">
            <x-ui.typography.p>
                {{ __('Components live in a separate registry repo. This starter kit uses a local clone at ../bladcn-components (sibling folder).') }}
            </x-ui.typography.p>
            <x-ui.typography.p class="mt-3">{{ __('Configure via .env or bladcn.json:') }}</x-ui.typography.p>
            <div class="mt-3">
                <x-docs.code-block
                    filename=".env"
                    language="ini"
                    code="BLADCN_REGISTRY=../bladcn-components"
                />
            </div>
            <x-ui.typography.p class="mt-4">{{ __('The CLI package can also be linked locally via Composer path repository:') }}</x-ui.typography.p>
            <div class="mt-3">
                <x-docs.code-block
                    filename="composer.json"
                    language="json"
                    code="&quot;repositories&quot;: [{ &quot;type&quot;: &quot;path&quot;, &quot;url&quot;: &quot;../bladcn-cli&quot; }]
&quot;require-dev&quot;: { &quot;ailuracode/bladcn&quot;: &quot;@dev&quot; }"
                />
            </div>
            <x-ui.typography.p class="mt-4">{{ __('After editing components in the registry, sync into this app:') }}</x-ui.typography.p>
            <div class="mt-3 space-y-3">
                <x-docs.install-block command="composer bladcn:sync" />
                <x-docs.install-block command="php artisan bladcn:add button --overwrite" />
            </div>
            <x-ui.typography.muted class="mt-3">
                {{ __('npm packages listed in dependencies.json are not installed automatically — add them to package.json and run pnpm install.') }}
            </x-ui.typography.muted>
        </x-docs.section>

        <x-docs.section :label="__('Theme')">
            <x-ui.typography.p>
                {{ __('Customize design tokens in resources/css/bladcn-theme.css. Toggle light/dark mode from Settings → Appearance or via $store.theme in Alpine.') }}
            </x-ui.typography.p>
        </x-docs.section>
    </div>
</x-layouts::docs>
