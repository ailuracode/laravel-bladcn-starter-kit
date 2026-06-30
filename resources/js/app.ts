import { Alpine, Livewire } from "./livewire";
import { initAiluracodeAlpinePlugins } from "./alpine-toolkit";

import "./bladcn";

initAiluracodeAlpinePlugins(Alpine);

Livewire.start();
