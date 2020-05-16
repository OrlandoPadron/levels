<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'athletes' => 'array',
        'files' => 'array',
    ];


    public function trainer()
    {
        return $this->hasOne(Trainer::class);
    }
}
