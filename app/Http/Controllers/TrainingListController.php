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
                'trainings' => Auth::user()->account->trainings()
                    ->orderBy('title')
                    ->filter(Request::only('search', 'trashed'))
                    ->paginate()
                    ->only('id', 'title', 'date', 'trainer', 'deleted_at'),
            ]);
        }
        else{
            return Inertia::render('TrainingList/Index', [
                'trainings' => Auth::user()->account->trainings()
                    ->where('department_id','=', $request->idDepartment)
                    ->orderBy('title')
                    ->filter(Request::only('search', 'trashed'))
                    ->paginate()
                    ->only('id', 'title', 'date', 'trainer', 'deleted_at'),
            ]);
        }
    }

    public function show(Training $training)
    {
        return Inertia::render('TrainingList/View',[
            'training' => [
                'id'        => $training->id,
                'title'     => $training->title,
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
