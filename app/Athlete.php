<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{

    //Relelations between entities 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainingPlans()
    {
        return $this->hasMany(TrainingPlan::class, 'athlete_associated');
    }


    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'athlete_id');
    }

    public function tutorships()
    {
        return $this->hasMany(Tutorship::class, 'athlete_associated');
    }
}
