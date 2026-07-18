<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@include('partials.bladcn-document-hooks')

<title>
    {{ filled($title ?? null) ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

{{-- Typography FOUC guard — apply Instrument Sans before app.css (Tailwind base) loads. --}}
<style>
    html {
        font-family: var(--font-instrument-sans, ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji");
    }
</style>

@livewireStyles
@livewireScriptConfig

@vite(['resources/css/app.css', 'resources/js/app.js'])