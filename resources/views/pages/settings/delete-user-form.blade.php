<?php

use Livewire\Component;

new class extends Component {}; ?>

<section class="mt-10 space-y-6">
    <div>
        <x-ui.typography.h3 class="text-base font-semibold">{{ __('Delete account') }}</x-ui.typography.h3>
        <x-ui.typography.muted>{{ __('Delete your account and all of its resources') }}</x-ui.typography.muted>
    </div>

    <livewire:pages::settings.delete-user-modal />
</section>
