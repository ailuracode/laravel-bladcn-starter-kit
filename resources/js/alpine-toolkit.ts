import scrollPlugin, { scrollOptions } from "@ailuracode/alpine-scroll";
import themePlugin from "@ailuracode/alpine-theme";
import type { ThemeResolved } from "@ailuracode/alpine-theme";
import type { AlpineInstance } from "./types/alpine";
import { registerSidebarPlugin, registerSidebarProvider, registerSidebarResponsiveCleanup } from "./sidebar";

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

  Alpine.plugin(
    scrollPlugin(
      scrollOptions({
        onLockChange(locked) {
          document.documentElement.toggleAttribute("data-scroll-locked", locked);
        },
      }),
    ),
  );
  Alpine.plugin(registerSidebarPlugin);
  registerSidebarResponsiveCleanup(Alpine);
  registerSidebarProvider(Alpine);
  Alpine.plugin(registerThemePlugin);
  registerThemeNavigateSync(Alpine);

  pluginsInitialized = true;
}
