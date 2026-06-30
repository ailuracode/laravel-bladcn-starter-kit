import dialogPlugin, { dialogOptions } from "@ailuracode/alpine-dialog";
import type { MenuInstanceOptions } from "@ailuracode/alpine-menu";
import menuPlugin, { menuOptions } from "@ailuracode/alpine-menu";
import scrollPlugin from "@ailuracode/alpine-scroll";
import type { ThemeResolved } from "@ailuracode/alpine-theme";
import themePlugin from "@ailuracode/alpine-theme";
import anchor from "@alpinejs/anchor";
import {
    patchMenuStoreUiEvents,
    registerMenuGlobalHandlers,
    registerMenuInstance,
} from "./menu-helpers";
import { patchScrollStoreWithCompensation } from "./scroll-lock-compensation";
import {
    registerSidebarPlugin,
    registerSidebarProvider,
    registerSidebarResponsiveCleanup,
} from "./sidebar";
import type { AlpineInstance } from "./types/alpine";

function applyResolvedTheme(resolved: ThemeResolved): void {
    document.documentElement.classList.toggle("dark", resolved === "dark");
    document.documentElement.style.colorScheme = resolved;
}

const registerThemePlugin = themePlugin({
    storageKey: "theme",
    onChange: ({ resolved }) => applyResolvedTheme(resolved),
});

let pluginsInitialized = false;
let themeNavigateSyncRegistered = false;

/** Re-apply theme after wire:navigate morphs `<html>` (inline head script only runs on full load). */
function registerThemeNavigateSync(Alpine: AlpineInstance): void {
    if (themeNavigateSyncRegistered) {
        return;
    }

    const sync = () => {
        applyResolvedTheme(Alpine.store("theme").resolved);
    };

    document.addEventListener("livewire:navigated", sync);

    document.addEventListener("livewire:navigating", (event) => {
        const navigating = event as CustomEvent<{
            onSwap?: (callback: () => void) => void;
        }>;

        navigating.detail.onSwap?.(sync);
    });

    themeNavigateSyncRegistered = true;
}

/** Register @ailuracode/alpine-* plugins before Livewire.start(). */
export function initAiluracodeAlpinePlugins(Alpine: AlpineInstance): void {
    if (pluginsInitialized) {
        return;
    }

    Alpine.plugin(anchor);
    Alpine.plugin(scrollPlugin());
    patchScrollStoreWithCompensation(Alpine.store("scroll"));
    Alpine.plugin(
        dialogPlugin(
            dialogOptions({
                onLockChange(locked) {
                    const scroll = Alpine.store("scroll");
                    locked ? scroll.lock() : scroll.unlock();
                },
            }),
        ),
    );
    Alpine.plugin(
        menuPlugin(
            menuOptions({
                onLockChange(locked) {
                    const scroll = Alpine.store("scroll");
                    locked ? scroll.lock() : scroll.unlock();
                },
            }),
        ),
    );

    window.bladcnRegisterMenu = (id: string, options: MenuInstanceOptions = {}) => {
        registerMenuInstance(Alpine.store("menu"), id, options);
    };

    patchMenuStoreUiEvents(Alpine.store("menu"));
    registerMenuGlobalHandlers(Alpine);
    Alpine.plugin(registerSidebarPlugin);
    registerSidebarResponsiveCleanup(Alpine);
    registerSidebarProvider(Alpine);
    Alpine.plugin(registerThemePlugin);
    registerThemeNavigateSync(Alpine);

    pluginsInitialized = true;
}
