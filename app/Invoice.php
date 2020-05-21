<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'athlete_id', 'date', 'subscription_title', 'active_month',
        'price', 'isPaid',
    ];


    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
