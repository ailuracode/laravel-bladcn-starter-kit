/**
 * Register Alpine.data factories on first load and after wire:navigate.
 * Load this file from resources/js/app.ts: import './bladcn';
 * Helpers are also registered on demand via @pushOnce('bladcn-scripts') in UI components.
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

bladcnRegister("bladcnDialog", (config: { open?: boolean } = {}) => ({
  isOpen: config.open ?? false,

  open() {
    this.isOpen = true;
    window.Alpine.store("scroll").lock();
  },

  close() {
    this.isOpen = false;
    window.Alpine.store("scroll").unlock();
  },
}));

const ALERT_DIALOG_CLOSE_DURATION = 300;

interface AlertDialogContext {
  isOpen: boolean;
  isPresent: boolean;
  animationState: string;
  isClosing: boolean;
  closeTimer: ReturnType<typeof setTimeout> | null;
  $nextTick(callback: () => void): void;
  $store: Alpine.Stores;
}

bladcnRegister("bladcnAlertDialog", (config: { open?: boolean } = {}) => ({
  isOpen: config.open ?? false,
  isPresent: config.open ?? false,
  animationState: config.open ? "open" : "closed",
  isClosing: false,
  closeTimer: null as ReturnType<typeof setTimeout> | null,

  open(this: AlertDialogContext) {
    clearTimeout(this.closeTimer ?? undefined);
    this.isClosing = false;
    this.isOpen = true;
    this.isPresent = true;
    this.animationState = "closed";
    this.$store.scroll.lock();

    this.$nextTick(() => {
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          this.animationState = "open";
        });
      });
    });
  },

  close(this: AlertDialogContext) {
    if (!this.isPresent) {
      return;
    }

    clearTimeout(this.closeTimer ?? undefined);
    this.isClosing = true;
    this.isOpen = false;
    this.animationState = "closed";

    this.closeTimer = setTimeout(() => {
      this.isPresent = false;
      this.isClosing = false;
      this.$store.scroll.unlock();
    }, ALERT_DIALOG_CLOSE_DURATION);
  },
}));

import { registerScrollArea } from "./scroll-area";

registerScrollArea();
