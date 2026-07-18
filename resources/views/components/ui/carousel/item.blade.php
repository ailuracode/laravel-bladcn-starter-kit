@blaze(fold: true)

@aware(['orientation' => 'horizontal'])

@props([
    'style' => null,
    'class' => null,
])

@php
    $userClass = trim((string) ($class ?? ''));

    $presetClass = implode(
        ' ',
        array_filter([
            'min-w-0 box-border shrink-0 grow-0',
            $orientation === 'vertical' ? 'min-h-0 w-full' : null,
            !preg_match('/\bbasis-/', $userClass) ? 'basis-full' : null,
            !preg_match(
                '/[!]?p[trblxy]?-\d|[!]?px-\d|[!]?py-\d|[!]?p-\d/',
                $userClass,
            )
                ? ($orientation === 'horizontal'
                    ? 'pl-4'
                    : 'pt-4')
                : null,
        ]),
    );

    $presetAttributes = [
        'role' => 'group',
        'aria-roledescription' => 'slide',
        'data-slot' => 'carousel-item',
    ];

    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>
