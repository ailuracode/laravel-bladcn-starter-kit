import dialogPlugin, { dialogOptions } from "@ailuracode/alpine-dialog";
import menuPlugin, { menuOptions } from "@ailuracode/alpine-menu";
import scrollPlugin, { scrollOptions } from "@ailuracode/alpine-scroll";
import anchor from "@alpinejs/anchor";
import type { ScrollStore } from "@ailuracode/alpine-scroll";
import themePlugin from "@ailuracode/alpine-theme";
import type { ThemeResolved } from "@ailuracode/alpine-theme";
import type { MenuInstanceOptions } from "@ailuracode/alpine-menu";
import type { AlpineInstance } from "./types/alpine";
import { patchMenuStoreUiEvents, registerMenuGlobalHandlers, registerMenuInstance } from "./menu-helpers";
import { registerSidebarPlugin, registerSidebarProvider, registerSidebarResponsiveCleanup } from "./sidebar";
import { setScrollLockState } from "./scroll-lock-compensation";

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
  Alpine.plugin(
    scrollPlugin(
      scrollOptions({
        onLockChange(locked) {
          setScrollLockState(locked);
        },
      }),
    ),
  );
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
