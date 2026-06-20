@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <title>{{ $title ? "{$title} - " : '' }}{{ __('Docs') }} | {{ config('app.name') }}</title>
    </head>
    <body class="min-h-screen bg-background text-foreground antialiased" x-data="{ mobileNav: false }">
        <div class="flex min-h-screen">
            <div class="lg:hidden">
                <div
                    class="fixed inset-0 z-40 bg-black/50"
                    x-show="mobileNav"
                    x-transition
                    x-on:click="mobileNav = false"
                    x-cloak
                ></div>
                <div
                    class="fixed inset-y-0 left-0 z-50 w-64 bg-background shadow-lg lg:hidden"
                    x-show="mobileNav"
                    x-transition
                    x-cloak
                >
                    <x-docs.sidebar />
                </div>
            </div>

            <div class="hidden lg:block">
                <x-docs.sidebar />
            </div>

            <div class="flex min-w-0 flex-1 flex-col">
                <header class="sticky top-0 z-30 flex h-14 items-center gap-4 border-b bg-background/95 px-4 backdrop-blur supports-[backdrop-filter]:bg-background/60 lg:px-8">
                    <x-ui.button type="button" variant="outline" size="icon-sm" class="lg:hidden" x-on:click="mobileNav = !mobileNav">
                        <x-ui.icon name="menu" />
                    </x-ui.button>
                    <x-ui.breadcrumb class="hidden min-w-0 sm:flex">
                        <x-ui.breadcrumb.list>
                            {{ $breadcrumb ?? '' }}
                        </x-ui.breadcrumb.list>
                    </x-ui.breadcrumb>
                    <div class="ms-auto flex items-center gap-2">
                        <x-ui.button variant="ghost" size="sm" asChild>
                            <a href="{{ route('dashboard') }}" wire:navigate>{{ __('Back to app') }}</a>
                        </x-ui.button>
                    </div>
                </header>

                <main class="flex-1">
                    <div class="mx-auto w-full max-w-3xl px-4 py-8 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <x-ui.sonner />

        @include('partials.bladcn-foot')
    </body>
</html>
