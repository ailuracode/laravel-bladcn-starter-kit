---
name: shadcn-sync
description: >-
  Synchronize Laravel Blade UI components with official shadcn/ui docs (1:1 Tailwind,
  data-slot, variants) and refresh dashboard examples. Trigger: shadcn sync, sincronizar
  componente shadcn, actualizar bladcn, réplica shadcn, sync ui component, dashboard
  examples shadcn.
---

# shadcn Sync (Blade)

Synchronize `resources/views/components/ui/{component}/` with the official shadcn/ui React source and replace `resources/views/dashboard.blade.php` examples with every example from the official docs page.

## Hard rules

- **Always ask first** which component(s) and optional subcomponent(s) to sync before any subagent or edit.
- **Source of truth:** https://ui.shadcn.com/docs/components/{component}
- **1:1 parity:** Tailwind classes, `data-slot`, variants, roles, and composition must match shadcn — not legacy Blade markup.
- **Project conventions:** keep `@blaze`, `@props`, `$presetClass`, `$presetAttributes`, `$attributes->merge()->class()`.
- **Icons:** always from `mallardduck/blade-lucide-icons` — never inline SVG, Heroicons, or other libraries. Prefer `<x-ui.icon name="…" />`; in subcomponents, `<x-lucide-{kebab} />` is also valid (same package).
- **Scope:** only touched component dirs + `dashboard.blade.php`. No commits unless explicitly requested.
- **Self-contained components:** Alpine `x-data` factories and component-specific behavior live in the root `index.blade.php` via `@pushOnce('bladcn-scripts')` — never in `resources/js/`. Global JS may only register shared Alpine **plugins** (e.g. `@ailuracode/alpine-dialog` → `$store.dialog` in `resources/js/bladcn/bootstrap.js`).
- **Subagents:** run stages in order; parent agent owns intake, merge, and final summary.

## Stage 0 — Intake (parent agent, blocking)

Do not launch subagents until scope is confirmed.

Use `AskQuestion` when available; otherwise ask conversationally.

Collect:

1. **Component slug(s)** — shadcn doc slug (e.g. `alert`, `accordion`, `dialog`).
2. **Subcomponent scope** — one of:
   - `all` — entire component tree
   - explicit list — e.g. `title`, `description`, `action`
3. **Dashboard** — default `yes`: replace dashboard card with all official examples for the primary component.

Normalize input:

| User says | Resolved slug | Blade path |
|-----------|---------------|------------|
| Alert, alert | `alert` | `resources/views/components/ui/alert/` |
| Alert Title | `alert` + sub `title` | `.../alert/title.blade.php` |

If the user names multiple components, sync each sequentially (discover → blade → dashboard per component, or one dashboard section per component if they ask for multi).

**Intake template to confirm:**

```text
Sync scope:
- Components: {slug1}, {slug2}
- Subcomponents: all | {list}
- Dashboard: yes | no
- Doc URL: https://ui.shadcn.com/docs/components/{slug}
```

## Stage 1 — Discover (subagent: `explore`, thoroughness: `medium`)

Launch **one** explore subagent per component slug.

**Prompt must include:**

```text
Full Repository Path: {abs path}
Component slug: {slug}
Subcomponent scope: {all | list}
Doc URL: https://ui.shadcn.com/docs/components/{slug}

Tasks:
1. Fetch/read the official shadcn docs page for this component.
2. List every React export (Alert, AlertTitle, AlertAction, …) with its cva/base classes and data-slot values.
3. List existing Blade files under resources/views/components/ui/{slug}/.
4. Diff: missing subcomponents, outdated classes, extra props/attrs not in shadcn.
5. List every Lucide icon used in doc examples (React import name) and the expected `mallardduck/blade-lucide-icons` kebab `name` after conversion.
6. List every doc example section (Demo, Basic, Destructive, Action, RTL, …) with titles and key markup.

Return a structured report only — no file edits.
```

Parent waits for report before Stage 2.

## Stage 2 — Sync Blade (subagent: `generalPurpose`)

Launch **one** generalPurpose subagent per component (or one per subcomponent if scope is a narrow list).

**Prompt must include:** full discover report + paths + shadcn React snippets/classes from docs.

**Instructions for subagent:**

1. Update existing `.blade.php` files to 1:1 class strings from shadcn `cva` / component `className`.
2. Create missing subcomponents (e.g. `action.blade.php` for `AlertAction`).
3. Map React → Blade:
   - `data-slot="alert-title"` → `'data-slot' => 'alert-title'`
   - `variant` prop → `@props(['variant' => 'default'])` + `match ($variant)`
   - Remove attrs shadcn does not use (e.g. `data-variant` if absent in React).
4. Preserve file header: `@blaze(fold: true)` and `@see https://ui.shadcn.com/docs/components/{slug}` on index/root. Interactive roots (`dialog`, `alert-dialog`, `accordion`, …) use `@blaze(fold: false)`.
5. Do not edit dashboard in this stage.
6. **Alpine / JS:** register `Alpine.data('bladcn{Component}', …)` in the root `index.blade.php` with `@pushOnce('bladcn-scripts')`. Use `$store.{plugin}` from toolkit plugins initialized in `resources/js/bladcn/bootstrap.js` — do not move component factories to `resources/js/`.
7. **Icons in component files:** when shadcn React uses Lucide icons, render them via `mallardduck/blade-lucide-icons`:
   - Dashboard / examples: `<x-ui.icon name="{kebab}" class="size-4" aria-hidden="true" />`
   - Inside UI subcomponents (e.g. accordion trigger): `<x-lucide-{kebab} … />` is fine if the file already uses that pattern
   - Resolve React `FooBarIcon` → kebab `foo-bar`; verify SVG exists before using (see [reference.md](reference.md))

**Blade file pattern:**

```blade
@blaze(fold: true)
{{-- @see https://ui.shadcn.com/docs/components/{slug} --}}

@props([
    'id' => null,
    'style' => null,
    'class' => null,
    // variant props only when shadcn exposes them
])

@php
    $presetClass = '...'; // exact shadcn classes
    $presetAttributes = [
        'id' => $id,
        'data-slot' => '{slot-name}',
    ];
    if (filled($style)) {
        $presetAttributes['style'] = $style;
    }
@endphp

<div {{ $attributes->merge($presetAttributes)->class([$presetClass, $class]) }}>
    {{ $slot }}
</div>
```

## Stage 3 — Dashboard examples (subagent: `generalPurpose`)

Skip if intake said `dashboard: no`.

**Prompt must include:** discover report example sections + synced Blade component names.

**Instructions for subagent:**

1. Edit `resources/views/dashboard.blade.php`.
2. Remove prior demo content for the synced component(s).
3. Add **every** official doc example as its own `<x-docs.section :label="__('...')">`.
4. Wrap in:

```blade
<x-ui.card>
    <x-ui.card.header>
        <x-ui.card.title>{{ __('{Component}') }}</x-ui.card.title>
        <x-ui.card.description>
            {{ __('Examples from the official shadcn/ui {component} documentation.') }}
        </x-ui.card.description>
    </x-ui.card.header>
    <x-ui.card.content class="space-y-12">
        {{-- sections --}}
    </x-ui.card.content>
</x-ui.card>
```

5. JSX → Blade mapping:

| shadcn React | Blade |
|--------------|-------|
| `<Alert>` | `<x-ui.{slug}>` |
| `<AlertTitle>` | `<x-ui.{slug}.title>` |
| `<AlertDescription>` | `<x-ui.{slug}.description>` |
| `<AlertAction>` | `<x-ui.{slug}.action>` |
| `<Button size="xs">` | `<x-ui.button size="xs">` |
| Lucide `CheckCircle2Icon` | `<x-ui.icon name="circle-check" />` |
| Lucide `InfoIcon` | `<x-ui.icon name="info" />` |
| Lucide `AlertCircleIcon` | `<x-ui.icon name="circle-alert" />` |
| Lucide `AlertTriangleIcon` | `<x-ui.icon name="triangle-alert" />` |

   **Icons rule:** every Lucide icon in dashboard examples must use `<x-ui.icon name="…" />`, which resolves to `mallardduck/blade-lucide-icons` (`lucide-{kebab}`). Do not paste SVG markup or use other icon packages. Copy `className` from React onto the icon (e.g. `class="size-4"`). See [reference.md](reference.md) for React → kebab conversion and the full mapping table.

6. User-facing strings: `__()`. RTL sections: Arabic/Hebrew verbatim + `dir="rtl"` on wrapper.
7. Add muted description under section title when the doc includes explanatory copy.

## Stage 4 — Verify (subagent: `shell` or parent)

1. Confirm every icon used resolves to `mallardduck/blade-lucide-icons` — each `name` prop or `x-lucide-*` tag must match an SVG in vendor:

```bash
# Exact filename check (preferred)
test -f vendor/mallardduck/blade-lucide-icons/resources/svg/{kebab-name}.svg && echo ok

# Or search when unsure of the kebab name
ls vendor/mallardduck/blade-lucide-icons/resources/svg/ | rg -i "{icon-names}"
```

   If no SVG exists, pick the closest Lucide name from the package (e.g. `CheckCircle2Icon` → `circle-check.svg`, not `check-circle.svg`) or note the gap in the summary.

2. Grep edited files — no inline `<svg`, no Heroicons, no `@svg` directives for Lucide icons:

```bash
rg -n "<svg|heroicon|@svg" resources/views/components/ui/{slug}/ resources/views/dashboard.blade.php
```

3. `ReadLints` on edited Blade paths.
4. Parent summarizes: files changed, subcomponents created, dashboard sections added, icons verified (list each `name` / `x-lucide-*` and matching SVG).

## Parent agent checklist

Copy and track:

```text
- [ ] Stage 0: Intake — component(s) + subcomponent scope confirmed
- [ ] Stage 1: Discover report received
- [ ] Stage 2: Blade sync complete
- [ ] Stage 3: Dashboard updated (if requested)
- [ ] Stage 4: Icons + lints verified
- [ ] Summary delivered to user
```

## Subagent launch pattern

Run sequentially per component; parallelize discover across multiple slugs only.

```text
1. AskQuestion / confirm scope
2. Task explore → discover report
3. Task generalPurpose → Blade sync
4. Task generalPurpose → dashboard (if yes)
5. Task shell → icon verification
6. Parent: read lints + summary
```

Do **not** use `bugbot` or `security-review` unless the user asks.

## When user pastes React source directly

If the user includes shadcn React/`cva` code in the message, skip fetching for that file and use pasted code as source of truth for Stage 2. Still run Stage 1 lightly to list doc examples for dashboard.

## Icons — `mallardduck/blade-lucide-icons`

Package: `mallardduck/blade-lucide-icons` (Composer dependency). SVG source: `vendor/mallardduck/blade-lucide-icons/resources/svg/{name}.svg`.

| Context | Blade usage |
|---------|-------------|
| Dashboard examples | `<x-ui.icon name="circle-check" class="size-4" aria-hidden="true" />` |
| UI subcomponents | `<x-lucide-chevron-down … />` (direct Blade component from the same package) |

`x-ui.icon` (`resources/views/components/ui/icon/index.blade.php`) wraps the package:

```blade
{{-- name="circle-check" → <x-lucide-circle-check /> --}}
<x-ui.icon name="circle-check" class="size-4" />
```

**React → `name` conversion:** strip trailing `Icon`, convert PascalCase to kebab-case (`CheckCircle2Icon` → `circle-check-2` or `circle-check` — always verify the SVG filename). When shadcn uses a numbered variant (`2`, `Big`), check both `{base}-{n}.svg` and `{base}.svg` in vendor.

**Forbidden:** inline `<svg>`, Heroicons, Font Awesome, custom icon components not backed by this package.

Full mapping table and conversion examples: [reference.md](reference.md).

## Additional resources

- Lucide names, selectors, dashboard patterns: [reference.md](reference.md)
