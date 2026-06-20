<?php

use App\Concerns\DispatchesBladcnToast;
use App\Concerns\PasswordValidationRules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Laravel\Passkeys\Actions\DeletePasskey;

new #[Title('Security settings')]
    #[Layout('layouts::app', ['title' => 'Security settings'])]
    class extends Component {
    use DispatchesBladcnToast;
    use PasswordValidationRules;

    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public bool $canManageTwoFactor;
    public bool $twoFactorEnabled;
    public bool $requiresConfirmation;

    #[Locked]
    public bool $canManagePasskeys;

    #[Locked]
    public array $passkeys = [];

    public bool $showDeleteModal = false;

    #[Locked]
    public ?int $deletingPasskeyId = null;

    #[Locked]
    public string $deletingPasskeyName = '';

    public function mount(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $this->canManageTwoFactor = Features::canManageTwoFactorAuthentication();

        if ($this->canManageTwoFactor) {
            if (Fortify::confirmsTwoFactorAuthentication() && is_null(auth()->user()->two_factor_confirmed_at)) {
                $disableTwoFactorAuthentication(auth()->user());
            }

            $this->twoFactorEnabled = auth()->user()->hasEnabledTwoFactorAuthentication();
            $this->requiresConfirmation = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }

        $this->canManagePasskeys = Features::canManagePasskeys();

        if ($this->canManagePasskeys) {
            $this->loadPasskeys();
        }
    }

    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => $this->currentPasswordRules(),
                'password' => $this->passwordRules(),
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->bladcnToast(__('Password updated.'));
    }

    public function loadPasskeys(): void
    {
        $this->passkeys = auth()->user()->passkeys()
            ->select(['id', 'name', 'credential', 'created_at', 'last_used_at'])
            ->latest()
            ->get()
            ->map(fn ($passkey) => [
                'id' => $passkey->id,
                'name' => $passkey->name,
                'authenticator' => $passkey->authenticator,
                'created_at_diff' => $passkey->created_at->diffForHumans(),
                'last_used_at_diff' => $passkey->last_used_at?->diffForHumans(),
            ])
            ->toArray();
    }

    public function confirmDelete(int $passkeyId): void
    {
        $passkey = auth()->user()->passkeys()->findOrFail($passkeyId);

        $this->deletingPasskeyId = $passkey->id;
        $this->deletingPasskeyName = $passkey->name;
        $this->showDeleteModal = true;
    }

    public function deletePasskey(DeletePasskey $deletePasskey): void
    {
        if (! $this->deletingPasskeyId) {
            return;
        }

        $passkey = auth()->user()->passkeys()->findOrFail($this->deletingPasskeyId);

        $deletePasskey(auth()->user(), $passkey);

        $this->closeDeleteModal();
        $this->loadPasskeys();
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
        $this->deletingPasskeyId = null;
        $this->deletingPasskeyName = '';
    }

    #[On('two-factor-enabled')]
    public function onTwoFactorEnabled(): void
    {
        $this->twoFactorEnabled = true;
    }

    public function disable(DisableTwoFactorAuthentication $disableTwoFactorAuthentication): void
    {
        $disableTwoFactorAuthentication(auth()->user());

        $this->twoFactorEnabled = false;
    }
}; ?>

<section class="w-full px-4 py-6">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <x-wire-field name="current_password" :label="__('Current password')" type="password" required autocomplete="current-password" />
            <x-wire-field name="password" :label="__('New password')" type="password" required autocomplete="new-password" />
            <x-wire-field name="password_confirmation" :label="__('Confirm password')" type="password" required autocomplete="new-password" />

            <x-ui.button type="submit" data-test="update-password-button">
                {{ __('Save') }}
            </x-ui.button>
        </form>

        @if ($canManageTwoFactor)
            <section class="mt-12 space-y-4">
                <div>
                    <x-ui.typography.h3 class="text-base font-semibold">{{ __('Two-factor authentication') }}</x-ui.typography.h3>
                    <x-ui.typography.muted>{{ __('Manage your two-factor authentication settings') }}</x-ui.typography.muted>
                </div>

                <div class="space-y-6 text-sm" wire:cloak>
                    @if ($twoFactorEnabled)
                        <x-ui.typography.muted>
                            {{ __('You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}
                        </x-ui.typography.muted>

                        <x-ui.button variant="destructive" wire:click="disable">
                            {{ __('Disable 2FA') }}
                        </x-ui.button>

                        <livewire:pages::settings.two-factor.recovery-codes :$requiresConfirmation />
                    @else
                        <x-ui.typography.muted>
                            {{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}
                        </x-ui.typography.muted>

                        <x-ui.button wire:click="$dispatch('start-two-factor-setup')">
                            {{ __('Enable 2FA') }}
                        </x-ui.button>

                        <livewire:pages::settings.two-factor-setup-modal :requires-confirmation="$requiresConfirmation" />
                    @endif
                </div>
            </section>
        @endif

        @if ($canManagePasskeys)
            <section class="mt-12 space-y-4">
                <div>
                    <x-ui.typography.h3 class="text-base font-semibold">{{ __('Passkeys') }}</x-ui.typography.h3>
                    <x-ui.typography.muted>{{ __('Manage your passkeys for passwordless sign-in') }}</x-ui.typography.muted>
                </div>

                <div class="space-y-6 text-sm" wire:cloak>
                    <x-ui.card class="overflow-hidden p-0">
                        @forelse ($passkeys as $passkey)
                            <div @class([
                                'flex items-center justify-between p-4',
                                'border-b' => ! $loop->last,
                            ])>
                                <div class="flex items-center gap-4">
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-muted">
                                        <x-ui.icon name="key" class="size-5 text-muted-foreground" />
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2.5">
                                            <p class="font-medium tracking-tight">{{ $passkey['name'] }}</p>
                                            @if ($passkey['authenticator'])
                                                <x-ui.badge variant="secondary">{{ $passkey['authenticator'] }}</x-ui.badge>
                                            @endif
                                        </div>
                                        <p class="text-xs text-muted-foreground">
                                            {{ __('Added :time', ['time' => $passkey['created_at_diff']]) }}
                                            @if ($passkey['last_used_at_diff'])
                                                <span class="mx-1 opacity-50">/</span>
                                                {{ __('Last used :time', ['time' => $passkey['last_used_at_diff']]) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <x-ui.button
                                    type="button"
                                    variant="ghost"
                                    size="icon-sm"
                                    wire:click="confirmDelete({{ $passkey['id'] }})"
                                    class="text-destructive hover:text-destructive"
                                >
                                    <x-ui.icon name="trash-2" />
                                </x-ui.button>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="mx-auto mb-4 flex size-14 items-center justify-center rounded-2xl bg-muted">
                                    <x-ui.icon name="key" class="size-7 text-muted-foreground" />
                                </div>
                                <p class="font-medium">{{ __('No passkeys yet') }}</p>
                                <x-ui.typography.muted class="mt-1">
                                    {{ __('Add a passkey to sign in without a password') }}
                                </x-ui.typography.muted>
                            </div>
                        @endforelse
                    </x-ui.card>

                    <x-passkey-registration />
                </div>
            </section>
        @endif
    </x-pages::settings.layout>

    @if ($showDeleteModal)
        <x-ui.alert-dialog open x-init="$watch('isOpen', value => { if (! value) $wire.closeDeleteModal() })">
            <x-ui.alert-dialog.content>
                <x-ui.alert-dialog.header>
                    <x-ui.alert-dialog.title>{{ __('Remove passkey') }}</x-ui.alert-dialog.title>
                    <x-ui.alert-dialog.description>
                        {{ __('Are you sure you want to remove the passkey ":name"? You will no longer be able to use it to sign in.', ['name' => $deletingPasskeyName]) }}
                    </x-ui.alert-dialog.description>
                </x-ui.alert-dialog.header>

                <x-ui.alert-dialog.footer>
                    <x-ui.alert-dialog.cancel type="button" wire:click="closeDeleteModal">
                        {{ __('Cancel') }}
                    </x-ui.alert-dialog.cancel>
                    <x-ui.alert-dialog.action type="button" wire:click="deletePasskey">
                        {{ __('Remove passkey') }}
                    </x-ui.alert-dialog.action>
                </x-ui.alert-dialog.footer>
            </x-ui.alert-dialog.content>
        </x-ui.alert-dialog>
    @endif
</section>
