@blaze(fold: true)
{{-- @see https://ui.shadcn.com/docs/components/aspect-ratio --}}

@props([
    'ratio' => 1,
    'style' => null,
    'class' => null,
])

@php
    $aspectRatio = match (true) {
        is_string($ratio) && str_contains($ratio, '/') => (function (string $value): string {
            [$ratioWidth, $ratioHeight] = array_pad(explode('/', $value, 2), 2, '1');
            $ratioWidth = max(1, (float) $ratioWidth);
            $ratioHeight = max(1, (float) $ratioHeight);

            return "{$ratioWidth} / {$ratioHeight}";
        })($ratio),
        default => (string) $ratio,
    };

    $presetAttributes = [
        'data-slot' => 'aspect-ratio',
    ];

    $mergedStyle = trim(
        collect(["aspect-ratio: {$aspectRatio}", $style])
            ->filter()
            ->implode('; '),
    );

    if (filled($mergedStyle)) {
        $presetAttributes['style'] = $mergedStyle;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class($class) }}>
    {{ $slot }}
</div>
