/**
 * Stubs for Alpine IntelliSense inside Blade templates.
 *
 * Not imported at runtime — registration happens in alpine-toolkit.ts and component blades.
 * The Alpine.js IntelliSense extension scans this file for Alpine.store / Alpine.data signatures.
 *
 * @see https://marketplace.visualstudio.com/items?itemName=AdrianWilczynski.alpine-js-intellisense
 */
import type { ThemeStore } from "@ailuracode/alpine-theme";
import type { AlpineInstance } from "./types/alpine";

/** @internal IDE-only — do not call. */
export function __alpineBladeIntellisenseStubs(Alpine: AlpineInstance): void {
  Alpine.store("theme", {} as ThemeStore);
  Alpine.store("sidebar", {} as import("@ailuracode/alpine-sidebar").SidebarStore);
  Alpine.store("scroll", {} as import("@ailuracode/alpine-scroll").ScrollStore);

  Alpine.data("bladcnSidebarProvider", () => ({
    expanded: true,
    toggleExpanded() {},
  }));

  Alpine.data("bladcnDialog", (_config: { open?: boolean } = {}) => ({
    isOpen: false,
    open() {},
    close() {},
  }));

  Alpine.data("bladcnAlertDialog", (_config: { open?: boolean } = {}) => ({
    isOpen: false,
    isPresent: false,
    animationState: "closed" as "open" | "closed",
    isClosing: false,
    open() {},
    close() {},
  }));

  Alpine.data("bladcnDropdownMenu", (_config: Record<string, unknown> = {}) => ({
    isOpen: false,
    checkboxes: {} as Record<string, boolean>,
    radioValue: null as string | null,
    toggle(_event?: Event) {},
    open(_event?: Event) {},
    close() {},
  }));

  Alpine.data("bladcnDropdownMenuSub", () => ({
    isOpen: false,
    open() {},
    close() {},
  }));

  Alpine.data("bladcnAvatar", () => ({
    imageLoaded: false,
    imageFailed: false,
  }));

  Alpine.data("bladcnInputOtp", (_config: Record<string, unknown> = {}) => ({
    value: "",
    focusIndex: 0,
  }));

  Alpine.data("bladcnSonner", (_config: Record<string, unknown> = {}) => ({
    toasts: [] as unknown[],
  }));

  Alpine.data("teamSwitcher", (_teams: unknown[] = []) => ({
    open: false,
    teams: [] as unknown[],
    activeTeam: null as unknown,
  }));
}
