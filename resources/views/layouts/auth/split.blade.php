<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-background text-foreground antialiased">
        <div class="relative grid min-h-svh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="relative hidden h-full flex-col bg-muted p-10 text-primary-foreground lg:flex">
                <div class="absolute inset-0 bg-zinc-900"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    <x-app-logo-icon class="me-2 size-7 fill-current" />
                    {{ config('app.name', 'Laravel') }}
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <x-ui.typography.h2 class="text-lg text-white">&ldquo;{{ trim($message) }}&rdquo;</x-ui.typography.h2>
                        <footer class="text-white/80">{{ trim($author) }}</footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <x-app-logo href="{{ route('home') }}" class="lg:hidden mx-auto" />
                    {{ $slot }}
                </div>
            </div>
        </div>

        <x-ui.sonner />

        @include('partials.bladcn-foot')
    </body>
</html>
