import { createCombobox } from "@ailuracode/alpine-combobox";

/** Registers `bladcnCombobox` Alpine.data — headless state via `$combobox`, change event at component level. */
export function registerBladcnCombobox(Alpine, lockScroll) {
    if (Alpine.data("bladcnCombobox")) {
        return;
    }

    Alpine.data("bladcnCombobox", (config = {}) => {
        const api = createCombobox({
            defaultValue: config.defaultValue ?? null,
            defaultLabel: config.defaultLabel ?? null,
            disabled: config.disabled ?? false,
            lockScroll,
        });

        const applySelection = api.select.bind(api);

        return Object.assign(api, {
            select(value, label) {
                applySelection(value, label);

                const host = this.$el.parentElement ?? this.$el;

                host?.dispatchEvent(
                    new CustomEvent("change", {
                        detail: { value, label },
                        bubbles: true,
                        composed: true,
                    }),
                );
            },
        });
    });
}
