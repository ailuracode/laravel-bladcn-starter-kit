@blaze(fold: true)

@aware(['open' => false, 'transition' => true])

@props([
    'size' => 'default',
    'style' => null,
    'class' => null,
])

@php
    $transition = filter_var($transition, FILTER_VALIDATE_BOOLEAN);
    $isOpen = filter_var($open, FILTER_VALIDATE_BOOLEAN);

    $overlayAlpineAttributes = [
        'x-bind:data-state' =>
            '$store.dialog.isOpen(id) ? \'open\' : \'closed\'',
        'x-show' => '$store.dialog.isOpen(id)',
    ];

    $contentAlpineAttributes = [
        'x-bind' => '$store.dialog.dialogProps(id)',
        'x-bind:data-state' =>
            '$store.dialog.isOpen(id) ? \'open\' : \'closed\'',
        'x-init' => '$store.dialog.bindContainer(id, $el)',
        'x-show' => '$store.dialog.isOpen(id)',
    ];

    $overlayClass =
        'fixed inset-0 z-50 bg-black/50 data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:animate-in data-[state=open]:fade-in-0';

    $contentClass =
        'group/alert-dialog-content fixed top-[50%] left-[50%] z-50 grid w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] gap-4 rounded-lg border bg-background p-6 shadow-lg duration-200 data-[size=sm]:max-w-xs data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95 data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95 data-[size=default]:sm:max-w-lg';

    $presetAttributes = [
        'data-slot' => 'alert-dialog-content',
        'data-size' => $size,
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<template x-teleport="body">
    <div data-slot="alert-dialog-portal">
        <div {{ (new \Illuminate\View\ComponentAttributeBag(
            $overlayAlpineAttributes,
        ))->merge([
            'data-slot' => 'alert-dialog-overlay',
            'data-state' => $isOpen ? 'open' : 'closed',
            ...$isOpen ? [] : ['x-cloak' => true],
        ]) }}
            @if ($transition) x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @endif
            @class($overlayClass)></div>
        <div {{ $attributes->merge($presetAttributes)->class([$contentClass, $class])->merge($contentAlpineAttributes) }}
            @unless ($isOpen) x-cloak @endunless
            @if ($transition) x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" @endif
            data-state="{{ $isOpen ? 'open' : 'closed' }}"
            role="alertdialog"
            x-on:click.stop>
            {{ $slot }}
        </div>
    </div>
</template>
