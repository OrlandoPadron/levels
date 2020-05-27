<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutorship extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'date', 'goal', 'description', 'athlete_associated', 'tutorship_number', 'bookmarked',
    ];

    //Each instance of tutorship belongs to one athlete 
    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'athlete_associated');
    }
}
