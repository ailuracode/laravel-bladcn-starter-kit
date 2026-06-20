<?php

namespace App\Http\Controllers;

use App\Support\BladcnDocs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DocsController extends Controller
{
    public function index(): View
    {
        return view('docs.index', [
            'componentCount' => BladcnDocs::all()->count(),
        ]);
    }

    public function installation(): View
    {
        return view('docs.installation');
    }

    public function components(): View
    {
        return view('docs.components.index', [
            'groups' => BladcnDocs::groups(),
            'components' => BladcnDocs::all(),
        ]);
    }

    public function show(string $slug): View|RedirectResponse
    {
        $component = BladcnDocs::find($slug);

        if (! $component) {
            abort(404);
        }

        return view('docs.components.show', [
            'doc' => $component,
        ]);
    }
}
