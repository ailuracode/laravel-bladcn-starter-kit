import type { AlpineInstance } from "./types/alpine";

interface LivewireRuntime {
    start(): void;
}

import { Alpine as LivewireAlpine, Livewire as LivewireRuntimeExport } from "#livewire";

const Alpine = LivewireAlpine as AlpineInstance;
const Livewire = LivewireRuntimeExport as LivewireRuntime;

export { Alpine, Livewire };
