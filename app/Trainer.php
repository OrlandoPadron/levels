<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function getUserId()
    // {
    //     return $this->belongsTo(User::class)->get('id');
    // }
}
