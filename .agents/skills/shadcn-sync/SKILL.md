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
- **Icons:** always from `mallardduck/blade-lucide-icons` — never inline SVG, Heroicons, or other libraries. In UI subcomponents use `<x-lucide-{kebab} />` directly; in dashboard examples `<x-ui.icon name="…" />` is allowed.
- **Scope:** only touched component dirs + `dashboard.blade.php`. No commits unless explicitly requested.
- **Self-contained components:** Alpine `x-data` factories and component-specific behavior live in the root `index.blade.php` via `@pushOnce('bladcn-scripts')` — never in `resources/js/`. Global JS may only register shared Alpine **plugins** (e.g. `@ailuracode/alpine-dialog` → `$store.dialog` in `resources/js/bladcn/bootstrap.js`).
- **Subagents:** run stages in order; parent agent owns intake, merge, and final summary. Stage 4 validation is mandatory and must run in a `generalPurpose` subagent before the parent summarizes.

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
   - UI subcomponents: `<x-lucide-{kebab} … />` (preferred — no dynamic icon wrapper)
   - Dashboard / examples: `<x-ui.icon name="{kebab}" class="size-4" aria-hidden="true" />` is allowed
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

## Stage 4 — Validate (subagent: `generalPurpose`, mandatory)

Launch **one** generalPurpose validation subagent **after** Stages 2 and 3 (or after Stage 2 when `dashboard: no`). The parent agent must **not** deliver the final summary until this stage returns.

**Prompt must include:**

```text
Full Repository Path: {abs path}
Component slug(s): {slug1}, {slug2}
Subcomponent scope: {all | list}
Dashboard: yes | no
Doc URL: https://ui.shadcn.com/docs/components/{slug}
Discover report: {paste Stage 1 report}
Edited paths: {list every file touched in Stages 2–3}

Tasks — run every check below and return a structured validation report only (no file edits unless a trivial fix is required to pass a blocking check; prefer reporting failures for the parent to route back to Stage 2/3).

1. **Icons**
   - List every `x-lucide-*` tag and every `x-ui.icon name="…"` in edited component files and dashboard sections.
   - Confirm each resolves to `vendor/mallardduck/blade-lucide-icons/resources/svg/{kebab}.svg` (run `composer install` if vendor is missing).
   - Grep edited paths — no inline `<svg`, Heroicons, or `@svg` for Lucide icons:
     `rg -n "<svg|heroicon|@svg" resources/views/components/ui/{slug}/ resources/views/dashboard.blade.php`

2. **Blade parity (spot-check)**
   - For each subcomponent in scope, compare `$presetClass`, `data-slot`, `role`, and `aria-*` attrs against the discover report / shadcn React source.
   - Flag missing subcomponents, extra props/attrs shadcn does not use, or class-string drift.

3. **Project conventions**
   - Root `index.blade.php` has `@blaze` + `@see https://ui.shadcn.com/docs/components/{slug}`.
   - Interactive roots use `@blaze(fold: false)`.
   - Alpine factories live in root `index.blade.php` via `@pushOnce('bladcn-scripts')`, not in `resources/js/`.
   - Subcomponents use `$presetClass`, `$presetAttributes`, `$attributes->merge()->class()`.

4. **Dashboard (when dashboard: yes)**
   - Every doc example section from the discover report exists as `<x-docs.section :label="__('…')">`.
   - Card wrapper matches the skill template (`x-ui.card` → header → `space-y-12` content).
   - RTL sections use `dir="rtl"` and verbatim Arabic/Hebrew where the docs do.
   - User-facing strings use `__()`.

5. **Lints**
   - Run `ReadLints` on all edited Blade paths and include results.

Return format:

```text
## Validation report — {slug}

| Check | Status | Notes |
|-------|--------|-------|
| Icons (SVG exists) | PASS/FAIL | … |
| Icons (no forbidden markup) | PASS/FAIL | … |
| Blade parity | PASS/FAIL | … |
| Project conventions | PASS/FAIL | … |
| Dashboard examples | PASS/SKIP/FAIL | … |
| Lints | PASS/FAIL | … |

Overall: PASS | FAIL
Blocking issues: {numbered list or "none"}
Icons verified: {each x-lucide-* / name → svg filename}
```

If **Overall: FAIL**, list which stage (2 or 3) should be re-run and why. Do not mark the sync complete.
```

Parent waits for the validation report. On **FAIL**, re-run the failing stage(s) and launch Stage 4 again. On **PASS**, summarize for the user.

## Parent agent checklist

Copy and track:

```text
- [ ] Stage 0: Intake — component(s) + subcomponent scope confirmed
- [ ] Stage 1: Discover report received
- [ ] Stage 2: Blade sync complete
- [ ] Stage 3: Dashboard updated (if requested)
- [ ] Stage 4: Validation subagent report — Overall PASS
- [ ] Summary delivered to user
```

## Subagent launch pattern

Run sequentially per component; parallelize discover across multiple slugs only.

```text
1. AskQuestion / confirm scope
2. Task explore → discover report
3. Task generalPurpose → Blade sync
4. Task generalPurpose → dashboard (if yes)
5. Task generalPurpose → validation (mandatory)
6. Parent: summary only after Stage 4 PASS (re-run 2/3 + 5 on FAIL)
```

Do **not** use `bugbot` or `security-review` unless the user asks.

## When user pastes React source directly

If the user includes shadcn React/`cva` code in the message, skip fetching for that file and use pasted code as source of truth for Stage 2. Still run Stage 1 lightly to list doc examples for dashboard.

## Icons — `mallardduck/blade-lucide-icons`

Package: `mallardduck/blade-lucide-icons` (Composer dependency). SVG source: `vendor/mallardduck/blade-lucide-icons/resources/svg/{name}.svg`.

| Context | Blade usage |
|---------|-------------|
| UI subcomponents | `<x-lucide-chevron-down class="size-4" aria-hidden="true" />` (preferred) |
| Dashboard examples | `<x-ui.icon name="circle-check" class="size-4" aria-hidden="true" />` |

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
