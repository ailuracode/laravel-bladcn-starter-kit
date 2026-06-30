/**
 * Register Alpine.data factories on first load and after wire:navigate.
 * Load this file from resources/js/app.ts: import './bladcn';
 * Component factories are registered on demand via @pushOnce('bladcn-scripts') in UI blades.
 *
 * @ailuracode/alpine-* plugins (theme, …) are registered in alpine-toolkit.ts before Livewire.start().
 */
window.bladcnOnAlpine =
  window.bladcnOnAlpine ??
  ((callback) => {
    const run = () => {
      if (typeof window.Alpine === "undefined") {
        return;
      }

      callback(window.Alpine);
    };

    if (typeof window.Alpine !== "undefined") {
      run();

      return;
    }

    document.addEventListener("alpine:init", run, { once: true });
  });

window.bladcnRegister =
  window.bladcnRegister ??
  ((name, factory) => {
    bladcnOnAlpine((Alpine) => {
      Alpine.data(name, factory);
    });
  });

import { registerScrollArea } from "./scroll-area";

registerScrollArea();
