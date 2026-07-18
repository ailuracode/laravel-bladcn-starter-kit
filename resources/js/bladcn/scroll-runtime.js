import { scrollPlugin } from "@ailuracode/alpine-scroll";

const SIDEBAR_WRAPPER_SELECTOR = '[data-slot="sidebar-wrapper"]';

let scrollPluginInitialized = false;

/** Registers `$store.scroll` and `$scroll` via @ailuracode/alpine-scroll. */
export function registerScrollPlugin(Alpine) {
    if (scrollPluginInitialized) {
        return;
    }

    Alpine.plugin(
        scrollPlugin({
            reserveScrollbarGap: true,
            target: SIDEBAR_WRAPPER_SELECTOR,
        }),
    );

    scrollPluginInitialized = true;
}

/**
 * Maps boolean lock events (e.g. menu overlay) to `$store.scroll` handles.
 * @param {import("@ailuracode/alpine-scroll").ScrollStore} scroll
 */
export function createScrollLockHandler(scroll) {
    /** @type {string | null} */
    let handle = null;

    return (locked) => {
        if (locked) {
            handle = scroll.lock("menu");

            return;
        }

        if (handle !== null) {
            scroll.unlock(handle);
            handle = null;
        }
    };
}
