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

    // public function getUserId()
    // {
    //     return $this->belongsTo(User::class)->get('id');
    // }

    public function trainingPlans()
    {
        return $this->hasMany(TrainingPlan::class, 'athlete_associated');
    }
}
