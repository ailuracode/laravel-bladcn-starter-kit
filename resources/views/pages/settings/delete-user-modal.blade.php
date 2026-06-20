<?php

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    use PasswordValidationRules;

    public string $password = '';

    public bool $open = false;

    public function mount(): void
    {
        $this->open = $this->getErrorBag()->isNotEmpty();
    }

    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }

    public function close(): void
    {
        $this->open = false;
        $this->reset('password');
        $this->resetErrorBag();
    }
}; ?>

<div>
    <x-ui.button variant="destructive" data-test="delete-user-button" wire:click="$set('open', true)">
        {{ __('Delete account') }}
    </x-ui.button>

    @if ($open)
        <x-ui.alert-dialog open x-init="$watch('isOpen', value => { if (! value) $wire.close() })">
            <x-ui.alert-dialog.content>
                <form wire:submit="deleteUser" class="space-y-6">
                    <x-ui.alert-dialog.header>
                        <x-ui.alert-dialog.title>{{ __('Are you sure you want to delete your account?') }}</x-ui.alert-dialog.title>
                        <x-ui.alert-dialog.description>
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </x-ui.alert-dialog.description>
                    </x-ui.alert-dialog.header>

                    <x-wire-field name="password" :label="__('Password')" type="password" autocomplete="current-password" />

                    <x-ui.alert-dialog.footer>
                        <x-ui.alert-dialog.cancel type="button" wire:click="close">
                            {{ __('Cancel') }}
                        </x-ui.alert-dialog.cancel>
                        <x-ui.alert-dialog.action type="submit" data-test="confirm-delete-user-button">
                            {{ __('Delete account') }}
                        </x-ui.alert-dialog.action>
                    </x-ui.alert-dialog.footer>
                </form>
            </x-ui.alert-dialog.content>
        </x-ui.alert-dialog>
    @endif
</div>
