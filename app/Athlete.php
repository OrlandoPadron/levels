<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function getUserId()
    // {
    //     return $this->belongsTo(User::class)->get('id');
    // }
}
