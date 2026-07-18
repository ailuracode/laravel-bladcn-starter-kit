@blaze(fold: true)

@aware(['orientation' => 'horizontal'])

@props([
    'style' => null,
    'class' => null,
])

@php
    $userClass = trim((string) ($class ?? ''));

    $viewportClass = implode(
        ' ',
        array_filter([
            'overflow-hidden outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 focus-visible:outline-1',
            preg_match('/-mt-(\[[^\]]+\]|\d+)/', $userClass, $marginMatch)
                ? 'pt-' . $marginMatch[1]
                : null,
            preg_match('/-ml-(\[[^\]]+\]|\d+)/', $userClass, $marginMatch)
                ? 'pl-' . $marginMatch[1]
                : null,
        ]),
    );

    $trackClass = implode(
        ' ',
        array_filter([
            'flex',
            $orientation === 'vertical' ? 'flex-col' : null,
            $orientation === 'horizontal' && !preg_match('/-ml-/', $userClass)
                ? '-ml-4'
                : null,
            $orientation === 'vertical' && !preg_match('/-mt-/', $userClass)
                ? '-mt-4'
                : null,
        ]),
    );
@endphp

<div @class($viewportClass)
    data-slot="carousel-content"
    x-ref="viewport">
    <div @class([$trackClass, $userClass])
        x-ref="container">
        {{ $slot }}
    </div>
</div>
