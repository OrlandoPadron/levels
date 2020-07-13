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
        'title', 'description', 'status', 'athlete_associated', 'files_associated',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'active',
        'files_associated' => '[]',
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'files_associated' => 'array',
    ];


    //Relations between entities

    public function athleteAssociated()
    {
        return $this->belongsTo(Athlete::class, 'athlete_associated');
    }

    public function macrocycles()
    {
        return $this->hasMany(Macrocycle::class, 'tplan_associated');
    }
}
