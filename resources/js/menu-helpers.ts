import type { MenuInstanceOptions, MenuStore } from "@ailuracode/alpine-menu";
import type { AlpineInstance } from "./types/alpine";

let globalHandlersRegistered = false;
let storePatched = false;

export const MENU_OPEN_EVENT = "bladcn:menu-open";
export const MENU_CLOSE_EVENT = "bladcn:menu-close";
export const MENU_ACTIVE_EVENT = "bladcn:menu-active";

const MENU_NAVIGATION_KEYS = new Set([
  "ArrowUp",
  "ArrowDown",
  "ArrowLeft",
  "ArrowRight",
  "Home",
  "End",
  "Enter",
  " ",
]);

/** Shared keyboard-navigation key check for menu Alpine components. */
export function isMenuNavigationKey(key: string): boolean {
  return MENU_NAVIGATION_KEYS.has(key);
}

type MenuSubComponent = {
  isSubOpen?: boolean;
  handleKeydown?: (event: KeyboardEvent) => boolean;
};

type MenuRootComponent = {
  panelOpen?: boolean;
  menusOpen?: Record<string, boolean>;
  handleKeydown?: (event: KeyboardEvent) => void;
};

function delegateToOpenSubs(
  Alpine: AlpineInstance,
  event: KeyboardEvent,
  subSlot: string,
): boolean {
  for (const element of document.querySelectorAll(`[data-slot="${subSlot}"]`)) {
    const sub = Alpine.$data(element) as MenuSubComponent | undefined;

    if (sub?.isSubOpen && sub.handleKeydown?.(event)) {
      return true;
    }
  }

  return false;
}

function delegateToOpenMenuRoots(
  Alpine: AlpineInstance,
  event: KeyboardEvent,
  rootSlot: string,
  isOpen: (menu: MenuRootComponent) => boolean,
): boolean {
  for (const element of document.querySelectorAll(`[data-slot="${rootSlot}"]`)) {
    const menu = Alpine.$data(element) as MenuRootComponent | undefined;

    if (menu && isOpen(menu) && menu.handleKeydown) {
      menu.handleKeydown(event);

      return true;
    }
  }

  return false;
}

function isMenubarOpen(menu: MenuRootComponent): boolean {
  return Object.values(menu.menusOpen ?? {}).some(Boolean);
}

/** Register without wiping trigger, container, items, or open state. */
export function registerMenuInstance(
  store: MenuStore,
  id: string,
  options: MenuInstanceOptions = {},
): void {
  const existing = store.instances[id];

  if (!existing) {
    store.register(id, options);

    return;
  }

  if (options.orientation !== undefined) {
    existing.orientation = options.orientation;
  }

  if (options.group !== undefined) {
    existing.group = options.group ?? null;
  }

  if (options.closeOnSelect !== undefined) {
    existing.closeOnSelect = options.closeOnSelect;
  }

  if (options.onOpen) {
    existing.onOpen = options.onOpen;
  }

  if (options.onClose) {
    existing.onClose = options.onClose;
  }

  if (options.onSelect) {
    existing.onSelect = options.onSelect;
  }
}

function dispatchMenuActive(store: MenuStore, menuId: string): void {
  document.dispatchEvent(
    new CustomEvent(MENU_ACTIVE_EVENT, {
      detail: { id: menuId, activeItemId: store.activeItem(menuId) },
    }),
  );
}

function focusActiveMenuItem(store: MenuStore, menuId: string): void {
  const instance = store.instances[menuId];
  const activeItemId = store.activeItem(menuId);

  if (!instance?.container || !activeItemId) {
    return;
  }

  const byId = instance.container.querySelector<HTMLElement>(
    `[data-menu-item-id="${activeItemId}"]`,
  );

  if (byId) {
    byId.focus({ preventScroll: true });

    return;
  }

  instance.container
    .querySelector<HTMLElement>('[role="menuitem"][tabindex="0"]')
    ?.focus({ preventScroll: true });
}

/** Broadcast open/close/active changes and keep keyboard focus in sync. */
export function patchMenuStoreUiEvents(store: MenuStore): void {
  if (storePatched) {
    return;
  }

  const originalOpen = store.open.bind(store);
  const originalClose = store.close.bind(store);
  const originalHandleKeydown = store.handleKeydown.bind(store);

  store.open = (id: string) => {
    if (store.isOpen(id)) {
      return;
    }

    const previouslyOpen = Object.keys(store.instances).filter(
      (menuId) => menuId !== id && store.isOpen(menuId),
    );

    originalOpen(id);

    for (const menuId of previouslyOpen) {
      if (!store.isOpen(menuId)) {
        document.dispatchEvent(new CustomEvent(MENU_CLOSE_EVENT, { detail: { id: menuId } }));
      }
    }

    document.dispatchEvent(new CustomEvent(MENU_OPEN_EVENT, { detail: { id } }));

    requestAnimationFrame(() => {
      dispatchMenuActive(store, id);
      focusActiveMenuItem(store, id);
    });
  };

  store.close = (id: string) => {
    if (!store.isOpen(id)) {
      return;
    }

    originalClose(id);
    document.dispatchEvent(new CustomEvent(MENU_CLOSE_EVENT, { detail: { id } }));
  };

  store.handleKeydown = (menuId: string, event: KeyboardEvent) => {
    originalHandleKeydown(menuId, event);

    if (!store.isOpen(menuId)) {
      return;
    }

    requestAnimationFrame(() => {
      dispatchMenuActive(store, menuId);
      focusActiveMenuItem(store, menuId);
    });
  };

  storePatched = true;
}

/** Keyboard handler for every menu on the page. */
export function registerMenuGlobalHandlers(Alpine: AlpineInstance): void {
  if (globalHandlersRegistered) {
    return;
  }

  document.addEventListener("keydown", (event) => {
    // Dropdown menus (and their subs) handle keyboard navigation via
    // x-on:keydown.window on the dropdown root (submenu-aware handleKeydown).

    if (delegateToOpenSubs(Alpine, event, "context-menu-sub")) {
      return;
    }

    if (delegateToOpenSubs(Alpine, event, "menubar-sub")) {
      return;
    }

    if (
      delegateToOpenMenuRoots(
        Alpine,
        event,
        "context-menu",
        (menu) => Boolean(menu.panelOpen),
      )
    ) {
      return;
    }

    if (
      delegateToOpenMenuRoots(Alpine, event, "menubar", (menu) =>
        isMenubarOpen(menu),
      )
    ) {
      return;
    }

    Alpine.store("menu").handleWindowKeydown(event);
  });

  globalHandlersRegistered = true;
}
