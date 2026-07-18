<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4" x-data>
        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Alert') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Examples from the official shadcn/ui alert documentation.') }}
                </x-ui.card.description>
            </x-ui.card.header>

            <x-ui.card.content class="space-y-12">
                <x-docs.section :label="__('Demo')">
                    <div class="grid w-full max-w-md items-start gap-4">
                        <x-ui.alert>
                            <x-ui.icon name="circle-check" />
                            <x-ui.alert.title>{{ __('Payment successful') }}</x-ui.alert.title>
                            <x-ui.alert.description>
                                {{ __('Your payment of $29.99 has been processed. A receipt has been sent to your email address.') }}
                            </x-ui.alert.description>
                        </x-ui.alert>

                        <x-ui.alert>
                            <x-ui.icon name="info" />
                            <x-ui.alert.title>{{ __('New feature available') }}</x-ui.alert.title>
                            <x-ui.alert.description>
                                {{ __('We\'ve added dark mode support. You can enable it in your account settings.') }}
                            </x-ui.alert.description>
                        </x-ui.alert>
                    </div>
                </x-docs.section>

                <x-docs.section :label="__('Basic')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('A basic alert with an icon, title and description.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert class="max-w-md">
                        <x-ui.icon name="circle-check" />
                        <x-ui.alert.title>{{ __('Account updated successfully') }}</x-ui.alert.title>
                        <x-ui.alert.description>
                            {{ __('Your profile information has been saved. Changes will be reflected immediately.') }}
                        </x-ui.alert.description>
                    </x-ui.alert>
                </x-docs.section>

                <x-docs.section :label="__('Destructive')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use variant="destructive" to create a destructive alert.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert variant="destructive" class="max-w-md">
                        <x-ui.icon name="circle-alert" />
                        <x-ui.alert.title>{{ __('Payment failed') }}</x-ui.alert.title>
                        <x-ui.alert.description>
                            {{ __('Your payment could not be processed. Please check your payment method and try again.') }}
                        </x-ui.alert.description>
                    </x-ui.alert>
                </x-docs.section>

                <x-docs.section :label="__('Action')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use AlertAction to add a button or other action element to the alert.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert class="max-w-md">
                        <x-ui.alert.title>{{ __('Dark mode is now available') }}</x-ui.alert.title>
                        <x-ui.alert.description>
                            {{ __('Enable it under your profile settings to get started.') }}
                        </x-ui.alert.description>
                        <x-ui.alert.action>
                            <x-ui.button size="xs">{{ __('Enable') }}</x-ui.button>
                        </x-ui.alert.action>
                    </x-ui.alert>
                </x-docs.section>

                <x-docs.section :label="__('Custom Colors')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('You can customize the alert colors by adding custom classes such as bg-amber-50 dark:bg-amber-950 to the Alert component.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert
                        class="max-w-md border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-50"
                    >
                        <x-ui.icon name="triangle-alert" />
                        <x-ui.alert.title>{{ __('Your subscription will expire in 3 days.') }}</x-ui.alert.title>
                        <x-ui.alert.description>
                            {{ __('Renew now to avoid service interruption or upgrade to a paid plan to continue using the service.') }}
                        </x-ui.alert.description>
                    </x-ui.alert>
                </x-docs.section>

                <x-docs.section :label="__('RTL')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Right-to-left layout with Arabic content.') }}
                    </x-ui.typography.muted>

                    <div class="grid w-full max-w-md items-start gap-4" dir="rtl">
                        <x-ui.alert>
                            <x-ui.icon name="circle-check" />
                            <x-ui.alert.title>تم الدفع بنجاح</x-ui.alert.title>
                            <x-ui.alert.description>
                                تمت معالجة دفعتك البالغة 29.99 دولارًا. تم إرسال إيصال إلى عنوان بريدك الإلكتروني.
                            </x-ui.alert.description>
                        </x-ui.alert>

                        <x-ui.alert>
                            <x-ui.icon name="info" />
                            <x-ui.alert.title>ميزة جديدة متاحة</x-ui.alert.title>
                            <x-ui.alert.description>
                                لقد أضفنا دعم الوضع الداكن. يمكنك تفعيله في إعدادات حسابك.
                            </x-ui.alert.description>
                        </x-ui.alert>
                    </div>
                </x-docs.section>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Alert Dialog') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Examples from the official shadcn/ui alert-dialog documentation.') }}
                </x-ui.card.description>
            </x-ui.card.header>

            <x-ui.card.content class="space-y-12">
                <x-docs.section :label="__('Demo')">
                    <x-ui.alert-dialog>
                        <x-ui.alert-dialog.trigger variant="outline">
                            {{ __('Show Dialog') }}
                        </x-ui.alert-dialog.trigger>
                        <x-ui.alert-dialog.content>
                            <x-ui.alert-dialog.header>
                                <x-ui.alert-dialog.title>{{ __('Are you absolutely sure?') }}</x-ui.alert-dialog.title>
                                <x-ui.alert-dialog.description>
                                    {{ __('This action cannot be undone. This will permanently delete your account and remove your data from our servers.') }}
                                </x-ui.alert-dialog.description>
                            </x-ui.alert-dialog.header>
                            <x-ui.alert-dialog.footer>
                                <x-ui.alert-dialog.cancel>{{ __('Cancel') }}</x-ui.alert-dialog.cancel>
                                <x-ui.alert-dialog.action>{{ __('Continue') }}</x-ui.alert-dialog.action>
                            </x-ui.alert-dialog.footer>
                        </x-ui.alert-dialog.content>
                    </x-ui.alert-dialog>
                </x-docs.section>

                <x-docs.section :label="__('Basic')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('A basic alert dialog with a title, description, and cancel and continue buttons.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert-dialog>
                        <x-ui.alert-dialog.trigger variant="outline">
                            {{ __('Show Dialog') }}
                        </x-ui.alert-dialog.trigger>
                        <x-ui.alert-dialog.content>
                            <x-ui.alert-dialog.header>
                                <x-ui.alert-dialog.title>{{ __('Are you absolutely sure?') }}</x-ui.alert-dialog.title>
                                <x-ui.alert-dialog.description>
                                    {{ __('This action cannot be undone. This will permanently delete your account and remove your data from our servers.') }}
                                </x-ui.alert-dialog.description>
                            </x-ui.alert-dialog.header>
                            <x-ui.alert-dialog.footer>
                                <x-ui.alert-dialog.cancel>{{ __('Cancel') }}</x-ui.alert-dialog.cancel>
                                <x-ui.alert-dialog.action>{{ __('Continue') }}</x-ui.alert-dialog.action>
                            </x-ui.alert-dialog.footer>
                        </x-ui.alert-dialog.content>
                    </x-ui.alert-dialog>
                </x-docs.section>

                <x-docs.section :label="__('Small')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use size="sm" on AlertDialogContent for a compact dialog.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert-dialog>
                        <x-ui.alert-dialog.trigger variant="outline">
                            {{ __('Show Dialog') }}
                        </x-ui.alert-dialog.trigger>
                        <x-ui.alert-dialog.content size="sm">
                            <x-ui.alert-dialog.header>
                                <x-ui.alert-dialog.title>{{ __('Allow accessory to connect?') }}</x-ui.alert-dialog.title>
                                <x-ui.alert-dialog.description>
                                    {{ __('Do you want to allow the USB accessory to connect to this device?') }}
                                </x-ui.alert-dialog.description>
                            </x-ui.alert-dialog.header>
                            <x-ui.alert-dialog.footer>
                                <x-ui.alert-dialog.cancel>{{ __('Don\'t allow') }}</x-ui.alert-dialog.cancel>
                                <x-ui.alert-dialog.action>{{ __('Allow') }}</x-ui.alert-dialog.action>
                            </x-ui.alert-dialog.footer>
                        </x-ui.alert-dialog.content>
                    </x-ui.alert-dialog>
                </x-docs.section>

                <x-docs.section :label="__('Media')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Add an icon or image with AlertDialogMedia.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert-dialog>
                        <x-ui.alert-dialog.trigger variant="outline">
                            {{ __('Show Dialog') }}
                        </x-ui.alert-dialog.trigger>
                        <x-ui.alert-dialog.content>
                            <x-ui.alert-dialog.header>
                                <x-ui.alert-dialog.media>
                                    <x-ui.icon name="circle-fading-plus" class="size-8" aria-hidden="true" />
                                </x-ui.alert-dialog.media>
                                <x-ui.alert-dialog.title>{{ __('Share this project?') }}</x-ui.alert-dialog.title>
                                <x-ui.alert-dialog.description>
                                    {{ __('Anyone with the link will be able to view and edit this project.') }}
                                </x-ui.alert-dialog.description>
                            </x-ui.alert-dialog.header>
                            <x-ui.alert-dialog.footer>
                                <x-ui.alert-dialog.cancel>{{ __('Cancel') }}</x-ui.alert-dialog.cancel>
                                <x-ui.alert-dialog.action>{{ __('Share') }}</x-ui.alert-dialog.action>
                            </x-ui.alert-dialog.footer>
                        </x-ui.alert-dialog.content>
                    </x-ui.alert-dialog>
                </x-docs.section>

                <x-docs.section :label="__('Small with Media')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Combine size="sm" with AlertDialogMedia for a compact dialog with an icon.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert-dialog>
                        <x-ui.alert-dialog.trigger variant="outline">
                            {{ __('Show Dialog') }}
                        </x-ui.alert-dialog.trigger>
                        <x-ui.alert-dialog.content size="sm">
                            <x-ui.alert-dialog.header>
                                <x-ui.alert-dialog.media>
                                    <x-ui.icon name="bluetooth" class="size-8" aria-hidden="true" />
                                </x-ui.alert-dialog.media>
                                <x-ui.alert-dialog.title>{{ __('Allow accessory to connect?') }}</x-ui.alert-dialog.title>
                                <x-ui.alert-dialog.description>
                                    {{ __('Do you want to allow the USB accessory to connect to this device?') }}
                                </x-ui.alert-dialog.description>
                            </x-ui.alert-dialog.header>
                            <x-ui.alert-dialog.footer>
                                <x-ui.alert-dialog.cancel>{{ __('Don\'t allow') }}</x-ui.alert-dialog.cancel>
                                <x-ui.alert-dialog.action>{{ __('Allow') }}</x-ui.alert-dialog.action>
                            </x-ui.alert-dialog.footer>
                        </x-ui.alert-dialog.content>
                    </x-ui.alert-dialog>
                </x-docs.section>

                <x-docs.section :label="__('Destructive')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use variant="destructive" on AlertDialogAction for destructive actions.') }}
                    </x-ui.typography.muted>

                    <x-ui.alert-dialog>
                        <x-ui.alert-dialog.trigger variant="destructive">
                            {{ __('Delete Chat') }}
                        </x-ui.alert-dialog.trigger>
                        <x-ui.alert-dialog.content size="sm">
                            <x-ui.alert-dialog.header>
                                <x-ui.alert-dialog.media
                                    class="bg-destructive/10 text-destructive dark:bg-destructive/20 dark:text-destructive"
                                >
                                    <x-ui.icon name="trash-2" class="size-8" aria-hidden="true" />
                                </x-ui.alert-dialog.media>
                                <x-ui.alert-dialog.title>{{ __('Delete chat?') }}</x-ui.alert-dialog.title>
                                <x-ui.alert-dialog.description>
                                    {{ __('This will permanently delete this chat and all of its messages. This action cannot be undone.') }}
                                </x-ui.alert-dialog.description>
                            </x-ui.alert-dialog.header>
                            <x-ui.alert-dialog.footer>
                                <x-ui.alert-dialog.cancel variant="outline">{{ __('Cancel') }}</x-ui.alert-dialog.cancel>
                                <x-ui.alert-dialog.action variant="destructive">{{ __('Delete') }}</x-ui.alert-dialog.action>
                            </x-ui.alert-dialog.footer>
                        </x-ui.alert-dialog.content>
                    </x-ui.alert-dialog>
                </x-docs.section>

                <x-docs.section :label="__('RTL')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Right-to-left layout with Arabic and Hebrew content.') }}
                    </x-ui.typography.muted>

                    <div class="grid w-full max-w-md items-start gap-4" dir="rtl">
                        <x-ui.alert-dialog>
                            <x-ui.alert-dialog.trigger variant="outline">
                                عرض الحوار
                            </x-ui.alert-dialog.trigger>
                            <x-ui.alert-dialog.content dir="rtl">
                                <x-ui.alert-dialog.header>
                                    <x-ui.alert-dialog.title>هل أنت متأكد تمامًا؟</x-ui.alert-dialog.title>
                                    <x-ui.alert-dialog.description>
                                        لا يمكن التراجع عن هذا الإجراء. سيؤدي هذا إلى حذف حسابك نهائيًا وإزالة بياناتك من خوادمنا.
                                    </x-ui.alert-dialog.description>
                                </x-ui.alert-dialog.header>
                                <x-ui.alert-dialog.footer>
                                    <x-ui.alert-dialog.cancel>إلغاء</x-ui.alert-dialog.cancel>
                                    <x-ui.alert-dialog.action>متابعة</x-ui.alert-dialog.action>
                                </x-ui.alert-dialog.footer>
                            </x-ui.alert-dialog.content>
                        </x-ui.alert-dialog>

                        <x-ui.alert-dialog>
                            <x-ui.alert-dialog.trigger variant="outline">
                                הצג דיאלוג
                            </x-ui.alert-dialog.trigger>
                            <x-ui.alert-dialog.content size="sm" dir="rtl">
                                <x-ui.alert-dialog.header>
                                    <x-ui.alert-dialog.media>
                                        <x-ui.icon name="bluetooth" class="size-8" aria-hidden="true" />
                                    </x-ui.alert-dialog.media>
                                    <x-ui.alert-dialog.title>לאפשר לתקן להתחבר?</x-ui.alert-dialog.title>
                                    <x-ui.alert-dialog.description>
                                        האם ברצונך לאפשר לתקן USB להתחבר למכשיר זה?
                                    </x-ui.alert-dialog.description>
                                </x-ui.alert-dialog.header>
                                <x-ui.alert-dialog.footer>
                                    <x-ui.alert-dialog.cancel>לא לאפשר</x-ui.alert-dialog.cancel>
                                    <x-ui.alert-dialog.action>לאפשר</x-ui.alert-dialog.action>
                                </x-ui.alert-dialog.footer>
                            </x-ui.alert-dialog.content>
                        </x-ui.alert-dialog>
                    </div>
                </x-docs.section>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Avatar') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Examples from the official shadcn/ui avatar documentation.') }}
                </x-ui.card.description>
            </x-ui.card.header>

            <x-ui.card.content class="space-y-12">
                <x-docs.section :label="__('Demo')">
                    <div class="flex flex-row flex-wrap items-center gap-6 md:gap-12">
                        <x-ui.avatar>
                            <x-ui.avatar.image
                                src="https://github.com/shadcn.png"
                                alt="@shadcn"
                                class="grayscale"
                            />
                            <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        </x-ui.avatar>

                        <x-ui.avatar>
                            <x-ui.avatar.image
                                src="https://github.com/evilrabbit.png"
                                alt="@evilrabbit"
                            />
                            <x-ui.avatar.fallback>ER</x-ui.avatar.fallback>
                            <x-ui.avatar.badge class="bg-green-600 dark:bg-green-800" />
                        </x-ui.avatar>

                        <x-ui.avatar.group class="grayscale">
                            <x-ui.avatar>
                                <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                                <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                            </x-ui.avatar>
                            <x-ui.avatar>
                                <x-ui.avatar.image src="https://github.com/maxleiter.png" alt="@maxleiter" />
                                <x-ui.avatar.fallback>LR</x-ui.avatar.fallback>
                            </x-ui.avatar>
                            <x-ui.avatar>
                                <x-ui.avatar.image src="https://github.com/evilrabbit.png" alt="@evilrabbit" />
                                <x-ui.avatar.fallback>ER</x-ui.avatar.fallback>
                            </x-ui.avatar>
                            <x-ui.avatar.group-count>+3</x-ui.avatar.group-count>
                        </x-ui.avatar.group>
                    </div>
                </x-docs.section>

                <x-docs.section :label="__('Basic')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('A basic avatar component with an image and a fallback.') }}
                    </x-ui.typography.muted>

                    <x-ui.avatar>
                        <x-ui.avatar.image
                            src="https://github.com/shadcn.png"
                            alt="@shadcn"
                            class="grayscale"
                        />
                        <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                    </x-ui.avatar>
                </x-docs.section>

                <x-docs.section :label="__('Badge')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use the AvatarBadge component to add a badge to the avatar. The badge is positioned at the bottom right of the avatar.') }}
                    </x-ui.typography.muted>

                    <x-ui.avatar>
                        <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                        <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        <x-ui.avatar.badge class="bg-green-600 dark:bg-green-800" />
                    </x-ui.avatar>
                </x-docs.section>

                <x-docs.section :label="__('Badge with Icon')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('You can also use an icon inside AvatarBadge.') }}
                    </x-ui.typography.muted>

                    <x-ui.avatar class="grayscale">
                        <x-ui.avatar.image src="https://github.com/pranathip.png" alt="@pranathip" />
                        <x-ui.avatar.fallback>PP</x-ui.avatar.fallback>
                        <x-ui.avatar.badge>
                            <x-ui.icon name="plus" aria-hidden="true" />
                        </x-ui.avatar.badge>
                    </x-ui.avatar>
                </x-docs.section>

                <x-docs.section :label="__('Avatar Group')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use the AvatarGroup component to add a group of avatars.') }}
                    </x-ui.typography.muted>

                    <x-ui.avatar.group class="grayscale">
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                            <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/maxleiter.png" alt="@maxleiter" />
                            <x-ui.avatar.fallback>LR</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/evilrabbit.png" alt="@evilrabbit" />
                            <x-ui.avatar.fallback>ER</x-ui.avatar.fallback>
                        </x-ui.avatar>
                    </x-ui.avatar.group>
                </x-docs.section>

                <x-docs.section :label="__('Avatar Group Count')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use AvatarGroupCount to add a count to the group.') }}
                    </x-ui.typography.muted>

                    <x-ui.avatar.group class="grayscale">
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                            <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/maxleiter.png" alt="@maxleiter" />
                            <x-ui.avatar.fallback>LR</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/evilrabbit.png" alt="@evilrabbit" />
                            <x-ui.avatar.fallback>ER</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar.group-count>+3</x-ui.avatar.group-count>
                    </x-ui.avatar.group>
                </x-docs.section>

                <x-docs.section :label="__('Avatar Group with Icon')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('You can also use an icon inside AvatarGroupCount.') }}
                    </x-ui.typography.muted>

                    <x-ui.avatar.group class="grayscale">
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                            <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/maxleiter.png" alt="@maxleiter" />
                            <x-ui.avatar.fallback>LR</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/evilrabbit.png" alt="@evilrabbit" />
                            <x-ui.avatar.fallback>ER</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar.group-count>
                            <x-ui.icon name="plus" aria-hidden="true" />
                        </x-ui.avatar.group-count>
                    </x-ui.avatar.group>
                </x-docs.section>

                <x-docs.section :label="__('Sizes')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use the size prop to change the size of the avatar.') }}
                    </x-ui.typography.muted>

                    <div class="flex flex-wrap items-center gap-2 grayscale">
                        <x-ui.avatar size="sm">
                            <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                            <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                            <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        </x-ui.avatar>
                        <x-ui.avatar size="lg">
                            <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                            <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        </x-ui.avatar>
                    </div>
                </x-docs.section>

                <x-docs.section :label="__('Dropdown')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('You can use the Avatar component as a trigger for a dropdown menu.') }}
                    </x-ui.typography.muted>

                    <x-ui.dropdown-menu>
                        <x-ui.dropdown-menu.trigger
                            class="[&>button]:inline-flex [&>button]:size-8 [&>button]:rounded-full [&>button]:border-transparent [&>button]:bg-transparent [&>button]:p-0 [&>button]:shadow-none [&>button]:hover:bg-muted [&>button]:focus-visible:ring-3 [&>button]:focus-visible:ring-ring/50"
                        >
                            <x-ui.avatar>
                                <x-ui.avatar.image src="https://github.com/shadcn.png" alt="shadcn" />
                                <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                            </x-ui.avatar>
                        </x-ui.dropdown-menu.trigger>
                        <x-ui.dropdown-menu.content class="w-32">
                            <x-ui.dropdown-menu.group>
                                <x-ui.dropdown-menu.item>{{ __('Profile') }}</x-ui.dropdown-menu.item>
                                <x-ui.dropdown-menu.item>{{ __('Billing') }}</x-ui.dropdown-menu.item>
                                <x-ui.dropdown-menu.item>{{ __('Settings') }}</x-ui.dropdown-menu.item>
                            </x-ui.dropdown-menu.group>
                            <x-ui.dropdown-menu.separator />
                            <x-ui.dropdown-menu.group>
                                <x-ui.dropdown-menu.item variant="destructive">{{ __('Log out') }}</x-ui.dropdown-menu.item>
                            </x-ui.dropdown-menu.group>
                        </x-ui.dropdown-menu.content>
                    </x-ui.dropdown-menu>
                </x-docs.section>

                <x-docs.section :label="__('RTL')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Right-to-left layout with Arabic content.') }}
                    </x-ui.typography.muted>

                    <div class="flex flex-row flex-wrap items-center gap-6 md:gap-12" dir="rtl">
                        <x-ui.avatar>
                            <x-ui.avatar.image
                                src="https://github.com/shadcn.png"
                                alt="@shadcn"
                                class="grayscale"
                            />
                            <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                        </x-ui.avatar>

                        <x-ui.avatar>
                            <x-ui.avatar.image src="https://github.com/evilrabbit.png" alt="@evilrabbit" />
                            <x-ui.avatar.fallback>ER</x-ui.avatar.fallback>
                            <x-ui.avatar.badge class="bg-green-600 dark:bg-green-800" />
                        </x-ui.avatar>

                        <x-ui.avatar.group class="grayscale">
                            <x-ui.avatar>
                                <x-ui.avatar.image src="https://github.com/shadcn.png" alt="@shadcn" />
                                <x-ui.avatar.fallback>CN</x-ui.avatar.fallback>
                            </x-ui.avatar>
                            <x-ui.avatar>
                                <x-ui.avatar.image src="https://github.com/maxleiter.png" alt="@maxleiter" />
                                <x-ui.avatar.fallback>LR</x-ui.avatar.fallback>
                            </x-ui.avatar>
                            <x-ui.avatar>
                                <x-ui.avatar.image src="https://github.com/evilrabbit.png" alt="@evilrabbit" />
                                <x-ui.avatar.fallback>ER</x-ui.avatar.fallback>
                            </x-ui.avatar>
                            <x-ui.avatar.group-count>+٣</x-ui.avatar.group-count>
                        </x-ui.avatar.group>
                    </div>
                </x-docs.section>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Badge') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Examples from the official shadcn/ui badge documentation.') }}
                </x-ui.card.description>
            </x-ui.card.header>

            <x-ui.card.content class="space-y-12">
                <x-docs.section :label="__('Demo')">
                    <div class="flex w-full flex-wrap justify-center gap-2">
                        <x-ui.badge>{{ __('Badge') }}</x-ui.badge>
                        <x-ui.badge variant="secondary">{{ __('Secondary') }}</x-ui.badge>
                        <x-ui.badge variant="destructive">{{ __('Destructive') }}</x-ui.badge>
                        <x-ui.badge variant="outline">{{ __('Outline') }}</x-ui.badge>
                    </div>
                </x-docs.section>

                <x-docs.section :label="__('Variants')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use the variant prop to change the variant of the badge.') }}
                    </x-ui.typography.muted>

                    <div class="flex flex-wrap gap-2">
                        <x-ui.badge>{{ __('Default') }}</x-ui.badge>
                        <x-ui.badge variant="secondary">{{ __('Secondary') }}</x-ui.badge>
                        <x-ui.badge variant="destructive">{{ __('Destructive') }}</x-ui.badge>
                        <x-ui.badge variant="outline">{{ __('Outline') }}</x-ui.badge>
                        <x-ui.badge variant="ghost">{{ __('Ghost') }}</x-ui.badge>
                        <x-ui.badge variant="link">{{ __('Link') }}</x-ui.badge>
                    </div>
                </x-docs.section>

                <x-docs.section :label="__('With Icon')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('You can render an icon inside the badge. Use data-icon="inline-start" to render the icon on the left and data-icon="inline-end" to render the icon on the right.') }}
                    </x-ui.typography.muted>

                    <div class="flex flex-wrap gap-2">
                        <x-ui.badge variant="secondary">
                            <x-ui.icon name="badge-check" data-icon="inline-start" aria-hidden="true" />
                            {{ __('Verified') }}
                        </x-ui.badge>
                        <x-ui.badge variant="outline">
                            {{ __('Bookmark') }}
                            <x-ui.icon name="bookmark" data-icon="inline-end" aria-hidden="true" />
                        </x-ui.badge>
                    </div>
                </x-docs.section>

                <x-docs.section :label="__('With Spinner')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('You can render a spinner inside the badge. Remember to add the data-icon="inline-start" or data-icon="inline-end" prop to the spinner.') }}
                    </x-ui.typography.muted>

                    <div class="flex flex-wrap gap-2">
                        <x-ui.badge variant="destructive">
                            <x-ui.spinner data-icon="inline-start" />
                            {{ __('Deleting') }}
                        </x-ui.badge>
                        <x-ui.badge variant="secondary">
                            {{ __('Generating') }}
                            <x-ui.spinner data-icon="inline-end" />
                        </x-ui.badge>
                    </div>
                </x-docs.section>

                <x-docs.section :label="__('Link')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use asChild to render a link as a badge.') }}
                    </x-ui.typography.muted>

                    <x-ui.badge asChild>
                        <a href="#link">
                            {{ __('Open Link') }}
                            <x-ui.icon name="arrow-up-right" data-icon="inline-end" aria-hidden="true" />
                        </a>
                    </x-ui.badge>
                </x-docs.section>

                <x-docs.section :label="__('Custom Colors')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('You can customize the colors of a badge by adding custom classes such as bg-green-50 dark:bg-green-950 to the Badge component.') }}
                    </x-ui.typography.muted>

                    <div class="flex flex-wrap gap-2">
                        <x-ui.badge class="bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                            {{ __('Blue') }}
                        </x-ui.badge>
                        <x-ui.badge class="bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300">
                            {{ __('Green') }}
                        </x-ui.badge>
                        <x-ui.badge class="bg-sky-50 text-sky-700 dark:bg-sky-950 dark:text-sky-300">
                            {{ __('Sky') }}
                        </x-ui.badge>
                        <x-ui.badge class="bg-purple-50 text-purple-700 dark:bg-purple-950 dark:text-purple-300">
                            {{ __('Purple') }}
                        </x-ui.badge>
                        <x-ui.badge class="bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300">
                            {{ __('Red') }}
                        </x-ui.badge>
                    </div>
                </x-docs.section>

                <x-docs.section :label="__('RTL')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Right-to-left layout with Arabic and Hebrew content.') }}
                    </x-ui.typography.muted>

                    <div class="flex w-full flex-wrap justify-center gap-2" dir="rtl">
                        <x-ui.badge>شارة</x-ui.badge>
                        <x-ui.badge variant="secondary">ثانوي</x-ui.badge>
                        <x-ui.badge variant="destructive">مدمر</x-ui.badge>
                        <x-ui.badge variant="outline">مخطط</x-ui.badge>
                        <x-ui.badge variant="secondary">
                            <x-ui.icon name="badge-check" data-icon="inline-start" aria-hidden="true" />
                            متحقق
                        </x-ui.badge>
                        <x-ui.badge variant="outline">
                            إشارة مرجعية
                            <x-ui.icon name="bookmark" data-icon="inline-end" aria-hidden="true" />
                        </x-ui.badge>
                    </div>

                    <div class="flex w-full flex-wrap justify-center gap-2" dir="rtl">
                        <x-ui.badge>תג</x-ui.badge>
                        <x-ui.badge variant="secondary">משני</x-ui.badge>
                        <x-ui.badge variant="destructive">הרסני</x-ui.badge>
                        <x-ui.badge variant="outline">קווי מתאר</x-ui.badge>
                        <x-ui.badge variant="secondary">
                            <x-ui.icon name="badge-check" data-icon="inline-start" aria-hidden="true" />
                            מאומת
                        </x-ui.badge>
                        <x-ui.badge variant="outline">
                            סימנייה
                            <x-ui.icon name="bookmark" data-icon="inline-end" aria-hidden="true" />
                        </x-ui.badge>
                    </div>
                </x-docs.section>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Breadcrumb') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Examples from the official shadcn/ui breadcrumb documentation.') }}
                </x-ui.card.description>
            </x-ui.card.header>

            <x-ui.card.content class="space-y-12">
                <x-docs.section :label="__('Demo')">
                    <x-ui.breadcrumb>
                        <x-ui.breadcrumb.list>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Home') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.dropdown-menu>
                                    <x-ui.dropdown-menu.trigger
                                        class="[&>button]:inline-flex [&>button]:size-7 [&>button]:rounded-[min(var(--radius-md),12px)] [&>button]:border-transparent [&>button]:bg-transparent [&>button]:p-0 [&>button]:shadow-none [&>button]:hover:bg-muted [&>button]:focus-visible:ring-3 [&>button]:focus-visible:ring-ring/50"
                                    >
                                        <x-ui.breadcrumb.ellipsis />
                                        <span class="sr-only">{{ __('Toggle menu') }}</span>
                                    </x-ui.dropdown-menu.trigger>
                                    <x-ui.dropdown-menu.content align="start">
                                        <x-ui.dropdown-menu.group>
                                            <x-ui.dropdown-menu.item>{{ __('Documentation') }}</x-ui.dropdown-menu.item>
                                            <x-ui.dropdown-menu.item>{{ __('Themes') }}</x-ui.dropdown-menu.item>
                                            <x-ui.dropdown-menu.item>{{ __('GitHub') }}</x-ui.dropdown-menu.item>
                                        </x-ui.dropdown-menu.group>
                                    </x-ui.dropdown-menu.content>
                                </x-ui.dropdown-menu>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Components') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.page>{{ __('Breadcrumb') }}</x-ui.breadcrumb.page>
                            </x-ui.breadcrumb.item>
                        </x-ui.breadcrumb.list>
                    </x-ui.breadcrumb>
                </x-docs.section>

                <x-docs.section :label="__('Basic')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('A basic breadcrumb with a home link and a components link.') }}
                    </x-ui.typography.muted>

                    <x-ui.breadcrumb>
                        <x-ui.breadcrumb.list>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Home') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Components') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.page>{{ __('Breadcrumb') }}</x-ui.breadcrumb.page>
                            </x-ui.breadcrumb.item>
                        </x-ui.breadcrumb.list>
                    </x-ui.breadcrumb>
                </x-docs.section>

                <x-docs.section :label="__('Custom separator')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Use a custom component as children for BreadcrumbSeparator to create a custom separator.') }}
                    </x-ui.typography.muted>

                    <x-ui.breadcrumb>
                        <x-ui.breadcrumb.list>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Home') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator>
                                <x-lucide-dot class="size-3.5" aria-hidden="true" />
                            </x-ui.breadcrumb.separator>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Components') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator>
                                <x-lucide-dot class="size-3.5" aria-hidden="true" />
                            </x-ui.breadcrumb.separator>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.page>{{ __('Breadcrumb') }}</x-ui.breadcrumb.page>
                            </x-ui.breadcrumb.item>
                        </x-ui.breadcrumb.list>
                    </x-ui.breadcrumb>
                </x-docs.section>

                <x-docs.section :label="__('Dropdown')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('You can compose Breadcrumb with a DropdownMenu to create a dropdown in the breadcrumb.') }}
                    </x-ui.typography.muted>

                    <x-ui.breadcrumb>
                        <x-ui.breadcrumb.list>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Home') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator>
                                <x-lucide-dot class="size-3.5" aria-hidden="true" />
                            </x-ui.breadcrumb.separator>
                            <x-ui.breadcrumb.item>
                                <x-ui.dropdown-menu>
                                    <x-ui.dropdown-menu.trigger
                                        class="[&>button]:inline-flex [&>button]:items-center [&>button]:gap-1 [&>button]:border-transparent [&>button]:bg-transparent [&>button]:p-0 [&>button]:text-sm [&>button]:shadow-none [&>button]:hover:bg-transparent [&>button]:hover:text-foreground [&>button]:focus-visible:ring-0"
                                    >
                                        {{ __('Components') }}
                                        <x-lucide-chevron-down data-icon="inline-end" class="size-3.5" aria-hidden="true" />
                                    </x-ui.dropdown-menu.trigger>
                                    <x-ui.dropdown-menu.content align="start">
                                        <x-ui.dropdown-menu.group>
                                            <x-ui.dropdown-menu.item>{{ __('Documentation') }}</x-ui.dropdown-menu.item>
                                            <x-ui.dropdown-menu.item>{{ __('Themes') }}</x-ui.dropdown-menu.item>
                                            <x-ui.dropdown-menu.item>{{ __('GitHub') }}</x-ui.dropdown-menu.item>
                                        </x-ui.dropdown-menu.group>
                                    </x-ui.dropdown-menu.content>
                                </x-ui.dropdown-menu>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator>
                                <x-lucide-dot class="size-3.5" aria-hidden="true" />
                            </x-ui.breadcrumb.separator>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.page>{{ __('Breadcrumb') }}</x-ui.breadcrumb.page>
                            </x-ui.breadcrumb.item>
                        </x-ui.breadcrumb.list>
                    </x-ui.breadcrumb>
                </x-docs.section>

                <x-docs.section :label="__('Collapsed')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('We provide a BreadcrumbEllipsis component to show a collapsed state when the breadcrumb is too long.') }}
                    </x-ui.typography.muted>

                    <x-ui.breadcrumb>
                        <x-ui.breadcrumb.list>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Home') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.ellipsis />
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">{{ __('Components') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.page>{{ __('Breadcrumb') }}</x-ui.breadcrumb.page>
                            </x-ui.breadcrumb.item>
                        </x-ui.breadcrumb.list>
                    </x-ui.breadcrumb>
                </x-docs.section>

                <x-docs.section :label="__('Link component')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('To use a custom link component from your routing library, you can use the render prop on BreadcrumbLink.') }}
                    </x-ui.typography.muted>

                    <x-ui.breadcrumb>
                        <x-ui.breadcrumb.list>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#link-component">{{ __('Home') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#link-component">{{ __('Components') }}</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator />
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.page>{{ __('Breadcrumb') }}</x-ui.breadcrumb.page>
                            </x-ui.breadcrumb.item>
                        </x-ui.breadcrumb.list>
                    </x-ui.breadcrumb>
                </x-docs.section>

                <x-docs.section :label="__('RTL')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Right-to-left layout with Arabic content.') }}
                    </x-ui.typography.muted>

                    <x-ui.breadcrumb dir="rtl">
                        <x-ui.breadcrumb.list>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.link href="#">الرئيسية</x-ui.breadcrumb.link>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator>
                                <x-lucide-dot class="size-3.5" aria-hidden="true" />
                            </x-ui.breadcrumb.separator>
                            <x-ui.breadcrumb.item>
                                <x-ui.dropdown-menu>
                                    <x-ui.dropdown-menu.trigger
                                        class="[&>button]:inline-flex [&>button]:items-center [&>button]:gap-1 [&>button]:border-transparent [&>button]:bg-transparent [&>button]:p-0 [&>button]:text-sm [&>button]:shadow-none [&>button]:hover:bg-transparent [&>button]:hover:text-foreground [&>button]:focus-visible:ring-0"
                                    >
                                        المكونات
                                        <x-lucide-chevron-down data-icon="inline-end" class="size-3.5" aria-hidden="true" />
                                    </x-ui.dropdown-menu.trigger>
                                    <x-ui.dropdown-menu.content align="end" dir="rtl">
                                        <x-ui.dropdown-menu.group>
                                            <x-ui.dropdown-menu.item>التوثيق</x-ui.dropdown-menu.item>
                                            <x-ui.dropdown-menu.item>السمات</x-ui.dropdown-menu.item>
                                            <x-ui.dropdown-menu.item>جيت هاب</x-ui.dropdown-menu.item>
                                        </x-ui.dropdown-menu.group>
                                    </x-ui.dropdown-menu.content>
                                </x-ui.dropdown-menu>
                            </x-ui.breadcrumb.item>
                            <x-ui.breadcrumb.separator>
                                <x-lucide-dot class="size-3.5" aria-hidden="true" />
                            </x-ui.breadcrumb.separator>
                            <x-ui.breadcrumb.item>
                                <x-ui.breadcrumb.page>مسار التنقل</x-ui.breadcrumb.page>
                            </x-ui.breadcrumb.item>
                        </x-ui.breadcrumb.list>
                    </x-ui.breadcrumb>
                </x-docs.section>
            </x-ui.card.content>
        </x-ui.card>

        <x-ui.card>
            <x-ui.card.header>
                <x-ui.card.title>{{ __('Aspect Ratio') }}</x-ui.card.title>
                <x-ui.card.description>
                    {{ __('Examples from the official shadcn/ui aspect-ratio documentation.') }}
                </x-ui.card.description>
            </x-ui.card.header>

            <x-ui.card.content class="space-y-12">
                <x-docs.section :label="__('Demo')">
                    <x-ui.aspect-ratio ratio="16/9" class="w-full max-w-sm rounded-lg bg-muted">
                        <img
                            src="https://avatar.vercel.sh/shadcn1"
                            alt="{{ __('Photo') }}"
                            class="size-full rounded-lg object-cover grayscale dark:brightness-20"
                        />
                    </x-ui.aspect-ratio>
                </x-docs.section>

                <x-docs.section :label="__('Usage')">
                    <x-ui.aspect-ratio ratio="16/9">
                        <img
                            src="https://avatar.vercel.sh/shadcn1"
                            alt="{{ __('Image') }}"
                            class="rounded-md object-cover"
                        />
                    </x-ui.aspect-ratio>
                </x-docs.section>

                <x-docs.section :label="__('Square')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('A square aspect ratio component using the ratio="1/1" prop. This is useful for displaying images in a square format.') }}
                    </x-ui.typography.muted>

                    <x-ui.aspect-ratio ratio="1/1" class="w-full max-w-48 rounded-lg bg-muted">
                        <img
                            src="https://avatar.vercel.sh/shadcn1"
                            alt="{{ __('Photo') }}"
                            class="size-full rounded-lg object-cover grayscale dark:brightness-20"
                        />
                    </x-ui.aspect-ratio>
                </x-docs.section>

                <x-docs.section :label="__('Portrait')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('A portrait aspect ratio component using the ratio="9/16" prop. This is useful for displaying images in a portrait format.') }}
                    </x-ui.typography.muted>

                    <x-ui.aspect-ratio ratio="9/16" class="w-full max-w-40 rounded-lg bg-muted">
                        <img
                            src="https://avatar.vercel.sh/shadcn1"
                            alt="{{ __('Photo') }}"
                            class="size-full rounded-lg object-cover grayscale dark:brightness-20"
                        />
                    </x-ui.aspect-ratio>
                </x-docs.section>

                <x-docs.section :label="__('RTL')">
                    <x-ui.typography.muted class="text-sm">
                        {{ __('Right-to-left layout with Arabic and Hebrew captions.') }}
                    </x-ui.typography.muted>

                    <div class="grid w-full max-w-sm gap-6">
                        <figure class="w-full max-w-sm" dir="ltr">
                            <x-ui.aspect-ratio ratio="16/9" class="rounded-lg bg-muted">
                                <img
                                    src="https://avatar.vercel.sh/shadcn1"
                                    alt="{{ __('Photo') }}"
                                    class="size-full rounded-lg object-cover grayscale dark:brightness-20"
                                />
                            </x-ui.aspect-ratio>
                            <figcaption class="mt-2 text-center text-sm text-muted-foreground">
                                {{ __('Beautiful landscape') }}
                            </figcaption>
                        </figure>

                        <figure class="w-full max-w-sm" dir="rtl">
                            <x-ui.aspect-ratio ratio="16/9" class="rounded-lg bg-muted">
                                <img
                                    src="https://avatar.vercel.sh/shadcn1"
                                    alt="{{ __('Photo') }}"
                                    class="size-full rounded-lg object-cover grayscale dark:brightness-20"
                                />
                            </x-ui.aspect-ratio>
                            <figcaption class="mt-2 text-center text-sm text-muted-foreground">
                                منظر طبيعي جميل
                            </figcaption>
                        </figure>

                        <figure class="w-full max-w-sm" dir="rtl">
                            <x-ui.aspect-ratio ratio="16/9" class="rounded-lg bg-muted">
                                <img
                                    src="https://avatar.vercel.sh/shadcn1"
                                    alt="{{ __('Photo') }}"
                                    class="size-full rounded-lg object-cover grayscale dark:brightness-20"
                                />
                            </x-ui.aspect-ratio>
                            <figcaption class="mt-2 text-center text-sm text-muted-foreground">
                                נוף יפה
                            </figcaption>
                        </figure>
                    </div>
                </x-docs.section>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layouts::app>
