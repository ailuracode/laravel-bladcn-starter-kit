<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class BladcnDocs
{
    public static function groups(): array
    {
        return config('docs.groups', []);
    }

    public static function all(): Collection
    {
        $indexed = collect();

        foreach (self::groups() as $group => $slugs) {
            foreach ($slugs as $slug) {
                $indexed->put($slug, self::make($slug, $group));
            }
        }

        return $indexed;
    }

    public static function find(string $slug): ?array
    {
        return self::all()->get($slug);
    }

    public static function slugs(): array
    {
        return self::all()->keys()->all();
    }

    public static function make(string $slug, ?string $group = null): array
    {
        $group ??= self::resolveGroup($slug);
        $path = self::componentPath($slug);

        return [
            'slug' => $slug,
            'title' => Str::headline(str_replace('-', ' ', $slug)),
            'group' => $group,
            'description' => config("docs.descriptions.{$slug}", 'A bladcn component for Laravel.'),
            'shadcn_url' => self::shadcnUrl($path),
            'props' => self::parseProps($path),
            'usage' => self::usageExample($slug),
            'install_command' => "php artisan bladcn:add {$slug}",
            'has_demo' => view()->exists("docs.demos.{$slug}"),
        ];
    }

    public static function resolveGroup(string $slug): string
    {
        foreach (self::groups() as $group => $slugs) {
            if (in_array($slug, $slugs, true)) {
                return $group;
            }
        }

        return 'Components';
    }

    public static function componentPath(string $slug): ?string
    {
        $base = resource_path("views/components/ui/{$slug}");

        if (is_file("{$base}/index.blade.php")) {
            return "{$base}/index.blade.php";
        }

        if (is_file("{$base}.blade.php")) {
            return "{$base}.blade.php";
        }

        return null;
    }

    public static function shadcnUrl(?string $path): ?string
    {
        if (! $path || ! is_file($path)) {
            return null;
        }

        $content = file_get_contents($path);

        if (preg_match('/@see\s+(https:\/\/ui\.shadcn\.com\/docs\/components\/[^\s]+)/', $content, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * @return array<int, array{name: string, type: string, default: string}>
     */
    public static function parseProps(?string $path): array
    {
        if (! $path || ! is_file($path)) {
            return [];
        }

        $content = file_get_contents($path);

        if (! preg_match('/@props\(\[(.*?)\]\)/s', $content, $matches)) {
            return [];
        }

        $props = [];
        $block = $matches[1];

        preg_match_all("/'([^']+)'\s*=>\s*([^,\]]+)/", $block, $pairs, PREG_SET_ORDER);

        foreach ($pairs as $pair) {
            $name = $pair[1];
            $default = trim($pair[2]);
            $default = trim($default, "'\"");

            $props[] = [
                'name' => $name,
                'type' => self::inferType($default),
                'default' => $default === '' ? '—' : $default,
            ];
        }

        return $props;
    }

    private static function inferType(string $default): string
    {
        return match (true) {
            $default === 'true', $default === 'false' => 'boolean',
            is_numeric($default) => 'number',
            $default === 'null' => 'null',
            default => 'string',
        };
    }

    public static function usageExample(string $slug): string
    {
        $tag = "x-ui.{$slug}";

        return match ($slug) {
            'typography' => '<x-ui.typography.h1>Heading</x-ui.typography.h1>',
            'icon' => '<x-ui.icon name="sparkles" />',
            'input-otp' => "<x-ui.input-otp name=\"code\" :maxlength=\"6\">\n    <x-ui.input-otp.group>\n        <x-ui.input-otp.slot :index=\"0\" />\n    </x-ui.input-otp.group>\n</x-ui.input-otp>",
            'sonner' => '<x-ui.sonner />',
            default => "<{$tag}>\n    Content\n</{$tag}>",
        };
    }
}
