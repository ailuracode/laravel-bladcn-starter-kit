import { Alpine, Livewire } from "./livewire";

import accordion from "@ailuracode/alpine-accordion";
import media from "@ailuracode/alpine-media";
import sidebar from "@ailuracode/alpine-sidebar";
import theme from "@ailuracode/alpine-theme";
import anchor from "@alpinejs/anchor";
import collapse from "@alpinejs/collapse";
import scroll from "@ailuracode/alpine-scroll";

import { MEDIA_INTERVALS, SIDEBAR_MOBILE_MEDIA_QUERY } from "./bladcn/config";
import { registerBladcnSonnerToast } from "./bladcn/toast";

Alpine.plugin([
    anchor,
    collapse,
    scroll({ target: '[data-slot="sidebar-wrapper"]' }),
    accordion(),
    media({ intervals: MEDIA_INTERVALS }),
    theme({
        reapplyEvents: ["livewire:navigated", "livewire:navigating"],
    }),
]);

Alpine.plugin([
    sidebar({
        closeOnEscape: true,
        breakpoint: {
            query: SIDEBAR_MOBILE_MEDIA_QUERY,
            onMismatch: "hide",
        },
        scroll: Alpine.store("scroll"),
    }),
]);

registerBladcnSonnerToast(Alpine);

Livewire.start();
