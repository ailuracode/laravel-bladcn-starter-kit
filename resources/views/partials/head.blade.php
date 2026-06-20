<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

{{-- Apply theme before CSS paint to prevent light→dark flash (FOUC). --}}
<script>
    (function () {
        const key = 'theme';

        function applyTheme() {
            const appearance = localStorage.getItem(key) || 'dark';
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const dark = appearance === 'dark' || (appearance === 'system' && prefersDark);

            document.documentElement.classList.toggle('dark', dark);
            document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
        }

        applyTheme();

        document.addEventListener('livewire:navigating', (event) => {
            event.detail.onSwap?.(() => applyTheme());
        });

        document.addEventListener('livewire:navigated', () => applyTheme());
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

@vite(['resources/css/app.css', 'resources/js/app.js'])
