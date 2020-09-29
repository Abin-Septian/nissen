<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'date', 'type_id', 'location', 'method', 'trainer', 'content', 'note', 'department_id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Type()
    {
        return $this->belongsTo(TrainingType::class);
    }

    public static function methods(){
        $data = DB::table('methods')
                    ->get();
                    
        return $data;
    }

    public static function retrieveData(){
        $data = DB::table('employees')
                    ->leftJoin('departments', 'departments.id', '=', 'employees.department_id')
                    ->leftJoin('sections' , 'employees.section_id', '=', 'sections.id')
                    ->select('employees.*', 'departments.name as dname', 'sections.name as sname', DB::raw("false as checked, false as result, null as score, null as note"))
                    ->orderByRaw('employees.name ASC')
                    ->get();
                    
        return $data;
    }

    public static function retrieveEdit($idTraining)
    {
        $query = "SELECT
        `employees`.`id` AS `id`,
        `employees`.`name` AS `name`,
        `nik`,
        `departments`.`name` AS `dname`,
        `sections`.`name` AS `sname`,
        (SELECT
          `participant`
        FROM
          `employee_training`
        WHERE `employee_id` = `employees`.`id`
          AND `training_id` = $idTraining) AS `participant`,
        IF (
          (SELECT
            result
          FROM
            `employee_training`
          WHERE `employee_id` = `employees`.`id`
            AND `training_id` = $idTraining) = 1,
          'true',
          'false'
        ) AS result,
        (SELECT
          score
        FROM
          `employee_training`
        WHERE `employee_id` = `employees`.`id`
          AND `training_id` = $idTraining) AS `score`,
        (SELECT
          note
        FROM
          `employee_training`
        WHERE `employee_id` = `employees`.`id`
          AND `training_id` = $idTraining) AS `note`
      FROM
        employees
        LEFT JOIN `departments`
          ON `departments`.`id` = `employees`.`department_id`
        LEFT JOIN `sections`
          ON `sections`.`id` = `employees`.`section_id`
        WHERE `employees`.`deleted_at` IS NULL
      ORDER BY `participant` DESC, `name`";

        $data = DB::select($query);

        return $data;
    }

    public function TrainingReport()
    {
        return $this->belongsToMany(Employee::class, 'employee_training')
                    ->withPivot('result', 'score', 'note', 'participant');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
