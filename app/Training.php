<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'date', 'type', 'location', 'method', 'trainer', 'content', 'note'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function TrainingReport()
    {
        return $this->belongsToMany(Employee::class, 'employee_user')
                    ->withPivot('result', 'participant');
    }
    public function TrainingRecord()
    {
        return $this->belongsToMany(Training::class, 'employee_user')
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
