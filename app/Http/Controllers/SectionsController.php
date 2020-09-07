<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class SectionsController extends Controller
{
    public function index()
    {
        return Inertia::render('Sections/Index', [
            'filters' => Request::all('search', 'trashed'),
            'sections' => Auth::user()->account->sections()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'deleted_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Sections/Create');
    }

    public function store()
    {
        Auth::user()->account->sections()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('sections')->with('success', 'Section created.');
    }

    public function edit(Section $section)
    {
        return Inertia::render('Sections/Edit', [
            'section' => [
                'id' => $section->id,
                'name' => $section->name,
                'deleted_at' => $section->deleted_at,
            ],
        ]);
    }

    public function update(Section $section)
    {
        $section->update(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::back()->with('success', 'Section updated.');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return Redirect::route('sections')->with('success', 'Section Deleted.');
    }

    public function restore(Section $section)
    {
        $section->restore();

        return Redirect::back()->with('success', 'Section restored.');
    }
}
