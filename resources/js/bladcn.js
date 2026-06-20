/**
 * Register Alpine.data factories on first load and after wire:navigate.
 * Load this file from resources/js/app.js: import './bladcn';
 * Helpers are also registered on demand via @pushOnce('bladcn-scripts') in UI components.
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

bladcnRegister("bladcnDialog", (config = {}) => ({
  isOpen: config.open ?? false,

  open() {
    this.isOpen = true;
    document.body.classList.add("overflow-hidden");
  },

  close() {
    this.isOpen = false;
    document.body.classList.remove("overflow-hidden");
  },
}));

const ALERT_DIALOG_CLOSE_DURATION = 300;

bladcnRegister("bladcnAlertDialog", (config = {}) => ({
  isOpen: config.open ?? false,
  isPresent: config.open ?? false,
  animationState: config.open ? "open" : "closed",
  isClosing: false,
  closeTimer: null,

  open() {
    clearTimeout(this.closeTimer);
    this.isClosing = false;
    this.isOpen = true;
    this.isPresent = true;
    this.animationState = "closed";
    window.bladcnBodyScrollLock?.lock();

    this.$nextTick(() => {
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          this.animationState = "open";
        });
      });
    });
  },

  close() {
    if (!this.isPresent) {
      return;
    }

    clearTimeout(this.closeTimer);
    this.isClosing = true;
    this.isOpen = false;
    this.animationState = "closed";

    this.closeTimer = setTimeout(() => {
      this.isPresent = false;
      this.isClosing = false;
      window.bladcnBodyScrollLock?.unlock();
    }, ALERT_DIALOG_CLOSE_DURATION);
  },
}));

if (!window.bladcnBodyScrollLock) {
  window.bladcnBodyScrollLock = {
    count: 0,
    originalPaddingRight: "",

    getScrollbarWidth() {
      return Math.max(0, window.innerWidth - document.documentElement.clientWidth);
    },

    lock() {
      this.count += 1;

      if (this.count !== 1) {
        return;
      }

      this.originalPaddingRight = document.body.style.paddingRight;

      const scrollbarWidth = this.getScrollbarWidth();

      if (scrollbarWidth > 0) {
        const currentPadding =
          Number.parseFloat(window.getComputedStyle(document.body).paddingRight) || 0;

        document.body.style.paddingRight = `${currentPadding + scrollbarWidth}px`;
      }

      document.body.classList.add("overflow-hidden");
    },

    unlock() {
      this.count = Math.max(0, this.count - 1);

      if (this.count !== 0) {
        return;
      }

      document.body.classList.remove("overflow-hidden");
      document.body.style.paddingRight = this.originalPaddingRight;
    },
  };
}
