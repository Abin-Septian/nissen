<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Training;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request as HTTPRequest;

class TrainingListController extends Controller
{
    public function index(HTTPRequest $request)
    {
        if($request->admin == 'true'){
            return Inertia::render('TrainingList/Index', [
                'filters' => Request::all('search', 'trashed'),
                'trainings' => Auth::user()->account->trainings()
                    ->orderBy('name')
                    ->filter(Request::only('search', 'trashed'))
                    ->paginate()
                    ->transform(function ($training) {
                        return [
                            'id' => $training->id,
                            'name' => $training->name,
                            'date' => $training->date,
                            'trainer' => $training->trainer,
                            'deleted_at' => $training->deleted_at,
                            'department' => $training->department ? $training->department->only('name') : null,
                            'type' => $training->type ? $training->type->only('type') : null,
                        ];
                    }),
            ]);
        }
        else{
            return Inertia::render('TrainingList/Index', [
                'filters' => Request::all('search', 'trashed'),
                'trainings' => Auth::user()->account->trainings()
                    ->where('department_id','=', $request->idDepartment)
                    ->orderBy('name')
                    ->filter(Request::only('search', 'trashed'))
                    ->paginate()
                    ->only('id', 'name', 'date', 'trainer', 'deleted_at'),
            ]);
        }
    }

    public function show(Training $training)
    {
        return Inertia::render('TrainingList/View',[
            'training' => [
                'id'        => $training->id,
                'name'     => $training->name,
                'date'      => $training->date,
                'type'      => $training->type->only('type'),
                'location'  => $training->location,
                'trainer'   => $training->trainer,
                'content'   => $training->content,
                'method'    => $training->method,
            ],
            'participants' => Training::find($training->id)->TrainingReport()
                ->where('employee_training.participant','=',1)
                ->get()
                ->transform(function ($participants) {
                    return [
                        'id' => $participants->id,
                        'nik' => $participants->nik,
                        'name' => $participants->name,
                        'department' => $participants->department->name,
                        'result' => $participants->pivot->result,
                        'score' => $participants->pivot->score,
                        'note' => $participants->pivot->note,
                    ];
                }),
        ]
    );
    }

    public function preview(Training $training)
    {
        return Inertia::render('TrainingList/View',[
            'training' => [
                'id'        => $training->id,
                'name'     => $training->name,
                'date'      => $training->date,
                'type'      => $training->type->only('type'),
                'location'  => $training->location,
                'trainer'   => $training->trainer,
                'content'   => $training->content,
                'method'    => $training->method,
            ],
            'participants' => Training::find($training->id)->TrainingReport()
                ->where('employee_training.participant','=',1)
                ->get()
                ->transform(function ($participants) {
                    return [
                        'id' => $participants->id,
                        'nik' => $participants->nik,
                        'name' => $participants->name,
                        'department' => $participants->department->name,
                        'result' => $participants->pivot->result,
                        'score' => $participants->pivot->score,
                        'note' => $participants->pivot->note,
                    ];
                }),
        ]
    );
    }

}