import { toastPositions, toastVariants } from "@ailuracode/alpine-toast";

/** Shared layout breakpoints — align with Tailwind `md` and sidebar provider. */
export const DESKTOP_MIN_WIDTH_PX = 768;

export const DESKTOP_MEDIA_QUERY = `(min-width: ${DESKTOP_MIN_WIDTH_PX}px)`;

/** Matches `$store.media` + sidebar mobile drawer (below Tailwind `md`). */
export const SIDEBAR_MOBILE_MEDIA_QUERY = `(max-width: ${DESKTOP_MIN_WIDTH_PX - 1}px)`;

/** Two-tier intervals so `breakpoint === 'desktop'` matches CSS `md:`. */
export const MEDIA_INTERVALS = [
    { name: "mobile", maxWidth: DESKTOP_MIN_WIDTH_PX - 1 },
    { name: "desktop", maxWidth: Number.POSITIVE_INFINITY },
];

export const SONNER_POSITIONS = toastPositions([
    "top-left",
    "top-center",
    "top-right",
    "bottom-left",
    "bottom-center",
    "bottom-right",
]);

export const SONNER_VARIANTS = toastVariants([
    "success",
    "info",
    "warning",
    "destructive",
    "loading",
]);
