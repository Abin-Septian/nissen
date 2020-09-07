<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PositionsController extends Controller
{
    public function index()
    {
        return Inertia::render('Positions/Index', [
            'filters' => Request::all('search', 'trashed'),
            'positions' => Auth::user()->account->positions()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'deleted_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Positions/Create');
    }

    public function store()
    {
        Auth::user()->account->positions()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('positions')->with('success', 'Position created.');
    }

    public function edit(Position $position)
    {
        return Inertia::render('Positions/Edit', [
            'position' => [
                'id' => $position->id,
                'name' => $position->name,
                'deleted_at' => $position->deleted_at,
            ],
        ]);
    }

    public function update(Position $position)
    {
        $position->update(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::back()->with('success', 'Position updated.');
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return Redirect::route('positions')->with('success', 'Position Deleted.');
    }

    public function restore(Position $position)
    {
        $position->restore();

        return Redirect::back()->with('success', 'Position restored.');
    }
}
