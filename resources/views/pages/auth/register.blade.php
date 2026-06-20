<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf

            <x-form-field
                name="name"
                :label="__('Name')"
                type="text"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <x-form-field
                name="email"
                :label="__('Email address')"
                type="email"
                :value="old('email')"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <x-form-field
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
            />

            <x-form-field
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
            />

            <x-ui.button type="submit" class="w-full" data-test="register-user-button">
                {{ __('Create account') }}
            </x-ui.button>
        </form>

        <p class="text-center text-sm text-muted-foreground">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="text-primary hover:underline" wire:navigate>{{ __('Log in') }}</a>
        </p>
    </div>
</x-layouts::auth>
