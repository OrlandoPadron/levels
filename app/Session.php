<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'microcycle_associated',
    ];
    //Each session belongs to one microcycle
    public function microcycle()
    {
        return $this->belongsTo(Microcycle::class, 'microcycle_associated');
    }
}
