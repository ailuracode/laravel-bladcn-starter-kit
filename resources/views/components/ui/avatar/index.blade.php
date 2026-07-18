@blaze(fold: false)
{{-- @see https://ui.shadcn.com/docs/components/avatar --}}

@props([
    'size' => 'default',
    'style' => null,
    'class' => null,
])

@php
    $presetClass =
        'group/avatar relative flex size-8 shrink-0 rounded-full select-none data-[size=lg]:size-10 data-[size=sm]:size-6';

    $presetAttributes = [
        'data-slot' => 'avatar',
        'data-size' => $size,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>

{{-- FOUC: `hidden` + bladcnAvatarApplyState below — no dedicated FOUC CSS file. --}}
@pushOnce('bladcn-scripts')
    <script>
        window.bladcnAvatarApplyState = window.bladcnAvatarApplyState ?? ((img) => {
            if (!img || img.getAttribute('data-slot') !== 'avatar-image') {
                return;
            }

            const fallback = img.closest('[data-slot="avatar"]')?.querySelector('[data-slot="avatar-fallback"]');

            if (img.dataset.state === 'loaded') {
                img.hidden = false;
                if (fallback) {
                    fallback.hidden = true;
                }

                return;
            }

            img.hidden = true;
            if (fallback) {
                fallback.hidden = false;
            }
        });

        window.bladcnAvatarSyncImage = window.bladcnAvatarSyncImage ?? ((img) => {
            if (!img || img.getAttribute('data-slot') !== 'avatar-image') {
                return;
            }

            if (img.dataset.state === 'loaded' || img.dataset.state === 'error') {
                window.bladcnAvatarApplyState(img);

                return;
            }

            if (img.complete && img.naturalWidth > 0) {
                img.dataset.state = 'loaded';
            } else if (img.complete) {
                img.dataset.state = 'error';
            }

            window.bladcnAvatarApplyState(img);
        });

        window.bladcnAvatarBindImage = window.bladcnAvatarBindImage ?? ((img) => {
            if (!img || img.getAttribute('data-slot') !== 'avatar-image') {
                return;
            }

            if (img.dataset.avatarBound !== 'true') {
                img.dataset.avatarBound = 'true';

                img.addEventListener('load', () => {
                    img.dataset.state = 'loaded';
                    window.bladcnAvatarApplyState(img);
                }, { once: true });

                img.addEventListener('error', () => {
                    img.dataset.state = 'error';
                    window.bladcnAvatarApplyState(img);
                }, { once: true });
            }

            window.bladcnAvatarSyncImage(img);
        });

        window.bladcnAvatarSyncAll = window.bladcnAvatarSyncAll ?? ((root = document) => {
            root.querySelectorAll?.('[data-slot="avatar-image"]')?.forEach((img) => {
                window.bladcnAvatarBindImage(img);
            });
        });

        window.bladcnAvatarSyncAll();

        document.addEventListener('DOMContentLoaded', () => window.bladcnAvatarSyncAll());
        document.addEventListener('livewire:navigated', () => window.bladcnAvatarSyncAll());
    </script>
@endPushOnce
