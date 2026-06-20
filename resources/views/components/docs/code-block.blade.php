@props(['code', 'language' => 'blade', 'filename' => null])

<div
    class="group relative overflow-hidden rounded-xl border bg-zinc-950 text-zinc-50"
    x-data="{ copied: false, async copy() {
        await navigator.clipboard.writeText(@js($code));
        this.copied = true;
        setTimeout(() => this.copied = false, 2000);
    }}"
>
    @if ($filename)
        <div class="flex items-center justify-between border-b border-zinc-800 px-4 py-2 text-xs text-zinc-400">
            <span>{{ $filename }}</span>
            <button type="button" class="inline-flex items-center gap-1 hover:text-zinc-200" x-on:click="copy()">
                <x-ui.icon name="copy" class="size-3.5" x-show="!copied" />
                <x-ui.icon name="check" class="size-3.5 text-green-400" x-show="copied" x-cloak />
                <span x-text="copied ? @js(__('Copied')) : @js(__('Copy'))"></span>
            </button>
        </div>
    @endif
    <pre class="overflow-x-auto p-4 text-sm leading-relaxed"><code class="language-{{ $language }}">{{ $code }}</code></pre>
</div>
