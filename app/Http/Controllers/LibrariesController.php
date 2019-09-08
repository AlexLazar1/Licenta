<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Library;

class LibrariesController extends Controller
{
    public function index()
    {
        return Inertia::render('Libraries/Index', [
            'libraries' => Auth::user()->libraries()
                ->orderBy('name')
                ->get()
        ]);
    }

    public function books(Library $library)
    {
        return Inertia::render('Libraries/Books', [
            'library' => $library,
            'paginated_books' => $library->books()
                ->orderBy('title')
                ->paginate()
        ]);
    }

    public function create()
    {
        return Inertia::render('Libraries/Create');
    }

    public function store()
    {
        Auth::user()->libraries()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'description' => ['required']
            ])
        );

        return Redirect::route('libraries')->with('success', 'Library created.');
    }

    public function edit(Library $library)
    {
        return Inertia::render('Libraries/Edit', [
            'library' => $library
        ]);
    }

    public function update(Library $library)
    {
        $library->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'description' => ['required']
            ])
        );

        return Redirect::route('libraries', $library)->with('success', 'Library updated.');
    }

    public function destroy(Library $library)
    {
        $library->delete();

        return Redirect::route('libraries', $library)->with('success', 'Library deleted.');
    }

    public function restore(Library $library)
    {
        $library->restore();

        return Redirect::route('libraries', $library)->with('success', 'Library restored.');
    }
}
