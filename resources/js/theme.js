const STORAGE_KEY = 'theme';

function systemPrefersDark() {
  return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function isDark(appearance) {
  if (appearance === 'dark') {
    return true;
  }

  if (appearance === 'light') {
    return false;
  }

  return systemPrefersDark();
}

function applyTheme(appearance) {
  const dark = isDark(appearance);

  document.documentElement.classList.toggle('dark', dark);
  document.documentElement.style.colorScheme = dark ? 'dark' : 'light';
}

function readStoredAppearance() {
  return localStorage.getItem(STORAGE_KEY) || 'dark';
}

function syncThemeFromStorage() {
  const appearance = readStoredAppearance();

  applyTheme(appearance);

  if (typeof window.Alpine !== 'undefined') {
    const store = window.Alpine.store('bladcnTheme');

    if (store) {
      store.appearance = appearance;
    }
  }
}

const initial = readStoredAppearance();

applyTheme(initial);

document.addEventListener('livewire:navigating', (event) => {
  event.detail.onSwap?.(() => {
    syncThemeFromStorage();
  });
});

document.addEventListener('livewire:navigated', () => {
  syncThemeFromStorage();
});

bladcnOnAlpine((Alpine) => {
  Alpine.store('bladcnTheme', {
    appearance: initial,

    get isDark() {
      return isDark(this.appearance);
    },

    set(value) {
      this.appearance = value;
      localStorage.setItem(STORAGE_KEY, value);
      applyTheme(value);
    },

    init() {
      applyTheme(this.appearance);

      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (this.appearance === 'system') {
          applyTheme('system');
        }
      });
    },
  });
});
