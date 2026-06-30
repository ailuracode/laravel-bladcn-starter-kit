declare module "#livewire" {
    export const Alpine: import("./alpine").AlpineInstance;

    export const Livewire: {
        start(): void;
    };
}
