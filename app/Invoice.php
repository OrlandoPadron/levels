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
        'date', 'subscription_title', 'active_month',
        'price',
    ];


    public function athlete()
    {
        return $this->belongsTo(Athlete::class);
    }
}
