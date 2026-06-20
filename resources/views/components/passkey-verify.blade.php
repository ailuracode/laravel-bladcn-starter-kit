@props([
    'optionsRoute' => 'passkey.login-options',
    'submitRoute' => 'passkey.login',
    'label' => __('Sign in with a passkey'),
    'loadingLabel' => __('Authenticating...'),
    'separator' => __('Or continue with email'),
])

@assets
@vite('resources/js/passkeys.js')
@endassets

<div
    x-data="{
        supported: false,
        loading: false,
        error: null,
        updateSupport() {
            this.supported = Boolean(window.Passkeys?.isSupported());
        },
        init() {
            this.updateSupport();
            window.addEventListener('passkeys:ready', () => this.updateSupport(), { once: true });
        },
        async verify() {
            this.loading = true;
            this.error = null;
            try {
                const response = await window.Passkeys.verify({
                    routes: {
                        options: '{{ route($optionsRoute) }}',
                        submit: '{{ route($submitRoute) }}',
                    },
                });
                Livewire.navigate(response.redirect || '/dashboard');
            } catch (e) {
                if (e.constructor?.name !== 'UserCancelledError') {
                    this.error = e.message;
                }
            } finally {
                this.loading = false;
            }
        },
    }"
>
    <template x-if="supported">
        <div>
            <x-ui.button
                type="button"
                variant="outline"
                class="w-full"
                x-on:click="verify()"
                x-bind:disabled="loading"
            >
                <x-ui.icon name="fingerprint" class="size-4 shrink-0" />
                <span x-show="!loading">{{ $label }}</span>
                <span x-show="loading" x-cloak>{{ $loadingLabel }}</span>
            </x-ui.button>
            <p x-show="error" x-text="error" x-cloak class="mt-2 text-center text-sm text-destructive"></p>

            <div class="relative my-6">
                <x-ui.separator />
                <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 bg-background px-2 text-xs uppercase text-muted-foreground">
                    {{ $separator }}
                </span>
            </div>
        </div>
    </template>
</div>
