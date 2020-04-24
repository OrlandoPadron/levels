<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    //
    public function getUser()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserId()
    {
        return $this->belongsTo(User::class)->get('id');
    }
}
