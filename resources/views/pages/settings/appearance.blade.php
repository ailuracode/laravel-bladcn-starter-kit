<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Title('Appearance settings')]
    #[Layout('layouts::app', ['title' => 'Appearance settings'])]
    class extends Component {
    //
}; ?>

<section class="w-full px-4 py-6">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Appearance settings')" :subheading="__('Update the appearance settings for your account')">
        <div class="inline-flex gap-1 rounded-lg border p-1" x-data>
            @foreach ([
                'light' => ['icon' => 'sun', 'label' => __('Light')],
                'dark' => ['icon' => 'moon', 'label' => __('Dark')],
                'system' => ['icon' => 'monitor', 'label' => __('System')],
            ] as $value => $option)
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium transition-colors"
                    x-bind:class="$store.theme.is(@js($value))
                        ? 'bg-accent text-accent-foreground'
                        : 'text-muted-foreground hover:bg-muted hover:text-foreground'"
                    x-on:click="$store.theme.set(@js($value))"
                >
                    <x-ui.icon :name="$option['icon']" class="size-4" />
                    {{ $option['label'] }}
                </button>
            @endforeach
        </div>
    </x-pages::settings.layout>
</section>
