<?php

namespace App;

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

    public function TrainingReport()
    {
        return $this->belongsToMany(Employee::class, 'employee_training')
                    ->withPivot('result', 'participant');
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
