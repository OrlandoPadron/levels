<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Macrocycle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'tplan_associated',
    ];
    //Each macrocycle belongs to one Training plan 
    public function tplan()
    {
        return $this->belongsTo(TrainingPlan::class);
    }

    //Each macrocycle has one or more mesocycles  
    public function mesocycles()
    {
        return $this->hasMany(Mesocycle::class);
    }
}
