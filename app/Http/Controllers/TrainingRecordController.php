<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Training;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HTTPRequest;

class TrainingRecordController extends Controller
{
    public function index(HTTPRequest $request)
    {
        $employees = Employee::employeeTrainings($request);

        return Inertia::render('TrainingRecord/Index', [
            'employees' => $employees
        ]);
    }

    public function show(Employee $employee)
    {
        return Inertia::render('TrainingRecord/View',[
            'employee' => [
                'id' => $employee->id,
                'name' => $employee->name,
                'nik' => $employee->nik,
                'date_entry' => $employee->date_entry,
                'department' => $employee->department ? $employee->department->only('name') : null,
                'position' => $employee->position ? $employee->position->only('name') : null,
                'section' => $employee->section ? $employee->section->only('name') : null,
            ],
            'trainings' => Employee::find($employee->id)->TrainingRecord()
                ->where('employee_training.participant','=',1)
                ->get()
                ->transform(function ($trainings) {
                    return [
                        'title' => $trainings->title,
                        'result' => $trainings->pivot->result,
                        'score' => $trainings->pivot->score,
                    ];
                }),
        ]
    );
    }
}
