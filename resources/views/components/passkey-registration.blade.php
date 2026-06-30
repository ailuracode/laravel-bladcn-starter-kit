@assets
@vite('resources/js/passkeys.ts')
@endassets

<div
    x-data="{
        supported: false,
        showForm: false,
        name: '',
        loading: false,
        error: null,
        updateSupport() {
            this.supported = Boolean(window.Passkeys?.isSupported());
        },
        init() {
            this.updateSupport();
            window.addEventListener('passkeys:ready', () => this.updateSupport(), { once: true });
        },
        async register() {
            if (!this.name.trim()) return;
            this.loading = true;
            this.error = null;
            try {
                await window.Passkeys.register({ name: this.name });
                this.name = '';
                this.showForm = false;
                await $wire.loadPasskeys();
            } catch (e) {
                if (e.constructor?.name !== 'UserCancelledError') {
                    this.error = e.message;
                }
            } finally {
                this.loading = false;
            }
        },
        cancel() {
            this.showForm = false;
            this.name = '';
            this.error = null;
        },
    }"
>
    <template x-if="!supported">
        <x-ui.typography.muted>{{ __('Passkeys are not supported in this browser.') }}</x-ui.typography.muted>
    </template>

    <template x-if="supported && !showForm">
        <x-ui.button type="button" x-on:click="showForm = true">
            <x-ui.icon name="plus" class="size-4 shrink-0" />
            {{ __('Add passkey') }}
        </x-ui.button>
    </template>

    <template x-if="supported && showForm">
        <div class="space-y-4 rounded-lg border bg-muted/50 p-4">
            <x-ui.field>
                <x-ui.field.label>{{ __('Passkey name') }}</x-ui.field.label>
                <x-ui.field.content>
                    <x-ui.input
                        x-model="name"
                        placeholder="{{ __('e.g., MacBook Pro, iPhone') }}"
                        x-on:keydown.enter.prevent="register()"
                        x-ref="passkeyNameInput"
                        x-init="$nextTick(() => $refs.passkeyNameInput?.focus())"
                    />
                </x-ui.field.content>
            </x-ui.field>
            <x-ui.typography.muted class="text-xs">
                {{ __('Give this passkey a name to help you identify it later.') }}
            </x-ui.typography.muted>

            <p x-show="error" x-text="error" x-cloak class="text-sm text-destructive"></p>

            <div class="flex gap-2">
                <x-ui.button type="button" x-on:click="register()" x-bind:disabled="loading || !name.trim()">
                    <span x-show="!loading">{{ __('Register passkey') }}</span>
                    <span x-show="loading" x-cloak>{{ __('Registering...') }}</span>
                </x-ui.button>
                <x-ui.button type="button" variant="outline" x-on:click="cancel()">
                    {{ __('Cancel') }}
                </x-ui.button>
            </div>
        </div>
    </template>
</div>
