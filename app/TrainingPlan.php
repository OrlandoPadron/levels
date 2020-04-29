<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status', 'athlete_associated',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'active',
    ];

    //Relations between entities

    public function athleteAssociated()
    {
        return $this->belongsTo(Athlete::class);
    }

    public function macrocycle()
    {
        return $this->hasMany(Macrocycle::class);
    }
}
