import type { AlpineInstance } from "./types/alpine";

interface LivewireRuntime {
    start(): void;
}

// @ts-expect-error Livewire ESM bundle ships without TypeScript declarations.
import { Alpine as LivewireAlpine, Livewire as LivewireRuntimeExport } from "../../vendor/livewire/livewire/dist/livewire.esm.js";

const Alpine = LivewireAlpine as AlpineInstance;
const Livewire = LivewireRuntimeExport as LivewireRuntime;

export { Alpine, Livewire };
