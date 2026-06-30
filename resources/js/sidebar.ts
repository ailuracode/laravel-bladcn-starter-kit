import type { ScrollStore } from "@ailuracode/alpine-scroll";
import type { SidebarPluginOptions, SidebarStore } from "@ailuracode/alpine-sidebar";
import sidebarPlugin, { sidebarOptions } from "@ailuracode/alpine-sidebar";
import type { AlpineInstance } from "./types/alpine";

/** localStorage key for desktop sidebar expanded (compact when `false`). */
export const SIDEBAR_EXPANDED_STORAGE_KEY = "sidebar-expanded";

/** Mobile drawer close animation — must match sidebar `duration-300` utilities. */
export const SIDEBAR_MOBILE_CLOSE_MS = 300;

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
 * Scroll lock composition — same pattern as apps/demo/src/demo/plugin-registry.ts
 * @see https://github.com/ailuracode/alpinejs-toolkit/blob/master/docs/plugins/scroll.md
 */
export const sidebarPluginOptions: SidebarPluginOptions = sidebarOptions({
    breakpoint: DESKTOP_SIDEBAR_BREAKPOINT,
    closeOnEscape: true,
    closeOnOverlayClick: true,
    onShow() {
        document.documentElement.setAttribute("data-sidebar", "");

        if (isDesktopSidebar()) {
            document.documentElement.style.scrollbarGutter = "stable";
        } else {
            // `axis: 'both'` fixes body in place — overflow-only lock breaks `fixed` overlays on body.
            scrollStore()?.lock({ axis: "both" });
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

interface SidebarProviderContext {
    expanded: boolean;
    mobilePresent: boolean;
    mobileAnimationState: "open" | "closed";
    mobileClosing: boolean;
    mobileCloseTimer: ReturnType<typeof setTimeout> | null;
    $el: HTMLElement;
    $nextTick(callback: () => void): void;
    $store: { sidebar: SidebarStore };
    openMobile(): void;
    finishMobileClose(options?: { hideStore?: boolean }): void;
    syncSidebarGroupDom(): void;
}

/** Alpine state for `<x-ui.sidebar.provider>` — desktop expand/collapse + mobile drawer animation. */
export function registerSidebarProvider(Alpine: AlpineInstance): void {
    Alpine.data("bladcnSidebarProvider", () => ({
        expanded: readSidebarExpanded(),
        mobilePresent: false,
        mobileAnimationState: "closed" as "open" | "closed",
        mobileClosing: false,
        mobileCloseTimer: null as ReturnType<typeof setTimeout> | null,

        init(
            this: SidebarProviderContext & {
                $watch: (source: unknown, callback: (value: boolean) => void) => void;
            },
        ) {
            syncSidebarExpandedDom(this.expanded);
            this.syncSidebarGroupDom();

            this.$watch("expanded", (value: boolean) => {
                writeSidebarExpanded(value);
                syncSidebarExpandedDom(value);
                this.syncSidebarGroupDom();
            });

            this.$watch(
                () => this.$store.sidebar.visible,
                (visible: boolean) => {
                    if (this.$store.sidebar.matchesBreakpoint) {
                        return;
                    }

                    if (visible) {
                        this.openMobile();

                        return;
                    }

                    if (this.mobilePresent && !this.mobileClosing) {
                        this.finishMobileClose();
                    }
                },
            );

            this.$watch(
                () => this.$store.sidebar.matchesBreakpoint,
                (matches: boolean) => {
                    if (!matches) {
                        return;
                    }

                    clearTimeout(this.mobileCloseTimer ?? undefined);
                    this.mobilePresent = false;
                    this.mobileAnimationState = "closed";
                    this.mobileClosing = false;

                    if (this.$store.sidebar.visible) {
                        this.$store.sidebar.hide();
                    }
                },
            );

            this.$nextTick(() => {
                document.documentElement.setAttribute("data-alpine-initialized", "");
            });
        },

        destroy(this: SidebarProviderContext) {
            clearTimeout(this.mobileCloseTimer ?? undefined);
        },

        openMobile(this: SidebarProviderContext) {
            clearTimeout(this.mobileCloseTimer ?? undefined);
            this.mobileClosing = false;
            this.mobilePresent = true;
            this.mobileAnimationState = "closed";

            this.$nextTick(() => {
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        this.mobileAnimationState = "open";
                    });
                });
            });
        },

        finishMobileClose(
            this: SidebarProviderContext,
            { hideStore = false }: { hideStore?: boolean } = {},
        ) {
            if (!this.mobilePresent || this.mobileClosing) {
                return;
            }

            clearTimeout(this.mobileCloseTimer ?? undefined);
            this.mobileClosing = true;
            this.mobileAnimationState = "closed";

            this.mobileCloseTimer = setTimeout(() => {
                if (hideStore && this.$store.sidebar.visible) {
                    this.$store.sidebar.hide();
                }

                this.mobilePresent = false;
                this.mobileClosing = false;
            }, SIDEBAR_MOBILE_CLOSE_MS);
        },

        closeMobileSidebar(this: SidebarProviderContext) {
            this.finishMobileClose({ hideStore: true });
        },

        handleMobileNavClick(this: SidebarProviderContext, event: Event) {
            if (this.$store.sidebar.matchesBreakpoint || !this.$store.sidebar.visible) {
                return;
            }

            const target = event.target;

            if (!(target instanceof Element)) {
                return;
            }

            if (target.closest("a[href]:not([target=_blank]), button[type=submit]")) {
                this.$store.sidebar.hide();
            }
        },

        syncSidebarGroupDom(this: SidebarProviderContext) {
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

        toggleExpanded(this: SidebarProviderContext) {
            this.expanded = !this.expanded;
        },
    }));
}
