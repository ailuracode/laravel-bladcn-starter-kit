import scrollPlugin from "@ailuracode/alpine-scroll";
import themePlugin from "@ailuracode/alpine-theme";
import type { AlpineInstance } from "./types/alpine";
import { registerSidebarPlugin, registerSidebarProvider, registerSidebarResponsiveCleanup } from "./sidebar";
import { themePluginOptions } from "./theme";

let pluginsInitialized = false;

/** Register @ailuracode/alpine-* plugins before Livewire.start(). */
export function initAiluracodeAlpinePlugins(Alpine: AlpineInstance): void {
  if (pluginsInitialized) {
    return;
  }

  Alpine.plugin(scrollPlugin());
  Alpine.plugin(registerSidebarPlugin);
  registerSidebarResponsiveCleanup(Alpine);
  registerSidebarProvider(Alpine);
  Alpine.plugin(themePlugin(themePluginOptions));

  pluginsInitialized = true;
}
