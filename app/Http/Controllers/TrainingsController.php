<?php

namespace App\Http\Controllers;

use App\Training;
use Carbon\Carbon;
use Inertia\Inertia;
use App\TrainingType;
use Illuminate\Validation\Rule;
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
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->only('id', 'name', 'date', 'trainer', 'deleted_at'),
        ]);
    }

    public function create()
    {
        $employees = Training::retrieveData();
        $methods = Training::methods();
                        
        return Inertia::render('Trainings/Create',[
            'employees' => $employees,
            'types' => TrainingType::all(),
            'methods' => $methods,
        ]);
    }

    public function store()
    {
        $participans = Request::only(['emp']);

        DB::beginTransaction();

        try{

            Auth::user()->account->trainings()->create(
                Request::validate([
                    'name'         => ['required', 'string'],
                    'date'          => ['required', 'date'],
                    'type_id'       => ['required', 'integer'],
                    'location'      => ['required', 'string'],
                    'trainer'       => ['required', 'string'],
                    'method'        => ['required', 'string'],
                    'content'       => ['required', 'string'],
                    'department_id' => ['required', 'integer'],
                ])
            );

            $trainingId = DB::table('trainings')->orderBy('id', 'desc')->pluck('id')->first();

            foreach($participans['emp'] as $key => $value){
                
                $checked    = $value['checked'];
                $result     = $value['result'];
                $score      = $value['score'];
                $note       = $value['note'];
                $employeeId = $value['id'];

                if($checked == 'true'){
                    $id = DB::table('employee_training')->insertGetId(
                    array("employee_id" => $employeeId, 
                          "training_id" => $trainingId,
                          "result" => $result,
                          "score" => $score,
                          "note" => $note,
                          "participant" => $checked,
                          "created_at"  => Carbon::now(), # new \Datetime()
                          "updated_at"  => Carbon::now())  # new \Datetime())
                    );
                }
                
            }

            DB::commit();

            return Redirect::route('training_list')->with('success', 'Data Training berhasil di simpan.');
        }catch (Exception $e){
            DB::rollback();
        }
    }

    public function edit(Training $training)
    {
        $employees = Training::retrieveEdit($training->id);
        $methods = Training::methods();
                        
        return Inertia::render('Trainings/Edit',[
            'training' => [
                'id'        => $training->id,
                'name'     => $training->name,
                'date'      => $training->date,
                'type'      => $training->type->only('id'),
                'location'  => $training->location,
                'trainer'   => $training->trainer,
                'content'   => $training->content,
                'method'    => $training->method,
                'department_id' => $training->department_id,
            ],
            'employees' => $employees,
            'methods' => $methods,
            'types' => TrainingType::all(),
        ]);
    }
    
    public function update(Training $training)
    {
        $employees = Request::only(['employee']);

        DB::beginTransaction();

        try{

            $training->update(
                Request::validate([
                    'name'         => ['required', 'string'],
                    'date'          => ['required', 'date'],
                    'type_id'       => ['required', 'integer'],
                    'location'      => ['required', 'string'],
                    'trainer'       => ['required', 'string'],
                    'method'        => ['required', 'string'],
                    'content'       => ['required', 'string'],
                    'department_id' => ['required', 'integer'],
                ])
            );

            DB::table('employee_training')->where('training_id', '=', $training->id)->delete();

            foreach($employees['employee'] as $key => $value){
                
                $checked    = $value['participant'];
                $result     = $value['result'] == 'true' ? 1 : 0;
                $score      = $value['score'];
                $note       = $value['note'];
                $employeeId = $value['id'];

                if($checked == 1){
                    $id = DB::table('employee_training')->insertGetId(
                    array("employee_id" => $employeeId, 
                          "training_id" => $training->id,
                          "result" => $result,
                          "score" => $score,
                          "note" => $note,
                          "participant" => $checked,
                          "created_at"  => Carbon::now(), # new \Datetime()
                          "updated_at"  => Carbon::now())  # new \Datetime())
                    );
                }
            
            }

            DB::commit();

            return Redirect::route('training_list')->with('success', 'Data Training berhasil di edit.');
        }catch (Exception $e){
            DB::rollback();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        $training->delete();

        return Redirect::route('training_list')->with('success', 'Hapus Data Training Berhasil.');
    }
}
