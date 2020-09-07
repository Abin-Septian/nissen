<?php

namespace App;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }
}
