@php
    $sidebarNavItems = [
        ['title' => __('Profile'), 'url' => route('profile.edit'), 'route' => 'profile.edit'],
        ['title' => __('Security'), 'url' => route('security.edit'), 'route' => 'security.edit'],
        ['title' => __('Appearance'), 'url' => route('appearance.edit'), 'route' => 'appearance.edit'],
    ];
@endphp

<div class="flex flex-col lg:flex-row lg:space-x-12">
    <aside class="w-full max-w-xl lg:w-48">
        <nav class="flex flex-col space-y-1 space-x-0" aria-label="{{ __('Settings') }}">
            @foreach ($sidebarNavItems as $item)
                <x-ui.button
                    variant="ghost"
                    size="sm"
                    asChild
                    :class="'w-full justify-start'.(request()->routeIs($item['route']) ? ' bg-muted' : '')"
                >
                    <a href="{{ $item['url'] }}" wire:navigate>{{ $item['title'] }}</a>
                </x-ui.button>
            @endforeach
        </nav>
    </aside>

    <x-ui.separator class="my-6 lg:hidden" />

    <div class="flex-1 md:max-w-2xl">
        <section class="max-w-xl space-y-12">
            <div>
                <x-ui.typography.h2 class="text-lg font-semibold">{{ $heading ?? '' }}</x-ui.typography.h2>
                @if (filled($subheading ?? null))
                    <x-ui.typography.muted class="mt-1">{{ $subheading }}</x-ui.typography.muted>
                @endif
            </div>

            {{ $slot }}
        </section>
    </div>
</div>
