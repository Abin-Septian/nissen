<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TrainingRecordController extends Controller
{
    public function index()
    {
        return Inertia::render('TrainingRecord/Index', [
            'filters' => Request::all('search', 'trashed'),
            'employees' => Auth::user()->account->employees()
                ->with('department')
                ->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($employee) {
                    return [
                        'id' => $employee->id,
                        'name' => $employee->name,
                        'nik' => $employee->nik,
                        'date_entry' => $employee->date_entry,
                        'deleted_at' => $employee->deleted_at,
                        'department' => $employee->department ? $employee->department->only('name') : null,
                        'position' => $employee->position ? $employee->position->only('name') : null,
                        'section' => $employee->section ? $employee->section->only('name') : null,
                    ];
                }),
        ]);
    }

    public function show($id)
    {
        return Inertia::render('TrainingRecord/View');
    }
}
