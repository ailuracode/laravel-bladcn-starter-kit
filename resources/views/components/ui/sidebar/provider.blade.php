@blaze(fold: false)

@props([
    'style' => null,
    'class' => null,
])

@php
    $presetClass = (new \AiluraCode\Bladcn\Support\ClassResolver())->add(
        'group/sidebar-wrapper has-data-[variant=inset]:bg-sidebar flex min-h-svh w-full overflow-x-hidden',
    );

    $presetAttributes = [
        'data-slot' => 'sidebar-wrapper',
    ];

    $mergedStyle = trim(
        collect(['--sidebar-width: 16rem; --sidebar-width-icon: 3rem;', $style])
            ->filter()
            ->implode(' '),
    );
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}
    @if ($mergedStyle !== '') style="{{ $mergedStyle }}" @endif
    x-data="bladcnSidebarProvider()">
    {{ $slot }}
</div>

{{-- Apply compact sidebar attributes before Alpine so the gap spacer matches main width. --}}
<script>
    (function() {
        const key = 'sidebar-expanded';

        function applyCompactSidebarDom() {
            try {
                if (localStorage.getItem(key) !== 'false') {
                    return;
                }
            } catch (e) {
                return;
            }

            if (!window.matchMedia('(min-width: 768px)').matches) {
                return;
            }

            const sidebar = document.querySelector(
                '[data-slot="sidebar-wrapper"] [data-slot="sidebar"]');

            if (!sidebar) {
                return;
            }

            sidebar.setAttribute('data-state', 'collapsed');
            sidebar.setAttribute('data-collapsible', 'icon');
        }

        applyCompactSidebarDom();
        document.addEventListener('livewire:navigated',
            applyCompactSidebarDom);
    })();
</script>
