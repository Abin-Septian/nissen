<?php

namespace App\Http\Controllers;

use App\Training;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class TrainingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Trainings/Index', [
            'filters' => Request::all('search', 'trashed'),
            'trainings' => Auth::user()->account->trainings()
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'title', 'date', 'trainer', 'deleted_at'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Trainings/Create',[
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
            'participans' => Auth::user()->account->employees()
            ->with('department')
            ->orderByName()
            ->filter(Request::only('search', 'trashed'))
            ->paginate()
            ->transform(function ($employee) {
                return [
                    'id' => $employee->id,
                    'checked' => false,
                    'result'  => null, 
                ];
            }),
        ]);
    }

    public function store()
    {
        $participans = Request::only(['participans']);

        DB::beginTransaction();

        try{

            Auth::user()->account->trainings()->create(
                Request::validate([
                    'title'     => ['required', 'string'],
                    'date'      => ['required', 'date'],
                    'type'      => ['required', 'string'],
                    'location'  => ['required', 'string'],
                    'trainer'   => ['required', 'string'],
                    'content'   => ['required', 'string'],
                    'method'    => ['required', 'string'],
                    'note'      => ['required', 'string'],
                ])
            );

            $trainingId = DB::table('trainings')->orderBy('id', 'desc')->pluck('id')->first();

            foreach($participans['participans'] as $key => $value){
                
                $checked    = $value['checked'];
                $result     = $value['result'];
                $employeeId = $value['id'];

                $id = DB::table('employee_user')->insertGetId(
                    array('employee_id' => $employeeId, 
                          'training_id' => $trainingId,
                          'result'      => $result,
                          'participant' => $checked,
                          "created_at"  => Carbon::now(), # new \Datetime()
                          "updated_at"  => Carbon::now())  # new \Datetime())
                );
            }

            DB::commit();

            return Redirect::route('trainings_list')->with('success', 'Training created.');
        }catch (Exception $e){
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
