<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DepartmentsController extends Controller
{
    public function index()
    {
        return Inertia::render('Departments/Index', [
            'filters' => Request::all('search', 'trashed'),
            'departments' => Auth::user()->account->departments()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'deleted_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Departments/Create');
    }

    public function store()
    {
        Auth::user()->account->departments()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('departments')->with('success', 'Department created.');
    }

    public function edit(Department $department)
    {
        return Inertia::render('Departments/Edit', [
            'department' => [
                'id' => $department->id,
                'name' => $department->name,
                'deleted_at' => $department->deleted_at,
            ],
        ]);
    }

    public function update(Department $department)
    {
        $department->update(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::back()->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return Redirect::route('departments')->with('success', 'Department Deleted.');
    }

    public function restore(Department $department)
    {
        $department->restore();

        return Redirect::back()->with('success', 'Department restored.');
    }
}
