<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','nik','department_id','position_id','section_id', 'date_entry'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function training_type()
    {
        return $this->belongsTo(TrainingType::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function Position()
    {
        return $this->belongsTo(Position::class);
    }

    public static function employeeTrainings($request){

        $condition = $request->admin == 'true' ? '' : "AND `employees`.`department_id` = $request->idDepartment" ;

        $query = "SELECT
                    `employees`.`id` as `id` ,
                    `employees`.`name` as `name`,
                    `nik`,
                    `departments`.`name` as `dname`,
                    `positions`.`name` as `pname`,
                    `sections`.`name` as `sname` 
                FROM
                    `employees`
                    LEFT JOIN `departments`
                    ON `departments`.`id` = `employees`.`department_id`
                    LEFT JOIN `sections`
                    ON `sections`.`id` = `employees`.`section_id`
                    LEFT JOIN `positions`
                    ON `positions`.`id` = `employees`.`position_id`
                WHERE `employees`.`id` IN
                    (SELECT
                    `employee_id`
                    FROM
                    `employee_training`) 
                    $condition";

        $data = DB::select($query);
        
        return $data;
    }

    public function TrainingRecord()
    {
        return $this->belongsToMany(Training::class, 'employee_training')
                    ->withPivot('result', 'score', 'note', 'participant');
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('name');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('nik', 'like', '%'.$search.'%')
                    ->orWhereHas('department', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    })
                    ->orWhereHas('position', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    })
                    ->orWhereHas('section', function ($query) use ($search) {
                        $query->where('name', 'like', '%'.$search.'%');
                    });
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
