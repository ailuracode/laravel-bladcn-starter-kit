const WRAPPER = '[data-slot="sidebar-wrapper"]';

let snapshot: {
  el: HTMLElement;
  htmlBackground: string;
  paddingRight: string;
  boxSizing: string;
} | null = null;

let scrollbarWidth = Math.max(0, window.innerWidth - document.documentElement.clientWidth);

function cacheScrollbarWidth(): void {
  const width = window.innerWidth - document.documentElement.clientWidth;

  if (width > 0) {
    scrollbarWidth = width;
  }
}

export function setScrollLockState(locked: boolean): void {
  if (!locked) {
    if (!snapshot) {
      cacheScrollbarWidth();

      return;
    }

    const html = document.documentElement;
    const { el, htmlBackground, paddingRight, boxSizing } = snapshot;

    html.style.backgroundColor = htmlBackground;
    el.style.paddingRight = paddingRight;
    el.style.boxSizing = boxSizing;
    snapshot = null;
    cacheScrollbarWidth();

    return;
  }

  if (snapshot) {
    return;
  }

  const html = document.documentElement;
  const el = document.querySelector<HTMLElement>(WRAPPER) ?? document.body;

  snapshot = {
    el,
    htmlBackground: html.style.backgroundColor,
    paddingRight: el.style.paddingRight,
    boxSizing: el.style.boxSizing,
  };

  html.style.backgroundColor = getComputedStyle(document.body).backgroundColor;

  if (scrollbarWidth === 0) {
    return;
  }

  const pad = Number.parseFloat(getComputedStyle(el).paddingRight) || 0;
  el.style.boxSizing = "border-box";
  el.style.paddingRight = `${pad + scrollbarWidth}px`;
}
