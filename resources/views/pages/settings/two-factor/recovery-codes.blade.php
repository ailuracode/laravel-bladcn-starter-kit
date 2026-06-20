<?php

use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component {
    #[Locked]
    public array $recoveryCodes = [];

    public bool $showRecoveryCodes = false;

    public function mount(): void
    {
        $this->loadRecoveryCodes();
    }

    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generateNewRecoveryCodes): void
    {
        $generateNewRecoveryCodes(auth()->user());

        $this->loadRecoveryCodes();
    }

    private function loadRecoveryCodes(): void
    {
        $user = auth()->user();

        if ($user->hasEnabledTwoFactorAuthentication() && $user->two_factor_recovery_codes) {
            try {
                $this->recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            } catch (Exception) {
                $this->addError('recoveryCodes', 'Failed to load recovery codes');

                $this->recoveryCodes = [];
            }
        }
    }
}; ?>

<x-ui.card class="py-6" wire:cloak>
    <x-ui.card.header>
        <div class="flex items-center gap-2">
            <x-ui.icon name="lock" class="size-4" />
            <x-ui.card.title>{{ __('2FA recovery codes') }}</x-ui.card.title>
        </div>
        <x-ui.card.description>
            {{ __('Recovery codes let you regain access if you lose your 2FA device. Store them in a secure password manager.') }}
        </x-ui.card.description>
    </x-ui.card.header>

    <x-ui.card.content class="space-y-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            @if (! $showRecoveryCodes)
                <x-ui.button
                    wire:click="$set('showRecoveryCodes', true)"
                    aria-expanded="false"
                    aria-controls="recovery-codes-section"
                >
                    <x-ui.icon name="eye" />
                    {{ __('View recovery codes') }}
                </x-ui.button>
            @else
                <x-ui.button
                    wire:click="$set('showRecoveryCodes', false)"
                    aria-expanded="true"
                    aria-controls="recovery-codes-section"
                >
                    <x-ui.icon name="eye-off" />
                    {{ __('Hide recovery codes') }}
                </x-ui.button>

                @if (filled($recoveryCodes))
                    <x-ui.button variant="secondary" wire:click="regenerateRecoveryCodes">
                        <x-ui.icon name="refresh-cw" />
                        {{ __('Regenerate codes') }}
                    </x-ui.button>
                @endif
            @endif
        </div>

        @if ($showRecoveryCodes)
        <div id="recovery-codes-section">
            <div class="space-y-3">
                @error('recoveryCodes')
                    <x-ui.alert variant="destructive">
                        <x-ui.icon name="circle-x" />
                        <x-ui.alert.title>{{ $message }}</x-ui.alert.title>
                    </x-ui.alert>
                @enderror

                @if (filled($recoveryCodes))
                    <div
                        class="grid gap-1 rounded-lg bg-muted p-4 font-mono text-sm"
                        role="list"
                        aria-label="{{ __('Recovery codes') }}"
                    >
                        @foreach ($recoveryCodes as $code)
                            <div role="listitem" class="select-text" wire:loading.class="animate-pulse opacity-50">
                                {{ $code }}
                            </div>
                        @endforeach
                    </div>
                    <x-ui.typography.muted class="text-xs">
                        {{ __('Each recovery code can be used once to access your account and will be removed after use. If you need more, click Regenerate codes above.') }}
                    </x-ui.typography.muted>
                @endif
            </div>
        </div>
        @endif
    </x-ui.card.content>
</x-ui.card>
