<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id', 'action', 'entity_implied', 'isGroup', 'tab',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
