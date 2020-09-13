<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class EmployeesController extends Controller
{
    public function index()
    {
        return Inertia::render('Employees/Index', [
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

    public function create()
    {
        return Inertia::render('Employees/Create', [
            'departments' => Auth::user()->account
                ->departments()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'sections' => Auth::user()->account
                ->sections()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'positions' => Auth::user()->account
                ->positions()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->employees()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'nik' => ['required', 'int'],
                'department_id' => ['required', Rule::exists('departments', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'position_id' => ['required', Rule::exists('positions', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'section_id' => ['required', Rule::exists('sections', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'date_entry' => ['date', 'max:100'],
            ])
        );

        return Redirect::route('employees')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/Edit', [
            'employee' => [
                'id' => $employee->id,
                'name' => $employee->name,
                'nik' => $employee->nik,
                'department_id' => $employee->department_id,
                'position_id' => $employee->position_id,
                'section_id' => $employee->section_id,
                'date_entry' => $employee->date_entry,
                'deleted_at' => $employee->deleted_at,
            ],
            'departments' => Auth::user()->account
                ->departments()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'sections' => Auth::user()->account
                ->sections()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
            'positions' => Auth::user()->account
                ->positions()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Employee $employee)
    {
        $employee->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'nik' => ['required', 'int'],
                'department_id' => ['required', Rule::exists('departments', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'position_id' => ['required', Rule::exists('positions', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'section_id' => ['required', Rule::exists('sections', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'date_entry' => ['date', 'max:100'],
            ])
        );

        return Redirect::route('employees')->with('success', 'Karyawan berhasil di updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return Redirect::route('employees')->with('warning', 'Employee deleted.');
    }

    public function restore(Employee $employee)
    {
        $employee->restore();

        return Redirect::back()->with('success', 'Employee restored.');
    }
}
