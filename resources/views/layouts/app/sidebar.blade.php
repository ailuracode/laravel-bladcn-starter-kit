<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-background text-foreground antialiased" x-data>
        <x-ui.sidebar.provider>
            <x-app-sidebar />

            <x-ui.sidebar.inset class="flex min-h-svh flex-col">
                <header class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/50 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4">
                    <div class="flex items-center gap-2">
                        <x-ui.sidebar.trigger class="-ms-1" />
                        @if (filled($title ?? null) || isset($breadcrumb))
                            <x-ui.breadcrumb>
                                <x-ui.breadcrumb.list>
                                    @isset($breadcrumb)
                                        {{ $breadcrumb }}
                                    @else
                                        @if ($title !== __('Dashboard'))
                                            <x-ui.breadcrumb.item class="hidden md:block">
                                                <x-ui.breadcrumb.link href="{{ route('dashboard') }}" wire:navigate>
                                                    {{ __('Dashboard') }}
                                                </x-ui.breadcrumb.link>
                                            </x-ui.breadcrumb.item>
                                            <x-ui.breadcrumb.separator class="hidden md:block" />
                                        @endif
                                        <x-ui.breadcrumb.item>
                                            <x-ui.breadcrumb.page>{{ $title }}</x-ui.breadcrumb.page>
                                        </x-ui.breadcrumb.item>
                                    @endisset
                                </x-ui.breadcrumb.list>
                            </x-ui.breadcrumb>
                        @endif
                    </div>
                </header>

                <div class="flex flex-1 flex-col">
                    {{ $slot }}
                </div>
            </x-ui.sidebar.inset>
        </x-ui.sidebar.provider>

        <x-ui.sonner />

        @include('partials.bladcn-foot')
    </body>
</html>
