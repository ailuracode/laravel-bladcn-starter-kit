import sidebarPlugin, { sidebarOptions } from "@ailuracode/alpine-sidebar";
import type { ScrollStore } from "@ailuracode/alpine-scroll";
import type { SidebarPluginOptions, SidebarStore } from "@ailuracode/alpine-sidebar";
import type { AlpineInstance } from "./types/alpine";

/** localStorage key for desktop sidebar expanded (compact when `false`). */
export const SIDEBAR_EXPANDED_STORAGE_KEY = "sidebar-expanded";

export function readSidebarExpanded(): boolean {
  try {
    return localStorage.getItem(SIDEBAR_EXPANDED_STORAGE_KEY) !== "false";
  } catch {
    return true;
  }
}

export function writeSidebarExpanded(expanded: boolean): void {
  try {
    localStorage.setItem(SIDEBAR_EXPANDED_STORAGE_KEY, String(expanded));
  } catch {
    // Private browsing or blocked storage — ignore.
  }
}

/** Width transition duration — must match sidebar `duration-200` utilities. */
export const SIDEBAR_TRANSITION_MS = 200;

export function syncSidebarExpandedDom(expanded: boolean): void {
  document.documentElement.toggleAttribute("data-sidebar-collapsed", !expanded);
  window.dispatchEvent(new CustomEvent("bladcn:sidebar-layout"));
}

/** Desktop layout breakpoint — matches Tailwind `md`. */
export const DESKTOP_SIDEBAR_BREAKPOINT = "(min-width: 768px)";

function isDesktopSidebar(): boolean {
  return window.matchMedia(DESKTOP_SIDEBAR_BREAKPOINT).matches;
}

function scrollStore(): ScrollStore | undefined {
  return window.Alpine?.store("scroll") as ScrollStore | undefined;
}

/**
 * @see https://github.com/ailuracode/alpinejs-toolkit/blob/master/docs/plugins/sidebar.md
 */
export const sidebarPluginOptions: SidebarPluginOptions = sidebarOptions({
  breakpoint: DESKTOP_SIDEBAR_BREAKPOINT,
  closeOnEscape: true,
  closeOnOverlayClick: true,
  onShow() {
    document.documentElement.setAttribute("data-sidebar", "");
    document.documentElement.style.scrollbarGutter = "stable";

    if (!isDesktopSidebar()) {
      scrollStore()?.lock();
    }
  },
  onHide() {
    document.documentElement.removeAttribute("data-sidebar");
    document.documentElement.style.scrollbarGutter = "";

    if (!isDesktopSidebar()) {
      scrollStore()?.unlock();
    }
  },
});

export const registerSidebarPlugin = sidebarPlugin(sidebarPluginOptions);

/** Hide the mobile drawer when crossing into the desktop breakpoint (clears scroll lock). */
export function registerSidebarResponsiveCleanup(Alpine: AlpineInstance): void {
  const mediaQuery = window.matchMedia(DESKTOP_SIDEBAR_BREAKPOINT);

  mediaQuery.addEventListener("change", (event) => {
    if (!event.matches) {
      return;
    }

    const sidebar = Alpine.store("sidebar") as SidebarStore;

    if (sidebar.visible) {
      sidebar.hide();
    }
  });
}

/** Alpine state for `<x-ui.sidebar.provider>` — persists desktop expanded/collapsed. */
export function registerSidebarProvider(Alpine: AlpineInstance): void {
  Alpine.data("bladcnSidebarProvider", () => ({
    expanded: readSidebarExpanded(),

    init() {
      syncSidebarExpandedDom(this.expanded);
      this.syncSidebarGroupDom();

      this.$watch("expanded", (value: boolean) => {
        writeSidebarExpanded(value);
        syncSidebarExpandedDom(value);
        this.syncSidebarGroupDom();
      });

      // Release button/menu FOUC guard after Alpine bindings are active.
      this.$nextTick(() => {
        document.documentElement.setAttribute("data-alpine-initialized", "");
      });
    },

    syncSidebarGroupDom() {
      const sidebar = this.$el.querySelector('[data-slot="sidebar"]');

      if (!sidebar) {
        return;
      }

      const desktop = window.matchMedia(DESKTOP_SIDEBAR_BREAKPOINT).matches;

      if (!this.expanded && desktop) {
        sidebar.setAttribute("data-state", "collapsed");
        sidebar.setAttribute("data-collapsible", "icon");
      } else if (desktop) {
        sidebar.setAttribute("data-state", "expanded");
        sidebar.removeAttribute("data-collapsible");
      }
    },

    toggleExpanded() {
      this.expanded = !this.expanded;
    },
  }));
}
