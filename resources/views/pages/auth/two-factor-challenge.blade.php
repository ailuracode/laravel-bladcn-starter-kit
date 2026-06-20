<x-layouts::auth :title="__('Two-factor authentication')">
    <div
        class="relative w-full"
        x-cloak
        x-data="{
            showRecoveryInput: @js($errors->has('recovery_code')),
            recovery_code: '',
            focusOtp() {
                this.$nextTick(() => this.$refs.otp?.querySelector('input')?.focus());
            },
            init() {
                if (! this.showRecoveryInput) {
                    this.focusOtp();
                }
            },
            toggleInput() {
                this.showRecoveryInput = !this.showRecoveryInput;
                this.recovery_code = '';
                $nextTick(() => {
                    this.showRecoveryInput
                        ? this.$refs.recovery_code?.focus()
                        : this.focusOtp();
                });
            },
        }"
    >
        <div class="flex flex-col gap-6">
            <div x-show="!showRecoveryInput">
                <x-auth-header
                    :title="__('Authentication code')"
                    :description="__('Enter the authentication code provided by your authenticator application.')"
                />
            </div>

            <div x-show="showRecoveryInput">
                <x-auth-header
                    :title="__('Recovery code')"
                    :description="__('Please confirm access to your account by entering one of your emergency recovery codes.')"
                />
            </div>

            <form method="POST" action="{{ route('two-factor.login.store') }}" class="space-y-5">
                @csrf

                <div x-show="!showRecoveryInput" class="flex justify-center" x-ref="otp">
                    <x-ui.input-otp name="code" :maxlength="6">
                        <x-ui.input-otp.group>
                            @foreach (range(0, 5) as $index)
                                <x-ui.input-otp.slot :index="$index" />
                            @endforeach
                        </x-ui.input-otp.group>
                    </x-ui.input-otp>
                </div>

                <div x-show="showRecoveryInput" class="space-y-2">
                    <x-ui.input
                        type="text"
                        name="recovery_code"
                        x-ref="recovery_code"
                        x-bind:required="showRecoveryInput"
                        autocomplete="one-time-code"
                        x-model="recovery_code"
                    />
                    @error('recovery_code')
                        <x-ui.field.error>{{ $message }}</x-ui.field.error>
                    @enderror
                </div>

                <x-ui.button type="submit" class="w-full">
                    {{ __('Continue') }}
                </x-ui.button>

                <p class="text-center text-sm text-muted-foreground">
                    <span>{{ __('or you can') }}</span>
                    <button type="button" class="font-medium text-primary hover:underline" @click="toggleInput()">
                        <span x-show="!showRecoveryInput">{{ __('login using a recovery code') }}</span>
                        <span x-show="showRecoveryInput">{{ __('login using an authentication code') }}</span>
                    </button>
                </p>
            </form>
        </div>
    </div>
</x-layouts::auth>
