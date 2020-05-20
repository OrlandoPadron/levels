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


    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'athlete_id');
    }
}
