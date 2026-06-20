<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <x-form-field
                name="email"
                :label="__('Email address')"
                type="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <x-ui.field.label for="password">{{ __('Password') }}</x-ui.field.label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
                <x-ui.input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                />
                @error('password')
                    <x-ui.field.error>{{ $message }}</x-ui.field.error>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <x-ui.checkbox name="remember" :checked="old('remember')" />
                {{ __('Remember me') }}
            </label>

            <x-ui.button type="submit" class="w-full" data-test="login-button">
                {{ __('Log in') }}
            </x-ui.button>
        </form>

        <p class="text-center text-sm text-muted-foreground">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="text-primary hover:underline" wire:navigate>{{ __('Sign up') }}</a>
        </p>
    </div>
</x-layouts::auth>
