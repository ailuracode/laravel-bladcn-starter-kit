# laravel-bladcn-starter-kit

A Laravel starter kit built on [Livewire](https://livewire.laravel.com) with [bladcn](https://github.com/SiddharthaGF/bladcn-cli) UI components — shadcn-style Blade components for Laravel.

## Stack

- Laravel 13
- Livewire 4
- Tailwind CSS 4
- [bladcn](https://github.com/SiddharthaGF/bladcn-cli) component library (20 components)
- Laravel Fortify (auth, 2FA, passkeys)

## Getting started

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
composer dev
```

Visit `/docs` (after login) to browse component documentation.

## Documentation

- `/docs` — Introduction and guides
- `/docs/installation` — Setup instructions
- `/docs/components` — Component index
- `/docs/components/button` — Per-component pages with preview, installation, usage, and API reference

## Local development (bladcn)

This project is set up to use **local** bladcn dependencies:

| Repo | Path | Role |
|------|------|------|
| [bladcn-components](https://github.com/AiluraCode/bladcn-components) | `../bladcn-components` | Component registry (Blade, CSS, JS) |
| [bladcn-cli](https://github.com/AiluraCode/bladcn-cli) | `../bladcn-cli` | CLI (`ailuracode/bladcn`), linked via Composer path |

```bash
# .env (already in .env.example)
BLADCN_REGISTRY=../bladcn-components
```

`bladcn.json` points to the same relative registry. After changing files in `bladcn-components`:

```bash
# Sync all components from local registry
composer bladcn:sync

# Or update a single component
php artisan bladcn:add button --overwrite
```

If a component's `dependencies.json` lists new **npm** packages, install them manually and update `package.json`.

Re-link the local CLI after cloning:

```bash
composer update ailuracode/bladcn
```

## Adding components

```bash
php artisan bladcn:add button
php artisan bladcn:add dialog card
```

## Theme

Light, dark, and system themes are managed via Alpine store (`$store.bladcnTheme`) and persisted in `localStorage`. Change appearance under **Settings → Appearance**.

## License

MIT
