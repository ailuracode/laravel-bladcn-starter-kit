import { dialogPlugin } from "@ailuracode/alpine-dialog";

let dialogPluginsInitialized = false;

/** Registers `$store.dialog` — requires `$store.scroll` from registerScrollPlugin first. */
export function registerDialogPlugins(alpine = window.Alpine) {
    if (dialogPluginsInitialized || typeof alpine === "undefined") {
        return;
    }

    alpine.plugin(
        dialogPlugin({
            scroll: alpine.store("scroll"),
        }),
    );

    dialogPluginsInitialized = true;
}

const boot = () => {
    if (typeof window.Alpine === "undefined") {
        document.addEventListener("alpine:init", () => registerDialogPlugins(), {
            once: true,
        });

        return;
    }

    registerDialogPlugins();
};

boot();
