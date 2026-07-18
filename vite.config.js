import { resolve } from "node:path";
import { fileURLToPath } from "node:url";
import tailwindcss from "@tailwindcss/vite";
import laravel from "laravel-vite-plugin";
import { bunny } from "laravel-vite-plugin/fonts";
import { defineConfig } from "vite";

const projectRoot = fileURLToPath(new URL(".", import.meta.url));

export default defineConfig({
    resolve: {
        alias: {
            "#livewire": resolve(projectRoot, "vendor/livewire/livewire/dist/livewire.esm.js"),
        },
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/bladcn/dialog-runtime.js",
                "resources/js/passkeys.js",
            ],
            refresh: true,
            fonts: [
                bunny("Instrument Sans", {
                    weights: [400, 500, 600],
                    subsets: ["latin"],
                    display: "swap",
                    preload: [
                        { weight: 400, style: "normal" },
                        { weight: 500, style: "normal" },
                        { weight: 600, style: "normal" },
                    ],
                }),
            ],
        }),
        tailwindcss(),
    ],
    optimizeDeps: {
        include: [
            "@ailuracode/alpine-media",
            "@ailuracode/alpine-theme",
            "@ailuracode/alpine-toast",
            "@ailuracode/alpine-sidebar",
            "@ailuracode/alpine-scroll",
            "@ailuracode/alpine-dialog",
            "@ailuracode/alpine-menu",
            "@alpinejs/anchor",
        ],
    },
    server: {
        cors: true,
        watch: {
            ignored: ["**/storage/framework/views/**", "**/vendor/**", "**/node_modules/**"],
        },
    },
});
