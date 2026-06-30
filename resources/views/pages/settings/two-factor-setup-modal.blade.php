<?php

use Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component {
    #[Locked]
    public bool $requiresConfirmation;

    #[Locked]
    public string $qrCodeSvg = '';

    #[Locked]
    public string $manualSetupKey = '';

    public bool $showModal = false;
    public bool $showVerificationStep = false;
    public bool $setupComplete = false;

    #[Validate('required|string|size:6', onUpdate: false)]
    public string $code = '';

    public function mount(bool $requiresConfirmation): void
    {
        $this->requiresConfirmation = $requiresConfirmation;
    }

    #[On('start-two-factor-setup')]
    public function startTwoFactorSetup(): void
    {
        $enableTwoFactorAuthentication = app(EnableTwoFactorAuthentication::class);
        $enableTwoFactorAuthentication(auth()->user());

        $this->showModal = true;
        $this->loadSetupData();
    }

    private function loadSetupData(): void
    {
        $user = auth()->user()?->fresh();

        try {
            if (! $user || ! $user->two_factor_secret) {
                throw new Exception('Two-factor setup secret is not available.');
            }

            $this->qrCodeSvg = $user->twoFactorQrCodeSvg();
            $this->manualSetupKey = decrypt($user->two_factor_secret);
        } catch (Exception) {
            $this->addError('setupData', 'Failed to fetch setup data.');

            $this->reset('qrCodeSvg', 'manualSetupKey');
        }
    }

    public function showVerificationIfNecessary(): void
    {
        if ($this->requiresConfirmation) {
            $this->showVerificationStep = true;
            $this->resetErrorBag();

            return;
        }

        $this->closeModal();
        $this->dispatch('two-factor-enabled');
    }

    public function confirmTwoFactor(ConfirmTwoFactorAuthentication $confirmTwoFactorAuthentication): void
    {
        $this->validate();

        $confirmTwoFactorAuthentication(auth()->user(), $this->code);

        $this->setupComplete = true;
        $this->closeModal();
        $this->dispatch('two-factor-enabled');
    }

    public function resetVerification(): void
    {
        $this->reset('code', 'showVerificationStep');
        $this->resetErrorBag();
    }

    public function closeModal(): void
    {
        $this->showModal = false;

        $this->reset(
            'code',
            'manualSetupKey',
            'qrCodeSvg',
            'showVerificationStep',
            'setupComplete',
        );

        $this->resetErrorBag();
    }

    #[Computed]
    public function modalConfig(): array
    {
        if ($this->setupComplete) {
            return [
                'title' => __('Two-factor authentication enabled'),
                'description' => __('Two-factor authentication is now enabled. Scan the QR code or enter the setup key in your authenticator app.'),
                'buttonText' => __('Close'),
            ];
        }

        if ($this->showVerificationStep) {
            return [
                'title' => __('Verify authentication code'),
                'description' => __('Enter the 6-digit code from your authenticator app.'),
                'buttonText' => __('Continue'),
            ];
        }

        return [
            'title' => __('Enable two-factor authentication'),
            'description' => __('To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app.'),
            'buttonText' => __('Continue'),
        ];
    }
}; ?>

<div>
    @if ($showModal)
    <x-ui.dialog open x-init="$watch(() => $store.dialog.isOpen(id), value => { if (! value) $wire.closeModal() })">
        <x-ui.dialog.content class="max-w-md">
            <x-ui.dialog.header class="text-center sm:text-center">
                <div class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full border bg-muted">
                    <x-ui.icon name="qr-code" class="size-6" />
                </div>
                <x-ui.dialog.title>{{ $this->modalConfig['title'] }}</x-ui.dialog.title>
                <x-ui.dialog.description>{{ $this->modalConfig['description'] }}</x-ui.dialog.description>
            </x-ui.dialog.header>

            @if ($showVerificationStep)
                <div class="space-y-6">
                    <div
                        class="flex justify-center"
                        x-data
                        x-init="$nextTick(() => $el.querySelector('input')?.focus())"
                        x-on:otp-change="$wire.set('code', $event.detail.value)"
                    >
                        <x-ui.input-otp name="code" :maxlength="6">
                            <x-ui.input-otp.group>
                                @foreach (range(0, 5) as $index)
                                    <x-ui.input-otp.slot :index="$index" />
                                @endforeach
                            </x-ui.input-otp.group>
                        </x-ui.input-otp>
                    </div>

                    @error('code')
                        <x-ui.typography.muted class="text-center text-destructive">{{ $message }}</x-ui.typography.muted>
                    @enderror

                    <div class="flex gap-3">
                        <x-ui.button type="button" variant="outline" class="flex-1" wire:click="resetVerification">
                            {{ __('Back') }}
                        </x-ui.button>
                        <x-ui.button
                            type="button"
                            class="flex-1"
                            wire:click="confirmTwoFactor"
                            x-bind:disabled="$wire.code.length < 6"
                        >
                            {{ __('Confirm') }}
                        </x-ui.button>
                    </div>
                </div>
            @else
                @error('setupData')
                    <x-ui.alert variant="destructive">
                        <x-ui.icon name="circle-x" />
                        <x-ui.alert.title>{{ $message }}</x-ui.alert.title>
                    </x-ui.alert>
                @enderror

                <div class="flex justify-center">
                    <div class="relative aspect-square w-64 overflow-hidden rounded-lg border">
                        @empty($qrCodeSvg)
                            <div class="absolute inset-0 flex animate-pulse items-center justify-center bg-muted">
                                <x-ui.icon name="loader-circle" class="size-6 animate-spin" />
                            </div>
                        @else
                            <div class="flex h-full items-center justify-center p-4">
                                <div
                                    class="rounded bg-white p-3"
                                    x-bind:style="$store.theme.isResolvedDark ? 'filter: invert(1) brightness(1.5)' : ''"
                                >
                                    {!! $qrCodeSvg !!}
                                </div>
                            </div>
                        @endempty
                    </div>
                </div>

                <x-ui.button
                    type="button"
                    class="w-full"
                    :disabled="$errors->has('setupData')"
                    wire:click="showVerificationIfNecessary"
                >
                    {{ $this->modalConfig['buttonText'] }}
                </x-ui.button>

                <div class="space-y-4">
                    <div class="relative flex items-center justify-center">
                        <x-ui.separator class="absolute inset-x-0" />
                        <span class="relative bg-background px-2 text-xs text-muted-foreground">
                            {{ __('or, enter the code manually') }}
                        </span>
                    </div>

                    <div
                        class="flex items-center gap-2"
                        x-data="{
                            copied: false,
                            async copy() {
                                try {
                                    await navigator.clipboard.writeText(@js($manualSetupKey));
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 1500);
                                } catch (e) {
                                    console.warn('Could not copy to clipboard');
                                }
                            }
                        }"
                    >
                        <div class="flex w-full items-stretch overflow-hidden rounded-lg border">
                            @empty($manualSetupKey)
                                <div class="flex w-full items-center justify-center p-3">
                                    <x-ui.icon name="loader-circle" class="size-4 animate-spin" />
                                </div>
                            @else
                                <input
                                    type="text"
                                    readonly
                                    value="{{ $manualSetupKey }}"
                                    class="w-full bg-transparent p-3 text-sm outline-none"
                                />
                                <button
                                    type="button"
                                    class="border-l px-3 transition-colors hover:bg-muted"
                                    x-on:click="copy()"
                                >
                                    <x-ui.icon name="copy" x-show="!copied" />
                                    <x-ui.icon name="check" class="text-green-500" x-show="copied" x-cloak />
                                </button>
                            @endempty
                        </div>
                    </div>
                </div>
            @endif
        </x-ui.dialog.content>
    </x-ui.dialog>
    @endif
</div>
