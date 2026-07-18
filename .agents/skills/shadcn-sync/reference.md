# shadcn-sync reference

## Blade component paths

| shadcn slug | Directory | Root tag |
|-------------|-----------|----------|
| `alert` | `ui/alert/` | `<x-ui.alert>` |
| `accordion` | `ui/accordion/` | `<x-ui.accordion>` |
| `dialog` | `ui/dialog/` | `<x-ui.dialog>` |
| `button` | `ui/button/` | `<x-ui.button>` |

Subcomponents: kebab-case file → dot notation (`title.blade.php` → `<x-ui.alert.title>`).

## Icons — `mallardduck/blade-lucide-icons`

**Single source of truth** for all Lucide icons in shadcn-sync work. Installed via Composer; SVGs live at:

`vendor/mallardduck/blade-lucide-icons/resources/svg/{kebab-name}.svg`

### Usage

| Where | Pattern | Example |
|-------|---------|---------|
| Dashboard / doc examples | `<x-ui.icon name="…" />` | `<x-ui.icon name="info" class="size-4" aria-hidden="true" />` |
| UI subcomponents | `<x-lucide-{kebab} />` | `<x-lucide-chevron-down class="size-4" aria-hidden="true" />` |

Both resolve to the same package. Prefer `x-ui.icon` in dashboard examples for consistency; use `x-lucide-*` inside subcomponents when the file already follows that pattern (e.g. accordion trigger).

### React import → `name` prop

1. Strip the `Icon` suffix from the React import.
2. Convert PascalCase to kebab-case.
3. Confirm the `.svg` file exists in vendor — filenames follow Lucide's kebab convention, not always a literal PascalCase split.

| React import | `name=` | SVG file |
|--------------|---------|----------|
| `CheckCircle2Icon` | `circle-check` | `circle-check.svg` |
| `CheckCircleIcon` | `circle-check` | `circle-check.svg` |
| `InfoIcon` | `info` | `info.svg` |
| `AlertCircleIcon` | `circle-alert` | `circle-alert.svg` |
| `AlertTriangleIcon` | `triangle-alert` | `triangle-alert.svg` |
| `XIcon` | `x` | `x.svg` |
| `ChevronDownIcon` | `chevron-down` | `chevron-down.svg` |
| `ChevronUpIcon` | `chevron-up` | `chevron-up.svg` |
| `Loader2Icon` | `loader-2` | `loader-2.svg` |
| `CopyIcon` | `copy` | `copy.svg` |
| `ExternalLinkIcon` | `external-link` | `external-link.svg` |

When unsure, search vendor:

```bash
ls vendor/mallardduck/blade-lucide-icons/resources/svg/ | rg -i "circle-check"
```

### Do not use

- Inline `<svg …>` copied from React/shadcn source
- Heroicons, Tabler, Font Awesome, or any icon library other than `mallardduck/blade-lucide-icons`
- Invented `name` values without verifying the SVG exists

### Verify before merge

```bash
# One icon
test -f vendor/mallardduck/blade-lucide-icons/resources/svg/circle-check.svg

# No forbidden inline icons in synced paths
rg -n "<svg|heroicon" resources/views/components/ui/{slug}/ resources/views/dashboard.blade.php
```

## Common Lucide → `x-ui.icon`

| React import | `name=` |
|--------------|---------|
| `CheckCircle2Icon` | `circle-check` |
| `InfoIcon` | `info` |
| `AlertCircleIcon` | `circle-alert` |
| `AlertTriangleIcon` | `triangle-alert` |
| `XIcon` | `x` |
| `ChevronDownIcon` | `chevron-down` |

Verify under:

`vendor/mallardduck/blade-lucide-icons/resources/svg/{name}.svg`

## Tailwind parity notes

Copy class strings **verbatim** from shadcn, including:

- Named groups: `group/alert`
- Container queries / has: `has-data-[slot=alert-action]:pr-18`
- Arbitrary variants: `*:[svg:not([class*='size-'])]:size-4`
- Escape inner quotes in PHP single-quoted strings: `\'size-\'`

## Dashboard section template

```blade
<x-docs.section :label="__('Basic')">
    <x-ui.typography.muted class="text-sm">
        {{ __('Doc description if present.') }}
    </x-ui.typography.muted>

    <x-ui.alert class="max-w-md">
        {{-- example markup --}}
    </x-ui.alert>
</x-docs.section>
```

## Multi-example Demo wrapper

When docs show a grid of examples:

```blade
<div class="grid w-full max-w-md items-start gap-4">
    {{-- multiple alerts/cards --}}
</div>
```

## RTL wrapper

```blade
<div class="grid w-full max-w-md items-start gap-4" dir="rtl">
    {{-- Arabic or Hebrew content, no __() --}}
</div>
```

## Props to avoid adding

Only expose Blade `@props` that shadcn exposes as React props. Do not invent `data-variant` unless the React component sets it.

## Alpine / JS components

Interactive components must be **self-contained**: all `Alpine.data` / component behavior scripts belong in `resources/views/components/ui/{slug}/index.blade.php` inside `@pushOnce('bladcn-scripts')`.

| Allowed globally (`resources/js/bladcn/`) | Must live in component Blade |
|-------------------------------------------|--------------------------------|
| `scrollPlugin({ target, reserveScrollbarGap })` in `scroll-runtime.js` | `Alpine.data('bladcnAlertDialog', …)` |
| `dialogPlugin({ scroll: $store.scroll })` in `dialog-runtime.js` | `x-data`, `$store.dialog.register/open/close` wiring |
| Other shared toolkit plugins in `bootstrap.js` | Subcomponent Alpine attrs (`trigger`, `content`, …) |

**Patterns:**

- Root index: `@blaze(fold: false)`, `x-id="['{slug}']"`, link toolkit in `@see` comment.
- Register with `$store.dialog` (or accordion, menu, …) in the component's `init()` — pass instance options there (e.g. `closeOnOutsideClick: false` for alert-dialog).
- Subcomponents reference `id` from parent Alpine scope; use `$store.dialog.*` in triggers/actions/content — not bare `open()` (avoids `window.open`).

If shadcn docs include client behavior, read existing Blade in the same family before changing markup. Sync **classes and data attributes** first; behavior changes only when required for parity.
