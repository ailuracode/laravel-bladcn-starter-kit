<?php

use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->prefix('docs')
    ->name('docs.')
    ->group(function () {
        Route::get('/', [DocsController::class, 'index'])->name('index');
        Route::get('/installation', [DocsController::class, 'installation'])->name('installation');
        Route::get('/components', [DocsController::class, 'components'])->name('components.index');
        Route::get('/components/{slug}', [DocsController::class, 'show'])->name('components.show');
    });
