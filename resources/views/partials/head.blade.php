<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

{{-- Theme: sync FOUC guard only — @ailuracode/alpine-theme owns storage, system, and $store.theme. --}}
<script>
    (function () {
        const stored = localStorage.getItem('theme');
        const mode = stored === 'light' || stored === 'dark' || stored === 'system' ? stored : 'system';
        const resolved = mode === 'system'
            ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
            : mode;

        document.documentElement.classList.toggle('dark', resolved === 'dark');
        document.documentElement.style.colorScheme = resolved;
    })();
</script>

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

@livewireStyles

@livewireScriptConfig

@vite(['resources/css/app.css', 'resources/js/app.ts'])
