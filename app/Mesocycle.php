<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesocycle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'macrocycle_associated',
    ];
    //Each mesocycle belongs to one macrocycle 
    public function macrocycle()
    {
        return $this->belongsTo(Macrocycle::class, 'macrocycle_associated');
    }

    //Each mesocycle has one or more microcycle  
    public function microcycles()
    {
        return $this->hasMany(Microcycle::class, 'mesocycle_associated');
    }
}
