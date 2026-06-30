/// <reference types="alpinejs" />

import type { AlpineInstance } from "./types/alpine";

declare module "alpinejs" {
    namespace Alpine {
        interface Stores {
            theme: import("@ailuracode/alpine-theme").ThemeStore;
            sidebar: import("@ailuracode/alpine-sidebar").SidebarStore;
            scroll: import("@ailuracode/alpine-scroll").ScrollStore;
        }

        interface Magics<T> {
            $theme: import("@ailuracode/alpine-theme").ThemeStore;
            $sidebar: import("@ailuracode/alpine-sidebar").SidebarStore;
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
    }

    function bladcnOnAlpine(callback: (Alpine: AlpineInstance) => void): void;
    function bladcnRegister(
        name: string,
        factory: (config?: Record<string, unknown>) => Record<string, unknown>,
    ): void;
}

export {};
