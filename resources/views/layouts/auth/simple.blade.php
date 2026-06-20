<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-background text-foreground antialiased">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-6">
                <x-app-logo href="{{ route('home') }}" class="mx-auto" />
                {{ $slot }}
            </div>
        </div>

        <x-ui.sonner />

        @include('partials.bladcn-foot')
    </body>
</html>
