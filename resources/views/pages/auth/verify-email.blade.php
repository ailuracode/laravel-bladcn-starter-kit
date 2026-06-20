<x-layouts::auth :title="__('Email verification')">
    <div class="flex flex-col gap-6">
        <x-ui.typography.p class="text-center text-muted-foreground">
            {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
        </x-ui.typography.p>

        @if (session('status') == 'verification-link-sent')
            <x-ui.alert>
                <x-ui.alert.description class="text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </x-ui.alert.description>
            </x-ui.alert>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-ui.button type="submit" class="w-full">
                    {{ __('Resend verification email') }}
                </x-ui.button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-ui.button variant="ghost" type="submit" class="w-full" data-test="logout-button">
                    {{ __('Log out') }}
                </x-ui.button>
            </form>
        </div>
    </div>
</x-layouts::auth>
