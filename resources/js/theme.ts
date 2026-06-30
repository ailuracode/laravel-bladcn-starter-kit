import type { ThemeChangePayload, ThemePluginOptions } from "@ailuracode/alpine-theme";

/**
 * Apply resolved theme to `<html>` (Tailwind class-based dark mode).
 *
 * @see https://github.com/ailuracode/alpinejs-toolkit/blob/master/docs/plugins/theme.md#tailwind-css
 */
function applyTheme({ resolved }: Pick<ThemeChangePayload, "resolved">): void {
  document.documentElement.classList.toggle("dark", resolved === "dark");
  document.documentElement.style.colorScheme = resolved;
}

export const themePluginOptions: ThemePluginOptions = {
  storageKey: "theme",
  onChange: applyTheme,
};
