<?php

namespace App\Concerns;

trait DispatchesBladcnToast
{
    protected function bladcnToast(string $title, string $variant = 'success'): void
    {
        $this->dispatch('toast', title: $title, variant: $variant);
    }
}
