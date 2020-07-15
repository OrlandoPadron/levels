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

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'trained_by_me' => '[]',
    ];


    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'created_by');
    }

    // public function getUserId()
    // {
    //     return $this->belongsTo(User::class)->get('id');
    // }
}
