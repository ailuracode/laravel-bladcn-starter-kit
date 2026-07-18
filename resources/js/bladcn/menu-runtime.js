import menuPlugin, { menuOptions } from "@ailuracode/alpine-menu";
import { createScrollLockHandler } from "./scroll-runtime";

const MENU_SLOT_ROOTS = ["dropdown-menu"];
const MENU_ROOT_SELECTOR = MENU_SLOT_ROOTS.map((slot) => `[data-slot="${slot}"]`).join(", ");
const MENU_OPEN_EVENT = "bladcn:menu-open";
const MENU_CLOSE_EVENT = "bladcn:menu-close";
const MENU_ACTIVE_EVENT = "bladcn:menu-active";

let menuInitialized = false;
let menuGlobalHandlersRegistered = false;
let menuStorePatched = false;
let menuNavigateSyncRegistered = false;
let menuUiRaf = null;
let pendingMenuUi = null;

export const pageUsesMenus = (root = document) => root.querySelector(MENU_ROOT_SELECTOR) !== null;

const registerMenuInstance = (store, id, options = {}) => {
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
};

const isMenubarOpen = (menu) => Object.values(menu.menusOpen ?? {}).some(Boolean);

const dispatchMenuActive = (store, menuId) => {
    document.dispatchEvent(
        new CustomEvent(MENU_ACTIVE_EVENT, {
            detail: { id: menuId, activeItemId: store.activeItem(menuId) },
        }),
    );
};

const focusActiveMenuItem = (store, menuId) => {
    const instance = store.instances[menuId];
    const activeItemId = store.activeItem(menuId);

    if (!instance?.container || !activeItemId) {
        return;
    }

    const byId = instance.container.querySelector(`[data-menu-item-id="${activeItemId}"]`);

    if (byId) {
        byId.focus({ preventScroll: true });

        return;
    }

    instance.container
        .querySelector('[role="menuitem"][tabindex="0"]')
        ?.focus({ preventScroll: true });
};

const scheduleMenuUiUpdate = (store, menuId) => {
    pendingMenuUi = { store, menuId };

    if (menuUiRaf !== null) {
        return;
    }

    menuUiRaf = requestAnimationFrame(() => {
        menuUiRaf = null;
        const pending = pendingMenuUi;
        pendingMenuUi = null;

        if (!pending) {
            return;
        }

        dispatchMenuActive(pending.store, pending.menuId);
        focusActiveMenuItem(pending.store, pending.menuId);
    });
};

const isAnyMenuPanelOpen = (Alpine) => {
    for (const element of document.querySelectorAll(MENU_ROOT_SELECTOR)) {
        const menu = Alpine.$data(element);

        if (!menu) {
            continue;
        }

        const slot = element.getAttribute("data-slot");

        if (slot === "menubar" ? isMenubarOpen(menu) : menu.panelOpen) {
            return true;
        }
    }

    return false;
};

const patchMenuStoreUiEvents = (store) => {
    if (menuStorePatched) {
        return;
    }

    const originalOpen = store.open.bind(store);
    const originalClose = store.close.bind(store);
    const originalHandleKeydown = store.handleKeydown.bind(store);

    store.open = (id) => {
        if (store.isOpen(id)) {
            return;
        }

        const previouslyOpen = Object.keys(store.instances).filter(
            (menuId) => menuId !== id && store.isOpen(menuId),
        );

        originalOpen(id);

        for (const menuId of previouslyOpen) {
            if (!store.isOpen(menuId)) {
                document.dispatchEvent(
                    new CustomEvent(MENU_CLOSE_EVENT, { detail: { id: menuId } }),
                );
            }
        }

        document.dispatchEvent(new CustomEvent(MENU_OPEN_EVENT, { detail: { id } }));

        scheduleMenuUiUpdate(store, id);
    };

    store.close = (id) => {
        if (!store.isOpen(id)) {
            return;
        }

        originalClose(id);
        document.dispatchEvent(new CustomEvent(MENU_CLOSE_EVENT, { detail: { id } }));
    };

    store.handleKeydown = (menuId, event) => {
        originalHandleKeydown(menuId, event);

        if (!store.isOpen(menuId)) {
            return;
        }

        scheduleMenuUiUpdate(store, menuId);
    };

    menuStorePatched = true;
};

const registerMenuGlobalHandlers = (Alpine) => {
    if (menuGlobalHandlersRegistered) {
        return;
    }

    document.addEventListener("keydown", (event) => {
        if (isAnyMenuPanelOpen(Alpine)) {
            return;
        }

        Alpine.store("menu").handleWindowKeydown(event);
    });

    menuGlobalHandlersRegistered = true;
};

export const registerBladcnMenu = (Alpine, scroll) => {
    if (!menuInitialized) {
        menuPlugin(
            menuOptions({
                onLockChange: createScrollLockHandler(scroll),
            }),
        )(Alpine);
        menuInitialized = true;
    }

    window.bladcnRegisterMenu = (id, options = {}) => {
        registerMenuInstance(Alpine.store("menu"), id, options);
    };

    patchMenuStoreUiEvents(Alpine.store("menu"));
    registerMenuGlobalHandlers(Alpine);
};

export const registerMenuNavigateSync = (Alpine, scroll) => {
    if (menuNavigateSyncRegistered) {
        return;
    }

    document.addEventListener("livewire:navigating", (event) => {
        event.detail.onSwap?.(() => {
            if (pageUsesMenus()) {
                registerBladcnMenu(Alpine, scroll);
            }
        });
    });

    menuNavigateSyncRegistered = true;
};
