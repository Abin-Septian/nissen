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

class PreviewController extends Controller
{
    public function training_preview(Training $training)
    {
        return Inertia::render('TrainingList/Preview',[
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