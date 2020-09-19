<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    public function training()
    {
        return $this->hasMany(Training::class);
    }
}
