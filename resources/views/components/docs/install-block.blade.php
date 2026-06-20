@props(['command'])

<div
    class="overflow-hidden rounded-xl border bg-zinc-950 text-zinc-50"
    x-data="{ copied: false, async copy() {
        await navigator.clipboard.writeText(@js($command));
        this.copied = true;
        setTimeout(() => this.copied = false, 2000);
    }}"
>
    <div class="flex items-center justify-between border-b border-zinc-800 px-4 py-2 text-xs text-zinc-400">
        <span>{{ __('Terminal') }}</span>
        <button type="button" class="inline-flex items-center gap-1 hover:text-zinc-200" x-on:click="copy()">
            <x-ui.icon name="copy" class="size-3.5" x-show="!copied" />
            <x-ui.icon name="check" class="size-3.5 text-green-400" x-show="copied" x-cloak />
            <span x-text="copied ? @js(__('Copied')) : @js(__('Copy'))"></span>
        </button>
    </div>
    <pre class="overflow-x-auto p-4 text-sm"><code>{{ $command }}</code></pre>
</div>
