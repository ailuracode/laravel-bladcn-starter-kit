/// <reference types="alpinejs" />

import type { AlpineInstance } from "./types/alpine";

declare module "alpinejs" {
    namespace Alpine {
        interface Stores {
            theme: import("@ailuracode/alpine-theme").ThemeStore;
            sidebar: import("@ailuracode/alpine-sidebar").SidebarStore;
            scroll: import("@ailuracode/alpine-scroll").ScrollStore;
            dialog: import("@ailuracode/alpine-dialog").DialogStore;
            menu: import("@ailuracode/alpine-menu").MenuStore;
        }

        interface Magics<T> {
            $theme: import("@ailuracode/alpine-theme").ThemeStore;
            $sidebar: import("@ailuracode/alpine-sidebar").SidebarStore;
            $dialog: import("@ailuracode/alpine-dialog").DialogStore;
            $menu: import("@ailuracode/alpine-menu").MenuStore;
        }
    }
}

declare global {
    interface Window {
        Alpine: AlpineInstance;
        Passkeys: typeof import("@laravel/passkeys").Passkeys;
        bladcnOnAlpine(callback: (Alpine: AlpineInstance) => void): void;
        bladcnRegister(
            name: string,
            factory: (config?: Record<string, unknown>) => Record<string, unknown>,
        ): void;
        bladcnRegisterMenu(
            id: string,
            options?: import("@ailuracode/alpine-menu").MenuInstanceOptions,
        ): void;
    }

    function bladcnOnAlpine(callback: (Alpine: AlpineInstance) => void): void;
    function bladcnRegister(
        name: string,
        factory: (config?: Record<string, unknown>) => Record<string, unknown>,
    ): void;
    function bladcnRegisterMenu(
        id: string,
        options?: import("@ailuracode/alpine-menu").MenuInstanceOptions,
    ): void;
}

export {};
