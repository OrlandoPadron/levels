<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'trained_by_me' => 'array',
    ];


    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    // public function getUserId()
    // {
    //     return $this->belongsTo(User::class)->get('id');
    // }
}
