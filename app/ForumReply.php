<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    public function thread()
    {
        return $this->belongsTo(ForumThread::class);
    }
}
