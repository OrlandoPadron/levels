<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'thread_id', 'description', 'author',
    ];

    public function thread()
    {
        return $this->belongsTo(ForumThread::class);
    }
}
