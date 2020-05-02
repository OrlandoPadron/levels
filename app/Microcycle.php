<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Microcycle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'mesocycle_associated',
    ];
    //Each macrocycle belongs to one mesocycle 
    public function mesocycle()
    {
        return $this->belongsTo(Mesocycle::class, 'mesocycle_associated');
    }

    //Each microcycle has one or more sessions  
    public function sessions()
    {
        return $this->hasMany(Session::class, 'microcycle_associated');
    }
}
