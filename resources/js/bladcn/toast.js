import toastPlugin, {
    createToastMagic,
    resolveToastPluginConfig,
    toastOptions,
} from "@ailuracode/alpine-toast";

import { SONNER_POSITIONS, SONNER_VARIANTS } from "./config";

export const toastPluginOptions = toastOptions({
    variants: SONNER_VARIANTS,
    positions: SONNER_POSITIONS,
    defaultPosition: "bottom-right",
    defaultDuration: 4000,
    maxToasts: 5,
    maxVisible: 3,
    listenToWindowEvents: true,
    promise: {
        loadingVariant: "loading",
        successVariant: "success",
        errorVariant: "destructive",
    },
});

const resolvedToastConfig = resolveToastPluginConfig(toastPluginOptions);

/** Register the headless toast queue and imperative `window.bladcnToast` bridge. */
export const registerBladcnSonnerToast = (Alpine) => {
    Alpine.plugin(toastPlugin(toastPluginOptions));

    const toast = createToastMagic(resolvedToastConfig, () => Alpine.store("toast"));

    const fromPayload = (payload = {}) => {
        const variant =
            payload.variant === "error" ? "destructive" : (payload.variant ?? "default");

        return toast.fromPayload({ ...payload, variant });
    };

    window.bladcnToast = Object.assign(
        (titleOrPayload, options = {}) => toast(titleOrPayload, options),
        {
            success: toast.success,
            info: toast.info,
            warning: toast.warning,
            error: toast.destructive,
            fromPayload,
            promise: toast.promise,
            dismiss: toast.dismiss,
            update: toast.update,
            dismissAt: toast.dismissAt,
            dismissAll: toast.dismissAll,
        },
    );
};
