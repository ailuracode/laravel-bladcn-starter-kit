import type { ScrollStore } from "@ailuracode/alpine-scroll";

const WRAPPER = '[data-slot="sidebar-wrapper"]';
const supportsStableScrollbarGutter =
    typeof CSS !== "undefined" && CSS.supports("scrollbar-gutter", "stable");

let snapshot: {
    el: HTMLElement;
    htmlBackground: string;
    htmlScrollbarGutter: string;
    paddingRight: string;
    boxSizing: string;
} | null = null;

function measureScrollbarWidth(): number {
    const live = Math.max(0, window.innerWidth - document.documentElement.clientWidth);

    if (live > 0) {
        return live;
    }

    const probe = document.createElement("div");
    probe.style.cssText =
        "position:absolute;top:-9999px;width:100px;height:100px;overflow:scroll;visibility:hidden";
    document.body.appendChild(probe);
    const width = probe.offsetWidth - probe.clientWidth;
    probe.remove();

    return width;
}

function cacheScrollbarWidth(): void {
    const width = measureScrollbarWidth();

    if (width > 0) {
        cachedScrollbarWidth = width;
    }
}

let cachedScrollbarWidth = measureScrollbarWidth();

export function applyScrollLockCompensation(): void {
    if (snapshot) {
        return;
    }

    const width = measureScrollbarWidth() || cachedScrollbarWidth;
    const html = document.documentElement;
    const el = document.querySelector<HTMLElement>(WRAPPER) ?? document.body;

    snapshot = {
        el,
        htmlBackground: html.style.backgroundColor,
        htmlScrollbarGutter: html.style.scrollbarGutter,
        paddingRight: el.style.paddingRight,
        boxSizing: el.style.boxSizing,
    };

    html.style.backgroundColor = getComputedStyle(document.body).backgroundColor;

    if (supportsStableScrollbarGutter) {
        html.style.scrollbarGutter = "stable";
    }

    if (width <= 0) {
        return;
    }

    cachedScrollbarWidth = width;

    if (supportsStableScrollbarGutter) {
        return;
    }

    const pad = Number.parseFloat(getComputedStyle(el).paddingRight) || 0;
    el.style.boxSizing = "border-box";
    el.style.paddingRight = `${pad + width}px`;
}

export function removeScrollLockCompensation(): void {
    if (!snapshot) {
        return;
    }

    const html = document.documentElement;
    const { el, htmlBackground, htmlScrollbarGutter, paddingRight, boxSizing } = snapshot;

    html.style.backgroundColor = htmlBackground;
    html.style.scrollbarGutter = htmlScrollbarGutter;
    el.style.paddingRight = paddingRight;
    el.style.boxSizing = boxSizing;
    snapshot = null;
    cacheScrollbarWidth();
}

/** Apply gutter compensation before lock styles run; remove it before the last unlock restores body. */
export function patchScrollStoreWithCompensation(store: ScrollStore): void {
    const originalLock = store.lock.bind(store);
    const originalUnlock = store.unlock.bind(store);
    let nestedLocks = 0;

    store.lock = () => {
        if (nestedLocks === 0) {
            applyScrollLockCompensation();
        }

        nestedLocks++;
        return originalLock();
    };

    store.unlock = () => {
        if (nestedLocks <= 0) {
            return originalUnlock();
        }

        nestedLocks--;

        if (nestedLocks === 0) {
            removeScrollLockCompensation();
        }

        return originalUnlock();
    };
}

if (typeof window !== "undefined") {
    document.addEventListener("livewire:navigated", cacheScrollbarWidth);
}
